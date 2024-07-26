
<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo"<h2> The page couldnot be found plz try again ERROR 1</h2>"; 
    exit();
}

$conn = new mysqli('localhost',"root","",'basanta_db');
if($conn->connect_error){
    die("connection failed". $conn->connect_error);
}
//to store blog_posts
if($_SERVER['REQUEST_METHOD']=="POST"){
    $id = $_POST['Blog_id'];
    $username = $_POST['username'];
    
    $session_username = $_SESSION['username'];
    echo $username . "<br>";
    echo $session_username;
    echo $commentor;

    if($username == $session_username){
        $sql  = $conn->prepare("DELETE FROM comment_table WHERE id = ? ");
        $sql ->bind_param("i", $id);
        
        if ($sql->execute()) {
            $_SESSION["delete_message"] = "Comment deleted successfully.";
        } else {
            $_SESSION['delete_message'] = "Error deleting the Comment.";
        }
        $sql->close();

    } else {
        $_SESSION['delete_message'] = "You cannot delete others' Comments.";
    }

    header('Location: view_mode.php');
    exit();
}
$conn->close();

?>