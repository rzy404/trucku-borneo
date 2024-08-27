@extends('layouts.frontend')
@section('title', session()->has('bahasa') ? GoogleTranslate::trans("Sewa Truk dengan Cepat, Mudah, dan Efisien | TrucKu
Borneo",
session()->get('bahasa')) : GoogleTranslate::trans("Sewa Truk dengan Cepat, Mudah, dan Efisien", 'id'))
@section('content')

@push('css')
<style>
    .language-selector {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 150px;
        height: 40px;
        background-color: #007A64;
        border-radius: 5px;
        overflow: hidden;
    }

    .language-selector select {
        padding: 10px;
        width: 100%;
        border: none;
        background: transparent;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        cursor: pointer;
        font-family: "Poppins", sans-serif;
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }

    .language-selector select:focus {
        outline: none;
    }
</style>
@endpush

<!-- Header -->
<header id="header" class="header">
    <svg class="header-bg" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
        viewBox="0 0 1720.053 1080">
        <defs>
            <style>
                .cls-1 {
                    fill: #007A64;
                }
            </style>
            <linearGradient id="linear-gradient" x1="190.62" y1="-190.62" x2="1472.363" y2="1091.123"
                gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#ff4587" />
                <stop offset="0.156" stop-color="#ff4e86" />
                <stop offset="0.415" stop-color="#ff6785" />
                <stop offset="0.742" stop-color="#fe9082" />
                <stop offset="1" stop-color="#feb580" />
            </linearGradient>
        </defs>
        <title>header-background</title>
        <path class="cls-1"
            d="M1455.1,1080L72.853,1000.374A73.067,73.067,0,0,1,0,927.521V0H1720.053l-2.3,12.065-189.8,995.082C1520,1050.667,1495.165,1080,1455.1,1080Z" />
    </svg>

    <a href="index.html"><img class="logo-image" src="images/icon/logo_text.png" alt="alternative"></a>

    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="text-container">
                    <h2 class="mb-4">
                        {{ session()->has('bahasa') ? GoogleTranslate::trans("Pesan Truk dengan",
                        session()->get('bahasa')) : GoogleTranslate::trans("Pesan Truk dengan", 'id') }}
                        <span id="js-rotating">
                            {{ session()->has('bahasa') ? GoogleTranslate::trans("cepat, mudah, efisien",
                            session()->get('bahasa')) : GoogleTranslate::trans("cepat, mudah, efisien", 'id') }}
                        </span>
                        {{ session()->has('bahasa') ? GoogleTranslate::trans("menggunakan Platform",
                        session()->get('bahasa')) : GoogleTranslate::trans("menggunakan Platform", 'id') }}
                        TrucKu <b>Borneo</b>,
                        {{ session()->has('bahasa') ? GoogleTranslate::trans("solusi penyewaan truk dengan harga
                        terjangkau.", session()->get('bahasa')) : GoogleTranslate::trans("solusi penyewaan truk dengan
                        harga terjangkau.", 'id') }}
                    </h2>
                    <a class="btn-solid-lg" href="javascript:void(0)"
                        onclick="swal('Coming Soon', 'Fitur ini akan segera hadir', 'info')"><i
                            class="fab fa-apple"></i>Apple</a>
                    <a class="btn-solid-lg" href="{{ route('download')}}"><i class="fab fa-google-play"></i>Android</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="image-container">
                    <img class="img-fluid" src="images/header-smartphone.png" alt="alternative">
                </div>
            </div>
        </div>
    </div>

    <div class="language-selector">
        <select class="form-select changeLanguage" id="language-select">
            <option value="id" {{ session()->get('bahasa') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
            <option value="en" {{ session()->get('bahasa') == 'en' ? 'selected' : '' }}>English</option>
        </select>
    </div>
</header>

<div id="process" class="cards-1">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <h2 class="h2-heading mb-2">
                    {{ session()->has('bahasa') ? GoogleTranslate::trans("Kenapa harus sewa truk di TrucKu
                    Borneo?",
                    session()->get('bahasa')) : GoogleTranslate::trans("Kenapa harus sewa truk di TrucKu Borneo?", 'id')
                    }}
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="card-icon"><i class="fas fa-truck"></i></div>
                            <h3>
                                {{ session()->has('bahasa') ? GoogleTranslate::trans("Konfirmasi Harga Secara Instan",
                                session()->get('bahasa')) : GoogleTranslate::trans("Konfirmasi Harga Secara Instan",
                                'id')
                                }}
                            </h3>
                        </div>
                        <div class="card-text">
                            {{ session()->has('bahasa') ? GoogleTranslate::trans("Lupakan proses tawar menawar!
                            Dapatkan
                            kepastian harga hanya
                            berdasarkan jenis truk dan
                            jarak yang ditempuh.",
                            session()->get('bahasa')) : GoogleTranslate::trans("Lupakan proses tawar menawar! Dapatkan
                            kepastian harga hanya berdasarkan jenis truk dan jarak yang ditempuh.", 'id') }}
                        </div>
                    </div>
                </div> <!-- end of card -->
                <!-- end of card -->

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="card-icon"><i class="fas fa-receipt"></i></div>
                            <h3>
                                {{ session()->has('bahasa') ? GoogleTranslate::trans("Invoice",
                                session()->get('bahasa')) : GoogleTranslate::trans("Invoice", 'id') }}
                            </h3>
                        </div>
                        <div class="card-text">
                            {{ session()->has('bahasa') ? GoogleTranslate::trans("Dapatkan bukti pengiriman secara
                            digital. Anda tidak perlu repot
                            menyimpan kertas bukti
                            pengiriman.",
                            session()->get('bahasa')) : GoogleTranslate::trans("Dapatkan bukti pengiriman secara
                            digital. Anda tidak perlu repot menyimpan kertas bukti pengiriman.", 'id') }}
                        </div>
                    </div>
                </div> <!-- end of card -->
                <!-- end of card -->

                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="card-icon"><i class="fas fa-shield-alt"></i> </div>
                            <h3>
                                {{ session()->has('bahasa') ? GoogleTranslate::trans("Layanan Terjamin dan Terpercaya.",
                                session()->get('bahasa')) : GoogleTranslate::trans("Layanan Terjamin dan Terpercaya.",
                                'id')
                                }}
                            </h3>
                        </div>
                        <div class="card-text">
                            {{ session()->has('bahasa') ? GoogleTranslate::trans("Layanan kami terjamin dan terpercaya.
                            Anda tidak perlu khawatir
                            dengan keamanan muatan
                            yang dikirim.", session()->get('bahasa')) : GoogleTranslate::trans("Layanan kami terjamin
                            dan terpercaya. Anda tidak perlu khawatir dengan keamanan muatan yang dikirim.", 'id') }}
                        </div>
                    </div>
                </div> <!-- end of card -->
                <!-- end of card -->

            </div>
        </div>
    </div>
</div>

<!-- Questions -->
<div class="basic-5 bg-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="h2-heading">
                    {{ session()->has('bahasa') ? GoogleTranslate::trans("Pertanyaan yang sering ditanyakan",
                    session()->get('bahasa')) : GoogleTranslate::trans("Pertanyaan yang sering ditanyakan", 'id') }}
                </h2>
                <hr class="hr-heading">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="text-container first">
                    <h5>{{ session()->has('bahasa') ? GoogleTranslate::trans("1. Apa jenis truk tangki yang tersedia
                        untuk disewa di TrucKu
                        Borneo?", session()->get('bahasa')) : GoogleTranslate::trans("1. Apa jenis truk tangki yang
                        tersedia untuk disewa di TrucKu Borneo?", 'id') }}</h5>
                    <p>{{ session()->has('bahasa') ? GoogleTranslate::trans("TrucKu Borneo menyediakan berbagai jenis
                        truk tangki untuk disewa.
                        Anda dapat memilih jenis truk tangki yang sesuai dengan kebutuhan muatan Anda.",
                        session()->get('bahasa')) : GoogleTranslate::trans("TrucKu Borneo menyediakan berbagai jenis
                        truk tangki untuk disewa. Anda dapat memilih jenis truk tangki yang sesuai dengan kebutuhan
                        muatan Anda.", 'id') }}</p>
                    <h5>{{ session()->has('bahasa') ? GoogleTranslate::trans("2. Bagaimana cara memesan truk tangki
                        di",
                        session()->get('bahasa')) : GoogleTranslate::trans("2. Bagaimana cara memesan truk tangki
                        di", 'id')
                        }} TrucKu Borneo?</h5>
                    <p>{{ session()->has('bahasa') ? GoogleTranslate::trans("Anda dapat memesan truk tangki di TrucKu
                        Borneo dengan mudah. Anda
                        hanya perlu mengisi form pemesanan truk tangki yang tersedia di Aplikasi",
                        session()->get('bahasa')) : GoogleTranslate::trans("Anda dapat memesan truk tangki di TrucKu
                        Borneo dengan mudah. Anda hanya perlu mengisi form pemesanan truk tangki yang tersedia di
                        Aplikasi", 'id') }} TrucKu Borneo.</p>
                    <h5>{{ session()->has('bahasa') ? GoogleTranslate::trans("3. Bagaimana cara menghitung biaya sewa
                        truk tangki di",
                        session()->get('bahasa')) : GoogleTranslate::trans("3. Bagaimana cara menghitung biaya sewa truk
                        tangki di", 'id')
                        }} TrucKu Borneo?</h5>
                    <p>{{ session()->has('bahasa') ? GoogleTranslate::trans("Biaya sewa truk tangki di",
                        session()->get('bahasa')) : GoogleTranslate::trans("Biaya sewa truk tangki di",
                        'id') }} TrucKu Borneo {{ session()->has('bahasa') ? GoogleTranslate::trans("dihitung
                        berdasarkan jarak tempuh dan jenis truk tangki yang Anda
                        pilih.", session()->get('bahasa')) : GoogleTranslate::trans("dihitung berdasarkan jarak tempuh
                        dan jenis truk tangki yang Anda
                        pilih.", 'id') }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-container second">
                    <h5>{{ session()->has('bahasa') ? GoogleTranslate::trans("4. Apa saja metode pembayaran yang
                        tersedia di TrucKu Borneo?", session()->get('bahasa')) : GoogleTranslate::trans("4. Apa saja
                        metode pembayaran yang tersedia di TrucKu Borneo?", 'id') }}</h5>
                    <p>{{ session()->has('bahasa') ? GoogleTranslate::trans("Anda dapat melakukan pembayaran melalui
                        transfer bank yang tersedia di Aplikasi TrucKu Borneo.", session()->get('bahasa')) :
                        GoogleTranslate::trans("Anda dapat melakukan pembayaran melalui transfer bank yang tersedia di
                        Aplikasi TrucKu Borneo?", 'id') }}</p>
                    <h5>{{ session()->has('bahasa') ? GoogleTranslate::trans("5. Apakah ada biaya tambahan yang harus
                        dibayar di luar biaya sewa truk tangki?", session()->get('bahasa')) : GoogleTranslate::trans("5.
                        Apakah ada biaya tambahan yang harus dibayar di luar biaya sewa truk tangki?", 'id') }}</h5>
                    <p>{{ session()->has('bahasa') ? GoogleTranslate::trans("Biaya sewa truk tangki di TrucKu Borneo
                        sudah termasuk biaya operasional", session()->get('bahasa')) : GoogleTranslate::trans("Biaya
                        sewa truk tangki di TrucKu Borneo sudah termasuk biaya operasional", 'id') }}</p>
                    <h5>{{ session()->has('bahasa') ? GoogleTranslate::trans("6. Bagaimana saya dapat memantau status
                        pengiriman CPO yang sedang dikirim melalui TrucKu Borneo?", session()->get('bahasa')) :
                        GoogleTranslate::trans("6. Bagaimana saya dapat memantau status pengiriman CPO yang sedang
                        dikirim melalui TrucKu Borneo?", 'id') }}</h5>
                    <p>{{ session()->has('bahasa') ? GoogleTranslate::trans("Anda dapat memantau status pengiriman CPO
                        melalui Aplikasi TrucKu Borneo.", session()->get('bahasa')) : GoogleTranslate::trans("Anda dapat
                        memantau status pengiriman CPO melalui Aplikasi TrucKu Borneo?", 'id') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="basic-6">
    <div class="basic-6-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="image-container">
                        <img class="img-fluid" src="images/download-smartphone.png" alt="alternative">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="download" class="basic-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>{{ session()->has('bahasa') ? GoogleTranslate::trans("Download dan Install TrucKu Borneo",
                    session()->get('bahasa')) : GoogleTranslate::trans("Download dan Install TrucKu Borneo", 'id') }}
                </h3>
                <a class="btn-solid-lg" href="{{ route('download')}}"><i class="fab fa-google-play"></i>Android</a>
                <a class="btn-solid-lg" href="javascript:void(0)"
                    onclick="swal('Coming Soon', 'Fitur ini akan segera hadir', 'info')"><i
                        class="fab fa-apple"></i>Apple</a>
            </div>
        </div>
    </div>
</div>

<div class="footer bg-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-col first">
                    <h6>{{ session()->has('bahasa') ? GoogleTranslate::trans("Tentang TrucKu Borneo",
                        session()->get('bahasa')) : GoogleTranslate::trans("Tentang TrucKu Borneo", 'id') }}</h6>
                    <p class="p-small">{{ session()->has('bahasa') ? GoogleTranslate::trans("TrucKu Borneo adalah
                        aplikasi yang berfungsi untuk
                        memudahkan pengguna dalam
                        mencari truk yang akan digunakan untuk mengangkut muatan jenis minyak CPO.",
                        session()->get('bahasa')) : GoogleTranslate::trans("TrucKu Borneo adalah aplikasi yang berfungsi
                        untuk memudahkan pengguna dalam mencari truk yang akan digunakan untuk mengangkut muatan jenis
                        minyak CPO.", 'id') }}</p>
                </div>
                <div class="footer-col second">
                </div>
                <div class="footer-col third">
                    <span class="fa-stack">
                        <a href="javascript:void(0)">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-facebook-f fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="javascript:void(0)">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-twitter fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="javascript:void(0)">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-instagram fa-stack-1x"></i>
                        </a>
                    </span>
                    <p class="p-small">{{ session()->has('bahasa') ? GoogleTranslate::trans("Follow us on social media",
                        session()->get('bahasa')) : GoogleTranslate::trans("Follow us on social media", 'id') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="copyright bg-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="p-small">Copyright &copy; 2023. All Rights Reserved. <a
                        href="https://www.facebook.com/TrucKuBorneo" target="_blank">TrucKu Borneo</a></p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        var url = "{{ route('GantiBahasa') }}";
        $('.changeLanguage').change(function() {
            var bahasa = $(this).val();
            window.location.href = url + "?bahasa=" + bahasa;
        });
    });
</script>
@endpush