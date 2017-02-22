<?php

$LevelArray = array (
	array ('id' => 1, 'name' => '普通代理' ), 
	array ('id' => 2, 'name' => '黄金代理' ), 
	array ('id' => 3, 'name' => '白金代理' ),
	array ('id' => 4, 'name' => '普通代理' ), 
	array ('id' => 5, 'name' => '黄金代理' ), 
	array ('id' => 6, 'name' => '白金代理' ) 
);

function GetInfoByID($ID)
{
	global $LevelArray;
	if (intval($ID)==0)
	return 0;
	foreach ($LevelArray As $Value)
	{
		if ($Value['id']==$ID)
		return $Value;
	}
}

function GetNameByID($ID)
{
	$LevelArray = array (
		array ('id' => 1, 'name' => '普通代理' ), 
		array ('id' => 2, 'name' => '黄金代理' ), 
		array ('id' => 3, 'name' => '白金代理' ),
		array ('id' => 4, 'name' => '普通代理' ), 
		array ('id' => 5, 'name' => '黄金代理' ), 
		array ('id' => 6, 'name' => '白金代理' ) 
	);
	if (intval($ID)==0)
	return 0;
	foreach ($LevelArray As $Value)
	{
		if ($Value['id']==$ID)
		return $Value['name'];
	}
}

