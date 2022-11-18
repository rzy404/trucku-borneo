<!-- modal form -->
<div class="modal fade" id="ModalKriteria">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleKriteria"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span>
                </button>
            </div>
            <form method="POST" id="formKriteria" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kriteria</label>
                            <div class="col-sm-9">
                                {!! Form::text('kriteria', null, array('id' => 'kriteria', 'placeholder' => 'Kriteria','class' => 'form-control')) !!}
                                @if ($errors->has('kriteria'))
                                <span class="text-danger">{{ $errors->first('kriteria') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Bobot Kriteria</label>
                            <div class="col-sm-9">
                                {!! Form::text('weight', null, array('id' => 'weight', 'placeholder' => 'Bobot Preferensi','class' => 'form-control')) !!}
                                @if ($errors->has('weight'))
                                <span class="text-danger">{{ $errors->first('weight') }}</span>
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