<?php
require 'AllEvents.php';

class MyEvents extends AllEvents
{
    /**
     * This is a list of all current events. Uncomment the ones you wish to listen to.
     * Every event that is uncommented - should then have a function below.
     * @var array
     */


    public $activeEvents = array(
//        'onClose',
       // 'onCodeRegister',
//        'onCodeRegisterFailed',
//        'onCodeRequest',
//        'onCodeRequestFailed',
//        'onCodeRequestFailedTooRecent',
        'onConnect',
//        'onConnectError',
//        'onCredentialsBad',
//        'onCredentialsGood',
        'onDisconnect',
//        'onDissectPhone',
//        'onDissectPhoneFailed',
//        'onGetAudio',
//        'onGetBroadcastLists',
//        'onGetError',
//        'onGetExtendAccount',
//        'onGetGroupMessage',
//        'onGetGroupParticipants',
//        'onGetGroups',
//        'onGetGroupsInfo',
//        'onGetGroupsSubject',
//        'onGetImage',
//        'onGetLocation',
       'onGetMessage',
//        'onGetNormalizedJid',
//        'onGetPrivacyBlockedList',
//        'onGetProfilePicture',
//        'onGetReceipt',
       // 'onGetRequestLastSeen',
//        'onGetServerProperties',
//        'onGetServicePricing',
//        'onGetStatus',
//        'onGetSyncResult',
//        'onGetVideo',
       // 'onGetvCard',
//        'onGroupCreate',
//        'onGroupisCreated',
//        'onGroupsChatCreate',
//        'onGroupsChatEnd',
//        'onGroupsParticipantsAdd',
//        'onGroupsParticipantsPromote',
//        'onGroupsParticipantsRemove',
//        'onLogin',
//        'onLoginFailed',
//        'onAccountExpired',
//        'onMediaMessageSent',
//        'onMediaUploadFailed',
//        'onMessageComposing',
//        'onMessagePaused',
       // 'onMessageReceivedClient',
       // 'onMessageReceivedServer',
//        'onPaidAccount',
//        'onPing',
       'onPresenceAvailable',
       'onPresenceUnavailable',
//        'onProfilePictureChanged',
//        'onProfilePictureDeleted',
//        'onSendMessage',
//        'onSendMessageReceived',
//        'onSendPong',
       // 'onSendPresence',
//        'onSendStatusUpdate',
//        'onStreamError',
//        'onUploadFile',
//        'onUploadFileFailed',
    );

    public function onConnect($mynumber, $socket)
    {
        // echo "Phone number $mynumber connected successfully! \n";
    }

    public function onDisconnect($mynumber, $socket)
    {
        // echo "Booo!, Phone number $mynumber is disconnected! \n";
    }

    public function onGetRequestLastSeen( $mynumber, $from, $id, $seconds )
    {
        // $timestamp = date("F j, Y, g:i a",$seconds); 
        // echo "$timestamp \n";
    }

    public function onPresenceAvailable( $mynumber, $from ) 
    {
        $from = substr($from, 0, 12);
        // echo $from;
        // echo " is Online\n";
       
        
        // echo"<br>";
        $sql = "UPDATE contacts SET online = '1' WHERE targetnumber = '$from' ";
        $result = $GLOBALS['conn']->query($sql);
    }

    public function onPresenceUnavailable( $mynumber, $from, $last )

    {
        
        $from = substr($from, 0, 12);
         $sql = "UPDATE contacts SET online = '0' WHERE targetnumber = '$from' ";
         $result = $GLOBALS['conn']->query($sql);
        // echo $from;
        // echo " is Offline\n";
        // echo"<br>";
        
    //     if($last != 'deny')
    //     {
    //     $timestamp = date("F j, Y, g:i a",$last); 
    //     echo "Last Seen : $timestamp \n";
    // }
    // else
    // {
    //   echo "Last Seen : Privacy Enabled \n";  
    // }
        
    }

    public function onSendPresence( $mynumber, $type, $name )
    {
        // echo "You are now $type \n";
    }

     public function onMessageReceivedServer( $mynumber, $from, $id, $type, $time )
    {
        $timestamp = date("F j, Y, g:i a",$time); 
        
       // insert message into DB
        
        $sql = "INSERT INTO `whatsapp`.`msgdb` (`fromNumber`, `toNumber`, `message`, `id`, `issent`, `isdelivered`, `isread`,`time_sent`,`bulkid`,`username`) VALUES ($mynumber,$GLOBALS[target],'$GLOBALS[message]','$id','1','0' ,'0' ,$time,'$GLOBALS[bulkid]','$_SESSION[login_user]')";
        $result = $GLOBALS['conn']->query($sql);

        $sql = "UPDATE users SET credits = credits - 1 WHERE username = '$_SESSION[login_user]' ";
        $result = $GLOBALS['conn']->query($sql);

        


        
        
        

    }

     public function onMessageReceivedClient( $mynumber, $from, $id, $type, $time  )
    {
        
        

        if($type == "read")
        {
            $sql = "UPDATE `whatsapp`.`msgdb` SET isread='1',time_read='$time' WHERE id='$id'";
            $result = $GLOBALS['conn']->query($sql); 

            $sql = "UPDATE `whatsapp`.`msgdb` SET isdelivered='1',time_delivered='$time' WHERE id='$id'";
            $result = $GLOBALS['conn']->query($sql); 
        }
        else
        {
            $sql = "UPDATE `whatsapp`.`msgdb` SET isdelivered='1',time_delivered='$time' WHERE id='$id'";
            $result = $GLOBALS['conn']->query($sql); 
        }
        
        
       
     }

     public function onGetvCard( $mynumber, $from, $id, $type, $time, $name, $vcardname, $vcard ,$fromJID_ifGroup = NULL)
     {
        echo $name."\n";
        echo $vcardname."\n";
        echo $vcard;
     }



    public function onGetMessage( $mynumber, $from, $id, $type, $time, $name, $body )
    {
    // echo "Message from $name:\n$body\n\n";
    
    
    
    





    }



 

}
