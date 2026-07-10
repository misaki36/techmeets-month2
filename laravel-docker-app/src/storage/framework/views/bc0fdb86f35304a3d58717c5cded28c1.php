<?php $__env->startSection('content'); ?>
    <h1>商品一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>カテゴリー</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td>
                        <a href="<?php echo e(route('products.show', $product)); ?>"><?php echo e($product->name); ?></a>
                    </td>
                    <td>¥<?php echo e(number_format($product->price)); ?></td>
                    <td><?php echo e($product->stock); ?></td>
                    <td><?php echo e($product->category); ?></td>
                    <td>
                        <a href="<?php echo e(route('products.edit', $product)); ?>">編集</a>
                        <form action="<?php echo e(route('products.destroy', $product)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">商品がありません</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <?php echo e($products->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/products/index.blade.php ENDPATH**/ ?>