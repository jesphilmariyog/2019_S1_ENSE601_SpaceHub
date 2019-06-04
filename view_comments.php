<?php
// Establishing a connection to the SQL Server.
$server_name = "tcp:space-hub-server.database.windows.net,1433";
$username = "space-hub-server@space-hub-server";
$password = "ENSE601_19";
$database = "space-hub-db";
$conn_info = array("Database" => $database, "UID" => $username, "PWD" => $password);
$conn = sqlsrv_connect($server_name, $conn_info);
if (!$conn) {} // Connection failed; Do nothing.
else {
    if (!sqlsrv_begin_transaction($conn)) {} // Transaction failed; Do nothing.
    else {
        $tid = $_POST['thread_id'];
        $query = "SELECT * FROM Comment WHERE ThreadID='$tid' ORDER BY Date";
        $select_stmt = sqlsrv_query($conn, $query);
        if (!$select_stmt) { sqlsrv_rollback($conn); } // Select query failed; Rollback transaction.
        else {
            // Get data from database.
            while ($comment = sqlsrv_fetch_array($select_stmt, SQLSRV_FETCH_ASSOC)) {
                $content = $comment["Comment_Content"];
                $account_id = $comment["AccountID"];
                $date_time = date_format($comment['Date'], 'Y-m-d H:i:s');
                
                $query = "SELECT FullName FROM Account WHERE AccountID='$account_id'";
                $account_stmt = sqlsrv_query($conn, $query);
                if (!$account_stmt) { // Select query for account's full name failed; Rollback transaction.
                    sqlsrv_rollback($conn);
                    break;
                } else {
                    if (!sqlsrv_fetch($account_stmt)) { // Comment created by account that is not in database.
                        sqlsrv_rollback($conn);
                        break;
                    } else {
                        $account_name = sqlsrv_get_field($account_stmt, 0);
                        echo "<div class=\"comment\" style=\"white-space: pre;\">$content<br><h6>Created on $date_time by $account_name</h6>";

                        // Continuing the session to find out who made what comment.
                        session_start();
                        $current_account_id = $_SESSION['id'];
                        if ($current_account_id === $account_id) {
                            $comment_id = $comment["CommentID"];
                            echo "<button class=\"delete-comment\" onClick=\"deleteComment('delete_comment.php', '$tid', '$comment_id')\">Delete</button>";
                        }
                        echo "</div>";
                    }
                }
            }
            
            // Committing all queries made. If failed commit, reset all transactions.  
            if (!sqlsrv_commit($conn)) {
                sqlsrv_rollback($conn);
            }
        }
    }
    sqlsrv_close($conn);
}