<?php
ignore_user_abort(true);//�ر������������ִ��
set_time_limit(0);//ȡ��Ĭ���ļ�ִ��ʱ��
date_default_timezone_set('PRC');//�л��й�ʱ��

include './ExpressPHP.Init.php';

$time=time();
$day=date("Y-m-d",$time);
$dtot=strtotime($day);
$run_time=$dtot+57566;
// $run_time=$dtot+86400;//��һ��ִ��ʱ��
$interval=10;
// $interval=86400;//�Զ�ִ�м��

$GbpenApps = new InterfaceApps();
$module = "AutoDelete";
$action = "DeleteCustomer";
if($module=='')
{
    header("HTTP/1.0 500 Internal Server Error");
    exit;
}

if(!file_exists('./cron-run')) exit(); // ��ֹ�����еĳ����ظ������ɷ���������

do {
  $run = include './auto_ctrl.php';
  if($run!==true){break;} //����һ���ļ���Ϊ���أ���ѭ���ɿ�

  $gmt_time = microtime(true); 
  $loop = isset($loop) && $loop ? $loop : $run_time - $gmt_time; //��һ��ִ����ʲôʱ���Ժ�ÿ��ִ�м�����

  $loop = $loop > 0 ? $loop : 0;
  if(!$loop) break; // ���ѭ���ļ��Ϊ�㣬��ֹͣ

  sleep($loop); 
  
  //ִ�ж���
  $GbpenApps->Run($module, $action);
  unset($GbpenApps);

  @rmdir('./cron-run'); // ɾ��cron-run�����߳��������ʱ�����Ѿ���ִ�й����У�������ִ��һ���µ�ͬ��������

  $loop = $interval;//��һ��ִ�к��Ժ��ִ�м��

} while(true);

?>