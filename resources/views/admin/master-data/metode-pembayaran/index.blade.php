@extends('layouts.app')
@section('title', 'Master Data - Metode Pembayaran | TrucKu Borneo')
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Metode Pembayaran</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Master Data</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('metodepb.index') }}">Metode Pembayaran</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Metode Pembayaran</h4>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" data-target="#ModalMetodePembayaran" id="AddMetode_Pembayaran">
                    <span class="btn-icon-left text-success">
                        <i class="fa fa-plus color-success"></i>
                    </span>Add
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-MetodeBayar" class="display min-w850">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bank</th>
                                <th>No Rekening</th>
                                <th>Atas Nama</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $mp)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <img src="{{ asset('images/' . $mp->logo) }}" width="100px" height="50px">
                                </td>
                                <td>{{ $mp->norek }}</td>
                                <td>{{ $mp->atas_nama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-primary shadow btn-xs sharp mr-1" id="editMetode" data-id="{{ $mp->id }}" data-toggle="modal" data-target="#ModalMetodePembayaran"><i class="fa fa-pencil"></i></a>
                                        <form method="POST" action="{{ route('metodepb.delete', $mp->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp" id="deleteMetode"><i class="fa fa-trash"></i></button>
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
@include('admin.master-data.metode-pembayaran.modal')
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#data-MetodeBayar').DataTable();
    });
</script>
<script>
    $(document).on("click", "#AddMetode_Pembayaran", function() {
        $.ajaxSetup({
            heaeders: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            }
        })

        $.ajax({
            success: function() {
                $("#titleBayar").html("Add Metode Pembayaran");
                $("#btnModal").html("Save");
                $("#formBayar").trigger("reset");
                $("#formBayar").attr("action", "{{ route('metodepb.create') }}")
            }
        });
    });

    $(document).on("click", "#editMetode", function() {
        $.ajaxSetup({
            heaeders: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            }
        })

        var id = $(this).data("id");
        var url2 = "{{ url('metode-pembayaran/update/') }}" + "/" + id;

        $.ajax({
            type: "GET",
            url: "{{ url('metode-pembayaran/edit/') }}" + "/" + id,
            data: {
                id: id
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $("#titleBayar").html("Edit Data Metode Pembayaran");
                $("#formBayar").attr("action", url2);
                $("#btnModal").html("Update");
                $('#metode_bayar').val(data.metode.metode_bayar);
                $('#norek').val(data.metode.norek);
                $('#atas_nama').val(data.metode.atas_nama);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });

    $(document).ready(function() {
        $('body').on('click', '#deleteMetode', function(e) {
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