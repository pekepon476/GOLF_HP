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
$name=$post['name'];
$event_date=$post['event_date'];
$gross=$post['gross'];
$olympic=$post['olympic'];
$near_pin=$post['near_pin'];
$new_peria=$post['new_peria'];
$putt=$post['putt'];
$birdie=$post['birdie'];
$drive_contest=$post['drive_contest'];

//pdo()メソッドでPDO接続読み込み
$dbh = pdo();
$sql='INSERT INTO game_golf(user_id,name,event_date,gross,olympic,near_pin,new_peria,putt,birdie,drive_contest) VALUES (?,?,?,?,?,?,?,?,?,?)';
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
$stmt->execute($data);

$dbh=null;

header('Location:rank.php');
exit;
?>