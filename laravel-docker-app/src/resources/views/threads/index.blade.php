<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            掲示板
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('threads.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    新規投稿
                </a>
            </div>

            @foreach($threads as $thread)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                    <p class="font-semibold">{{ $thread->name }}</p>
                    <p class="text-gray-700 mt-2">{{ $thread->body }}</p>
                    <p class="text-gray-400 text-sm mt-2">{{ $thread->created_at->diffForHumans() }}</p>

                    @if(Auth::id() === $thread->user_id)
                        <form method="POST" action="{{ route('threads.destroy', $thread) }}" class="inline mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm"
                                    onclick="return confirm('削除しますか？')">
                                削除
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>