<?php

namespace App\encryption;

class URLEncryption
{
    public $insert = "文字"; // 讓 urlencode 作用
    public $fake = "0"; // 給 urlencode 值用的
    
    public function __contruct() {
        // nothing
    }
    
    public function encrypt($pwd) {
//        echo "Encode: ";
        $this -> fake = md5(rand()); // 讓每次結果不一樣，看起來像密文
        $pwd = str_rot13(urlencode(base64_encode(base64_encode($pwd)).$this -> fake));
        return $pwd;
    }
    
    public function decrypt($pwd) {
//        echo "Decode: ";
        $pwd = base64_decode(base64_decode(substr(urldecode(str_rot13($pwd)),0,-32)));
        return $pwd;
    }
}
