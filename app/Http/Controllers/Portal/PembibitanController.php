<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Bibit;
use App\Models\PengadaanBibit;
use App\Models\JadwalPerawatanBibit;
use App\Models\MonitoringBibit;
use App\Models\Lahan;
use App\Models\PohonDurian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PembibitanController extends Controller
{
    private function menuItems(): array
    {
        return [
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                'label' => 'Dashboard',
                'route' => 'portal.pembibitan.dashboard',
                'match' => 'portal.pembibitan.dashboard',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                'label' => 'Data Bibit',
                'route' => 'portal.pembibitan.bibit.index',
                'match' => 'portal.pembibitan.bibit.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                'label' => 'Pengadaan Bibit',
                'route' => 'portal.pembibitan.pengadaan.index',
                'match' => 'portal.pembibitan.pengadaan.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                'label' => 'Monitoring Bibit',
                'route' => 'portal.pembibitan.monitoring.index',
                'match' => 'portal.pembibitan.monitoring.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                'label' => 'Jadwal Perawatan',
                'route' => 'portal.pembibitan.jadwal.index',
                'match' => 'portal.pembibitan.jadwal.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                'label' => 'Laporan Pembibitan',
                'route' => 'portal.pembibitan.laporan',
                'match' => 'portal.pembibitan.laporan',
            ],
        ];
    }

    public function dashboard()
    {
        $userId = Auth::id();

        $stats = [
            'total_bibit'       => (int) Bibit::where('user_id', $userId)->whereNotIn('status', ['mati', 'ditanam'])->where('jumlah', '>', 0)->sum('jumlah'),
            'bibit_aktif'       => (int) Bibit::where('user_id', $userId)->where('status', 'aktif')->where('jumlah', '>', 0)->sum('jumlah'),
            'bibit_sehat'       => (int) Bibit::where('user_id', $userId)->whereNotIn('status', ['mati', 'ditanam'])->where('jumlah', '>', 0)->where('kondisi', 'sehat')->sum('jumlah'),
            'bibit_perawatan'   => (int) Bibit::where('user_id', $userId)->where('status', 'perawatan')->where('jumlah', '>', 0)->sum('jumlah'),
            'bibit_siap_tanam'  => (int) Bibit::where('user_id', $userId)->where('status', 'siap_tanam')->where('jumlah', '>', 0)->sum('jumlah'),
        ];

        // Jadwal perawatan pending diurutkan tanggal paling dekat (termasuk hari ini / terlewat)
        $jadwalHariIni = JadwalPerawatanBibit::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('bibit')
            ->orderBy('tanggal_jadwal', 'asc')
            ->take(5)
            ->get();

        // Bibit yang memerlukan perhatian (kondisi kritis / kurang sehat, belum mati/ditanam)
        $bibitPerhatian = Bibit::where('user_id', $userId)
            ->whereNotIn('status', ['mati', 'ditanam'])
            ->where('jumlah', '>', 0)
            ->whereIn('kondisi', ['kritis', 'kurang_sehat'])
            ->orderByRaw("CASE WHEN kondisi = 'kritis' THEN 1 WHEN kondisi = 'kurang_sehat' THEN 2 ELSE 3 END")
            ->take(5)
            ->get();

        $aktivitasTerbaru = MonitoringBibit::where('user_id', $userId)
            ->with('bibit')
            ->latest()
            ->take(5)
            ->get();

        $pengadaanTerbaru = PengadaanBibit::where('user_id', $userId)
            ->latest()
            ->take(4)
            ->get();

        return view('portal.pembibitan.dashboard', [
            'menuItems'        => $this->menuItems(),
            'stats'            => $stats,
            'jadwalHariIni'    => $jadwalHariIni,
            'bibitPerhatian'   => $bibitPerhatian,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'pengadaanTerbaru' => $pengadaanTerbaru,
        ]);
    }

    // ── Data Bibit ──────────────────────────────────────────────
    public function bibitIndex(Request $request)
    {
        $query = Bibit::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: hanya tampilkan bibit yang masih aktif di persemaian (belum habis ditanam ke lahan)
            $query->whereNotIn('status', ['ditanam'])->where('jumlah', '>', 0);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nama_varietas', 'like', "%{$s}%")
                  ->orWhere('kode_bibit', 'like', "%{$s}%");
            });
        }

        $bibit = $query->latest()->paginate(15)->withQueryString();

        return view('portal.pembibitan.bibit.index', [
            'menuItems'      => $this->menuItems(),
            'bibit'          => $bibit,
            'currentStatus'  => $request->status,
            'currentKondisi' => $request->kondisi,
            'search'         => $request->search,
        ]);
    }

    public function getStandardVarietas(): array
    {
        return [
            'Musang King (D197)',
            'Duri Hitam / Ochee (D200)',
            'Bawor Banyumas',
            'Super Tembaga Bangka',
            'Montong Kani',
            'Petruk Jepara',
            'Namlung / Cumasi',
            'Matahari',
            'Pelangi Papua',
        ];
    }

    public function getStandardSuppliers(): array
    {
        $defaults = [
            'PT Benih Unggul Nusantara',
            'Balai Benih Tanaman Hortikultura (BBTH)',
            'Sentra Bibit Durian Majalengka',
            'Penangkar Bibit Durian Banyumas',
            'Balitbu Tropika Solok',
            'Sertifikasi Penangkar Jawa Timur',
            'CV Tani Makmur Sejahtera',
            'Penangkar Bibit Lokal Mandiri',
        ];
        $existing = PengadaanBibit::where('user_id', Auth::id())->pluck('nama_supplier')->filter()->unique()->toArray();
        return array_values(array_unique(array_merge($defaults, $existing)));
    }

    public function getStandardAsalBenih(): array
    {
        return [
            'Okulasi Mata Tempel Bersertifikat',
            'Sambung Pucuk (Top Grafting) Resmi',
            'Sertifikasi Penangkar Resmi BBTH',
            'Kultur Jaringan Terverifikasi',
            'Indukan Pohon Juara Kontes',
            'Semai Biji Pilihan (Rootstock)',
        ];
    }

    public function bibitCreate()
    {
        return view('portal.pembibitan.bibit.create', [
            'menuItems'       => $this->menuItems(),
            'varietasList'    => $this->getStandardVarietas(),
            'asalBenihList'   => $this->getStandardAsalBenih(),
        ]);
    }

    public function bibitStore(Request $request)
    {
        $data = $request->validate([
            'kode_bibit'     => 'required|string|max:50',
            'nama_varietas'  => 'required|string|max:100',
            'asal_benih'     => 'nullable|string|max:200',
            'jumlah'         => 'nullable|integer|min:1',
            'status'         => 'required|in:aktif,perawatan,siap_tanam,mati',
            'kondisi'        => 'required|in:sehat,kurang_sehat,kritis',
            'tanggal_semai'  => 'nullable|date',
            'catatan'        => 'nullable|string',
        ]);

        // 1 Kode Tag = 1 Bibit Tanaman Individual
        $data['jumlah'] = $data['jumlah'] ?? 1;
        $data['user_id'] = Auth::id();
        Bibit::create($data);

        return redirect()->route('portal.pembibitan.bibit.index')
            ->with('success', 'Data bibit berhasil ditambahkan.');
    }

    public function bibitEdit(Bibit $bibit)
    {
        abort_if($bibit->user_id !== Auth::id(), 403);
        return view('portal.pembibitan.bibit.edit', [
            'menuItems'     => $this->menuItems(),
            'bibit'         => $bibit,
            'varietasList'  => $this->getStandardVarietas(),
            'asalBenihList' => $this->getStandardAsalBenih(),
        ]);
    }

    public function bibitUpdate(Request $request, Bibit $bibit)
    {
        abort_if($bibit->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'kode_bibit'     => 'required|string|max:50',
            'nama_varietas'  => 'required|string|max:100',
            'asal_benih'     => 'nullable|string|max:200',
            'jumlah'         => 'nullable|integer|min:1',
            'status'         => 'required|in:aktif,perawatan,siap_tanam,mati',
            'kondisi'        => 'required|in:sehat,kurang_sehat,kritis',
            'tanggal_semai'  => 'nullable|date',
            'catatan'        => 'nullable|string',
        ]);

        $data['jumlah'] = $data['jumlah'] ?? $bibit->jumlah ?? 1;
        $bibit->update($data);
        return redirect()->route('portal.pembibitan.bibit.index')
            ->with('success', 'Data bibit berhasil diperbarui.');
    }

    public function bibitDestroy(Bibit $bibit)
    {
        abort_if($bibit->user_id !== Auth::id(), 403);
        $bibit->delete();
        return back()->with('success', 'Data bibit dihapus.');
    }

    public function tanamCreate(Bibit $bibit)
    {
        abort_if($bibit->user_id !== Auth::id(), 403);
        if ($bibit->status !== 'siap_tanam') {
            return redirect()->route('portal.pembibitan.bibit.index')->withErrors(['Tanam' => 'Bibit belum berstatus Siap Tanam!']);
        }
        $lahanList = Lahan::where('user_id', Auth::id())->get();
        $menuItems = $this->menuItems();
        $pageTitle = 'Tanam Bibit ke Lahan';
        return view('portal.pembibitan.bibit.tanam', compact('bibit', 'lahanList', 'menuItems', 'pageTitle'));
    }

    public function tanamStore(Request $request, Bibit $bibit)
    {
        abort_if($bibit->user_id !== Auth::id(), 403);
        
        $request->validate([
            'jumlah'        => 'required|integer|min:1|max:'.$bibit->jumlah,
            'lahan_id'      => [
                'required',
                Rule::exists('lahan', 'id')->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
            'tanggal_tanam' => 'required|date',
            'lokasi'        => 'nullable|string|max:200',
            'catatan'       => 'nullable|string',
        ]);

        $bibit->decrement('jumlah', $request->jumlah);
        $bibit->refresh();
        if ($bibit->jumlah <= 0) {
            $bibit->update(['status' => 'ditanam']); 
        }

        $lahan = Lahan::where('id', $request->lahan_id)->where('user_id', Auth::id())->firstOrFail();
        
        for ($i = 0; $i < $request->jumlah; $i++) {
            $count = PohonDurian::where('user_id', Auth::id())->count() + 1;
            PohonDurian::create([
                'user_id'       => Auth::id(),
                'kode_pohon'    => 'PD-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $bibit->nama_varietas), 0, 3)),
                'nama_varietas' => $bibit->nama_varietas,
                'lahan_id'      => $lahan->id,
                'bibit_id'      => $bibit->id,
                'lokasi'        => $request->lokasi ?: ($lahan->nama_lahan . ($lahan->lokasi ? ' - ' . $lahan->lokasi : '')),
                'fase'          => 'bibit',
                'kondisi'       => $bibit->kondisi === 'kritis' ? 'bermasalah' : ($bibit->kondisi === 'kurang_sehat' ? 'perawatan' : 'sehat'),
                'tanggal_tanam' => $request->tanggal_tanam,
                'catatan'       => $request->catatan ?: ('Hasil tanam dari bibit: ' . $bibit->kode_bibit),
            ]);
        }

        $lahan->increment('jumlah_pohon', $request->jumlah);

        return redirect()->route('portal.pertumbuhan.pohon.index')->with('success', $request->jumlah . ' bibit berhasil ditanam dan beralih menjadi pohon di Portal Pertumbuhan!');
    }

    // ── Pengadaan Bibit ─────────────────────────────────────────
    public function pengadaanIndex()
    {
        $pengadaan = PengadaanBibit::where('user_id', Auth::id())->latest()->paginate(15);
        return view('portal.pembibitan.pengadaan.index', ['menuItems' => $this->menuItems(), 'pengadaan' => $pengadaan]);
    }

    public function pengadaanCreate()
    {
        return view('portal.pembibitan.pengadaan.create', [
            'menuItems'    => $this->menuItems(),
            'varietasList' => $this->getStandardVarietas(),
            'supplierList' => $this->getStandardSuppliers(),
        ]);
    }

    public function pengadaanStore(Request $request)
    {
        $data = $request->validate([
            'nama_supplier'  => 'required|string|max:150',
            'nama_varietas'  => 'required|string|max:100',
            'jumlah'         => 'required|integer|min:1',
            'harga_satuan'   => 'required|numeric|min:0',
            'tanggal'        => 'required|date',
            'catatan'        => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        PengadaanBibit::create($data);

        // Auto-tambah ke inventaris Bibit
        $existingBibit = Bibit::where('user_id', Auth::id())->where('nama_varietas', $data['nama_varietas'])->first();
        if ($existingBibit) {
            $existingBibit->increment('jumlah', $data['jumlah']);
        } else {
            $count = Bibit::where('user_id', Auth::id())->count() + 1;
            Bibit::create([
                'user_id'       => Auth::id(),
                'kode_bibit'    => 'BIB-' . str_pad($count, 4, '0', STR_PAD_LEFT),
                'nama_varietas' => $data['nama_varietas'],
                'asal_benih'    => 'Pengadaan: ' . $data['nama_supplier'],
                'tanggal_semai' => $data['tanggal'],
                'jumlah'        => $data['jumlah'],
                'kondisi'       => 'sehat',
                'status'        => 'aktif',
            ]);
        }
        return redirect()->route('portal.pembibitan.pengadaan.index')
            ->with('success', 'Pengadaan bibit berhasil dicatat.');
    }

    public function pengadaanEdit(PengadaanBibit $pengadaan)
    {
        abort_if($pengadaan->user_id !== Auth::id(), 403);
        return view('portal.pembibitan.pengadaan.edit', [
            'menuItems'    => $this->menuItems(),
            'pengadaan'    => $pengadaan,
            'varietasList' => $this->getStandardVarietas(),
            'supplierList' => $this->getStandardSuppliers(),
        ]);
    }

    public function pengadaanUpdate(Request $request, PengadaanBibit $pengadaan)
    {
        abort_if($pengadaan->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'nama_supplier'  => 'required|string|max:150',
            'nama_varietas'  => 'required|string|max:100',
            'jumlah'         => 'required|integer|min:1',
            'harga_satuan'   => 'required|numeric|min:0',
            'tanggal'        => 'required|date',
            'catatan'        => 'nullable|string',
        ]);
        $pengadaan->update($data);
        return redirect()->route('portal.pembibitan.pengadaan.index')
            ->with('success', 'Data pengadaan bibit berhasil diperbarui.');
    }

    public function pengadaanDestroy(PengadaanBibit $pengadaan)
    {
        abort_if($pengadaan->user_id !== Auth::id(), 403);
        $pengadaan->delete();
        return back()->with('success', 'Data pengadaan berhasil dihapus.');
    }

    // ── Monitoring ───────────────────────────────────────────────
    public function monitoringIndex()
    {
        $monitoring = MonitoringBibit::where('user_id', Auth::id())->with('bibit')->latest()->paginate(15);
        return view('portal.pembibitan.monitoring.index', ['menuItems' => $this->menuItems(), 'monitoring' => $monitoring]);
    }

    public function monitoringCreate()
    {
        $bibitList = Bibit::where('user_id', Auth::id())->where('status', '!=', 'mati')->get();
        return view('portal.pembibitan.monitoring.create', ['menuItems' => $this->menuItems(), 'bibitList' => $bibitList]);
    }

    public function monitoringStore(Request $request)
    {
        $data = $request->validate([
            'bibit_id'      => 'required|exists:bibit,id',
            'tinggi_cm'     => 'nullable|numeric|min:0',
            'kondisi'       => 'required|in:sehat,kurang_sehat,kritis',
            'catatan'       => 'nullable|string',
            'tanggal'       => 'required|date',
        ]);
        $data['user_id'] = Auth::id();
        MonitoringBibit::create($data);

        // Update kondisi bibit
        Bibit::where('id', $data['bibit_id'])->update(['kondisi' => $data['kondisi']]);

        return redirect()->route('portal.pembibitan.monitoring.index')
            ->with('success', 'Data monitoring berhasil dicatat.');
    }

    public function monitoringEdit(MonitoringBibit $monitoring)
    {
        abort_if($monitoring->user_id !== Auth::id(), 403);
        $bibitList = Bibit::where('user_id', Auth::id())->where('status', '!=', 'mati')->get();
        return view('portal.pembibitan.monitoring.edit', [
            'menuItems'  => $this->menuItems(),
            'monitoring' => $monitoring,
            'bibitList'  => $bibitList,
        ]);
    }

    public function monitoringUpdate(Request $request, MonitoringBibit $monitoring)
    {
        abort_if($monitoring->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'bibit_id'      => 'required|exists:bibit,id',
            'tinggi_cm'     => 'nullable|numeric|min:0',
            'kondisi'       => 'required|in:sehat,kurang_sehat,kritis',
            'catatan'       => 'nullable|string',
            'tanggal'       => 'required|date',
        ]);
        $monitoring->update($data);
        Bibit::where('id', $data['bibit_id'])->update(['kondisi' => $data['kondisi']]);

        return redirect()->route('portal.pembibitan.monitoring.index')
            ->with('success', 'Data monitoring berhasil diperbarui.');
    }

    public function monitoringDestroy(MonitoringBibit $monitoring)
    {
        abort_if($monitoring->user_id !== Auth::id(), 403);
        $monitoring->delete();
        return back()->with('success', 'Data monitoring berhasil dihapus.');
    }

    // ── Jadwal Perawatan ─────────────────────────────────────────
    public function jadwalIndex()
    {
        $jadwal = JadwalPerawatanBibit::where('user_id', Auth::id())->with('bibit')->latest()->paginate(15);
        return view('portal.pembibitan.jadwal.index', ['menuItems' => $this->menuItems(), 'jadwal' => $jadwal]);
    }

    public function jadwalCreate()
    {
        $bibitList = Bibit::where('user_id', Auth::id())->where('status', '!=', 'mati')->get();
        return view('portal.pembibitan.jadwal.create', ['menuItems' => $this->menuItems(), 'bibitList' => $bibitList]);
    }

    public function jadwalStore(Request $request)
    {
        $data = $request->validate([
            'bibit_id'        => 'required|exists:bibit,id',
            'jenis_perawatan' => 'required|string|max:150',
            'tanggal_jadwal'  => 'required|date',
            'catatan'         => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        JadwalPerawatanBibit::create($data);
        return redirect()->route('portal.pembibitan.jadwal.index')
            ->with('success', 'Jadwal perawatan berhasil ditambahkan.');
    }

    public function jadwalEdit(JadwalPerawatanBibit $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $bibitList = Bibit::where('user_id', Auth::id())->where('status', '!=', 'mati')->get();
        return view('portal.pembibitan.jadwal.edit', [
            'menuItems' => $this->menuItems(),
            'jadwal'    => $jadwal,
            'bibitList' => $bibitList,
        ]);
    }

    public function jadwalUpdate(Request $request, JadwalPerawatanBibit $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'bibit_id'        => 'required|exists:bibit,id',
            'jenis_perawatan' => 'required|string|max:150',
            'tanggal_jadwal'  => 'required|date',
            'status'          => 'required|in:pending,selesai,batal',
            'catatan'         => 'nullable|string',
        ]);
        $jadwal->update($data);
        return redirect()->route('portal.pembibitan.jadwal.index')
            ->with('success', 'Jadwal perawatan berhasil diperbarui.');
    }

    public function jadwalDestroy(JadwalPerawatanBibit $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $jadwal->delete();
        return back()->with('success', 'Jadwal perawatan berhasil dihapus.');
    }

    public function jadwalSelesai(JadwalPerawatanBibit $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $jadwal->update(['status' => 'selesai']);
        return back()->with('success', 'Jadwal ditandai selesai.');
    }

    // ── Laporan ──────────────────────────────────────────────────
    public function laporan()
    {
        $userId = Auth::id();
        $rekapStatus = Bibit::where('user_id', $userId)->selectRaw('status, SUM(jumlah) as total')->groupBy('status')->get();
        $rekapKondisi = Bibit::where('user_id', $userId)->selectRaw('kondisi, SUM(jumlah) as total')->groupBy('kondisi')->get();
        $pengadaanBulanIni = PengadaanBibit::where('user_id', $userId)->whereMonth('tanggal', now()->month)->sum('jumlah');

        return view('portal.pembibitan.laporan', [
            'menuItems'         => $this->menuItems(),
            'rekapStatus'       => $rekapStatus,
            'rekapKondisi'      => $rekapKondisi,
            'pengadaanBulanIni' => $pengadaanBulanIni,
        ]);
    }
}

