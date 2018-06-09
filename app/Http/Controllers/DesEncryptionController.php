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
        $des=new DesEncryptipon('test data','12345678');//若是成功會出現 l9TN9Ln/71IvFRjlhD8PaQ==
        $des->encrypt();
        echo  '<br><br>';
        $des->decrypt();
    }
}