

<?php $__env->startSection('title', 'Cadastro - SimplificaMed'); ?>

<?php $__env->startSection('content'); ?>

<header>
            <h1>Pagina de  Cadastro</h1>
            <form action="<?php echo e(route('perfil_register')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="text" name="name" placeholder="Nome">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Senha">
                <input type="password" name="password_confirmation" placeholder="Confirme a Senha">
                <button type="submit">Cadastrar</button>
            </form>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <a href="<?php echo e(route('login')); ?>">Já tem uma conta? Faça login!</a>
    </header>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MICRO\Downloads\meta 14 - barra de pesquisa, status novo\resources\views/auth/register.blade.php ENDPATH**/ ?>