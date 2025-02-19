<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo"<h2> username not found</h2>"; 
    exit();
}

$conn = new mysqli('localhost',"root","",'basanta_db');
if($conn->connect_error){
    die("connection failed". $conn->connect_error);
}

if(isset($_SESSION['username']) ){
    $username  = $_SESSION['username'];
}


if($_SERVER['REQUEST_METHOD']=="POST"){
    $username = $_SESSION['username'];
    $content = $_POST['content'];
    $comment_to_id = $_POST['Blogid'];
    

    $stmt = $conn->prepare("INSERT INTO comment_table (username, content, comment_to) VALUES (?,?,?);");
    if ($stmt === false) {
        die("Prepare statement failed: " . $conn->connect_error);
    }
    $stmt->bind_param("sss", $username, $content, $comment_to_id);

    if($stmt->execute()){
        echo" comment successful";
        $_SESSION["username"] = $username;
        header('location:view_mode.php');
        exit();
    }else{
        die(" execution failed".$stmt->error);
    }
    $stmt->close();
}
$conn->close();


?>