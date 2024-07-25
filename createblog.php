<?php
session_start();
// to check whether user is logged in or not
if (!isset($_SESSION['username'])) {
    echo"<h2> PLese login to create a post</h2>"; 
    header('location:login.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create ur blog</title>
</head>
<body>
    <h2>Welcome to Creative page :</h2>
    <h2> <?php echo $_SESSION['username']; ?> </h2>
    <br>
    <button type="submit" ><a href="display.php">Dispaly all Blogs</a></button> 
    <h1>Create a New Blog Post</h1>
    <!-- to create a blog posts  -->
    <form action="store.php" method="post">
        
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="10" cols="30" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
    <h2>
    <?php
    // to display success message 
        if (isset($_SESSION['message'])) {//getting message from store.php
            echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
            // Unset the message after displaying
            unset($_SESSION['message']);
        }
    ?>
    </h2>
   
    <!-- <button type="submit" ><a href="register.php">Register</a></button>  -->
    <button type="submit" ><a href="logout.php">logout</a></button><br>

</body>
</html> 