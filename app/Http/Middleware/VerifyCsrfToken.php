<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //

        "admin/upload_file",
        "deletefiles",
        "packagemodal",
        "admin/uploadfile",
        "uploadfile",
        "admin/uploadImage"
    ];
}
