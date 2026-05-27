<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-500 text-sm mb-4">{{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</p>
                <p class="text-gray-800 mb-6">{{ $post->body }}</p>

                @if(Auth::id() === $post->user_id)
                    <a href="{{ route('posts.edit', $post) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        編集
                    </a>

                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                onclick="return confirm('削除しますか？')">
                            削除
                        </button>
                    </form>
                @endif

                <a href="{{ route('posts.index') }}" class="ml-4 text-gray-500 hover:underline">
                    一覧に戻る
                </a>
            </div>
        </div>
    </div>
</x-app-layout>