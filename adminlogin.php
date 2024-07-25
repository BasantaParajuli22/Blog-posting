<?php
//suppose to be Admin login page for all management

session_start();
$conn = new mysqli('localhost',"root","",'basanta_db');
if($conn->connect_error){
    die("connection failed". $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $sql ="SELECT username, password FROM blog_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if($stmt === false){
        echo "prepare stmt failed " . htmlspecialchars($conn->error) ;
        exit();
    }
    $stmt->bind_param("s",$username);
    $stmt->execute();

    $stmt->bind_result($db_username,$db_password);
    if($stmt->fetch()){
    
    if ($password == $db_password) {
        $_SESSION["username"] = $username;
        $_SESSION["loggedin"] = true;
        header("Location: /blog_post/$username");
        exit();
    } else {
        echo "Invalid  password.";
    }
    }else{
        echo "Invalid  user.";
    }
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php if(!isset($_SESSION['username'])){ echo " <p style = 'color:red;'> Please login to create post</p>"; }?>
<form action="Home.php">

   <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
   <button type="submit">Create new Post</button>
</form>
</body>
</html>