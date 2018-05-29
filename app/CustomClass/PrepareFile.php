<?php

namespace App\CustomClass;

class PrepareFile
{
    // 凱薩加密檔案紀錄方式
    // [數字] -> 標記加密方式
    // [凱薩加密字母位移量]
    // [加密過後的文字]
    
    public $fileName = '';
    public $encryptionIndex;
    public $fileContent = '';
    
    public function __construct($encryptionIndex, $fileContent) {
        // 檔案名稱依照時間設定
        $this->fileName = date('Y-m-d_H_i_s').'.txt';
        
        // 紀錄加密方式
        $this->encryptionIndex = $encryptionIndex;
        // 加密過後的內容，prefix 已加入
        $this->fileContent = $fileContent;
    }
    
    // 將密文寫入檔案
    public function write() {
        $file = fopen($this->fileName, 'w');
        fwrite($file, $this->fileContent);
        fclose($file);
    }
}
