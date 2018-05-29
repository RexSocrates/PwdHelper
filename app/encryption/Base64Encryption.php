<?php

namespace App\encryption;

class Base64Encryption
{
    public $plainText = '';
    public $cypherText = '';
    
    function __construct($plainText) {
        $this->plainText = $plainText;
    }
    
    // 加密
    public function encode() {
        $this->cypherText = base64_encode($this->plainText);
        return $this->cypherText;
    }
    
    // 解密
    public function decode($cypherText) {
        $this->plainText = base64_decode($cypherText);
        return $this->plainText;
    }
}
