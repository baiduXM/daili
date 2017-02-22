<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>代理平台后台</title>
    <link rel="stylesheet" type="text/css" href="Css/reset.css">
    <link rel="stylesheet" type="text/css" href="Css/control.css">
    <link rel="stylesheet" type="text/css" href="Css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="Css/calendar.css">
    <script type="text/javascript" src="Javascripts/jquery1.9.1.min.js"></script>
    <script type="text/javascript" src="Javascripts/control.js"></script>
    <?php 
    	$action = strtolower($MyAction);
    	$model = strtolower($MyModule);
    	echo $model ? is_file('Javascripts/' . $model . '.js') ? '<script type="text/javascript" src="Javascripts/' . $model . '.js"></script>' : '' : '';
    	echo $action ? is_file('Javascripts/page/' . $action . '.js') ? '<script type="text/javascript" src="Javascripts/page/' . $action . '.js"></script>' : '' : '';
    ?>
    <!-- <script src="Javascripts/ncontrolFunction.js"></script> -->
</head>
