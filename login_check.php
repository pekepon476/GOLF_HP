<?php
    require_once('./common/pdo.php');
    
    $post=sanitize($_POST);
    $member_id=$post['member_id'];
    $ps=$post['ps'];

    $dbh = pdo();
    $sql = "SELECT id, name, manager_id FROM m_user WHERE member_id = ? AND ps = ?";
    $stmt = $dbh->prepare($sql);
    $data[] = $member_id;
    $data[] = $ps;
    $stmt->execute($data);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;

    if($result == false) {
      header('Location:login.php');
    } else {
      session_start();
      $_SESSION['login']=1;
      $_SESSION['manager_id']=$result[0]['manager_id'];
      $_SESSION['name']=$result[0]['name'];
      header('Location:index.php');
      exit();
    }
?>