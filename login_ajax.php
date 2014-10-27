<?php
header("Content-Type: application/json");  
$username = $_POST['username'];
$password = $_POST['password'];
 
$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

$query = "SELECT username, password, COUNT(*)
	  FROM users
	  WHERE (username = ?)";
	  
$stmt = $mysqli->prepare($query);

if(!$stmt){
	printf("Something wrong: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);


if($stmt->execute()){
	$stmt->bind_result($returnedName, $pwd_hash, $count);
	$stmt->fetch();
	if($count==1 && crypt($password, $pwd_hash)==$pwd_hash){
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['token'] = substr(md5(rand()), 0, 10);
	 
		echo json_encode(array(
			"success" => true
		));
		exit;
	}else{
		echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
		));
		exit;
	}
}

$stmt->close();

?>