<?php
Route::group(['middleware' => ['web']], function () {

    Route::post('search', '\Bahraminekoo\Employee\Controllers\EmployeeController@search');

    Route::get('manager/{id}/employees', '\Bahraminekoo\Employee\Controllers\EmployeeController@employees');

    Route::resource('employees', '\Bahraminekoo\Employee\Controllers\EmployeeController');

});