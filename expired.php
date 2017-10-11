<?php
set_time_limit(128) ;
include 'dbchennai.php';
    $sql = "SELECT * FROM contacts where sms='1'";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_array($result)) {
$targetnumber = $row['targetnumber'];
$number = $row['usernumber'];
$number2 = $targetnumber;
$user = "#####";
$apikey = "#####";
$senderid  =  "MYTEXT";
$mobile  =  $number2;
$message   =  "Hey!".$number."tried to contact you. We will let them know that your phone is on now - Resq (http://help.anoram.com)";
$message = urlencode($message);
$type   =  "txt";
$ch = curl_init("http://smshorizon.co.in/api/sendsms.php?user=".$user."&apikey=".$apikey."&mobile=".$mobile."&senderid=".$senderid."&message=".$message."&type=".$type."");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $sql = "UPDATE contacts SET msgid = '$output' WHERE targetnumber = '$targetnumber' ";
    $process = $conn->query($sql);
            }
?>
