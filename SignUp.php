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


$email = htmlentities ( $_POST ["email"] );
$password = htmlentities ( $_POST ["password"] );
$email = htmlentities($_POST["email"]);

$returnValue = array();

// Ends script if Values are empty

if(empty($email) || empty($password))
{
	$returnValue["status"] = "error";
	$returnValue["message"] = "Missing required field";
	echo json_encode($returnValue);
	return;
}

// Make sure the address is valid

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$returnValue ["status"] = "error";
	$returnValue ["message"] = "Must have a valid Email Address";
	echo json_encode ($returnValue);
	return;
}

//	Creates a Direct Access Object and opens connection to Database.

$dao = new MySQLDao();
$dao->openConnection();

//	Sees if there exist a user with inputted email

$userDetails = $dao->getUserDetails ( $email );

if (! empty ( $userDetails )) {
	$returnValue ["status"] = "error";
	$returnValue ["message"] = "There is already a user with this email address";
	echo json_encode ($returnValue);
	return;
}

//	Secure Password so that no one cna see it

$secure_password = password_hash ( $password, PASSWORD_DEFAULT ); 

//	Register 

$result = $dao->registerUser ( $username, $secure_password, $email, $DOB, $gender );

if ($result) {
	$userDetails = $dao->getUserDetails($email);
	$returnValue["status"]="200";
	$returnValue["message"]="Successfully registered new user";
	$returnValue["userID"] = $userDetails["userID"];
	$returnValue["email"] = $userDetails["user_email"];
	
	}

else {
	$returnValue ["status"] = "400";
	$returnValue ["message"] = "Could not register user with provided information";
	}

echo json_encode($returnValue);
$dao->closeConnection ();


?>
