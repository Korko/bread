<?php

namespace App\Http\Controllers;

use App\User;
use Auth;

class FilesController extends Controller
{
    public function list($path = '/')
    {
        $fullpath = public_path('storage/'.$path);

        if (is_file($fullpath)) {
            return $this->downloadFile($fullpath);
        } else {
            return $this->listDirectory($path);
        }
    }

    protected function downloadFile($fullpath)
    {
        return response()->file($fullpath);
    }

    protected function listDirectory($path)
    {
        $user = User::find(Auth::id());
        $files = $this->getFiles($user, public_path('storage'), $path);
        $breadcrumbs = $this->getBreadcrumbs($path);

        return view('listing', [
            'dir'         => '/',
            'files'       => $files,
            'breadcrumbs' => $breadcrumbs,
            'canZip'      => false,
        ]);
    }

    protected function getFiles($user, $root, $parent)
    {
        $files = scandir($root.'/'.$parent);
        usort($files, 'strcasecmp');

        foreach ($files as $i => $file) {
            $relativePath = $parent.'/'.$file;
            $absolutePath = $root.'/'.$relativePath;

            if ($file[0] === '.' || !$user->canAccess($relativePath)) {
                unset($files[$i]);
            } else {
                $files[$i] = [
                    'name'     => $file,
                    'type'     => is_dir($absolutePath) ? 'dir' : 'file',
                    'url'      => route('list', ['path' => $relativePath]),
                    'mod_time' => filemtime($absolutePath),
                ];

                if (is_file($absolutePath)) {
                    $files[$i] += [
                        'size' => filesize($absolutePath),
                    ];
                }
            }
        }

        return $files;
    }

    protected function getBreadcrumbs($path)
    {
        $parts = explode('/', $path);
        if ($parts[0] === '') {
            array_shift($parts);
        }

        $breadcrumbs = [
            [
                'text' => config('app.name'),
                'link' => route('list'),
            ],
        ];

        foreach ($parts as $i => $part) {
            $breadcrumbs[] = [
                'text' => $part,
                'link' => route('list', ['path' => implode('/', array_slice($parts, 0, $i + 1))]),
            ];
        }

        return $breadcrumbs;
    }
}
