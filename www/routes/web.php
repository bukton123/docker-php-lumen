<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return response()->json([ 
        "list_api" => [
            "/users" => [
                "title" => "Get users all",
                "method" => "GET",
            ]
        ]
     ], 200);
});

$router->get('/users', function () use ($router) {

    for ($i=0;$i <= rand(1000, 10000);$i++) {
        $faker = Faker\Factory::create();
        
        $data[] = [
            "id"          => $faker->uuid,
            "name"        => $faker->name,
            "address"     => $faker->address,
            "email"       => $faker->safeEmail(),
            "timezone"    => $faker->iso8601(),
        ];
    }

    return response()->json([
        "count"   => count($data),
        "results" => $data
    ], 200);
});


// $router->getRoutes('{any:.*}', function () use ($router) {
//     return $router->app->version();
// });