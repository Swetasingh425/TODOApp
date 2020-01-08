<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ToDoAppService;
class ToDoAppController extends Controller
{
    //
    public function registerUser(Request $request){
        $payload = $request->all();
        return ToDoAppService::registerUser($payload);
    }

    public function login(Request $request){
        $payload = $request->all();
        return ToDoAppService::login($payload, $request);
    }

    public function logout(Request $request){
        $request->session()->flush();
        return [
            "status" => "ok",
            "message" => "logout succussfuly"
        ];
    }

    public function createToDo(Request $request){
        $payload = $request->all();
     }

    public function updateToDo(Request $request) {
        $payload = $request->all();
        return ToDoAppService::updateToDo($payload, $request);
    }

    public function listToDO(Request $request)
    {
        return ToDoAppService::listToDo($request);
    }

    public function getToDoDetails(Request $request, $id)
    {
        return ToDoAppService::getToDoDetails($request, $id);
    }

    public function completeToDo(Request $request, $id)
    {
        return ToDoAppService::completeToDo($request, $id);
    }

}

