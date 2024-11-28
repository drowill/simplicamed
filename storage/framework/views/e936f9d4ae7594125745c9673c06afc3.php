

<?php $__env->startSection('title', 'Acesso - SimplificaMed'); ?>

<?php $__env->startSection('content'); ?>

<header>
        <h1>Simplifica Med</h1>
        <nav>
            <a href="#">
                <img src="user-icon.svg" alt="Ícone de usuário">
            </a>
        </nav>

        <?php if($errors->any()): ?>
            <div>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <main>
            <form action="<?php echo e(route('perfil_login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <h2>Entrar</h2>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Insira o e-mail">
                </div>
                <div>
                    <label for="password">Senha</label>
                    <input type="password" name="password" placeholder="Insira a senha">
                    <a href="#">Esqueceu a senha?</a>
                </div> 
                <button type="submit">Entrar</button>
            </form>
            
        </main>
    </header>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MICRO\Downloads\meta 14 - barra de pesquisa, status novo\resources\views/auth/login.blade.php ENDPATH**/ ?>