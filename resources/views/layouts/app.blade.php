<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @include('scripts')
    @include('swal')


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <!-- Styles -->
    @include('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="monster-logo" width="80px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">Version {{ env('APP_VERSION') }}</a>
                            </li>
                            {{--@if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif--}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="advertisersDropdown" href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Advertiser') }}</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="advertisersDropdown">
                                    <a href="{{ route('advertisers') }}" id="advertisers" class="dropdown-item" navigation>{{ __('Advertisers') }}</a>
                                    <a href="{{ route('logs') }}" class="dropdown-item" id="advertiser_logs" navigation>{{ __('Logs') }}</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="agencyDropdown" href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Agency') }}</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="agencyDropdown">
                                    <a href="{{ route('agencies') }}" id="agencies" class="dropdown-item" navigation>{{ __('Agencies') }}</a>

                                    <a href="{{ route('logs') }}" class="dropdown-item" id="agency_logs" navigation>{{ __('Logs') }}</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="contractsDropdown" href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Contracts') }}</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="contractsDropdown">
                                    <a href="{{ route('contracts') }}" id="contracts" class="dropdown-item" navigation>{{ __('Contracts') }}</a>
                                    <a href="{{ route('logs') }}" class="dropdown-item" id="contract_logs" navigation>{{ __('Logs') }}</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="salesDropdown" href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Sales') }}</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="salesDropdown">
                                    <a href="{{ route('sales') }}" id="sales" class="dropdown-item" navigation>{{ __('Sales') }}</a>
                                    <a href="{{ route('sales.reports') }}" id="sales_report" class="dropdown-item" navigation>{{ __('Reports') }}</a>
                                    <a href="{{ route('logs') }}" class="dropdown-item" id="sales_logs" navigation>{{ __('Logs') }}</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('jobs') }}" id="jobs" class="nav-link" navigation>{{ __('Jobs') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="employeesDropdown" href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Employees') }}</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="employeesDropdown">
                                    <a href="{{ route('employees') }}" class="dropdown-item" id="employees" navigation>{{ __('Accounts') }}</a>
                                    <a href="{{ route('logs') }}" class="dropdown-item" id="employees_logs" navigation>{{ __('Logs') }}</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('archives') }}" id="archives" class="nav-link" navigation>{{ __('Archives') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->first_name }}<span class="caret"></span></a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#job-modal" data-toggle="modal">My Job</a>
                                    <a class="dropdown-item" href="#help-modal" data-toggle="modal">Help</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main id="main_content" class="py-4">
            @yield('content')
        </main>


        <!-- Modal -->
        <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Help with Buttons</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <tr>
                                <th>Button</th>
                                <th>Meaning</th>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-edit"></i></button></td>
                                <td>Edit or View</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-trash-alt"></i></button></td>
                                <td>Delete</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-plus"></i></button></td>
                                <td>Add</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-download"></i></button></td>
                                <td>Generate PDF for printable version</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-plus"></i></button></td>
                                <td>In Contracts, it means add sales breakdown</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-check"></i></button> or <button type="button" class="btn btn-outline-dark"><i class="fas fa-times"></i></button></td>
                                <td>In Contracts, activate or deactivate a contract</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-list"></i></button></td>
                                <td>List Breakdown</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-file-alt"></i></button></td>
                                <td>Add Invoice Number</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-question"></i></button></td>
                                <td>Help</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-lock"></i></button></td>
                                <td>Change Password</td>
                            </tr>
                            <tr>
                                <td><button type="button" class="btn btn-outline-dark"><i class="fas fa-exchange-alt"></i></button></td>
                                <td>Compare in Archives</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @auth
            <div class="modal fade" id="job-modal" tabindex="-1" role="dialog" aria-labelledby="job-modal" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Things you can do in BOCS</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(auth()->user()->Job->level === 1)
                                <ul class="nav nav-pills nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">View Contracts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Sales Breakdown</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Employees</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Compare Sales/Contracts</a>
                                    </li>
                                </ul>
                                <div class="jobs_container">

                                </div>
                            @elseif(auth()->user()->Job->level === 2)
                                <ul class="nav nav-pills nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">View Contracts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Sales Breakdown</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Employees</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Compare Sales/Contracts</a>
                                    </li>
                                </ul>
                                <div class="jobs_container">

                                </div>
                            @elseif(auth()->user()->Job->level === 3)
                                <ul class="nav nav-pills nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">View Contracts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Sales Breakdown</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Employees</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Compare Sales/Contracts</a>
                                    </li>
                                </ul>
                                <div class="jobs_container">

                                </div>
                            @else
                                <ul class="nav nav-pills nav-fill">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">View Contracts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Sales Breakdown</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Manage Employees</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Compare Sales/Contracts</a>
                                    </li>
                                </ul>
                                <div class="jobs_container">

                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</body>
</html>
