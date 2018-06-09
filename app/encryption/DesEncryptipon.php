<?php
/**
 * Created by PhpStorm.
 * User: jameswang
 * Date: 2018/6/1
 * Time: 下午 02:10
 */

namespace App\encryption;

//實作des ebc加密
class DesEncryptipon
{
    private $_secureKey="1234abcd";
    public $plainText="";
    public $cipherText="";

    function __construct($_secureKey)
    {
//        $this->plainText=$plainText;
        $this->_secureKey=$_secureKey;
    }
    
    //加密
    function encrypt($plainText){
        $this->cipherText=openssl_encrypt($plainText,'des-ecb',$this->_secureKey);
        
//        echo $this->plainText.'<br>';
//        echo 'key : '.$this->_secureKey.'<br>';
//        echo $this->cipherText.'<br>';
        
        return $this->cipherText;
    }
    
    //解密
    function decrypt($cipherText){
        $decryptedText=openssl_decrypt($cipherText,'des-ecb',$this->_secureKey);
        
//        echo 'Encrypted : '.$this->cipherText.'<br>';
//        echo 'Key : '.$this->_secureKey.'<br>';
//        echo 'Decrypted : '.$decryptedText.'<br>';
        
        return $decryptedText;
    }
}