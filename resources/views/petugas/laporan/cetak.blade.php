<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman dan Pengembalian Alat</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #1e293b;
            margin: 0;
            padding: 25px;
            background-color: #f8fafc;
        }
        .page-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 35px 40px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            margin: 0 0 4px 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #0f172a;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 12px;
            color: #475569;
        }

        /* Judul Laporan */
        .judul-laporan {
            text-align: center;
            margin-bottom: 24px;
        }
        .judul-laporan h3 {
            margin: 0 0 6px 0;
            font-size: 15px;
            text-transform: uppercase;
            color: #0f172a;
        }
        .judul-laporan .meta-info {
            font-size: 12px;
            color: #64748b;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 9px 10px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        td.text-center, th.text-center {
            text-align: center;
        }

        /* Ringkasan */
        .ringkasan-box {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 30px;
            padding: 10px 14px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        /* Tanda Tangan */
        .ttd-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }
        .ttd-box {
            text-align: center;
            width: 240px;
        }
        .ttd-space {
            height: 70px;
        }

        /* Action bar for screen */
        .action-bar {
            max-width: 900px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .btn-primary {
            background-color: #2563eb;
            color: #fff;
        }
        .btn-secondary {
            background-color: #e2e8f0;
            color: #334155;
            border-color: #cbd5e1;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .page-container {
                border: none;
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    {{-- Screen action bar --}}
    <div class="action-bar no-print">
        <div>
            <a href="javascript:history.back()" class="btn btn-secondary">&larr; Kembali</a>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">Cetak Dokumen / Simpan PDF</button>
        </div>
    </div>

    <div class="page-container">
        {{-- Kop Surat Resmi --}}
        <div class="kop-surat">
            <h2>Sistem Informasi Peminjaman Alat</h2>
            <p>Unit Pengelola Laboratorium & Inventaris Peralatan</p>
            <p>Jalan Pendidikan No. 1, Telp: (021) 1234567 | Email: lab@sekolah.sch.id</p>
        </div>

        {{-- Judul Laporan --}}
        <div class="judul-laporan">
            <h3>Laporan Rekapitulasi Peminjaman & Pengembalian Alat</h3>
            <div class="meta-info">
                @if (request('dari') || request('sampai'))
                    Periode: <strong>{{ request('dari') ?: 'Awal' }}</strong> s/d <strong>{{ request('sampai') ?: 'Hari Ini' }}</strong>
                @else
                    Periode: <strong>Seluruh Transaksi</strong>
                @endif
                @if (request('status'))
                    | Filter Status: <strong>{{ ucfirst(request('status')) }}</strong>
                @endif
            </div>
        </div>

        {{-- Tabel Data --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 35px;" class="text-center">No</th>
                    <th style="width: 85px;">Tgl Pinjam</th>
                    <th>Nama Peminjam</th>
                    <th>Alat & Kategori</th>
                    <th style="width: 55px;" class="text-center">Jml</th>
                    <th style="width: 85px;">Batas Kembali</th>
                    <th style="width: 95px;" class="text-center">Status</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $item->peminjam->name ?? 'User #' . $item->id_user }}</strong>
                        </td>
                        <td>
                            {{ $item->alat->nama_alat ?? '-' }}
                            <small style="color: #64748b;">({{ $item->alat->kategori->nama_kategori ?? 'Umum' }})</small>
                        </td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if ($item->isSudahDikembalikan())
                                Dikembalikan
                            @elseif ($item->status === 'menunggu')
                                Menunggu
                            @elseif ($item->status === 'disetujui')
                                Disetujui
                            @elseif ($item->status === 'ditolak')
                                Ditolak
                            @else
                                {{ ucfirst($item->status) }}
                            @endif
                        </td>
                        <td>{{ $item->petugas->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 20px;">
                            Tidak ada data transaksi yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Ringkasan --}}
        <div class="ringkasan-box">
            <div>Total Transaksi: <strong>{{ $peminjaman->count() }} Data</strong></div>
            <div>Total Unit Dipinjam: <strong>{{ $peminjaman->sum('jumlah') }} Unit</strong></div>
            <div>Dicetak Pada: <strong>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }} WIB</strong></div>
        </div>

        {{-- Tanda Tangan --}}
        <div class="ttd-section">
            <div class="ttd-box">
                <div>Petugas Pemeriksa,</div>
                <div class="ttd-space"></div>
                <div style="font-weight: bold; text-decoration: underline;">
                    {{ auth()->user()->name ?? 'Petugas Laboratorium' }}
                </div>
                <div style="font-size: 11px; color: #64748b;">
                    NIP / ID: {{ auth()->user()->id ?? '1' }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto print prompt
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
