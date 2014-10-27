<?php
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json");  
$ddmmyy = $_POST['ddmmyy'];
$begin  = $_POST['begin'];
$end = $_POST['end'];
$event = $_POST['event'];
$category = $_POST['category'];
$username = $_SESSION['username'];
 
$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

$query = "INSERT INTO events (username_event, begin_time, end_time, date, event, category)
          VALUES (?,?,?,?,?,?)";
	  
$stmt = $mysqli->prepare($query);

if(!$stmt){
	printf("Something wrong: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssssss', $username, $begin, $end, $ddmmyy, $event, $category);


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
        "message" => "This time slot has been taken. Try another one."
	));
	exit;
}

?>