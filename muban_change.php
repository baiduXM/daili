<?php
$connect=mysql_connect("localhost","root","") or die("error connecting");
mysql_select_db("db_daili2",$connect) or die("error selecting");


$url="./mubans.txt";
$fp=fopen($url,'r');
while(!feof($fp)){
	$result.=fgets($fp,28672);
}
fclose($fp);
//转化成数组，以换行分割
$arr = explode("\n",$result);
foreach($arr as $k=>$v){
	$arr[$k]=split("\t",$v);
	foreach ($v as $n => $c) {
    	$arr[$k][$n]=trim($c);
    }
}
// var_dump($arr[1]);
foreach ($arr as $key => $value) {
	if($key!==0){
		if($value[1]&&$value[0]){
			$sql="update tb_model_packages set PackagesNum_bak = '".trim($value[1])."' where PackagesNum = '".trim($value[0]) . "'";
			// echo $sql."<br/>";
			$result=mysql_query($sql,$connect) or die("error query");
		}
		
	}
		
		

}
