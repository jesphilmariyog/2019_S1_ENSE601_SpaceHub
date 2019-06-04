<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        
        $conn = mysqli_init(); //initialises MySQLi to be used for mysqli_real_connect(...)

        //details to access the database hosted on azure
        $hostname = "patrickmysql.mysql.database.azure.com";
        $username = "patrickmysql@patrickmysql";
        $password = "Testin9$";
        $db = "mysampledb"; //the name of the database to store data
        $port = 3306;

        //creating a secure and encrypted connection to the database
        mysqli_ssl_set($conn, NULL, NULL, "/home/pcb3888/public_html/randomstuff/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 

        //connecting to the database
        mysqli_real_connect($conn, $hostname, $username, $password, $db, 3306, MYSQLI_CLIENT_SSL);

        //testing if the connection was successful
        if (mysqli_connect_errno($conn)) {
            die('Failed to connect to MySQL: '.mysqli_connect_error()); //connection to the database failed
        }

        //creating a string that will be the SQL query statements
        $query = "INSERT INTO inventory (id, name, quantity) VALUES (4, 'peach', 204);"; 

        //executing the query statement
        $queryResult = mysqli_query($conn, $query);

        //if query statement is successful then $queryResult is set to true
        if($queryResult) {
            printf("Query execution successful.");
        } else {
            printf("Query execution failed");
        }

        //close connection
        mysqli_close($conn);

    ?>  
</body>
</html>
