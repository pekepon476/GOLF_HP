<?php
session_start();
session_regenerate_id(true);
if(empty($_SESSION['manager_id'])) {
  header('Location:index.php');
  exit();
}

require_once('./common/pdo.php');
require_once('./common/pdo.php');

if(isset($_POST['edit'])==true) {
	if(isset($_POST['id'])==false) {
		header('Location:blog.php');
		exit();
	}
	$id=$_POST['id'];
	header('Location:blog_edit.php?id='.$id);
	exit();
}

if(isset($_POST['delete'])==true) {
	if(isset($_POST['id'])==false) {
		header('Location:blog.php');
		exit();
  }
  $id = $_POST['id'];
  $image = $_POST['image'];
  $dbh = pdo();

  $sql='DELETE FROM blog WHERE id=?';
  $stmt=$dbh->prepare($sql);
  $data[]=$id;
  $stmt->execute($data);

  $dbh=null;

  header('Location:blog.php');
	exit();
}

?>