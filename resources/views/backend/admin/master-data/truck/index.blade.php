@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Master Data - Truk | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Master Data - Truk | TrucKu Borneo", 'id'))
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Truk", session()->get('bahasa')) :
            GoogleTranslate::trans("Truk", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Master Data",
                    session()->get('bahasa')) : GoogleTranslate::trans("Master Data",
                    'id') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('truk.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Truk",
                    session()->get('bahasa')) : GoogleTranslate::trans("Truk",
                    'id') }}</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-lg-12 row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Data Jenis Truk",
                        session()->get('bahasa')) : GoogleTranslate::trans("Data Jenis Truk",
                        'id') }}</h4>
                    <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal"
                        data-target="#ModalJenisTruk" id="addJenis">
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
                        <table id="dataJenis" class="display min-w300">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Jenis Truk",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Jenis Truk",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Aksi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Aksi",
                                        'id') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_jenisTruk as $tr)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $tr->jenis_truk }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex">
                                            <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewJenis"
                                                data-id="{{ $tr->id }}" data-toggle="modal"
                                                data-target="#View_ModalJenis"><i class="fa fa-eye"></i></a>
                                            <form method="POST" action="{{ route('truk.deleteJenisTruk', $tr->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp"
                                                    id="deleteTruk"><i class="fa fa-trash"></i></button>
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
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ session()->has('bahasa') ? GoogleTranslate::trans("Data Truk",
                        session()->get('bahasa')) :
                        GoogleTranslate::trans("Data Truk", 'id') }}</h4>
                    <button type="button" class="btn btn-rounded btn-success" data-toggle="modal"
                        data-target="#ModalTruk" id="addTruk">
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
                        <table id="dataTruck" class="display min-w550">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Plat</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Jenis Truk",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Jenis Truk",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Sopir",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Sopir",
                                        'id') }}</th>
                                    <th>{{ session()->has('bahasa') ?
                                        GoogleTranslate::trans("Aksi",
                                        session()->get('bahasa')) : GoogleTranslate::trans("Aksi",
                                        'id') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $tr)
                                <tr>
                                    <td>{{ ++$s }}</td>
                                    <td>{{ $tr->no_plat }}</td>
                                    <td>{{ $tr->jenis_truk }}</td>
                                    <td>
                                        <form action="{{ route('truk.updateDriver', $tr->id) }}" method="POST">
                                            @csrf
                                            <select class="select2-width-100 driver-truk" name="driver">
                                                <option value="">Pilih Driver</option>
                                                @forelse ($data_driver as $dr)
                                                <option value="{{ $dr->id }}" {{ ($tr->driver == $dr->id) ? 'selected' :
                                                    '' }}>{{ $dr->nama }}</option>
                                                @empty
                                                <option value="">
                                                    Tidak Ada Data Driver
                                                </option>
                                                @endforelse
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewTruk"
                                                data-id="{{ $tr->id }}" data-toggle="modal"
                                                data-target="#View_ModalTruk"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-primary shadow btn-xs sharp mr-1" id="editTruk"
                                                data-id="{{ $tr->id }}" data-toggle="modal" data-target="#ModalTruk"><i
                                                    class="fa fa-pencil"></i></a>
                                            <form method="POST" action="{{ route('truk.delete', $tr->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp"
                                                    id="deleteTruk"><i class="fa fa-trash"></i></button>
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
</div>

<!-- Modal -->
@include('backend.admin.master-data.truck.modal')

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataTruck').DataTable();

        $('#dataJenis').DataTable({
            "paging": false
        });
    });
</script>
<script type="text/javascript">
    $(document).on("click", "#addTruk", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            success: function() {
                $("#titleTruk").html("Add Truck");
                $("#ModalTruk").modal("show");
                $('#btnModal').html("Save");
                $("#formTruk").trigger("reset");
                $("#formTruk").attr("action", '{{ route("truk.create") }}');
            }
        })
    });

    $(document).on("click", "#addJenis", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            success: function() {
                $("#titleJenis").html("Add Jenis Truck");
                $("#ModalJenisTruk").modal("show");
                $('#btnModal').html("Save");
                $("#formJenis").trigger("reset");
                $("#formJenis").attr("action", '{{ route("truk.create_jenisTruk") }}');
            }
        })
    });

    $(document).on('click', '#editTruk', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).data('id');
        var url2 = "{{ url('data-truck/update/') }}" + '/' + id;

        $.ajax({
            type: "GET",
            url: "{{ url('data-truck/edit/') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#titleTruk').html("Edit Data Truck");
                $('#formTruk').attr('action', url2);
                $('#btnModal').html("Update");
                $('#np').val(data.truk.no_plat);
                $("#jenis_truk").val(data.truk.jenis_truk).attr('selected', 'selected');
                $('#merek_truck').val(data.truk.merek_truck);
                $('#tahun_buat').val(data.truk.tahun_buat);
                $('#wr').val(data.truk.warna);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });

    $(document).on("click", "#viewTruk", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "{{ url('data-truck/view/') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $("#View_ModalTruk").modal("show");
                $("#image_truck").attr("src", "{{ asset('images') }}" + "/" + data.truk.img_truck);
                $("#no_plat").attr("placeholder", data.truk.no_plat);
                $("#jenis").attr("placeholder", data.truk.jenis_truk);
                $("#merek").attr("placeholder", data.truk.merek_truck);
                $("#tahun").attr("placeholder", data.truk.tahun_buat);
                $("#warna").attr("placeholder", data.truk.warna);
                $("#dimensi").attr("placeholder", data.truk.dimensi);
                $("#volume").attr("placeholder", data.truk.volume);
                $("#beban").attr("placeholder", data.truk.beban_maks);

                if ($.trim(data.truk.nama_driver) == "") {
                    $("#driver").attr("placeholder", "Truk Ini Belum Ada Driver");
                } else {
                    $("#driver").attr("placeholder", data.truk.nama_driver);
                }
            }
        });
    });

    $(document).on('click', "#viewJenis", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "{{ url('data-truck/view/jenis') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $('#jenisTruk .namaJenis').html("Jenis Truck :");
                $('#jenisTruk .dataJenis').html(data.jenis.jenis_truk);
                $('#jenisTruk .namaDimensi').html("Dimensi :");
                $('#jenisTruk .dataDimensi').html(data.jenis.dimensi);
                $('#jenisTruk .namaVolume').html("Volume :");
                $('#jenisTruk .dataVolume').html(data.jenis.volume);
                $('#jenisTruk .namaBeban').html("Beban :");
                $('#jenisTruk .dataBeban').html(data.jenis.beban_maks);
                $('#jenisTruk .namaBiaya').html("Biaya/Liter :");
                $('#jenisTruk .dataBiaya').html(convertToRupiah(data.jenis.biaya));
            }
        });
    })

    $(document).ready(function() {
        $(".select2-width-100").select2();
        $(".driver-truk").on("change", function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            var form = $(this).closest("form");
            swal({
                title: 'Update Status',
                text: "Apakah anda yakin ingin mengubah data ini ?",
                icon: 'warning',
                buttons: ["Batal", "Ya, Ubah"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result => {
                if (result) {
                    form.submit();
                }
            }))
        });
    })

    $(document).ready(function() {
        $('body').on('click', '#deleteTruk', function(e) {
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