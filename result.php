<?php
// クラス読み込み
require('class.php');
// 共通関数読み込み
require('function.php');
// インスタンス読み込み
// require('instance.php');
// セッションスタート
session_start();

debug('SESSION:'.print_r($_SESSION, true));

// 捕獲ポイントを格納
$point = (!empty($_SESSION)) ? $_SESSION['point'] : 0;
// 捕獲したアニマルを格納
$catch = '';

// ゲーム終了としてセッションを削除
gameOver();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style.css" />
    <title>Animal GO!!</title>
  </head>
  <body>
    <section id="RESULT">
      <div class="point-container">
        <h2>あなたの捕獲ポイントは</h2>
        <p><span class="point"><?php echo $point; ?></span>点です！</p>
        <div class="btn">
          <a href="index.php">トップ画面へ戻る</a>
        </div>
      </div>
      <div class="point-bottom-container">
        <div class="card">
          <img src="img/kirin.png" alt="" />
          <p>×４</p>
        </div>
        <div class="card">
          <img src="img/raion.png" alt="" />
          <p>×１</p>
        </div>
        <div class="card">
          <img src="img/uma.png" alt="" />
          <p>×2</p>
        </div>
        <div class="card">
          <img src="img/shika.png" alt="" />
          <p>×４</p>
        </div>
      </div>
    </section>
  </body>
</html>
