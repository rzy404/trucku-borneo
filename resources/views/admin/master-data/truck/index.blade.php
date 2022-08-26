@extends('layouts.app')
@section('title', 'Master Data - Truck | TrucKu Borneo')
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Truck</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Master Data</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.driver.index') }}">Truck</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Truck</h4>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" data-target="#ModalTruk" id="addTruk">
                    <span class="btn-icon-left text-success">
                        <i class="fa fa-plus color-success"></i>
                    </span>Add
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTruck" class="display min-w850">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Plat</th>
                                <th>Jenis Truck</th>
                                <th>Tahun Buat</th>
                                <th>Driver</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $tr)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $tr->no_plat }}</td>
                                <td>{{ $tr->jenis_truck }}</td>
                                <td>{{ $tr->tahun_buat }}</td>
                                <td>
                                    <select class="select2-width-100 driver-truk" name="driver-truk" data-url="{{ url('data-truck/update-driver') }}" data-id_truk="{{ $tr->id }}" data-token="{{ csrf_token() }}">
                                        <option value="">Pilih Driver</option>
                                        @forelse ($data_driver as $dr)
                                        <option value="{{ $dr->id }}" {{ ($tr->driver == $dr->id) ? 'selected' : '' }}>{{ $dr->nama }}</option>
                                        @empty
                                        <option value="">
                                            Tidak Ada Data Driver
                                        </option>
                                        <!-- </form> -->
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewTruk" data-id="{{ $tr->id }}" data-toggle="modal" data-target="#View_ModalTruk"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-primary shadow btn-xs sharp mr-1" id="editTruk" data-id="{{ $tr->id }}" data-toggle="modal" data-target="#ModalTruk"><i class="fa fa-pencil"></i></a>
                                        <form method="POST" action="{{ route('truk.delete', $tr->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp" id="deleteTruk"><i class="fa fa-trash"></i></button>
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
@include('admin.master-data.truck.modal')

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataTruck').DataTable();
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
                $('#jenis_truck').val(data.truk.jenis_truck);
                $('#merek_truck').val(data.truk.merek_truck);
                $('#tahun_buat').val(data.truk.tahun_buat);
                $('#wr').val(data.truk.warna);
                $('#dimensi_maks').val(data.truk.dimensi);
                $('#volume_maks').val(data.truk.volume);
                $('#beban_maks').val(data.truk.beban_maks);
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
                $("#jenis").attr("placeholder", data.truk.jenis_truck);
                $("#merek").attr("placeholder", data.truk.merek_truck);
                $("#tahun").attr("placeholder", data.truk.tahun_buat);
                $("#warna").attr("placeholder", data.truk.warna);
                $("#dimensi").attr("placeholder", data.truk.dimensi);
                $("#volume").attr("placeholder", data.truk.volume);
                $("#beban").attr("placeholder", data.truk.beban_maks);

                if ($.trim(data.truk.nama_driver) == "") {
                    $("#driver").attr("placeholder", "Driver Truk Ini Belum Ada");
                } else {
                    $("#driver").attr("placeholder", data.truk.nama_driver);
                }
            }
        });
    });

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

    $(document).ready(function() {
        $(".select2-width-100").select2();
        $('.driver-truk').on('change', function() {

            var id_driver = $(".driver-truk").val();
            var id_truk = $(this).data('id_truk');
            var token = $(this).data('token');
            var base_url = $(this).data('url');

            $.ajax({
                url: base_url + '/' + id_truk + '/' + id_driver,
                type: 'POST',
                data: {
                    _token: token,
                    driver: id_driver,
                    truk: id_truk
                },
                success: function(msg) {
                    location.reload()
                },
                error: function(msg) {
                    console.log(msg)
                }
            });
        })
    });
</script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
@endsection