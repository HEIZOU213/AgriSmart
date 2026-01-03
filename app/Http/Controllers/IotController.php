<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Support\Facades\Auth;
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
            $userRole = $user->role ?? 'konsumen'; // Default jika null

            // Hanya ambil devices untuk petani/admin
            if (in_array($userRole, ['petani', 'admin'])) {
                $myDevices = Device::where('user_id', $user->id)->get();
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

        if (Auth::user()->role !== 'admin' && $device->user_id !== Auth::id()) {
            return redirect()->route('layanan.index')->with('error', 'Anda tidak memiliki akses ke alat ini.');
        }

        return view('layanan.show', compact('device'));
    }

    // =========================================================================
    // BAGIAN 3: LOGIC KONTROL & KLAIM (FORM ACTIONS)
    // =========================================================================

    // Proses Klaim Alat (Input Serial & PIN)
    public function claimDevice(Request $request)
    {
        $request->validate([
            'serial_number' => 'required',
            'pin_code' => 'required',
            'name' => 'required',
        ]);

        $device = Device::where('serial_number', $request->serial_number)
            ->where('pin_code', $request->pin_code)
            ->first();

        if (!$device) {
            return back()->with('error', 'Kode Serial atau PIN salah! Silakan cek stiker di alat.');
        }

        if ($device->user_id) {
            return back()->with('error', 'Alat ini sudah terdaftar milik orang lain!');
        }

        $device->update([
            'user_id' => Auth::id(),
            'name' => $request->name
        ]);

        return redirect()->route('layanan.show', $device->serial_number)
            ->with('success', 'Alat berhasil dihubungkan! Selamat memantau.');
    }

    // Tombol ON/OFF Pompa (Manual Mode)
    public function togglePump($id)
    {
        $device = Device::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $device->is_pump_on = !$device->is_pump_on;
        $device->mode = 'MANUAL'; // Jika user menekan tombol, otomatis jadi Manual
        $device->save();

        return back()->with('success', 'Status pompa berhasil diubah.');
    }

    // Tombol Kembali ke Mode AUTO
    public function setAuto($id)
    {
        $device = Device::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $device->mode = 'AUTO';
        $device->save();

        return back()->with('success', 'Alat kembali ke mode Otomatis.');
    }

    // [BARU] Tombol Switch ke Mode MANUAL
    public function manual($id)
    {
        $device = Device::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $device->mode = 'MANUAL';
        $device->save();

        return back()->with('success', 'Alat berhasil diubah ke mode Manual.');
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

        $device = Device::where('serial_number', $serial_number)
            ->where('user_id', Auth::id())
            ->with('latestSensorData')
            ->first();

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $sensor = $device->latestSensorData;

        return response()->json([
            'moisture' => $sensor ? $sensor->moisture : 0,
            'temperature' => $sensor ? $sensor->temperature : 0,
            'humidity' => $sensor ? $sensor->humidity : 0,
            'pump_status' => $device->is_pump_on ? 'HIDUP' : 'MATI',
            'last_update' => $sensor ? $sensor->created_at->diffForHumans() : '-'
        ]);
    }
}