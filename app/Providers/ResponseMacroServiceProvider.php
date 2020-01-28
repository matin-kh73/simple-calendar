<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('notFound', function ($message = null){
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'status_code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        });

        Response::macro('badRequest', function ($message = null){
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'status_code' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        });

        Response::macro('unAuthorized', function ($message = 'This action is unauthorized.'){
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'status_code' =>  Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        });

        Response::macro('created', function ($data = [], $message = null){
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => $message,
                'status_code' => Response::HTTP_CREATED,
            ], Response::HTTP_CREATED);
        });

        Response::macro('success', function ($data = [], $message = null){
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => $message,
                'status_code' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        });


        Response::macro('withoutData', function ($message){
            return response()->json([
                'message' => $message,
                'status_code' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        });

        Response::macro('error', function ($code, $message){
            return response()->json([
                'status' => 'error',
                'errors' => $message,
                'status_code' => $code ?: 500,
            ], $code ?: 500);
        });
    }
}
