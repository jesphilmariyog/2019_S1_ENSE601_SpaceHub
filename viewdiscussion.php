<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <title>SpaceHub</title>

    <link rel="icon" type="image/png" href="icons/spacehub_favicon1.png">

    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Stylesheet for back to top button -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <!--Stylesheet for comment styling-->
    <link rel="stylesheet" type="text/css" href="comment.css">

    <!--JavaScript files for moment.js library-->
    <script src="assets/clock/momentjs.js"></script>
    <script src="assets/clock/moment-timezone-with-data-10-year-range.js"></script>

    <!--Necessary for Google Sign-In API-->
    <script src="login.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=onloadInit" async defer></script>

    <script src="ajax.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SPACE BACKGROUND -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <div id='stars'></div>
    <div id='stars2'></div>
    <div id='stars3'></div>

</head>
<?php
$tid=$_GET['thread_id'];
echo "<body onload=\"setCommentFeed('view_comments.php', 'view-comment', '$tid')\">";
?>

    <!--Header and Navigation Bar for the Homepage-->
    <header>
        <div class="header-navbar">

            <a href="index.html"><img class="logo" src="assets/logo.png" alt="SpaceHub Logo"></a>

            <!--******This is the navigation elements. Need to add proper webpage links.******-->
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="calendar.html">Calendar</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="discussion.html">Discussion</a></li>
                    <li><a href="lightPollutionMap.html">Light Pollution Map</a></li>
                    <li id="login-item">
                        <div id="sign-in"></div>
                    </li>
                </ul>
            </nav>

        </div>
    </header>

    <!--Clock Header-->
    <div class="clock-container">
        <div class="clock-wall">
            <div class="clock" id="America/New_York"></div>
            <div class="clock" id="Europe/London"></div>
            <div class="clock" id="Asia/Tokyo"></div>
            <div class="clock" id="Asia/Calcutta"></div>
            <div class="clock" id="Pacific/Auckland"></div>
        </div>
    </div>

    <!--Updates the clock view-->
    <script src="clock_script.js"></script>

    <!-- New line for spacing -->
    <br>

    <?php

    $threadID = $_GET['thread_id'];

    //details to access the database hosted on azure
    $serverName = "space-hub-server.database.windows.net";
    $username = "space-hub-server";
    $password = "ENSE601_19";
    $databaseName = "space-hub-db"; //the name of the database to store data

    $connectionInfo = array("UID" => $username, "PWD" => $password, "Database" => $databaseName);

    // 1. CREATING CONNECTION
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    // 2. CREATING QUERY
    $query = "SELECT AccountID, Title, Thread_Content, Date FROM DiscussionThread WHERE ThreadID = '$threadID';";

    // 3. EXECUTING QUERY
    $result = sqlsrv_query($conn, $query);

    // 4. MANIPULATING RESULTS
    $row = sqlsrv_fetch_array($result);

    $accountID = $row[0];
    $title = $row[1];
    $threadContent = $row[2];
    $returnDateTime = date_format($row[3], 'Y-m-d H:i:s');
    $date = date('d-m-Y', strtotime($returnDateTime));

    sqlsrv_free_stmt($result);

    // 5. CREATING SECOND QUERY 
    $query = "SELECT FullName FROM Account WHERE AccountID = '$accountID'";

    // 6. EXECUTING QUERY
    $result = sqlsrv_query($conn, $query);

    // 6. MANIPULATING RESULTS 2
    $row = sqlsrv_fetch_array($result);

    $threadAuthor = $row[0];

    echo "<div class=\"thread-container\">";
    echo "<div class=\"thread-in-view\">";

    session_start();
    $currentAccID = $_SESSION['id'];

    if($currentAccID === $accountID) { //author is the current user

        echo "<div class=\"thread-btn-wrapper\">";

            echo "<button id=\"delete-thread\" type=\"button\" onClick=\"deleteThread('deletethreadprocess.php', $threadID)\">Delete Thread</button>";

        echo "</div>";

    } else if($currentAccID !== null && $currentAccID !== $accountID) { //current user not the author
    }

    echo "<h2>$title</h2>";
    echo "<span>Created by $threadAuthor on $date</span>";
    echo "<div class=\"thread-content\">$threadContent</div>";
    echo "<div class=\"create-comment-container\">";
    echo "<form id=\"add-comment\" action=\"create_comment.php\" onsubmit=\"window.location.replace('.');\">";
    echo "<textarea placeholder=\"Enter comment\" name=\"comment\" form=\"add-comment\" required></textarea><br>";
    echo "<input type=\"hidden\" name=\"threadid\" value=\"$threadID\">";
    echo "<button type=\"submit\" form=\"add-comment\">Comment</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>"; //115
    echo "<div id=\"view-comment\">";
    echo "<h3>Comments</h3>";
    echo "</div>"; //121
    echo "</div><br>"; //114

    sqlsrv_close($conn);
    ?>

    <!-- New line for spacing -->
    <br>

    <!-- Footer -->
    <div class="footer">
        <footer>
            <p>Malay Bhagavan &nbsp;<span> | </span>&nbsp; Jesphilmar Iyog &nbsp;<span> | </span>&nbsp; Nishant Patel &nbsp;<span> | </span>&nbsp; Sri Sai Chandan Mangu</p>
            <p>Copyright © 2019 space-hub.azurewebsites.net</p>
            <p>All rights reserved</p>
        </footer>
    </div>
</body>
</html>