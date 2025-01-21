@extends('layouts.app')
@section('content')
    <div class="container-fluid d-flex justify-content-center align-items-center transparent-bg" style="background-color: #fff; opacity:0.7; margin-top:2%">
        <div class="text-center">
            <h5 class="display-3 mt-4 mb-4" style="color:rgb(2, 121, 55)">Welcome {{Auth::user()->name}}</h5>
            <p class="lead mb-4">Here you can manage your account, claims, and much more!</p>

            <!-- Example of a big call-to-action or status message -->
            <div class="alert alert-dark">
                <h4 class="alert-heading">Important Notice:</h4>
                <p>Your system is up to date, and everything is running smoothly.</p>
                <hr>
                <p class="mb-0">If you encounter any issues, feel free to contact support.</p>
            </div>

            <!-- A Button (if needed) -->
            <!-- <a href="#" class="btn btn-primary btn-lg">Get Started</a> -->
        </div>
    </div>
@endsection
