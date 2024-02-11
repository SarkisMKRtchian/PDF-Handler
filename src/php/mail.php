<?php
require_once __DIR__."/PHPMailer/src/PHPMailer.php";
require_once __DIR__."/PHPMailer/src/SMTP.php";
require_once __DIR__."../../../config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail{
    private PHPMailer $mail;

    /**
     * Настройка конфигурации phpmailer
     * Подключается к серверам mail.ru почта создана только для этого задания
     */
    public function __construct(){
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();                                            
        $this->mail->isHTML(true);                                
        $this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $this->mail->Host       = 'smtp.mail.ru';                    
        $this->mail->SMTPAuth   = true;                                   
        $this->mail->Username   = 'mytestgamil@mail.ru';                  
        $this->mail->Password   = 'Sn1rSP93jdGgipS3sxHw';                 
        $this->mail->Port       = 465;      
        $this->mail->setFrom('mytestgamil@mail.ru', 'Mailer');
    }

    /**
     * Отправка файла по почте
     * @param string $to Получатель
     * @param string $subject Загловок
     * @param string $body Тело (Иожно использовать HTML теги)
     * @param string $fileName Путь до файла
     * @return bool
     */
    public function sendFile(string $to, string $subject, string $body, string $fileName): bool{
        try{
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->addAttachment($fileName);

            $this->mail->send();

            return true;
        }catch (Exception $e) {
            writeLog($e->getMessage(), false);
            return false;
        }
        
    }
}