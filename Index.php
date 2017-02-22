<?php
include './ExpressPHP.Init.php';
$AdminApps = new ForeAPPS();
$module = $_GET['module'];
$action = $_GET['action'];
unset($_GET['module'], $_GET['action']);
$AdminApps->Run($module, $action);
unset($AdminApps);