<?php
require_once __DIR__ . '/../db_config.php';
require_once __DIR__ . '/../get_post_check.php';

if ($_POST['drop_item'] == '選択してください') {
    echo "ドロップアイテム名を選択してください。";
    exit;
}
//print_r($_POST);

$drop_item = (int)$_POST['drop_item'];
$drop_enemy = htmlspecialchars($_POST['drop_enemy'], ENT_QUOTES);
$drop_area1 = htmlspecialchars($_POST['drop_area1'], ENT_QUOTES);
$drop_area2 = htmlspecialchars($_POST['drop_area2'], ENT_QUOTES);
if ($_POST['x'] || $_POST['x'] == "0") {
    $x = (int)$_POST['x'];
} else {
    $x = NULL;
}
if ($_POST['y'] || $_POST['y'] == "0") {
    $y = (int)$_POST['y'];
} else {
    $y = NULL;
}
if ($_POST['height'] || $_POST['height'] == "0") {
    $height = (int)$_POST['height'];
} else {
    $height = NULL;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>倉庫クエインサート</title>
	<link rel="icon" href="../img/favicon.ico">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="main">
    <h2>倉庫クエ（敵一覧）データ新規登録</h2>
    <form method="post" action="souko_kue.php?step=<?= htmlspecialchars($step, ENT_QUOTES) ?>">
        <table border="1">
            <tr>
                <th>ドロップアイテム</th><th>ドロップする敵</th><th>エリア１</th><th>エリア２</th><th>座標</th>
            </tr>
            <tr>
                <td><?= $drop_item_name[$drop_item]; ?></td>
                <td><?= $drop_enemy; ?></td>
                <td><?= $drop_area1; ?></td>
                <td><?= $drop_area2; ?></td>
                <td><?= '(' . $x . ',' . $y . ')↑' . $height; ?></td>
            </tr>
        </table>
<?php
try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO souko_kue (step, drop_item, drop_enemy, drop_area1, drop_area2, x, y, height) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $step, PDO::PARAM_INT);
    $stmt->bindValue(2, $drop_item, PDO::PARAM_INT);
    $stmt->bindValue(3, $drop_enemy, PDO::PARAM_STR);
    $stmt->bindValue(4, $drop_area1, PDO::PARAM_STR);
    $stmt->bindValue(5, $drop_area2, PDO::PARAM_STR);
    $stmt->bindValue(6, $x, PDO::PARAM_INT);
    $stmt->bindValue(7, $y, PDO::PARAM_INT);
    $stmt->bindValue(8, $height, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo "登録が完了しました。";
} catch (PDOException $e) {
    echo 'エラー発生：登録に失敗しました。';
    exit;
}
?>
        <br>
        <table>
            <tr>
                <th>
                    <input type="submit" value="戻る">
                </th>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>