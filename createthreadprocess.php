<?php

$threadTitle = $_POST["threadTitle"];
$threadContent = $_POST["threadContent"];

//details to access the database hosted on azure
$serverName = "space-hub-server.database.windows.net";
$username = "space-hub-server";
$password = "ENSE601_19";
$databaseName = "space-hub-db"; //the name of the database to store data

$connectionInfo = array( "UID"=>$username, "PWD"=>$password, "Database"=>$databaseName); 

// 1. ESTABLISHING CONNECTION
$conn = sqlsrv_connect($serverName, $connectionInfo);

$currentTime = date("Y-m-d H:i:s");

session_start();
$acc_id = $_SESSION["id"];

$message;

if($acc_id === null) {
    $message = "<p id=\"confirmation-message-thread\">Thread Not Posted</p>";
} else {
    // 2. CREATE QUERY
    $query = "INSERT INTO DiscussionThread (AccountID, Title, Date, Thread_Content) VALUES ('$acc_id', '$threadTitle', '$currentTime', '$threadContent');";

    // 3. EXECUTING QUERY
    $result = sqlsrv_query($conn, $query);

    if($result) {
        header("Location: discussion.html");
    } else {
        $message = "<p id=\"confirmation-message-thread\">Thread Not Posted</p>";
        echo $message;
    }
}
?>