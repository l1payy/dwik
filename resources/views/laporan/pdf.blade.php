<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h2 {
            margin: 0;
            font-size: 14px;
            text-decoration: underline;
        }
        .meta {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH KOTA BINJAI</h1>
        <h1>BADAN PENANGGULANGAN BENCANA DAERAH</h1>
        <p>Jl. Jenderal Sudirman No. 1, Kota Binjai, Sumatera Utara</p>
        <p>Telepon: (061) 123456 | Email: bpbd@binjaikota.go.id</p>
    </div>

    <div class="title">
        <h2>{{ $title }}</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="{{ $type == 'semua' ? '15%' : '20%' }}">No. Surat</th>
                <th width="{{ $type == 'semua' ? '12%' : '15%' }}">Tanggal</th>
                @if($type == 'semua')
                <th width="13%">Tipe</th>
                @endif
                <th width="{{ $type == 'semua' ? '25%' : '30%' }}">
                    {{ $type == 'surat_masuk' ? 'Asal Surat' : ($type == 'surat_keluar' ? 'Penerima' : 'Pengirim/Penerima') }}
                </th>
                <th width="{{ $type == 'semua' ? '30%' : '30%' }}">Perihal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if($type == 'semua')
                        <td>{{ $item->no_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $item->tipe }}</td>
                        <td>{{ $item->pihak }}</td>
                        <td>{{ $item->perihal }}</td>
                    @else
                        <td>{{ $item->no_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($type == 'surat_masuk' ? $item->tanggal_masuk : $item->tanggal_surat)->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $type == 'surat_masuk' ? $item->pengirim : $item->penerima }}</td>
                        <td>{{ $item->perihal }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Binjai, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p>Kepala BPBD Kota Binjai</p>
        <div class="signature">
            <p><strong>__________________________</strong></p>
            <p>NIP. ...........................</p>
        </div>
    </div>
</body>
</html>
