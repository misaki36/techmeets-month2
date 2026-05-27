<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿を編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700">タイトル</label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}"
                               class="w-full border rounded p-2 mt-1">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">本文</label>
                        <textarea name="body" rows="6"
                                  class="w-full border rounded p-2 mt-1">{{ old('body', $post->body) }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        更新する
                    </button>

                    <a href="{{ route('posts.show', $post) }}" class="ml-4 text-gray-500 hover:underline">
                        キャンセル
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>