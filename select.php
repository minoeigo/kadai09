<?php
session_start();

//function h($str){
//  return htmlspecialchars($str, ENT_QUOTES);
//}

//1.  DB接続します

require_once('funcs.php');
loginCheck();
$pdo = db_conn();

//use LDAP\Result;

//try {
  //Password:MAMP='root',XAMPP=''
//  $pdo = new PDO('mysql:dbname=kadai07;charset=utf8;host=localhost','root','root');
//} catch (PDOException $e) {
//  exit('DBConnectError'.$e->getMessage());
//}

//２．データ取得SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_bm_table');
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //成功した場合
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>';
    $view .= '<a href="detail.php?id=' . $result['id'] . '">';
    $view .= $result["date"] . "：" . $result["name"];
    $view .= '</a>';

    if($_SESSION['kanri_flg']){
    $view .= '<a href="delete.php?id=' . $result['id'] . '">';//追記
    $view .= '  [削除]';//追記
    $view .= '</a>';//追記
    }

    $view .= '</p>';

}}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>COLLECTION LIST</title>
<link rel="stylesheet" type="text/css" href="css.css"> 
</head>
<body id="main">
<header>COLLECTION LIST</header>
            <a href="detail.php"></a>
            <?= $view ?>


<hr color="#726659" noshade>
<a href="index.php">COLLECTION RECORD</a>

</body>
</html>
