<?php

namespace App\encryption;

class URLEncryption
{
    public $plainText = "";
    public $cipherText = "";
    
    public function __contruct($text) {
        $this->plainText = $text;
    }
    
    public function encode() {
        $this->cypherText = urlencode($this->plainText);
        return $this->cypherText;
    }
    
    public function decode($text) {
        $this->plainText = urldecode($text);
        return $this->plainText;
    }
}
