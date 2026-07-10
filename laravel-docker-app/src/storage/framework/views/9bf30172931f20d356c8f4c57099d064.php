<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク一覧
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            
            <div class="mb-4">
                <a href="<?php echo e(route('tasks.create')); ?>"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    新規タスク作成
                </a>
            </div>

            
            <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            
                            <form method="POST" action="<?php echo e(route('tasks.toggle', $task)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                        class="<?php echo e($task->is_completed ? 'bg-green-500' : 'bg-gray-300'); ?> text-white px-3 py-1 rounded text-sm">
                                    <?php echo e($task->is_completed ? '完了' : '未完了'); ?>

                                </button>
                            </form>

                            
                            <span class="<?php echo e($task->is_completed ? 'line-through text-gray-400' : ''); ?>">
                                <?php echo e($task->title); ?>

                            </span>
                        </div>

                        
                        <div class="flex gap-2">
                            <a href="<?php echo e(route('tasks.edit', $task)); ?>"
                               class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                編集
                            </a>
                            <form method="POST" action="<?php echo e(route('tasks.destroy', $task)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600"
                                        onclick="return confirm('削除しますか？')">
                                    削除
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-6 text-gray-500">タスクがありません</div>
                <?php endif; ?>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/tasks/index.blade.php ENDPATH**/ ?>