<?php

include './base/base.php';
include './base/func.php';

// セッションチェック
sessionCheck();

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
    exit("QueryError:".$error[2]);
}else{
    if( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $shopName = $result['shop_name'];
    }
}

// 投稿取得
$stmt = $pdo->prepare($getReportByShopIddSQL);

$stmt->bindValue(':shopId', $shopId);
$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}else{
    $reportView = '';
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){

        $id = $result['id'];

        // 写真読み込み
        if(is_dir("$baseUploadDirPath/$id")) {
            $fileArray = array();
            $handle = opendir("$baseUploadDirPath/$id");
            while(false !== ($entry = readdir($handle))) {
                if( $entry != '.' && $entry != '..') {
                    array_push($fileArray, $entry);
                }
            }
            closedir($handle);
        }

        $reportView .= '<div id="outputReport">';
        $reportView .= '<p>投稿日：'.$result['report_ymdhm'].'</p>';
        $reportView .= '<p>写真:<img src="'."$baseUploadDirPath/$id/$fileArray[0]".'"></p>';
        $reportView .= '<p>ニックネーム:'.$result['nickname'].'</p>';
        $reportView .= '<p>購入場所:'.$result['hold_ymd'].'@'.$result['place_name'].'</p>';
        $reportView .= '<p>リピート:'.getRepeatEvlText($result['repeat_evl']).'</p>';
        $reportView .= '<p>お値段:'.getRepeatEvlText($result['price_evl']).'</p>';
        $reportView .= '<p>購入商品:'.$result['buy_pdt'].'</p>';
        $reportView .= '<p>購入金額:'.$result['price'].'</p>';
        $reportView .= '<p>感想:'.$result['impression'].'</p>';
        $reportView .= '</div>';
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
            <h2><?=$shopName?>の買いレポ＆食レポ参照</h2>
            <a href="./selectShop.php">TOPに戻る</a><br>
        </div>
        <?=$reportView?>
    </body>
</html>