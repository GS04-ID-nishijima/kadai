<?php

include './base/msg.php';

if(isset($_GET['login'])) {
    $error = $msg001;
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
            <h2>ログインページ</h2>
            <a href="./inputRegistUserInfo.php" >ユーザ新規登録</a>
        </div>

        <?php
            if(isset($error)) {
                echo '<p id="errorMsg">'.$error.'</p>';
            }
        ?>

       
        <div id="loginPage">
            <form action="login.php" method="post" enctype="multipart/form-data">
                <ul class="loginUl clearfix">
                    <li><label class="titleLabel" for="email">メールアドレス</label></li>
                    <li><div class="loginFormArea">
                        <input type="text" name="email" id="email" required>
                    </div></li>
                </ul>
                <ul class="loginUl clearfix">
                    <li><label class="titleLabel" for="password">パスワード</label></li>
                    <li><div class="loginFormArea">
                        <input type="password" name="password" id="password" required>
                    </div></li>
                </ul>
                <div class="btnCntr"><input type="submit" value="ログイン" class="rptSbt"></div>
            </form>
        </div>

        
    </body>
</html>
