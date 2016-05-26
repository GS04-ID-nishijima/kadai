<?php

include '../base/base.php';
include '../base/msg.php';
include '../base/func.php';

// セッションチェック
sessionCheck();

$userId = $_POST["id"];

$pdo = dbConnect();

if(isset($_GET['edit'])) {
    $error = $msg003;
}

// ユーザー情報取得
$stmt = $pdo->prepare($getUserInfoForAdminSQL);

$stmt->bindValue(':id', $userId);
$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msgQueryError.$error[2]);
}else{
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $email = $result['email'];
        $nickname = $result['nickname'];
        $authority = $result['authority'];
        $shop_name = $result['shop_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>キョウココ</title>
        <link rel="stylesheet" href="../css/main.css">
        <script src="../lib/jquery-2.1.3.min.js"></script>
    </head>
    <body>
        <header>
           <h1>
               キ ョ ウ コ コ
           </h1>
        </header>
        <div class="subheader clearfix">
            <h2><?=$nickname?>のユーザ情報</h2>
            <a href="./showUserList.php">ユーザ一覧に戻る</a>
        </div>
        <?php
            if(isset($error)) {
                echo '<p id="errorMsg">'.$error.'</p>';
            }
        ?>
        <div id="showUserForAdmin">
            <ul class="clearfix">
                <li><label class="titleLabel">id</label></li>
                <li><p><?=$userId?></p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">email</label></li>
                <li><p><?=$email?></p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">ニックネーム</label></li>
                <li><p><?=$nickname?></p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">パスワード</label></li>
                <li><p>********（セキュリティのため表示していません。）</p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">権限</label></li>
                <li><p><?=$authority?></p></li>
            </ul>
            <ul class="clearfix">
                <li><label class="titleLabel">お店</label></li>
                <li><p><?=$shop_name?></p></li>
            </ul>
            <form action="./inputUserInfoForAdmin.php" method="post">
                <input type="hidden" name="id" value="<?=$userId?>">
                <button class="rptSbt">ユーザ情報の<br>変更</button>
                <button formaction="./deleteUser.php" class="rptSbt">ユーザ情報の<br>削除</button>
            </form>
        </div>
    </body>
</html>