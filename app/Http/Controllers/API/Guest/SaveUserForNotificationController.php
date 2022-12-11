<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Guest\SaveUserForNotificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveUserForNotificationController extends Controller
{
    public function store(SaveUserForNotificationRequest $request): JsonResponse
    {
        return $request->handle();
    }
}
