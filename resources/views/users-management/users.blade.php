@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Users Management</li>
        <li class="breadcrumb-item active">Users</li>
        <!-- Breadcrumb Menu-->
    </ol>
@endsection

@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users"></i>
                <span>List Users</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped" id="table-users">
                            <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Username</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Address</th>
                                  <th>Verified</th>
                                  <th>Created At</th>
                                  <th>Updated At</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include("users-management.modal-users")

@push('scripts')
<script src="{{asset('public/js/users-management/users.js')}}"></script>

<script>
    var table = null
    var token = "{{csrf_token()}}"
    var urlList = "{{route('users-management.users.list')}}"
    var urlDetail = "{{route('users-management.users.detail')}}"
    var urlUpdate = "{{route('users-management.users.update')}}"
</script>

@endpush
