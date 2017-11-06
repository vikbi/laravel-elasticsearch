<?php

use Illuminate\Http\Request;

// will modify the code aacording to response and sample data
Route::get('/search-user','QueryController@searchUser');
Route::get('/search-company','QueryController@searchCompany');
Route::get('/search-profile','QueryController@searchProfile');
