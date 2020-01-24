<?php

// アニマル格納用
$animals = array();

// ボール格納用
$balls = array();

// インスタンス生成
// 主人公：名前、体力、運、捕獲ポイント
$human = new Human('見習い', 300, 70, 0);

// アニマル：名前、画像、抵抗力（MAX100）、反撃力、レア度、捕獲ポイント
$animals[] = new Animal('キリン', 'kirin.png', 30, mt_rand(30, 50), 30, 50);
$animals[] = new Animal('ライオン', 'raion.png', 80, mt_rand(80, 100), 10, 100);
$animals[] = new Animal('シカ', 'shika.png', 50, mt_rand(30, 50), 30, 30);
$animals[] = new Animal('ウマ', 'uma.png', 60, mt_rand(30, 50), 30, 30);

// ボール：名前、画像、捕獲力（MAX100）、レア度
$balls[] = new Ball('ベーシック', '', 50, 70);
$balls[] = new Ball('レア', '', 80, 28);
$balls[] = new Ball('超レア', '', 1000, 2);
