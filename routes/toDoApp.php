<?php

use App\Http\Controllers\ToDoAppController;

Route::get("/todo", "ToDoAppController@listToDo");
Route::post("/signup", "ToDoAPPController@registerUser");
Route::post("/login", "ToDoAppController@login");
Route::get("/logout", "ToDoAppController@logout");
Route::post("/todo", "ToDoAppController@createToDo");
Route::put("/todo", "ToDoAppController@updateToDo");
Route::get("/todo/{id}", "ToDoAppController@getToDoDetails");
Route::get("/todo/{id}/done", "ToDoAppController@completeToDo");
Route::get("/form", "ToDoAppController@form");
//Route::delete("/todo/{id}", "ToDoAppController@deleteToDo");
//Route::post("/todo", "ToDoAppController@reminderToDo");
