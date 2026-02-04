<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class JsonErrorController
{
    public function show(Throwable $exception)
    {
        return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode() > 0 ? $exception->getCode() : 500);
    }
}
