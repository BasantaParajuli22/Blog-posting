<?php

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo 'Welcome, ' . $_SESSION['username'];
} else {
    echo 'You are not logged in.';
}

$conn = new mysqli('localhost',"root","",'basanta_db');
if($conn->connect_error){
    die("connection failed". $conn->connect_error);
}

$sql ="SELECT * FROM post_table where username = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$username);
$stmt->execute();

$stmt->bind_result($db_id,$db_content,$db_title,$db_username);
 $result = $stmt->get_result();

$fetched_data = array();
if($result->num_rows>0){
    $fetched_data = $result->fetch_all(MYSQLI_ASSOC);
}else{
    $fetchedData = array();
    echo"no blog found";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Posts</title>
</head>
<body>
    <h1>Blog Posts</h1>
     <form action="createblog.php">
        <!-- send username in url line 11 in home  -->
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <button type="submit">Create new Post</button>
     </form>
     <button type="submit" ><a href="display.php">Home Blog</a></button> 
    <hr>
    <!-- for blog post data -->
    <table border="1">
        <th>id</th>
        <th>author</th>
        <th>title</th>
        <th>content</th>
        <th>Options</th>
    
    <?php
        foreach ($fetched_data as $data) {
    ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['username']; ?></td>
            <td><?php echo $data['title']; ?></td>
            <td><?php echo $data['content']; ?></td>
            <!-- <td><button name ="username">edit </button></td> -->
        </tr>
        <?php
        }
        ?>
    </table>
<br>
<br>
    
    </body>
</html>