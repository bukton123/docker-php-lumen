<?php
namespace App\Http\Middleware;

use Closure;

class AfterMiddleware {
  public function handle($req, Closure $next) {
    $res = $next($req);

    $headers = [
      'Access-Control-Allow-Origin'      => '*',
      'Access-Control-Allow-Methods'     => 'GET, POST, PUT, PATCH, DELETE',
      'Access-Control-Allow-Credentials' => 'true',
      // 'Access-Control-Max-Age'           => '86400',
      'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
      'Content-Type'                     => 'application/json'
    ];

    // $res->header('Access-Control-Allow-Headers', $req->header('Access-Control-Request-Headers'));

    // if ($request->isMethod('OPTIONS'))
    // {
    //     return response()->json('{"method":"OPTIONS"}', 200, $headers);
    // }

    foreach ($headers as $key => $value) {
      $res->header($key, $value);
    }

    return $res;
  }
}