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

    <button class="btn btn-primary">
      <a href="{{ route('touristAttractionAdd') }}" style="color: white; text-decoration: none" >Tambah Data</a>
    </button>
    
    <table class="table table-bordered">
    <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nama</th>
      <th scope="col">Address</th>
      <th scope="col">Phone</th>
      <th scope="col">Email Contact</th>
      <th scope="col">Website Information</th>
      <th scope="col">Ticket Price</th>
      <th scope="col">Review</th>
      <th scope="col">Full Review</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($touristAttractions as $touristAttraction)    
    <tr>
        <th scope="row">{{ $touristAttraction->id }}</th>
        <td>{{ $touristAttraction->name }}</td>
        <td>{{ $touristAttraction->address }}</td>
        <td>{{ $touristAttraction->phone }}</td>
        <td>{{ $touristAttraction->email_contact }}</td>
        <td>{{ $touristAttraction->website_information }}</td>
        <td>{{ $touristAttraction->ticket_price }}</td>
        <td></td>
        <td>{{ $touristAttraction->full_review }}</td>
        <td>
            <form action="{{route('taupdate')}}" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ $touristAttraction->id }}">
              <input type="submit" name="submit" class="btn btn-primary" value="Update">
            </form>
        </td>
        </tr>
    @endforeach 

  </tbody>
    </table>
@endsection

@push('scripts')
@endpush