<?php

session_start();
//if the user didnot login then
if(!isset($_SESSION['username'])) {
    echo "
     <p style = 'color:red;'> Please Login to add comment</p> <button ><a href='login.php'>Login</a></button> <br><br> "; 
    echo "no username found";
    }
 
//i couldnot redirect the user to view_mode.php after adding comment so
// if(isset($_SESSION['username'])){
//     $username  = $_SESSION['username'];
// }
// if(isset($_SESSION['Blog_id'])){
//     $username  = $_SESSION['Blog_id'];
// }

//only show tables if view button is pressed in display.php
if($_SERVER['REQUEST_METHOD']=="POST"){
    if (isset($_POST['view'])) {
        $Blog_id = $_POST['view'];
        echo "Blog ID: " . $Blog_id . "<br> ";
        
    //for displaying blog post   
    $conn = new mysqli('localhost',"root","",'basanta_db');
    if($conn->connect_error){
    die("connection failed". $conn->connect_error);
    }

    $sql ="SELECT * FROM post_table where id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$Blog_id);
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

    // to display comments
    $sql2 ="SELECT * FROM comment_table where comment_to = ? ";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s",$Blog_id);//blog_id is same as comment_to id
    $stmt2->execute();

    $stmt->bind_result($comment_id,$comment_username,$comment_content,$comment_to);
    $result2 = $stmt2->get_result();

    $fetched_data2 = array();
    if($result->num_rows>0){
        $fetched_data2 = $result2->fetch_all(MYSQLI_ASSOC);
    }else{
        $fetchedData2 = array();
        echo"no blog found";
    }

    } 
    else{
        echo "no request found";
    }
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

<br><button type="submit" ><a href="display.php">Go to Blog</a></button>  
<br><h2>Blog::</h2>
<!-- for blogs  -->
<table border="1">
        <th>Blog id</th>
        <th>author</th>
        <th>title</th>
        <th>content</th>
        <th>Options</th>
    
    <?php
        foreach ($fetched_data as $data) {
    ?>
        <tr>
            <td><?php echo $data['id'];  ?></td>
            <td><?php echo $data['username']; ?></td>
            <td><?php echo $data['title']; ?></td>
            <td><?php echo $data['content']; ?></td>
            <!-- <td><button name ="username">edit </button></td> -->
        </tr>
        <?php
        }
        ?>
    </table><br><hr>
    <h3>Comment Section</h3>
    
    <form action="comment.php" method="post">
        <textarea name="content" cols="50" rows="5" >test </textarea>
        <!-- always use echo to send data  -->
        <input type="hidden" name ="Blogid" value="<?php echo htmlspecialchars($Blog_id); ?>">
        <button name="addcomment" value="<?php echo htmlspecialchars($Blog_id); ?> " >Add comment</button>
    </form>
    <hr>
<br>
<br>
<br>
<!-- for comments -->
<h3>Other Users Comments </h3>
 <table border="1">
        <th>Comment id</th>
        <th>Username</th>
        <th>content</th>
    <?php
            foreach ($fetched_data2 as $comment) {
        ?>
        <tr>
            <td><?php echo $comment['id']; ?></td>
            <td><?php echo $comment['username']; ?></td>
            <td><?php echo $comment['content']; ?></td>
            <form action="delete_comment.php" method="post">
                <input type="hidden" name="Blog_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($comment['username']); ?>">
            <td><button type="submit" name="delete_comment"  value="<?php echo htmlspecialchars($comment['username']); ?>">Delete</button></td>
            <?php  if(isset($_SESSION['delete_message'])) {
                    echo "<p style ='red';>" .  htmlspecialchars($_SESSION['delete_message']). "</p>"; 
                    unset($_SESSION['delete_message']); 
                }
            ?>
        </form>
        </tr>
        <?php
        }
    
    $conn->close();
    ?>
    </table> 
</body>
</html>