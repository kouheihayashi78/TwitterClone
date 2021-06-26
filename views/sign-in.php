<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../views/common/head.php'); ?>
    <title>ログイン画面 / Twitterクローン</title>
    <meta name="description" content="ログイン画面です">

</head>

<body class = "signup text-center"><!--text-center 中央に寄せる -->
    <main class="form-signup">
        <form action="sign-in.php" method="post">
            <img src="/Twitterclone/views/img/logo-white.svg" alt="" class="logo-white">
            <h1>Twitterクローンにログイン</h1>

            <?php if(isset($view_try_login_result) && $view_try_login_result === false): ?>
            <!-- ログインに失敗した場合 -->
            <div class="alert alert-warning text-sm" role="alert">
                ログインに失敗しました。メールアドレス、パスワードが正しいかご確認下さい。
            </div>
            <?php endif; ?>
            
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="パスワード" required>
            <button class="w-100 btn btn-lg" type="submit">ログイン</button><!-- w-100はwidth100% btn btn-lgは大きいボタン -->
            <p class="mt-3 mb-2"><a href="sign-up.php">会員登録する</a></p><!-- mt-3はmargin-top:1rem; mb-2はmargin-bottom:0.5rem; -->
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p><!-- text-mutedは文字を灰色！  mt-2はmargin-top:0.5rem; mb-3はmargin-bottom:1rem; -->
        </form>
    </main>
    <?php include_once('../views/common/foot.php'); ?>
</body>

</html>