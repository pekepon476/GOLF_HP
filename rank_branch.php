<?php
session_start();
session_regenerate_id(true);
if(empty($_SESSION['manager_id'])) {
	header('Location:index.php');
	exit();
}
require_once('./common/pdo.php');

if(isset($_POST['show'])==true) {
	if(isset($_POST['id'])==false)
	{
		header('Location:rank.php');
		exit();
  }
	$id=$_POST['id'];
	header('Location:rank_show.php?id='.$id);
	exit();
}

if(isset($_POST['edit'])==true) {
	if(isset($_POST['id'])==false) {
		header('Location:rank.php');
		exit();
	}
	$id=$_POST['id'];
	header('Location:rank_edit.php?id='.$id);
	exit();
}

if(isset($_POST['delete'])==true) {
	if(isset($_POST['id'])==false) {
		header('Location:rank.php');
		exit();
  }
  $id=$_POST['id'];
  $dbh = pdo();

  $sql='DELETE FROM game_golf WHERE id=?';
  $stmt=$dbh->prepare($sql);
  $data[]=$id;
  $stmt->execute($data);

  $dbh=null;

  header('Location:rank.php');
	exit();
}

?>