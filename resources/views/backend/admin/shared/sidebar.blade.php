<div class="deznav-scroll">
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-networking"></i>
                <span class="nav-text">{{ session()->has('bahasa') ? GoogleTranslate::trans("Dashboard",
                    session()->get('bahasa')) : GoogleTranslate::trans("Dashboard", "id") }}</span>
            </a>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-user-9"></i>
                <span class="nav-text">{{ session()->has('bahasa') ? GoogleTranslate::trans("Pengguna",
                    session()->get('bahasa')) : GoogleTranslate::trans("Pengguna", "id") }}</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('user.operator.index') }}">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Operator", session()->get('bahasa')) :
                        GoogleTranslate::trans("Operator", "id") }}</a></li>
                <li><a href="{{ route('user.driver.index') }}">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Sopir", session()->get('bahasa')) : GoogleTranslate::trans("Sopir",
                        "id") }}</a></li>
                <li><a href="{{ route('user.cost.index') }}">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Pelanggan", session()->get('bahasa')) :
                        GoogleTranslate::trans("Pelanggan", "id") }}</a></li>
            </ul>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-layer-1"></i>
                <span class="nav-text">{{ session()->has('bahasa') ? GoogleTranslate::trans("Master Data",
                    session()->get('bahasa')) : GoogleTranslate::trans("Master Data", "id") }}</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('truk.index') }}">{{ session()->has('bahasa') ? GoogleTranslate::trans("Truk",
                        session()->get('bahasa')) : GoogleTranslate::trans("Truk", "id") }}</a></li>
                <li><a href="{{ route('metodepb.index') }}">{{ session()->has('bahasa') ? GoogleTranslate::trans("Metode
                        Pembayaran", session()->get('bahasa')) : GoogleTranslate::trans("Metode Pembayaran", "id")
                        }}</a></li>
                <li><a href="{{ route('transaksi.index') }}">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Transaksi", session()->get('bahasa')) :
                        GoogleTranslate::trans("Transaksi", "id") }}</a></li>
            </ul>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-settings-2"></i>
                <span class="nav-text">{{ session()->has('bahasa') ? GoogleTranslate::trans("Proses Metode",
                    session()->get('bahasa')) : GoogleTranslate::trans("Proses Metode", "id") }} Electre</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('kriteria.index') }}">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Kriteria", session()->get('bahasa')) :
                        GoogleTranslate::trans("Kriteria", "id") }}</a></li>
                <li><a href="{{ route('alternatif.index') }}">{{ session()->has('bahasa') ?
                        GoogleTranslate::trans("Alternatif", session()->get('bahasa')) :
                        GoogleTranslate::trans("Alternatif", "id") }}</a></li>
                <li><a href="{{ route('electre.index') }}">{{ session()->has('bahasa') ? GoogleTranslate::trans("Hasil
                        Metode", session()->get('bahasa')) : GoogleTranslate::trans("Hasil Metode", "id") }}</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('laporan.index') }}" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-notepad"></i>
                <span class="nav-text">{{ session()->has('bahasa') ? GoogleTranslate::trans("Laporan",
                    session()->get('bahasa')) : GoogleTranslate::trans("Laporan", "id") }}</span>
            </a>
        </li>

    </ul>
</div>