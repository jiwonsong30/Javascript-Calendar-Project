<?php
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json");  
$email = $_POST['shared_email'];
$added_username = $_POST['shared_user'];
$username = $_SESSION['username'];


$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
 
$stmt = $mysqli->prepare("INSERT INTO shared (username, email, shared_by)
			  VALUES (?, ?, ?)");

if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('sss', $added_username, $email, $username);

if($stmt->execute()){
        $stmt->close(); 
        echo json_encode(array(
                "success" => true
        ));
        exit;
}else{
        $stmt->close();
        echo json_encode(array(
	"success" => false,
        "message" => "You are already sharing your calendar with this user."
	));
	exit;
}

?>

