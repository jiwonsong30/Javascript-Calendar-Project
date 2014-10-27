<?php
header("Content-Type: application/json");
ini_set("session.cookie_httponly", 1);
session_start();
$shared_username = $_POST['shared_by'];
 
$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
// 
$query = "SELECT event_ID, begin_time, end_time, date, event
		FROM events
		WHERE (username_event = ?)";
	  
$stmt = $mysqli->prepare($query);
if(!$stmt){
	printf("Something wrong: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $shared_username);
$stmt->execute();
$stmt->bind_result($id, $begin, $end, $date, $event);
$stmt->store_result();
$count = $stmt->num_rows;
if($count>=1){
	while($stmt->fetch()){
		$data[]=array(
			"success"=>"eventloaded",
			"id"=>htmlentities($id),
			"begin"=>htmlentities($begin),
			"end"=>htmlentities($end),
			"date"=>htmlentities($date),
			"event"=>htmlentities($event)
		);
	}
	echo json_encode(array(
		"success"=>true,
		"data"=>$data,
	));
	exit;
}elseif($count == null) {
    $data[]=array(
			"success"=>"eventloaded",
			"id"=>htmlentities($id),
			"begin"=>htmlentities($begin),
			"end"=>htmlentities($end),
			"date"=>htmlentities($date),
			"event"=>htmlentities($event)
		);
    echo json_encode(array(
	"success" => "true",
        "data"=>$data,
	));
	exit;
}else{
	echo json_encode(array(
	"success" => "error",
	"message" => "Incorrect Username or Password"
	));
	exit;
}
$stmt->close();
?>