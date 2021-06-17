<?php
//////////
//便利な関数
//////////
/**
 * 画像ファイル名から画像のURLを生成
 * 
 * @param string $name 画像ファイル名
 * @param string $type ユーザー画像かツイート画像
 * @return string
 */
function buildImagePath(string $name = null,string $type)
{
    if ($type === 'user' && !isset($name)) {
        return HOME_URL . 'views/img/icon-default-user.svg'; 
    }

    return HOME_URL . 'views/img_uploaded/' . $type . '/' . htmlspecialchars($name); 
}


/**
 * 指定した日時を指定した日時からどれだけ経過したかを取得
 * 
 * @param string $datetime 日時
 * @return string
 */
function convertTodayTimeAgo(string $datetime)
{
    $unit = strtotime($datetime);
    $now = time();
    $diff_sec = $now - $unit;

    if($diff_sec < 60){
        $time = $diff_sec;
        $unit = '秒前';
    } elseif ($diff_sec < 3600){
        $time = $diff_sec / 60;
        $unit = '分前';
    } elseif ($diff_sec < 86400){
        $time = $diff_sec / 3600;
        $unit = '時間前';
    } elseif ($diff_sec < 2764800){
        $time = $diff_sec / 86400;
        $unit = '日前';
    } else{
        if(date('Y') != date('Y',$unit)){
            $time = date('Y年n月j日',$unit);
        } else {
            $time = date('n月j日',$unit);
        }
        return $time;
    }

    return (int)$time . $unit;
}

/**
 * ユーザー情報をセッションに保存
 * 
 * @param array $user
 * @return void
 */
function saveUserSession(array $user)
{
    // セッションをセッションを開始していない場合
    if(session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }

    $_SESSION['USER'] = $user;
}

/**
 * ユーザー情報をセッションから削除
 * 
 * 戻り値なし
 * @return void
 */
function deleteUserSession()
{
    if(session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
    // セッションのユーザー情報を削除
    unset($_SESSION['USER']);
}

/**
 * セッションのユーザー情報を取得
 * 
 * @return array|false
 */
function getUserSession()
{
    if(session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }

    if(!isset($_SESSION['USER'])) {
        // セッションにユーザー情報をユーザー情報がない
        return false;
    }

    $user = $_SESSION['USER'];

    // 画像のファイル名からURLを取得
    if(!isset($user['image_name'])) {
        $user['image_name'] = null;
    }
    $user['image_path'] = buildImagePath($user['image_name'],'user');

    return $user;
}


/**
 * 画像アップロード
 * 
 * @param array $user
 * @param array $file
 * @return string $type
 * @return string 画像のファイル名を返す
 */
function uploadImage(array $user, array $file, string $type) 
{
    // strrchrで.を指定して画像のファイル名から拡張子を取得（例：.png）
    $image_extension = strrchr($file['name'], '.');

    // 画像のファイル名を作成 (YmdHis 例：2021-01-01 00:00:00)
    $image_name = $user['id'] . '_' . date('YmdHis') . $image_extension;

    // 保存先のディレクトリ
    $directory = '../views/img_uploaded/' . $type . '/';

    // 画像のパス
    $image_path = $directory . $image_name;

    // 画像の設置
    move_uploaded_file($file['tmp_name'], $image_path);

    // 画像ファイルかチェック
    if(exif_imagetype($image_path)) {
        return $image_name;
    }

    // 画像ファイル以外の画像ファイル以外の場合
    echo '選択されたファイルが画像ではないため処理を停止しました。';
    exit;
    
}

?>