<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        $users = User::orderBy('id')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'npk' => 'required|string|max:100|unique:users,npk',
            'jabatan' => 'required|string|in:member,leader,foreman,supervisior,manager,bod,administrator',
            'password' => 'required|string|min:6',
        ]);

        $validated['level'] = strtolower($validated['jabatan']);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Data user berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'npk' => 'required|string|max:100|unique:users,npk,' . $user->id,
            'jabatan' => 'required|string|in:member,leader,foreman,supervisior,manager,bod,administrator',
            'password' => 'nullable|string|min:6',
        ]);

        $validated['level'] = strtolower($validated['jabatan']);
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Data user berhasil dihapus.');
    }

    public function export(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }
        $type = strtolower($request->query('type', 'csv'));

        if ($type === 'xlsx') {
            if (! class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
                return redirect()->route('users.index')->with('error', 'Ekspor XLSX membutuhkan paket phpoffice/phpspreadsheet. Jalankan composer require phpoffice/phpspreadsheet.');
            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray(['npk', 'name', 'email', 'jabatan', 'level'], null, 'A1');

            $rowNumber = 2;
            foreach (User::orderBy('id')->cursor() as $user) {
                $sheet->fromArray([$user->npk, $user->name, $user->email, $user->jabatan, $user->level], null, 'A' . $rowNumber);
                $rowNumber++;
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename = 'users-export_' . date('Y-m-d_H-i-s') . '.xlsx';

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        $filename = 'users-export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['npk', 'name', 'email', 'jabatan', 'level']);

            foreach (User::orderBy('id')->cursor() as $user) {
                fputcsv($handle, [$user->npk, $user->name, $user->email, $user->jabatan, $user->level]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        if ($redirect = $this->requireRole(['administrator'])) {
            return $redirect;
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:10240',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        try {
            $importData = $this->parseUserImportFile($file, $extension);
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Import gagal: ' . $e->getMessage());
        }

        $header = array_map('strtolower', array_map('trim', $importData['header']));
        $rows = $importData['rows'];

        $allowedHeaders = ['npk', 'name', 'email', 'jabatan', 'level', 'password'];
        $header = array_values(array_filter($header, fn ($column) => in_array($column, $allowedHeaders, true)));

        $requiredColumns = ['npk', 'name', 'email', 'jabatan'];
        $missing = array_diff($requiredColumns, $header);
        if (! empty($missing)) {
            return redirect()->route('users.index')->with('error', 'Header harus berisi: ' . implode(', ', $requiredColumns) . '.');
        }

        $successCount = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $row = array_map('trim', $row);
            if (count(array_filter($row, fn ($value) => trim((string) $value) !== '')) === 0) {
                continue;
            }

            $mapped = [];
            foreach ($header as $columnIndex => $fieldName) {
                $mapped[$fieldName] = $row[$columnIndex] ?? '';
            }

            $npk = $mapped['npk'] ?? '';
            $email = strtolower($mapped['email'] ?? '');
            $name = $mapped['name'] ?? '';
            $jabatan = strtolower($mapped['jabatan'] ?? $mapped['level'] ?? 'member');
            $level = strtolower($mapped['level'] ?? $mapped['jabatan'] ?? $jabatan);
            $password = $mapped['password'] ?? '';

            if ($npk === '' || $name === '' || $email === '' || $jabatan === '') {
                $errors[] = 'Baris ' . ($index + 2) . ': NPK, nama, email, dan jabatan wajib diisi.';
                continue;
            }

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Baris ' . ($index + 2) . ': Email tidak valid.';
                continue;
            }

            $allowedRoles = ['member', 'leader', 'foreman', 'supervisior', 'manager', 'bod', 'administrator'];
            if (! in_array($level, $allowedRoles, true)) {
                $level = 'member';
            }

            try {
                $user = User::where('npk', $npk)->orWhere('email', $email)->first();
                $payload = [
                    'npk' => $npk,
                    'name' => $name,
                    'email' => $email,
                    'jabatan' => $jabatan,
                    'level' => $level,
                ];

                if ($password !== '') {
                    $payload['password'] = Hash::make($password);
                }

                if ($user) {
                    $user->update($payload);
                } else {
                    if (! isset($payload['password'])) {
                        $payload['password'] = Hash::make('password');
                    }
                    User::create($payload);
                }

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = 'Baris ' . ($index + 2) . ': ' . $e->getMessage();
            }
        }

        $message = "Import selesai. {$successCount} baris diproses.";
        if (! empty($errors)) {
            $message .= ' Error: ' . implode(' | ', $errors);
        }

        return redirect()->route('users.index')->with('success', $message);
    }

    private function parseUserImportFile($file, string $extension): array
    {
        if (in_array($extension, ['xlsx', 'xls'], true)) {
            if (! class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
                throw new \Exception('Library PhpSpreadsheet tidak ditemukan. Jalankan composer require phpoffice/phpspreadsheet.');
            }

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = [];

            foreach ($sheet->toArray(null, true, true, true) as $rawRow) {
                $rows[] = array_values(array_map(fn ($cell) => is_string($cell) ? trim($cell) : $cell, $rawRow));
            }

            if (empty($rows)) {
                throw new \Exception('File kosong.');
            }

            return ['header' => $rows[0], 'rows' => array_slice($rows, 1)];
        }

        if (in_array($extension, ['csv', 'txt'], true)) {
            $handle = fopen($file->getRealPath(), 'r');
            if ($handle === false) {
                throw new \Exception('Tidak dapat membuka file.');
            }

            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

            $rows = [];
            while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rows[] = array_map(fn ($cell) => is_string($cell) ? trim($cell) : $cell, $data);
            }
            fclose($handle);

            if (empty($rows)) {
                throw new \Exception('File kosong.');
            }

            return ['header' => $rows[0], 'rows' => array_slice($rows, 1)];
        }

        throw new \Exception('Format file tidak didukung. Gunakan CSV atau XLSX.');
    }
}
