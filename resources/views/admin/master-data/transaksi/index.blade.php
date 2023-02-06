@extends('layouts.app')
@section('title', 'Master Data - Transaksi | TrucKu Borneo')
@section('css')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="page-titles">
        <h4>Transaksi</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Master Data</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('metodepb.index') }}">Transaksi</a></li>
        </ol>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Transaksi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-transaksi" class="display min-w850">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Transaksi</th>
                                <th>Perusahaan</th>
                                <th>Jenis Truk</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $transaksi)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $transaksi->id_transaksi }}</td>
                                <td>{{ $transaksi->nama_perusahaan }}</td>
                                <td>{{ $transaksi->jenis_truk }}</td>
                                <td>
                                    <form action="{{ route('transaksi.update_status', $transaksi->id_transaksi) }}"
                                        method="POST">
                                        @csrf
                                        <select class="select2-width-100 status_transaksi" name="status_transaksi">
                                            <option value="0" {{ $transaksi->status_penyewaan == 0 ? 'selected' : '' }}>
                                                Menunggu Konfirmasi</option>
                                            <option value="1" {{ $transaksi->status_penyewaan == 1 ? 'selected' : '' }}>
                                                Proses Sewa</option>
                                            <option value="2" {{ $transaksi->status_penyewaan == 2 ? 'selected' : '' }}>
                                                Selesai</option>
                                            <option value="3" {{ $transaksi->status_penyewaan == 3 ? 'selected' : '' }}>
                                                Batal</option>
                                        </select>
                                    </form>
                                </td>
                                <td id="bukti_bayar" data-id="{{ $transaksi->id_transaksi }}"
                                    data-bukti="{{ $transaksi->bukti_bayar }}">
                                    @if ($transaksi->bukti_bayar === null)
                                    <span class="badge badge-warning">Menunggu Pembayaran</span>
                                    @else
                                    <span class="badge badge-primary">Sudah Dibayar</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary shadow btn-xs sharp mr-1" id="detailTransaksi"
                                        data-id="{{ $transaksi->id_transaksi }}" data-toggle="modal"
                                        data-target="#modal_detailTransaksi"><i class="fa fa-eye"></i></a>
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
@include('admin.master-data.transaksi.modal')
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#data-transaksi').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        $(".select2-width-100").select2();
        $(".status_transaksi").on("change", function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            var form = $(this).closest("form");
            swal({
                title: 'Update Status',
                text: "Apakah anda yakin ingin update status transaksi ?",
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
    })

    $(document).ready(function() {
        $(document).on('click', '#bukti_bayar', function() {
            var id_transaksi = $(this).data('id');
            var status_pembayaran = $(this).data('bukti');

            if (status_pembayaran) {
                $('#modalBuktiBayar').modal('show');

                var modal = $('#modalBuktiBayar');
                modal.find('.modal-body').html('<p>Loading...</p>')

                $.ajax({
                    type: "GET",
                    url: "{{ url('/transaksi/bukti_bayar') }}/" + id_transaksi,
                    success: function(data) {
                        var image = '<img src="' + data['path'] + '" class="img-fluid" alt="Bukti Pembayaran">';
                        modal.find('.modal-body').html(image);
                    }
                })
            }
        })
    })

    $(document).on('click', "#detailTransaksi", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: "{{ url('transaksi/detail') }}" + '/' + id,
            data: {
                id: id
            },
            dataType: "json",
            cache: false,
            success: function(data) {
                $('.modal-title #titleDetail').html("#" + id);
                $('#detailTransaksi .nama_perusahaan').html("Perusahaan :");
                $('#detailTransaksi .data_Perusahaan').html(data.nama_perusahaan);
                $('#detailTransaksi .jenis_truk').html("Jenis Truk :");
                $('#detailTransaksi .data_jenisTruk').html(data.jenis_truk);
                $('#detailTransaksi .alamat_asal').html("Alamat Asal :");
                $('#detailTransaksi .data_alamatAsal').html(data.alamat_asal);
                $('#detailTransaksi .alamat_tujuan').html("Alamat Tujuan :");
                $('#detailTransaksi .data_alamatTujuan').html(data.alamat_tujuan);
                $('#detailTransaksi .jumlah_muatan').html("Jumlah Muatan :");
                $('#detailTransaksi .data_jumlah').html(data.jumlah_muatan + " Ton");
                $('#detailTransaksi .tgl_pengambilan').html("Tanggal Pengambilan :");
                $('#detailTransaksi .data_tgl1').html(formatDate(data.tgl_pengambilan));
                $('#detailTransaksi .tgl_pengembalian').html("Tanggal Pengembalian :");
                $('#detailTransaksi .data_tgl2').html(formatDate(data.tgl_pengembalian));
                $('#detailTransaksi .total_biaya').html("Total Biaya :");
                $('#detailTransaksi .data_biaya').html("Rp. " + currencyIdr(data.total_biaya));
                $('#detailTransaksi .status').html("Status Pemesanan :");
                switch (data.status_penyewaan) {
                    case 0:
                        $('#detailTransaksi .data_status').html("Menunggu Konfirmasi").addClass("badge badge-secondary");
                        break;
                    case 1:
                        $('#detailTransaksi .data_status').html("Proses Penyewaan").addClass("badge badge-info");
                        break;
                    case 2:
                        $('#detailTransaksi .data_status').html("Selesai").addClass("badge badge-primary");
                        break;
                    case 3:
                        $('#detailTransaksi .data_status').html("Dibatalkan").addClass("badge badge-danger");
                        break;
                    default:
                        break;
                }
            }
        });
    })

    function formatDate(tgl) {
        var date = new Date(tgl);
        var monthNames = [
            "Januari", "Februari", "Maret",
            "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober",
            "November", "Desember"
        ];
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();
        return day + ' ' + monthNames[monthIndex] + ' ' + year;
    }

    function currencyIdr(number) {
        var number_string = number.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }
</script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
@endsection