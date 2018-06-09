<?php

namespace App\encryption;

class CaesarEncryption
{
    public $plainText = "";
    public $cipherText = "";
    
    public $offset = 0;
    
    public $upperCaseAlphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", 
                          "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    
    public $lowerCaseAlphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "m",
                         "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    
    //特殊符號
    
    
    
    function __construct( $offset) {
        $this->offset = $offset;
    }
    
    // 加密
    function encrypt($text) {
        $this->plainText = $text;
        
        $newCypherText = "";
        for($i = 0; $i < strlen($this->plainText); $i++) {
            $ch = $this->plainText[$i];
            // 先判斷字元是哪一種
            
            // 字元是數字
            if(ctype_digit($ch)) {
                $digit = intval($ch);
                
                $newDigit = ($digit + $this->offset) % 10;
                $newCypherText = $newCypherText.$newDigit;
            }else {
                // 字元是英文字母
                
                // 如果字元是大寫
                if(ctype_upper($ch)) {
                    $newChIndex = (array_search($ch, $this->upperCaseAlphabet) + $this->offset) % count($this->upperCaseAlphabet);
                
                    $newCypherText = $newCypherText.$this->upperCaseAlphabet[$newChIndex];
                }else {
                    // 字元是小寫
                    $newChIndex = (array_search($ch, $this->lowerCaseAlphabet) + $this->offset) % count($this->lowerCaseAlphabet);
                
                    $newCypherText = $newCypherText.$this->lowerCaseAlphabet[$newChIndex];
                }
            }
        }
        
        $this->cipherText = $newCypherText;
        
//        echo $this->plainText.'<br>';
//        echo $this->cipherText.'<br>';
        return $newCypherText;
    }
    
    function decrypt($text) {
        $this->cipherText = $text;
        
//        echo 'Text in caesar : '.$text.'<br>';
//        echo 'Length : '.strlen($text).'<br>';
        
        $decryptedText = "";
        
        for($i = 0; $i < strlen($text); $i++) {
            $ch = $this->cipherText[$i];
            
            $newCh = "";
            
            // 如果目前的字元是數字
            if(ctype_digit($ch)) {
//                echo 'Ch is digit<br>';
                
                // 如果數字 - offset 會變負數
                if((intval($ch) - $this->offset) < 0) {
                    $newCh = (string)(intval($ch) - $this->offset + 10);
                }else {
                    // 直接減OFFSET
                    $newCh = (string)(intval($ch) - $this->offset);
                }
            }else {
                // 目前的字元是字母
//                echo 'Ch is characters<br>';
                
                // 如果是大寫
                if(ctype_upper($ch)) {
                    if((array_search($ch, $this->upperCaseAlphabet) - $this->offset) < 0) {
                        // 減去移動量會小於0
                        $newChIndex = (array_search($ch, $this->upperCaseAlphabet) - $this->offset) + count($this->upperCaseAlphabet);
                        
                        $newCh = $this->upperCaseAlphabet[$newChIndex];
                    }else {
                        // 減去移動量會大於0
                        $newChIndex = (array_search($ch, $this->upperCaseAlphabet) - $this->offset);
                        
                        $newCh = $this->upperCaseAlphabet[$newChIndex];
                    }
                }else {
                    // 字元是小寫
                    if((array_search($ch, $this->lowerCaseAlphabet) - $this->offset) < 0) {
                        // 減去移動量會小於0
                        $newChIndex = (array_search($ch, $this->lowerCaseAlphabet) - $this->offset) + count($this->lowerCaseAlphabet);
                        
                        $newCh = $this->lowerCaseAlphabet[$newChIndex];
                    }else {
                        // 減去移動量會大於0
                        $newChIndex = (array_search($ch, $this->lowerCaseAlphabet) - $this->offset);
                        
                        $newCh = $this->lowerCaseAlphabet[$newChIndex];
                    }
                }
            }
            
//            echo 'New ch : '.$newCh.'<br>';
            
            $decryptedText = $decryptedText.$newCh;
            
        }
//        echo 'Encrypted : '.$this->cipherText.'<br>';
//        echo 'Decrypted : '.$decryptedText.'<br>';
        $this->plainText = $decryptedText;
        
        return $decryptedText;
    }
}
