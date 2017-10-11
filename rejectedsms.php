<?php
// Check SMS Delivery Status and send message to both users

set_time_limit(128) ;
include 'dbchennai.php';
    $sql = "SELECT * FROM contacts where sms='1' ";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_array($result)) {
        $msgid = $row['msgid'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://smshorizon.co.in/api/status.php?user=xxxxx&apikey=xxxxxxxx&msgid=".$msgid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = trim($output);
               if ($output=="REJECTD")
        {
      $usernumber = $row['usernumber'];
      $name = $row['name'];
      $targetnumber = $row['targetnumber'];
$user = "#####";
$apikey = "#####";
$senderid  =  "MYTEXT";
$mobile  =  $usernumber;
$message   =  "Hey! ".$name." is now rechable. You can contact him now ".$targetnumber." - Resq (http://help.anoram.com)";
$message = urlencode($message);
$type   =  "txt";
$ch = curl_init("http://smshorizon.co.in/api/sendsms.php?user=".$user."&apikey=".$apikey."&mobile=".$mobile."&senderid=".$senderid."&message=".$message."&type=".$type."");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
      $sql = "UPDATE contacts SET sms = '0' WHERE msgid = '$msgid' ";
      $process = $conn->query($sql);
        }
            }


?>
