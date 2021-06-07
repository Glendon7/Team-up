<?php

require_once __DIR__ . "/../../core/init.php";

$user=new User();
if(isset($_POST['project_id'])){
$user->delete('projects','id' , $_POST['project_id']);
$user->delete('task','for_project',$_POST['project_id']);
echo 1;
exit;
}

echo 0;
exit;