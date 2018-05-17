<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    //
    public function test() {
        $str = "Hello world";
        $arr = ["A", "B", "C"];
        
        echo var_dump(array_search("D", $arr));
    }
}
