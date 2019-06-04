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

    $imageArray = array(); 
    
    $getImgquery = "SELECT ImageContent FROM Gallery";
    $result = sqlsrv_query($conn, $getImgquery); 
    
    //to go through database
    while($row_brand=sqlsrv_fetch_array($result)){ }
    
    $dirname = "Images/"; 
    $imageArray = glob($dirname."*.{jpg,png,jpeg,gif,pdf}", GLOB_BRACE); 

    $imgCount = 0; 
    foreach($imageArray as $brand){  
        $imgCount++; 
        if($imgCount == 5)
        {
            $imgCount = 1; 
        }
        if($imgCount == 5)
        {
            echo '<div class="column"> 
                    <a target="_blank" href='.$brand.' class="image a"> 
                        <img src="'.$brand.'" style="width:24%">
                    </a>
                </div>'; 
        }
        else{
            echo '  
                    <a target="_blank" href='.$brand.'> 
                        <img src="'.$brand.'" style="width:24%">
                    </a>'; 
        }
    }
?>