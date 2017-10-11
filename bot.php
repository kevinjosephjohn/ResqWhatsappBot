<?php
require_once 'waconfig.php';
include 'dbchennai.php';
$w = new WhatsProt($username, $nickname, $debug);
$events = new MyEvents($w);
$events->setEventsToListenFor($events->activeEvents);
$w->connect(); // Connect to WhatsApp network
$w->loginWithPassword($password); // logging in with the password we got!
$w->sendGetPrivacyBlockedList();
$w->sendPresence($type = "active");
while(1)
{
   $w->pollMessage();
    $msgs = $w->getMessages();
    $sql = "SELECT * FROM contacts where online='1' AND notified='' ";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_array($result)) {
      # code...
      $unsubscribe = $row['targetnumber'];
      $w->sendPresenceUnsubscription($unsubscribe);
      $message = $row['name']." is online";
      $w->sendMessageComposing($row['usernumber']); // Send composing
      sleep(2);
      $w->sendMessagePaused($row['usernumber']); // Send paused
      sleep(2);
      $w->sendMessage($row['usernumber'],$message);
      $sql = "UPDATE contacts SET notified = '1' WHERE targetnumber = '$unsubscribe' ";
      $result = $conn->query($sql);
    }
     foreach ($msgs as $m) {
      // Get User Phone Number
                $target = @$m->getAttribute('from');
                $target = substr($target, 0, 12);
                // Get Message
                $message = @$m->getChild("body")->getData();
                $sql = "SELECT * FROM users where mobile='$target' ";
                $result = $conn->query($sql);
                $isexist = mysqli_num_rows($result);
                 if($isexist == "1")
                {
                    $type = explode(" ", $message);
                    if($type[0] != null && $type[1] != null && $type[2] !=null)
                    {
                      $name = $type[0];
                      $targetnumber = "91".$type[1];
                      $myContacts = array($targetnumber);
                      $w->sendSync($myContacts);
                      sleep(2);
                      $w->sendPresenceSubscription($targetnumber);
                      $sql = "INSERT INTO `resq`.`contacts` (`name`,`usernumber`,`targetnumber`,`type`,`sms`,`message`) VALUES ('$name','$target','$targetnumber','notify','1','$message')";
                  $results = $conn->query($sql);
                  $w->sendMessageComposing($target); // Send composing
                  sleep(3);
                  $w->sendMessagePaused($target); // Send paused
                  sleep(2);
                  $message = "We will update you once ".$name." comes online";
                  $w->sendMessage($target , $message);
                    }
                    else
                    {
                      $message = "";
                  $w->sendMessageComposing($target); // Send composing
                  sleep(2);
                  $w->sendMessagePaused($target); // Send paused
                  sleep(2);
                       $w->sendMessage($target , $message);

                  $w->sendMessageComposing($target); // Send composing
                  sleep(5);
                  $w->sendMessagePaused($target); // Send paused
                  sleep(2);
                       $message = "Please send the message in format below so we will let you know once the person comes online\n\nNAME WHATSAPPNUMBER NOTFIY\n\nEg: John 9999999999 NOTFIY";
                        $w->sendMessage($target , $message);
                    }
                }
                else
                {
                  $sql = "INSERT INTO `resq`.`users` (`mobile`,`state`) VALUES ('$target','1')";
                  $results = $conn->query($sql);
                  $myContacts = array($target);
                  $w->sendSync($myContacts);
                  sleep(3);
                  $w->sendMessageComposing($target); // Send composing
                  sleep(5);
                  $w->sendMessagePaused($target); // Send paused
                  sleep(2);
                  $message = "Please send the message in format below so we will let you know once the person comes online\n\nNAME WHATSAPPNUMBER NOTFIY\n\nEg: John 9999999999 NOTFIY";
                  $w->sendMessage($target , $message);
                }
     }
}
?>
