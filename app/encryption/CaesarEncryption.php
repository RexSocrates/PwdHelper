<?php

namespace App\encryption;

class CaesarEncryption
{
    $plainText = "";
    $cipherText = "";
    
    $offset = 0;
    
    $upperCaseAlphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", 
                          "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    
    $lowerCaseAlphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "m"
                         "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    
    
    
    function __construct($plainText, $offset) {
        $this->plainText = $plainText;
        $this->offset = $offset;
    }
    
    // 加密
    function encrypt() {
        $newCypherText = "";
        foreach($this->plainText as $ch) {
            // 先判斷字元是哪一種
            
            // 字元是數字
            if(IntlChar::isdigit($ch)) {
                $digit = intval($ch);
                
                $newDigit = ($digit + $this->offset) % 10;
                $newCypherText = $newCypherText.$newDigit;
            }else {
                // 字元是英文字母
                
                // 如果字元是大寫
                if(ctype_upper($ch)) {
                    $newChIndex = (array_search($ch, $upperCaseAlphabet) + $this->offset) % count($upperCaseAlphabet);
                
                    $newCypherText = $newCypherText.$upperCaseAlphabet[$newChIndex];
                }else {
                    // 字元是小寫
                    $newChIndex = (array_search($ch, $lowerCaseAlphabet) + $this->offset) % count($lowerCaseAlphabet);
                
                    $newCypherText = $newCypherText.$lowerCaseAlphabet[$newChIndex];
                }
            }
        }
        
        $this->cipherText = $newCypherText;
    }
    
    function decrypt() {
        
    }
}
