<?php

namespace App\Providers;

use Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data, $status = 200, $code = null) {
            $code = is_null($code) ? $status : $code;

            return Response::json([
                'success'  => true,
                'code' => $code,
                'data' => $data
            ], $status);
        });

        Response::macro('error', function ($errors, $status = 400, $code = null) {
            
            $code = is_null($code) ? $status : $code;

            $response = [
                'success'  => false,
                'code' => $code,
            ];

            if (is_array($errors)) {
                $response += [
                    'errors' => $errors
                ];
            } else {
                $response += [
                    'message' => $errors
                ];
            }

            return Response::json($response, $status);
        });

        Response::macro('withMeta', function ($data) {
            return Response::json([
                'code' => 200,
                'data' => array_except($data, ['meta']),
                'meta' => array_get($data, 'meta'),
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        
    }
}