<?php

    // 1. ESTABLISHING CONNECTION

    $conn = mysqli_init(); //initialises MySQLi to be used for mysqli_real_connect(...)

    //details to access the database hosted on azure
    $hostname = "patrickmysql.mysql.database.azure.com";
    $username = "patrickmysql@patrickmysql";
    $password = "Testin9$";
    $db = "mysampledb"; //the name of the database to store data
    $port = 3306;

    //creating a secure and encrypted connection to the database
    mysqli_ssl_set($conn, NULL, NULL, "/site/wwwroot/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 

    //connecting to the database
    mysqli_real_connect($conn, $hostname, $username, $password, $db, 3306, MYSQLI_CLIENT_SSL);

    //testing if the connection was successful
    if (mysqli_connect_errno($conn)) {
        die('Failed to connect to MySQL: '.mysqli_connect_error()); //connection to the database failed
    }

    // 2. CREATING QUERY

    $title = $_POST["article-title"];
    $author = $_POST["author"];
    $content = $_POST["content"];



    if($result ) {
        printf("Query execution successful.");
    } else {
        printf("Query execution failed");
    }

    mysqli_close($conn);

?>
