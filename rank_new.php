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
  <title>成績追加</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <style>
    body {
      font-family: "ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO";
    }
  </style>
</head>
<body>
  <?php
    require_once('./common/pdo.php');
    //pdo()メソッドでPDO接続読み込み
    $id = $_GET['id'];

    //pdo()メソッドでPDO接続読み込み
    $dbh = pdo();
    $sql = 'SELECT id, name FROM m_user WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh=null;
  ?>
  <?php include (dirname(__FILE__) . '/common/head.php' ); ?>
  <main>
    <div class="container mt-5 pt-5 px-0 w-50">
      <h3>成績登録</h3>
      <br>
      <?php foreach($result as $val) { ?>
        <h4>ユーザーID：<?php print $val['id'] ?></h4>
        <h4>名前：<?php print $val['name'] ?></h4>
      <?php } ?>
      <br>
      <form method="POST" action="rank_create.php">
        <?php foreach($result as $val) { ?>
          <input type="hidden" name="user_id" value="<?php print $val['id'] ?>">
          <input type="hidden" name="name" value="<?php print $val['name'] ?>">
        <?php } ?>
        <div class="form-group">
          <label for="event_date">開催日：</label>
          <input class="form-control" type="date" name="event_date" id="event_date" required>
        </div>
        <div class="form-group">
          <label for="gross">グロス：</label>
          <input class="form-control" type="text" name="gross" id="gross" pattern="\d+(?:\.\d+)?" required>
        </div>
        <div class="form-group">
          <label for="olympic">オリンピック：</label>
          <input class="form-control" type="text" name="olympic" id="olympic" pattern="\d+(?:\.\d+)?" required>
        </div>
        <div class="form-group">
          <label for="near_pin">ニアピン：</label>
          <input class="form-control" type="text" name="near_pin" id="near_pin" pattern="\d+(?:\.\d+)?" required>
        </div>
        <div class="form-group">
          <label for="new_peria">新ペリ：</label>
          <input class="form-control" type="text" name="new_peria" id="new_peria" pattern="\d+(?:\.\d+)?" required>
        </div>
        <div class="form-group">
          <label for="putt">パット：</label>
          <input class="form-control" type="text" name="putt" id="putt" pattern="\d+(?:\.\d+)?" required>
        </div>
        <div class="form-group">
          <label for="birdie">バーディー：</label>
          <input class="form-control" type="text" name="birdie" id="birdie" pattern="\d+(?:\.\d+)?" required>
        </div>
        <div class="form-group">
          <label for="drive_contest">ドラコン：</label>
          <input class="form-control" type="text" name="drive_contest" id="drive_contest" pattern="\d+(?:\.\d+)?" required>
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