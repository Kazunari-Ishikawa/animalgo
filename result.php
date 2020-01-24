<?php
// クラス読み込み
require('class.php');
// 共通関数読み込み
require('function.php');
// インスタンス読み込み
require('instance.php');
// セッションスタート
session_start();

debug('SESSION:'.print_r($_SESSION, true));

// 捕獲ポイントを格納
$point = (!empty($_SESSION['point'])) ? $_SESSION['point'] : 0;
// 捕獲したアニマルを格納
$catch = (!empty($_SESSION['achieve'])) ? $_SESSION['achieve'] : array();
// ゲームオーバーコメントを格納
$comment = (!empty($_SESSION['gameover'])) ? $_SESSION['gameover'] : '';

// それぞれの数を数える
$getAnimal = array();
$count1 = count($catch);
for ($i = 0; $i < count($catch); $i++) {
  $okFlg = false;
  $tmpName = $catch[$i]->getName();
  if ($i == 0) {
    $getAnimal[$i]['name'] = $catch[$i]->getName();
    $getAnimal[$i]['img'] = $catch[$i]->getImg();
    $getAnimal[$i]['num'] = 1;
  } else {
    $count2 = count($getAnimal);
    for ($j = 0; $j < $count2; $j++) {
      if ($getAnimal[$j]['name'] == $tmpName) {
        $getAnimal[$j]['num'] ++;
        $okFlg = true;
      break;
      }
    }
    if ($okFlg == false) {
      $getAnimal[$count2]['name'] = $catch[$i]->getName();
      $getAnimal[$count2]['img'] = $catch[$i]->getImg();
      $getAnimal[$count2]['num'] = 1;
    }
  }
}

// ゲーム終了としてセッションを削除
session_destroy();

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
        <p><?php echo $comment; ?></p>
        <h2>あなたの捕獲ポイントは</h2>
        <p><span class="point"><?php echo $point; ?></span>点です！</p>
        <div class="btn">
          <a href="index.php">トップ画面へ戻る</a>
        </div>
      </div>
      <div class="point-bottom-container">
        <?php for ($i = 0; $i < count($getAnimal); $i++) { ?>
          <div class="card">
            <img src="img/<?php echo $getAnimal[$i]['img']; ?>" alt="" />
            <p>×<?php echo $getAnimal[$i]['num']; ?></p>
          </div>
          <?php } ?>
      </div>
    </section>
  </body>
</html>
