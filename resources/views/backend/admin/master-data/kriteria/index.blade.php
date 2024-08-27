@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Electre - Kriteria | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Electre - Kriteria | TrucKu Borneo", 'id'))
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Kriteria", session()->get('bahasa')) :
            GoogleTranslate::trans("Kriteria", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Metode",
                    session()->get('bahasa')) : GoogleTranslate::trans("Metode",
                    'id') }} Electre</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('kriteria.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Kriteria",
                    session()->get('bahasa')) : GoogleTranslate::trans("Kriteria",
                    'id') }}</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-lg-12 row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Data Kriteria",
                        session()->get('bahasa')) : GoogleTranslate::trans("Data Kriteria",
                        'id') }}</h4>
                    <button type="button" class="btn btn-rounded btn-primary mr-2" data-toggle="modal"
                        data-target="#ModalKriteria" id="addKriteria">
                        <span class="btn-icon-left text-primary">
                            <i class="fa fa-plus color-primary"></i>
                        </span>{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Tambah",
                        session()->get('bahasa')) : GoogleTranslate::trans("Tambah",
                        'id') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table primary-table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Kode Kriteria",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Kode Kriteria",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Kriteria",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Kriteria",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Bobot",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Bobot",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Aksi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Aksi",
                                        'id') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $krit)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $krit->id }}</td>
                                    <td>{{ $krit->kriteria }}</td>
                                    <td>{{ $krit->weight }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-primary shadow btn-xs sharp mr-1" id="editKriteria"
                                                data-id="{{ $krit->id }}" data-toggle="modal"
                                                data-target="#ModalKriteria"><i class="fa fa-pencil"></i></a>
                                            <form method="POST" action="{{ route('kriteria.delete', $krit->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp"
                                                    id="deleteKriteria"><i class="fa fa-trash"></i></button>
                                            </form>
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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Nilai Bobot Preferensi",
                        session()->get('bahasa')) : GoogleTranslate::trans("Nilai Bobot Preferensi",
                        'id') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display min-w300">
                            <thead>
                                <tr>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Bobot Preferensi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Bobot Preferensi",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Bobot",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Bobot",
                                        'id') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Sangat Rendah",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Sangat Rendah",
                                        'id') }}</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Rendah",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Rendah",
                                        'id') }}</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Cukup",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Cukup",
                                        'id') }}</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Tinggi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Tinggi",
                                        'id') }}</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Sangat Tinggi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Sangat Tinggi",
                                        'id') }}</td>
                                    <td>5</td>
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
@include('backend.admin.master-data.kriteria.modal')

@endsection
@section('script')
<script type="text/javascript">
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
</script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
@endsection