<?php

class RemoteUploadAPI
{
    private $api_key;
    private $base_url = "https://doodapi.com/api/";

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    private function sendRequest($url)
    {
        // CURL kullanarak API'ye HTTP isteği gönderen fonksiyon
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // API'den gelen JSON yanıtını diziye çevirerek döndürme
        return json_decode($response, true);
    }

    public function remoteUpload($url, $fld_id = null, $new_title = null)
    {
        // Remote Upload API'sini kullanarak dosya yükleme işlemi
        $url = $this->base_url . "upload/url?key={$this->api_key}&url={$url}";

        if ($fld_id) {
            $url .= "&fld_id={$fld_id}";
        }

        if ($new_title) {
            $url .= "&new_title={$new_title}";
        }

        return $this->sendRequest($url);
    }

    public function remoteUploadList()
    {
        // Remote Upload List API'sini kullanarak uzaktan yükleme listesini alma işlemi
        $url = $this->base_url . "urlupload/list?key={$this->api_key}";
        return $this->sendRequest($url);
    }

    public function remoteUploadStatus($file_code)
    {
        // Remote Upload Status API'sini kullanarak dosya durumunu sorgulama işlemi
        $url = $this->base_url . "urlupload/status?key={$this->api_key}&file_code={$file_code}";
        return $this->sendRequest($url);
    }

    public function remoteUploadSlots()
    {
        // Kullanılabilir uzaktan yükleme slotlarını alma işlemi
        $url = $this->base_url . "urlupload/slots?key={$this->api_key}";
        return $this->sendRequest($url);
    }

    public function listFiles($page = null, $per_page = null, $fld_id = null, $created = null)
    {
        // Tüm dosyaları listeleme işlemi
        $url = $this->base_url . "file/list?key={$this->api_key}";

        if ($page) {
            $url .= "&page={$page}";
        }

        if ($per_page) {
            $url .= "&per_page={$per_page}";
        }

        if ($fld_id) {
            $url .= "&fld_id={$fld_id}";
        }

        if ($created) {
            $url .= "&created={$created}";
        }

        return $this->sendRequest($url);
    }

    public function fileStatus($file_code)
    {
        // Dosya durumunu kontrol etme işlemi
        $url = $this->base_url . "file/check?key={$this->api_key}&file_code={$file_code}";
        return $this->sendRequest($url);
    }

    public function fileInfo($file_code)
    {
        // Dosya bilgilerini alma işlemi
        $url = $this->base_url . "file/info?key={$this->api_key}&file_code={$file_code}";
        return $this->sendRequest($url);
    }

    public function fileRename($file_code, $title)
    {
        // Dosya yeniden adlandırma işlemi
        $url = $this->base_url . "file/rename?key={$this->api_key}&file_code={$file_code}&title={$title}";
        return $this->sendRequest($url);
    }
}

// Kullanım örneği:
$api_key = "your_api_key";
$remoteUploadAPI = new RemoteUploadAPI($api_key);

// Remote Upload
$remoteUploadResponse = $remoteUploadAPI->remoteUpload("https://example.com/file.zip", null, "New File");
print_r($remoteUploadResponse);

// Remote Upload List
$remoteUploadListResponse = $remoteUploadAPI->remoteUploadList();
print_r($remoteUploadListResponse);

// Remote Upload Status
$fileCode = "98zukoh5jqiw"; // Önceki işlem sonucundan alınan file code
$remoteUploadStatusResponse = $remoteUploadAPI->remoteUploadStatus($fileCode);
print_r($remoteUploadStatusResponse);

// Remote Upload Slots
$remoteUploadSlotsResponse = $remoteUploadAPI->remoteUploadSlots();
print_r($remoteUploadSlotsResponse);

// List Files
$listFilesResponse = $remoteUploadAPI->listFiles();
print_r($listFilesResponse);

// File Status
$fileStatusResponse = $remoteUploadAPI->fileStatus($fileCode);
print_r($fileStatusResponse);

// File Info
$fileInfoResponse = $remoteUploadAPI->fileInfo($fileCode);
print_r($fileInfoResponse);

// File Rename
$newTitle = "New Title";
$fileRenameResponse = $remoteUploadAPI->fileRename($fileCode, $newTitle);
print_r($fileRenameResponse);

?>
