@php
$pageName = 'Manage Companies';
@endphp
@extends('dashboard.superadmin.layouts.superadmin')
@section('content')
    <div class="col-md-8 offset-md-2 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Company</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" method="POST" action="{{ route('superadmin.companies.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @include('alerts.fail')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">Name</label>
                                        <div class="position-relative">
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name"
                                                id="first-name-icon">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="email-id-icon">Email</label>
                                        <div class="position-relative">
                                            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email"
                                                id="email-id-icon">
                                            <div class="form-control-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="email-id-icon">Website</label>
                                        <div class="position-relative">
                                            <input type="text" name="website" value="{{ old('website') }}" class="form-control" placeholder="Website">
                                            <div class="form-control-icon">
                                            <i class="bi bi-layout-text-window-reverse"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="password-id-icon">Logo</label>
                                        <div class="position-relative">
                                            <label for="logo">
                                                <img src="{{ asset('img/Add_Image_icon.png') }}" alt="logo"
                                                    style="cursor: pointer">
                                                <input type="file" id="logo" name="logo" class="form-control d-none">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Add</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
