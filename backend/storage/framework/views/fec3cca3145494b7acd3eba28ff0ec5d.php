<?php if($consultas->count() === 0): ?>
    <p>Nenhuma consulta encontrada para essa data.</p>
<?php else: ?>
    <ul class="list-group">
        <?php $__currentLoopData = $consultas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item">
                <strong><?php echo e($consulta->title); ?></strong> - <?php echo e($consulta->horario); ?> - 
                
                <?php if($consulta->status == '1'): ?>
                    <span class="badge text-bg-warning">Pendente</span>
                <?php elseif($consulta->status == '2'): ?>
                    <span class="badge text-bg-primary">Confirmado</span>
                <?php elseif($consulta->status == '3'): ?>
                    <span class="badge text-bg-danger">Rejeitado</span>
                <?php elseif($consulta->status == '4'): ?>
                    <span class="badge text-bg-danger">Cancelado</span>
                <?php elseif($consulta->status == '5'): ?>
                    <span class="badge text-bg-success">Finalizado</span>
                <?php elseif($consulta->status == '6'): ?>
                    <span class="badge text-bg-danger">Cliente ausente</span>
                <?php endif; ?>

                <span class="truncate"><?php echo e($consulta->descricao); ?></span>

                <small class="text-muted"><?php echo e($consulta->user->name); ?></small>
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(route('exibir_consulta', $consulta->id)); ?>" class="btn btn-primary me-2">Visualizar</a>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

<?php endif; ?>
<?php /**PATH C:\Users\MICRO\Downloads\meta 14 - barra de pesquisa, status novo\resources\views/consultas-list.blade.php ENDPATH**/ ?>