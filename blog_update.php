<?php
session_start();
session_regenerate_id(true);
if(empty($_SESSION['manager_id'])) {
  header('Location:index.php');
  exit();
}

require_once('./common/pdo.php');


$post=sanitize($_POST);
$user_id=$post['user_id'];
$title=$post['title'];
$content=$post['content'];
$old_image=$post['old_image'];
$image=$_FILES['image'];
$id=$post['id'];

if ($image['name'] != '') {
  move_uploaded_file($image['tmp_name'],'./image/'.$image['name']);
  $image_name=$image['name'];
} else {
  $image_name=$old_image;
}

//pdo()メソッドでPDO接続読み込み
$dbh = pdo();
$sql='UPDATE blog SET user_id=?,title=?,content=?,image=? WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$user_id;
$data[]=$title;
$data[]=$content;
$data[]=$image_name;
$data[]=$id;
$stmt->execute($data);

$dbh=null;

header('Location:blog.php');
exit;
?>