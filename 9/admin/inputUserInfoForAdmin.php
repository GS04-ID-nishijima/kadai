<?php

include '../base/base.php';
include '../base/msg.php';
include '../base/func.php';

// セッションチェック
sessionCheck();

$userId = $_POST["id"];

if(isset($_GET['param'])) {
    $error = $msg002;
}

$pdo = dbConnect();

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
        $authority_id = $result['authority_id'];
        $authority = $result['authority'];
        $shop_id = $result['shop_id'];
        $shop_name = $result['shop_name'];
    }
}

// 店一覧取得
$stmt = $pdo->prepare($getShopListSQL);
$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msgQueryError.$error[2]);
}else{
    $selectView = '<select name="shop_id" id="shop_id"><option value=""></option>';
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        if($shop_id == $result['id']) {
            $selectView .= 
                '<option value="'.$result['id'].'" selected>'.$result['shop_name'].'</option>';
        } else {
            $selectView .= 
                '<option value="'.$result['id'].'">'.$result['shop_name'].'</option>';
        }
    }
    $selectView .= '</select>';
}

// 権限一覧取得
$stmt = $pdo->prepare($getKbnListSQL);
$stmt->bindValue(':cd', 3);
$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msgQueryError.$error[2]);
}else{
    $authorityView = '<select name="authority" id="authority">';
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        if($authority_id == $result['id']) {
            $authorityView .= 
                '<option value="'.$result['id'].'" selected>'.$result['text'].'</option>';
        } else {
            $authorityView .= 
                '<option value="'.$result['id'].'">'.$result['text'].'</option>';
        }
    }
    $authorityView .= '</select>';
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>キョウココ</title>
        <link rel="stylesheet" href="../css/main.css">
        <script src="./lib/jquery-2.1.3.min.js"></script>
    </head>
    <body>
        <header>
           <h1>
               キ ョ ウ コ コ
           </h1>
        </header>
        <div class="subheader clearfix">
            <h2><?=$nickname?>のユーザ情報の変更</h2>
            <a href="./showUserList.php">ユーザ一覧に戻る</a>
        </div>

        <?php
            if(isset($error)) {
                echo '<p id="errorMsg">'.$error.'</p>';
            }
        ?>

        <div id="showUserForAdmin">
            <form action="./editUserInfoForAdmin.php" method="post">
                <ul class="clearfix">
                    <li><label class="titleLabel">id</label></li>
                    <li><p><?=$userId?></p></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="email">email</label></li>
                    <li><div class="loginFormArea">
                        <input type="email" name="email" id="email" value="<?=$email?>" required>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="nickname">ニックネーム</label></li>
                    <li><div class="loginFormArea">
                        <input type="text" name="nickname" id="nickname" value="<?=$nickname?>" required>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="password">パスワード</label></li>
                    <li><div class="loginFormArea">
                        <input type="password" name="password" id="password" placeholder="変更する場合に入力してください。">
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="authority">権限</label></li>
                    <li><div class="loginFormArea">
                        <?php echo $authorityView?>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel" for="shop_id">お店</label></li>
                    <li><div class="loginFormArea">
                        <?php echo $selectView?>
                    </div></li>
                </ul>
                <input type="hidden" name="id" value="<?=$userId?>">
                <button class="rptSbt">変更</button>
            </form>
        </div>
    </body>
</html>