<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\encryption\CaesarEncryption;
use App\encryption\RandomPassword;

use App\CustomClass\PrepareFile;

class EncryptionController extends Controller
{
    // 取得所有加密方式的列表頁面
    public function getEncryptionsList() {
        $encryptions = [
            'Caesar',
            'Others'
        ];
        
        return view('encryptionList', [
            'encryptions' => $encryptions
        ]);
    }
    
    // 送出密碼內容後進行加密
    public function encrypt(Request $request) {
        $data = $request->all();
//        echo 'Password : '.$data['password'].'<br>';
//        echo 'Encryption : '.$data['encryptionMethod'].'<br>';
        
        // 初始化記錄密文的變數
        $encryptionIndex = 0;
        $fileContent = '';
        // 依照所選加密方式進行加密
        switch ($data['encryptionMethod']) {
            case 'Caesar' : 
                $encryptionIndex = 1;
                
                // 密碼位移量
                $movement = rand(1, 10);
                // 建立物件
                $caesar = new CaesarEncryption($data['password'], $movement);
                
                $caesar->encrypt();
                
                // 密碼紀錄前綴
                $prefix = '1-'.$movement.'-';
                
                // 檔案內容
                $fileContent = $prefix.$caesar->cipherText;
                break;
        }
//        if($data['encryptionMethod'] == 'Caesar') {
//            $encryptionIndex = 1;
//            
//            // 密碼位移量
//            $movement = rand(1, 10);
//            // 建立物件
//            $caesar = new CaesarEncryption($data['password'], $movement);
//            
//            $caesar->encrypt();
//            
//            // 密碼紀錄前綴
//            $prefix = '1-'.$movement.'-';
//            
//            // 檔案內容
//            $fileContent = $prefix.$caesar->cipherText;
//        }else {
//            
//        }
        
        $file = new PrepareFile($encryptionIndex, $fileContent);
        $file->write();
        
//        echo 'File name : '.$file->fileName.'<br>';
        
        return view('encryptedFileDownload', [
            'fileName' => $file->fileName,
        ]);
        
    }
    
    // Testing function
    
    public function downloadFile() {
        return view('encryptedFileDownload');
    }
    
    public function ceasar() {
        $ceasar = new CaesarEncryption('TestaBC1290', 7);
        
        $ceasar->encrypt();
        echo '<br><br>';
        $ceasar->decrypt();
    }
    
    public function generatePwd() {
        $pwd = new RandomPassword(20, [1, 2, 3]);
    }
    
    public function readFile() {
        $file = fopen('test.txt', 'w');
        fwrite($file, 'Hello world');
        fclose($file);
    }
}
