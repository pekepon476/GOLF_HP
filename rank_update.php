<?php
session_start();
session_regenerate_id(true);
if(empty($_SESSION['manager_id'])) {
  header('Location:index.php');
  exit();
}
require_once('./common/pdo.php');
//pdo()メソッドでPDO接続読み込み
$dbh = pdo();
$post=sanitize($_POST);
$user_id=$post['user_id'];
$name=$post['name'];
$event_date=$post['event_date'];
$gross=$post['gross'];
$olympic=$post['olympic'];
$near_pin=$post['near_pin'];
$new_peria=$post['new_peria'];
$putt=$post['putt'];
$birdie=$post['birdie'];
$drive_contest=$post['drive_contest'];
$id = $post['id'];

$sql='UPDATE game_golf SET user_id=?,name=?,event_date=?,gross=?,olympic=?,near_pin=?,new_peria=?,putt=?,birdie=?,drive_contest=? WHERE id=?';
$stmt=$dbh->prepare($sql);
$data[]=$user_id;
$data[]=$name;
$data[]=$event_date;
$data[]=$gross;
$data[]=$olympic;
$data[]=$near_pin;
$data[]=$new_peria;
$data[]=$putt;
$data[]=$birdie;
$data[]=$drive_contest;
$data[]=$id;
$stmt->execute($data);

$dbh=null;

header('Location:rank.php');
exit;
?>