<?php

include './base/base.php';
include './base/msg.php';

if(isset($_GET['param'])) {
    $error = $msg004;
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>キョウココ</title>
        <link rel="stylesheet" href="css/main.css">
        <script src="./lib/jquery-2.1.3.min.js"></script>
    </head>
    <body>
        <header>
           <h1>
               キ ョ ウ コ コ
           </h1>
        </header>
        <div class="subheader clearfix">
            <h2>ユーザの新規登録</h2>
            <a href="./index.php">ログインページに戻る</a>
        </div>

        <?php
            if(isset($error)) {
                echo '<p id="errorMsg">'.$error.'</p>';
            }
        ?>

        <div id="showUser">
            <form action="./registUserInfo.php" method="post">
                <ul class="clearfix">
                    <li><label class="titleLabel" for="email">email</label></li>
                    <li><div class="loginFormArea">
                        <input type="email" name="email" id="email" required>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="nickname">ニックネーム</label></li>
                    <li><div class="loginFormArea">
                        <input type="text" name="nickname" id="nickname" required>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="password">パスワード</label></li>
                    <li><div class="loginFormArea">
                        <input type="password" name="password" id="password" required>
                    </div></li>
                </ul>
                <button class="rptSbt">登録</button>
            </form>
        </div>
    </body>
</html>