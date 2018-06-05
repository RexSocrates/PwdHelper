<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

// Encryption
use App\encryption\CaesarEncryption;
use App\encryption\Base64Encryption;
use App\encryption\URLEncryption;

use App\encryption\RandomPassword;
use App\CustomClass\PrepareFile;

class EncryptionController extends Controller
{
    // 取得所有加密方式的列表頁面
    public function getEncryptionsList() {
        $encryptions = [
            'Caesar',
            'Base 64',
            'URL encryption',
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
                $caesar = new CaesarEncryption($movement);
                
                $caesar->encrypt($data['password']);
                
                // 密碼紀錄前綴
                $prefix = $encryptionIndex.'-'.$movement.'-';
                
                // 檔案內容
                $fileContent = $prefix.$caesar->cypherText;
                break;
            case 'Base 64' : 
                $encryptionIndex = 2;
                
                $base64 = new Base64Encryption($data['password']);
                
                // 密碼前綴
                $prefix = $encryptionIndex.'-';
                
                // 檔案內容
                $fileContent = $prefix.$base64->encode();
                break;
            case 'URL encryption' :
                $encryptionIndex = 3;
                
                $urlencryption = new URLEncryption();
                
                // 密碼前綴
                $prefix = $encryptionIndex.'-';
                
                // 檔案內容
                $fileContent = $prefix.$urlencryption->encode($data['password']);
        }
        
        $file = new PrepareFile($encryptionIndex, $fileContent);
        $file->write();
        
        return view('encryptedFileDownload', [
            'fileName' => $file->fileName,
        ]);
        
    }
    
    // 取得解密頁面
    public function getDecryptionPage() {
        return view('textDecrypt');
    }
    
    // 送出表單並解密
    public function decrypt(Request $request) {
        $data = $request->all();
        
        // 取得加密後的文字
        $cyphertext = $data['cypherText'];
        
        // 切割密文
        $cypherArr = explode('-', $cyphertext);
        
        // 解析加密方式
        
        $plaintext = '';
        echo 'Encryption : '.$cypherArr[0].'<br>';
        
        switch($cypherArr[0]) {
            case '1' : 
                // Caesar encryption
                echo 'Caesar<br>';
                
                // 設定文字位移量
                echo 'Offset : '.$cypherArr[1].'<br>';
                $caesar = new CaesarEncryption($cypherArr[1]);
                
                // 進行解密
                echo 'Cypher text : '.$cypherArr[2].'<br>';
                $plaintext = $caesar->decrypt($cypherArr[2]);
                break;
            case '2' : 
                // Base 64
                echo 'base 64<br>';
                $base = new Base64Encryption();
                
                $plaintext = $base->decode($cypherArr[1]);
                
                break;
            case '3' : 
                // URL
                echo 'url<br>';
                $urlEnc = new URLEncryption();
                
                $plaintext = $urlEnc->decode($cypherArr[1]);
                break;
        }
        
        echo 'Plain text : '.$plaintext.'<br>';
    }
    
    // Testing function
    public function downloadFile() {
        return view('encryptedFileDownload');
    }
    
    // 測試凱薩加密
    public function ceasar() {
        $ceasar = new CaesarEncryption(7);
        
        $ceasar->encrypt('TestaBC1290');
        echo '<br><br>';
        $ceasar->decrypt($ceasar->encrypt('TestaBC1290'));
    }
    
    // 測URL加密
    public function test() {
        $mix = new URLEncryption();
        
        $str = 'abc123';
        
        $cypher = $mix->encode($str);
        echo $cypher.'<br>';
        echo $mix->decode($cypher).'<br>';
    }
    
    // 測試隨機生成密碼
    public function generatePwd() {
        $pwd = new RandomPassword(20, [1, 2, 3]);
        
        echo '<br>';
        
        // c3VwZXJuaWtraTEy
        echo base64_decode('c3VwZXJuaWtraTEy');
    }
    
    // 測試檔案讀取
    public function readFile() {
//        $file = fopen('test.txt', 'w');
//        fwrite($file, 'Hello world');
//        fclose($file);
        
        // 讀取server檔案
        $exist = Storage::disk('public')->exists('public/keyFile1.txt');
        echo 'Exist : '.var_dump($exist).'<br>';
        
//        $content = Storage::get($url);
        
//        echo $content;
        
    }
    
    // 測試上傳檔案
    public function fileUpload(Request $request) {
        if($request->hasFile('keyFile')) {
            echo 'There is a file';
            
            $path = $request->keyFile->storeAs('user_upload', 'keyFile1.txt');
            echo $path;
            
//            $file = fopen('storage/app/user_upload/keyFile1.txt', 'r');
        }else {
            echo 'There is no file in the package.';
        }
        echo '<br>';
        
//        $data = $request->all();
        
//        echo var_dump($data);
        
//        $file = Input::file('keyFile');
        
//        echo $file->getClientOriginalName();
        
//        $file = $request->file('keyFile');
        
//        echo $file->getClientOriginalName();
        
//        $myFile = fopen($file, 'r');
//        echo fgets($myFile);
//        fclose($myFile);
        
        
    }
}
