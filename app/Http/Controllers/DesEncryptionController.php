<?php
/**
 * Created by PhpStorm.
 * User: jameswang
 * Date: 2018/6/1
 * Time: 下午 02:23
 */

namespace App\Http\Controllers;
use App\encryption\DesEncryptipon;

class DesEncryptionController extends Controller
{
    public function doDes(){
        $des=new DesEncryptipon('12345678');//若是成功會出現 l9TN9Ln/71IvFRjlhD8PaQ==
        $cipherText = $des->encrypt('test data');
        echo $cipherText;
        echo  '<br><br>';
        echo $des->decrypt($cipherText);
    }
}