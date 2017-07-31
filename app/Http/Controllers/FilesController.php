<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function list() {

	$files = [];
        $breadcrumbs = [];

        return view('listing', [
            'dir' => '/',
            'files' => $files,
            'breadcrumbs' => $breadcrumbs,
            'canZip' => false
        ]);

    }
}
