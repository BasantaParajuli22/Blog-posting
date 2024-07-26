<?php

session_start();

if(isset($_SESSION['username']) ){
     $username  = $_SESSION['username'];
}


$conn = new mysqli('localhost',"root","",'basanta_db');
if($conn->connect_error){
    die("connection failed". $conn->connect_error);
}
//to display all blog_post
$sql ="SELECT * FROM post_table  ";
$result = $conn->query($sql);
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
    <title>Home</title>
</head>
<body>
    <h1>Home <br>>>Blog Posts</h1>
    <h2><?php echo "User::  " . $_SESSION['username']; ?> </h2>

    <?php if(!isset($_SESSION['username'])){ echo " <p style = 'color:red;'> Please login to create post</p>"; }?>
     <form action="blogform.php">
        <!-- send username in url line 11 in home  -->
        <input type="hidden" name="username" >
        <button type="submit">Create new Post</button>
     </form>
     <br><button><a href="blogNcomment.php">Visit my profile</a></button>
    <hr>
<!-- to display all blog_posts in table -->
    <table border="1">
        <tr>
        <th>id</th>
        <th>author</th>
        <th>title</th>
        <th>content</th>
        <th>Options</th>
        </tr>
    <?php
        foreach ($fetched_data as $data) {
             
    ?>
    <tr>   
        <form action="view_mode.php" method="post">      
        <td><?php echo $data['id']; $form_id = $data['id'];?></td>
        <?php echo $_SESSION['view'] = $form_id ;?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
        <td><?php echo $data['username']; ?></td>
        <td><?php echo $data['title']; ?></td>
        <td><?php echo $data['content']; ?></td>


            <!-- no priviliges needed to view the specific content-->
        <td> <button type="submit" name="view">View</button></td>
        </form>
        
                <!-- priviliges needed to edit  -->
        <form action="">
        <td><button type="submit" name="edit" value="<?php echo htmlspecialchars($data['id']);   ?>">Edit</button></td>
        </form>  
                <!-- username needs to same for deletion  --> 
        <form action="delete_blog.php" method="post">
            <input type="hidden" name="Blog_id" value="<?php echo htmlspecialchars($data['id']); ?>">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($data['username']); ?>">
            <td><button type="submit" name="delete_blog" >Delete</button></td>
            <?php  if(isset($_SESSION['delete_message'])) {
                echo "<p style ='red';>" .  htmlspecialchars($_SESSION['delete_message']). "</p>"; 
                unset($_SESSION['delete_message']); 
                }
            ?>
        </form>
    </tr> 

    <?php
    }
    ?>
    
    </table>
    <br>
    <button ><a href="login.php">Login</a></button>
    <button type="submit" ><a href="logout.php">logout</a></button><br>
</body>
</html>
