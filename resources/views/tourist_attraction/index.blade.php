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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                  <div class="col-10">
                    <i class="fas fa-location-arrow"></i>
                    <span>Tourist Attraction</span>
                  </div>
                  <div class="col-2">
                    <button class="btn btn-primary">
                      <a href="{{ route('touristAttractionAdd') }}" style="color: white; text-decoration: none" >Tambah Data</a>
                    </button>
                  </div>
                </div>
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Nama</th>
                                  <th>Gambar</th>
                                  <th>Alamat</th>
                                  <th>No. Telp</th>
                                  <!-- <th>Email</th> -->
                                  <!-- <th>Website</th> -->
                                  <th>Harga Tiket</th>
                                  <th>Rating</th>
                                  <th colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                              $i = 1;
                            ?>
                            @foreach($touristAttractions as $touristAttraction)    
                                <tr>
                                  <td>{{ $i++ }}</td>
                                  <td>{{ $touristAttraction->name }}</td>
                                  <td>
                                    <img src="{{ asset('public' . $touristAttraction->image) }}" alt="img" width="100px" height="100px"/>
                                  </td>
                                  <td>{{ $touristAttraction->address }}</td>
                                  <td>{{ $touristAttraction->phone }}</td>
                                  <!-- <td>{{ $touristAttraction->email_contact }}</td> -->
                                  <!-- <td>{{ $touristAttraction->website_information }}</td> -->
                                  <td>Rp{{ number_format($touristAttraction->ticket_price) ?? '-' }}</td>
                                  <td>{{ $touristAttraction->rating }} </td>
                                  <td>
                                      <form action="{{route('touristAttractionEdit', $touristAttraction->id)}}" method="post">
                                        @csrf
                                        @method('get')
                                        <input type="submit" name="submit" class="btn btn-primary" value="Update">
                                      </form>
                                  </td>
                                  <td>
                                      <form action="{{route('touristAttractionDelete', $touristAttraction->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $touristAttraction->id }}">
                                        <input type="submit" name="submit" class="btn btn-danger" value="Hapus">
                                      </form>
                                  </td>
                                </tr>
                            @endforeach  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush