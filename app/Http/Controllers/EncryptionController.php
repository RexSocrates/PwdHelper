<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

// Encryption
use App\encryption\CaesarEncryption;
use App\encryption\Base64Encryption;
use App\encryption\URLEncryption;
use App\encryption\DesEncryptipon;

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
            'DES'
        ];
        
        return view('encryptionList', [
            'encryptions' => $encryptions
        ]);
    }
    
    // 送出密碼內容後進行加密
    public function encrypt(Request $request) {
        $data = $request->all();
        
        // 網站名稱
        $websiteName = $data['websiteName'];
        
        // 帳號名稱
        $accountName = $data['accountName'];
        
        // 初始化記錄密文的變數
        $encryptionIndex = 0;
        $fileContent = '';
        // 依照所選加密方式進行加密
        switch ($data['encryptionMethod']) {
            case 'Caesar' : 
                $encryptionIndex = 1;
                
                // 密碼位移量
                $movement = rand(1, 10);
                
                // 建立密碼加密物件
                $caesar = new CaesarEncryption($movement);
                
                $pwdCipher = $caesar->encrypt($data['password']);
                
                // 密碼紀錄前綴
                $prefix = $encryptionIndex.'-'.$movement.'-';
                
                // 網站名稱的密文
                $siteNameCipher = $caesar->encrypt($websiteName);
                
                // 帳號的密文
                $accountCipher = $caesar->encrypt($accountName);
                
                // 檔案內容加入密碼部分，檔案內容：加密編號0-移動量1-網站名稱2-帳號名稱3-密碼4
                $fileContent = $prefix.$siteNameCipher.'-'.$accountCipher.'-'.$pwdCipher;
                break;
            case 'Base 64' : 
                $encryptionIndex = 2;
                
                $base64 = new Base64Encryption();
                
                // 密碼前綴
                $prefix = $encryptionIndex.'-';
                
                // 網站名稱
                $siteNameCipher = $base64->encode($websiteName);
                
                // 帳號名稱
                $accountCipher = $base64->encode($accountName);
                
                // 密碼
                $pwdCipher = $base64->encode($data['password']);
                
                // 檔案內容，檔案內容：加密編號0-網站名稱1-帳號名稱2-密碼3
                $fileContent = $prefix.$siteNameCipher.'-'.$accountCipher.'-'.$pwdCipher;
                break;
            case 'URL encryption' :
                $encryptionIndex = 3;
                
                $urlencryption = new URLEncryption();
                
                // 密碼前綴
                $prefix = $encryptionIndex.'-';
                
                // 網站名稱
                $siteNameCipher = $urlencryption->encode($websiteName);
                
                // 帳號名稱
                $accountCipher = $urlencryption->encode($accountName);
                
                // 密碼
                $pwdCipher = $urlencryption->encode($data['password']);
                
                // 檔案內容，檔案內容：加密編號0-網站名稱1-帳號名稱2-密碼3
                $fileContent = $prefix.$siteNameCipher.'-'.$accountCipher.'-'.$pwdCipher;
                break;
            case 'DES' :
                $encryptionIndex = 4;
                
                // 金鑰使用 123456789
                $desEncryption = new DesEncryptipon('123456789');
                
                // 密碼前綴
                $prefix = $encryptionIndex.'-';
                
                // 網站名稱
                $siteNameCipher = $desEncryption->encrypt($websiteName);
                
                // 帳號名稱
                $accountCipher = $desEncryption->encrypt($accountName);
                
                // 密碼
                $pwdCipher = $desEncryption->encrypt($data['password']);
                
                // 檔案內容，檔案內容：加密編號0-網站名稱1-帳號名稱2-密碼3
                $fileContent = $prefix.$siteNameCipher.'-'.$accountCipher.'-'.$pwdCipher;
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
        // Plain text
        $siteName = '';
        $accountName = '';
        $pwd = '';
        
        $data = $request->all();
        
        // 取得加密後的文字
        $ciphertext = $data['cypherText'];
        
        // 切割密文
        $cipherArr = explode('-', $ciphertext);
        
        // 解析加密方式
        echo 'Encryption : '.$cipherArr[0].'<br>';
        
        switch($cipherArr[0]) {
            case '1' : 
                // Caesar encryption
//                echo 'Caesar<br>';
                
                // 設定文字位移量
//                echo 'Offset : '.$cipherArr[1].'<br>';
                $caesar = new CaesarEncryption($cipherArr[1]);
                
                // 進行解密
                $siteName = $caesar->decrypt($cipherArr[2]);
//                echo '網站名稱 : '.$siteName.'<br>';
                
                $accountName = $caesar->decrypt($cipherArr[3]);
//                echo '帳號名稱 : '.$plain$accountNametext.'<br>';
                
                $pwd = $caesar->decrypt($cipherArr[4]);
//                echo '密碼名稱 : '.$pwd.'<br>';
                
                break;
            case '2' : 
                // Base 64
//                echo 'base 64<br>';
                
                $base = new Base64Encryption();
                
                $siteName = $base->decode($cipherArr[1]);
                $accountName = $base->decode($cipherArr[2]);
                $pwd = $base->decode($cipherArr[3]);
                
                break;
            case '3' : 
                // URL
//                echo 'url<br>';
                
                $urlEnc = new URLEncryption();
                
                $siteName = $urlEnc->decode($cipherArr[1]);
                $accountName = $urlEnc->decode($cipherArr[2]);
                $pwd = $urlEnc->decode($cipherArr[3]);
                
                break;
            case '4' :
//                echo 'DES<br>';
                
                $des = new DesEncryptipon('123456789');
                
                $siteName = $des->decrypt($cipherArr[1]);
                $accountName = $des->decrypt($cipherArr[2]);
                $pwd = $des->decrypt($cipherArr[3]);
        }
        
//        echo '網站名稱：'.$siteName.'<br>';
//        echo '帳號名稱：'.$accountName.'<br>';
//        echo '密碼名稱：'.$pwd.'<br>';
        
        $pwdDic = [
            'websiteName' => $siteName,
            'accountName' => $accountName,
            'pwd' => $pwd
        ];
        
        $pwdList = [$pwdDic];
        
        return view('passwordlist', [
            'pwdList' => $pwdList
        ]);
        
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
