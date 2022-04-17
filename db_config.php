<?php
// DBのユーザー名とパスワード
$user = "moyasea_patako";
$pass = "S8sDruIkILC0jKA6";

// DB接続（ローカル、ネットワーク切り替え）
$dbh = new PDO('mysql:host=localhost;dbname=moyasea_kanbi;charset=utf8', $user, $pass);
//$dbh = new PDO('mysql:host=mysql8.star.ne.jp;dbname=moyasea_kanbi;charset=utf8', $user, $pass);
