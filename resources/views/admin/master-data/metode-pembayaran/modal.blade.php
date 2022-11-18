<!-- modal form driver -->
<div class="modal fade" id="ModalMetodePembayaran">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleBayar"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <form method="POST" id="formBayar" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Metode Pembayaran</label>
                            <div class="col-sm-9">
                                {!! Form::text('metode_bayar', null, array('id' => 'metode_bayar', 'placeholder' => 'Metode Pembayaran','class' => 'form-control')) !!}
                                @if ($errors->has('metode_bayar'))
                                <span class="text-danger">{{ $errors->first('metode_bayar') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No Rekening</label>
                            <div class="col-sm-9">
                                {!! Form::text('norek', null, array('id' => 'norek', 'placeholder' => 'No Rekening','class' => 'form-control')) !!}
                                @if ($errors->has('norek'))
                                <span class="text-danger">{{ $errors->first('norek') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Atas Nama</label>
                            <div class="col-sm-9">
                                {!! Form::text('atas_nama', null, array('id' => 'atas_nama', 'placeholder' => 'Atas Nama','class' => 'form-control')) !!}
                                @if ($errors->has('atas_nama'))
                                <span class="text-danger">{{ $errors->first('atas_nama') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Logo</label>
                            <div class="custom-file col-sm-8 ml-3">
                                <input type="file" id="logo_bayar" name="logo" class="custom-file-input">
                                <label class="custom-file-label">Pilih Gambar</label>
                                @if ($errors->has('logo'))
                                <span class="text-danger">{{ $errors->first('logo') }}</span>
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