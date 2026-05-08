<!DOCTYPE html>
<html>
<head>
    <title>Surat Keluar - {{ $suratKeluar->no_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header .title { font-size: 16pt; font-weight: bold; }
        .content { margin-top: 20px; }
        .meta-table { width: 100%; margin-bottom: 30px; }
        .meta-table td { vertical-align: top; }
        .date { text-align: right; margin-bottom: 20px; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BADAN PENANGGULANGAN BENCANA DAERAH</div>
        <div style="font-size: 14pt;">KOTA BINJAI</div>
        <div style="font-size: 10pt;">Jl. Jenderal Sudirman No. 123, Binjai</div>
    </div>

    <div class="date">
        Binjai, {{ $suratKeluar->tanggal_surat->format('d F Y') }}
    </div>

    <table class="meta-table">
        <tr>
            <td width="15%">Nomor</td>
            <td width="2%">:</td>
            <td>{{ $suratKeluar->no_surat }}</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>{{ ucfirst($suratKeluar->sifat) }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td><strong>{{ $suratKeluar->perihal }}</strong></td>
        </tr>
    </table>

    <div class="content">
        <p>Kepada Yth:</p>
        <p>{{ $suratKeluar->penerima }}</p>
        <p>di -</p>
        <p style="padding-left: 20px;">{{ $suratKeluar->instansi_penerima }}</p>

        <br>
        <p>Dengan hormat,</p>
        <p>Tuliskan isi surat di sini. Ini adalah draf surat keluar yang telah disetujui.</p>
        <p>Demikian disampaikan, atas perhatiannya diucapkan terima kasih.</p>
    </div>

    <div class="footer">
        <p>KEPALA BPBD KOTA BINJAI</p>
        <div class="signature">
            ( ........................................... )
        </div>
    </div>
</body>
</html>
