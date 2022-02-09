<?php

Route::prefix('api')->group(function () {
	Route::get('sma254log', 'Airviro\SMA254Log\SMA254LogController@index');
	Route::get('sma254log/{id}', 'Airviro\SMA254Log\SMA254LogController@show');
	Route::get('sma254log/{uf}/{proceso}', 'Airviro\SMA254Log\SMA254LogController@proceso');
	Route::get('sma254log/{uf}/{proceso}/{dispositivo}', 'Airviro\SMA254Log\SMA254LogController@dispositivo');
	Route::get('sma254log/{uf}/{proceso}/{dispositivo}/{parametro}', 'Airviro\SMA254Log\SMA254LogController@parametro');
	Route::get('sma254log/{uf}/{proceso}/{dispositivo}/{parametro}/{from}', 'Airviro\SMA254Log\SMA254LogController@from');
    Route::get('sma254log/{uf}/{proceso}/{dispositivo}/{parametro}/{from}/{to}', 'Airviro\SMA254Log\SMA254LogController@fromTo');
    Route::get('sma254log/{uf}/{proceso}/{dispositivo}/{parametro}/{from}/{to}/highcharts', 'Airviro\SMA254Log\SMA254LogController@highcharts');
});
