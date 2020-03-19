<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function disableExceptionHandling()
    {
        $this->app->instance(
            ExceptionHandler::class,
            new class($this->app) extends Handler {
                public function report(\Exception $e) { }

                public function render($request, \Exception $e)
                {
                    throw $e;
                }
            });
    }
}
