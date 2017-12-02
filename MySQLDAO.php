

<?php

/*
 * MySQL Direct Access Object
 *
 * Holds Queries, SQL Commands, & other Methods for PHP Scripts  
 *
 * @author Jevon Cowell <JC06505n@pace.edu>
 * 
 */
 
class MySQLDao {

	var $dbhost = null;
	var $dbuser = null;
	var $dbpass = null;
	var $conn = null;
	var $dbname = null;
	var $result = null;

	/**
		* 
		* Constructs Database Login Credentials
		*
    */

	function __construct() {
		$this->dbhost = Conn::$dbhost;
		$this->dbuser = Conn::$dbuser;
		$this->dbpass = Conn::$dbpass;
		$this->dbname = Conn::$dbname;
	}

	/**
		* 
		* Opens Connection to mySQL Database
		*
	*/

	public function openConnection() {
		$this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		if (mysqli_connect_errno()) {
			//echo new Exception("Could not establish connection with database");
			$returnValue ["status"] = "error";
			$returnValue ["message"] = "Could not establish connection with database";
			echo json_encode ($returnValue);
		}
		$this->conn->set_charset("utf8");
	}

	/**
		* 
		* Returns Conn
		*
	*/
	
	public function getConnection() {
		return $this->conn;
	}


	/**
		* 
		* Closes Connection to mySQL Database
		*
	*/

	public function closeConnection() {
		if ($this->conn != null)
			$this->conn->close();
	}



	public function getExample($email)
	{
		$returnValue = array();
		$sql = "select * from users where user_example='" . $example . "'";
	
		$result = $this->conn->query($sql);
		if ($result != null && (mysqli_num_rows($result) >= 1)) {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if (!empty($row)) {
				$returnValue = $row;
			}
		}
		return $returnValue;
	}
	
	public function storeExample($user_id, $exmaple_ID)
	{
		$sql = "insert into user_attribute set userID=?, exampleID=?";
		$statement = $this->conn->prepare($sql);
	
		if (!$statement)
			throw new Exception($statement->error);
	
			$statement->bind_param("is", $user_id,$college_ID);
			$returnValue = $statement->execute();
	
			return $returnValue;
	}


	function setExample($example, $user_id)
	{
		$sql = "update users set isExample=? where userID=?";
		$statement = $this->conn->prepare($sql);
	
		if (!$statement)
			throw new Exception($statement->error);
	
			$statement->bind_param("ii", $status, $user_id);
			$returnValue = $statement->execute();
	
			return $returnValue;
	
	}
	
	function deleteExample($example)
	{
		$sql = "delete from user_attribute where user_example=?";
		$statement = $this->conn->prepare($sql);
	
		if (!$statement)
			throw new Exception($statement->error);
	
			$statement->bind_param("s", $emailToken);
			$returnValue = $statement->execute();
	
			return $returnValue;
	}

?>