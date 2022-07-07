<?php


namespace App\Providers;

use App\support\Responses\Codes;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{

    public function boot(ResponseFactory $factory){
        $factory->macro('created', function ($message = '', $data = null, $key = null) use ($factory) {
            $format = [
                'status' => 201,
                'message' => $message,
                $key =>  $data
            ];
            return $factory->make($format);
        });

        $factory->macro('updated', function (string $message = '', $data = null, $key=null) use ($factory){
            $format = [
                'status' => 202,
                'message' => $message,
                $key =>  $data
            ];

            return $factory->make($format);
        });

        $factory->macro('fetch', function (string $message = '', $data = null, $key =  null) use ($factory){
            $format = [
                'status' => 200,
                'message' => $message,
                $key =>  $data
            ];

            return $factory->make($format);
        });

        $factory->macro('deleted', function (string $message = '') use ($factory){
            $format = [
                'status' => 204,
                'message' => $message,
            ];

            return $factory->make($format);
        });
    }

}
