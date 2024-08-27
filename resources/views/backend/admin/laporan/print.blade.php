<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon/favicon.png') }}">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media print {
            body {
                font-size: 12pt;
            }

            h1 {
                font-size: 16pt;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: center;
            }

            th {
                background-color: #f2f2f2;
            }

            tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            /* Set orientasi halaman menjadi landscape */
            @page {
                size: landscape;
            }
        }
    </style>
</head>

<body>
    <h1>Laporan Transaksi TrucKu Borneo</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Perusahaan</th>
                <th>Jenis Truk</th>
                <th>Status Penyewaan</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>{{ $item->jenis_truk }}</td>
                <td>
                    @if($item->status_penyewaan == 0)
                    Menunggu Konfirmasi
                    @elseif($item->status_penyewaan == 1)
                    Proses Sewa
                    @elseif($item->status_penyewaan == 2)
                    Selesai
                    @elseif($item->status_penyewaan == 3)
                    Dibatalkan
                    @endif
                </td>
                <td>Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>