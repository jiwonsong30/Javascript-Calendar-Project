<?php
header("Content-Type: application/json");  
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$encrypted = crypt($password);


$mysqli = new mysqli('localhost', 'module5', 'amyjiwon', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

$query = "INSERT INTO users (username, password, email)
          VALUES (?,?,?)";
          
$stmt = $mysqli->prepare($query);
if(!$stmt){
        printf("Something wrong: %s\n", $mysqli->error);
        exit;
}else if(strcmp($username,"")==0||strcmp($password,"")==0){
        echo "Please enter valid username and password.";
}

$stmt->bind_param('sss', $username, $encrypted, $email);

if($stmt->execute()){
        $stmt->close();
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['token'] = substr(md5(rand()), 0, 10);
 
        echo json_encode(array(
                "success" => true
        ));
        exit;
}else{
        $stmt->close();
        echo json_encode(array(
	"success" => false,
        "message" => "This username has been taken. Try another one."
	));
	exit;
}

?>