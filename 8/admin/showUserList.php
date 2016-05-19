<?php

include '../base/base.php';
include '../base/msg.php';

session_start();

// ログイン状態のチェック
if (!isset($_SESSION["userId"])) {
    header("Location: index.php");
    exit();
} else {
    $userId = $_SESSION["userId"];
}

try {
    $pdo = new PDO($datasource, $dbUser,$dbPass);
} catch (PDOException $e) {
    exit($msgDbConnectError.$e->getMessage());
}


// ユーザー情報一覧取得
$stmt = $pdo->prepare($getUserListSQL);

$flag = $stmt->execute();

if($flag==false){
    $error = $stmt->errorInfo();
    exit($msgQueryError.$error[2]);
}else{
    $view = "";
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<tr><th>'.$result['id'].'</th><th>'.$result['email'].'</th><th>'.$result['nickname'].'</th><th>'.$result['authority'].'</th><th>'.$result['shop_name'].'</th>';
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
            <h2>ユーザ一覧</h2>
            <a href="../index.php">TOPに戻る</a>
        </div>
s        <div id="showUser">
            <table>
                <thead>
                    <tr><th class="thId">ID</th><th class="thEmail">email</th><th class="thNickname">ニックネーム</th><th class="thAuthority">権限</th><th class="thShopName">店名</th></tr>
                </thead>
                <tbody>
                    <?=$view?>
                </tbody>
            </table>
        </div>
    </body>
</html>