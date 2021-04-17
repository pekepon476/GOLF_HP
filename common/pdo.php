<?php

// HTMLエスケープの処理
function sanitize($before)
{
	foreach($before as $key=>$value)
	{
		$after[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
	}
	return $after;
}

// PDO接続メソッド
function pdo() {
	$dsn='mysql:dbname=azurelizard6_golf;host=mysql57.azurelizard6.sakura.ne.jp;charset=utf8';
  $user='azurelizard6';
  $password='tadashi476';
	$dbh=new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

?>