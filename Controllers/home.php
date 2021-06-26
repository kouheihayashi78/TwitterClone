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
// フォローデータ操作モデルを読み込む
include_once '../Models/follows.php';

// ログインしているか
$user = getUserSession();
if (!$user) {
    // ログインしていない
    header('Location' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// 自分がフォローしているユーザーID一覧を取得
$following_user_ids = findFollowingUserIds($user['id']);
// 自分のツイートも表示するために自分のIDも追加
$following_user_ids[] = $user['id'];
 
// 画面表示
$view_user = $user;
// ツイート一覧
$view_tweets = findTweets($user, null, $following_user_ids); // 第二引数は検索キーワードなのでnull

include_once '../views/home.php';
