@props(['type' => 'success'])

@php
    $config = [
        'success' => [
            'icon' => '<svg class="w-20 h-20" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="50" r="45" fill="#E0F2FE"/><path d="M70 35L42 63L30 51" stroke="#0EA5E9" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="50" cy="25" r="8" fill="#0EA5E9"/><path d="M50 35V45" stroke="#0EA5E9" stroke-width="4" stroke-linecap="round"/></svg>',
            'title' => 'Data berhasil disimpan!',
            'message' => 'Data Anda telah tersimpan dengan aman'
        ],
        'deleted' => [
            'icon' => '<svg class="w-20 h-20" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="50" r="45" fill="#FEE2E2"/><path d="M35 40L65 40M40 40V70C40 72 42 74 44 74H56C58 74 60 72 60 70V40M45 40V35C45 33 47 31 49 31H51C53 31 55 33 55 35V40" stroke="#DC2626" stroke-width="4" stroke-linecap="round"/><line x1="45" y1="50" x2="45" y2="64" stroke="#DC2626" stroke-width="3" stroke-linecap="round"/><line x1="55" y1="50" x2="55" y2="64" stroke="#DC2626" stroke-width="3" stroke-linecap="round"/></svg>',
            'title' => 'Data berhasil dihapus!',
            'message' => 'Data Anda telah dihapus dari sistem'
        ],
        'updated' => [
            'icon' => '<svg class="w-20 h-20" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="50" r="45" fill="#FEF3C7"/><path d="M65 35L40 60L32 52" stroke="#F59E0B" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="70" cy="30" r="6" fill="#F59E0B"/><path d="M60 25L55 20" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/></svg>',
            'title' => 'Perubahan Berhasil!',
            'message' => 'Perubahan yang Anda buat telah disimpan dengan sukses'
        ],
        'error' => [
            'icon' => '<svg class="w-20 h-20" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="50" r="45" fill="#FEE2E2"/><path d="M35 35L65 65M65 35L35 65" stroke="#DC2626" stroke-width="6" stroke-linecap="round"/></svg>',
            'title' => 'Terjadi Kesalahan!',
            'message' => 'Mohon coba lagi atau hubungi administrator'
        ]
    ];

    $current = $config[$type] ?? $config['success'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    x-init="setTimeout(() => show = false, 5000)"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
    style="display: none;"
>
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-8 text-center relative">
        <!-- Close Button -->
        <button
            @click="show = false"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
        >
            <i class="fas fa-times w-5 h-5"></i>
        </button>

        <!-- Icon -->
        <div class="flex justify-center mb-4">
            {!! $current['icon'] !!}
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-gray-900 mb-2">
            {{ $slot->isEmpty() ? $current['title'] : $slot }}
        </h3>

        <!-- Message -->
        <p class="text-sm text-gray-600">
            {{ $attributes->get('message') ?? $current['message'] }}
        </p>

        <!-- Button -->
        <button
            @click="show = false"
            class="mt-6 px-8 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
        >
            Kembali
        </button>
    </div>
</div>
