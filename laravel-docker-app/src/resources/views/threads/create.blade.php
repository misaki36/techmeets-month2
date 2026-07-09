<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規投稿
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('threads.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">投稿者名</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded p-2 mt-1">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">本文</label>
                        <textarea name="body" rows="6"
                                  class="w-full border rounded p-2 mt-1">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        投稿する
                    </button>

                    <a href="{{ route('threads.index') }}" class="ml-4 text-gray-500 hover:underline">
                        戻る
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>