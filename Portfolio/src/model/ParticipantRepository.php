<?php
namespace model;

require_once ('./src/model/Participant.php');
require_once ('./src/model/ParticipantList.php');
require_once ('./src/model/Repository.php');

class ParticipantRepository extends base\Repository {
	private $participants;

	private static $key = 'uniqueKey';
	private static $name = 'name';
	private static $projectTable = 'projects';

	public function __construct() {
		$this -> dbTable = 'participants';
		$this -> participants = new ParticipantList();
	}

	public function add(Participant $participant) {
		try {
			$db = $this -> connection();

			$sql = "INSERT INTO $this->dbTable (" . self::$key . ", " . self::$name . ") VALUES (?, ?)";
			$params = array($participant -> getUnique(), $participant -> getName());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			foreach($participant->getProjects()->toArray() as $project) {
				$sql = "INSERT INTO ".self::$projectTable." (" . self::$key . ", " . self::$name . ", participantUnique) VALUES (?, ?, ?)";
				$query = $db->prepare($sql);
				$query->execute(array($project->getUnique(), $project->getName(), $participant->getUnique()));
			}
			
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}

	public function get($unique) {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " = ?";
			$params = array($unique);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();

			if ($result) {
				$user = new \model\Participant($result[self::$name], $result[self::$key]);
				$sql = "SELECT * FROM ".self::$projectTable. " WHERE participantUnique = ?";
				$query = $db->prepare($sql);
				$query->execute (array($result[self::$key]));
				$projects = $query->fetchAll();
				foreach($projects as $project) {
					$proj = new Project($project['projectName'], $project['uniqueKey']);
					$user->add($proj);
				}
				return $user;
			}

			return NULL;
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}

	public function find($unique) {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " LIKE '%:unique%'";
			$params = array($unique);

			$query = $db -> prepare($sql);
			$query -> execute(array(':unique' => $unique));

			$participantList = new \model\ParticipantList();

			foreach ($query->fetchAll() as $result) {
				$participantList -> add(new \model\Participant($result[self::$name], $result[self::$key]));
			}

			return $participantList;
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}

	public function delete(\model\Participant $participant) {
		try {
			$db = $this -> connection();

			$sql = "DELETE FROM $this->dbTable WHERE uniqueKey = ?";
			$params = array($participant -> getUnique());

			$query = $db -> prepare($sql);
			$query -> execute($params);

		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}

	public function query($sql, $params = NULL) {
		try {
			$db = $this -> connection();

			$query = $db -> prepare($sql);
			$result;
			if ($params != NULL) {
				if (!is_array($params)) {
					$params = array($params);
				}

				$result = $query -> execute($params);
			} else {
				$result = $query -> execute();
			}

			if ($result) {
				return $result -> fetchAll();
			}

			return NULL;
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}

	public function toList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $owner) {
				$name = $owner['name'];
				$unique = $owner['uniqueKey'];

				$parti = new Participant($name, $unique);

				$this -> participants -> add($parti);
			}

			return $this -> participants;
		} catch (\PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}

}
