@php
$pageName = 'Manage Companies';
@endphp
@extends('dashboard.superadmin.layouts.superadmin')
@section('title', $pageName)
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-3">
                    <h3>Manage Companies</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/superadmin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Companies</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        @include('alerts.success')
        <section class="section">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content:space-between; align-items:center">
                    <div>Companies Table</div>
                    <a href="/superadmin/companies/create"><button class="btn btn-primary">Add Company</button></a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Logo</th>
                                <th>Company Name</th>
                                <th>Company Email</th>
                                <th>Company Website</th>
                                <th>Adjustments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>
                                        <img class="avatar me-2" style="object-fit: cover" width="50" height="50"
                                            src="{{ $company->logo != 'no-logo.png' ? asset("/storage/logo/$company->logo") : asset("img/no-logo.png")  }}" alt="logo">
                                    </td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email ?? "There is no email" }}</td>
                                    <td>{{ $company->website ?? "There is no website"}}</td>
                                    <td>
                                        <a href="{{ route('superadmin.companies.edit', $company->id) }}" class="ms-3 "><i
                                                class="fas fa-user-edit"></i></a>
                                        <form style="display: inline-block" method="POST"
                                            action="{{ route('superadmin.companies.destroy', $company->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn text-primary"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endsection
