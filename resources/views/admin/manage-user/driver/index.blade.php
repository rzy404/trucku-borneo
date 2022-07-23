@extends('layouts.app')
@section('title', 'Management User - Driver Truck | TrucKu Borneo')
@section('css')
<!-- pick date -->
<link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Driver</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Management User</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.driver.index') }}">Driver</a></li>
        </ol>
    </div>
    <!-- Datatable -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Driver</h4>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" data-target="#ModalDriver" id="addDriver">
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
                                <th>Tanggal Lahir</th>
                                <th>No Telpon</th>
                                <th>Agama</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dr)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $dr->nama }}</td>
                                <td>{{ $dr->tgl_lahir }}</td>
                                <td>{{ $dr->no_telpon }}</td>
                                <td>{{ $dr->agama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-info shadow btn-xs sharp mr-1" id="viewCostumer" data-id="{{ $dr->id }}" data-toggle="modal" data-target="#View_ModalCostumer"><i class="fa fa-eye"></i></a>
                                        <form method="POST" action="{{ route('user.cost.delete', $dr->id) }}">
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
@include('admin.manage-user.driver.modal')

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

        console.log("ok");
        $.ajax({
            success: function() {
                $("#titleDriver").html("Add Driver");
                $("#ModalDriver").modal("show");
                $("#formDriver").trigger("reset");
                $("#btnModal").html("Save");
                $("#formDriver").attr("action", '{{ route("user.cost.create") }}');
            }
        })
    });
</script>
<!-- pick date -->
<script src="{{ asset('vendor/pickadate/picker.js') }}"></script>
<script src="{{ asset('vendor/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('vendor/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('js/plugins-init/pickadate-init.js') }}"></script>
@endsection