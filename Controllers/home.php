<?php
// 外のファイルを一回だけ読み込むのが include_once  // 何回でも読み込むのが include
////////////////////
// ホームコントローラー
////////////////////
// 設定を読み込み
include_once '../config.php';

// 便利な関数を読みこみ
include_once '../util.php';

// ツイートデータ操作モデルを読み込む
include_once '../Models/tweets.php';

// ログインしているか
$user = getUserSession();
if (!$user) {
    // ログインしていない
    header('Location' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// 画面表示
$view_user = $user;
//ツイート一覧
$view_tweets = findTweets($user);
include_once '../views/home.php';