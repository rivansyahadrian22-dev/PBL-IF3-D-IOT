@props(['job'])

{{-- Tombol pemicu pop up Lamar. Perilakunya di resources/js/lowongan.js --}}
<button type="button" data-lamar
        data-slug="{{ $job['slug'] }}" data-posisi="{{ $job['posisi'] }}" data-perusahaan="{{ $job['perusahaan'] }}"
        data-emoji="{{ $job['emoji'] }}" data-akses="{{ implode(' ', $job['akses']) }}"
        {{ $attributes }}>{{ $slot }}</button>
