<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Guest\HomeIndexCollection;
use App\Http\Resources\API\Guest\HomeIndexResource;
use App\Http\Resources\User;
use App\Models\Drivers\TrackedPair;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return HomeIndexResource::collection(TrackedPair::all());
    }
}
