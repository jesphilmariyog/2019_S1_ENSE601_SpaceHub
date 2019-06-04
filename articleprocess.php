<?php

/*
articleprocess.php stores a new article into the database
*/

//details to access the database hosted on azure
$serverName = "space-hub-server.database.windows.net";
$username = "space-hub-server";
$password = "ENSE601_19";
$databaseName = "space-hub-db"; //the name of the database to store data

$connectionInfo = array( "UID"=>$username, "PWD"=>$password, "Database"=>$databaseName); 

// 1. ESTABLISHING CONNECTION
$conn = sqlsrv_connect($serverName, $connectionInfo);

if(!$conn) {
    printf("Connection not established<br>");
}

// 2. CREATING QUERY
$title = $_POST["article-title"];
$content = $_POST["article-content-textarea"]; 

//ensure that the accountID is put into the query

$currentDateTime = (string)date('Y-m-d H:i:s');

echo $currentDateTime;

session_start();
$acc_id = $_SESSION['id'];

$query;

if ($acc_id === NULL) {

} else {
    $query = "INSERT INTO Article (AccountID, Title, Date, Article_Content) VALUES ('$acc_id', '$title', '$currentDateTime', '$content')";
}

// 3. EXECUTING QUERY
$result = sqlsrv_query($conn, $query);   

// 4. CLOSING CONNECTION
sqlsrv_close($conn);

header("Location:https://space-hub.azurewebsites.net/index.html");

?>
