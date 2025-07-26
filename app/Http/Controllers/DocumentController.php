<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Generator;

class DocumentController extends Controller
{
    public function index(){
    $openapi = Generator::scan([base_path('app')]);

    return response($openapi->toJson(), 200)
        ->header('Content-Type', 'application/json');
        }
}
