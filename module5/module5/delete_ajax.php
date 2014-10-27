<?php
ini_set("session.cookie_httponly", 1);
session_start();
header("Content-Type: application/json");  
$event_id = $_POST['event_id'];
$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

$query = "DELETE FROM events
	  WHERE (event_ID = ? AND username_event = ?)";
          
$stmt = $mysqli->prepare($query);

if(!$stmt){
        printf("Something wrong: %s\n", $mysqli->error);
        exit;
}

$stmt->bind_param('is', $event_id, $username);

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
        "message" => "Cannot delete this event. Something Wrong."
	));
	exit;
}

?>