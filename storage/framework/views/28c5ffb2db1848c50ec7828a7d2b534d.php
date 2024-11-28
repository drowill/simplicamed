

<?php $__env->startSection('title', 'Perfil'); ?>


<link rel="stylesheet" href="/css/agenda.css">

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div id="search-container-agenda" class="col-md-12">
        <h1>Busque sua consulta</h1>
        <form action="<?php echo e(route('consultas')); ?>" method="GET" class="d-flex mb-3 align-items-center">
            <input type="text" id="search" name="search" class="form-control me-2" 
                placeholder="Buscar..." value="<?php echo e(request('search')); ?>">
            <button type="submit" class="btn btn-primary" style="width: 40px; height: 40px; padding: 0;">
                <i class="fas fa-search"></i> <!-- Ícone de lupa -->
            </button>
        </form>
    </div>

    <div id="consultas-container" class="col-md-12">
        <h1>Consultas recentes</h1>

        <?php if(request('search')): ?>
            <div class="mb-3">
                <a href="<?php echo e(route('consultas')); ?>" class="badge bg-danger text-decoration-none" style="font-size: 1rem;">
                    Limpar Pesquisa
                </a>
            </div>
        <?php endif; ?>

        <div id="cards-container" class="row">
            <?php if( count( $consultas ) == 0 ): ?>
                <p>Nenhuma consulta encontrada.</p>
            <?php else: ?>
                <?php $__currentLoopData = $consultas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card col-md-3">
                        <img src="https://via.placeholder.com/150" alt="Imagem de consultas">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo e($consulta->title); ?>

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
                            </h5>
                            
                            <p class="card-name"><?php echo e($consulta->name); ?> - <?php echo e($consulta->idade); ?> Anos</p>
                            <p class="card-endereco"><?php echo e($consulta->endereco); ?></p>
                            <p class="card-text"><?php echo e($consulta->descricao); ?></p>
                            <p class="card-date-time"><?php echo e(\Carbon\Carbon::parse($consulta->data)->format('d/m/Y')); ?> ---------- <?php echo e($consulta->horario); ?></p>

                            <a href="<?php echo e(route('exibir_consulta', $consulta->id)); ?>" class="btn btn-primary">Visualizar</a>
                            <?php if(Auth::user()->id == $consulta->user_id): ?>
                                <a href="<?php echo e(route('editar_consulta', $consulta->id)); ?>" class="btn btn-secondary">Editar</a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    
    </div>

<!-- <?php $__currentLoopData = $consultas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><?php echo e($consulta->title); ?> -- <?php echo e($consulta->name); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MICRO\Downloads\meta 14 - barra de pesquisa, status novo\resources\views/profile.blade.php ENDPATH**/ ?>