

<?php $__env->startSection('title', 'Consultas - SimplificaMed'); ?>

<?php $__env->startSection('content'); ?>

    <div id="consulta-create-container" class="col-md-6 offsef-md-3">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <h1>Crie sua Consulta</h1>
        <form action="<?php echo e(route('agenda')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Título da consulta -->
            <div class="form-group mb-3">
                <label for="title">Título da Consulta</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <!-- Nome do paciente -->
            <div class="form-group mb-3">
                <label for="name">Nome do Paciente</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(Auth::user()->name); ?>" required disabled>
            </div>

            <!-- Idade -->
            <div class="form-group mb-3">
                <label for="idade">Idade</label>
                <input type="number" name="idade" class="form-control" value="<?php echo e(old('idade')); ?>" required>
            </div>

            <!-- Endereço -->
            <div class="form-group mb-3">
                <label for="endereco">Endereço</label>
                <?php if(Auth::user()->endereco): ?>
                    <input type="text" name="endereco" class="form-control" value="<?php echo e(Auth::user()->endereco); ?>" disabled>
                <?php else: ?>
                    <input type="text" name="endereco" class="form-control" value="Endereço de usuário não cadastrado" disabled>
                <?php endif; ?>
            </div>

            <!-- Descrição -->
            <div class="form-group mb-3">
                <label for="descricao">Descrição da Consulta</label>
                <textarea name="descricao" class="form-control" rows="5" required></textarea>
            </div>

            <!-- Data da Consulta -->
            <div class="form-group mb-3">
                <label for="data">Data da Consulta</label>
                <input type="date" name="data" class="form-control" required>
            </div>

            <!-- Horário da Consulta -->
            <div class="form-group mb-3">
                <label for="horario">Horário da Consulta</label>
                <input type="time" name="horario" class="form-control" required>
            </div>

            <!-- Botão de submissão -->
            <button type="submit" class="btn btn-primary">Cadastrar Consulta</button>
        </form>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MICRO\Downloads\meta 14 - barra de pesquisa, status novo\resources\views/consulta/consultas.blade.php ENDPATH**/ ?>