<?php
//　エラー表示
ini_set('display_errors',1);

// 日本時間で表示
date_default_timezone_set('Asia/Tokyo');
//URLディレクトリ設定
define('HOME_URL','/TWITTERCLONE/');
// データベースの接続情報
define('DB_HOST', 'localhost');
define('DB_USER', 'hayashi');
define('DB_PASSWORD', 'hayashipass');
define('DB_NAME', 'twitter_clone');

?>