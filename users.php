<?php
include_once __DIR__."/config.php";

// Получить всех пользователей из бд
$users = $db->select("users", "*");


// Добавить нового пользователя вручную
if(isset($_POST['addUser'])){
    $sendType = $_POST['send_type'];
    $userId   = $_POST['user_id'];
    $userName = $_POST['fullName'];

    try{
        $db->add('test_users', [NULL, $userId, $userName, $sendType]);
        die(json_encode(true));
    }catch(Exception $ex){
        die(json_encode(false));
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?3">
    <script src="./src/js/users.js"></script>
    <title>PDF Reader</title>
</head>
<body>
    <div class="users">
        <div class="header">
            <button><a href="./index.php">Назад</a></button>
            <button id="add_user">Добавить пользователя</button>
        </div>
        <div class="body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Full name</th>
                        <th>Send type</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach($users as $user): ?>
                        <tr>
                            <td><?=$user['id']?></td>
                            <td><?=$user['user_id']?></td>
                            <td><?=$user['full_name']?></td>
                            <td><?=$user['send_type']?></td>
                        </tr>
                    <?endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>