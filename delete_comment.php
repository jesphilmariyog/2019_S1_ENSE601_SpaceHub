<?php
$server_name = "tcp:space-hub-server.database.windows.net,1433";
$username = "space-hub-server@space-hub-server";
$password = "ENSE601_19";
$database = "space-hub-db";
$conn_info = array("Database" => $database, "UID" => $username, "PWD" => $password);
$conn = sqlsrv_connect($server_name, $conn_info);
if (!$conn) {}
else {
    $comment_id = $_POST['commentID'];
    $thread_id = $_POST['threadID'];
    if (!sqlsrv_begin_transaction($conn)) {}
    else {
        $stmt = sqlsrv_query($conn, "DELETE FROM Comment WHERE CommentID = '$comment_id' AND ThreadID = '$thread_id'");
        if (!$stmt) { sqlsrv_rollback($conn); }
        else {
            if (!sqlsrv_commit($conn)) {
                sqlsrv_rollback($conn);
            }
        }
    }
    sqlsrv_close($conn);
}