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
    // 取得功能列表(主頁面)
    public function getFunctionsList() {
        return view('index');
    }
    
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
        
        // 取得加密的檔案內容
        $fileContent = $this->getCipherText($data['encryptionMethod'], $data['websiteName'], $data['accountName'], $data['password']);
        
        $file = new PrepareFile($fileContent['encryptionIndex'], $fileContent['text']);
        $file->write();
        
        return view('encryptedFileDownload', [
            'fileName' => $file->fileName,
        ]);
        
    }
    
    // 加密過程
    public function getCipherText($encryptionMethod, $website, $account, $pwd) {
        $encryptionMethodIndex = 0;
        
        // 紀錄檔案內容的變數
        $prefix = '';
        $siteNameCipher = '';
        $accountNameCipher = '';
        $pwdCipher = '';
        
        // 加密物件變數
        $encryptionVar = NULL;
        
        
        switch($encryptionMethod) {
            case 'Caesar' :
                $encryptionMethodIndex = 1;
                
                // 隨機決定位移量
                $movement = rand(1, 10);
                
                $encryptionVar = new CaesarEncryption($movement);
                
                $prefix = $encryptionMethodIndex.'-'.$movement.'-';
                
                break;
                
            case 'Base 64' :
                $encryptionMethodIndex = 2;
                
                $encryptionVar = new Base64Encryption();
                
                $prefix = $encryptionMethodIndex.'-';
                break;
            case 'URL encryption' :
                $encryptionMethodIndex = 3;
                
                $urlencryption = new URLEncryption();
                
                $prefix = $encryptionMethodIndex.'-';
                break;
            case 'DES' :
                $encryptionMethodIndex = 4;
                
                // 金鑰使用 123456789
                $desEncryption = new DesEncryptipon('123456789');
                
                $prefix = $encryptionMethodIndex.'-';
        }
        
        if($encryptionVar != NULL) {
            $siteNameCipher = $encryptionVar->encrypt($website);
            $accountNameCipher = $encryptionVar->encrypt($account);
            $pwdCipher = $encryptionVar->encrypt($pwd);
        }else {
            echo 'Something went wrong<br>';
        }
        
        $fileContent = [
            'encryptionIndex' => $encryptionMethodIndex,
            'text' => $prefix.$siteNameCipher.'-'.$accountNameCipher.'-'.$pwdCipher
        ];
        
        // 回傳給使用者的檔案內容
        return $fileContent;
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
        
        // 取得明文
        $pwdDic = $this->getPlainText($cipherArr);
        
        $pwdList = [$pwdDic];
        
        return view('passwordlist', [
            'pwdList' => $pwdList
        ]);
        
    }
    
    // 將解密功能獨立寫出來
    public function getPlainText($cipherArr) {
        
        // 解析加密方式
//        echo 'Encryption : '.$cipherArr[0].'<br>';
        
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
                
                $siteName = $base->decrypt($cipherArr[1]);
                $accountName = $base->decrypt($cipherArr[2]);
                $pwd = $base->decrypt($cipherArr[3]);
                
                break;
            case '3' : 
                // URL
//                echo 'url<br>';
                
                $urlEnc = new URLEncryption();
                
                $siteName = $urlEnc->decrypt($cipherArr[1]);
                $accountName = $urlEnc->decrypt($cipherArr[2]);
                $pwd = $urlEnc->decrypt($cipherArr[3]);
                
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
        
        return $pwdDic;
    }
    
    // 取得隨機產生密碼的頁面
    public function getRandomPwdPage() {
        $encryptions = [
            'Caesar',
            'Base 64',
            'URL encryption',
            'DES'
        ];
        
        return view('randomPwd', [
            'encryptions' => $encryptions
        ]);
    }
    
    // 產生隨機密碼後進行加密
    public function getRandomPwd(Request $request) {
        $data = $request->all();
        
        // 取得網站名稱
        $websiteName = $data['website'];
        
        // 取得帳號名稱
        $accountName = $data['account'];
        
        // 所需密碼長度
        $pwdLength = $data['pwdLength'];
        
        // 密碼涵蓋內容
        $rules = $data['rule'];
        
        // 將字串轉為數字
        $demand = [];
        for($i = 0; $i < count($rules); $i++) {
            $demand[$i] = intval($rules[$i]);
        }
        
        $pwdObj = new RandomPassword($pwdLength, $demand);
        
        // 取得隨機密碼
        $newPwd = $pwdObj->generate();
        
        // 取得加密方式
        $encryptionMethod = $data['encryptionMethod'];
        
        echo $encryptionMethod;
        
        $fileContent = $this->getCipherText($encryptionMethod, $websiteName, $accountName, $newPwd);
        
        $file = new PrepareFile($fileContent['encryptionIndex'], $fileContent['text']);
        $file->write();
        
        return view('encryptedFileDownload', [
            'fileName' => $file->fileName,
        ]);
    }
    
    // 取得更換加密方式的頁面
    public function getEncryptionChangePage() {
        $encryptions = [
            'Caesar',
            'Base 64',
            'URL encryption',
            'DES'
        ];
        
        return view('changeEncryption', [
            'encryptions' => $encryptions
        ]);
    }
    
    // 送出表單並更換加密方式
    public function changeEncryptionMethod(Request $request) {
        $data = $request->all();
        
        // 取得新的加密方式
        $newEncryptionMethod = $data['newEncryptionMethod'];
        
        // 讀取密文並解密
        $cipherText = $data['cipherText'];
        
        $pwdDic = $this->getPlainText(explode('-', $cipherText));
        
        // 取得解密過後的各項資料
        $websiteName = $pwdDic['websiteName'];
        $accountName = $pwdDic['accountName'];
        $pwd = $pwdDic['pwd'];
        
        // 加資料進行加密並取得加密過後的檔案內容
        $fileContent = $this->getCipherText($newEncryptionMethod, $websiteName, $accountName, $pwd);
        
        $file = new PrepareFile($fileContent['encryptionIndex'], $fileContent['text']);
        $file->write();
        
        return view('encryptedFileDownload', [
            'fileName' => $file->fileName,
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
