@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Laporan | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Laporan | TrucKu Borneo", 'id'))
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Laporan", session()->get('bahasa')) :
            GoogleTranslate::trans("Laporan", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('laporan.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Laporan",
                    session()->get('bahasa')) : GoogleTranslate::trans("Laporan",
                    'id') }}</a></li>
        </ol>
    </div>

    <div class="col-12">
        <div class="row">
            <!-- Search Filters -->
            <div class="col-md-10">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{session()->has('bahasa') ? GoogleTranslate::trans("Pilih Tanggal",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Pilih Tanggal",
                                        'id')}}</label>
                                    <input type="date" class="form-control" id="inputTgl" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{session()->has('bahasa') ? GoogleTranslate::trans("Pilih Status Transaksi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Pilih Status Transaksi",
                                        'id')}}</label>
                                    <select id="inputStatus" class="form-control default-select">
                                        <option value="" selected>{{session()->has('bahasa') ?
                                            GoogleTranslate::trans("Pilih
                                            Status",
                                            session()->get('bahasa')) : GoogleTranslate::trans("Pilih Status",
                                            'id')}}</option>
                                        <option value="0">{{session()->has('bahasa') ?
                                            GoogleTranslate::trans("Menunggu Konfirmasi",
                                            session()->get('bahasa')) : GoogleTranslate::trans("Menunggu Konfirmasi",
                                            'id')}}</option>
                                        <option value="1">{{session()->has('bahasa') ?
                                            GoogleTranslate::trans("Proses Sewa",
                                            session()->get('bahasa')) : GoogleTranslate::trans("Proses Sewa",
                                            'id')}}</option>
                                        <option value="2">{{session()->has('bahasa') ?
                                            GoogleTranslate::trans("Selesai",
                                            session()->get('bahasa')) : GoogleTranslate::trans("Selesai",
                                            'id')}}</option>
                                        <option value="3">{{session()->has('bahasa') ?
                                            GoogleTranslate::trans("Batal",
                                            session()->get('bahasa')) : GoogleTranslate::trans("Batal",
                                            'id')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Button -->
            <div class="col-md-2">
                <div class="card card-table">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary btn-block" id="btnPrint"><i
                                class="fa fa-print"></i> {{session()->has('bahasa') ? GoogleTranslate::trans("Cetak
                            Laporan",
                            session()->get('bahasa')) : GoogleTranslate::trans("Cetak Laporan",
                            'id')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function(){
            $('#btnPrint').click(function () {
                var tgl = $('#inputTgl').val();
                var status = $('#inputStatus').val();
                if (tgl == "" || status == "") {
                    swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silahkan isi tanggal dan status terlebih dahulu!',
                    })
                } else {
                    var url = "{{ route('laporan.print') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            tgl: tgl,
                            status: status
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                var newWindow = window.open('', '_blank');
                                newWindow.document.write(data.view); 
                                newWindow.document.close();

                                console.log(data);
                            } else {
                                swal({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data tidak ditemukan!',
                                });
                                console.log(data);
                            }
                        }, error: function(xhr, textStatus, errorThrown) {
                            swal({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data tidak ditemukan!',
                                })
                                console.log(xhr.responseText);
                        },
                    })
                    
                }
            })
        })
</script>
@endsection