<?php


const TOKEN = "6899864481:AAHY08_Q9wgWD5q4emgUNcqaSuU0q2IXNkk"; // токен (это тестовый @https://t.me/test_doc_handler_bot)
const HOST_URL = ""; // Адрес хоста для установки вебхука

class BOT{
    // URL для запросов
    private string $url = "https://api.telegram.org/bot".TOKEN; 

    // Получить информацию о боте
    public function getMe(): mixed{
        $ch = $this->getCurl("getMe");

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Отправка документа 
     * @param string $fileName Путь до PDF файла 
     * @param string @chatId   id чата куда надо отправить документ
     * @return bool Если все хорошо - true, иначе false
     */
    public function sendDocument(string $fileName, string $chatId): bool {
        $ch = $this->getCurl("sendDocument?chat_id=".$chatId);
        $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $fileName);
        $cFile = new CURLFile($fileName, $finfo);

        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "document" => $cFile
        ]);

        $result = curl_exec($ch);
        curl_close($ch); 
        
        return $result;
    }


    /**
     * @return string URL для установик вебхука
     */
    public function setWebHook(): string {
        return $this->url."/setWebhook?url=".HOST_URL;
    }

    /**
     * Настройка curl для запросов 
     * @param string $request тип запроса
     * @return CurlHandle  
     */
    private function getCurl(string $request): CurlHandle {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/".$request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        return $ch;
    }

}

?>