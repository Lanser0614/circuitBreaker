<?php

namespace App\Http\Controllers;

use App\Services\circuitBreaker\CircuitBreakerClass;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    private static int $threshold = 5;
    private static int $delay = 10;

    public function __construct(
        private readonly CircuitBreakerClass $circuitBreaker
    )
    {
        $this->circuitBreaker->setThreshold(self::$threshold)->setDelay(self::$delay);
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $key = __FUNCTION__;
        $this->circuitBreaker->setActionKay($key);

        if ($this->circuitBreaker->isTooManyAttempts()) {
            return $this->failOrFallback($key);
        }

        try {
            $response = Http::timeout(2)->get('https://jsonplaceholder.typicode.om/users')->throw();
            return new JsonResponse($response->json());
        } catch (Exception $exception) {
            $this->circuitBreaker->setDelayOnException(self::$delay);
            throw new Exception( "second exception");
        }
    }


    /**
     * @param string $actionKey
     * @return JsonResponse
     */
    public function failOrFallback(string $actionKey): JsonResponse
    {
        return new JsonResponse([
            "message" => "$actionKey не доступен"
        ]);
    }
}
