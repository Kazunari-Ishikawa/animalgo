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
function gameOver() {
  $_SESSION = array();
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
  } elseif (!$goodEventFlg && $ballEventFlg) {
    // 悪いボールイベント発生
    debug('悪いボールイベント発生');
  } elseif ($goodEventFlg && !$ballEventFlg) {
    // 良い体力イベント発生
    debug('良い体力イベント発生');
  } elseif (!$goodEventFlg && !$ballEventFlg) {
    // 悪い体力イベント発生
    debug('悪い体力イベント発生');
  }
}