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
// セッション準備
//================================
//セッションを使う
// session_start();

//================================
// クラス設計
//================================
// 主人公クラス：主人公の情報を管理する
class Human {
  // プロパティ
  protected $name;
  protected $hp;
  protected $luck; //逃げる確率：MAX100
  protected $achieve; //合計捕獲ポイント：基本は0
  // コンストラクタ
  public function __construct($name, $hp, $luck, $achieve) {
    $this->name = $name;
    $this->hp = $hp;
    $this->luck = $luck;
    $this->achieve = $achieve;
  }
  // セッター
  public function setHp($num) {
    $this->hp = $num;
  }
  public function setAchieve($num) {
    $this->achieve = $num;
  }
  // ゲッター
  public function getName() {
    return $this->name;
  }
  public function getHp() {
    return $this->hp;
  }
  public function getLuck() {
    return $this->luck;
  }
  public function getAchieve() {
    return $this->achieve;
  }
  // メソッド
  // 逃げるメソッド
  public function escape() {
    if (rateCal($this->luck)) {
      return true;
    } else {
      false;
    }
  }
  // 捕獲ポイント計算メソッド
  public function calPoint($animalObj) {
    $currentAchieve = $this->getAchieve;
    $currentAchieve += $animalObj->getPoint();
    $this->setAchieve($currentAchieve);
  }
}

// ボールクラス：ボールの情報を管理する
class Ball {
  // プロパティ
  protected $name;
  protected $img;
  protected $catch; // 捕獲力：暫定MAX100
  protected $rare; // レア度、出現率：MAX100
  // コンストラクタ
  public function __construct($name, $img, $catch, $rare) {
    $this->name = $name;
    $this->img = $img;
    $this->catch = $catch;
    $this->rare = $rare;
  }
  // ゲッター
  public function getName() {
    return $this->name;
  }
  public function getImg() {
    return $this->img;
  }
  public function getCatch() {
    return $this->catch;
  }
  public function getRare() {
    return $this->rare;
  }

}


// アニマルクラス：アニマルの情報を管理する
class Animal {
  // プロパティ
  protected $name;
  protected $img;
  protected $resistance; //抵抗力：暫定MAX100
  protected $attack;
  protected $rare; // レア度、出現率：MAX100
  protected $point;
  // コンストラクタ
  public function __construct($name, $img, $resistance, $attack, $rare, $point) {
    $this->name = $name;
    $this->img = $img;
    $this->resistance = $resistance;
    $this->attack = $attack;
    $this->rare = $rare;
    $this->point = $point;
  }
  // セッター
  public function setHp($num) {
    $this->hp = $num;
  }
  // ゲッター
  public function getName() {
    return $this->name;
  }
  public function getImg() {
    return $this->img;
  }
  public function getResistance() {
    return $this->resistance;
  }
  public function getAttack() {
    return $this->attack;
  }
  public function getRare() {
    return $this->rare;
  }
  public function getPoint() {
    return $this->point;
  }
  // メソッド
  // アニマルからの反撃メソッド
  public function attack($humanObj) {
    // 反撃力の計算
    $attackMin = $this->attack - 10;
    $attackMax = $this->attack + 10;
    $attackPoint = (int)mt_rand($attackMin, $attackMax);
    $humanObj->setHp($humanObj->getHp()-$attackPoint);
    debug($this->name.'から反撃を受けた！');
    debug($attackPoint.'のダメージ！');
    $_SESSION['history'] .= $this->name.'から反撃を受けた！';
    $_SESSION['history'] .= $attackPoint.'のダメージ！';
  }
  // ボールへの抵抗判定メソッド
  public function resist($ballObj) {
    // ボールの捕獲力計算
    $catchPoint = $ballObj->catch;
    // アニマルの抵抗力計算
    $resistPoint = $this->getResistance();

    // 判定・・・さらに複雑にするかは保留
    if ($catchPoint >= $resistPoint) {
      $_SESSION['history'] .= $this->name.'の捕獲成功！';
    } else {
      $_SESSION['history'] .= $this->name.'の捕獲失敗…';
    }
  }

}

// 履歴管理クラス
class History {
  public static function set($str) {
    if (empty($_SESSION['history'])) $_SESSION['history'] = '';
    $_SESSION['history'] .= $str.'<br>';
  }
  public static function clear() {
    // unset($_SESSION);
    $_SESSION = array();
  }
}

// 初期化
function init() {
  History::clear();
  History::set('ゲームスタート！');
  createHuman();
}

// ゲームオーバー
function gameOver() {
  // session_destroy();
  $_SESSION = array();
}


// 主人公生成関数
function createHuman() {
  global $human;
  $_SESSION['human'] = $human;
}

// 確率判定関数
function rateCal($num) {
  if ($num >= mt_rand(1, 100)) {
    return true;
  } else {
    return false;
  }
}

// イベント関数
function event($eventFlg) {
  if ($eventFlg) {
    // 良いイベントか悪いイベントか判定
    if (rateCal(60)) {
      $goodEventFlg = true;
    } else {
      $goodEventFlg = false;
    }
    // ボールイベントか体力イベントか判定
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
}