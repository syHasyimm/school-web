<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pendaftaran - {{ $student->full_name }}</title>
    <style>
        @page { margin: 40px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; line-height: 1.5; color: #222; margin: 0; padding: 0;}
        .header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px;}
        .header p { margin: 5px 0 0; font-size: 14px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px; text-decoration: underline; letter-spacing: 1px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        td { padding: 6px 10px; vertical-align: middle; border: 1px solid #444; }
        .label { width: 35%; font-weight: bold; background-color: #f2f2f2; }
        .value { width: 65%; }
        .qrcode-container { text-align: center; margin-top: 10px; }
        .qrcode { width: 110px; height: 110px; padding: 5px; background: #fff;}
        .footer { text-align: center; margin-top: 50px; font-size: 11px; color: #666; font-style: italic;}
        .flex-container { width: 100%; display: table; margin-bottom: 10px; }
        .flex-item { display: table-cell; vertical-align: top; }
        .photo-box { width: 120px; text-align: right; padding-right: 10px;}
        .text-info { width: 100%; }
    </style>
</head>
<body>

    <div class="header">
        <h1>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</h1>
        <h2>{{ $schoolName }}</h2>
        <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <div class="title">
        BUKTI PENDAFTARAN ONLINE
    </div>

    <table style="border: none; width: 100%; margin-bottom: 0;">
        <tr style="border: none;">
            <td style="border: none; padding: 0;" class="text-info">
                <h3>A. BIODATA SISWA</h3>
            </td>
            <td style="border: none; padding: 0;" class="photo-box">
                @php
                    $photoDoc = collect($student->documents)->firstWhere('type', 'foto');
                    $photoPath = $photoDoc ? storage_path('app/public/' . $photoDoc->file_path) : '';
                @endphp
                @if($photoDoc && file_exists($photoPath))
                    <img src="{{ $photoPath }}" alt="Foto Siswa" style="width: 100px; height: 130px; border: 1px solid #000; object-fit: cover;">
                @else
                    <div style="width: 100px; height: 130px; border: 1px solid #000; text-align: center; line-height: 130px; font-size: 12px; color: #999;">Pas Foto 3x4</div>
                @endif
            </td>
        </tr>
    </table>

    <table style="margin-top: 10px;">
        <tr><td class="label">Nomor Pendaftaran</td><td class="value" style="font-size: 16px;"><strong>{{ $student->registration_code }}</strong></td></tr>
        <tr><td class="label">Status Sistem</td><td class="value">
            @if($student->status === 'accepted') <strong>DITERIMA</strong>
            @elseif($student->status === 'rejected') <strong>DITOLAK</strong>
            @else <strong>PROSES VERIFIKASI ADMIN</strong>
            @endif
        </td></tr>
        <tr><td class="label">Nama Lengkap</td><td class="value">{{ strtoupper($student->full_name) }}</td></tr>
        <tr><td class="label">NIK / NISN</td><td class="value">{{ $student->nik }} / {{ $student->nisn ?? '-' }}</td></tr>
        <tr><td class="label">Tempat, Tanggal Lahir</td><td class="value">{{ strtoupper($student->birth_place) }}, {{ $student->birth_date->format('d/m/Y') }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td class="value">{{ $student->gender == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</td></tr>
        <tr><td class="label">Asal Sekolah</td><td class="value">{{ strtoupper($student->previous_school ?? '-') }}</td></tr>
        <tr><td class="label">Alamat Lengkap</td><td class="value">{{ $student->address }}, RT. {{ $student->rt }} / RW. {{ $student->rw }}</td></tr>
    </table>

    <h3 style="margin-bottom: 10px;">B. DATA ORANG TUA / WALI</h3>
    <table>
        <tr><td class="label">Nomor KK</td><td class="value">{{ $student->no_kk }}</td></tr>
        <tr><td class="label">Nama Ibu Kandung</td><td class="value">{{ strtoupper($student->mother_name) }}</td></tr>
        <tr><td class="label">Nama Ayah</td><td class="value">{{ strtoupper($student->father_name ?? '-') }}</td></tr>
        <tr><td class="label">Nomor Ponsel (WA)</td><td class="value">{{ $student->parent_phone }}</td></tr>
    </table>

    <div style="margin-top: 25px; padding: 15px; border: 1px solid #aaa; background-color: #fcfcfc;">
        <p style="margin-top: 0; font-weight: bold; text-decoration: underline;">Catatan Penting:</p>
        <ol style="margin-bottom: 0; padding-left: 20px;">
            <li>Harap simpan dan bawa dokumen bukti cetak ini sebagai persyaratan mutlak daftar ulang.</li>
            <li>Lampirkan kelengkapan <strong>asli dan fotokopi</strong> KK, Akta Kelahiran, serta Pas Foto berwarna 3x4 (2 lembar) saat menyerahkan berkas ke sekolah.</li>
            <li>Pemalsuan data akan menyebabkan kelulusan dibatalkan.</li>
        </ol>
    </div>

    <table style="border: none; width: 100%; margin-top: 20px;">
        <tr style="border: none;">
            <td style="border: none; width: 50%; text-align: center; vertical-align: top;">
                <div class="qrcode-container">
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" class="qrcode">
                    <p style="font-size: 11px; margin-top: 5px; color: #555;">Scan QR Code Pendaftaran</p>
                </div>
            </td>
            <td style="border: none; width: 50%; text-align: center; vertical-align: bottom;">
                <div>
                     ........................., {{ date('d F Y') }}<br>
                     Panitia PPDB,<br>
                    <br><br><br><br>
                    (...........................................)
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dicetak otomatis dari Sistem Informasi PPDB <strong>{{ $schoolName }}</strong> pada {{ now()->format('d/m/Y H:i:s') }}.<br>
        Dokumen ini sah dan di-generate oleh sistem online.
    </div>
</body>
</html>
