<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonNotFoundResponse extends JsonResponse
{
    public function __construct(string $entityName)
    {
        parent::__construct(['message' => ucfirst($entityName) . ' not found.'], 404);
    }
}
