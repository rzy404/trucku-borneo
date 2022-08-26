<!-- view modal -->
<div class="modal fade" id="View_ModalDriver">
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
                                    <img id="profileDriver" src="">
                                    <div class="info d-flex align-items-center p-md-3 p-2 bg-primary">
                                        <div>
                                            <p class="fs-14 text-white op5 mb-1" id="umur_driver"></p>
                                            <span class="fs-18 text-white" id="namaLengkap"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-info d-flex align-items-start mt-4 mb-3">
                                    <div class="mr-auto pr-3">
                                        <div class="input-group mb-5 input-primary">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="las la-calendar"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="tgl_lahir" placeholder="" disabled>
                                        </div>
                                        <div class="input-group mb-5 input-primary">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="lab la-gratipay"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="agama" placeholder="" disabled>
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
                                                    <i class="las la-map-marker"></i>
                                                </span>
                                            </div>
                                            <textarea rows="2" cols="40" id="alamat" placeholder="" style="resize:none" class="form-control" disabled></textarea>
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

<!-- modal form driver -->
<div class="modal fade" id="ModalDriver">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleDriver"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <form method="POST" id="formDriver" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                {!! Form::text('nama', null, array('id' => 'namaDriver', 'placeholder' => 'Nama','class' => 'form-control')) !!}
                                @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                {!! Form::text('tgl_lahir', null, array('id' => 'mdate', 'placeholder' => 'Pilih Tanggal Lahir', 'class' => 'form-control')) !!}
                                @if ($errors->has('tgl_lahir'))
                                <span class="text-danger">{{ $errors->first('tgl_lahir') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea rows="4" cols="54" id="alamat" name="alamat" placeholder="Alamat" style="resize:none" class="form-control"></textarea>
                                @if ($errors->has('alamat'))
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Agama</label>
                            <div class="col-sm-9">
                                <select class="form-control default-select'" name="agama" id="agama">
                                    <option selected>Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Protestan">Protestan</option>
                                    <option value="Khatolik">Khatolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                                @if ($errors->has('agama'))
                                <span class="text-danger">{{ $errors->first('agama') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No Telpon</label>
                            <div class="col-sm-9">
                                {!! Form::text('no_telpon', null, array('id' => 'notel', 'placeholder' => 'No. Telpon', 'class' => 'form-control')) !!}
                                @if ($errors->has('no_telpon'))
                                <span class="text-danger">{{ $errors->first('no_telpon') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Foto</label>
                            <div class="custom-file col-sm-8 ml-3">
                                <input type="file" id="avatar" name="avatar" class="custom-file-input">
                                <label class="custom-file-label">Pilih Gambar</label>
                                @if ($errors->has('avatar'))
                                <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnModal">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>