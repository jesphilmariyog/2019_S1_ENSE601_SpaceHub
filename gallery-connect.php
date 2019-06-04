<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
    
        //details to access the database hosted on azure
        $serverName = "space-hub-server.database.windows.net";
        $username = "space-hub-server";
        $password = "ENSE601_19";
        $databaseName = "space-hub-db"; //the name of the database to store data

        $connectionInfo = array( "UID"=>$username, "PWD"=>$password, "Database"=>$databaseName); 

        // ESTABLISHING CONNECTION
        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if(!$conn) {
            printf("Connection not established<br>");
        }
        
        $targetDir = "Images/"; 
        $imageName = basename($_FILES['file']['name']); 
        $givenImageName = $_POST['text']; 
        $targetfilepath = $targetDir . $imageName;
        $fileExt = explode('.', $imageName); 
        $fileType = strtolower(end($fileExt));
        $imagetmp = $_FILES['file']['tmp_name'];
        $imgData = addslashes(file_get_contents($_FILES['file']['name'])); 
         
        if(isset($_POST['submit']) && !empty($_FILES['file']['name'])){
            //allowed file types
            $allowed = array('jpg', 'png', 'jpeg', 'gif', 'pdf'); 
            
            if(in_array($fileType, $allowed)){
                
                //Upload to server TODO This is where I changed the file.
                session_start();
                $acc_id = $_SESSION['id'];
                if ($acc_id === NULL) {header("Location: gallery.html?Please_Login");} else {
                    if(move_uploaded_file($imagetmp, $targetfilepath)) {
                        //Insert image file name into database
                        $query = "INSERT INTO Gallery (AccountID, Title, Date, Image_Content) 
                                  VALUES ('$acc_id', '$givenImageName', GETDATE() ,CAST('$imgData' AS VARBINARY(MAX)))"; 
                        $result = sqlsrv_query($conn, $query); 
                        header("Location: gallery.html?Upload_Success!$acc_id");
                    } else {
                        header("Location: gallery.html?There_was_an_error_uploading_the_image"); 
                    }
               }
            } else {
                header("Location: gallery.html?The_file_type_was_incorrect");
            }
        }else {
            header("Location: gallery.html?Please_select_an_image_to_upload");
        }
    ?>
</body>
</html>