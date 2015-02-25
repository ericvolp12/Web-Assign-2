<?php
session_start();
require 'sqlData.php';
$_SESSION["loaded"] = false;

    $user = $_SESSION["user"];
    $assignment = $_SESSION["assignmentID"];

    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $DBH = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM assignments WHERE user=:user AND assignment=:assignment";
    $STH = $DBH->prepare($sql);
    $STH->bindParam(':user', $user);
    $STH->bindParam(':assignment', $assignment);
    $result = $STH->execute();
?>