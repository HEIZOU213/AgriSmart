<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\PohonDurian;
use App\Models\MonitoringPertumbuhan;
use App\Models\JadwalPerawatanPohon;
use App\Models\Lahan;
use App\Models\Bibit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PertumbuhanController extends Controller
{
    private function menuItems(): array
    {
        return [
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                'label' => 'Dashboard',
                'route' => 'portal.pertumbuhan.dashboard',
                'match' => 'portal.pertumbuhan.dashboard',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
                'label' => 'Data Pohon',
                'route' => 'portal.pertumbuhan.pohon.index',
                'match' => 'portal.pertumbuhan.pohon.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
                'label' => 'Fase Pohon',
                'route' => 'portal.pertumbuhan.fase',
                'match' => 'portal.pertumbuhan.fase',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                'label' => 'Monitoring',
                'route' => 'portal.pertumbuhan.monitoring.index',
                'match' => 'portal.pertumbuhan.monitoring.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                'label' => 'Jadwal Perawatan',
                'route' => 'portal.pertumbuhan.jadwal.index',
                'match' => 'portal.pertumbuhan.jadwal.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                'label' => 'Laporan Pertumbuhan',
                'route' => 'portal.pertumbuhan.laporan',
                'match' => 'portal.pertumbuhan.laporan',
            ],
        ];
    }

    public function dashboard()
    {
        $userId = Auth::id();

        $stats = [
            'total_pohon'      => (int) PohonDurian::where('user_id', $userId)->count(),
            'pohon_sehat'      => (int) PohonDurian::where('user_id', $userId)->where('kondisi', 'sehat')->count(),
            'pohon_perawatan'  => (int) PohonDurian::where('user_id', $userId)->where('kondisi', 'perawatan')->count(),
            'pohon_produktif'  => (int) PohonDurian::where('user_id', $userId)->where('fase', 'produktif')->count(),
            'pohon_bermasalah' => (int) PohonDurian::where('user_id', $userId)->where('kondisi', 'bermasalah')->count(),
        ];

        // Jadwal perawatan pending diurutkan dari tanggal paling dekat
        $jadwalHariIni = JadwalPerawatanPohon::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('pohon')
            ->orderBy('tanggal_jadwal', 'asc')
            ->take(5)
            ->get();

        // Pohon yang memerlukan perhatian khusus (bermasalah atau dalam perawatan)
        $pohonPerhatian = PohonDurian::where('user_id', $userId)
            ->whereIn('kondisi', ['bermasalah', 'perawatan'])
            ->orderByRaw("CASE WHEN kondisi = 'bermasalah' THEN 1 WHEN kondisi = 'perawatan' THEN 2 ELSE 3 END")
            ->with('lahan')
            ->take(5)
            ->get();

        $monitoringTerbaru = MonitoringPertumbuhan::where('user_id', $userId)
            ->with('pohon')
            ->latest()
            ->take(5)
            ->get();

        $faseSummary = PohonDurian::where('user_id', $userId)
            ->selectRaw('fase, COUNT(*) as total')
            ->groupBy('fase')
            ->get();

        return view('portal.pertumbuhan.dashboard', [
            'menuItems'         => $this->menuItems(),
            'stats'             => $stats,
            'jadwalHariIni'     => $jadwalHariIni,
            'pohonPerhatian'    => $pohonPerhatian,
            'monitoringTerbaru' => $monitoringTerbaru,
            'faseSummary'       => $faseSummary,
        ]);
    }

    // ── Data Pohon ───────────────────────────────────────────────
    public function pohonIndex(Request $request)
    {
        $query = PohonDurian::where('user_id', Auth::id())->with('lahan');

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('fase')) {
            $query->where('fase', $request->fase);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_varietas', 'like', "%{$s}%")
                  ->orWhere('kode_pohon', 'like', "%{$s}%")
                  ->orWhere('lokasi', 'like', "%{$s}%");
            });
        }

        $pohon = $query->latest()->paginate(15)->withQueryString();

        return view('portal.pertumbuhan.pohon.index', [
            'menuItems'      => $this->menuItems(),
            'pohon'          => $pohon,
            'currentKondisi' => $request->kondisi,
            'currentFase'    => $request->fase,
            'search'         => $request->search,
        ]);
    }

    public function pohonCreate()
    {
        $userId = Auth::id();
        $lahanList = Lahan::where('user_id', $userId)->get();
        $bibitSiapTanam = Bibit::where('user_id', $userId)
            ->where('status', 'siap_tanam')
            ->where('jumlah', '>', 0)
            ->get();

        return view('portal.pertumbuhan.pohon.create', [
            'menuItems'      => $this->menuItems(),
            'lahanList'      => $lahanList,
            'bibitSiapTanam' => $bibitSiapTanam,
        ]);
    }

    public function pohonStore(Request $request)
    {
        // 1. Alur Terintegrasi: Tanam pohon bersumber dari Bibit Siap Tanam di Pembibitan
        if ($request->filled('bibit_id')) {
            $request->validate([
                'bibit_id'      => [
                    'required',
                    Rule::exists('bibit', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
                ],
                'lahan_id'      => [
                    'required',
                    Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
                ],
                'jumlah'        => 'required|integer|min:1',
                'tanggal_tanam' => 'required|date',
                'lokasi'        => 'nullable|string|max:200',
                'catatan'       => 'nullable|string',
            ]);

            $bibit = Bibit::where('id', $request->bibit_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            if ($request->jumlah > $bibit->jumlah) {
                return back()->withErrors(['jumlah' => "Jumlah ditanam ({$request->jumlah}) melebihi stok bibit siap tanam yang tersedia ({$bibit->jumlah})."])->withInput();
            }

            // Kurangi stok bibit
            $bibit->decrement('jumlah', $request->jumlah);
            $bibit->refresh();

            // Jika stok bibit habis, status beralih menjadi 'ditanam' (otomatis hilang dari daftar aktif pembibitan)
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

            return redirect()->route('portal.pertumbuhan.pohon.index')
                ->with('success', "{$request->jumlah} bibit {$bibit->nama_varietas} berhasil ditanam ke lahan dan aktif di Portal Pertumbuhan!");
        }

        // 2. Fallback untuk kompatibilitas input langsung / test cases
        $data = $request->validate([
            'kode_pohon'    => 'required|string|max:50',
            'nama_varietas' => 'required|string|max:100',
            'lokasi'        => 'nullable|string|max:200',
            'lahan_id'      => [
                'nullable',
                Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'fase'          => 'required|in:bibit,vegetatif,generatif,produktif',
            'kondisi'       => 'required|in:sehat,perawatan,bermasalah',
            'tanggal_tanam' => 'nullable|date',
            'catatan'       => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        $pohon = PohonDurian::create($data);
        if ($pohon->lahan_id) {
            Lahan::where('id', $pohon->lahan_id)->increment('jumlah_pohon');
        }
        return redirect()->route('portal.pertumbuhan.pohon.index')
            ->with('success', 'Data pohon berhasil ditambahkan.');
    }

    public function pohonEdit(PohonDurian $pohon)
    {
        abort_if($pohon->user_id !== Auth::id(), 403);
        $lahanList = Lahan::where('user_id', Auth::id())->get();
        return view('portal.pertumbuhan.pohon.edit', ['menuItems' => $this->menuItems(), 'pohon' => $pohon, 'lahanList' => $lahanList]);
    }

    public function pohonUpdate(Request $request, PohonDurian $pohon)
    {
        abort_if($pohon->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'kode_pohon'    => 'required|string|max:50',
            'nama_varietas' => 'required|string|max:100',
            'lokasi'        => 'nullable|string|max:200',
            'lahan_id'      => [
                'nullable',
                Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'fase'          => 'required|in:bibit,vegetatif,generatif,produktif',
            'kondisi'       => 'required|in:sehat,perawatan,bermasalah',
            'tanggal_tanam' => 'nullable|date',
            'catatan'       => 'nullable|string',
        ]);
        $oldLahan = $pohon->lahan_id;
        $pohon->update($data);
        if ($oldLahan !== $pohon->lahan_id) {
            if ($oldLahan) Lahan::where('id', $oldLahan)->decrement('jumlah_pohon');
            if ($pohon->lahan_id) Lahan::where('id', $pohon->lahan_id)->increment('jumlah_pohon');
        }
        return redirect()->route('portal.pertumbuhan.pohon.index')
            ->with('success', 'Data pohon berhasil diperbarui.');
    }

    public function pohonDestroy(PohonDurian $pohon)
    {
        abort_if($pohon->user_id !== Auth::id(), 403);
        if ($pohon->lahan_id) {
            Lahan::where('id', $pohon->lahan_id)->decrement('jumlah_pohon');
        }
        $pohon->delete();
        return back()->with('success', 'Data pohon dihapus.');
    }

    // ── Fase ─────────────────────────────────────────────────────
    public function fase()
    {
        $userId = Auth::id();
        $pohonPerFase = [
            'bibit'      => PohonDurian::where('user_id', $userId)->where('fase', 'bibit')->get(),
            'vegetatif'  => PohonDurian::where('user_id', $userId)->where('fase', 'vegetatif')->get(),
            'generatif'  => PohonDurian::where('user_id', $userId)->where('fase', 'generatif')->get(),
            'produktif'  => PohonDurian::where('user_id', $userId)->where('fase', 'produktif')->get(),
        ];
        return view('portal.pertumbuhan.fase', ['menuItems' => $this->menuItems(), 'pohonPerFase' => $pohonPerFase]);
    }

    // ── Monitoring ───────────────────────────────────────────────
    public function monitoringIndex()
    {
        $monitoring = MonitoringPertumbuhan::where('user_id', Auth::id())->with('pohon')->latest()->paginate(15);
        return view('portal.pertumbuhan.monitoring.index', ['menuItems' => $this->menuItems(), 'monitoring' => $monitoring]);
    }

    public function monitoringCreate()
    {
        $pohonList = PohonDurian::where('user_id', Auth::id())->get();
        return view('portal.pertumbuhan.monitoring.create', ['menuItems' => $this->menuItems(), 'pohonList' => $pohonList]);
    }

    public function monitoringStore(Request $request)
    {
        $data = $request->validate([
            'pohon_id'         => [
                'required',
                Rule::exists('pohon_durian', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'tinggi_cm'        => 'nullable|numeric|min:0',
            'diameter_batang'  => 'nullable|numeric|min:0',
            'jumlah_cabang'    => 'nullable|integer|min:0',
            'kondisi'          => 'required|in:sehat,perawatan,bermasalah',
            'catatan'          => 'nullable|string',
            'tanggal'          => 'required|date',
        ]);
        $data['user_id'] = Auth::id();
        MonitoringPertumbuhan::create($data);
        PohonDurian::where('id', $data['pohon_id'])->update(['kondisi' => $data['kondisi']]);
        return redirect()->route('portal.pertumbuhan.monitoring.index')
            ->with('success', 'Data monitoring berhasil dicatat.');
    }

    public function monitoringEdit(MonitoringPertumbuhan $monitoring)
    {
        abort_if($monitoring->user_id !== Auth::id(), 403);
        $pohonList = PohonDurian::where('user_id', Auth::id())->get();
        return view('portal.pertumbuhan.monitoring.edit', [
            'menuItems'  => $this->menuItems(),
            'monitoring' => $monitoring,
            'pohonList'  => $pohonList,
        ]);
    }

    public function monitoringUpdate(Request $request, MonitoringPertumbuhan $monitoring)
    {
        abort_if($monitoring->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'pohon_id'         => [
                'required',
                Rule::exists('pohon_durian', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'tinggi_cm'        => 'nullable|numeric|min:0',
            'diameter_batang'  => 'nullable|numeric|min:0',
            'jumlah_cabang'    => 'nullable|integer|min:0',
            'kondisi'          => 'required|in:sehat,perawatan,bermasalah',
            'catatan'          => 'nullable|string',
            'tanggal'          => 'required|date',
        ]);
        $monitoring->update($data);
        PohonDurian::where('id', $data['pohon_id'])->update(['kondisi' => $data['kondisi']]);
        return redirect()->route('portal.pertumbuhan.monitoring.index')
            ->with('success', 'Data monitoring berhasil diperbarui.');
    }

    public function monitoringDestroy(MonitoringPertumbuhan $monitoring)
    {
        abort_if($monitoring->user_id !== Auth::id(), 403);
        $monitoring->delete();
        return back()->with('success', 'Data monitoring berhasil dihapus.');
    }

    // ── Jadwal ───────────────────────────────────────────────────
    public function jadwalIndex()
    {
        $jadwal = JadwalPerawatanPohon::where('user_id', Auth::id())->with('pohon')->latest()->paginate(15);
        return view('portal.pertumbuhan.jadwal.index', ['menuItems' => $this->menuItems(), 'jadwal' => $jadwal]);
    }

    public function jadwalCreate()
    {
        $pohonList = PohonDurian::where('user_id', Auth::id())->get();
        return view('portal.pertumbuhan.jadwal.create', ['menuItems' => $this->menuItems(), 'pohonList' => $pohonList]);
    }

    public function jadwalStore(Request $request)
    {
        $data = $request->validate([
            'pohon_id'        => [
                'required',
                Rule::exists('pohon_durian', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'jenis_perawatan' => 'required|string|max:150',
            'tanggal_jadwal'  => 'required|date',
            'catatan'         => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        JadwalPerawatanPohon::create($data);
        return redirect()->route('portal.pertumbuhan.jadwal.index')
            ->with('success', 'Jadwal perawatan berhasil ditambahkan.');
    }

    public function jadwalEdit(JadwalPerawatanPohon $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $pohonList = PohonDurian::where('user_id', Auth::id())->get();
        return view('portal.pertumbuhan.jadwal.edit', [
            'menuItems' => $this->menuItems(),
            'jadwal'    => $jadwal,
            'pohonList' => $pohonList,
        ]);
    }

    public function jadwalUpdate(Request $request, JadwalPerawatanPohon $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'pohon_id'        => [
                'required',
                Rule::exists('pohon_durian', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'jenis_perawatan' => 'required|string|max:150',
            'tanggal_jadwal'  => 'required|date',
            'status'          => 'required|in:pending,selesai,batal',
            'catatan'         => 'nullable|string',
        ]);
        $jadwal->update($data);
        return redirect()->route('portal.pertumbuhan.jadwal.index')
            ->with('success', 'Jadwal perawatan berhasil diperbarui.');
    }

    public function jadwalDestroy(JadwalPerawatanPohon $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $jadwal->delete();
        return back()->with('success', 'Jadwal perawatan berhasil dihapus.');
    }

    public function jadwalSelesai(JadwalPerawatanPohon $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $jadwal->update(['status' => 'selesai']);
        return back()->with('success', 'Jadwal ditandai selesai.');
    }

    // ── Laporan ──────────────────────────────────────────────────
    public function laporan()
    {
        $userId = Auth::id();
        $rekapFase    = PohonDurian::where('user_id', $userId)->selectRaw('fase, COUNT(*) as total')->groupBy('fase')->get();
        $rekapKondisi = PohonDurian::where('user_id', $userId)->selectRaw('kondisi, COUNT(*) as total')->groupBy('kondisi')->get();
        return view('portal.pertumbuhan.laporan', ['menuItems' => $this->menuItems(), 'rekapFase' => $rekapFase, 'rekapKondisi' => $rekapKondisi]);
    }
}




