<?php

include './base/base.php';

session_start();

// ログイン状態のチェック
if (!isset($_SESSION["userId"])) {
    header("Location: index.php");
    exit();
} else {
    $nickname = $_SESSION["nickname"];
}

// 店一覧取得
$pdo = new PDO($datasource, $dbUser,$dbPass);
$stmt = $pdo->prepare($getShopInfoSQL);

$flag = $stmt->execute();

if($flag==false){
    echo "SQLエラー";
}else{
    $shopView = "";
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $shopView .= '<option value="'. $result['id'] . '">' . $result['shop_name'] . '</option>';
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
            <h2><?=$nickname?>さんの買いレポ＆食レポ作成</h2>
        </div>

        <div id="selectShop">
                <form action="inputReport.php" method="post">
                <ul class="clearfix">
                    <li><label class="titleLabel">お店</label></li>
                    <li><div class="formArea">
                        <select name="shop">
                           <?php
                                echo $shopView;
                            ?>
                        </select>
                    </div></li>
                </ul>
                <input type="submit" value="お店を選択" class="rptSbt">
            </form>
        </div>

        <div class="subheader clearfix">
            <h2>みんなの買いレポ＆食レポをみる</h2>
        </div>

        <div id="selectShop">
                <form action="showReport.php" method="post">
                <ul class="clearfix">
                    <li><label class="titleLabel">お店</label></li>
                    <li><div class="formArea">
                        <select name="shop">
                           <?php
                                echo $shopView;
                            ?>
                        </select>
                    </div></li>
                </ul>
                <input type="submit" value="お店を選択" class="rptSbt">
            </form>
        </div>

        </body>
</html>
