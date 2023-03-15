<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){

        try {
            
            return view(
                'user.chats.index'
            );

        } catch (Exception $error) {
            report($error);
        }




    }
}
