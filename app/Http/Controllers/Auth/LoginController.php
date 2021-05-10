<?php

namespace App\Http\Controllers\Auth;

use App\Employee;
use App\EmployeeLogs;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $isUserActive = Employee::where('username', $request['username'])
            ->where('is_active', 1)
            ->get()
            ->count();

        if($isUserActive == 1) {
            if ($this->attemptLogin($request)) {
                $employee = Auth::user();

                $logs = new EmployeeLogs([
                    'employee_id' => $employee->id,
                    'action' => 'Logged In',
                    'user_id' => $employee->id,
                    'job_id' => $employee->Job->id
                ]);

                $logs->save();

                return $this->sendLoginResponse($request);
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $isUserActive = Employee::where('username', $request['username'])
            ->where('is_active', '=', 1)
            ->get()
            ->count();

        // if user is inactive
        if($isUserActive == 0) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.inactive')],
            ]);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')]
        ]);
    }

    public function logout(Request $request)
    {
        $employee = Auth::user();

        $logs = new EmployeeLogs([
            'employee_id' =>  $employee->id,
            'action' => 'Logged Out',
            'user_id' => $employee->id,
            'job_id' => $employee->Job->id
        ]);

        $logs->save();

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
