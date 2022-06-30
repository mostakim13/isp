<?php

namespace App\Http\Controllers;

use App\Helpers\apiResponse;
use App\Helpers\Component;
use App\Helpers\DataProcessing;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\EmployeSalaryFun;
use App\Helpers\MikrotikConnection;
use App\Helpers\MikrotikQuery;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        apiResponse,
        DataProcessing,
        EmployeSalaryFun,
        MikrotikConnection,
        Component,
        MikrotikQuery;
}
