<?php
$server_name = "tcp:space-hub-server.database.windows.net,1433";
$username = "space-hub-server@space-hub-server";
$password = "ENSE601_19";
$database = "space-hub-db";

$conn_info = array("Database" => $database, "UID" => $username, "PWD" => $password);
$conn = sqlsrv_connect($server_name, $conn_info);
if (!$conn) { echo "<div>" . print_r(sqlsrv_errors(), true) . "</div>"; }
else {
    $thread_id = $_GET["threadid"]; // Getting thread_id outside so it will redirect even when comment fails.

    if (!sqlsrv_begin_transaction($conn)) {}
    else {
        // Get account ID.
        session_start();
        $acc_id = $_SESSION["id"];
        if ($acc_id === NULL) {}
        else {
            // Get current date and time.
            $date_time = date("Y-m-d H:i:s");

            // Get the data from the form.
            $comment = $_GET["comment"];

            // Make an insert query to insert the comment into the database.
            $query = "INSERT INTO Comment (AccountID, ThreadID, Date, Comment_Content) VALUES ( '$acc_id', '$thread_id', '$date_time', '$comment' )";
            $result = sqlsrv_query($conn, $query);
            if (!$result) { // Insertion Query failed.
                print_r(sqlsrv_errors(), true);
            } elseif (!sqlsrv_commit($conn)) { // Failed to commit. Rollback.
                sqlsrv_rollback($conn);
            }
        }
    }
    sqlsrv_close($conn);

    // Redirect to viewdiscussion.php
    header("Location: https://space-hub.azurewebsites.net/viewdiscussion.php?thread_id=$thread_id");
}