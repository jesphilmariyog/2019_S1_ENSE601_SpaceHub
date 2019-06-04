<!DOCTYPE html>

<!-- viewarticle.php is a web page where a user can read an article. The content of the article that is 
    that is clicked from the article feed on the homepage is displayed here. -->

<html>

<head>
    <meta charset="utf-8" />

    <title>SpaceHub</title>

    <!--NOTE: Change the href link to whatever icon you want for the title: eg "icons/spacehub_favicon.png"-->
    <!-- "og_spacehub_favicon.png" is our original space background from the space hub logo-->
    <link rel="icon" type="image/png" href="icons/spacehub_favicon1.png">

    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Stylesheet for back to top button -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

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

<body>
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

    <div id="view-article">
        <?php

        $article_to_view = $_GET['article_to_view'];
        $articleID = $_GET['article_id'];

        //details to access the database hosted on azure
        $serverName = "space-hub-server.database.windows.net";
        $username = "space-hub-server";
        $password = "ENSE601_19";
        $databaseName = "space-hub-db"; //the name of the database to store data

        $connectionInfo = array("UID" => $username, "PWD" => $password, "Database" => $databaseName);

        $conn = sqlsrv_connect($serverName, $connectionInfo);

        // 2. CREATING QUERY
        $query = "SELECT Article_Content FROM Article WHERE ArticleID = '$articleID'";

        // 3. EXECUTING QUERY
        $result = sqlsrv_query($conn, $query);

        // 4. MANIPULATING RESULT
        while ($row = sqlsrv_fetch_array($result)) {
            echo "<h2>" . $article_to_view . "</h2>";
            echo $row[0];
        }

        sqlsrv_close($conn);

        ?>
    </div>

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