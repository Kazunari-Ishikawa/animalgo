<?php

//================================
// ログ設定
//================================
ini_set('log_errors','on');
ini_set('error_log','php.log');

//================================
// デバッグ設定
//================================
// デバッグフラグ
$debug_flg = true;
// デバッグログ関数
function debug($str) {
  global $debug_flg;
  if ($debug_flg === true) {
    error_log($str);
  }
}

//================================
// 初期化
//================================
function init($name) {
  // 履歴リセット
  History::clear();
  History::set('ゲームスタート！');
  // 主人公生成
  createHuman();
  $_SESSION['human']->setName($name);
  // エンカウントフラグをリセット
  $_SESSION['encountFlg'] = false;
}

//================================
// ゲームオーバー
//================================
function gameOver($humanObj) {
  $gameOverFlg = false;
  // 体力値の判定
  if ($humanObj->getHp() <= 0) {
    History::set('体力がなくなり力尽きた・・・');
    $_SESSION['gameover'] = $humanObj->getName().'は体力がなくなり力尽きた・・・';
    $gameOverFlg = true;
  }
  // ボール数の判定
  if (($humanObj->getNumBasic() <= 0) && ($humanObj->getNumRare() <= 0) && ($humanObj->getNumSuperRare() <= 0) ) {
    History::set('ボールが無くなったので帰るしかない・・・');
    $_SESSION['gameover'] = 'ボールが無くなったので帰るしかない・・・';
    $gameOverFlg = true;
  }

  if ($gameOverFlg) {
    header("Location:result.php");
    exit();
  }
}

//================================
// 主人公生成関数
//================================
function createHuman() {
  global $human;
  $_SESSION['human'] = $human;
}

//================================
// 確率判定関数
//================================
function rateCal($num) {
  if ($num >= mt_rand(1, 100)) {
    return true;
  } else {
    return false;
  }
}

//================================
// イベント関数
//================================
function event() {
  // 良いイベントか悪いイベントか判定:暫定60%
  if (rateCal(60)) {
    $goodEventFlg = true;
  } else {
    $goodEventFlg = false;
  }
  // ボールイベントか体力イベントか判定:暫定20%
  if (rateCal(20)) {
    $ballEventFlg = true;
  } else {
    $ballEventFlg = false;
  }

  if ($goodEventFlg && $ballEventFlg) {
    // 良いボールイベント発生
    debug('良いボールイベント発生');
    return ballEvent($goodEventFlg);
  } elseif (!$goodEventFlg && $ballEventFlg) {
    // 悪いボールイベント発生
    debug('悪いボールイベント発生');
    return ballEvent($goodEventFlg);
  } elseif ($goodEventFlg && !$ballEventFlg) {
    // 良い体力イベント発生
    debug('良い体力イベント発生');
    return hpEvent($goodEventFlg);
  } elseif (!$goodEventFlg && !$ballEventFlg) {
    // 悪い体力イベント発生
    debug('悪い体力イベント発生');
    return hpEvent($goodEventFlg);
  }
}

// ボールイベント：何が何個増減するかを決定する
function ballEvent($goodEventFlg) {
  global $balls;
  // ボール種別を決める
  $num = mt_rand(1,100);
  if ($num <= $balls[Ball::BASIC]->getRare()) {
    $type = Ball::BASIC;
  } elseif (($balls[Ball::BASIC]->getRare() < $num) && ($num <= $balls[Ball::BASIC]->getRare()+$balls[Ball::RARE]->getRare())) {
    $type = Ball::RARE;
  } else {
    $type = Ball::SUPERRARE;
  }

  // 変動個数を決める
  switch ($type) {
    case Ball::BASIC:
      $changeNum = mt_rand(5,8);
      break;
    case Ball::RARE:
      $changeNum = mt_rand(2,4);
      break;
    case Ball::SUPERRARE:
      $changeNum = 1;
      break;
  }

  // ボール保有数を変更
  if ($goodEventFlg) {
    $_SESSION['human']->changeBallNum($type, $changeNum);
    History::set('目の前に何か落ちている。');
    History::set($balls[$type]->getName().'を'.$changeNum.'個ゲットした！！');
  } else {
    $_SESSION['human']->changeBallNum($type, -$changeNum);
    History::set('転んでしまった。');
    History::set($balls[$type]->getName().'を'.$changeNum.'個失った・・・');
  }
}

// ボールイベント：何が何個増減するかを決定する
function hpEvent($goodEventFlg) {
  // 体力変動値を決める
  $num = mt_rand(1,100);
  if ((1 <= $num) && ($num < 21)) {
    $changeHp = 10;
  } elseif ((21 <= $num) && ($num < 51)) {
    $changeHp = 20;
  } elseif ((51 <= $num) && ($num < 81)) {
    $changeHp = 30;
  } elseif ((81 <= $num) && ($num < 96)) {
    $changeHp = 50;
  } else {
    $changeHp = 100;
  }

  // 体力値を変更
  if ($goodEventFlg) {
    $_SESSION['human']->setHp($_SESSION['human']->getHp()+$changeHp);
    History::set('目の前に何か落ちている。');
    History::set('エナジードリンクゲット！体力が'.$changeHp.'回復した！！');
  } else {
    $_SESSION['human']->setHp($_SESSION['human']->getHp()-$changeHp);
    History::set('目の前に何か落ちている。');
    History::set('マムシドリンクゲット！体力が'.$changeHp.'減った・・・');
  }
}