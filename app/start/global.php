<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';


/*
|--------------------------------------------------------------------------
| Register Cron Event Listener
|--------------------------------------------------------------------------
|
| Next we will register the cronjobs used for garbage collector
|
| Manually called via
| http://music-xml-analyzer.local/cron.php?key=VIs1AGmBKoMhBmY7RWpWMtAXdD3FTLPF
|
*/
Event::listen('cron.collectJobs', function() {
	foreach (User::where('last_activity', '<', date('Y-m-d H:m:s', time() - 24*60*60*7))->get() as $user)
	{
	    $user->uploads->each(function($upload) {

			if (count($upload->result)) {
				$upload->result->delete();
			}
			$upload->delete();
	    });

		$upload_directory = public_path() . '/uploads/' . $user->id;
		$success = Upload::delTree($upload_directory);
		$download_directory = public_path() . '/downloads/' . $user->id;
		$success = Upload::delTree($download_directory);
	    $user->delete();
	}
});
