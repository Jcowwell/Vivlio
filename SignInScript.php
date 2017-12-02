
<?php

/*
 * 
 * Verifies User Log In input
 *
 * @author Jevon Cowell <JC06505n@pace.edu>
 * 
 */

require("Conn.php");
require("MySQLDAO.php");

$email = htmlentities($_POST["email"]);
$password = htmlentities($_POST["password"]);


$returnValue = array();

// Ends script if Values are empty

if(empty($email) || empty($password))
{
	$returnValue["status"] = "error";
	$returnValue["message"] = "Missing required field";
	echo json_encode($returnValue);
	return;
}

// Hash's user's password input to match up against hash in DB

$secure_password = password_hash($password, PASSWORD_DEFAULT);

// Creates a Direct Access Object and opens connection to Database.
$dao = new MySQLDao();
$dao->openConnection();

//Stores user detials from database into a variable

$userDetails = $dao->getUserDetailsWithPassword($email,$password);

//	Sends data back to application if data was found. 

if(!empty($userDetails))
{
	$returnValue["status"] = "Success";
	$returnValue["message"] = "You are now Logged In";
	$returnValue["userID"] = $userDetails["userID"];
	echo json_encode($returnValue);
} else {

	$returnValue["status"] = "error";
	$returnValue["message"] = "Credentials are Incorrect";
	echo json_encode($returnValue);
}

//	Closes connection to database

$dao->closeConnection();

?>
