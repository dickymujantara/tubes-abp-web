<!-- Modal -->
<div class="modal fade" id="modal-users" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        {{-- <form action="{{route('reference.project.store')}}" method="post"> --}}
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Detail Users</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id-detail">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3"><h6>Name</h6></div>
                            <div class="col-md-1"><h6>:</h6></div>
                            <div class="col-md-8"><h6 id="name-detail"></h6></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><h6>Email</h6></div>
                            <div class="col-md-1"><h6>:</h6></div>
                            <div class="col-md-8"><h6 id="email-detail"></h6></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><h6>Username</h6></div>
                            <div class="col-md-1"><h6>:</h6></div>
                            <div class="col-md-8"><h6 id="username-detail"></h6></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><h6>Address</h6></div>
                            <div class="col-md-1"><h6>:</h6></div>
                            <div class="col-md-8"><h6 id="address-detail"></h6></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><h6>Status</h6></div>
                            <div class="col-md-1"><h6>:</h6></div>
                            <div class="col-md-8">
                                <select id="status-detail" class="form-control">
                                    <option value="0">PENDING</option>
                                    <option value="1">PROCESS</option>
                                    <option value="2">SUCCESS</option>
                                    <option value="3">FAILED</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="update()" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</div>