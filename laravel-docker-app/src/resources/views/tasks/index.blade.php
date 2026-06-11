<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 新規作成ボタン --}}
            <div class="mb-4">
                <a href="{{ route('tasks.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    新規タスク作成
                </a>
            </div>

            {{-- タスク一覧 --}}
            <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                @forelse ($tasks as $task)
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            {{-- 完了/未完了ボタン --}}
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="{{ $task->is_completed ? 'bg-green-500' : 'bg-gray-300' }} text-white px-3 py-1 rounded text-sm">
                                    {{ $task->is_completed ? '完了' : '未完了' }}
                                </button>
                            </form>

                            {{-- タイトル --}}
                            <span class="{{ $task->is_completed ? 'line-through text-gray-400' : '' }}">
                                {{ $task->title }}
                            </span>
                        </div>

                        {{-- 編集・削除ボタン --}}
                        <div class="flex gap-2">
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                編集
                            </a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600"
                                        onclick="return confirm('削除しますか？')">
                                    削除
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-500">タスクがありません</div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>