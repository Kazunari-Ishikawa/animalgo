<?php

// アニマル格納用
$animals = array();

// ボール格納用
$balls = array();

// インスタンス生成
// 主人公：名前、体力、運、各ボール保有数
$human = new Human('新人', 300, 55, 5, 3, 2);

// アニマル：名前、画像、抵抗力（MAX100）、反撃力、レア度、捕獲ポイント
$animals[] = new Animal('サル', 'saru.png', 30, mt_rand(30, 50), 70, 30);
$animals[] = new Animal('ハクチョウ', 'hakuchou.png', 30, mt_rand(30, 50), 70, 30);
$animals[] = new Animal('シカ', 'shika.png', 30, mt_rand(30, 50), 70, 30);
$animals[] = new Animal('ウマ', 'uma.png', 50, mt_rand(30, 50), 50, 50);
$animals[] = new Animal('パンダ', 'panda.png', 50, mt_rand(50, 70), 50, 50);
$animals[] = new Animal('カンガルー', 'kangaru.png', 80, mt_rand(50, 70), 20, 80);
$animals[] = new Animal('キリン', 'kirin.png', 80, mt_rand(50, 70), 20, 80);
$animals[] = new Animal('ダチョウ', 'dachou.png', 80, mt_rand(50, 70), 20, 80);
$animals[] = new Animal('サイ', 'sai.png', 120, mt_rand(80, 100), 5, 120);
$animals[] = new Animal('ゾウ', 'zou.png', 120, mt_rand(80, 160), 5, 120);
$animals[] = new Animal('ライオン', 'raion.png', 120, mt_rand(100, 120), 5, 120);

// ボール：名前、画像、捕獲力（基準値70）、レア度
$balls[] = new Ball('ノーマルボール', '', 100, 70);
$balls[] = new Ball('レアボール', '', 140, 28);
$balls[] = new Ball('ウルトラボール', '', 200, 2);
