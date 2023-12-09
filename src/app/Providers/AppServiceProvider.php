<?php

namespace App\Providers;

use App\Dictionaries\ErrorDictionary;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SuccessResource::withoutWrapping();

        Response::macro('success', function ($data = []) {
            return new SuccessResource($data);
        });

        Response::macro('error', function ($err = null, $msg = null) {
            $statusCode = ErrorDictionary::getStatusCode($err);

            $data = [
                'err' => $err,
                'msg' => $msg ?? ErrorDictionary::getErrorMessage($err)
            ];

            return (new ErrorResource($data))->response()->setStatusCode($statusCode);
        });
    }
}
