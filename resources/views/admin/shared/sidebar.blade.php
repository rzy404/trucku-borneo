<div class="deznav-scroll">
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-networking"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-user-9"></i>
                <span class="nav-text">Management User</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('user.operator.index') }}">Operator</a></li>
                <li><a href="{{ route('user.driver.index') }}">Driver</a></li>
                <li><a href="{{ route('user.cost.index') }}">Costumer</a></li>
            </ul>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-layer-1"></i>
                <span class="nav-text">Master Data</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('truk.index')}}">Truck</a></li>
                <li><a href="javascript:void()">Metode Pembayaran</a></li>
                <li><a href="javascript:void()">Transaksi</a></li>
            </ul>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-notepad"></i>
                <span class="nav-text">Master Laporan</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="javascript:void()">Transaksi</a></li>
            </ul>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-settings-2"></i>
                <span class="nav-text">Proses Metode Electre</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="javascript:void()">Kriteria</a></li>
                <li><a href="javascript:void()">Alternatif</a></li>
                <li><a href="javascript:void()">Hasil Metode</a></li>
            </ul>
        </li>
    </ul>
</div>