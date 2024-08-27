@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Pengguna - Operator | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Pengguna - Operator | TrucKu Borneo", 'id'))
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Operator", session()->get('bahasa')) :
            GoogleTranslate::trans("Operator", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard",
                    'id') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Pengguna",
                    session()->get('bahasa')) : GoogleTranslate::trans("Pengguna",
                    'id') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.operator.index') }}">{{ session()->has('bahasa')
                    ?
                    GoogleTranslate::trans("Operator",
                    session()->get('bahasa')) : GoogleTranslate::trans("Operator",
                    'id') }}</a></li>
        </ol>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Data Operator",
                    session()->get('bahasa')) : GoogleTranslate::trans("Data Operator",
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
                    <table id="dataOperator" class="display min-w850">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Aksi",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Aksi",
                                    'id') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $op)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $op->name }}</td>
                                <td>
                                    @if ($op->username == NULL)
                                    -
                                    @else
                                    {{ $op->username }}
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0);">
                                        <strong>{{ $op->email }}</strong>
                                    </a>
                                </td>
                                <td>
                                    @if(!empty($op->getRoleNames()))
                                    @foreach($op->getRoleNames() as $v)
                                    <label class="badge light badge-info">{{ $v }}</label>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if ($op->username != Auth::user()->username)
                                        <a class="btn btn-primary shadow btn-xs sharp mr-1" id="editOperator"
                                            data-id="{{ $op->id }}" data-toggle="modal" data-target="#ModalOperator"><i
                                                class="fa fa-pencil"></i></a>
                                        <form method="POST" action="{{ route('user.operator.delete', $op->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp"
                                                id="deleteOperator"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @else
                                        <span>No Action</span>
                                        @endif
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
@include('backend.admin.manage-user.operator.modal')

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataOperator').DataTable();
    });
</script>
<script>
    $(document).on('click', '#addOperator', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            success: function() {
                var titleOperator = "{{ session()->has('bahasa') ? GoogleTranslate::trans('Tambah Operator', session()->get('bahasa')) : GoogleTranslate::trans('Tambah Operator', 'id') }}";
                $('#titleOperator').html(titleOperator);
                $('#ModalOperator').modal('show');
                $('#formOperator').trigger('reset');
                $('#btnModal').html("Save");
                $('#formOperator').attr('action', '{{ route("user.operator.create") }}');
            }
        })
    });

    $(document).on('click', '#editOperator', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = $(this).data('id');
        var url2 = "{{ url('user/operator/update/') }}" + '/' + id;

        $.ajax({
            type: "GET",
            url: "{{ url('user/operator/edit/') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#ModalOperator').modal('show');
                $('#titleOperator').html("Edit Operator");
                $('#formOperator').attr('action', url2);
                $('#btnModal').html("Update");
                $('#namaOperator').val(data.user.name);
                $('#email').val(data.user.email);
                $('#roles').val(data.userRole);
            }
        });
    });

    $(document).ready(function() {
        $('body').on('click', '#deleteOperator', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            var name = $(this).data("name");
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