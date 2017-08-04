<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'root', 'expiration'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function canAccess($path)
    {
        $path = str_replace('///', '/', '/'.$path);

        $access = false;

        if (strlen($this->root) > 0) {
            $allowedPaths = explode(',', $this->root);
            foreach ($allowedPaths as $root) {
                if ($root[0] === '-') {
                    $root = substr($root, 1);
                    if (strpos($path, $root) === 0) {
                        return false;
                    }
                } else if (strpos($path, $root) === 0 || strpos($root, $path) === 0) {
                    $access = true;
                }
            }
        } else {
            $success = true;
        }

        return $access;
    }
}
