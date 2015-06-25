<?php
//include database connection
include 'db.php';
$action = isset($_GET['action']) ? $_GET['action'] : "";

if ($action == 'delete') { //if the user clicked ok, run delete query
    
    //$mysqli->real_escape_string() function helps us prevent attacks such as SQL injection
    $query = "DELETE FROM users WHERE id = " . $mysqli->real_escape_string($_GET['id']) . "";
    
    //execute query
    if ($mysqli->query($query)) {
        
        //if successful deletion
        //redirect to index.php 
		header("Location:index.php");
        
    } else {
        //if there's a database problem
        echo "Database Error: Unable to delete record.";
    }
}
?>
