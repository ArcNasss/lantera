@extends($layout)

@section('title', $pageTitle)
@section('page-title', $pageTitle)

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-3xl px-6 py-12 text-white shadow-sm md:px-10"
             style="background-image: url('{{ asset('image/hero.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-cyan-500/25"></div>
        <div class="relative z-10 mx-auto max-w-3xl text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-cyan-600">
                <i class="fas fa-book-open text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold">{{ $heroTitle }}</h1>
            <p class="mt-3 text-sm text-cyan-50 md:text-base">{{ $heroSubtitle }}</p>
            <p class="mt-3 text-sm text-cyan-100">Terakhir diperbarui: {{ $lastUpdated }}</p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 md:grid-cols-2">
        @foreach($sections as $section)
        <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-cyan-100 text-cyan-600">
                    <i class="{{$section['icon']}}"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $section['title'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $section['subtitle'] }}</p>
                </div>
            </div>
            <ul class="space-y-2 text-sm text-gray-600">
                @foreach($section['points'] as $point)
                <li class="flex items-start gap-2">
                    <span class="mt-2 h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    <span>{{ $point }}</span>
                </li>
                @endforeach
            </ul>
            <a href="{{ route($detailRouteName, $section['slug']) }}"
               class="mt-5 inline-flex items-center gap-2 rounded-lg bg-cyan-500 px-3 py-1.5 text-xs font-medium text-white transition-colors hover:bg-cyan-600">
                Lihat Selengkapnya
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </article>
        @endforeach
    </section>
</div>
@endsection
