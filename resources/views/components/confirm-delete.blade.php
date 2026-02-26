@props(['action', 'title' => 'Apakah Anda yakin ingin hapus?', 'message' => 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.'])

<div
    x-data="{ show: false, deleteUrl: '' }"
    x-show="show"
    @open-confirm-delete.window="show = true; deleteUrl = $event.detail.url"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
    style="display: none;"
>
    <div
        @click.away="show = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-8 relative"
    >
        <!-- Close Button -->
        <button
            @click="show = false"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Illustration -->
        <div class="flex justify-center mb-6">
            <svg class="w-32 h-32" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Question mark left -->
                <circle cx="50" cy="70" r="8" fill="#93C5FD"/>
                <path d="M50 78 L50 85" stroke="#93C5FD" stroke-width="4" stroke-linecap="round"/>

                <!-- Question mark right -->
                <circle cx="150" cy="70" r="8" fill="#93C5FD"/>
                <path d="M150 78 L150 85" stroke="#93C5FD" stroke-width="4" stroke-linecap="round"/>

                <!-- Person body -->
                <rect x="85" y="120" width="30" height="50" rx="4" fill="#60A5FA"/>
                <rect x="80" y="125" width="40" height="35" rx="4" fill="#3B82F6"/>

                <!-- Person head/face circle -->
                <circle cx="100" cy="95" r="25" fill="#DBEAFE"/>
                <circle cx="100" cy="95" r="20" fill="#93C5FD"/>

                <!-- Face details -->
                <circle cx="92" cy="90" r="3" fill="#1E40AF"/>
                <circle cx="108" cy="90" r="3" fill="#1E40AF"/>
                <path d="M95 102 Q100 105 105 102" stroke="#1E40AF" stroke-width="2" fill="none" stroke-linecap="round"/>

                <!-- Arms raised (confused gesture) -->
                <path d="M75 130 L65 115" stroke="#60A5FA" stroke-width="8" stroke-linecap="round"/>
                <path d="M125 130 L135 115" stroke="#60A5FA" stroke-width="8" stroke-linecap="round"/>

                <!-- Hands -->
                <circle cx="63" cy="112" r="6" fill="#93C5FD"/>
                <circle cx="137" cy="112" r="6" fill="#93C5FD"/>

                <!-- Hair/hat top -->
                <path d="M85 75 Q100 70 115 75" fill="#1E40AF"/>
            </svg>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">
            {{ $title }}
        </h3>

        <!-- Message -->
        <p class="text-sm text-gray-600 text-center mb-6">
            {{ $message }}
        </p>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button
                @click="show = false"
                type="button"
                class="flex-1 px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 rounded-lg transition-colors font-medium"
            >
                Kembali
            </button>
            <button
                @click="$refs.deleteForm.submit()"
                type="button"
                class="flex-1 px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors font-medium"
            >
                Hapus
            </button>
        </div>

        <!-- Hidden form -->
        <form x-ref="deleteForm" :action="deleteUrl" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
