<?php

include './base/base.php';

$holdInfoId = $_POST["holdInfoId"];
$repeatEvl = $_POST["repeatEvl"];
$priceEvl = $_POST["priceEvl"];
$buyPdt = htmlEnc($_POST["buyPdt"]);
$price = $_POST["price"];
$impression = htmlEnc($_POST["impression"]);

session_start();

// ログイン状態のチェック
if (!isset($_SESSION["userId"])) {
    header("Location: index.php");
    exit();
} else {
    $userId = $_SESSION["userId"];
    $nickname = $_SESSION["nickname"];
    $shopId = $_SESSION["shopId"];
}

$pdo = new PDO($datasource, $dbUser,$dbPass);

// 店名取得
$stmt = $pdo->prepare($getShopNameSQL);

$stmt->bindValue(':id', $shopId);

$flag = $stmt->execute();

if($flag==false){
    var_dump($stmt);
    echo "SQLエラー:shop";
}else{
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $shopName = $result['shop_name'];
    }
}

// 開催日と開催場所名、場所IDを取得
$stmt = $pdo->prepare($getHoldInfoByHoldInfoIdSQL);

$stmt->bindValue(':id', $holdInfoId);

$flag = $stmt->execute();

if($flag==false){
    var_dump($stmt);
    echo "SQLエラー:holdInfo";
}else{
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $hold_ymd = $result['hold_ymd'];
        $place_id = $result['place_id'];
        $place_name = $result['place_name'];
    }
}

// 投稿を登録
$stmt = $pdo->prepare($insShopReportSQL);

$stmt->bindValue(':shopId', $shopId);
$stmt->bindValue(':reportUserId', $userId);
$stmt->bindValue(':holdYmd', $hold_ymd);
$stmt->bindValue(':placeId', $place_id);
$stmt->bindValue(':repeatEvl', $repeatEvl);
$stmt->bindValue(':priceEvl', $priceEvl);
$stmt->bindValue(':buyPdt', $buyPdt);
$stmt->bindValue(':price', $price);
$stmt->bindValue(':impression', $impression);

$flag = $stmt->execute();

if($flag==false){
    var_dump($stmt);
    echo "SQLエラー:ins";
}else{
    $reportCnt = $pdo->lastInsertId();
}

$uploadFilePath;
$reportCnt;

// ファイルアップロード処理
if($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES["photo"]["tmp_name"];
    $uploadName = $_FILES["photo"]["name"];
    mkdir("$baseUploadDirPath/$reportCnt", 0755);
    $path_parts = pathinfo($uploadName);

    $uploadFilePath = "$baseUploadDirPath/$reportCnt/1.$path_parts[extension]";

    if(move_uploaded_file($tmp_name, $uploadFilePath)) {
//        echo "upload OK";
    } else {
        echo "upload NG";
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
                <h2><?=$shopName?>：<?=$nickname?>さんの買いレポ＆食レポを登録しました。</h2>
                <a href="./selectShop.php">TOPに戻る</a><br>
        </div>
        <div id="inputReport">
            <p>写真:<?php
                    echo "<img src=\"$uploadFilePath\">";
                ?></p>
            <p>ニックネーム:<?=$shopName?></p>
            <p>購入場所:<?=$hold_ymd?>@<?=$place_name?></p>
            <p>リピート:<?=getRepeatEvlText($repeatEvl)?></p>
            <p>お値段:<?=getPriceEvlText($priceEvl)?></p>
            <p>購入商品:<?=$buyPdt?></p>
            <p>購入金額:<?=$price?> 円</p>
            <p>感想:<?=$impression?></p>
        </div>
    </body>
</html>
