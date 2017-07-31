<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function list() {

	$files = array();

        return return view('listing', ['files' => $files]);

    }
}
