<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function version()
    {
        return response()->json(['version' => 'this is debug version']);
    }

    public function db()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['status' => 'ok']);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error']);
        }
    }
}
