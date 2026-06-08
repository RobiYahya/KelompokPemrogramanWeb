<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * AJAX preview: return JSON data for table preview in modal.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:barang_masuk,barang_keluar,data_edit,data_delete',
        ]);

        $data = $this->getReportData($request->report_type, $request->start_date, $request->end_date);

        $rows = $data->map(function ($item) use ($request) {
            if (in_array($request->report_type, ['barang_masuk', 'barang_keluar'])) {
                // Sumber data: BarangMasuk / BarangKeluar — field langsung tersedia
                return [
                    'transaction_id' => $item->formatted_id,
                    'item_id'        => $item->barang->formatted_id ?? '-',
                    'item_name'      => $item->barang->nama_barang ?? '-',
                    'quantity'       => $item->jumlah,
                    'date'           => $item->tanggal
                                            ? Carbon::parse($item->tanggal)->format('d/m/Y')
                                            : '-',
                    'description'    => $item->deskripsi ?? '-',
                    'user'           => $item->user->nama ?? '-',
                ];
            } else {
                // Sumber data: ActivityLog — tetap seperti sebelumnya
                $aksi = $this->translateAksi($item->aksi);

                $kategoriId = $item->kategori
                    ? $item->kategori->formatted_id
                    : ($item->id_kategori ?? '-');

                return [
                    'date'        => $item->tanggal
                                        ? Carbon::parse($item->tanggal)->format('d/m/Y H:i')
                                        : '-',
                    'user'        => $item->user->nama ?? 'Unknown',
                    'action'      => $aksi,
                    'item_name'   => $item->nama_barang ?? '-',
                    'category_id' => $kategoriId,
                    'description' => $item->deskripsi ?? '-',
                ];
            }
        });

        return response()->json(['rows' => $rows->values()]);
    }

    /**
     * Download report based on date range and type.
     */
    public function download(Request $request)
    {
        $request->validate([
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:barang_masuk,barang_keluar,data_edit,data_delete',
            'format'      => 'required|in:pdf,excel',
        ]);

        $startDate  = $request->input('start_date');
        $endDate    = $request->input('end_date');
        $reportType = $request->input('report_type');
        $format     = $request->input('format');

        $data = $this->getReportData($reportType, $startDate, $endDate);

        if ($data->isEmpty()) {
            return redirect()->route('dashboard')
                ->with('error', 'No data found for the selected date range.');
        }

        $filename = 'report_' . $reportType . '_' . $startDate . '_' . $endDate;

        if ($format === 'pdf') {
            return $this->generatePDF($data, $reportType, $filename);
        } else {
            return $this->generateExcel($data, $reportType, $filename);
        }
    }

    /**
     * Get report data based on type.
     *
     * barang_masuk / barang_keluar → dari tabel transaksi langsung.
     * data_edit / data_delete      → dari ActivityLog (tidak berubah).
     */
    private function getReportData($reportType, $startDate, $endDate)
    {
        switch ($reportType) {
            case 'barang_masuk':
                return BarangMasuk::with(['barang', 'user'])
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->orderBy('tanggal', 'desc')
                    ->get();

            case 'barang_keluar':
                return BarangKeluar::with(['barang', 'user'])
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->orderBy('tanggal', 'desc')
                    ->get();

            case 'data_edit':
                return ActivityLog::where('aksi', 'update')
                    ->whereBetween('tanggal', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->with(['user', 'kategori'])
                    ->orderBy('tanggal', 'desc')
                    ->get();

            case 'data_delete':
                return ActivityLog::where('aksi', 'delete')
                    ->whereBetween('tanggal', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->with(['user', 'kategori'])
                    ->orderBy('tanggal', 'desc')
                    ->get();

            default:
                return collect();
        }
    }

    /**
     * Translate raw action string to human-readable label.
     */
    private function translateAksi(string $aksi): string
    {
        return match ($aksi) {
            'create'        => 'Add',
            'update'        => 'Edit',
            'delete'        => 'Delete',
            'barang_masuk'  => 'Incoming',
            'barang_keluar' => 'Outgoing',
            default         => ucfirst($aksi),
        };
    }

    /**
     * Generate PDF report.
     */
    private function generatePDF($data, $reportType, $filename)
    {
        $html = $this->generateHTMLReport($data, $reportType);

        $pdf = Pdf::loadHTML($html);
        $filename .= '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate Excel (CSV) report.
     * BUG-016 Fix: Stream directly to browser — no disk write, no orphan files.
     */
    private function generateExcel($data, $reportType, $filename)
    {
        $csv      = $this->generateCSVReport($data, $reportType);
        $filename .= '.csv';

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    /**
     * Generate HTML report.
     * BUG-002 Fix: All user-controlled data escaped with htmlspecialchars().
     */
    private function generateHTMLReport($data, $reportType)
    {
        $title = $this->getReportTitle($reportType);

        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #6b21a8; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #6b21a8; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h1>
    <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
    <table>';

        $html .= $this->getTableHeaders($reportType);

        foreach ($data as $item) {
            $html .= $this->getTableRow($item, $reportType);
        }

        $html .= '</table>
</body>
</html>';

        return $html;
    }

    /**
     * Generate CSV report.
     */
    private function generateCSVReport($data, $reportType)
    {
        $csv = '';

        $headers = $this->getCSVHeaders($reportType);
        $escapedHeaders = array_map(function ($header) {
            return '"' . str_replace('"', '""', $header) . '"';
        }, $headers);
        $csv .= implode(',', $escapedHeaders) . "\n";

        foreach ($data as $item) {
            $row = $this->getCSVRow($item, $reportType);
            $escapedRow = array_map(function ($cell) {
                return '"' . str_replace('"', '""', $cell) . '"';
            }, $row);
            $csv .= implode(',', $escapedRow) . "\n";
        }

        return $csv;
    }

    /**
     * Get report title.
     */
    private function getReportTitle($reportType)
    {
        $titles = [
            'barang_masuk'  => 'Barang Masuk Report',
            'barang_keluar' => 'Barang Keluar Report',
            'data_edit'     => 'Data Edit Report',
            'data_delete'   => 'Data Delete Report',
        ];

        return $titles[$reportType] ?? 'Report';
    }

    /**
     * Get table headers HTML.
     */
    private function getTableHeaders($reportType)
    {
        $headers = [
            'barang_masuk'  => '<tr><th>Transaction ID</th><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Date</th><th>Description</th><th>User</th></tr>',
            'barang_keluar' => '<tr><th>Transaction ID</th><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Date</th><th>Description</th><th>User</th></tr>',
            'data_edit'     => '<tr><th>Date</th><th>User</th><th>Action</th><th>Item Name</th><th>Category ID</th><th>Description</th></tr>',
            'data_delete'   => '<tr><th>Date</th><th>User</th><th>Action</th><th>Item Name</th><th>Category ID</th><th>Description</th></tr>',
        ];

        return $headers[$reportType] ?? '';
    }

    /**
     * Get table row HTML.
     * BUG-002 Fix: All dynamic values escaped to prevent XSS in PDF/HTML output.
     */
    private function getTableRow($item, $reportType)
    {
        // Helper closure: escape for HTML output
        $h = fn($s) => htmlspecialchars((string) ($s ?? '-'), ENT_QUOTES, 'UTF-8');

        switch ($reportType) {
            case 'barang_masuk':
            case 'barang_keluar':
                $formattedDate = $item->tanggal
                    ? Carbon::parse($item->tanggal)->format('d/m/Y')
                    : '-';

                return '<tr>
                    <td>' . $h($item->formatted_id) . '</td>
                    <td>' . $h($item->barang->formatted_id ?? '-') . '</td>
                    <td>' . $h($item->barang->nama_barang ?? '-') . '</td>
                    <td>' . $h($item->jumlah) . '</td>
                    <td>' . $h($formattedDate) . '</td>
                    <td>' . $h($item->deskripsi ?? '-') . '</td>
                    <td>' . $h($item->user->nama ?? '-') . '</td>
                </tr>';

            case 'data_edit':
            case 'data_delete':
                $formattedDate = $item->tanggal
                    ? Carbon::parse($item->tanggal)->format('d/m/Y H:i')
                    : '-';

                $aksi = $this->translateAksi($item->aksi);

                $kategoriId = $item->kategori
                    ? $item->kategori->formatted_id
                    : ($item->id_kategori ?? '-');

                return '<tr>
                    <td>' . $h($formattedDate) . '</td>
                    <td>' . $h($item->user->nama ?? '-') . '</td>
                    <td>' . $h($aksi) . '</td>
                    <td>' . $h($item->nama_barang ?? '-') . '</td>
                    <td>' . $h($kategoriId) . '</td>
                    <td>' . $h($item->deskripsi ?? '-') . '</td>
                </tr>';

            default:
                return '';
        }
    }

    /**
     * Get CSV headers array.
     */
    private function getCSVHeaders($reportType)
    {
        $headers = [
            'barang_masuk'  => ['Transaction ID', 'Item ID', 'Item Name', 'Quantity', 'Date', 'Description', 'User'],
            'barang_keluar' => ['Transaction ID', 'Item ID', 'Item Name', 'Quantity', 'Date', 'Description', 'User'],
            'data_edit'     => ['Date', 'User', 'Action', 'Item Name', 'Category ID', 'Description'],
            'data_delete'   => ['Date', 'User', 'Action', 'Item Name', 'Category ID', 'Description'],
        ];

        return $headers[$reportType] ?? [];
    }

    /**
     * Get CSV row array.
     */
    private function getCSVRow($item, $reportType)
    {
        switch ($reportType) {
            case 'barang_masuk':
            case 'barang_keluar':
                $formattedDate = $item->tanggal
                    ? Carbon::parse($item->tanggal)->format('d/m/Y')
                    : '-';

                return [
                    $item->formatted_id,
                    $item->barang->formatted_id ?? '-',
                    $item->barang->nama_barang ?? '-',
                    (string) $item->jumlah,
                    $formattedDate,
                    $item->deskripsi ?? '-',
                    $item->user->nama ?? '-',
                ];

            case 'data_edit':
            case 'data_delete':
                $formattedDate = $item->tanggal
                    ? Carbon::parse($item->tanggal)->format('d/m/Y H:i')
                    : '-';

                $aksi = $this->translateAksi($item->aksi);

                $kategoriId = $item->kategori
                    ? $item->kategori->formatted_id
                    : ($item->id_kategori ?? '-');

                return [
                    $formattedDate,
                    $item->user->nama ?? 'Unknown',
                    $aksi,
                    $item->nama_barang ?? '-',
                    $kategoriId,
                    $item->deskripsi ?? '-',
                ];

            default:
                return [];
        }
    }
}