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
<form action="{{route('touristAttractionCreate')}}" method="post">
  @csrf 
  
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>

  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address">
  </div>

  <div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone">
  </div>

  <div class="mb-3">
    <label for="emailContact" class="form-label">Email Contact</label>
    <input type="text" class="form-control" id="email_contact" name="email_contact">
  </div>

  <div class="mb-3">
    <label for="websiteInformation" class="form-label">Website Information</label>
    <input type="text" class="form-control" id="website" name="website">
  </div>

  <div class="mb-3">
    <label for="ticket" class="form-label">Ticket Price</label>
    <input type="text" class="form-control" id="ticket" name="ticket">
  </div>

  <button type="submit" class="btn btn-primary">Add</button>
</form>
@endsection

@push('scripts')
@endpush