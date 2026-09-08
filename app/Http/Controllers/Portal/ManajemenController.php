<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use App\Models\StokBarang;
use App\Models\HasilPanen;
use App\Models\BiayaOperasional;
use App\Models\JadwalKebun;
use App\Models\PohonDurian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ManajemenController extends Controller
{
    private function menuItems(): array
    {
        return [
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                'label' => 'Dashboard',
                'route' => 'portal.manajemen.dashboard',
                'match' => 'portal.manajemen.dashboard',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>',
                'label' => 'Data Lahan',
                'route' => 'portal.manajemen.lahan.index',
                'match' => 'portal.manajemen.lahan.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
                'label' => 'Inventaris Stok',
                'route' => 'portal.manajemen.stok.index',
                'match' => 'portal.manajemen.stok.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                'label' => 'Hasil Panen',
                'route' => 'portal.manajemen.panen.index',
                'match' => 'portal.manajemen.panen.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'label' => 'Biaya Operasional',
                'route' => 'portal.manajemen.biaya.index',
                'match' => 'portal.manajemen.biaya.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                'label' => 'Jadwal Kebun',
                'route' => 'portal.manajemen.jadwal.index',
                'match' => 'portal.manajemen.jadwal.*',
            ],
            [
                'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                'label' => 'Laporan',
                'route' => 'portal.manajemen.laporan',
                'match' => 'portal.manajemen.laporan',
            ],
        ];
    }

    public function dashboard()
    {
        $userId = Auth::id();

        $stats = [
            'total_lahan'       => Lahan::where('user_id', $userId)->count(),
            'total_luas_ha'     => (float) Lahan::where('user_id', $userId)->sum('luas_ha'),
            'total_pohon'       => PohonDurian::where('user_id', $userId)->count(),
            'total_stok_item'   => StokBarang::where('user_id', $userId)->count(),
            'stok_habis'        => StokBarang::where('user_id', $userId)->where('jumlah', '<=', 0)->count(),
            'stok_menipis'      => StokBarang::where('user_id', $userId)->where('jumlah', '>', 0)->where('jumlah', '<=', 5)->count(),
            'total_panen_kg'    => (float) HasilPanen::where('user_id', $userId)->sum('jumlah_kg'),
            'biaya_bulan_ini'   => (float) BiayaOperasional::where('user_id', $userId)
                                    ->whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)->sum('jumlah'),
            'pendapatan_panen'  => (float) (HasilPanen::where('user_id', $userId)
                                    ->whereMonth('tanggal_panen', now()->month)
                                    ->whereYear('tanggal_panen', now()->year)
                                    ->selectRaw('SUM(jumlah_kg * harga_per_kg) as total')->value('total') ?? 0),
            'jadwal_pending'    => JadwalKebun::where('user_id', $userId)->where('status', 'pending')->count(),
        ];

        $jadwalMendatang = JadwalKebun::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('lahan')
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        $panenTerbaru = HasilPanen::where('user_id', $userId)
            ->with(['lahan', 'pohon'])
            ->latest('tanggal_panen')
            ->take(5)
            ->get();

        $lahanList = Lahan::where('user_id', $userId)->take(6)->get();
        $stokMenipis = StokBarang::where('user_id', $userId)->where('jumlah', '<=', 5)->take(6)->get();

        return view('portal.manajemen.dashboard', [
            'menuItems'       => $this->menuItems(),
            'stats'           => $stats,
            'jadwalMendatang' => $jadwalMendatang,
            'panenTerbaru'    => $panenTerbaru,
            'lahanList'       => $lahanList,
            'lahanSummary'    => $lahanList,
            'stokMenipis'     => $stokMenipis,
        ]);
    }

    // ── Lahan ────────────────────────────────────────────────────
    public function lahanIndex()
    {
        $lahan = Lahan::where('user_id', Auth::id())->latest()->paginate(12);
        return view('portal.manajemen.lahan.index', ['menuItems' => $this->menuItems(), 'lahan' => $lahan]);
    }

    public function lahanCreate()
    {
        return view('portal.manajemen.lahan.create', ['menuItems' => $this->menuItems()]);
    }

    public function lahanStore(Request $request)
    {
        $data = $request->validate([
            'nama_lahan'    => 'required|string|max:150',
            'luas_ha'       => 'required|numeric|min:0',
            'lokasi'        => 'nullable|string|max:300',
            'kondisi'       => 'required|in:baik,sedang,buruk',
            'jumlah_pohon'  => 'nullable|integer|min:0',
            'catatan'       => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        Lahan::create($data);
        return redirect()->route('portal.manajemen.lahan.index')->with('success', 'Data lahan berhasil ditambahkan.');
    }

    public function lahanEdit(Lahan $lahan)
    {
        abort_if($lahan->user_id !== Auth::id(), 403);
        return view('portal.manajemen.lahan.edit', ['menuItems' => $this->menuItems(), 'lahan' => $lahan]);
    }

    public function lahanUpdate(Request $request, Lahan $lahan)
    {
        abort_if($lahan->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'nama_lahan'   => 'required|string|max:150',
            'luas_ha'      => 'required|numeric|min:0',
            'lokasi'       => 'nullable|string|max:300',
            'kondisi'      => 'required|in:baik,sedang,buruk',
            'jumlah_pohon' => 'nullable|integer|min:0',
            'catatan'      => 'nullable|string',
        ]);
        $lahan->update($data);
        return redirect()->route('portal.manajemen.lahan.index')->with('success', 'Data lahan diperbarui.');
    }

    public function lahanDestroy(Lahan $lahan)
    {
        abort_if($lahan->user_id !== Auth::id(), 403);
        $lahan->delete();
        return back()->with('success', 'Data lahan dihapus.');
    }

    // ── Stok Barang ──────────────────────────────────────────────
    public function stokIndex()
    {
        $stok = StokBarang::where('user_id', Auth::id())->latest()->paginate(15);
        return view('portal.manajemen.stok.index', ['menuItems' => $this->menuItems(), 'stok' => $stok]);
    }

    public function stokCreate()
    {
        return view('portal.manajemen.stok.create', ['menuItems' => $this->menuItems()]);
    }

    public function stokStore(Request $request)
    {
        $data = $request->validate([
            'nama_barang'  => 'required|string|max:150',
            'kategori'     => 'required|string|max:100',
            'jumlah'       => 'required|numeric|min:0',
            'satuan'       => 'required|string|max:30',
            'harga_satuan' => 'nullable|numeric|min:0',
            'catatan'      => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        StokBarang::create($data);
        return redirect()->route('portal.manajemen.stok.index')->with('success', 'Stok barang berhasil ditambahkan.');
    }

    public function stokEdit(StokBarang $stok)
    {
        abort_if($stok->user_id !== Auth::id(), 403);
        return view('portal.manajemen.stok.edit', ['menuItems' => $this->menuItems(), 'stok' => $stok]);
    }

    public function stokUpdate(Request $request, StokBarang $stok)
    {
        abort_if($stok->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'nama_barang'  => 'required|string|max:150',
            'kategori'     => 'required|string|max:100',
            'jumlah'       => 'required|numeric|min:0',
            'satuan'       => 'required|string|max:30',
            'harga_satuan' => 'nullable|numeric|min:0',
            'catatan'      => 'nullable|string',
        ]);
        $stok->update($data);
        return redirect()->route('portal.manajemen.stok.index')->with('success', 'Stok barang diperbarui.');
    }

    public function stokDestroy(StokBarang $stok)
    {
        abort_if($stok->user_id !== Auth::id(), 403);
        $stok->delete();
        return back()->with('success', 'Stok barang dihapus.');
    }

    // ── Hasil Panen ──────────────────────────────────────────────
    public function panenIndex()
    {
        $panen = HasilPanen::where('user_id', Auth::id())->with(['lahan', 'pohon'])->latest('tanggal_panen')->paginate(15);
        return view('portal.manajemen.panen.index', ['menuItems' => $this->menuItems(), 'panen' => $panen]);
    }

    public function panenCreate()
    {
        $userId = Auth::id();
        $lahanList = Lahan::where('user_id', $userId)->get();
        $pohonList = PohonDurian::where('user_id', $userId)
            ->with('lahan')
            ->orderByRaw("CASE WHEN fase = 'produktif' THEN 1 WHEN fase = 'generatif' THEN 2 ELSE 3 END")
            ->get();

        $varietasList = [
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

        return view('portal.manajemen.panen.create', [
            'menuItems'    => $this->menuItems(),
            'lahanList'    => $lahanList,
            'pohonList'    => $pohonList,
            'varietasList' => $varietasList,
        ]);
    }

    public function panenStore(Request $request)
    {
        $data = $request->validate([
            'lahan_id'      => [
                'nullable',
                Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'pohon_id'      => [
                'nullable',
                Rule::exists('pohon_durian', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'varietas'      => 'required|string|max:100',
            'jumlah_kg'     => 'required|numeric|min:0',
            'harga_per_kg'  => 'nullable|numeric|min:0',
            'tanggal_panen' => 'required|date',
            'catatan'       => 'nullable|string',
        ]);

        if ($request->filled('pohon_id')) {
            $pohon = PohonDurian::where('id', $request->pohon_id)->where('user_id', Auth::id())->first();
            if ($pohon) {
                if (empty($data['lahan_id']) && $pohon->lahan_id) {
                    $data['lahan_id'] = $pohon->lahan_id;
                }
                if (empty($data['varietas'])) {
                    $data['varietas'] = $pohon->nama_varietas;
                }
            }
        }

        $data['user_id'] = Auth::id();
        HasilPanen::create($data);
        return redirect()->route('portal.manajemen.panen.index')->with('success', 'Hasil panen berhasil dicatat.');
    }

    public function panenEdit(HasilPanen $panen)
    {
        abort_if($panen->user_id !== Auth::id(), 403);
        $userId = Auth::id();
        $lahanList = Lahan::where('user_id', $userId)->get();
        $pohonList = PohonDurian::where('user_id', $userId)->with('lahan')->get();
        $varietasList = [
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

        return view('portal.manajemen.panen.edit', [
            'menuItems'    => $this->menuItems(),
            'panen'        => $panen,
            'lahanList'    => $lahanList,
            'pohonList'    => $pohonList,
            'varietasList' => $varietasList,
        ]);
    }

    public function panenUpdate(Request $request, HasilPanen $panen)
    {
        abort_if($panen->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'lahan_id'      => [
                'nullable',
                Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'pohon_id'      => [
                'nullable',
                Rule::exists('pohon_durian', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'varietas'      => 'required|string|max:100',
            'jumlah_kg'     => 'required|numeric|min:0',
            'harga_per_kg'  => 'nullable|numeric|min:0',
            'tanggal_panen' => 'required|date',
            'catatan'       => 'nullable|string',
        ]);
        $panen->update($data);
        return redirect()->route('portal.manajemen.panen.index')->with('success', 'Data panen berhasil diperbarui.');
    }

    public function panenDestroy(HasilPanen $panen)
    {
        abort_if($panen->user_id !== Auth::id(), 403);
        $panen->delete();
        return back()->with('success', 'Data panen dihapus.');
    }

    // ── Biaya Operasional ────────────────────────────────────────
    public function biayaIndex()
    {
        $biaya = BiayaOperasional::where('user_id', Auth::id())->latest('tanggal')->paginate(15);
        return view('portal.manajemen.biaya.index', ['menuItems' => $this->menuItems(), 'biaya' => $biaya]);
    }

    public function biayaCreate()
    {
        return view('portal.manajemen.biaya.create', ['menuItems' => $this->menuItems()]);
    }

    public function biayaStore(Request $request)
    {
        $data = $request->validate([
            'jenis_biaya' => 'required|string|max:150',
            'jumlah'      => 'required|numeric|min:0',
            'tanggal'     => 'required|date',
            'catatan'     => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        BiayaOperasional::create($data);
        return redirect()->route('portal.manajemen.biaya.index')->with('success', 'Biaya operasional berhasil dicatat.');
    }

    public function biayaEdit(BiayaOperasional $biaya)
    {
        abort_if($biaya->user_id !== Auth::id(), 403);
        return view('portal.manajemen.biaya.edit', [
            'menuItems' => $this->menuItems(),
            'biaya'     => $biaya,
        ]);
    }

    public function biayaUpdate(Request $request, BiayaOperasional $biaya)
    {
        abort_if($biaya->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'jenis_biaya' => 'required|string|max:150',
            'jumlah'      => 'required|numeric|min:0',
            'tanggal'     => 'required|date',
            'catatan'     => 'nullable|string',
        ]);
        $biaya->update($data);
        return redirect()->route('portal.manajemen.biaya.index')->with('success', 'Biaya operasional berhasil diperbarui.');
    }

    public function biayaDestroy(BiayaOperasional $biaya)
    {
        abort_if($biaya->user_id !== Auth::id(), 403);
        $biaya->delete();
        return back()->with('success', 'Data biaya dihapus.');
    }

    // ── Jadwal Kebun ─────────────────────────────────────────────
    public function jadwalIndex()
    {
        $jadwal = JadwalKebun::where('user_id', Auth::id())->with('lahan')->orderBy('tanggal')->paginate(15);
        return view('portal.manajemen.jadwal.index', ['menuItems' => $this->menuItems(), 'jadwal' => $jadwal]);
    }

    public function jadwalCreate()
    {
        $lahanList = Lahan::where('user_id', Auth::id())->get();
        return view('portal.manajemen.jadwal.create', ['menuItems' => $this->menuItems(), 'lahanList' => $lahanList]);
    }

    public function jadwalStore(Request $request)
    {
        $data = $request->validate([
            'lahan_id'          => [
                'nullable',
                Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'jenis_aktivitas'   => 'required|string|max:150',
            'tanggal'           => 'required|date',
            'catatan'           => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        JadwalKebun::create($data);
        return redirect()->route('portal.manajemen.jadwal.index')->with('success', 'Jadwal kebun berhasil ditambahkan.');
    }

    public function jadwalEdit(JadwalKebun $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $lahanList = Lahan::where('user_id', Auth::id())->get();
        return view('portal.manajemen.jadwal.edit', [
            'menuItems' => $this->menuItems(),
            'jadwal'    => $jadwal,
            'lahanList' => $lahanList,
        ]);
    }

    public function jadwalUpdate(Request $request, JadwalKebun $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'lahan_id'        => [
                'nullable',
                Rule::exists('lahan', 'id')->where(fn ($q) => $q->where('user_id', Auth::id())),
            ],
            'jenis_aktivitas' => 'required|string|max:150',
            'tanggal'         => 'required|date',
            'status'          => 'required|in:pending,selesai',
            'catatan'         => 'nullable|string',
        ]);
        $jadwal->update($data);
        return redirect()->route('portal.manajemen.jadwal.index')->with('success', 'Jadwal kebun berhasil diperbarui.');
    }

    public function jadwalDestroy(JadwalKebun $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $jadwal->delete();
        return back()->with('success', 'Jadwal kebun dihapus.');
    }

    public function jadwalSelesai(JadwalKebun $jadwal)
    {
        abort_if($jadwal->user_id !== Auth::id(), 403);
        $jadwal->update(['status' => 'selesai']);
        return back()->with('success', 'Jadwal ditandai selesai.');
    }

    // ── Laporan ──────────────────────────────────────────────────
    public function laporan()
    {
        $userId = Auth::id();
        $totalPanen     = HasilPanen::where('user_id', $userId)->sum('jumlah_kg');
        $totalPendapatan= HasilPanen::where('user_id', $userId)->selectRaw('SUM(jumlah_kg * harga_per_kg) as total')->value('total') ?? 0;
        $totalBiaya     = BiayaOperasional::where('user_id', $userId)->sum('jumlah');
        $labaRugi       = $totalPendapatan - $totalBiaya;
        $allPanen = HasilPanen::where('user_id', $userId)->get();
        $panenPerBulan = $allPanen->filter(fn($p) => !empty($p->tanggal_panen))
            ->groupBy(function ($p) {
                return (int) $p->tanggal_panen->format('n');
            })
            ->map(function ($items, $bulan) {
                return (object) [
                    'bulan'    => $bulan,
                    'total_kg' => (float) $items->sum('jumlah_kg'),
                ];
            })
            ->sortBy('bulan')
            ->values();

        $panenPerVarietas = HasilPanen::where('user_id', $userId)
            ->selectRaw('varietas, SUM(jumlah_kg) as total_kg, SUM(jumlah_kg * COALESCE(harga_per_kg, 0)) as total_nilai')
            ->groupBy('varietas')
            ->orderByDesc('total_kg')
            ->get();

        $biayaPerJenis = BiayaOperasional::where('user_id', $userId)
            ->selectRaw('jenis_biaya, SUM(jumlah) as total_biaya')
            ->groupBy('jenis_biaya')
            ->orderByDesc('total_biaya')
            ->get();

        return view('portal.manajemen.laporan', [
            'menuItems'        => $this->menuItems(),
            'totalPanen'       => $totalPanen,
            'totalPendapatan'  => $totalPendapatan,
            'totalBiaya'       => $totalBiaya,
            'labaRugi'         => $labaRugi,
            'panenPerBulan'    => $panenPerBulan,
            'panenPerVarietas' => $panenPerVarietas,
            'biayaPerJenis'    => $biayaPerJenis,
        ]);
    }
}




