<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
   public function index(): JsonResponse
   {
      return response()->json([
         'status' => 'ok',
         'message' => 'API is working',
         'data' => [
            'example' => true,
            'timestamp' => now()->toISOString(),
         ],
      ]);
   }
}
