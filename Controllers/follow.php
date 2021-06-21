<?php
// 外のファイルを一回だけ読み込むのが include_once  // 何回でも読み込むのが include
////////////////////
// フォローコントローラー
////////////////////
// 設定を読み込み
include_once '../config.php';

// 便利な関数を読みこみ
include_once '../util.php';

// いいね！データ操作モデルを読み込む
include_once '../Models/follows.php';

// ログインしているか
$user = getUserSession();
if (!$user) {
    // ログインしていない
    header('HTTP/1.0 404 Not Found');
    exit;
}

// フォローする
$follow_id = null;
if (isset($_POST['followed_user_id'])) {
    $data = [
        'followed_user_id' => $_POST['followed_user_id'],
        'follow_user_id' => $user['id'],
    ];
    // フォロー登録
    $follow_id = createFollow($data);
}
 
// フォローIDが指定されている場合は、フォローを削除
if (isset($_POST['follow_id'])) {
    $data = [
        'follow_id' => $_POST['follow_id'],
        'follow_user_id' => $user['id']
    ];
    // フォロー削除
    deleteFollow($data);
}
 
// JSON形式で結果を返却
$response = [
    'message' => 'successful',
    // フォローしたときに値が入る
    'follow_id' => $follow_id,
];
header('Content-Type: application/json; charset=uft-8');
echo json_encode($response);
