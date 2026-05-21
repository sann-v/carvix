<?php

namespace App\Http\Controllers;

class ServicePageController extends Controller {
    public function index() {
        return view('services');
    }
}