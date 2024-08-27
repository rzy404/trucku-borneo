@extends('layouts.app')
@section('title', 'Electre - Alternatif | TrucKu Borneo')
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Alternatif", session()->get('bahasa')) :
            GoogleTranslate::trans("Alternatif", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Metode",
                    session()->get('bahasa')) : GoogleTranslate::trans("Metode",
                    'id') }} Electre</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('alternatif.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Alternatif",
                    session()->get('bahasa')) : GoogleTranslate::trans("Alternatif",
                    'id') }}</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-lg-12 row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Alternatif</h4>
                    <button type="button" class="btn btn-rounded btn-secondary" data-toggle="modal"
                        data-target="#ModalKriteria" id="viewKriteria">
                        <span class="btn-icon-left text-secondary">
                            <i class="fa fa-eye color-secondary"></i>
                        </span>{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Lihat",
                        session()->get('bahasa')) : GoogleTranslate::trans("Lihat",
                        'id') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table primary-table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ session()->has('bahasa')
                                        ?
                                        GoogleTranslate::trans("Alternatif",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Alternatif",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa')
                                        ?
                                        GoogleTranslate::trans("Perusahaan",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Perusahaan",
                                        'id') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAlternatif as $alternatif)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td style="font-weight: bold">{{ $alternatif->transaksi }}</td>
                                    <td>{{ $alternatif->nama_perusahaan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Awal</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped primary-table-bordered">
                            <thead class="thead-primary">
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">{{
                                        session()->has('bahasa')
                                        ?
                                        GoogleTranslate::trans("Alternatif",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Alternatif",
                                        'id') }}</th>
                                    <th colspan="5" style="text-align: center; vertical-align: middle;">{{
                                        session()->has('bahasa')
                                        ?
                                        GoogleTranslate::trans("Kriteria",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Kriteria",
                                        'id') }}</th>
                                </tr>
                                <tr>
                                    @foreach ($dataKriteria as $kriteria)
                                    {{-- <th align="center">{{ $kriteria->kriteria }}</th> --}}
                                    <th align="center">
                                        {{ session()->has('bahasa') ? GoogleTranslate::trans($kriteria->kriteria,
                                        session()->get('bahasa')) : GoogleTranslate::trans($kriteria->kriteria, 'id') }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataNilaiAwal as $nilai_awal)
                                <tr>
                                    <td align="center">{{ $nilai_awal->transaksi }}</td>
                                    <td align="center">{{ $nilai_awal->jarak_tempuh }} KM</td>
                                    <td align="center">{{ $nilai_awal->jumlah_muatan }} Ton</td>
                                    <td align="center">{{ number_format($nilai_awal->total_biaya, 0, ".", ",") }}</td>
                                    <td align="center">{{ $nilai_awal->lama_sewa }} Hari</td>
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

<!-- Modal -->
@include('backend.admin.master-data.alternatif.modal')

@endsection
@section('script')
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
@endsection