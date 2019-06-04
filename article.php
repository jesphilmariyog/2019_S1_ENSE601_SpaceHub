<?php

    /* article.php retrieves the articles from the SQL database
    and manipulates for the article feed section of the homepage */

    //details to access the database hosted on azure
    $serverName = "space-hub-server.database.windows.net";
    $username = "space-hub-server";
    $password = "ENSE601_19";
    $databaseName = "space-hub-db"; //the name of the database to store data

    $connectionInfo = array( "UID"=>$username, "PWD"=>$password, "Database"=>$databaseName); 

    $conn = sqlsrv_connect($servernName, $connectionInfo); 

    // 2. CREATING QUERY
    $query = "SELECT title, author FROM article;";

    // 3. Executing query
    $result = sqlsrv_query($conn, $query);
    
    // 4. Manipulate results
    if($result) { // if result is true then manipulate results

        if ($result !== false and sqlsrv_num_rows($result) > 0) {

            $tArray = array(); //creating an empty array
    
            //pushing rows into tArray
            while ($row = sqlsrv_fetch_array($result)) {
                array_push($tArray, $row);
            }
    
            //Organsing titles from latest to earliest
            $cArray = array();
            $size = sizeof($tArray);
            for($i = $size - 1; $i >= 0; $i--){
                array_push($cArray, array_pop($tArray));
            }
            
            foreach($cArray as $tValue) {
                $title = $tValue["title"];
                $author = $tValue["author"];
                echo "<a href=\"viewarticle.php?article_to_view=$title\">" . $title . " - by " . $author . "</a>";
            }

        }
    
    } else { // if false then display error

        echo "Execution failed.\n";  
        die(print_r(sqlsrv_errors(), true));

    } 

    // 5. CLOSING CONNECTION
    sqlsrv_close($conn);

?>