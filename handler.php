<?php 
require_once __DIR__."/config.php";

// Включаем буфер вывода
ob_start();

// Запрос на получение логов если они есть (doc.error.json)
if(isset($_GET['logs'])){
    $file = file_get_contents("doc.error.json");
    die($file === '' ? json_encode([]) : $file);
}


// Отправка сообщений
if(isset($_POST['doc'])){
    $doc = $_POST['doc'];
    $errors = 0; // кол-во неудачных отправок
    foreach($_POST as $key => $value){
        if($key === 'doc' || $key === "checkAll") continue;
        // Получаем id юзера из чекбоксов
        $id = str_replace("user-", "", $key);
        // Запрашиваем юзера из бд
        $user = $db->select("test_users WHERE id = $id", "*");
        
        $userId = $user[0]['user_id'];
        
        // Проверка типа отправки (тг, эл. почта)
        switch($user[0]['send_type']){
            
            case "email": {
                $send = $mail->sendFile($userId, "PDF Reader", "Вам письмо", $doc);
                if(!$send){
                    writeLog("Не удалось отправить файл пользователью {$user[0]['user_id']}({$user[0]['full_name']}) на почту.", true);
                    $errors++;
                } break;
            }

            case "telegram": {
                $send = json_decode($bot->sendDocument($doc, $userId));
                if(!$send->ok){
                    writeLog("Не удалось отправить файл пользователью {$user[0]['user_id']}({$user[0]['full_name']}) в телеграм.", true);
                    $errors++;
                } break;
            }
        }

    }

    // Удаляем документ
    deleteFile($doc);

    $message = $errors === 0 ? "success=Сообщение успешно отправлены!" : "error=Не удалось отправить сообщение $errors из".strval(count($_POST) - 1).". Подробнее в разделе 'Ошибки'";
    
    // Переадресация на index
    header("Location: index.php?".$message);
    

}else header("Location: index.php");






?>