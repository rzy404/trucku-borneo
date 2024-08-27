@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Pengguna - Pelanggan | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Pengguna - Pelanggan | TrucKu Borneo", 'id'))
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Pelanggan", session()->get('bahasa')) :
            GoogleTranslate::trans("Pelanggan", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Pengguna",
                    session()->get('bahasa')) : GoogleTranslate::trans("Pengguna",
                    'id') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.cost.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Pelanggan",
                    session()->get('bahasa')) : GoogleTranslate::trans("Pelanggan",
                    'id') }}</a></li>
        </ol>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Data Pelanggan",
                    session()->get('bahasa')) : GoogleTranslate::trans("Data Pelanggan",
                    'id') }}</h4>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal"
                    data-target="#ModalOperator" id="addOperator">
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
                                <th>Email</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("No. Telpon",
                                    session()->get('bahasa')) : GoogleTranslate::trans("No. Telpon",
                                    'id') }}</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Perusahaan",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Perusahaan",
                                    'id') }}</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Status Aktif",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Status Aktif",
                                    'id') }}</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Aksi",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Aksi",
                                    'id') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $cost)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $cost->nama }}</td>
                                <td>
                                    <a href="javascript:void(0);">
                                        <strong>{{ $cost->email }}</strong>
                                    </a>
                                </td>
                                <td>
                                    @if ($cost->no_telpon == NULL)
                                    -
                                    @else
                                    {{ $cost->no_telpon }}
                                    @endif
                                </td>
                                <td>
                                    @if ($cost->nama_perusahaan == NULL)
                                    -
                                    @else
                                    {{ $cost->nama_perusahaan }}
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('user.cost.update_status', $cost->id) }}" method="POST">
                                        @csrf
                                        @if ($cost->status_user == 0)
                                        <a id="status-costumer" name="status-costumer"><label
                                                class="badge light badge-danger">Belum Aktif</label></a>
                                        @else
                                        <a id="status-costumer" name="status-costumer"><label
                                                class="badge light badge-info">Aktif</label></a>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewCostumer"
                                            data-id="{{ $cost->id }}" data-toggle="modal"
                                            data-target="#View_ModalCostumer"><i class="fa fa-eye"></i></a>
                                        <form method="POST" action="{{ route('user.cost.delete', $cost->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp"
                                                id="deleteCostumer"><i class="fa fa-trash"></i></button>
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
@include('backend.admin.manage-user.costumer.modal')

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataCostumer').DataTable();
    });
</script>
<script>
    $(document).on("click", "#addCostumer", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            success: function() {
                $("#titleCostumer").html("Add Costumer");
                $("#ModalCostumer").modal("show");
                $("#formCostumer").trigger("reset");
                $("#btnModal").html("Save");
                $("#formCostumer").attr("action", '{{ route("user.cost.create") }}');
            }
        })
    });

    $(document).on("click", "#viewCostumer", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "{{ url('user/costumer/view/') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $("#titleCostumer").html("View Data");
                $("#View_ModalCostumer").modal("show");
                $("#namaLengkap").text(data.cost.nama);
                $("#profile_cost").attr("src", "{{ asset('images') }}" + "/" + data.cost.avatar);
                $("#email_cost").attr("placeholder", data.cost.email);
                $("#alamat_perusahaan").attr("placeholder", "-");

                if (data.cost.status_user == "1") {
                    $("#status_user").text("Aktif");
                } else {
                    $("#status_user").text("Belum Aktif");
                }

                if ($.trim(data.cost.nama_perusahaan) == "") {
                    $("#perusahaan").attr("placeholder", "-");
                } else {
                    $("#perusahaan").attr("placeholder", data.cost.nama_perusahaan);
                }

                if ($.trim(data.cost.no_telpon) === "") {
                    $("#no_telpon").attr("placeholder", "-");
                } else {
                    $("#no_telpon").attr("placeholder", data.cost.no_telpon);
                }

                if ($.trim(data.cost.alamat_perusahaan) === "") {
                    $("#alamat_perusahaan").attr("placeholder", "-");
                    console.log("ada")
                } else {
                    $("#alamat_perusahaan").attr("placeholder", data.cost.alamat_perusahaan);
                    console.log("tidak")
                }
            },
            error: function(msg) {}
        });
    });

    $(document).ready(function() {
        $('body').on('click', '#deleteCostumer', function(e) {
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

    $(document).on("click", "#status-costumer", function() {
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
</script>
@endsection