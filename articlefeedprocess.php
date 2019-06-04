<?php

/*
articlefeedprocess.php gets the articles from the database and
displays the title of the article section of the homepage
*/

//details to access the database hosted on azure
$serverName = "space-hub-server.database.windows.net";
$username = "space-hub-server";
$password = "ENSE601_19";
$databaseName = "space-hub-db"; //the name of the database to store data

$connectionInfo = array( "UID"=>$username, "PWD"=>$password, "Database"=>$databaseName); 

$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    printf("Connection not established<br>");
}

// 2. CREATING QUERY
// $query = "SELECT Title, FROM Article;";
$query = "SELECT ArticleID, Title, Date FROM Article;";

// 3. EXECUTING QUERY
$result = sqlsrv_query($conn, $query);

// 4. MANIPULATING RESULTS
if ($result) {

    $tArray = array(); //creating an empty array

    //pushing rows into tArray
    while ($row = sqlsrv_fetch_array($result)) {
        array_push($tArray, $row);
    }

    $cArray = array();
    $size = sizeof($tArray);

    //Organsing titles from latest to earliest
    for ($i = $size - 1; $i >= 0; $i--) {
        array_push($cArray, array_pop($tArray));
    }

    foreach ($cArray as $tValue) {
        $articleID = $tValue[0];
        $title = $tValue[1];

        $returnDateTime = date_format($tValue[2], 'Y-m-d H:i:s');

        //Date
        $newDate = date('d-m-Y', strtotime($returnDateTime));

        //Time
        $newTime = date('H:ia', strtotime($returnDateTime));

        print("<a href=\"viewarticle.php?article_to_view=$title&article_id=$articleID\">$title <span id=\"date-span\">- created on $newDate</span></a>");
    }
 
} else {
    print("No content");
}

// 5. CLOSING CONNECTION
sqlsrv_close($conn);
