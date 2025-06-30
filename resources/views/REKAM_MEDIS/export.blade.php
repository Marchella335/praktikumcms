<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Rekam Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
            font-weight: normal;
        }
        
        .info-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .info-left, .info-right {
            flex: 1;
        }
        
        .info-item {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .summary-stats {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .stats-row {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        
        .stat-item {
            flex: 1;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            display: block;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        .data-table th {
            background-color: #343a40;
            color: white;
            padding: 8px 4px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }
        
        .data-table td {
            padding: 6px 4px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .data-table tr:hover {
            background-color: #e9ecef;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            margin: 60px 0 10px 0;
        }
        
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .header {
                page-break-after: avoid;
            }
            
            .data-table {
                page-break-inside: auto;
            }
            
            .data-table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            .data-table thead {
                display: table-header-group;
            }
            
            .signature-section {
                page-break-before: avoid;
            }
        }
        
        /* Screen-only controls */
        .screen-controls {
            position: fixed;
            top: 10px;
            right: 10px;
            background: white;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 2px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.8;
        }
        
        @media print {
            .screen-controls {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Screen Controls (tidak akan muncul saat print) -->
    <div class="screen-controls">
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Print
        </button>
        <button onclick="exportToCSV()" class="btn btn-success">
            📊 Export CSV
        </button>
        <a href="{{ route('rekam_medis.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN DATA REKAM MEDIS</h1>
        <h2>Sistem Informasi Manajemen Rumah Sakit</h2>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-left">
            <div class="info-item">
                <span class="info-label">Tanggal Export:</span>
                {{ \Carbon\Carbon::now()->format('d F Y') }}
            </div>
            <div class="info-item">
                <span class="info-label">Waktu Export:</span>
                {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB
            </div>
            <div class="info-item">
                <span class="info-label">Total Data:</span>
                {{ number_format($rekamMedis->count()) }} Record
            </div>
        </div>
        <div class="info-right">
            @if(request('start_date') || request('end_date'))
                <div class="info-item">
                    <span class="info-label">Filter Periode:</span>
                    @if(request('start_date') && request('end_date'))
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                    @elseif(request('start_date'))
                        Mulai: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}
                    @elseif(request('end_date'))
                        Sampai: {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                    @endif
                </div>
            @endif
            @if(request('dokter_id'))
                @php
                    $dokterName = DB::table('DOKTER')->where('ID_DOKTER', request('dokter_id'))->value('NAMA_DOKTER');
                @endphp
                <div class="info-item">
                    <span class="info-label">Filter Dokter:</span>
                    {{ $dokterName }}
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Statistics -->
    @if($rekamMedis->count() > 0)
        <div class="summary-stats">
            <h3 style="margin-top: 0; text-align: center; color: #333;">Ringkasan Statistik</h3>
            <div class="stats-row">
                <div class="stat-item">
                    <span class="stat-number">{{ number_format($rekamMedis->count()) }}</span>
                    <div class="stat-label">Total Rekam Medis</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $rekamMedis->unique('ID_PASIEN')->count() }}</span>
                    <div class="stat-label">Jumlah Pasien</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $rekamMedis->unique('ID_DOKTER')->count() }}</span>
                    <div class="stat-label">Jumlah Dokter</div>
                </div>
                <div class="stat-item">
                    @php
                        $firstDate = $rekamMedis->min('TANGGAL');
                        $lastDate = $rekamMedis->max('TANGGAL');
                        $daysDiff = $firstDate && $lastDate ? \Carbon\Carbon::parse($firstDate)->diffInDays(\Carbon\Carbon::parse($lastDate)) + 1 : 0;
                    @endphp
                    <span class="stat-number">{{ $daysDiff }}</span>
                    <div class="stat-label">Rentang Hari</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    @if($rekamMedis->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 8%;">Tanggal</th>
                    <th style="width: 15%;">Nama Pasien</th>
                    <th style="width: 15%;">Nama Dokter</th>
                    <th style="width: 12%;">Nama Staf</th>
                    <th style="width: 20%;">Diagnosa</th>
                    <th style="width: 15%;">Tindakan</th>
                    <th style="width: 12%;">Obat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekamMedis as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ $item->nama_staf ?? '-' }}</td>
                        <td>{{ Str::limit($item->diagnosa, 50) }}</td>
                        <td>{{ Str::limit($item->tindakan, 40) }}</td>
                        <td>{{ $item->obat ? Str::limit($item->obat, 30) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>Tidak Ada Data</h3>
            <p>Tidak ada data rekam medis yang sesuai dengan kriteria yang dipilih.</p>
        </div>
    @endif

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div>Diperiksa oleh:</div>
            <div class="signature-line"></div>
            <div>Kepala Bagian Rekam Medis</div>
        </div>
        <div class="signature-box">
            <div>Disetujui oleh:</div>
            <div class="signature-line"></div>
            <div>Direktur Rumah Sakit</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Manajemen Rumah Sakit</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }} WIB</p>
    </div>

    <script>
        function exportToCSV() {
            // Membuat header CSV
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "No,Tanggal,Nama Pasien,Nama Dokter,Nama Staf,Diagnosa,Tindakan,Obat\n";
            
            // Mengambil data dari tabel
            const table = document.querySelector('.data-table tbody');
            if (table) {
                const rows = table.querySelectorAll('tr');
                rows.forEach(row => {
                    const cols = row.querySelectorAll('td');
                    const rowData = Array.from(cols).map(col => {
                        // Membersihkan data dan menambahkan quotes jika perlu
                        let data = col.textContent.trim().replace(/"/g, '""');
                        if (data.includes(',') || data.includes('"') || data.includes('\n')) {
                            data = '"' + data + '"';
                        }
                        return data;
                    });
                    csvContent += rowData.join(',') + '\n';
                });
            }
            
            // Download file CSV
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'rekam_medis_export_' + new Date().toISOString().slice(0,10) + '.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Auto print jika ada parameter print di URL
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            };
        }
    </script>
</body>
</html>