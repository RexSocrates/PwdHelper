<?php

namespace App\encryption;

class URLEncryption
{
    public $plainText = "";
    public $cipherText = "";
    
    public function __contruct() {
        // nothing
    }
    
    public function encode($text) {
        $this->plainText = $text;
        
        $this->cypherText = urlencode($this->plainText);
        return $this->cypherText;
    }
    
    public function decode($text) {
        $this->cypherText = $text;
        
        $this->plainText = urldecode($this->cypherText);
        return $this->plainText;
    }
}
