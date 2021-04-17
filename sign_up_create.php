<?php
    require_once('./common/pdo.php');

    $post=sanitize($_POST);
    $name=$post['name'];
    $member_id=$post['member_id'];
    $ps=$post['ps'];
    $manager_id=$post['manager_id'];


    $dbh = pdo();
    // $sql = "SELECT member_id FROM m_user";
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // foreach ($result as $data) {
    //   if ($data['member_id'] == 123) {
    //     var_dump('ご希望の会員IDは既に利用されています');
    //     return;
    //   }
    // }
    $sql = "INSERT INTO m_user (name, member_id, ps, manager_id) VALUE (?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $data[]=$name;
    $data[]=$member_id;
    $data[]=$ps;
    $data[]=$manager_id;
    $stmt->execute($data);
    $dbh = null;
    
    session_start();
    $_SESSION['login']=1;
    $_SESSION['manager_id']=$manager_id;
    $_SESSION['name']=$name;
    header('Location:index.php');
    exit();
    // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>