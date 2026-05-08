<!DOCTYPE html>
<html>
<head>
    <title>Lembar Disposisi - {{ $suratMasuk->no_surat }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border: 1px solid #ccc; }
        .label { font-weight: bold; width: 30%; background-color: #f9f9f9; }
        .disposisi-section { margin-top: 30px; }
        .disposisi-table { width: 100%; border-collapse: collapse; }
        .disposisi-table th, .disposisi-table td { border: 1px solid #000; padding: 10px; text-align: left; }
        .disposisi-table th { background-color: #eee; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BADAN PENANGGULANGAN BENCANA DAERAH</div>
        <div style="font-size: 14px;">KOTA BINJAI</div>
        <div style="font-size: 16px; font-weight: bold; margin-top: 10px;">LEMBAR DISPOSISI</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nomor Surat</td>
            <td>{{ $suratMasuk->no_surat }}</td>
        </tr>
        <tr>
            <td class="label">Asal Surat</td>
            <td>{{ $suratMasuk->pengirim }} - {{ $suratMasuk->instansi_pengirim }}</td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td>{{ $suratMasuk->perihal }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Surat</td>
            <td>{{ $suratMasuk->tanggal_surat->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Diterima Tanggal</td>
            <td>{{ $suratMasuk->tanggal_masuk->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Batas Waktu</td>
            <td>{{ $suratMasuk->deadline ? $suratMasuk->deadline->format('d/m/Y') : '-' }}</td>
        </tr>
    </table>

    <div class="disposisi-section">
        <h3>RIWAYAT DISPOSISI</h3>
        <table class="disposisi-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Diteruskan Ke</th>
                    <th width="25%">Instruksi</th>
                    <th width="45%">Catatan/Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratMasuk->disposisi as $index => $d)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $d->penerima->name }}</td>
                        <td>{{ $d->instruksi }}</td>
                        <td>{{ $d->catatan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada disposisi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 50px; text-align: right;">
        <p>Binjai, {{ date('d F Y') }}</p>
        <p style="margin-top: 60px; font-weight: bold;">( ........................................... )</p>
    </div>
</body>
</html>
