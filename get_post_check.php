<?php
// GETの値をチェックする
if (empty($_GET['step'])) {
    echo 'IDを正しく入力してください。';
    exit;
}
$step = (int)$_GET['step'];

switch ($step) {
case 1:
    $drop_item_name = ['冥獣の肉片', '呪術の皮', '元素の粉末', '柔軟な毛皮', '触角', 'サイの角'];
    break;
case 2:
    $drop_item_name = ['冥獣の鋭い爪', '丈夫な皮袋', '元素の破片', '鈍い爪', '蜜', '百草液'];
    break;
default:
    echo 'IDが正しくありません。';
    exit;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = NULL;
}

//var_dump($search);

// POSTの値をチェックする
if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = NULL;
}

//var_dump($id);
?>