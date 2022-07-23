@extends('layouts.app')
@section('title', 'Management User - Costumer | TrucKu Borneo')
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Costumer</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Management User</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.cost.index') }}">Costumer</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Costumer</h4>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" data-target="#ModalCostumer" id="addCostumer">
                    <span class="btn-icon-left text-success">
                        <i class="fa fa-plus color-success"></i>
                    </span>Add
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
                                <th>No Telpon</th>
                                <th>Perusahaan</th>
                                <th>Status Aktif</th>
                                <th>Action</th>
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
                                    @if ($cost->perusahaan == NULL)
                                    -
                                    @else
                                    {{ $cost->perusahaan }}
                                    @endif
                                </td>
                                <td>
                                    @if ($cost->status_user == 0)
                                    <label class="badge light badge-danger">Belum Aktif</label>
                                    @else if ($cost->status_user == 1)
                                    <label class="badge light badge-info">Aktif</label>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewCostumer" data-id="{{ $cost->id }}" data-toggle="modal" data-target="#View_ModalCostumer"><i class="fa fa-eye"></i></a>
                                        <form method="POST" action="{{ route('user.cost.delete', $cost->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp" id="deleteCostumer"><i class="fa fa-trash"></i></button>
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
@include('admin.manage-user.costumer.modal')

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

        console.log("ok");
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

        console.log(id);
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
                console.log(data);
                if ($.trim(data.cost.perusahaan) == "") {
                    $("#perusahaan").attr("placeholder", "-");
                } else {
                    $("#perusahaan").attr("placeholder", data.cost.perusahaan);
                }

                if ($.trim(data.cost.no_telpon) === "") {
                    $("#no_telpon").attr("placeholder", "-");
                } else {
                    $("#no_telpon").attr("placeholder", data.cost.no_telpon);
                }
            }
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
</script>
@endsection