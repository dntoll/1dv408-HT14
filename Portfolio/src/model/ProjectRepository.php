<?php
namespace model;

require_once ('./src/model/Repository.php');
require_once ('./src/model/ProjectList.php');

class ProjectRepository extends base\Repository {
	private $projects;
	
	private static $name = 'projectName';
	private static $key = 'uniqueKey';
	public static $owner = 'ownerParticipantFK';
	
	public function __construct() {
		$this -> dbTable = 'projects';
		$this -> projects = new ProjectList();
	}

	public function add(Project $project) {
		$db = $this -> connection();

		$sql = "INSERT INTO $this->dbTable (" . self::$key . ", " . self::$name . ", ".self::$owner.") VALUES (?, ?, ?)";
		$params = array($project -> getUnique(), $project -> getName(), $project->getOwner()->getUnique());

		$query = $db -> prepare($sql);
		$query -> execute($params);
	}

	public function get($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " = ?";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();

		if ($result) {
			return new \model\Participant($result[self::$name], $result[self::$key]);
		}
	}

	public function find($unique) {
		
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " LIKE '%:unique%'";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute(array(':unique' => $unique));

		$participantList = new \model\ParticipantList();

		foreach ($query->fetchAll() as $result) {
			$participantList -> add(new \model\Project($result[self::$name], $result[self::$key]));
		}

		return $participantList;
	}

	public function delete(Project $project) {
		$db = $this -> connection();

		$sql = "DELETE FROM $this->dbTable WHERE uniqueKey = ?";
		$params = array($project -> getUnique());

		$query = $db -> prepare($sql);
		$query -> execute($params);

	}

	public function query($sql, $params = NULL) {
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
		
	}

	public function toList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $project) {
				$name = $project['name'];
				$unique = $project['uniqueKey'];

				$proj = new Project($name, $unique);

				$this -> project -> add($proj);
			}

			return $this -> projects;
		} catch (\PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}

}
