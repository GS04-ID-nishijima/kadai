<?php

include './base/base.php';
include './base/msg.php';
include './base/func.php';

// セッションチェック
session_start();

$shopId = $_POST["shop"];
$_SESSION["shopId"] = $shopId;
$nickname = $_SESSION["nickname"];

$pdo = dbConnect();

// 店名取得
$stmt = $pdo->prepare($getShopNameSQL);

$stmt->bindValue(':id', $shopId);

$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msg007.$error[2]);
}else{
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $shopName = $result['shop_name'];
    }
}

// 開催情報一覧取得
$stmt = $pdo->prepare($getHoldInfoByShopIdSQL);

$stmt->bindValue(':shopId', $shopId);

$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msg007.$error[2]);
}else{
    $placeView = '';
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $placeView .= '<option value="'. $result['id'] . '">' . $result['hold_ymd'] . '@'.$result['place_nmae'].'</option>';
    }
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
            <h2><?=$shopName?>：<?=$nickname?>さんの買いレポ＆食レポ作成</h2>
            <a href="./selectShop.php">TOPに戻る</a><br>
        </div>

        <div id="inputReport">
            <form action="registReport.php" method="post" enctype="multipart/form-data">
                <ul class="clearfix">
                    <li><label class="titleLabel">購入場所</label></li>
                    <li><div class="formArea">
                        <select name="holdInfoId">
                            <?=$placeView?>
                        </select>
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel">今後の利用頻度</label></li>
                    <li>
                        <input type="radio" name="repeatEvl" id="repeatEvl1" value="3">
                        <label class="radioLabel" for="repeatEvl1">日常的に！</label>
                    </li>
                    <li>
                        <input type="radio" name="repeatEvl" id="repeatEv2" value="2">
                        <label class="radioLabel" for="repeatEv2">プチ贅沢の時に！</label>
                    </li>
                    <li>
                        <input type="radio" name="repeatEvl" id="repeatEv3" value="1">
                        <label class="radioLabel" for="repeatEv3">利用は少ないかな。</label>
                    </li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel">お値段</label></li>
                    <li>
                        <input type="radio" name="priceEvl" value="3" id="priceEvl1">
                        <label class="radioLabel" for="priceEvl1">お買い得！</label>
                    </li>
                    <li>
                        <input type="radio" name="priceEvl" value="2" id="priceEvl2">
                        <label class="radioLabel" for="priceEvl2">お手頃！</label>
                    </li>
                    <li>
                        <input type="radio" name="priceEvl" value="1" id="priceEvl3">
                        <label class="radioLabel" for="priceEvl3">お高め。</label>
                    </li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel">購入商品</label></li>
                    <li><textarea name="buyPdt" cols="30" rows="3" required></textarea></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel">写真</label></li>
                    <li><div class="formArea">
                        <input type="file" name="photo">
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel">購入金額</label></li>
                    <li><div class="formArea">
                        <input type="number" name="price" min="0" max="99999" required> 円
                    </div></li>
                </ul>
                <ul class="clearfix">
                    <li><label class="titleLabel">感想</label></li>
                    <li>
                        <textarea name="impression" cols="50" rows="5"></textarea>
                    </li>
                </ul>
                <input type="submit" value="投稿" class="rptSbt">
            </form>
        </div>
    </body>
</html>
