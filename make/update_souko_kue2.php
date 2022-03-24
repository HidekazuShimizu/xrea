<?php
require_once __DIR__ . '/../db_config.php';
require_once __DIR__ . '/../get_post_check.php';

if ($_POST['id'] == NULL) {
    echo "正しい更新ボタンを押してください。";
    exit;
}
//var_dump($_POST);
if ($_POST['drop_item'] != "NULL") {
    $drop_item = (int)$_POST['drop_item'];
} else {
    echo 'アイテム名が正しくありません。';
    exit;
}
$drop_enemy = htmlspecialchars($_POST['drop_enemy'], ENT_QUOTES);
$drop_area1 = htmlspecialchars($_POST['drop_area1'], ENT_QUOTES);
$drop_area2 = htmlspecialchars($_POST['drop_area2'], ENT_QUOTES);
if ($_POST['x'] || $_POST['x'] == "0") {
    $x = (int)htmlspecialchars($_POST['x'], ENT_QUOTES);
} else {
    $x = NULL;
}
if ($_POST['y'] || $_POST['y'] == "0") {
    $y = (int)htmlspecialchars($_POST['y'], ENT_QUOTES);
} else {
    $y = NULL;
}
if ($_POST['height'] || $_POST['height'] == "0") {
    $height = (int)htmlspecialchars($_POST['height'], ENT_QUOTES);
} else {
    $height = NULL;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>倉庫クエアップデート</title>
	<link rel="icon" href="../img/favicon.ico">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="main">
    <h2>倉庫クエ（敵一覧）データ更新</h2>
    <form method="post" action="souko_kue.php?step=<?= htmlspecialchars($step, ENT_QUOTES) ?>">
<?php
echo '<table border="1">' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<th>ドロップアイテム</th><th>ドロップする敵</th><th>エリア１</th><th>エリア２</th><th>x座標</th><th>y座標</th><th>高度</th>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '<tr>' . PHP_EOL;
echo '<td>' . $drop_item_name[$drop_item] . '</td>' . PHP_EOL;
echo '<td>' . $drop_enemy . '</td>' . PHP_EOL;
echo '<td>' . $drop_area1 . '</td>' . PHP_EOL;
echo '<td>' . $drop_area2 . '</td>' . PHP_EOL;
echo '<td>' . $x . '</td>' . PHP_EOL;
echo '<td>' . $y . '</td>' . PHP_EOL;
echo '<td>' . $height . '</td>' . PHP_EOL;
echo '</tr>' . PHP_EOL;
echo '</table>' . PHP_EOL;
echo '<input type="hidden" name="id" value="' . $id . '">';

try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE souko_kue set step = ?, drop_item = ?, drop_enemy = ?, drop_area1 = ?, drop_area2 = ?, x = ?, y = ?, height = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $step, PDO::PARAM_INT);
    $stmt->bindValue(2, $drop_item, PDO::PARAM_INT);
    $stmt->bindValue(3, $drop_enemy, PDO::PARAM_STR);
    $stmt->bindValue(4, $drop_area1, PDO::PARAM_STR);
    $stmt->bindValue(5, $drop_area2, PDO::PARAM_STR);
    $stmt->bindValue(6, $x, PDO::PARAM_INT);
    $stmt->bindValue(7, $y, PDO::PARAM_INT);
    $stmt->bindValue(8, $height, PDO::PARAM_INT);
    $stmt->bindValue(9, $id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo "更新が完了しました。";
} catch (PDOException $e) {
    echo 'エラー発生：更新に失敗しました。' . var_dump($e);
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