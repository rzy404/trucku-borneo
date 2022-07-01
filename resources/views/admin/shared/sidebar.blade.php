<div class="deznav-scroll">
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-networking"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="has-arrow ai-icon" href="{{ route('profile.detail') }}" aria-expanded="false">
                <i class="flaticon-381-user-9"></i>
                <span class="nav-text">Management User</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('user.operator.index') }}">Operator</a></li>
                <li><a href="{{ route('profile.detail') }}">Sopir</a></li>
                <li><a href="{{ route('user.cost.index') }}">Costumer</a></li>
            </ul>
        </li>
        {{-- <li>
            <a href="{{ route('profile.detail') }}" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-equal-1"></i>
                <span class="nav-text">Data Truck</span>
            </a>
        </li>
        <li>
            <a href="javascript:void()" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-equal-1"></i>
                <span class="nav-text">Sewa</span>
            </a>
        </li> --}}
    </ul>
</div>