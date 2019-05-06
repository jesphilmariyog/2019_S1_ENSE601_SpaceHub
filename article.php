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
                        mysqli_ssl_set($conn, NULL, NULL, "/site/wwwroot/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
                        

                        //connecting to the database
                        mysqli_real_connect($conn, $hostname, $username, $password, $db, 3306, MYSQLI_CLIENT_SSL);

                        //testing if the connection was successful
                        if (mysqli_connect_errno($conn)) {
                            die('Failed to connect to MySQL: ' . mysqli_connect_error()); //connection to the database failed
                        }

                        // 2. CREATING QUERY
                        $query = "SELECT title, author FROM article;";

                        // 3. EXECUTING QUERY
                        $result = mysqli_query($conn, $query);

                        // 4. MANIPULATING RESULTS
                        //results must be true in order to manipulate the results
                        //results must have rows greater than zero - otherwise there are no titles (hence articles)
                        if ($result !== false and mysqli_num_rows($result) > 0) {

                            $tArray = array(); //creating an empty array

                            //pushing rows into tArray
                            while ($row = mysqli_fetch_array($result)) {
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

                        // 5. CLOSING CONNECTION
                        mysqli_close($conn);

                    ?>