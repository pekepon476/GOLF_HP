<?php 
  session_start();
  session_regenerate_id(true);
  if(empty($_SESSION['manager_id'])) {
    header('Location:index.php');
    exit();
  }
?>
<!doctype html>
<html lang="ja">
<head>
  <title>記事作成</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <style>
    body {
      font-family: "ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO";
    }
    .content_box {
      height: 380px;
    }
  </style>
</head>
<body>
  <?php
    require_once('./common/pdo.php');
    //pdo()メソッドでPDO接続読み込み
    $dbh = pdo();
  ?>
  <?php include (dirname(__FILE__) . '/common/head.php' ); ?>
  <main>
    <div class="container mt-5 pt-5 w-50 px-0">
      <h3>記事作成</h3>
      <form method="POST" action="blog_create.php" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="1">
        <div class="form-group">
          <label for="title">タイトル：</label>
          <input class="form-control" type="text" name="title" id="title" required>
        </div>
        <div class="form-group">
          <label for="content">内容：</label>
          <textarea class="form-control content_box" type="text" name="content" id="content" required></textarea>
        </div>
        <div class="form-group">
          <label for="image">添付画像：</label></br>
          <input type="file" name="image" id="image" style="font-size: 10px;">
        </div>
        <input class="btn btn-primary" type="submit" value="送信">
      </form>
    </div>
    
    
  </main>
  <?php include (dirname(__FILE__) . '/common/foot.html' ); ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>