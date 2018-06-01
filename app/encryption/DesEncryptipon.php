<?php
/**
 * Created by PhpStorm.
 * User: jameswang
 * Date: 2018/6/1
 * Time: 下午 02:10
 */

namespace App\encryption;


class DesEncryptipon
{
    private $_secureKey="1234abcd";
    public $plainText="";
    public $cipherText="";

    function __construct($plainText,$_secureKey)
    {
        $this->plainText=$plainText;
        $this->_secureKey=$_secureKey;
    }
    //加密
    function encrypt(){
        $this->cipherText=openssl_encrypt($this->plainText,'des-ecb',$this->_secureKey);
        echo $this->plainText.'<br>';
        echo 'key : '.$this->_secureKey.'<br>';
        echo $this->cipherText.'<br>';
    }
    //解密
    function decrypt(){
        $decryptedText=openssl_decrypt($this->cipherText,'des-ecb',$this->_secureKey);
        echo 'Encrypted : '.$this->cipherText.'<br>';
        echo 'Key : '.$this->_secureKey.'<br>';
        echo 'Decrypted : '.$decryptedText.'<br>';
    }
}