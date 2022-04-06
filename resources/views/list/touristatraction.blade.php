@extends('layouts.app')

@section('title')
tourist atraction
@endsection

@section('breadcrumb')
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Tourist Atraction</li>
        <!-- Breadcrumb Menu-->
    </ol>
    
@endsection

@section('container')
    
    <table class="table table-bordered">
    <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nama</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($tas as $ta)    
    <tr>
        <th scope="row">{{$ta->id}}</th>
        <td>{{$ta->name}}</td>
        <td><form action="{{route('taupdate')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{ $ta->id }}">
                  <input type="submit" name="submit" class="btn btn-primary" value="Detail">
                </form></td>
        </tr>
    @endforeach 

  </tbody>
    </table>
@endsection

@push('scripts')
@endpush