<?php
///////////////////////////////////////
// 通知データを処理
///////////////////////////////////////
 
/**
 * 通知を作成
 *
 * @param array $data
 * @return int|false
 */
function createNotification(array $data)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // 接続チェック
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit;
    }
 
    // SQL作成
    $query = 'INSERT INTO notifications (recieved_user_id, sent_user_id, message) VALUES (?, ?, ?)';
    $statement = $mysqli->prepare($query);
 
    // プレースホルダーに値をセット
    $statement->bind_param('iis', $data['recieved_user_id'], $data['sent_user_id'], $data['message']);
 
    // SQL実行
    if ($statement->execute()) {
        // 結果をIDで返却
        $response = $mysqli->insert_id;
    } else {
        $response = false;
        echo 'エラーメッセージ：' . $mysqli->error . "\n";
    }
 
    // 接続を閉じる
    $statement->close();
    $mysqli->close();
 
    return $response;
}
 
/**
 * 通知の一覧を取得
 *
 * @param integer $user_id
 * @return array|false
 */
function findNotifications(int $user_id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // 接続チェック
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit;
    }
 
    // エスケープ
    $user_id = $mysqli->real_escape_string($user_id);
 
    // 検索のSQLを作成
    $query = <<<SQL
        SELECT
            N.id AS notification_id,
            N.message AS notification_message,
            U.name AS user_name,
            U.nickname AS user_nickname,
            U.image_name AS user_image_name
        FROM
            notifications AS N
            JOIN
                users AS U ON U.id = N.sent_user_id AND U.status = 'active'
        WHERE
            N.status = 'active' AND N.recieved_user_id = '$user_id' -- 通知を受信したユーザーIDが自分のユーザーIDのとき
        ORDER BY
            N.created_at DESC
        LIMIT 50
    SQL;
 
    // SQL実行
    if ($result = $mysqli->query($query)) {
        // 配列で取得
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $notifications = false;
        echo 'エラーメッセージ：' . $mysqli->error . "\n";
    }
 
    return  $notifications;
}