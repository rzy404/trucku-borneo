@extends('layouts.app')
@section('title', 'Electre - Hitung | TrucKu Borneo')
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Metode Electre</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Metode Electre</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('electre.index') }}">Hasil Metode</a></li>
        </ol>
    </div>
    <div class="col-lg-12 row">
        <div class="col-lg-6">
            <div id="accordion-one" class="accordion accordion-primary">
                <div class="card">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapseOne" aria-expanded="false">
                            <span class="accordion__header--text">Step 1: Matriks Keputusan (X)</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="default_collapseOne" class="collapse accordion__body" data-parent="#accordion-one">
                            <div class="accordion__body--text">
                                <div class="table-responsive">
                                    <table class="table table-striped primary-table-bordered" id="matriksX">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Alternatif</th>
                                                <th colspan="{{$kolom}}"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Kriteria </th>
                                            </tr>
                                            <tr>
                                                @foreach ($kriteria as $k)
                                                <th style="text-align: center; vertical-align: middle;">
                                                    {{$k->kriteria}}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alternatif as $a)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{$a->transaksi}}</td>
                                                @foreach ($kriteria as $k)
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{$matriks_x[$k->id][$a->transaksi]}}
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="accordion-two" class="accordion accordion-primary">
                <div class="card">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapseTwo" aria-expanded="false">
                            <span class="accordion__header--text">Step 2: Menentukan Bobot Kriteria (W)</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="default_collapseTwo" class="collapse accordion__body" data-parent="#accordion-two">
                            <div class="accordion__body--text">
                                <div class="table-responsive">
                                    <table class="table table-striped primary-table-bordered" id="matriksW">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th style="text-align: center; vertical-align: middle;">
                                                    Kriteria</th>
                                                <th style="text-align: center; vertical-align: middle;">
                                                    Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kriteria as $k)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;">{{$k->kriteria}}
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{$k->weight}}
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
            </div>
        </div>
    </div>
    <div class="col-lg-12 row">
        <div class="col-lg-6">
            <div id="accordion-3" class="accordion accordion-primary">
                <div class="card">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapse3" aria-expanded="false">
                            <span class="accordion__header--text">Step 3: Matriks Ternormalisasi (R)</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="default_collapse3" class="collapse accordion__body" data-parent="#accordion-3">
                            <div class="accordion__body--text">
                                <div class="table-responsive">
                                    <table class="table table-striped primary-table-bordered" id="matriksR">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Alternatif</th>
                                                <th colspan="{{$kolom}}"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Kriteria</th>
                                            </tr>
                                            <tr>
                                                @foreach ($kriteria as $k)
                                                <th style="text-align: center; vertical-align: middle;">
                                                    {{$k->kriteria}}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alternatif as $a)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{$a->transaksi}}</td>
                                                @foreach ($kriteria as $k)
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{round($matriks_r[$k->id][$a->transaksi], 5)}}
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="accordion-4" class="accordion accordion-primary">
                <div class="card">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapse4" aria-expanded="false">
                            <span class="accordion__header--text">Step 4: Matriks Normalisasi Terbobot (V)</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="default_collapse4" class="collapse accordion__body" data-parent="#accordion-4">
                            <div class="accordion__body--text">
                                <div class="table-responsive">
                                    <table class="table table-striped primary-table-bordered" id="matriksV">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Alternatif</th>
                                                <th colspan="{{$kolom}}"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Kriteria</th>
                                            </tr>
                                            <tr>
                                                @foreach ($kriteria as $k)
                                                <th style="text-align: center; vertical-align: middle;">
                                                    {{$k->kriteria}}
                                                </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alternatif as $a)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{$a->transaksi}}</td>
                                                @foreach ($kriteria as $k)
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{round($matriks_y[$k->id][$a->transaksi], 5)}}
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div id="accordion-5" class="accordion accordion-primary">
                <div class="accordion__item">
                    <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                        data-target="#default_collapse5" aria-expanded="false">
                        <span class="accordion__header--text">Step 5: Matriks Concordance & Discordance</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="default_collapse5" class="collapse accordion__body" data-parent="#accordion-5">
                                <div class="accordion__body--text">

                                    <div class="table-responsive" id="himpunanC">
                                        <table class="table table-striped primary-table-bordered">
                                            <thead>
                                                {{-- @for ($i = 0; $i < $baris; $i++) <tr>
                                                    @for ($j=0; $j < $kolom; $j++) <td>
                                                        {{$solusi_ideal[$i][$j]}}
                                                        </td>
                                                        @endfor </tr>
                                                        @endfor --}}
                                                        <tr>
                                                            <h6>
                                                                Concordance :
                                                            </h6>
                                                        </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $baris; $i++) <tr>
                                                    @for ($j=0; $j < $baris; $j++) <td
                                                        style="text-align: center; vertical-align: middle;">
                                                        @if ($i == $j)
                                                        -------
                                                        @else
                                                        {{$matriks_con[$i][$j]}}
                                                        @endif
                                                        </td>
                                                        @endfor
                                                        </tr>
                                                        @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="default_collapse5" class="collapse accordion__body" data-parent="#accordion-5">
                                <div class="accordion__body--text">
                                    <div class="table-responsive" id="himpunanD">
                                        <table class="table table-striped primary-table-bordered">
                                            <thead>
                                                {{-- @for ($i = 0; $i < $baris; $i++) <tr>
                                                    @for ($j=0; $j < $kolom; $j++) <td>
                                                        {{$solusi_ideal[$i][$j]}}
                                                        </td>
                                                        @endfor </tr>
                                                        @endfor --}}
                                                        <tr>
                                                            <h6>
                                                                Discordance :
                                                            </h6>
                                                        </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $baris; $i++) <tr>
                                                    @for ($j=0; $j < $baris; $j++) <td
                                                        style="text-align: center; vertical-align: middle;">
                                                        @if ($i == $j)
                                                        -------
                                                        @else
                                                        {{round($matriks_dis[$i][$j], 5)}}
                                                        @endif
                                                        </td>
                                                        @endfor
                                                        </tr>
                                                        @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div id="accordion-6" class="accordion accordion-primary">
                <div class="accordion__item">
                    <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                        data-target="#default_collapse6" aria-expanded="false">
                        <span class="accordion__header--text">Step 6: Menghitung Matriks Dominan Concordance &
                            Discordance</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="default_collapse6" class="collapse accordion__body" data-parent="#accordion-6">
                                <div class="accordion__body--text">
                                    <div class="table-responsive">
                                        <table class="table table-striped primary-table-bordered">
                                            <thead class="mb-2">
                                                <tr>
                                                    <h6>
                                                        Nilai Threshold Concordance : {{round($threshold_con, 2)}}
                                                    </h6>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $baris; $i++) <tr>
                                                    @for ($j=0; $j < $baris; $j++) <td
                                                        style="text-align: center; vertical-align: middle;">
                                                        @if ($i == $j)
                                                        -------
                                                        @else
                                                        {{$dominan_con[$i][$j]}}
                                                        @endif
                                                        </td>
                                                        @endfor
                                                        </tr>
                                                        @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="default_collapse6" class="collapse accordion__body" data-parent="#accordion-6">
                                <div class="accordion__body--text">
                                    <div class="table-responsive">
                                        <table class="table table-striped primary-table-bordered">
                                            <thead class="thead-primary">
                                                <tr>
                                                    <h6>
                                                        Nilai Threshold Discordance : {{round($threshold_dis, 2)}}
                                                    </h6>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $baris; $i++) <tr>
                                                    @for ($j=0; $j < $baris; $j++) <td
                                                        style="text-align: center; vertical-align: middle;">
                                                        @if ($i == $j)
                                                        -------
                                                        @else
                                                        {{$dominan_dis[$i][$j]}}
                                                        @endif
                                                        </td>
                                                        @endfor
                                                        </tr>
                                                        @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 row">
        <div class="col-lg-6">
            <div id="accordion-7" class="accordion accordion-primary">
                <div class="card">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapse7" aria-expanded="false">
                            <span class="accordion__header--text">Step 7: Menentukan Agregate Dominan (Matriks
                                E)</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="default_collapse7" class="collapse accordion__body" data-parent="#accordion-7">
                            <div class="accordion__body--text">
                                <div class="table-responsive">
                                    <table class="table table-striped primary-table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach ($alternatif as $alt)
                                                <th
                                                    style="text-align: center; background-color: #007A64; color: white;">
                                                    {{$alt->transaksi}}</th>
                                                @endforeach
                                                <th>Total Ekl</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < $baris; $i++) <tr>
                                                <td
                                                    style="text-align: center; background-color: #007A64; color: white;">
                                                    {{$alternatif[$i]->transaksi}}</td>
                                                @for ($j=0; $j < $baris; $j++) <td
                                                    style="text-align: center; vertical-align: middle;">
                                                    @if ($i == $j)
                                                    -------
                                                    @else
                                                    {{$agregate_matrix[$i][$j]}}
                                                    @endif
                                                    </td>
                                                    @endfor
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        {{$tmp = array_sum($agregate_matrix[$i])}}
                                                    </td>
                                                    </tr>
                                                    @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="accordion-8" class="accordion accordion-primary">
                <div class="card">
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapse8" aria-expanded="false">
                            <span class="accordion__header--text">Hasil Perhitungan (Ranking)</span>
                            <span class="accordion__header--indicator"></span>
                        </div>
                        <div id="default_collapse8" class="collapse accordion__body" data-parent="#accordion-8">
                            <div class="accordion__body--text">
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped verticle-middle table-responsive-lg">

                                            <thead>
                                                <tr>
                                                    <th scope="col">Ranking</th>
                                                    <th scope="col">ID Transaksi (Alternatif)</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Nilai Akhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ranking as $key => $item)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$item->transaksi}}</td>
                                                    <td>
                                                        <form
                                                            action="{{ route('electre.update_status', $item->transaksi) }}"
                                                            method="POST">
                                                            @csrf
                                                            <span class="data_status badge badge-secondary"
                                                                id="statusAlternatif">Menunggu
                                                                Konfirmasi</span>
                                                        </form>
                                                    </td>
                                                    <td>{{round($item->nilai_ekl, 2)}}%</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
@endsection
@section('script')
<script>
    $(document).on("click", "#statusAlternatif", function() {
        var form = $(this).closest("form");
        swal({
            title: 'Update Status',
            text: "Apakah anda yakin ingin mengubah data ini ?",
            icon: 'warning',
            buttons: ["Batal", "Ya, Ubah"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result => {
            if (result) {
                form.submit();
            }
        }))
    });
</script>
@endsection