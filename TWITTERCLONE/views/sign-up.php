<?php
// 設定関連を読み込む
include_once('../config.php');
// 便利な関数を読み込む
include_once('../util.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../views/common/head.php'); ?>
    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">

</head>

<body class = "signup text-center"><!--text-center 中央に寄せる -->
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="/Twitterclone/views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1>
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus><!--form-control 綺麗に見せる required 必須入力欄！ -->
            <input type="text" class="form-control" name="name" placeholder="ユーザー名、例)techis132" maxlength="50" required>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required>
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="4" maxlength="128" required>
            <button class="w-100 btn btn-lg" type="submit">登録する</button><!-- w-100はwidth100% btn btn-lgは大きいボタン -->
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p><!-- mt-3はmargin-top:1rem; mb-2はmargin-bottom:0.5rem; -->
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p><!-- text-mutedは文字を灰色！  mt-2はmargin-top:0.5rem; mb-3はmargin-bottom:1rem; -->
        </form>
    </main>
    <?php include_once('../views/common/foot.php'); ?>
</body>

</html>