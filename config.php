<?php 
include_once __DIR__."/src/php/PHP_MYSQLDB/db.php";
require_once __DIR__."/src/php/bot.php";
require_once __DIR__."/src/php/mail.php";

/**
 * По понятным причинами данные для входа в бд не верные
 * Если хотите проверить у себя то создайтье таблицу users в бд со след. поля: 
 * id int autoincrement   - уникальный идентификатор для юзеров
 * user_id varchar(128)   - для эл. почты или тг чат id
 * full_name varchar(128) - ФИО
 * send_type varchar(64)  - Тип отправки сообщения email/telegram
 * 
 * Библотеку написал я - https://github.com/SarkisMKRtchian/PHP_MYSQLDB
 */
$db   = new MYSQLDB('localhost', 'mydatabase', 'username', 'password');
$bot  = new BOT;
$mail = new Mail;

/**
 * Пишет лог файл
 * @param string $text Сообщения
 * @param bool $isDoc Если false то пишет в обычный лог файл а если true то пишет json файл для вывода в index.html 
 */
function writeLog(string $text, bool $isDoc){
    $date = date('Y-m-d H:i:s');
    $log  = $date." ".$text."\n".PHP_EOL;
    $path = __DIR__.$isDoc ? "doc.error.json" : "/error.log";

    if(!$isDoc) {file_put_contents($path, $log, FILE_APPEND); return;}

    $file = file_get_contents("doc.error.json");

    if($file === '') {file_put_contents("doc.error.log", [$log]); return;}

    $file = json_decode($file);
    array_push($file, $log);
    file_put_contents("doc.error.json", json_encode($file));
    
}

function deleteFile(string $fileName){
    if(file_exists($fileName)) unlink($fileName);
}



?>