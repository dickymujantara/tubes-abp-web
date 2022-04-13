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
        <i class="fas fa-location-arrow"></i>
        <span>Tambah Wisata</span>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <form action="{{route('touristAttractionCreate')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row form-group">
                <div class="col-12">
                  <label for="name" class="form-label">Nama Wisata *</label>
                  <input type="text" class="form-control" id="name" name="name">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12">
                  <label for="address" class="form-label">Alamat *</label>
                  <input type="text" class="form-control" id="address" name="address">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-6">
                  <label for="phone" class="form-label">No. Telp</label>
                  <input type="text" class="form-control" id="phone" name="phone">
                </div>

                <div class="col-6">
                  <label for="emailContact" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email_contact" name="email_contact">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-6">
                  <label for="websiteInformation" class="form-label">Website</label>
                  <input type="text" class="form-control" id="website" name="website">
                </div>

                <div class="col-6">
                  <label for="ticket" class="form-label">Harga Tiket</label>
                  <input type="text" class="form-control" id="ticket" name="ticket">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12">
                  <label for="image" class="form-label">Gambar *</label>
                  <input type="file" class="form-control" id="image" name="image">
                </div>
              </div>
              <div class="text-right">
                <input type="submit" class="btn btn-primary btn-sm" value="Simpan">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@endpush