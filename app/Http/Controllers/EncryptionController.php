<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\encryption\CaesarEncryption;
use App\encryption\RandomPassword;

class EncryptionController extends Controller
{
    //
    public function ceasar() {
//        $ceasar = new CaesarEncryption('TestaBC1290', 7);
//        
//        $ceasar->encrypt();
//        echo '<br><br>';
//        $ceasar->decrypt();
    }
    
    public function generatePwd() {
        $pwd = new RandomPassword(20, [1, 3, 4]);
    }
}
