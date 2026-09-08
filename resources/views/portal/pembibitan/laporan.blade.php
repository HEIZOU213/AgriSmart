<x-portal-layout portalName="Pembibitan" pageTitle="Laporan Pembibitan" :menuItems="$menuItems">
<h2 class="text-lg font-bold text-slate-800 mb-5">Laporan Pembibitan</h2>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
<div class="bg-green-50 rounded-2xl p-5 border border-green-100"><p class="text-xs font-bold text-green-600 uppercase tracking-wider">Pengadaan Bulan Ini</p><p class="text-3xl font-extrabold text-green-700 mt-2">{{ $pengadaanBulanIni }}</p><p class="text-xs text-green-500 mt-1">bibit diadakan</p></div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
<h3 class="font-bold text-slate-800 mb-4">Rekap Berdasarkan Status</h3>
<div class="space-y-2">@foreach($rekapStatus as $r)<div class="flex items-center justify-between py-2 border-b border-slate-50"><span class="text-sm text-slate-600 capitalize">{{ str_replace('_',' ',$r->status) }}</span><span class="font-bold text-slate-800">{{ $r->total }} bibit</span></div>@endforeach</div>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
<h3 class="font-bold text-slate-800 mb-4">Rekap Berdasarkan Kondisi</h3>
<div class="space-y-2">@foreach($rekapKondisi as $r)<div class="flex items-center justify-between py-2 border-b border-slate-50"><span class="text-sm text-slate-600 capitalize">{{ str_replace('_',' ',$r->kondisi) }}</span><span class="font-bold text-slate-800">{{ $r->total }} bibit</span></div>@endforeach</div>
</div>
</div>
</x-portal-layout>
