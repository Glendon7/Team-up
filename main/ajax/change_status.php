<?php

require_once __DIR__ . "/../../core/init.php";

$user=new User();
if(isset($_POST['new_status'])){
$user->update('task',$_POST['ticketid'], array( 'status'=> $_POST['new_status']));
}

if(isset($_POST['percentage'])){
$user->update('task',$_POST['ticketid'], array( 'percent_complete'=> $_POST['percentage']));

}