<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700">タイトル</label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}"
                               class="w-full border rounded p-2 mt-1">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">メモ</label>
                        <textarea name="body" rows="4"
                                  class="w-full border rounded p-2 mt-1">{{ old('body', $task->body) }}</textarea>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            更新する
                        </button>
                        <a href="{{ route('tasks.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            キャンセル
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>