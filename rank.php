<!doctype html>
<html lang="ja">
<head>
  <title>順位</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <style>
    body {
      font-family: "ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO";
    }
    .rank_title {
      background-color: skyblue;
    }

  </style>
</head>
<body>
  <?php
    require_once('./common/pdo.php');
    include (dirname(__FILE__) . '/common/head.php' );
  ?>
  <main>
  <div class="container-fluid px-0">
    <div class="rank_title mt-5 pt-5 mb-4 pb-4 text-center text-white">
      <h1>順位</h1>
    </div>
  </div>
  <?php
    //pdo()メソッドでPDO接続読み込み
    // 年ごとの平均を求める
    $dbh = pdo();

    $sql = 'SELECT user_id FROM game_golf';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while(true) { 
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if($rec == false) {break;}
      $user_id_box[] = $rec['user_id'];
    }
    if (!empty($user_id_box)) {
      $user_id_box = array_unique($user_id_box);
      $user_id_count = count($user_id_box);
    }

    // セレクトボックスで選択された値を受け取る
    if(isset($_POST["year"])) {
      $year = $_POST["year"];
      $year_first = strval($year) . "-01-01";
      $year_end = strval($year) . "-12-31";
    } else {
      $year = date('Y');
      $year_first = strval($year) . "-01-01";
      $year_end = strval($year) . "-12-31";
    }
    
    $sql = 'SELECT DISTINCT user_id FROM game_golf WHERE event_date BETWEEN ? AND ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $year_first;
    $data[] = $year_end;
    $stmt->execute($data);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    $row = [];
    $handicapId = 3;
    $grossHandicap = 40;
    $olympicHandicap = 5;
    $puttHandicap = 4;

    if ($result) {
      foreach ($result as $data) {
        $sql = 'SELECT user_id, name, gross, olympic, near_pin, new_peria, putt, birdie, drive_contest, event_date
              FROM game_golf WHERE user_id = ? AND event_date BETWEEN ? AND ?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute([$data['user_id'], $year_first, $year_end]);
      $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        foreach ($userData as $rec) {
          $userId[] = $rec['user_id'];
          $name[] = $rec['name'];
          $gross_box[] = $rec['gross'];
          $olympic_box[] = $rec['olympic'];
          $near_pin_box[] = $rec['near_pin'];
          $new_peria_box[] = $rec['new_peria'];
          $putt_box[] = $rec['putt'];
          $birdie_box[] = $rec['birdie'];
          $drive_contest_box[] = $rec['drive_contest'];
        }
      
      $gross_sum[$i] = array_sum($gross_box);
      $olympic_sum[$i] = array_sum($olympic_box);
      $near_pin_sum[$i] = array_sum($near_pin_box);
      $new_peria_sum[$i] = array_sum($new_peria_box);
      $putt_sum[$i] = array_sum($putt_box);
      $birdie_sum[$i] = array_sum($birdie_box);
      $drive_contest_sum[$i] = array_sum($drive_contest_box);
      
      $gross_avg[$i] = $gross_sum[$i] / count($gross_box);
      $olympic_avg[$i] = $olympic_sum[$i] / count($olympic_box);
      $near_pin_avg[$i] = $near_pin_sum[$i] / count($near_pin_box);
      $new_peria_avg[$i] = $new_peria_sum[$i] / count($new_peria_box);
      $putt_avg[$i] = $putt_sum[$i] / count($putt_box);
      $birdie_avg[$i] = $birdie_sum[$i] / count($birdie_box);
      $drive_contest_avg[$i] = $drive_contest_sum[$i] / count($drive_contest_box);

      

      if ($userId[0] == $handicapId) {
        $specialGross   = $gross_avg[$i];
        $specialOlympic = $olympic_avg[$i];
        $specialPutt    = $putt_avg[$i];

        $gross_avg[$i]   = $gross_avg[$i] - $grossHandicap;
        $olympic_avg[$i] = $olympic_avg[$i] + $olympicHandicap;
        $putt_avg[$i]    = $putt_avg[$i] - $puttHandicap;
      }

      $row[] = [
        'user_id'             => array_values($userId)[0],
        'name'                => array_values($name)[0],
        'gross'               => $gross_avg[$i],
        'olympic'             => $olympic_avg[$i],
        'near_pin'            => $near_pin_avg[$i],
        'new_peria'           => $new_peria_avg[$i],
        'putt'                => $putt_avg[$i],
        'birdie'              => $birdie_avg[$i],
        'drive_contest'       => $drive_contest_avg[$i]
      ];
      
      $i++;
      
      unset($userId, $name, $gross_box, $olympic_box, $near_pin_box, $new_peria_box, $putt_box, $birdie_box, $drive_contest_box);
    }

    // グロスの並べ替え
    foreach ($row as $key => $value) {
      $gross[$key] = $value['gross'];
    }
    
    array_multisort($gross, SORT_ASC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for ($i = 0; $i < count($row); ++$i) {
      // 前回と同順位の場合は、点数も同じ
      if ($bef_point != $gross[$i]) {
        $rank = $cnt;
      }
      $row[$i]['gross_point'] = $rank;
      $bef_point = $gross[$i];
      $cnt--;
    }
    
    // オリンピックの並び替え
    foreach ($row as $key => $value) {
      $olympic[$key] = $value['olympic'];
    }

    array_multisort($olympic, SORT_DESC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for($i = 0; $i < count($row); ++$i) {
      // 前回と同順位の場合は、点数も同じ
      if ($bef_point != $olympic[$i]) {
        $rank = $cnt;
      }
      $row[$i]['olympic_point'] = $rank;
      $bef_point = $olympic[$i];
      $cnt--;
    }
    
    // ニアピンの並び替え
    foreach ($row as $key => $value) {
      $near_pin[$key] = $value['near_pin'];
    }

    array_multisort($near_pin, SORT_DESC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for($i = 0; $i < count($row); ++$i) {
      if ($bef_point != $near_pin[$i]) {
        $rank = $cnt;
      }
      $row[$i]['near_pin_point'] = $rank;
      $bef_point = $near_pin[$i];
      $cnt--;
    }
    
    // 新ペリの並び替え
    foreach ($row as $key => $value) {
      $new_peria[$key] = $value['new_peria'];
    }

    array_multisort($new_peria, SORT_ASC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for($i = 0; $i < count($row); ++$i) {
      if ($bef_point != $new_peria[$i]) {
        $rank = $cnt;
      }
      $row[$i]['new_peria_point'] = $rank;
      $bef_point = $new_peria[$i];
      $cnt--;
    }
    
    // パット数の並び替え
    foreach ($row as $key => $value) {
      $putt[$key] = $value['putt'];
    }

    array_multisort($putt, SORT_ASC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for($i = 0; $i < count($row); ++$i) {
      if ($bef_point != $putt[$i]) {
        $rank = $cnt;
      }
      $row[$i]['putt_point'] = $rank;
      $bef_point = $putt[$i];
      $cnt--;
    }
    
    // バーディーの小さい順に並び替え
    foreach ($row as $key => $value) {
      $birdie[$key] = $value['birdie'];
    }

    array_multisort($birdie, SORT_DESC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for($i = 0; $i < count($row); ++$i) {
      if ($bef_point != $birdie[$i]) {
        $rank = $cnt;
      }
      if ($birdie[$i] == 0) {
        $rank = 0;
      }
      $row[$i]['birdie_point'] = $rank;
      $bef_point = $birdie[$i];
      $cnt--;
    }
    
    // ドラコンの並び替え
    foreach ($row as $key => $value) {
      $drive_contest[$key] = $value['drive_contest'];
    }

    array_multisort($drive_contest, SORT_DESC, $row);

    $cnt = count($row);
    $bef_point = 0;

    for($i = 0; $i < count($row); ++$i) {
      if ($bef_point != $drive_contest[$i]) {
        $rank = $cnt;
      } 
      if ($drive_contest[$i] == 0) {
        $rank = 0;
      }
      $row[$i]['drive_contest_point'] = $rank;
      $bef_point = $drive_contest[$i];
      $cnt--;
    }
    
    // 合計
    for($i = 0; $i < count($row); ++$i) {
      $row[$i]['total_point'] = $row[$i]['gross_point'] + $row[$i]['olympic_point'] + $row[$i]['near_pin_point'] + $row[$i]['new_peria_point'] + $row[$i]['putt_point'] + $row[$i]['birdie_point'] +$row[$i]['drive_contest_point'];
    }
    // 合計順に並び替え
    foreach ($row as $key => $value) {
      $total_point[$key] = $value['total_point'];
    }
    array_multisort($total_point, SORT_DESC, $row);
  }
    ?>
  <div class="container px-0">
    <div class="text-center pt-3">
      <div>
        <?php if(!empty($_SESSION['manager_id'])) { ?>
          <a class="btn btn-primary" href="../hp/rank_new_select.php">成績登録</a>
        <?php } ?>
      </div>
      <div class="pt-3">
        <form action="rank.php" method = "POST">
          <select name="year" onchange="submit(this.form)">
            <?php
              for($i = date('Y'); $i > 2015; $i--) {?>
                <?php if ($i == $year) { ?>
                  <option value="<?php print $i ?>" selected><?php print $i ?></option>
                <?php } else {?>
                  <option value="<?php print $i ?>"><?php print $i ?></option>
                <?php } ?>
            <?php } ?>
          </select>
        </form>
      </div>
    </div>
    <div class="rank_table">
      <h2 class="text-center mt-5"><?php print $year ?>年順位表</h2>
      <h2 class="text-center">(点数合計)</h2>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">名前</th>
            <th scope="col">点数</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($row as $index => $val) { ?>
          <tr>
            <th scope="row"><?php print $index+1 ?>位</th>
            <td><?php print $val['name'] ?></td>
            <td><?php print $val['total_point'] ?>点</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <!-- PC -->
    <div class="rank_table d-md-block d-none">
      <h2 class="text-center mt-5"><?php print $year ?>年間平均</h2>
      <table class="table table-bordered">
        <tbody>
        <tr>
          <th scope="row">名前</th>
          <?php foreach ($row as $val) { ?>
            <td><?php print $val['name'] ?></td>
            <td>点数</td>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">グロス</th>
          <?php foreach ($row as $index => $val) { ?>
            <?php if ($val['user_id'] == $handicapId) {?>
              <td>
                <?php print rtrim(rtrim(number_format($val['gross'], 1),'0'),'.') ?>
                <?php print '('.rtrim(rtrim(number_format($specialGross, 1),'0'),'.').')' ?>
              </td>
              <td><?php print $val['gross_point'] ?>点</td>
            <?php } else { ?>
              <td><?php print rtrim(rtrim(number_format($val['gross'], 1),'0'),'.') ?></td>
              <td><?php print $val['gross_point'] ?>点</td>
            <?php } ?>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">オリンピック</th>
          <?php foreach ($row as $index => $val) { ?>
            <?php if ($val['user_id'] == $handicapId) {?>
              <td>
                <?php print rtrim(rtrim(number_format($val['olympic'], 1),'0'),'.') ?>
                <?php print '('.rtrim(rtrim(number_format($specialOlympic, 1),'0'),'.').')' ?>
              </td>
              <td><?php print $val['olympic_point'] ?>点</td>
            <?php } else { ?>
              <td><?php print rtrim(rtrim(number_format($val['olympic'], 1),'0'),'.') ?></td>
              <td><?php print $val['olympic_point'] ?>点</td>
            <?php } ?>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">ニアピン</th>
          <?php foreach ($row as $val) { ?>
            <td><?php print rtrim(rtrim(number_format($val['near_pin'], 1),'0'),'.') ?></td>
            <td><?php print $val['near_pin_point'] ?>点</td>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">新ペリ</th>
          <?php foreach ($row as $val) { ?>
            <td><?php print rtrim(rtrim(number_format($val['new_peria'], 1),'0'),'.') ?></td>
            <td><?php print $val['new_peria_point'] ?>点</td>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">パット数</th>
          <?php foreach ($row as $val) { ?>
            <?php if ($val['user_id'] == $handicapId) {?>
              <td>
                <?php print rtrim(rtrim(number_format($val['putt'], 1),'0'),'.') ?>
                <?php print '('.rtrim(rtrim(number_format($specialPutt, 1),'0'),'.').')' ?>
              </td>
              <td><?php print $val['putt_point'] ?>点</td>
            <?php } else { ?>
              <td><?php print rtrim(rtrim(number_format($val['putt'], 1),'0'),'.') ?></td>
              <td><?php print $val['putt_point'] ?>点</td>
            <?php } ?>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">バーディー</th>
          <?php foreach ($row as $val) { ?>
            <td><?php print rtrim(rtrim(number_format($val['birdie'], 1),'0'),'.') ?></td>
            <td><?php print $val['birdie_point'] ?>点</td>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">ドラコン</th>
          <?php foreach ($row as $val) { ?>
            <td><?php print rtrim(rtrim(number_format($val['drive_contest'], 1),'0'),'.') ?></td>
            <td><?php print $val['drive_contest_point'] ?>点</td>
          <?php } ?>
        </tr>
        <tr>
          <th scope="row">合計</th>
          <?php foreach ($row as $val) { ?>
            <td></td>
            <td><?php print $val['total_point'] ?>点</td>
          <?php } ?>
        </tr>
        </tbody>
      </table>
      <!-- <table class="table table-bordered">
        <tbody>
          <tr>
            <th scope="row">名前</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['name'] ?></td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">グロス</th>
            <?php foreach ($row as $index => $val) { ?>
              <td><?php print $val['gross'] ?>→<?php print $val['gross_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">オリンピック</th>
            <?php foreach ($row as $index => $val) { ?>
              <td><?php print $val['olympic'] ?>→<?php print $val['olympic_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">ニアピン</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['near_pin'] ?>→<?php print $val['near_pin_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">新ペリ</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['new_peria'] ?>→<?php print $val['new_peria_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">パット数</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['putt'] ?>→<?php print $val['putt_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">バーディー</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['birdie'] ?>→<?php print $val['birdie_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">ドラコン</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['drive_contest'] ?>→<?php print $val['drive_contest_point'] ?>点</td>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">合計</th>
            <?php foreach ($row as $val) { ?>
              <td><?php print $val['total_point'] ?>点</td>
            <?php } ?>
          </tr>
        </tbody>
      </table> -->
    </div>
    <?php 
        // 開催日の日程を取得
        $sql = 'SELECT DISTINCT event_date FROM game_golf WHERE event_date BETWEEN ? AND ?';
        $stmt = $dbh->prepare($sql);
        $data[] = $year_first;
        $data[] = $year_end;
        $stmt->execute([$year_first, $year_end]);
        $eventDate = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows = [];
        $userId = 3;
        $grossHandicap = 40;
        $olympicHandicap = 5;
        $puttHandicap = 4;

        // 日程が同じものは同じ配列に
        foreach ($eventDate as $data) {
            $sql = 'SELECT id, user_id, name, gross, olympic, near_pin, new_peria, putt, birdie, drive_contest, event_date 
                    FROM game_golf WHERE event_date = ?';

            $stmt = $dbh->prepare($sql);
            $stmt->execute([$data['event_date']]);
            $rows[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    ?>
    <div class="rank_table d-md-block d-none">
      <h2 class="text-center mt-5"><?php print $year ?>年</h2>
      <h2 class="text-center">開催日ごとの成績</h2>
      <?php foreach ($rows as $data) { ?>
      <h4 class="text-center mt-4">開催日：<?php print $data[0]['event_date'] ?></h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">名前</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <th>
                <?php print $data[$i]['name'] ?>
                <form action="rank_branch.php" method="POST">
                  <?php if(!empty($_SESSION['manager_id'])) { ?>
                    <input type="hidden" name="id" value="<?php print $data[$i]['id']; ?>">
                    <input class="btn btn-primary" type="submit" name="edit" value="編集">
                    <input class="btn btn-primary delete" id="delete" type="submit" name="delete" value="削除">
                  <?php } ?>
                </form>
              </th>
            <?php } ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">グロス</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <?php if ($data[$i]['user_id'] == $handicapId) {?>
                <?php $gross = $data[$i]['gross'] - $grossHandicap ?>
                <th>
                  <?php print rtrim(rtrim(number_format($gross, 1),'0'),'.') ?>
                  <?php print '('.rtrim(rtrim(number_format($data[$i]['gross'], 1),'0'),'.').')' ?>
                </th>
              <?php } else { ?>
                <th><?php print rtrim(rtrim(number_format($data[$i]['gross'], 1),'0'),'.') ?></th>
              <?php } ?>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">オリンピック</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <?php if ($data[$i]['user_id'] == $handicapId) {?>
                <?php $olympic = $data[$i]['olympic'] + $olympicHandicap ?>
                <th>
                  <?php print rtrim(rtrim(number_format($olympic, 1),'0'),'.') ?> 
                  <?php print '('.rtrim(rtrim(number_format($data[$i]['olympic'], 1),'0'),'.').')' ?>
                </th>
              <?php } else { ?>
                <th><?php print rtrim(rtrim(number_format($data[$i]['olympic'], 1),'0'),'.') ?></th>
              <?php } ?>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">ニアピン</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <th><?php print rtrim(rtrim(number_format($data[$i]['near_pin'], 1),'0'),'.') ?></th>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">新ペリ</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <th><?php print rtrim(rtrim(number_format($data[$i]['new_peria'], 1),'0'),'.') ?></th>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">パット数</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <?php if ($data[$i]['user_id'] == $handicapId) {?>
                <?php $putt = $data[$i]['putt'] - $puttHandicap ?>
                <th>
                  <?php print '('.rtrim(rtrim(number_format($putt, 1),'0'),'.').')' ?>
                  <?php print rtrim(rtrim(number_format($data[$i]['putt'], 1),'0'),'.') ?>
                </th>
              <?php } else { ?>
                <th><?php print rtrim(rtrim(number_format($data[$i]['putt'], 1),'0'),'.') ?></th>
              <?php } ?>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">バーディー</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <th><?php print rtrim(rtrim(number_format($data[$i]['birdie'], 1),'0'),'.') ?></th>
            <?php } ?>
          </tr>
          <tr>
            <th scope="row">ドラコン</th>
            <?php for ($i = 0; $i < count($data) ; $i++) { ?>
              <th><?php print rtrim(rtrim(number_format($data[$i]['drive_contest'], 1),'0'),'.') ?></th>
            <?php } ?>
          </tr>
        </tbody>
      </table>
      <?php } ?>
    </div>
  <!-- SP -->
  <div class="container px-0 d-sm-none">
    <h2 class="text-center mt-5"><?php print $year ?>年間平均</h2>
    <?php for ($i = 0; $i < count($row); $i++) { ?>
    <table class="table table-bordered">
      <tbody>
      <tr>
        <th scope="row">名前</th>
        <td><?php print $row[$i]['name'] ?></td>
        <td>点数</td>
      </tr>
      <tr>
        <th scope="row">グロス</th>
          <?php if ($row[$i]['user_id'] == $handicapId) {?>
            <th>
              <?php print rtrim(rtrim(number_format($row[$i]['gross'], 1),'0'),'.') ?>
              <?php print '('.rtrim(rtrim(number_format($specialGross, 1),'0'),'.').')' ?>
            </th>
            <td><?php print $row[$i]['gross_point'] ?>点</td>
          <?php } else { ?>
            <th><?php print rtrim(rtrim(number_format($row[$i]['gross'], 1),'0'),'.') ?></th>
            <td><?php print $row[$i]['gross_point'] ?>点</td>
          <?php } ?>
      </tr>
      <tr>
        <th scope="row">オリンピック</th>
          <?php if ($row[$i]['user_id'] == $handicapId) {?>
            <th>
              <?php print rtrim(rtrim(number_format($row[$i]['olympic'], 1),'0'),'.') ?>
              <?php print '('.rtrim(rtrim(number_format($specialOlympic, 1),'0'),'.').')' ?>   
            </th>
            <td><?php print $row[$i]['olympic_point'] ?>点</td>
          <?php } else { ?>
            <th><?php print rtrim(rtrim(number_format($row[$i]['olympic'], 1),'0'),'.') ?></th>
            <td><?php print $row[$i]['olympic_point'] ?>点</td>
          <?php } ?>
      </tr>
      <tr>
        <th scope="row">ニアピン</th>
        <td><?php print rtrim(rtrim(number_format($row[$i]['near_pin'], 1),'0'),'.') ?></td>
        <td><?php print $row[$i]['near_pin_point'] ?>点</td>
      </tr>
      <tr>
        <th scope="row">新ペリ</th>
        <td><?php print rtrim(rtrim(number_format($row[$i]['new_peria'], 1),'0'),'.') ?></td>
        <td><?php print $row[$i]['new_peria_point'] ?>点</td>
      </tr>
      <tr>
        <th scope="row">パット数</th>
          <?php if ($row[$i]['user_id'] == $handicapId) {?>
            <th>
              <?php print rtrim(rtrim(number_format($row[$i]['putt'], 1),'0'),'.') ?>
              <?php print '('.rtrim(rtrim(number_format($specialPutt, 1),'0'),'.').')' ?>   
            </th>
            <td><?php print $row[$i]['putt_point'] ?>点</td>
          <?php } else { ?>
            <th><?php print rtrim(rtrim(number_format($row[$i]['putt'], 1),'0'),'.') ?></th>
            <td><?php print $row[$i]['putt_point'] ?>点</td>
          <?php } ?>
      </tr>
      <tr>
        <th scope="row">バーディー</th>
        <td><?php print rtrim(rtrim(number_format($row[$i]['birdie'], 1),'0'),'.') ?></td>
        <td><?php print $row[$i]['birdie_point'] ?>点</td>
      </tr>
      <tr>
        <th scope="row">ドラコン</th>
        <td><?php print rtrim(rtrim(number_format($row[$i]['drive_contest'], 1),'0'),'.') ?></td>
        <td><?php print $row[$i]['drive_contest_point'] ?>点</td>
      </tr>
      <tr>
        <th scope="row">合計</th>
        <td></td>
        <td><?php print $row[$i]['total_point'] ?>点</td>
      </tr>
      </tbody>
    </table>
    <?php } ?>
    <h2 class="text-center mt-5"><?php print $year ?>年</h2>
    <h2 class="text-center">開催日ごとの成績</h2>
    <?php foreach ($rows as $data) { ?>
      <h4 class="text-center mt-4">開催日：<?php print $data[0]['event_date'] ?></h4>
      <?php for ($i = 0; $i < count($data) ; $i++) { ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">名前</th>
              <th>
                <?php print $data[$i]['name'] ?>
                <form action="rank_branch.php" method="POST">
                  <?php if(!empty($_SESSION['manager_id'])) { ?>
                    <input type="hidden" name="id" value="<?php print $data[$i]['id']; ?>">
                    <input class="btn btn-primary" type="submit" name="edit" value="編集">
                    <input class="btn btn-primary delete" type="submit" name="delete" value="削除">
                  <?php } ?>
                </form>
              </th>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">グロス</th>
              <?php if ($data[$i]['user_id'] == $handicapId) {?>
                <?php $gross = $data[$i]['gross'] - $grossHandicap ?>
                <th><?php print rtrim(rtrim(number_format($data[$i]['gross'], 1),'0'),'.') ?>
                  <?php print '('.rtrim(rtrim(number_format($gross, 1),'0'),'.').')' ?>   
                </th>
              <?php } else { ?>
                <th><?php print rtrim(rtrim(number_format($data[$i]['gross'], 1),'0'),'.') ?></th>
              <?php } ?>
          </tr>
          <tr>
            <th scope="row">オリンピック</th>
              <?php if ($data[$i]['user_id'] == $handicapId) {?>
                <?php $olympic = $data[$i]['olympic'] + $olympicHandicap ?>
                <th><?php print rtrim(rtrim(number_format($olympic, 1),'0'),'.') ?> 
                  <?php print '('.rtrim(rtrim(number_format($data[$i]['olympic'], 1),'0'),'.').')' ?>
                </th>
              <?php } else { ?>
                <th><?php print rtrim(rtrim(number_format($data[$i]['olympic'], 1),'0'),'.') ?></th>
              <?php } ?>
          </tr>
          <tr>
            <th scope="row">ニアピン</th>
              <th><?php print rtrim(rtrim(number_format($data[$i]['near_pin'], 1),'0'),'.') ?></th>
          </tr>
          <tr>
            <th scope="row">新ペリ</th>
              <th><?php print rtrim(rtrim(number_format($data[$i]['new_peria'], 1),'0'),'.') ?></th>
          </tr>
          <tr>
            <th scope="row">パット数</th>
              <?php if ($data[$i]['user_id'] == $handicapId) {?>
                <?php $putt = $data[$i]['putt'] - $puttHandicap ?>
                <th>
                  <?php print '('.rtrim(rtrim(number_format($putt, 1),'0'),'.').')' ?>
                  <?php print rtrim(rtrim(number_format($data[$i]['putt'], 1),'0'),'.') ?>
                </th>
              <?php } else { ?>
              <th><?php print rtrim(rtrim(number_format($data[$i]['putt'], 1),'0'),'.') ?></th>
              <?php } ?>
          </tr>
          <tr>
            <th scope="row">バーディー</th>
              <th><?php print rtrim(rtrim(number_format($data[$i]['birdie'], 1),'0'),'.') ?></th>
          </tr>
          <tr>
            <th scope="row">ドラコン</th>
              <th><?php print rtrim(rtrim(number_format($data[$i]['drive_contest'], 1),'0'),'.') ?></th>
          </tr>
        </tbody>
      </table>
      <?php } ?>
    <?php } ?>
  </div>
  </main>
  <?php include (dirname(__FILE__) . '/common/foot.html' ); ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script>
    $('.delete').click(function() {
      if(!confirm('本当に削除しますか？')) {
        return false;
      }
    });
  </script>
</body>
</html>