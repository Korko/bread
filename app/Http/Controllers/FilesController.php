<?php

namespace App\Http\Controllers;

class FilesController extends Controller
{
    public function list($path = '')
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
        $files = $this->getFiles(public_path('storage'), $path);
        $breadcrumbs = $this->getBreadcrumbs($path);

        return view('listing', [
            'dir'         => '/',
            'files'       => $files,
            'breadcrumbs' => $breadcrumbs,
            'canZip'      => false,
        ]);
    }

    protected function getFiles($root, $path)
    {
        $files = scandir($root.'/'.$path);

        foreach ($files as $i => $file) {
            if ($file[0] === '.') {
                unset($files[$i]);
            } else {
                $fullpath = $root.'/'.$path.'/'.$file;
                $files[$i] = [
                    'name'     => $file,
                    'type'     => is_dir($fullpath) ? 'dir' : 'file',
                    'url'      => route('list', ['path' => $path.'/'.$file]),
                    'mod_time' => filemtime($fullpath),
                ];

                if (is_file($fullpath)) {
                    $files[$i] += [
                        'size' => filesize($fullpath),
                    ];
                }
            }
        }

        return $files;
    }

    protected function getBreadcrumbs($path)
    {
        $parts = explode('/', $path);

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
