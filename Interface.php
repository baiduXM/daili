<?php
include './ExpressPHP.Init.php';

$GbpenApps = new InterfaceApps();
$module = $_GET['module'];
$action = $_GET['action'];
if($module=='')
{
    header("HTTP/1.0 500 Internal Server Error");
    exit;
}

unset($_GET['module'], $_GET['action']);
$GbpenApps->Run($module, $action);
unset($GbpenApps);
?>