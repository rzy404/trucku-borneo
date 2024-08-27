@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Pengguna - Sopir | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Pengguna - Sopir | TrucKu Borneo", 'id'))
@section('css')
<!-- pick date -->
<link href="{{ asset('vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet"> -->
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Sopir", session()->get('bahasa')) :
            GoogleTranslate::trans("Sopir", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Pengguna",
                    session()->get('bahasa')) : GoogleTranslate::trans("Pengguna",
                    'id') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.driver.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Sopir",
                    session()->get('bahasa')) : GoogleTranslate::trans("Sopir",
                    'id') }}</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Data Sopir",
                    session()->get('bahasa')) : GoogleTranslate::trans("Data Sopir",
                    'id') }}</h4>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" data-target="#ModalDriver"
                    id="addDriver">
                    <span class="btn-icon-left text-success">
                        <i class="fa fa-plus color-success"></i>
                    </span>{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Tambah",
                    session()->get('bahasa')) : GoogleTranslate::trans("Tambah",
                    'id') }}
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataCostumer" class="display min-w850">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Umur",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Umur",
                                    'id') }}</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("No. Telpon",
                                    session()->get('bahasa')) : GoogleTranslate::trans("No. Telpon",
                                    'id') }}</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Agama",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Agama",
                                    'id') }}</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Aksi",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Aksi",
                                    'id') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $dr)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $dr->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($dr->tgl_lahir)->age }} Tahun</td>
                                <td>{{ $dr->no_telpon }}</td>
                                <td>{{ $dr->agama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewDriver"
                                            data-id="{{ $dr->id }}" data-toggle="modal"
                                            data-target="#View_ModalDriver"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-primary shadow btn-xs sharp mr-1" id="editDriver"
                                            data-id="{{ $dr->id }}" data-toggle="modal" data-target="#ModalDriver"><i
                                                class="fa fa-pencil"></i></a>
                                        <form method="POST" action="{{ route('user.driver.delete', $dr->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp"
                                                id="deleteDriver"><i class="fa fa-trash"></i></button>
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
</div>

<!-- Modal -->
@include('backend.admin.manage-user.driver.modal')

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataCostumer').DataTable();
    });
</script>
<script>
    $(document).on("click", "#addDriver", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            success: function() {
                $("#titleDriver").html("Add Driver");
                $("#ModalDriver").modal("show");
                $("#formDriver").trigger("reset");
                $("#formDriver").attr("action", '{{ route("user.driver.create") }}');
                $('#btnModal').html("Save");
            }
        })
    });

    $(document).on('click', '#editDriver', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).data('id');
        var url2 = "{{ url('user/driver/update/') }}" + '/' + id;

        $.ajax({
            type: "GET",
            url: "{{ url('user/driver/edit/') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#ModalDriver').modal('show');
                $('#titleDriver').html("Edit Driver");
                $('#formDriver').attr('action', url2);
                $('#btnModal').html("Update");
                $('#namaDriver').val(data.driver.nama);
                $('#mdate').val(data.driver.tgl_lahir);
                $('textarea#alamat').val(data.driver.alamat);
                $('#agama option[value="' + data.driver.agama + '"]').val(data.driver.agama).attr('selected', 'selected');
                $('#notel').val(data.driver.no_telpon);
            }
        });
    });

    $(document).on("click", "#viewDriver", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "{{ url('user/driver/view/') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                console.log(data.format_tgl);
                $("#View_ModalDriver").modal("show");
                $("#namaLengkap").text(data.driver.nama);
                $("#profileDriver").attr("src", "{{ asset('images') }}" + "/" + data.driver.avatar);
                $("#no_telpon").attr("placeholder", data.driver.no_telpon);
                $("#agama").attr("placeholder", data.driver.agama);
                $("#alamat").attr("placeholder", data.driver.alamat);
                $("p#umur_driver").text(data.umur + " Tahun");
                $("#tgl_lahir").attr("placeholder", data.format_tgl);
            }
        });
    });

    $(document).ready(function() {
        $('body').on('click', '#deleteDriver', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            var name = $(this).data("name");
            console.log(name);
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
<!-- pick date -->
<script src="{{ asset('vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('js/plugins-init/material-date-picker-init.js') }}"></script>
@endsection