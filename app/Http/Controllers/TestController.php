<?php

namespace App\Http\Controllers;

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
