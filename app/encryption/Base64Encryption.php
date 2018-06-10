<?php

namespace App\encryption;

class Base64Encryption
{
    public $plainText = '';
    public $cypherText = '';
    
    function __construct() {
        // nothing
    }
    
    // 加密
    public function encrypt($text) {
        $this->plainText = $text;
        
        $this->cypherText = base64_encode($this->plainText);
        return $this->cypherText;
    }
    
    // 解密
    public function decrypt($text) {
        $this->cypherText = $text;
        
        $this->plainText = base64_decode($this->cypherText);
        return $this->plainText;
    }
}
