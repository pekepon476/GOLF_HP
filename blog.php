<!doctype html>
<html lang="ja">
<head>
  <title>ブログ</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <style>
    .blog_title {
      background-color: skyblue;
    }
    .content_title {
      border-bottom: 1px solid rgb(234,236,239);
    }
    .create_date {
      font-size: 14px;
      color: silver;
    }
    .img_box {
      height: 200px;
    }
  </style>
</head>
<body>
  <?php
    require_once('./common/pdo.php');
    include (dirname(__FILE__) . '/common/head.php' );
    //pdo()メソッドでPDO接続読み込み
    $dbh = pdo();

    $sql='SELECT * FROM blog';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();

    $dbh=null;
  ?>
  <main>
    <div class="container-fluid px-0">
      <div class="blog_title mt-5 pt-5 mb-4 pb-4 text-center text-white">
        <h1>ブログ</h1>
      </div>
      <div class="text-center pt-3">
        <div>
          <?php if(!empty($_SESSION['manager_id'])) { ?>
            <a class="btn btn-primary" href="../hp/blog_new.php">新規作成</a>
          <?php } ?>
        </div>
      </div>
      <div class="container">
        <div class="py-3 pl-3">
          <a href="../hp/blog.php">全ての記事</a>
        </div>
        <?php 
          while(true) {
            $rec=$stmt->fetch(PDO::FETCH_ASSOC);
            if($rec==false) { break;}
        ?>
          <div class="border rounded mb-5">
            <div class="row">
              <div class="col-md-4 align-items-center">
                <?php if($rec['image']=='') {
                } else { ?>
                  <img class="img_box img-fluid d-block mx-auto" src="./image/<?php print $rec['image'] ?>">
                <?php } ?>
              </div>
              <div class="col-md-8 pt-3">
                <div class="row content_title pl-3">
                  <div class="col-md-9">
                    <h3><a href="../hp/blog_show.php?id=<?php print $rec['id']; ?>"><?php print $rec['title']; ?></a></h3>
                  </div>
                  <div class="col-md-3">
                    <form action="blog_branch.php" method="POST">
                      <input type="hidden" name="id" value="<?php print $rec['id']; ?>">
                      <input type="hidden" name="image" value="<?php print $rec['image']; ?>">
                      <?php if(!empty($_SESSION['manager_id'])) { ?>
                        <input class="btn btn-primary mb-2 mr-2" type="submit" name="edit" value="編集">
                        <input class="btn btn-primary mb-2 mr-2" type="submit" name="delete" value="削除">
                      <?php } ?>
                    </form>
                  </div>
                </div>
                <div class="pt-2 pl-3">
                  <p><?php print substr($rec['content'], 0, 350); ?></p>
                </div>
                <div class="create_date pt-2 pl-3">
                  <p><?php print $rec['create_time']; ?></p>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
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