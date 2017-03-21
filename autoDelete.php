<?php
ignore_user_abort(true);//关闭浏览器后仍能执行
set_time_limit(0);//取消默认文件执行时间
date_default_timezone_set('PRC');//切换中国时间

include './ExpressPHP.Init.php';

$time=time();
$day=date("Y-m-d",$time);
$dtot=strtotime($day);
$run_time=$dtot+57566;
// $run_time=$dtot+86400;//第一次执行时间
$interval=10;
// $interval=86400;//自动执行间隔

$GbpenApps = new InterfaceApps();
$module = "AutoDelete";
$action = "DeleteCustomer";
if($module=='')
{
    header("HTTP/1.0 500 Internal Server Error");
    exit;
}

if(!file_exists('./cron-run')) exit(); // 防止运行中的程序重复激活，造成服务器奔溃

do {
  $run = include './auto_ctrl.php';
  if($run!==true){break;} //引入一个文件作为开关，让循环可控

  $gmt_time = microtime(true); 
  $loop = isset($loop) && $loop ? $loop : $run_time - $gmt_time; //第一次执行在什么时候。以后每次执行间隔多久

  $loop = $loop > 0 ? $loop : 0;
  if(!$loop) break; // 如果循环的间隔为零，则停止

  sleep($loop); 
  
  //执行动作
  $GbpenApps->Run($module, $action);
  unset($GbpenApps);

  @rmdir('./cron-run'); // 删除cron-run来告诉程序，这个定时任务已经在执行过程中，不能再执行一个新的同样的任务

  $loop = $interval;//第一次执行后，以后的执行间隔

} while(true);

?>