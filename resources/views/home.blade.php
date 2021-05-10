@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('employees') }}" id="employees" navigation>
                <div class="card bg-light text-dark border-primary">
                    <div class="card-body">
                        <h4 class="card-title mb-1">Employees</h4>
                        <p class="card-text">{{ $users->count() }} active employees</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('contracts') }}" id="contracts" navigation>
                <div class="card bg-light text-dark border-dark">
                    <div class="card-body">
                        <h4 class="card-title mb-1">Contracts</h4>
                        <p class="card-text">{{ $contracts->count() }} active contracts</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('agencies') }}" id="agencies" navigation>
                <div class="card bg-light text-dark border-success">
                    <div class="card-body">
                        <h4 class="card-title mb-1">Agencies</h4>
                        <p class="card-text">{{ $agencies->count() }} active agencies</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('advertisers') }}" id="advertisers" navigation>
                <div class="card bg-light text-dark border-danger">
                    <div class="card-body">
                        <h4 class="card-title mb-1">Advertisers</h4>
                        <p class="card-text">{{ $advertisers->count() }} active advertisers</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @include('webpages.charts.manila')
    @include('webpages.charts.cebu')
    @include('webpages.charts.davao')
</div>
@endsection
