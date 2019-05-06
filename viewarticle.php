<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>SpaceHub</title>

    <!--NOTE: Change the href link to whatever icon you want for the title: eg "icons/spacehub_favicon.png"-->
    <!-- "og_spacehub_favicon.png" is our original space background from the space hub logo-->
    <link rel="icon" type="image/png" href="icons/spacehub_favicon1.png">

    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--JavaScript files for moment.js library-->
    <script src="assets/clock/momentjs.js"></script>
    <script src="assets/clock/moment-timezone-with-data-10-year-range.js"></script>

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
                    <li><a href="#">Articles</a></li>
                    <li><a href="calendar.html">Calendar</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Login</a></li>
                </ul>
            </nav>

            <!--******This is the search bar. Need to create search operation******-->

        </div>
    </header>

    <!--Clock Header-->
    <div class="clock-container">
        <div class="clock-wall">
            <div class="clock" id="America/New_York"></div>
            <div class="clock" id="Europe/London"></div>
            <div class="clock" id="Asia/Tokyo"></div>
            <div class="clock" id="Pacific/Sydney"></div>
            <div class="clock" id="Pacific/Auckland"></div>
        </div>
    </div>

    <!--Updates the clock view-->
    <script src="clock_script.js"></script>

    <div id="view-article">
    <?php

            $article_to_view = $_GET['article_to_view'];

            // 1. ESTABLISHING CONNECTION
            $conn = mysqli_init(); //initialises MySQLi to be used for mysqli_real_connect(...)

            //details to access the database hosted on azure
            $hostname = "patrickmysql.mysql.database.azure.com";
            $username = "patrickmysql@patrickmysql";
            $password = "Testin9$";
            $db = "mysampledb"; //the name of the database to store data
            $port = 3306;

            //creating a secure and encrypted connection to the database
            mysqli_ssl_set($conn, NULL, NULL, "/home/pcb3888/public_html/test/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);

            //connecting to the database
            mysqli_real_connect($conn, $hostname, $username, $password, $db, 3306, MYSQLI_CLIENT_SSL);

            //testing if the connection was successful
            if (mysqli_connect_errno($conn)) {
                die('Failed to connect to MySQL: ' . mysqli_connect_error()); //connection to the database failed
            }

            // 2. CREATING QUERY
            $query = "SELECT * FROM article WHERE title='$article_to_view';";

            // 3. EXECUTE QUERY
            $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_row($result)) {

                $title = $row[1];
                $author = $row[2];
                $content = $row[3];

                echo "<h2>" . $title . "</h2>";
                echo "<h3>" . $author . "</h3>";
                echo "<p>" . $content . "</p>";

            }

            mysqli_close($conn);

        ?>
    </div>

</body>
</html>


