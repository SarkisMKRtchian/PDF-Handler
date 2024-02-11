<?php
include_once __DIR__."/config.php";

// Сохраняет PDF файл, далее делает редирект на саму себя добавляя в get называние файла(чтобы при перезагрузке страницы не было повторных отправок данных)
if(isset($_FILES['pdf'])){
    $tmp_name  = $_FILES['pdf']['tmp_name'];
    $name      = $_FILES['pdf']['name'];
    $error     = $_FILES['pdf']['error'];
    
    if($error !== 0) die(error('При обработке вашего файла произошла неизвестная ошибка'));
    

    $file_ex = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if($file_ex !== 'pdf') die(error("Пожалуйста загрузитье файл с расширением PDF!"));
    
    $file_name = uniqid("doc-", true).".".$file_ex;
    $path = "uploads/$file_name";
    move_uploaded_file($tmp_name, $path); 

    die(header("Location: edit.php?path=$path"));

}

if(!isset($_GET['path']) || !file_exists($_GET['path'])) header("Location: index.php");


function error(string $text){
    header("Location: index.php?error=$text");
}

// Получаем всех ролзователей из бд
$users = $db->select("users", "*");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="./src/js/edit.js"></script>
    <title>PDF READER</title>
</head>
<body>


    <div class="users">
        <div class="header">
            <button><a href="./index.php">Назад</a></button>
        </div>
        <div class="body">
            <form action="./handler.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="checkAll" id="checkAll"></th>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Full name</th>
                            <th>Send type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($users as $user): ?>
                            <tr data-user="<?=$user['id']?>">
                                <td><input type="checkbox" name="user-<?=$user['id']?>" id="checkbox"></td>
                                <td><?=$user['id']?></td>
                                <td><?=$user['user_id']?></td>
                                <td><?=$user['full_name']?></td>
                                <td><?=$user['send_type']?></td>
                            </tr>
                        <?endforeach?>
                    </tbody>
                    <tbody>
                        <td colspan="4"><input type="text" name="doc" hidden value="<?=$_GET['path']?>"></td>
                        <td><button type="submit">Отправить</button></td>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>
</html>