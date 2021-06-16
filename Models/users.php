<?php
////////////////////////
// ユーザーデータを処理
////////////////////////

/**
 * ユーザーを作成
 * 
 * @param array $data
 * @return bool
 */
function createUser(array $data)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // 接続チェック
    if ($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit; //強制終了みたいな感じ
    }

    // 新規登録のSQLを作成
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';
    $statement = $mysqli->prepare($query);

    // パスワードパスワードをハッシュ値に変換
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // ? の部分にセットする内容
    // 第一引数のsは変数の型を指定(s=string) ssssは全てstring型になる
    $statement->bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password']);

    // 処理を実行
    $response = $statement->execute();
    if($response === false){
        echo 'エラーメッセージ：'. $mysqli->error . "\n";
    }
    // 接続を開放
    $statement->close();
    $mysqli->close();

    return $response;
}
/**
 * ユーザー情報取得：ログインチェック
 * 
 * @param string $email
 * @return string $password
 * @return array|false
 */
function findUserAndCheckPassword(string $email, string $password)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // 接続チェック
    if ($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。：' . $mysqli->connect_error . "\n";
        exit; //強制終了みたいな感じ
    }

    // 入力値をエスケープ
    $email = $mysqli->real_escape_string($email);

    // クエリを作成
    // - 外部から外部からのリクエストリクエストは何が入って来るかわからないので、必ずエスケープしたものをクオートで囲む
    $query = 'SELECT * FROM users WHERE email = "' . $email . '"';

    // SQL実行
    $result = $mysqli->query($query);
    if(!$result) {
        // MySQL処理中にエラー
        echo 'エラーメッセージ：' . $mysqli->error . "\n";

        $mysqli->close();
        return false;
    }

    // ユーザー情報を取得
    $user = $result->fetch_array(MYSQLI_ASSOC);//データを一件取得
    if(!$user) {
        // ユーザー情報が存在しない
        $mysqli->close();
        return false;
    }
    
    // パスワードチェック
    if(!password_verify($password, $user['password'])){
        // パスワード不一致
        $mysqli->close();
        return false;
    }

    $mysqli->close();
    // 最後までクリアしたらデータベースの情報をリターン
    return $user;
}

?>