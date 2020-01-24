<?php
//================================
// 主人公クラス：主人公の情報を管理する
//================================
class Human {
  // プロパティ
  protected $name;
  protected $hp;
  protected $luck; //逃げる確率：MAX100
  protected $achieve; //合計捕獲ポイント：基本は0
  protected $numBasic; //ベーシックボールの保有数
  protected $numRare; //レアボールの保有数
  protected $numSuperRare; //スーパーレアボールの保有数
  // コンストラクタ
  public function __construct($name, $hp, $luck, $achieve, $numBasic, $numRare, $numSuperRare) {
    $this->name = $name;
    $this->hp = $hp;
    $this->luck = $luck;
    $this->achieve = $achieve;
    $this->numBasic = $numBasic;
    $this->numBasic = $numRare;
    $this->numBasic = $numSuperRare;
  }
  // セッター
  public function setName($str) {
    if ($str !== '') {
      $this->name = $str;
    }
  }
  public function setHp($num) {
    $this->hp = $num;
  }
  public function setAchieve($num) {
    $this->achieve = $num;
  }
  public function setNumBasic($num) {
    $this->$numBasic = $num;
  }
  public function setNumRare($num) {
    $this->$numRare = $num;
  }
  public function setNumSuperRare($num) {
    $this->$numSuperRare = $num;
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
  public function getNumBasic() {
    return $this->numBasic;
  }
  public function getNumRare() {
    return $this->numRare;
  }
  public function getNumSuperRare() {
    return $this->numSuperRare;
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

//================================
// アニマルクラス：アニマルの情報を管理する
//================================
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

//================================
// ボールクラス：ボールの情報を管理する
//================================
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

//================================
// 履歴管理クラス
//================================
class History {
  public static function set($str) {
    if (empty($_SESSION['history'])) $_SESSION['history'] = '';
    $_SESSION['history'] .= $str.'<br>';
  }
  public static function clear() {
    $_SESSION = array();
  }
}
