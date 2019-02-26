<?php

require_once __DIR__ . '/Messenger/Messenger.php';

$message = array(
    "to"=>array('j.watson@militaryshipment.com'),
    "subject"=>"Email Alert",
    "body"=>"You have an email"
);


try{
    Messenger::send($message);
}catch(\Exception $e){
    echo $e->getMessage() . "\n";
}

