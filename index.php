<?php
// クラス読み込み
require('class.php');
// 共通関数読み込み
require('function.php');
// インスタンス読み込み
require('instance.php');
// セッションスタート
session_start();

// ポスト送信がある場合
if (!empty($_POST)) {

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
    // 主人公の名前
    $name = (!empty($_POST['name'])) ? $_POST['name'] : '';
    // 初期化処理
    init($name);

  // ゲーム進行中
  } else {
    // 進むを押した場合
    if ($nextFlg) {
      // イベント判定を行う
      if (!mt_rand(0,9)) {
        // イベント発生
        $eventParameter = event();

      // イベントが発生していない場合
      } else {
        // エンカウントフラグON
        $_SESSION['encountFlg'] = true;
        // レア度を設定したが、どのようにレア別に出現させるか
        $_SESSION['animal'] = $animals[mt_rand(0,3)];
        History::set($_SESSION['animal']->getName().'が現れた！');
      }

    // 逃げるを押した場合
    }elseif ($escapeFlg) {
      if (!$_SESSION['human']->escape()) {
        $_SESSION['animal']->attack($_SESSION['human']);
      } else {
        // 逃げる成功時、エンカウントフラグOFF
        $_SESSION['encountFlg'] = false;
      }

    // ボールを投げた場合
    } elseif ($ballFlg) {
      // 選択したボール種別の判定
      if (!empty($_POST['type1'])) {
        $selectBall = $balls[0];
      } elseif (!empty($_POST['type2'])) {
        $selectBall = $balls[1];
      } elseif (!empty($_POST['type3'])) {
        $selectBall = $balls[2];
      }
      // 捕獲判定
      if (!$_SESSION['animal']->resist($selectBall)) {
        // 捕獲失敗時、アニマルが反撃する
        $_SESSION['animal']->attack($_SESSION['human']);
      } else {
        // 捕獲成功時、エンカウントフラグOFF
        History::achieve($_SESSION['animal']);
        $_SESSION['animal'] = '';
        $_SESSION['encountFlg'] = false;
      };

    // リタイアを押した場合
    } elseif ($gameoverFlg) {
      // ゲームオーバーとして遷移する
      gameOver();
      header("Location:index.php");
      exit();
    }
  }
}
debug('SESSION:'.print_r($_SESSION, true));
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
  <?php if (empty($_SESSION)) { ?>
    <section id="START">
      <div  class="container">
        <h1>Animal GO!!</h1>
        <form action="" method="POST" class="start-form">
          <p>名前</p>
          <input type="text" name="name" class="set-name" placeholder="見習い">
          <input type="submit" name="start" value="ゲームスタート！" />
        </form>
      </div>
    </section>
  <?php } else { ?>
    <section id="MAIN">
      <div class="main-container">
        <?php if($_SESSION['encountFlg']){ ?>
          <div class="img-container">
            <img src="img/<?php echo $_SESSION['animal']->getImg(); ?>" alt="アニマル画像" />
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
            <?php if (!empty($_SESSION['history'])) echo $_SESSION['history']; ?>
          </div>
        </div>
        <div class="sub-right">
          <div class="command-container">
            <?php if($_SESSION['encountFlg']) { ?>
              <form action="" method="post" class="main-form">
                <input type="hidden" name="ball" value="ボール">
                <input type="submit" name="type1" value="ベーシックボール" />
                <input type="submit" name="type2" value="レアボール" />
                <input type="submit" name="type3" value="スーパーレアボール" />
              </form>
              <form action="" method="post" class="main-form">
                <input type="submit" name="escape" value="逃げる" />
                <input type="submit" name="gameover" value="リタイア" />
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
  <?php } ?>
  </body>
</html>
