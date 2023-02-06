@extends('layouts.app')
@section('title', 'Dashboard | TrucKu Borneo')
@section('content')
<div class="container-fluid">
    <div class="form-head d-flex align-items-center mb-sm-4 mb-3">
        <div class="mr-auto">
            <h2 class="text-black font-w600">Dashboard</h2>
            <p class="mb-0">Hai &#128075;&#127996;, {{ Auth::user()->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body mr-3">
                            <h2 class="fs-34 text-black font-w600">{{ $countCostumer }}</h2>
                            <span>Costumer</span>
                        </div>
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="40"
                            height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                </div>
                <div class="progress  rounded-0" style="height:4px;">
                    <div class="progress-bar rounded-0 bg-secondary progress-animated"
                        style="width: {{ $countCostumer }}%; height:4px;" role="progressbar">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body mr-3">
                            <h2 class="fs-34 text-black font-w600">{{ $countTruk }}</h2>
                            <span>Truk</span>
                        </div>
                        <svg id="icon-truck" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="40"
                            height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                </div>
                <div class="progress  rounded-0" style="height:4px;">
                    <div class="progress-bar rounded-0 bg-secondary progress-animated"
                        style="width: {{ $countTruk }}%; height:4px;" role="progressbar">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body mr-3">
                            <h2 class="fs-34 text-black font-w600">{{ $countDriver }}</h2>
                            <span>Driver</span>
                        </div>
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="40"
                            height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                </div>
                <div class="progress  rounded-0" style="height:4px;">
                    <div class="progress-bar rounded-0 bg-secondary progress-animated"
                        style="width: {{ $countDriver }}%; height:4px;" role="progressbar">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body mr-3">
                            <h2 class="fs-34 text-black font-w600">{{ $countTransaksi }}</h2>
                            <span>Transaksi</span>
                        </div>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.7 39.9993C15.8603 40.0123 18.0017 39.5921 20 38.763C21.9962 39.5991 24.139 40.0196 26.3 39.9993C32.861 39.9993 38 36.463 38 31.9467V24.4159C38 19.8996 32.861 16.3633 26.3 16.3633C25.9958 16.3633 25.697 16.3779 25.4 16.3943V7.87804C25.4 3.45448 20.261 0 13.7 0C7.139 0 2 3.45448 2 7.87804V32.1213C2 36.5448 7.139 39.9993 13.7 39.9993ZM34.4 31.9467C34.4 34.0358 31.0736 36.363 26.3 36.363C21.5264 36.363 18.2 34.0358 18.2 31.9467V30.2649C20.6376 31.7624 23.4476 32.5262 26.3 32.4667C29.1524 32.5262 31.9624 31.7624 34.4 30.2649V31.9467ZM26.3 19.9996C31.0736 19.9996 34.4 22.3269 34.4 24.4159C34.4 26.505 31.0736 28.8304 26.3 28.8304C21.5264 28.8304 18.2 26.5032 18.2 24.4159C18.2 22.3287 21.5264 19.9996 26.3 19.9996ZM13.7 3.6363C18.4736 3.6363 21.8 5.87262 21.8 7.87804C21.8 9.88346 18.4736 12.1216 13.7 12.1216C8.9264 12.1216 5.6 9.88528 5.6 7.87804C5.6 5.87081 8.9264 3.6363 13.7 3.6363ZM5.6 13.6034C8.04776 15.0717 10.8538 15.8181 13.7 15.7579C16.5462 15.8181 19.3522 15.0717 21.8 13.6034V16.9633C19.8383 17.4628 18.0392 18.4698 16.58 19.8851C15.6336 20.092 14.6683 20.198 13.7 20.2015C8.9264 20.2015 5.6 17.9651 5.6 15.9597V13.6034ZM5.6 21.6851C8.04828 23.1519 10.854 23.8976 13.7 23.8378C14.0204 23.8378 14.33 23.7978 14.645 23.7814C14.6182 23.9919 14.6032 24.2037 14.6 24.4159V28.2068C14.2976 28.225 14.006 28.2831 13.7 28.2831C8.9264 28.2831 5.6 26.0468 5.6 24.0396V21.6851ZM5.6 29.7649C8.04776 31.2332 10.8538 31.9796 13.7 31.9194C14.0024 31.9194 14.2994 31.8958 14.6 31.8813V31.9467C14.6258 33.4944 15.2146 34.9784 16.2542 36.1157C15.412 36.2763 14.5571 36.3591 13.7 36.363C8.9264 36.363 5.6 34.1267 5.6 32.1213V29.7649Z"
                                fill="#007A64" />
                        </svg>
                    </div>
                </div>
                <div class="progress  rounded-0" style="height:4px;">
                    <div class="progress-bar rounded-0 bg-secondary progress-animated"
                        style="width: {{ $countTransaksi }}%; height:4px;" role="progressbar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection