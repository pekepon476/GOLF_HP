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
$image=$_FILES['image'];

move_uploaded_file($image['tmp_name'],'./image/'.$image['name']);
print '<img src="./image/'.$image['name'].'">';
$image_name=$image['name'];

//pdo()メソッドでPDO接続読み込み
$dbh = pdo();
$sql='INSERT INTO blog(user_id,title,content,image) VALUES (?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$user_id;
$data[]=$title;
$data[]=$content;
$data[]=$image_name;
$stmt->execute($data);

$dbh=null;

header('Location:blog.php');
exit;
?>