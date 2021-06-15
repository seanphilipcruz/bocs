<?php

namespace App\Http\Controllers;

use App\EmployeeLogs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // master password for BOCS
    public function password() {
        return Hash::make('MonsterRXBOCS');
    }


    public function Log($action, $employee_id, $user_id) {
        if($action && $employee_id && $user_id) {
            EmployeeLogs::create([
                'action' => $action,
                'employee_id' => $employee_id,
                'user_id' => $user_id,
                'job_id' => Auth::user()->job_id
            ]);
        }
    }

    // Converting hex to RGB from https://stackoverflow.com/questions/15202079/convert-hex-color-to-rgb-values-in-php
    public function hexToRGB($hex, $alpha = false) {
        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);

        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

        if ($alpha) {
            $rgb['a'] = $alpha;
        }

        return $rgb;
    }
}
