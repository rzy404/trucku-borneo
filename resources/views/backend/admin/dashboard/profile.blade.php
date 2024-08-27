@extends('layouts.app')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Profil | TrucKu Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Profil | TrucKu Borneo", 'id'))
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>{{ session()->has('bahasa') ? GoogleTranslate::trans("Profile", session()->get('bahasa')) :
            GoogleTranslate::trans("Profile", 'id') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard", 'id') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('profile.detail') }}">{{ session()->has('bahasa') ?
                    GoogleTranslate::trans("Profile", session()->get('bahasa')) : GoogleTranslate::trans("Profile",
                    'id') }}</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="profile-blog mb-5">
                        <div class="dropdown pull-right ml-auto">
                            <a href="#" class="btn btn-primary light sharp" data-toggle="dropdown" aria-expanded="true">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                    </g>
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item" data-toggle="modal" data-target="#modalChangePassword"><i
                                        class="fa fa-key text-primary mr-2"></i>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Edit
                                    Password",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Edit Password", 'id') }}</li>
                                <li class="dropdown-item" data-toggle="modal" data-target="#modalChangeAvatar"><i
                                        class="fa fa-image text-primary mr-2"></i>{{ session()->has('bahasa') ?
                                    GoogleTranslate::trans("Edit Foto
                                    Profil",
                                    session()->get('bahasa')) : GoogleTranslate::trans("Edit Foto Profil", 'id') }}
                            </ul>
                        </div>
                        <img src="{{ asset('images/' . Auth::user()->avatar) }}"
                            class="img-fluid rounded-circle mt-4 mb-4 w-100" alt="">
                        <div class="row mt-3 sp-3">
                            <div class="profile-name px-2 pt-2">
                                <h4 class="text-primary mb-0">{{ Auth::user()->name }}</h4>
                                <p class="mb-0">{{ Auth::user()->username }}</p>
                            </div>
                            <div class="profile-name px-2 pt-2">
                                <h4 class="text-primary mb-0">{{ Auth::user()->email }}</h4>
                                <p class="mb-0">Email</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div class="tab-content">
                                <div id="profile-settings" class="tab-pane fade active show">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <h4 class="text-primary">{{ session()->has('bahasa') ?
                                                GoogleTranslate::trans("Pengaturan Akun",
                                                session()->get('bahasa')) : GoogleTranslate::trans("Pengaturan Akun",
                                                'id') }}</h4>
                                            <form action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Nama</label>
                                                        <input type="text" placeholder="Nama"
                                                            class="form-control @error('nama') is-invalid @enderror"
                                                            name="nama"
                                                            value="{{ old('nama') ? old('nama') : auth()->user()->name }}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Username</label>
                                                        <input type="text" placeholder="Username"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            name="username"
                                                            value="{{ old('username') ? old('username') : auth()->user()->username }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" placeholder="Email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email"
                                                        value="{{ old('email') ? old('email') : auth()->user()->email }}">
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-primary" type="submit">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal change password -->
<div class="modal fade" id="modalChangePassword">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ session()->has('bahasa') ? GoogleTranslate::trans("Edit Password",
                    session()->get('bahasa')) : GoogleTranslate::trans("Edit Password", 'id') }}</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form action="{{ route('profile.change-password') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="current_pw"
                            class="form-control @error('current_pw') is-invalid @enderror"
                            placeholder="Masukkan Password Lama" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password Baru</label>
                            <input type="password" name="new_pw"
                                class="form-control @error('new_pw') is-invalid @enderror"
                                placeholder="Masukkan Password Baru" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="confirm_pw"
                                class="form-control @error('confirm_pw') is-invalid @enderror"
                                placeholder="Konfirmasi Password Baru" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal change image profile -->
<div class="modal fade" id="modalChangeAvatar">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Foto Profil</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form action="{{ route('profile.change-avatar') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="avatar" class="custom-file-input">
                            <label class="custom-file-label">Pilih Foto</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection