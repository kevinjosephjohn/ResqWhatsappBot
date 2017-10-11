<?php
// Check SMS Delivery Status and send message to both users
set_time_limit(128) ;
include 'dbchennai.php';
    $sql = "SELECT * FROM users where msgstatus='0'";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_array($result)) {
        $msgid = $row['msgid'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://smshorizon.co.in/api/status.php?user=xxxxx&apikey=xxxxxxxx&msgid=".$msgid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = trim($output);
               if ($output=="DELIVRD")
        {
      $sql = "UPDATE users SET msgstatus = 'Phone is On' WHERE msgid = '$msgid' ";
      $process = $conn->query($sql);
        }
                   elseif ($output=="DND")
        {
      $sql = "UPDATE users SET msgstatus = 'Phone has DND enabled' WHERE msgid = '$msgid' ";
      $process = $conn->query($sql);
        }
 elseif ($output=="Message Sent")
        {
      $sql = "UPDATE users SET msgstatus = 'Waiting for response from phone' WHERE msgid = '$msgid' ";
      $process = $conn->query($sql);
        }
            }
?>
