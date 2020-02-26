<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function version()
    {
        return response()->json(['version' => 'dev']);
    }

    public function db()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['db' => 'ok']);
        } catch (\Exception $exception) {
            return response()->json(['db' => 'error']);
        }
    }
}
