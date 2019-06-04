<?php
//details to access the database hosted on azure
$serverName = "space-hub-server.database.windows.net";
$username = "space-hub-server";
$password = "ENSE601_19";
$databaseName = "space-hub-db"; //the name of the database to store data

$connectionInfo = array("UID" => $username, "PWD" => $password, "Database" => $databaseName);

// 1. ESTABLISHING CONNECTION
$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    printf("Connection not established");
}

// 2. CREATING QUERY    
$query = "SELECT ThreadID, Title, Date FROM DiscussionThread";

// 3. EXECUTING QUERY
$result = sqlsrv_query($conn, $query);

$content;

if (!$result) {
    $content = "<p>No Content</p>";
} else {
    $content = "<table class=\"discussion-table\">";
    $content .= "<thead><tr><th>Title</th><th id=\"th-date\">Date</th></tr></thead><tbody>";

    $row = sqlsrv_fetch_array($result);

    do {
        $threadID = $row[0];

        $title = $row[1];

        $returnDateTime = date_format($row[2], 'Y-m-d H:i:s');
        
        $newDate = date('d-m-Y', strtotime($returnDateTime));

        $content .= "<tr><td><a href=\"viewdiscussion.php?thread_id=$threadID\">$title</a></td><td>$newDate</td></tr>";

    } while ($row = sqlsrv_fetch_array($result));
}

$content .= "</tbody></table>";

sqlsrv_free_stmt($result);

echo $content;

?>