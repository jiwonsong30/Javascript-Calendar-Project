<?php
header("Content-Type: application/json");
session_start();
$username = $_POST['shared_user'];
 
$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
 
$query = "SELECT event_ID, begin_time, end_time, date, event, category
		FROM events
		WHERE (username_event = ?)";
	  
$stmt = $mysqli->prepare($query);
if(!$stmt){
	printf("Something wrong: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($id, $begin, $end, $date, $event, $category);
$stmt->store_result();
$count = $stmt->num_rows;
if($count>=1){
	while($stmt->fetch()){
		$data[]=array(
			"success"=>"eventloaded",
			"id"=>$id,
			"begin"=>$begin,
			"end"=>$end,
			"date"=>$date,
			"event"=>$event,
			"tag"=>$category
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
			"id"=>$id,
			"begin"=>$begin,
			"end"=>$end,
			"date"=>$date,
			"event"=>$event,
			"tag"=>$category
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