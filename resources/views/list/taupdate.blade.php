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
@foreach($tas as $ta)

<form action="{{route('taupdateproses')}}" method="post">
  @csrf 
  <input type="hidden" name="id" value="{{$ta->id}}">
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{$ta->name}}">
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address" value="{{$ta->address}}">
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
@endforeach   
@endsection

@push('scripts')
@endpush