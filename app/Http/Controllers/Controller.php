<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    /**
     * Get file name except directory path
     *
     * @return mixed|string
     */
    public function getFileName(string $fullPath)
    {
        $parts = explode('/', $fullPath);
        return $parts[count($parts) - 1];
    }
}
