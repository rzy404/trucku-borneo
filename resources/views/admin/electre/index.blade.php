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
                                    <table class="table table-striped primary-table-bordered">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Alternatif</th>
                                                <th colspan="{{ $kolom }}"
                                                    style="text-align: center; vertical-align: middle;">Kriteria </th>
                                            </tr>
                                            <tr>
                                                @foreach ($dataKriteria as $kriteria)
                                                <th align="center">{{ $kriteria->id }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alternatif as $alt)
                                            <tr>
                                                <td align="center">{{$alt->perusahaan}}</td>
                                                @foreach ($dataKriteria as $kriteria)
                                                @php
                                                $normalization =
                                                App\Http\Controllers\Admin\AlgoritmaElectre::normalization($kriteria->id,$alt->perusahaan);
                                                @endphp
                                                <td align="center">{{
                                                    $normalization[$kriteria->id][$alt->perusahaan][0]->nilai }}</td>
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
                                    <table class="table table-striped primary-table-bordered">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Kriteria</th>
                                                <th colspan="5" style="text-align: center; vertical-align: middle;">
                                                    Bobot</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataKriteria as $kriteria)
                                            <tr>
                                                <td align="center">{{ $kriteria->id }}</td>
                                                <td align="center">{{ $kriteria->weight }}</td>
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
                                    <table class="table table-striped primary-table-bordered">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Alternatif</th>
                                                <th colspan="{{ $kolom }}"
                                                    style="text-align: center; vertical-align: middle;">Kriteria</th>
                                            </tr>
                                            <tr>
                                                @foreach ($dataKriteria as $kriteria)
                                                <th>{{ $kriteria->id }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alternatif as $alt)
                                            <tr>
                                                <td align="center">{{$alt->perusahaan}}</td>
                                                @foreach ($dataKriteria as $kriteria)
                                                @php
                                                $matR =
                                                App\Http\Controllers\Admin\AlgoritmaElectre::normalization_R($kriteria->id,$alt->perusahaan);
                                                @endphp
                                                <td align="center">{{ round($matR[$kriteria->id][$alt->perusahaan],
                                                    $digit) }}</td>
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
                                    <table class="table table-striped primary-table-bordered">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                    Alternatif</th>
                                                <th colspan="5" style="text-align: center; vertical-align: middle;">
                                                    Kriteria</th>
                                            </tr>
                                            <tr>
                                                @foreach ($dataKriteria as $kriteria)
                                                <th>{{ $kriteria->id }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alternatif as $alt)
                                            <tr>
                                                <td align="center">{{$alt->perusahaan}}</td>
                                                @foreach ($dataKriteria as $kriteria)
                                                @php
                                                $bobot =
                                                App\Http\Controllers\Admin\AlgoritmaElectre::pembobotan($kriteria->id,$alt->perusahaan);
                                                @endphp
                                                <td align="center">{{ round($bobot[$kriteria->id][$alt->perusahaan],
                                                    $digit) }}</td>
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
                                    <div class="table-responsive">
                                        <table class="table table-striped primary-table-bordered">
                                            <tbody>
                                                @for($i = 0; $i < $baris; $i++) <tr>
                                                    @for($j = 0; $j < $baris; $j++) @php
                                                        $concor=App\Http\Controllers\Admin\AlgoritmaElectre::tabelConcordance($i,$j);
                                                        @endphp <td align="center">
                                                        @if($i == $j)
                                                        -------
                                                        @else
                                                        {{ round($concor[$i][$j], $digit) }}
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
                                    <div class="table-responsive">
                                        <table class="table table-striped primary-table-bordered">
                                            <tbody>
                                                @for($i = 0; $i < $baris; $i++) <tr>
                                                    @for($j = 0; $j < $baris; $j++) @php
                                                        $discor=App\Http\Controllers\Admin\AlgoritmaElectre::tabelDiscordance($i,$j);
                                                        @endphp <td align="center">
                                                        @if($i == $j)
                                                        -------
                                                        @else
                                                        {{ round($discor[$i][$j], $digit) }}
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
                                                        @php
                                                        $tc =
                                                        App\Http\Controllers\Admin\AlgoritmaElectre::thresoldConcordance();
                                                        @endphp
                                                        Nilai Threshold Concordance : {{ round($tc, $digit) }}
                                                    </h6>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $DomCon =
                                                App\Http\Controllers\Admin\AlgoritmaElectre::matriksDominanConcordance();
                                                @endphp
                                                @for($i = 0; $i < $baris; $i++) <tr>
                                                    @for($j = 0; $j < $baris; $j++) <td align="center">
                                                        @if($i == $j)
                                                        -------
                                                        @else
                                                        {{ $DomCon[$i][$j] }}
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
                                                        @php
                                                        $td =
                                                        App\Http\Controllers\Admin\AlgoritmaElectre::thresoldDiscordance();
                                                        @endphp
                                                        Nilai Threshold Discordance : {{ round($td, $digit) }}
                                                    </h6>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $DomDis =
                                                App\Http\Controllers\Admin\AlgoritmaElectre::matriksDominanDiscordance();
                                                @endphp
                                                @for($i = 0; $i < $baris; $i++) <tr>
                                                    @for($j = 0; $j < $baris; $j++) <td align="center">
                                                        @if($i == $j)
                                                        -------
                                                        @else
                                                        {{ $DomDis[$i][$j] }}
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
                                                @for($i = 0; $i < $baris; $i++) <th
                                                    style="text-align: center; background-color: #007A64; color: white;">
                                                    {{ $list_alternatif[$i] }}
                                                    </th>
                                                    @endfor
                                                    <th>Total Ekl</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($i = 0; $i < $baris; $i++) <tr>
                                                <td
                                                    style="text-align: center; background-color: #007A64; color: white;">
                                                    {{ $list_alternatif[$i] }}
                                                </td>
                                                @php
                                                $agre =
                                                App\Http\Controllers\Admin\AlgoritmaElectre::agregateDominanMatriks();
                                                $total = 0;
                                                @endphp
                                                @for($j = 0; $j < $baris; $j++) <td align="center">
                                                    @if($i == $j)
                                                    -------
                                                    @else
                                                    {{ $agre[$i][$j] }}
                                                    @endif
                                                    @php
                                                    $total += $agre[$i][$j];
                                                    $totalEkl = array('$total' => $total, );
                                                    @endphp
                                                    </td>
                                                    @endfor
                                                    <td
                                                        style="text-align: center; background-color: #007A64; color: white;">
                                                        {{$total}}
                                                    </td>
                                                    @endfor
                                                    </tr>
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
                                            @php
                                            $rank = App\Http\Controllers\Admin\AlgoritmaElectre::rankingAlternatif();
                                            @endphp
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Perusahaan (Alternatif)</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Nilai Akhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < $baris; $i++) <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>{{$list_alternatif[$i]}}</td>
                                                    <td>
                                                        <form method="POST">
                                                            @csrf<span class="badge badge-primary" id="statusAlternatif"
                                                                name="statusAlternatif">Proses</span>
                                                        </form>
                                                    </td>
                                                    <td>{{round($rank[$i], $digitPersen)}}%</td>
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