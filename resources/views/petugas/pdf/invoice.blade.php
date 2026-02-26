<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Denda #{{ $invoiceNumber }}</title>
    <style>
        /* Standar A4 Portrait */
        @page {
            size: portrait;
            margin: 0;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 1cm;
            color: #334155;
            background-color: #fff;
            position: relative;
        }

        /* Header Section */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #06B6D4; /* Cyan Utama sesuai dashboard */
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .brand-logo { width: 70px; vertical-align: middle; }

        .brand-text { padding-left: 15px; vertical-align: middle; }
        .brand-text h1 {
            font-size: 24pt; margin: 0; color: #F59E0B; /* Orange aksen logo */
            text-transform: uppercase;
        }
        .brand-text h1 span { color: #06B6D4; }
        .brand-text p { margin: 0; font-size: 11pt; font-weight: bold; color: #1e293b; }

        .invoice-label {
            font-size: 30pt; font-weight: bold; color: #0891B2;
            text-align: right; vertical-align: middle;
            text-transform: uppercase;
        }

        /* Billing & Meta */
        .meta-table { width: 100%; margin-bottom: 35px; font-size: 10pt; }
        .meta-table td { vertical-align: top; line-height: 1.5; }
        .label-gray { color: #64748b; text-transform: uppercase; font-size: 9pt; font-weight: bold; margin-bottom: 5px; }

        /* Main Table - Balanced Cyan Theme */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0; /* Rapat dengan pill di bawahnya */
        }
        .main-table th {
            background-color: #06B6D4;
            color: white;
            text-align: center;
            padding: 15px 10px;
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }
        .main-table td {
            padding: 14px 10px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 10pt;
            color: #475569;
        }
        /* Zebra Striping Soft */
        .main-table tr:nth-child(even) { background-color: #F8FAFC; }

        /* Subtotal Pill - Fixed Balance & Capsule Shape */
        .subtotal-row td { border: none !important; padding: 0 !important; }

        .pill-wrapper {
            text-align: right;
            width: 100%;
            margin-top: -1px; /* Menghilangkan celah putih antara tabel dan pill */
        }

        .subtotal-pill {
            background-color: #06B6D4;
            color: white;
            display: inline-block;
            padding: 12px 30px;
            min-width: 320px; /* Lebar seimbang dengan teks Invoice di atas */
            font-weight: bold;
            border-radius: 50px 0 0 50px; /* Capsule sempurna di sisi kiri */
        }

        .pill-label {
            float: left;
            font-size: 11pt;
            margin-right: 40px;
        }

        .pill-value {
            float: right;
            font-size: 11pt;
            letter-spacing: 0.5px;
        }

        /* Footer & Sign */
        .content-footer { margin-top: 50px; font-size: 9.5pt; color: #475569; line-height: 1.6; }

        .admin-section { width: 100%; margin-top: 40px; }
        .sig-box { text-align: right; padding-right: 40px; }
        .sig-space { height: 70px; }

        /* Contact Bar */
        .contact-bar {
            position: absolute;
            bottom: 1cm;
            width: 90%;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            left: 5%;
        }
        .contact-item { width: 33.33%; font-size: 8.5pt; text-align: center; color: #64748b; }
        .icon-cyan { color: #06B6D4; font-weight: bold; margin-right: 4px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="75">
                <img src="{{ public_path('image/logoClean.png') }}" class="brand-logo">
            </td>
            <td class="brand-text">
                <h1>LAN<span>TERA</span></h1>
                <p>SMP NEGERI 1 Balen</p>
            </td>
            <td class="invoice-label">INVOICE</td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td width="55%">
                <div class="label-gray">INVOICE TO:</div>
                <div style="font-weight: bold; font-size: 11pt; color: #0f172a;">{{ $user->name }}</div>
                <div style="margin-top: 3px;">ID: {{ $user->nomor_identitas }}</div>
            </td>
            <td align="right">
                <div style="font-weight: bold; color: #0f172a;">INVOICE NO: #{{ $invoiceNumber }}</div>
                <div style="color: #64748b; margin-top: 3px;">
                    {{ \Carbon\Carbon::parse($return->tanggal_pengembalian)->format('d F Y') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Buku</th>
                <th width="130">Jenis Denda</th>
                <th width="120">Keterlambatan</th>
                <th width="150">Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td style="color: #1E293B; font-weight: 500;">{{ $item['judul'] }}</td>
                <td align="center">{{ $item['jenis'] }}</td>
                <td align="center">{{ $item['hari'] > 0 ? $item['hari'] . ' Hari' : '-' }}</td>
                <td align="right" style="padding-right: 20px;">
                    Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" class="subtotal-row">
                    <div class="pill-wrapper">
                        <div class="subtotal-pill">
                            <span class="pill-label">Total Tagihan :</span>
                            <span class="pill-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="content-footer">
        <p style="font-weight: bold; color: #1e293b; margin-bottom: 5px;">Keterangan:</p>
        <p style="width: 85%; margin-top: 0;">
            Tagihan ini merupakan biaya administrasi perpustakaan yang timbul akibat keterlambatan pengembalian atau kehilangan buku. Mohon segera melakukan pembayaran melalui petugas perpustakaan untuk mengaktifkan kembali status keanggotaan Anda.
        </p>
    </div>

    <table class="admin-section">
        <tr>
            <td align="right" class="sig-box">
                <div style="font-weight: bold; color: #1e293b;">Perpustakaan LANTERA</div>
                <div class="sig-space">
                    </div>
                <div style="font-weight: bold; border-top: 1.5px solid #334155; display: inline-block; padding: 5px 40px; color: #1e293b;">
                    Admin Perpustakaan
                </div>
            </td>
        </tr>
    </table>

    <table class="contact-bar">
        <tr>
            <td class="contact-item"><span class="icon-cyan">📞</span> +62 123 4567 890</td>
            <td class="contact-item"><span class="icon-cyan">✉️</span> spensaba@gmail.com</td>
            <td class="contact-item"><span class="icon-cyan">📍</span> Kec. Balen, Bojonegoro</td>
        </tr>
    </table>

</body>
</html>
