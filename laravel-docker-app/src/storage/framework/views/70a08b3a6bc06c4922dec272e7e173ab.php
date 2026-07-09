<?php $__env->startSection('content'); ?>
    <h1>イベント一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>開催日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($event->id); ?></td>
                    <td>
                        <a href="<?php echo e(route('events.show', $event)); ?>"><?php echo e($event->title); ?></a>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($event->event_date)->format('Y/m/d H:i')); ?></td>
                    <td>
                        <a href="<?php echo e(route('reservations.create', ['event_id' => $event->id])); ?>">予約する</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4">イベントがありません</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <?php echo e($events->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/events/index.blade.php ENDPATH**/ ?>