<?php
    //details to access the database hosted on azure
    $serverName = "space-hub-server.database.windows.net";
    $username = "space-hub-server";
    $password = "ENSE601_19";
    $databaseName = "space-hub-db"; //the name of the database to store data

    $connectionInfo = array( "UID"=>$username, "PWD"=>$password, "Database"=>$databaseName); 

    //ESTABLISHING CONNECTION
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if(!$conn) {
        printf("Connection not established<br>");
    }

    $brand_image = array(); 

    $getImgquery = "SELECT ImageContent FROM Gallery";
    $result = sqlsrv_query($conn, $getImgquery); 
    
    $dirname = "Images/"; 
    $brand_image = glob($dirname."*.{jpg,png,jpeg,gif,pdf}", GLOB_BRACE); 

    $iPreview = 0; 

    echo '<div class="mySlides fade">'; 
    echo '<a target=_blank" href='.$brand_image['2'].'>'; 
    echo '<img src="'.$brand_image['2'].'" style="width:100%;">';
    echo '</a>'; 
    echo '</div>';

?>
