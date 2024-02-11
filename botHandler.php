<?php 
require_once __DIR__."/config.php";

// Получаем все обращения от бота
$query = json_decode(file_get_contents("PHP://input"));


if(isset($query)){
    if($query->message->text !== '/start') return;
    // Если юзер нажал на старт то забираем из json имю, фамилию и чат id и записываем в бд
    $user = $query->message->from;
    $fullName = $user->first_name." ".$user->last_name;
    $id   = $query->message->chat->id;
    $db->add("users", [NULL, $id, $fullName, "telegram"]);

    
}




?>