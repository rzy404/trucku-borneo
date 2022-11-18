@extends('layouts.app')
@section('title', 'Electre - Alternatif | TrucKu Borneo')
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Alternatif</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Metode Electre</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('alternatif.index') }}">Alternatif</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-lg-12 row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Alternatif</h4>
                    <button type="button" class="btn btn-rounded btn-secondary" data-toggle="modal" data-target="#ModalKriteria" id="viewKriteria">
                        <span class="btn-icon-left text-secondary">
                            <i class="fa fa-eye color-secondary"></i>
                        </span>Show
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table primary-table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Alternatif</th>
                                    <th>Perusahaan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAlternatif as $alternatif)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $alternatif->id_perusahaan }}</td>
                                    <td>{{ $alternatif->nama_perusahaan }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-secondary shadow btn-xs sharp mr-1" id="edit" data-id="{{ $alternatif->id }}" data-toggle="modal" data-target="#ModalKriteria"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Matiks Keputusan (x)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped primary-table-bordered">
                            <thead class="thead-primary">
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Alternatif</th>
                                    <th colspan="5" style="text-align: center; vertical-align: middle;">Kriteria</th>
                                </tr>
                                <tr>
                                    @foreach ($dataKriteria as $kriteria)
                                    <th>{{ $kriteria->id }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @foreach($dataAlternatif as $alternatif)
                                @endforeach -->
                                <tr>
                                    <td style="text-align: center;">A1</td>
                                    <td>4</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    </pre>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">A2</td>
                                    <td>2</td>
                                    <td>5</td>
                                    <td>4</td>
                                    <td>5</td>
                                    </pre>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@include('admin.master-data.alternatif.modal')

@endsection
@section('script')
<!-- <script type=" text/javascript">
                                        $(document).on("click", "#addKriteria", function() {
                                        $.ajaxSetup({
                                        headers: {
                                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                                        }
                                        });

                                        $.ajax({
                                        success: function() {
                                        $("#titleKriteria").html("Add Kriteria");
                                        $("#ModalKriteria").modal("show");
                                        $('#btnModal').html("Save");
                                        $("#formKriteria").trigger("reset");
                                        $("#formKriteria").attr("action", '{{ route("kriteria.create") }}');
                                        }
                                        })
                                        });

                                        $(document).on('click', '#editKriteria', function() {
                                        $.ajaxSetup({
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                        });
                                        var id = $(this).data('id');
                                        var url2 = "{{ url('kriteria/update/') }}" + '/' + id;

                                        $.ajax({
                                        type: "GET",
                                        url: "{{ url('kriteria/edit/') }}" + '/' + id,
                                        data: {
                                        id: id
                                        },
                                        dataType: 'json',
                                        cache: false,
                                        success: function(data) {
                                        $('#titleKriteria').html("Edit Data Kriteria");
                                        $('#formKriteria').attr('action', url2);
                                        $('#btnModal').html("Update");
                                        $('#kriteria').val(data.kriteria.kriteria);
                                        $('#weight').val(data.kriteria.weight);
                                        console.log(data.kriteria)
                                        },
                                        error: function(msg) {
                                        console.log(msg);
                                        }
                                        });
                                        });

                                        $(document).ready(function() {
                                        $('body').on('click', '#deleteKriteria', function(e) {
                                        e.preventDefault();
                                        var form = $(this).closest("form");
                                        swal({
                                        title: 'Hapus',
                                        text: "Apakah anda yakin ingin menghapus data ini ?",
                                        icon: 'warning',
                                        buttons: ["Batal", "Ya, Hapus"],
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        }).then((result => {
                                        if (result) {
                                        form.submit();
                                        }
                                        }))
                                        });
                                        });
                                        </script> -->
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
@endsection