<?php
// 共通関数・クラス関数読み込み
require('function.php');

// インスタンス読み込み
require('instance.php')

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
    <section id="MAIN">
      <div class="main-container">
        <div class="img-container">
          <img src="img/kirin.png" alt="アニマル画像" />
        </div>
      </div>
      <div class="sub-container">
        <div class="sub-left">
          <div class="comment-container">
            <p>〇〇はキリンに遭遇した！</p>
            <p>〇〇はボールを投げた！</p>
            <p>捕まえられなかった！</p>
            <p>キリンの反撃！</p>
            <p>〇〇は〇〇のダメージを受けた！</p>
          </div>
        </div>
        <div class="sub-right">
          <div class="command-container">
            <form action="" class="main-form">
              <input type="submit" value="進む" />
              <input type="submit" value="逃げる" />
              <input type="submit" value="リタイア" />
            </form>
            <form action="" class="main-form">
              <input type="submit" value="１を投げる" />
              <input type="submit" value="２を投げる" />
              <input type="submit" value="３を投げる" />
            </form>
          </div>
          <div class="status-container">
            <div class="status">
              <p>名前</p>
              <p>残り体力：300</p>
            </div>
            <div class="ball">
              <p>ボール１</p>
              <p>ボール２</p>
              <p>ボール３</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
