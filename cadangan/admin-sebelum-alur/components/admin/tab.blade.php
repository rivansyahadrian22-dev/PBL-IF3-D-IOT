@props(['item'])

{{-- Tab navigasi antar halaman yang berada di bawah satu menu sidebar. item: [[label, nama route], ...] --}}
<nav class="-mt-2 flex gap-1 overflow-x-auto border-b border-slate-200 print:hidden" aria-label="Bagian halaman">
    @foreach ($item as [$label, $rute])
        @php $aktif = request()->routeIs($rute); @endphp
        <a href="{{ route($rute) }}" @if ($aktif) aria-current="page" @endif
           class="-mb-px shrink-0 border-b-2 px-4 py-3 text-sm font-bold transition {{ $aktif ? 'border-navy-900 text-navy-900' : 'border-transparent text-slate-500 hover:text-navy-900' }}">{{ $label }}</a>
    @endforeach
</nav>
