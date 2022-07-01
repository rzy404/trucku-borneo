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
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal"
                    data-target="#ModalOperator" id="addCostumer">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function () {
    $('#dataCostumer').DataTable();
});
</script>
@endsection