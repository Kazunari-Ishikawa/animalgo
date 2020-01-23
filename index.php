<?php
// 共通関数・クラス関数読み込み
require('function.php');
debug('POST:'.print_r($_POST,true));
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
    <section id="START">
      <div  class="container">
        <h1>Animal GO!!</h1>
        <form action="main.php" method="POST" class="start-form">
          <input type="submit" name="start" value="ゲームスタート！" />
        </form>
      </div>
    </section>
  </body>
</html>
