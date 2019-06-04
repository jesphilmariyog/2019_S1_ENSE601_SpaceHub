<?php

$threadID = $_POST['threadID'];

//details to access the database hosted on azure
$serverName = "space-hub-server.database.windows.net";
$username = "space-hub-server";
$password = "ENSE601_19";
$databaseName = "space-hub-db"; //the name of the database to store data

$connectionInfo = array("UID" => $username, "PWD" => $password, "Database" => $databaseName);

// 1. CREATING CONNECTION
$conn = sqlsrv_connect($serverName, $connectionInfo);

// 2. CREATING QUERY
$query = "DELETE FROM DiscussionThread WHERE ThreadID = '$threadID'";

// 3. EXECUTING QUERY
$result = sqlsrv_query($conn, $query);

header("Location:https://space-hub.azurewebsites.net/discussion.html");
?>
