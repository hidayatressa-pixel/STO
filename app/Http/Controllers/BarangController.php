<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function dashboard(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $range = $request->query('range', 'all');
        $query = Produksi::query();

        if ($range === 'today') {
            $query = $query->whereDate('created_at', Carbon::today());
        } elseif ($range === 'week') {
            $query = $query->whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->endOfDay()]);
        }

        $lines = (clone $query)
            ->select('line', DB::raw('SUM(gap) as total_gap'))
            ->groupBy('line')
            ->orderByDesc('total_gap')
            ->limit(10)
            ->get();

        $totalParts = (clone $query)->count();
        $totalSystem = (clone $query)->sum('qty_system');
        $totalAktual = (clone $query)->sum('qty_aktual');
        $totalGap = (clone $query)->sum('gap');
        $latestProduksi = (clone $query)->orderByDesc('updated_at')->limit(6)->get();

        return view('dashboard', compact('lines', 'totalParts', 'totalSystem', 'totalAktual', 'totalGap', 'latestProduksi', 'range'));
    }

    public function detailLine($line)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $parts = Produksi::where('line', $line)
            ->orderByDesc('gap')
            ->get();

        $totalGap = $parts->sum('gap');

        return view('detail-line', compact('line', 'parts', 'totalGap'));
    }

    public function index(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $search = $request->query('search');
        $sort = $request->query('sort');
        $allowedSorts = ['part_number', 'qty_system', 'qty_aktual', 'gap', 'created_at'];

        $produksi = Produksi::when($search, function ($query) use ($search) {
            return $query->where('line', 'like', "%{$search}%");
        });

        if (in_array($sort, $allowedSorts)) {
            $produksi = $produksi->orderBy($sort, 'desc');
        }

        $produksi = $produksi->orderBy('line')->orderBy('part_number')->get();

        $lines = Produksi::select('line')->distinct()->orderBy('line')->pluck('line');

        return view('index', compact('produksi', 'search', 'lines'));
    }

    public function uploadForm()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator', 'manager', 'bod'])) {
            return $redirect;
        }

        return view('upload');
    }

    public function exportPage()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator', 'manager', 'bod', 'foreman', 'supervisior'])) {
            return $redirect;
        }

        return view('export');
    }

    public function settings()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('settings');
    }

    public function updateProfile(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $currentUser = $this->currentUser();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($currentUser['id']),
            ],
            'current_password' => 'nullable|string|min:6',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $currentUser = $this->currentUser();
        $user = User::find($currentUser['id']);

        if (! $user) {
            return redirect()->route('settings')->with('error', 'Pengguna tidak ditemukan.');
        }

        if (! empty($validated['password'])) {
            if (empty($validated['current_password']) || ! Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withInput();
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        $authUser = session('auth_user');
        $authUser['name'] = $user->name;
        $authUser['email'] = $user->email;
        session(['auth_user' => $authUser]);

        return redirect()->route('settings')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePreferences(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'theme' => 'required|in:dark,light',
            'language' => 'required|in:id,en,de,zh,ja,vi,ru,es',
        ]);

        $currentUser = $this->currentUser();
        $user = User::find($currentUser['id']);

        if (! $user) {
            return redirect()->route('settings')->with('error', 'Pengguna tidak ditemukan.');
        }

        if (Schema::hasColumn('users', 'theme')) {
            $user->theme = $validated['theme'];
        }
        if (Schema::hasColumn('users', 'language')) {
            $user->language = $validated['language'];
        }
        $user->save();

        $authUser = session('auth_user');
        $authUser['theme'] = $validated['theme'];
        $authUser['language'] = $validated['language'];
        session(['auth_user' => $authUser]);

        return redirect()->route('settings')->with('success', 'Preferensi berhasil disimpan.');
    }

    public function exportData(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator', 'manager', 'bod', 'foreman', 'supervisior'])) {
            return $redirect;
        }

        $type = strtolower($request->query('type', 'csv'));
        $filename = 'produksi-export_' . date('Y-m-d_H-i-s');

        if ($type === 'xlsx') {
            if (! class_exists('\PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
                return redirect()->route('barang.export')->with('error', 'Ekspor XLSX membutuhkan paket phpoffice/phpspreadsheet.');
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray(['line', 'part_number', 'part_name', 'qty_system', 'qty_aktual', 'gap'], null, 'A1');

            $rowNumber = 2;
            foreach (Produksi::orderBy('id')->cursor() as $item) {
                $sheet->fromArray([
                    $item->line,
                    $item->part_number,
                    $item->part_name,
                    $item->qty_system,
                    $item->qty_aktual,
                    $item->gap,
                ], null, 'A' . $rowNumber);
                $rowNumber++;
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename .= '.xlsx';

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        $filename .= '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['line', 'part_number', 'part_name', 'qty_system', 'qty_aktual', 'gap']);

            foreach (Produksi::orderBy('id')->cursor() as $item) {
                fputcsv($handle, [
                    $item->line,
                    $item->part_number,
                    $item->part_name,
                    $item->qty_system,
                    $item->qty_aktual,
                    $item->gap,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function masterData()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator', 'manager', 'bod'])) {
            return $redirect;
        }

        $lineSummaries = Produksi::select(
            'line',
            DB::raw('COUNT(*) as part_count'),
            DB::raw('SUM(qty_system) as total_system'),
            DB::raw('SUM(qty_aktual) as total_aktual'),
            DB::raw('SUM(gap) as total_gap')
        )
        ->groupBy('line')
        ->orderBy('line')
        ->get();

        return view('master-data', compact('lineSummaries'));
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'line' => 'required|string|max:50',
            'part_number' => 'required|string|max:50',
            'part_name' => 'required|string|max:255',
            'qty_system' => 'required|integer|min:0',
            'qty_aktual' => 'required|integer|min:0',
            'gap' => 'required|integer',
        ]);

        Produksi::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Produksi $barang)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('show', compact('barang'));
    }

    public function edit(Produksi $barang)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('edit', compact('barang'));
    }

    public function update(Request $request, Produksi $barang)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'qty_aktual' => 'required|integer|min:0',
        ]);

        $barang->qty_aktual = $validated['qty_aktual'];
        $barang->gap = $barang->qty_aktual - $barang->qty_system;
        $barang->save();

        return redirect()->route('barang.show', $barang)->with('success', 'Qty Aktual berhasil diperbarui.');
    }

    public function destroy(Produksi $barang)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }

    public function import(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator', 'manager', 'bod'])) {
            return $redirect;
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:5120',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if (in_array($extension, ['xlsx', 'xls'], true)) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            foreach ($spreadsheet->getActiveSheet()->toArray(null, true, true, true) as $rawRow) {
                $rows[] = array_values(array_map(fn ($cell) => is_string($cell) ? trim($cell) : $cell, $rawRow));
            }
        } else {
            $handle = fopen($file->getRealPath(), 'r');
            if ($handle === false) {
                return redirect()->route('barang.upload')->with('error', 'Tidak dapat membuka file.');
            }

            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';
            while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rows[] = array_map(fn ($cell) => is_string($cell) ? trim($cell) : $cell, $data);
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return redirect()->route('barang.upload')->with('error', 'File kosong atau format tidak dikenali.');
        }

        array_walk($rows, function (&$row) {
            if (is_array($row)) {
                $row = array_values($row);
            }
        });

        $header = array_map('strtolower', array_map('trim', array_shift($rows)));
        $successCount = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $row = array_map('trim', $row);
            if (count(array_filter($row, fn ($value) => trim((string) $value) !== '')) === 0) {
                continue;
            }

            $line = $row[0] ?? null;
            $partNumber = $row[1] ?? null;
            $partName = $row[2] ?? null;
            $qtySystem = (int) ($row[3] ?? 0);
            $qtyAktual = (int) ($row[4] ?? 0);
            $gap = (int) ($row[5] ?? ($qtyAktual - $qtySystem));

            if (! $line || ! $partNumber) {
                $errors[] = 'Baris ' . ($index + 2) . ': Line dan part number wajib diisi.';
                continue;
            }

            try {
                Produksi::updateOrCreate(
                    ['part_number' => trim($partNumber)],
                    [
                        'line' => trim($line),
                        'part_name' => trim($partName),
                        'qty_system' => $qtySystem,
                        'qty_aktual' => $qtyAktual,
                        'gap' => $gap,
                    ]
                );

                $successCount++;
            } catch (\Exception $e) {
                Log::error('Import produksi failed: ' . $e->getMessage());
                $errors[] = 'Baris ' . ($index + 2) . ': ' . $e->getMessage();
            }
        }

        $message = "Import selesai. {$successCount} baris diproses.";
        if (! empty($errors)) {
            $message .= ' Error: ' . implode(' | ', $errors);
        }

        return redirect()->route('barang.upload')->with('success', $message);
    }
}
