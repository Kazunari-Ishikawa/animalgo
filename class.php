<?php
//================================
// 主人公クラス：主人公の情報を管理する
//================================
class Human {
  // プロパティ
  protected $name;
  protected $hp;
  protected $luck; //逃げる確率：MAX100
  protected $numBasic; //ベーシックボールの保有数
  protected $numRare; //レアボールの保有数
  protected $numSuperRare; //スーパーレアボールの保有数
  // コンストラクタ
  public function __construct($name, $hp, $luck, $numBasic, $numRare, $numSuperRare) {
    $this->name = $name;
    $this->hp = $hp;
    $this->luck = $luck;
    $this->numBasic = $numBasic;
    $this->numRare = $numRare;
    $this->numSuperRare = $numSuperRare;
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
      History::set($this->name.'は逃げる成功！');
      return true;
    } else {
      History::set($this->name.'は逃げる失敗！');
      return false;
    }
  }
  // ボール保有数変更
  public function changeBallNum($ball, $num) {
    switch ($ball) {
      case BASIC:
        $this->setNumBasic($this->getNumBasic()-$num);
        break;
      case RARE:
        $this->setNumRare($this->getNumRare()-$num);
        break;
      case SUPERRAER:
        $this->setNumSuperRare($this->getNumSuperRare()-$num);
        break;
    }
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
    History::set($this->name.'から反撃を受けた！');
    History::set($attackPoint.'のダメージ！');
  }
  // ボールへの抵抗判定メソッド
  public function resist($ballObj) {
    // ボールの捕獲力計算
    $catchPoint = $ballObj->getCatch();
    // アニマルの抵抗力計算
    $resistPoint = $this->getResistance();

    // 判定・・・さらに複雑にするかは保留
    if ($catchPoint >= $resistPoint) {
      History::set($this->name.'の捕獲成功！');
      return true;
    } else {
      History::set($this->name.'の捕獲失敗…');
      return false;
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
  // 種別定数
  const BASIC = 0;
  const RARE = 1;
  const SUPERRARE = 2;
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
  public static function achieve($animalObj) {
    if (empty($_SESSION['point'])) {
      // $_SESSION['achieve'] = '';
      $_SESSION['point'] = 0;
    }
    // $_SESSION['achieve'][0] = $animalObj->getName();
    $_SESSION['point'] += $animalObj->getPoint();
  }
}
