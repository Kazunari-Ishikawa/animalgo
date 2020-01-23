<?php
// 共通関数・クラス関数読み込み
require('function.php');
// インスタンス読み込み
require('instance.php');

$encountFlg = false;

// ポスト送信がある場合
if (!empty($_POST)) {
  debug('POST:'.print_r($_POST,true));

  // ゲーム開始フラグ
  $startFlg = (!empty($_POST['start'])) ? true : false;
  // 進行フラグ
  $nextFlg = (!empty($_POST['next'])) ? true : false;
  // 逃げるフラグ
  $escapeFlg = (!empty($_POST['escape'])) ? true : false;
  // ゲームオーバーフラグ
  $gameoverFlg = (!empty($_POST['gameover'])) ? true : false;
  // ボールフラグ
  $ballFlg = (!empty($_POST['ball'])) ? true : false;

  // ゲーム開始時
  if ($startFlg) {
    // 初期化処理
    $_SESSION = array();
    createHuman();

  } else {
    // ゲーム進行中
    // 進むを押した場合
    if ($nextFlg) {
      // イベント判定を行う
      if (!mt_rand(0,9)) {
        // イベント
        $eventFlg = true;
        $eventParameter = event($eventFlg);

        // イベントが発生していない場合
      } else {
        // エンカウントフラグ
        $encountFlg = true;
        // レア度を設定したが、どのようにレア別に出現させるか
        $_SESSION['animal'] = $animals[mt_rand(0,3)];
      }

      // 逃げるを押した場合
    }elseif ($escapeFlg) {
      if (!$_SESSION['human']->escape()) {
        debug('逃げる失敗！');
        $_SESSION['animal']->attack($_SESSION['human']);
      } else {
        debug('逃げる成功！');
      }

      // ボールを投げた場合
    } elseif ($ballFlg) {
      $encountFlg = true;

      // 捕獲成功時にはエンカウントフラグをOFFにしなければならない

      // リタイアを押した場合
    } elseif ($gameoverFlg) {
      // ゲームオーバーとして遷移する
      header("Location:index.php");
      exit();
    }
  }
}

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
        <?php if($encountFlg){ ?>
          <div class="img-container">
            <img src="<?php echo $_SESSION['animal']->getImg(); ?>" alt="アニマル画像" />
          </div>
        <?php } else { ?>
          <div class="img-container">
            <img src="img/mori_jungle.png" alt="背景" style="width: 45%;"/>
          </div>
          <?php } ?>
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
            <?php if($encountFlg) { ?>
              <form action="" method="post" class="main-form">
                <input type="submit" name="ball" value="１を投げる" />
                <input type="submit" name="ball" value="２を投げる" />
                <input type="submit" name="ball" value="３を投げる" />
              </form>
              <form action="" method="post" class="main-form">
                <input type="submit" name="escape" value="逃げる" />
              </form>
            <?php } else { ?>
              <form action="" method="post" class="main-form">
                <input type="submit" name="next" value="進む" />
                <input type="submit" name="show" value="一覧をみる" />
                <input type="submit" name="gameover" value="リタイア" />
              </form>
            <?php } ?>
 
          </div>
          <div class="status-container">
            <div class="status">
              <p><?php echo $_SESSION['human']->getName(); ?></p>
              <p>残り体力：<?php echo $_SESSION['human']->getHp(); ?></p>
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
