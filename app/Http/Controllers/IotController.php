<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class IotController extends Controller
{
    // =========================================================================
    // BAGIAN 1: API & MOBILE APP (JSON RESPONSE)
    // =========================================================================

    // List Alat (Untuk Mobile App Flutter / API)
    public function index()
    {
        $devices = Device::where('user_id', Auth::id())
            ->with('latestSensorData')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }

    // =========================================================================
    // BAGIAN 2: FRONTEND WEB VIEWS (BLADE TEMPLATES)
    // =========================================================================

    // Halaman Landing Layanan IoT (/layanan/smart-garden)
    public function serviceIndex()
    {
        $myDevices = [];
        $userRole = null;

        if (Auth::check()) {
            $user = Auth::user();
            $userRole = $user->role ?? 'user'; // Default jika null

            // Hanya ambil devices untuk petani/admin
            if (in_array($userRole, ['pekebun', 'admin'])) {
                $myDevices = Device::where('user_id', $user->id)->latest()->get();
            }
        }

        // KIRIM $userRole ke view
        return view('layanan.index', compact('myDevices', 'userRole'));
    }

    // Halaman Dashboard Monitoring Spesifik (/layanan/smart-garden/{serial})
    public function serviceShow($serial_number)
    {
        // Cari alat dan ambil data sensor terakhir
        $device = Device::where('serial_number', $serial_number)
            ->with('latestSensorData')
            ->firstOrFail();

        // KEAMANAN: Pastikan yang akses adalah pemilik alat ATAU Admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != 'admin' && $device->user_id != Auth::id()) {
            return redirect()->route('layanan.index')->with('error', 'Anda tidak memiliki akses ke alat ini.');
        }

        return view('layanan.show', compact('device'));
    }

    // =========================================================================
    // BAGIAN 3: LOGIC KONTROL & KLAIM (FORM ACTIONS)
    // =========================================================================

    // Proses Klaim / Pendaftaran Alat (Input Serial & PIN/Password)
    public function claimDevice(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string',
            'pin_code'      => 'required|string',
            'name'          => 'required|string',
        ]);

        $serial = trim($request->serial_number);
        $pin = trim($request->pin_code);
        $name = trim($request->name);

        $device = Device::where('serial_number', $serial)->first();

        if ($device) {
            // Jika perangkat sudah ada di database, verifikasi kecocokan PIN
            if ($device->pin_code !== $pin) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json(['success' => false, 'message' => 'PIN/Password untuk nomor seri ini salah.'], 422);
                }
                return back()->with('error', 'PIN atau Password untuk Serial Number ini salah! Silakan periksa stiker alat atau tanyakan ke admin.')
                    ->withInput();
            }

            // Cek apakah sudah diklaim orang lain
            if ($device->user_id && $device->user_id !== Auth::id()) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json(['success' => false, 'message' => 'Perangkat ini sudah terdaftar milik akun lain.'], 403);
                }
                return back()->with('error', 'Perangkat ini sudah terhubung dengan akun pekebun lain!')
                    ->withInput();
            }

            // Update pemilik dan nama
            $device->update([
                'user_id' => Auth::id(),
                'name'    => $name,
            ]);

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perangkat berhasil dihubungkan!',
                    'data'    => $device
                ]);
            }

            return redirect()->route('layanan.show', $device->serial_number)
                ->with('success', "Perangkat {$device->serial_number} ({$name}) berhasil dihubungkan! Selamat memantau.");
        }

        // JIKA PERANGKAT BELUM ADA DI DATABASE:
        // Daftarkan langsung secara instan sehingga user tidak perlu repot input manual di database!
        $newDevice = Device::create([
            'serial_number' => $serial,
            'pin_code'      => $pin,
            'name'          => $name,
            'user_id'       => Auth::id(),
            'mode'          => 'AUTO',
            'is_pump_on'    => false,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Perangkat baru berhasil didaftarkan dan langsung terhubung!',
                'data'    => $newDevice
            ]);
        }

        return redirect()->route('layanan.show', $newDevice->serial_number)
            ->with('success', "Perangkat baru {$newDevice->serial_number} berhasil didaftarkan dengan PIN Anda dan langsung aktif!");
    }

    // Tombol ON/OFF Pompa (Manual Mode)
    public function togglePump($id)
    {
        $deviceQuery = Device::where('id', $id);
        if (Auth::user()->role !== 'admin') {
            $deviceQuery->where('user_id', Auth::id());
        }
        $device = $deviceQuery->firstOrFail();

        $device->is_pump_on = !$device->is_pump_on;
        $device->mode = 'MANUAL'; // Jika user menekan tombol, otomatis jadi Manual
        $device->save();

        return back()->with('success', 'Status pompa berhasil diubah.');
    }

    // Tombol Kembali ke Mode AUTO
    public function setAuto($id)
    {
        $deviceQuery = Device::where('id', $id);
        if (Auth::user()->role !== 'admin') {
            $deviceQuery->where('user_id', Auth::id());
        }
        $device = $deviceQuery->firstOrFail();

        $device->mode = 'AUTO';
        $device->save();

        return back()->with('success', 'Alat kembali ke mode Otomatis.');
    }

    // [BARU] Tombol Switch ke Mode MANUAL
    public function manual($id)
    {
        $deviceQuery = Device::where('id', $id);
        if (Auth::user()->role !== 'admin') {
            $deviceQuery->where('user_id', Auth::id());
        }
        $device = $deviceQuery->firstOrFail();

        $device->mode = 'MANUAL';
        $device->save();

        return back()->with('success', 'Alat berhasil diubah ke mode Manual.');
    }

    // Download template CSV khusus Pekebun
    public function downloadTemplate()
    {
        $csvHeader = "serial_number,pin_code,nama_perangkat\n";
        $csvRows = "SN-AGRI-001,123456,Sensor Blok A Durian Musang King\n" .
                   "SN-AGRI-002,654321,Sensor Blok B Durian Duri Hitam\n" .
                   "SN-AGRI-003,888999,Sensor Pembibitan Durian\n";

        return Response::make($csvHeader . $csvRows, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_upload_perangkat_iot.csv"',
        ]);
    }

    // Upload / Import Massal PIN & Password langsung untuk Pekebun
    public function uploadDevices(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'file'       => 'nullable|file|mimes:csv,txt,text/plain|max:4096',
            'batch_text' => 'nullable|string',
        ]);

        if (!$request->hasFile('file') && empty(trim($request->batch_text ?? ''))) {
            return back()->with('error', 'Silakan pilih file CSV/TXT atau masukkan teks daftar perangkat.');
        }

        $lines = [];

        // 1. Baca dari file
        if ($request->hasFile('file')) {
            $content = file_get_contents($request->file('file')->getRealPath());
            $fileLines = preg_split("/\r\n|\n|\r/", $content);
            foreach ($fileLines as $line) {
                if (trim($line) !== '') {
                    $lines[] = trim($line);
                }
            }
        }

        // 2. Baca dari textarea batch
        if (!empty(trim($request->batch_text ?? ''))) {
            $textLines = preg_split("/\r\n|\n|\r/", $request->batch_text);
            foreach ($textLines as $line) {
                if (trim($line) !== '') {
                    $lines[] = trim($line);
                }
            }
        }

        $createdCount = 0;
        $updatedCount = 0;
        $failedCount = 0;
        $userId = Auth::id();

        foreach ($lines as $line) {
            $delimiter = ',';
            if (strpos($line, ';') !== false) {
                $delimiter = ';';
            } elseif (strpos($line, '|') !== false) {
                $delimiter = '|';
            } elseif (strpos($line, "\t") !== false) {
                $delimiter = "\t";
            }

            $parts = str_getcsv($line, $delimiter);
            if (count($parts) < 2) {
                continue;
            }

            $serial = trim($parts[0]);
            $pin = trim($parts[1]);
            $name = isset($parts[2]) ? trim($parts[2]) : null;

            // Lewati jika baris header
            if (in_array(strtolower($serial), ['serial', 'serial_number', 'serial number', 'sn', 'kode serial'])) {
                continue;
            }

            if (empty($serial) || empty($pin)) {
                $failedCount++;
                continue;
            }

            $existing = Device::where('serial_number', $serial)->first();
            if ($existing) {
                // Jangan timpa jika sudah terhubung ke akun pekebun lain
                if ($existing->user_id && $existing->user_id !== $userId && Auth::user()->role !== 'admin') {
                    $failedCount++;
                    continue;
                }

                $updateData = [
                    'pin_code' => $pin,
                    'user_id'  => $userId,
                ];
                if (!empty($name)) {
                    $updateData['name'] = $name;
                }
                $existing->update($updateData);
                $updatedCount++;
            } else {
                Device::create([
                    'serial_number' => $serial,
                    'pin_code'      => $pin,
                    'name'          => !empty($name) ? $name : 'Sensor ' . $serial,
                    'user_id'       => $userId,
                    'mode'          => 'AUTO',
                    'is_pump_on'    => false,
                ]);
                $createdCount++;
            }
        }

        $msg = "Selesai! {$createdCount} perangkat baru berhasil didaftarkan dan {$updatedCount} perangkat diperbarui ke akun Anda.";
        if ($failedCount > 0) {
            $msg .= " ({$failedCount} baris dilewati karena tidak valid atau terdaftar di akun lain).";
        }

        return redirect()->route('layanan.index')->with('success', $msg);
    }

    // Update Nama dan PIN Perangkat oleh Pekebun
    public function updateDevice(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $deviceQuery = Device::where('id', $id);
        if (Auth::user()->role !== 'admin') {
            $deviceQuery->where('user_id', Auth::id());
        }
        $device = $deviceQuery->firstOrFail();

        $request->validate([
            'name'          => 'required|string|max:150',
            'pin_code'      => 'required|string|max:50',
            'serial_number' => 'nullable|string|max:100|unique:devices,serial_number,' . $device->id,
        ]);

        $data = [
            'name'     => trim($request->name),
            'pin_code' => trim($request->pin_code),
        ];

        if ($request->filled('serial_number')) {
            $data['serial_number'] = trim($request->serial_number);
        }

        $device->update($data);

        return redirect()->route('layanan.index')->with('success', "Perangkat {$device->serial_number} ({$device->name}) berhasil diperbarui!");
    }

    // Hapus / Putuskan Perangkat oleh Pekebun
    public function destroyDevice($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $deviceQuery = Device::where('id', $id);
        if (Auth::user()->role !== 'admin') {
            $deviceQuery->where('user_id', Auth::id());
        }
        $device = $deviceQuery->firstOrFail();

        $serial = $device->serial_number;
        $device->sensorData()->delete();
        $device->delete();

        return redirect()->route('layanan.index')->with('success', "Perangkat {$serial} berhasil dihapus dari sistem.");
    }

    // =========================================================================
    // BAGIAN 4: ENDPOINT DATA (ESP32 & AJAX REALTIME)
    // =========================================================================

    // 1. Endpoint untuk ESP32 Mengirim Data (WAJIB PUBLIC)
    public function receiveData(Request $request)
    {
        // Validasi Input agar tidak error SQL
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required|exists:devices,serial_number',
            'moisture' => 'required|numeric',
            'temperature' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
        }

        $device = Device::where('serial_number', $request->serial_number)->first();

        if ($device) {
            SensorData::create([
                'device_id' => $device->id,
                'moisture' => $request->moisture,
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
            ]);

            // Smart Automation: Dalam mode AUTO, nyalakan pompa jika tanah kering (< 40%)
            // dan matikan pompa jika kelembapan tanah sudah optimal (>= 60%)
            if ($device->mode === 'AUTO') {
                if ($request->moisture < 40 && !$device->is_pump_on) {
                    $device->is_pump_on = true;
                    $device->save();
                } elseif ($request->moisture >= 60 && $device->is_pump_on) {
                    $device->is_pump_on = false;
                    $device->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'mode' => $device->mode,
                'pump' => $device->is_pump_on ? 'ON' : 'OFF'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Device not found'], 404);
    }

    // 2. Endpoint Khusus AJAX (Agar Web Update Tanpa Refresh)
    public function getLatestData($serial_number)
    {
        // Cari alat user (Wajib Login)
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $deviceQuery = Device::where('serial_number', $serial_number);
        if (Auth::user()->role !== 'admin') {
            $deviceQuery->where('user_id', Auth::id());
        }
        $device = $deviceQuery->with('latestSensorData')->first();

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $sensor = $device->latestSensorData;

        return response()->json([
            'moisture' => $sensor ? $sensor->moisture : 0,
            'temperature' => $sensor ? $sensor->temperature : 0,
            'humidity' => $sensor ? $sensor->humidity : 0,
            'pump_status' => $device->is_pump_on ? 'HIDUP' : 'MATI',
            'last_update' => ($sensor && $sensor->created_at) ? $sensor->created_at->diffForHumans() : '-'
        ]);
    }
}

