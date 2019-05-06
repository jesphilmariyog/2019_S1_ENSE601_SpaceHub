<html>
<head>
    <meta charset="UTF-8">
    <title>GetImage</title>
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

        $result = $conn->query("SELECT * FROM images");

        while($row_brand=mysqli_fetch_array($result))
        {
            $brand_image[] = $row_brand; 
        }
    ?>

    <?php foreach($brand_image as $brand){ ?>
        <div class="column">
            <img src='uploads/<?php echo $brand["$image"]; ?>' />
            <img src="image.php?id=<? echo $brand['imageId']; ?>" />
        </div>
    <?php } ?>
</body>
</html>