@extends('layouts.app')

@section('title')
list
@endsection

@section('breadcrumb')
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Visit List</li>
        <!-- Breadcrumb Menu-->
    </ol>
    
@endsection

@section('container')
    
    <table class="table table-bordered">
    <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">ID User</th>
      <th scope="col">Tourist Attraction</th>
      <th scope="col">Visit Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach($lists as $list)    
        <tr>
        <th scope="row">{{$list->id}}</th>
        <td>{{$list->id_user}}</td>
        <td>{{$list->id_tourist_attraction}}</td>
        <td>{{$list->visit_date}}</td>
        </tr>
    @endforeach 

  </tbody>
    </table>
@endsection

@push('scripts')
@endpush