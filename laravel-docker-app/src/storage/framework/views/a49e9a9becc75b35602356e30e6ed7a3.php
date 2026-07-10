<?php $__env->startSection('content'); ?>
    <h1>予約一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>イベント名</th>
                <th>予約者名</th>
                <th>メール</th>
                <th>人数</th>
                <th>予約日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($reservation->id); ?></td>
                    <td><?php echo e($reservation->event->title); ?></td>
                    <td><?php echo e($reservation->name); ?></td>
                    <td><?php echo e($reservation->email); ?></td>
                    <td><?php echo e($reservation->number_of_people); ?>人</td>
                    <td><?php echo e(\Carbon\Carbon::parse($reservation->reserved_at)->format('Y/m/d H:i')); ?></td>
                    <td>
                        <form action="<?php echo e(route('reservations.destroy', $reservation)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn-danger" onclick="return confirm('キャンセルしますか？')">キャンセル</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">予約がありません</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <?php echo e($reservations->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/reservations/index.blade.php ENDPATH**/ ?>