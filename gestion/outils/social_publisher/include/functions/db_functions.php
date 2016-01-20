<?php

function getUsers($criteria=array()) {
	$user_id = $criteria['user_id'];
	$type = $criteria['type'];
	
	$u1 = new MySqlTable();
	$sql = "SELECT * FROM ".$GLOBALS['db_table']['users']." WHERE 1";
	
	if($user_id!='') $sql .= ' AND user_id="'.$u1->escape($user_id).'"';
	if($type!='') $sql .= ' AND type="'.$u1->escape($type).'"';
	
	$sql .= ' ORDER BY id';
	
	$result = $u1->customQuery($sql);
	
	return $result;
}

function getHistory($criteria=array()) {
	$type = $criteria['type'];
	$start = $criteria['start'];
	$nb_display = $criteria['nb_display'];
	
	$u1 = new MySqlTable();
	$sql = "SELECT * FROM ".$GLOBALS['db_table']['history']." WHERE 1";
	
	if($type!='') $sql .= ' AND type="'.$u1->escape($type).'"';
	
	$sql .= ' ORDER BY id DESC';
	
	if($nb_display>0) $sql .= ' LIMIT '.$start.', '.$nb_display;
	
	$result = $u1->customQuery($sql);
	
	return $result;
}

?>