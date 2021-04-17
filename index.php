<!doctype html>
<html lang="ja">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="google-site-verification" content="upxH57tCLAeg_kRaIkH_Q2zRMqn_IsWUhd_oVhlcnWk" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>ホーム | IGC</title>
<style>
body {
  font-family: "ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO";
}

@media screen and (max-width:480px) { 
  /*画面サイズが480px以下はここを読み込む*/
  .title {
    font-size: 25px;
  }
  .sub_title {
    font-size: 20px;
  }
  .summary {
    font-size: 25px;
  }
  .summary2 {
    font-size: 14px;
  }
  .message {
    font-size: 18px;
    text-align: left;
  }
  .sub_message {
    font-size: 14px;
    text-align: left;
  }
  .main1 {
    margin-top: 35px;
    background: url(./img/top_img1.jpg);
    background-size: 100% 100%;
    height: 270px;
  }
}

@media screen and (min-width:481px) and (max-width:650px) {
  .main1 {
    margin-top: 35px;
    background: url(./img/top_img1.jpg);
    background-size: 100% 100%;
    height: 300px;
  }
  .title {
    font-size: 25px;
  }
  .sub_title {
    font-size: 20px;
  }
  .summary {
    font-size: 25px;
  }
  .summary2 {
    font-size: 14px;
  }
  .message {
    font-size: 18px;
    text-align: left;
  }
  .sub_message {
    font-size: 14px;
    text-align: left;
  }
}
@media screen and (min-width:651px) and (max-width:1300px) {
  .title {
    font-size: 50px;
  }
  .sub_title {
    font-size: 35px;
  }
  .main1 {
    margin-top: 20px;
    background: url(./img/top_img1.jpg);
    background-size: 100% 100%;
    height: 600px;
  }
}
@media screen and (min-width:1301px) {
  .main1 {
    margin-top: 20px;
    background: url(./img/top_img1.jpg);
    background-size: cover;
    height: 800px;
  }
}

.main1 {
  display: flex;
  justify-content: center;
  align-items: center;
}

.main1_box {
  background: rgb(255, 255, 255, 0.4);
}

.title {
  font-weight: bold;
}


.main2 {
  height: 350px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.main2_box {
  max-width: 900px;
}

.main3 {
  background: url(./img/top_img2.jpg);
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  height: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.main3_box {
  max-width: 900px;
}

.contact {
  background-color: rgb(235, 235, 235);
}
.gm {
  background-color: rgb(235, 235, 235);
}

.text_box{
  display: flex;
  justify-content: center;
  align-items: center;
}

#target {
  margin: 0 auto;
  max-width: 1200px;
  height: 400px;
}
</style>
</head>
<body>
  <?php include (dirname(__FILE__) . '/common/head.php' ); ?>
  <main>
    <section>
      <div class="main1">
        <div class="main1_box text-center p-2">
          <u><h1 class="title display-3">IGC〜板橋ゴルフ倶楽部〜</h1></u>
          <h2 class="sub_title">〜遊ぶならとことん本気で！〜</h2>
        </div>
      </div>
    </section>
    <section>
      <div class="main2">
        <div class="main2_box p-2">
          <h1><p class="summary">概要</p></h1>
          <p class="summary2">「遊ぶならとことん本気で!」をモットーに</p>
          <p class="summary2">
            遊びは遊びだがやるならとことん本気でやってみよう！そう考えたのがこの4人です。<br>
            この4人はそれぞれ小中学校からの同級生グループ。<br>
            木村はバスケ出身、その他3人は野球部出身の4人がゴルフというスポーツにハマってしまいました。<br>
            そんな4人による、「年間チャンピオン」を手にするための負けられない戦いをお楽しみください！<br>
          </p>
        </div>
      </div>
    </section>
    <div class="main3 text-white">
      <div class="main3_box text-center p-2">
        <h2 class="message">ゴルフを通じて様々な人とつながりを</h2>
          <p class="sub_message">
            今は4人からのスタートですが、ゴルフを通じて様々な人とつながっていけたら嬉しいです！<br>
            ゆくゆくは一緒にコースを回ったりコミュニティを広げていけたらと思っています。<br>
            初心者の方からアドバイスを頂ける方までお気軽にご連絡ください！
          </p>
      </div>
    </div>
    <div class="contact">
      <div class="container py-5">
        <div class="row">
          <div class="text_box text-center col-sm-6">
            <div>
              <h1 class="contact_title">お問い合わせ</h1>
              <p class="contact_address">東京都板橋区高島平</p>
              <p class="contact_mail">rt.bbp.0214@outlook.jp</p>
            </div>
          </div>
          <div class="text_box text-center col-sm-6">
            <div id="googleform">
              <form action="https://docs.google.com/forms/u/0/d/e/1FAIpQLScHYNTb8ArGshHAS1ZwR5VsQM_je0S8ZOf13gkFPvuVTVo8vg/formResponse" method="POST" id="mG61Hd" jsmodel="TOfxwf Q91hve" data-response="%.@.[]]" data-first-entry="0" data-last-entry="6" data-is-first-page="true" target="hidden_iframe" onsubmit="submitted=true;">
                <div class="form-group">
                  <label for="name"></label>
                  <input class="form-control" type="text" name="entry.1881024529" id="name" placeholder="名前" required>
                  <label for="address"></label>
                  <input class="form-control" type="text" name="entry.1892215667" id="address" placeholder="住所">
                  <label for="mail"></label>
                  <input class="form-control" type="text" name="entry.611545403" id="mail" placeholder="メールアドレス" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                  <label for="tell"></label>
                  <input class="form-control" type="text" name="entry.162005762" id="tell" placeholder="電話番号">
                  <label for="title"></label>
                  <input class="form-control" type="text" name="entry.590331870" id="title" placeholder="件名">
                  <label for="message"></label>
                  <textarea class="form-control" type="textarea" name="entry.752155850" id="message" placeholder="メッセージ"></textarea>
                </div>
                <div class="pt-2"><input class="btn btn-primary" type="submit" value="送信"></div>
              </form>
              <script type="text/javascript">var submitted = false;</script>
              <iframe name="hidden_iframe" id="hidden_iframe" style="display:none;" onload="if(submitted){window.location='index.php';}"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="gm p-4">
      <div id="target"></div>
      <div id="info">
        東京都板橋区高島平<br>
        <a href="https://www.google.com/maps/dir/35.652772,139.6605155/%E9%AB%98%E5%B3%B6%E5%B9%B3%E3%80%81%E3%80%92175-0082+%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%9D%BF%E6%A9%8B%E5%8C%BA/@35.7841839,139.6548883,14z/data=!4m9!4m8!1m1!4e1!1m5!1m1!1s0x6018ec82e97ff6a3:0xc1518105874ae32c!2m2!1d139.6579635!2d35.786996" target="_blank" rel="noopener noreferrer">詳細</a>
      </div>
    </div>
  </main>
  <?php include (dirname(__FILE__) . '/common/foot.html' ); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBBq4vVN1xvCOMe0sCC7ITOcbXGg7z2SGc&callback=initMap" async defer></script>
  <script>
    function initMap() {
      'use strict';

      let target = document.getElementById('target');
      let map;
      let marker;
      let tokyo_itabashi = {lat: 35.78799018447648, lng: 139.6578742703138};
      let infoWindow;

      map = new google.maps.Map(target, {
        center: tokyo_itabashi,
        zoom: 15
      });

      marker = new google.maps.Marker({
        position: tokyo_itabashi,
        map: map,
      });

      infoWindow = new google.maps.InfoWindow({
        position: tokyo_itabashi,
        content: document.getElementById('info')
      });
      
      infoWindow.open(map, marker);
    }


    $(document).ready(function () {
    $("#googleform").submit(function (event) {
      alert('送信が完了しました。');
    });
});
  </script>
</body>
</html>