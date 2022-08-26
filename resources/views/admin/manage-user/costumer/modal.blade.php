<!-- view modal -->
<div class="modal fade" id="View_ModalCostumer">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card details-card">
                        <div class="card-body mt-1">
                            <div class="d-sm-flex mb-2">
                                <div class="img-card mb-sm-0 mt-1 mb-3">
                                    <img id="profile_cost" src="">
                                    <div class="info d-flex align-items-center p-md-3 p-2 bg-primary">
                                        <div>
                                            <p class="fs-14 text-white op5 mb-1" id="status_user"></p>
                                            <span class="fs-18 text-white" id="namaLengkap"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-info d-flex align-items-start mt-4 mb-3">
                                    <div class="mr-auto pr-3">
                                        <div class="input-group mb-5 input-primary">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="las la-envelope-open"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="email_cost" placeholder="" disabled>
                                        </div>
                                        <div class="input-group mb-5 input-primary">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="las la-phone"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="no_telpon" placeholder="" disabled>
                                        </div>
                                        <div class="input-group mb-5 input-primary">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="las la-building"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="perusahaan" placeholder="" disabled>
                                        </div>
                                        <div class="input-group mb-5 input-primary">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="las la-map-marker"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="alamat_perusahaan" placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal form costumer -->
<div class="modal fade" id="ModalCostumer">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleCostumer"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <form method="POST" id="formCostumer">
                @csrf
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                {!! Form::text('nama', null, array('id' => 'namaOperator', 'placeholder' =>
                                'Nama','class'
                                => 'form-control'))
                                !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                {!! Form::text('email', null, array('id' => 'email', 'placeholder' =>
                                'Email','class' => 'form-control'))
                                !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                {!! Form::password('password', array('id' => 'password', 'placeholder' =>
                                'Password','class' =>
                                'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class'
                                => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnModal">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>