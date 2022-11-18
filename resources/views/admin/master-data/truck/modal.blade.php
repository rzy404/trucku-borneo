<!-- view modal -->
<div class="modal fade" id="View_ModalTruk">
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
                                <div class="img-card mb-sm-0 mt-2 mb-3">
                                    <img id="image_truck" class="rounded mx-auto d-block" src="">
                                </div>
                                <div class="card-info d-flex align-items-start mt-4 mb-3">
                                    <div class="mr-2 pr-3">
                                        <div class="form-group mb-2 input-primary">
                                            <label>No. Plat</label>
                                            <input type="text" class="form-control" readonly size="50" id="no_plat" placeholder="">
                                        </div>
                                        <div class="form-group mb-2 input-primary">
                                            <label>Jenis Truk</label>
                                            <input type="text" class="form-control" readonly size="50" id="jenis">
                                        </div>
                                        <div class="form-group mb-2 input-primary">
                                            <label>Merek</label>
                                            <input type="text" class="form-control" readonly size="50" id="merek">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-sm-flex ml-2">
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-group mb-4 input-primary">
                                            <label>Tahun Buat</label>
                                            <input type="text" class="form-control" readonly size="50" id="tahun">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-group mb-4 input-primary">
                                            <label>Dimensi</label>
                                            <input type="text" class="form-control" readonly size="50" id="dimensi">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-group mb-4 input-primary">
                                            <label>Beban Maks</label>
                                            <input type="text" class="form-control" readonly size="50" id="beban">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-group mb-4 input-primary">
                                            <label>Warna</label>
                                            <input type="text" class="form-control" readonly size="50" id="warna">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-group mb-4 input-primary">
                                            <label>Volume</label>
                                            <input type="text" class="form-control" readonly size="50" id="volume">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-group mb-4 input-primary">
                                            <label>Driver</label>
                                            <input type="text" class="form-control" readonly size="50" id="driver">
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

<div class="modal fade" id="View_ModalJenis">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="jenisTruk">
                        <tr>
                            <td width="30%" class="namaJenis"></td>
                            <td width="50%" class="dataJenis"></td>
                        </tr>
                        <tr>
                            <td width="30%" class="namaDimensi"></td>
                            <td width="50%" class="dataDimensi"></td>
                        </tr>
                        <tr>
                            <td width="30%" class="namaVolume"></td>
                            <td width="50%" class="dataVolume"></td>
                        </tr>
                        <tr>
                            <td width="30%" class="namaBeban"></td>
                            <td width="50%" class="dataBeban"></td>
                        </tr>
                        <tr>
                            <td width="30%" class="namaBiaya"></td>
                            <td width="50%" class="dataBiaya"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- modal form truk -->
<div class="modal fade" id="ModalTruk">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleTruk"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <form method="POST" id="formTruk" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No. Plat</label>
                            <div class="col-sm-9">
                                {!! Form::text('no_plat', null, array('id' => 'np', 'placeholder' => 'No. Plat Kendaraan','class' => 'form-control')) !!}
                                @if ($errors->has('no_plat'))
                                <span class="text-danger">{{ $errors->first('no_plat') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Jenis Truck</label>
                            <div class="col-sm-9">
                                <select class="form-control default-select'" name="jenis_truk" id="jenis_truk">
                                    <option selected disabled>Pilih Jenis Truck</option>
                                    @foreach ($data_jenisTruk as $key => $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->jenis_truk }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Merek Truck</label>
                            <div class="col-sm-9">
                                {!! Form::text('merek_truck', null, array('id' => 'merek_truck', 'placeholder' => 'Merek Truck','class' => 'form-control')) !!}
                                @if ($errors->has('merek_truck'))
                                <span class="text-danger">{{ $errors->first('merek_truck') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tahun Buat</label>
                            <div class="col-sm-9">
                                {!! Form::text('tahun_buat', null, array('id' => 'tahun_buat', 'placeholder' => 'Tahun Buat','class' => 'form-control')) !!}
                                @if ($errors->has('tahun_buat'))
                                <span class="text-danger">{{ $errors->first('tahun_buat') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Warna</label>
                            <div class="col-sm-9">
                                {!! Form::text('warna', null, array('id' => 'wr', 'placeholder' => 'Warna','class' => 'form-control')) !!}
                                @if ($errors->has('warna'))
                                <span class="text-danger">{{ $errors->first('warna') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Foto</label>
                            <div class="custom-file col-sm-8 ml-3">
                                <input type="file" id="img_truck" name="img_truck" class="custom-file-input">
                                <label class="custom-file-label">Pilih Gambar</label>
                                <img src="" class="img-fluid w-100" alt="" id="file-image-edit">
                                @if ($errors->has('img_truck'))
                                <span class="text-danger">{{ $errors->first('img_truck') }}</span>
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

<!-- modal form jenis truk -->
<div class="modal fade" id="ModalJenisTruk">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleJenis"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <form method="POST" id="formJenis" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Jenis Truck</label>
                            <div class="col-sm-9">
                                {!! Form::text('jenis_truk', null, array('id' => 'jenis_truk', 'placeholder' => 'Jenis Truck ("JBORNEO_XX")','class' => 'form-control')) !!}
                                @if ($errors->has('jenis_truk'))
                                <span class="text-danger">{{ $errors->first('jenis_truk') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Dimensi</label>
                            <div class="col-sm-9">
                                {!! Form::textarea('dimensi', null, array('id' => 'dimensi_maks', 'cols' => '54', 'rows' => '4', 'placeholder' => 'Dimensi Maksimal','class' => 'form-control')) !!}
                                @if ($errors->has('dimensi'))
                                <span class="text-danger">{{ $errors->first('dimensi') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Volume</label>
                            <div class="col-sm-9">
                                {!! Form::text('volume', null, array('id' => 'volume_maks', 'placeholder' => 'Volume Maks','class' => 'form-control')) !!}
                                @if ($errors->has('volume'))
                                <span class="text-danger">{{ $errors->first('volume') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Beban</label>
                            <div class="col-sm-9">
                                {!! Form::text('beban_maks', null, array('id' => 'beban_maks', 'placeholder' => 'Beban Maks','class' => 'form-control')) !!}
                                @if ($errors->has('beban_maks'))
                                <span class="text-danger">{{ $errors->first('beban_maks') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Biaya (Rp)</label>
                            <div class="col-sm-9">
                                {!! Form::text('biaya', null, array('id' => 'biaya', 'placeholder' => 'Biaya','class' => 'form-control')) !!}
                                @if ($errors->has('biaya'))
                                <span class="text-danger">{{ $errors->first('biaya') }}</span>
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