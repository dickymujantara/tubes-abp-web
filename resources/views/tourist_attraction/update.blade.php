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
        <span>Edit Wisata</span>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <form action="{{ route('touristAttractionUpdate', $tourist_attraction->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="row form-group">
                <div class="col-12">
                  <label for="name" class="form-label">Nama Wisata *</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $tourist_attraction->name }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12">
                  <label for="address" class="form-label">Alamat *</label>
                  <input type="text" class="form-control" id="address" name="address" value="{{ $tourist_attraction->address }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-6">
                  <label for="phone" class="form-label">No. Telp (Opsional)</label>
                  <input type="text" class="form-control" id="phone" name="phone"  value="{{ $tourist_attraction->phone }}">
                </div>

                <div class="col-6">
                  <label for="emailContact" class="form-label">Email (Opsional)</label>
                  <input type="text" class="form-control" id="email_contact" name="email_contact" value="{{ $tourist_attraction->email_contact }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-6">
                  <label for="websiteInformation" class="form-label">Website (Opsional)</label>
                  <input type="text" class="form-control" id="website" name="website" value="{{ $tourist_attraction->website_information }}">
                </div>
                <div class="col-6">
                  <label for="ticket" class="form-label">Harga Tiket *</label>
                  <input type="text" class="form-control" id="ticket" name="ticket" value="{{ $tourist_attraction->ticket_price }}">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12">
                  <table class="table table">
                    <thead>
                        <tr>
                          <th>Hari</th>
                          <th>Jam Buka</th>
                          <th>Jam Tutup</th>
                          <th><p style="cursor: pointer" class="btn btn-primary" id="add_item">+</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tourist_attraction->openclose as $oc)
                        <tr>
                          <td>
                            <input type="text" name="day[]" id="hari" class="form-control" placeholder="Contoh: Senin, Selasa" value="{{ $oc->day }}">
                          </td>
                          <td>
                            <input type="time" name="open[]" id="buka" class="form-control" value="{{ $oc->open }}">
                          </td>
                          <td>
                            <input type="time" name="close[]" id="tutup" class="form-control" value="{{ $oc->close }}">
                          </td>
                          <td>
                            <p style="cursor: pointer" class="btn btn-danger" id="remove_item">x</p>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12">
                  <label for="image" class="form-label">Gambar *</label>
                  <input type="file" class="form-control" id="image" name="image" value="{{ $tourist_attraction->image }}">
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
<script type="text/javascript">
  $(document).ready(function() {   
    var i=0;  
      $('#add_item').click(function() {  
           i++;  
           var html = '';
           html += '<tr>';
           html += '<td><input type="text" name="day[]" id="hari" class="form-control" placeholder="Contoh: Senin, Selasa"></td>';
           html += '<td><input type="time" name="open[]" id="buka" class="form-control"></td>';
           html += '<td><input type="time" name="close[]" id="tutup" class="form-control"></td>';
           html += '<td><p style="cursor: pointer" class="btn btn-danger" id="remove_item">x</p></td>'
           html += '</tr>'
                  
           $('tbody').append(html);  

      });  
  });

  $(document).on('click', '#remove_item', function() {
    $(this).closest('tr').remove();
  });
  
</script>
@endpush