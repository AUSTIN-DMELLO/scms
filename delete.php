<?php
if(isset($_GET['Roll_No'])){
    $id = $_GET['Roll_No'];

    $servername="localhost";
    $username="root";
    $password="";
    $database="studentdetails";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql= "DELETE FROM students WHERE Roll_No=$id";
    $connection->query($sql);
}
header("location: /scms/index.php");
exit;
?>
