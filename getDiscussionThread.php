<?php
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

    $imageArray = array(); 
    
    $getDThread = "SELECT * FROM DiscussionThread";
    $result = sqlsrv_query($conn, $getDThread); 
 
    while($row = sqlsrv_fetch_array($result)){
        echo '<tr>';
        echo '<td>'.$row['Title'].'</td>'; 
        echo '<td>'.$row['Date'].'</td>'; 
        echo '</tr>';
    }
?>