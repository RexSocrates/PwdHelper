<?php

namespace App\encryption;

class RandomPassword
{
    // 密碼長度(最大長度)
    public $pwdLenght = 0;
    // 密碼規範紀錄陣列
    public $pwdRule = [];
    // 產生的密碼
    public $pwd = "";
    
    // 1. 是否包含數字
    
    // 2. 大寫英文字母
    public $upperCaseAlphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", 
                          "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    // 3. 小寫英文字母
    public $lowerCaseAlphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "m",
                         "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    // 4. 特殊符號
    public $symbol = "!@#$%^&*";
    
    
    
    public function __construct($length, $rule) {
        // 分析密碼需求
        $this->pwdLength = $length;
        
        // 密碼生成規範
        // 密碼規範 紀錄方式 [1, 2, 3, 4]
        // 1. 表示包含數字
        // 2. 表示包含大寫
        // 3. 表示包含小寫
        // 4. 表示包含特殊符號
        // 例如密碼規範為[1, 3, 4]
        // 表示欲產生之密碼需要包含數字、小寫字母以及特殊符號
        $this->pwdRule = $rule;
        
        $this->generate();
    }
    
    public function generate() {
        $newPwd = "";
        
        do {
            // 先決定這一圈加入的字元
            $chType = $this->pwdRule[rand(0, count($this->pwdRule) - 1)];
            $newCh = '';
            
            switch($chType) {
                case 1 : 
                    $newCh = (string)(rand(0, 9));
                    break;
                case 2 : 
                    $newCh = $this->upperCaseAlphabet[rand(0, count($this->upperCaseAlphabet) - 1)];
                    break;
                case 3 : 
                    $newCh = $this->lowerCaseAlphabet[rand(0, count($this->lowerCaseAlphabet) - 1)];
                    break;
                case 4 : 
                    $newCh = $this->symbol[rand(0, strlen($this->symbol))];
                    break;
            }
            echo 'The new character : '.$newCh.'<br>';
            $newPwd = $newPwd.$newCh;
        }while(strlen($newPwd) < $this->pwdLength);
        
        echo 'New password : '.$newPwd;
        $this->pwd = $newPwd;
    }
}
