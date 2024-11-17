<?php

namespace App\Http\Controllers;
use App\Models\knowledge_base;
use Illuminate\Http\Request;

class knowledge_baseController extends Controller
{
    public function index(){
       
        $create = new knowledge_base();
        $create->title = "sewlyn";
        $create->description = "test";
        $create->save();
        return view('create');
    }
}
