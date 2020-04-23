<?php

use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::group(
    ["middleware" => "auth"],
    function () {
        Route::get("/projects", "ProjectsController@index");
        Route::get("/project/create", "ProjectsController@create");
        Route::get("/projects/{project}", "ProjectsController@show");
        Route::post("/projects", "ProjectsController@store");

        Route::post("/projects/{project}/tasks", "ProjectTasksController@store");

        Route::get('/home', 'HomeController@index')->name('home');
    }
);

Auth::routes();
