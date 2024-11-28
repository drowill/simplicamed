<?php $__env->startSection('title', 'Home - SimplificaMed'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Sucess login -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

    <!-- End tag -->


    <!-- -------------------------------  Welcome  -------------------------------  -->
    <section class="banner">
        <div class="banner-content">
            <h2>Seja bem-vindo!</h2>
            <p>Precisa agendar sua consulta e não pode ir até o consultório?</p>
            <a href="<?php echo e(route('agenda')); ?>"><button>Agende aqui</button></a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit">Logout</button>
            </form>
        </div>
    </section>

    <!-- -------------------------------  Agendamentos  -------------------------------  -->
    <section class="appointments">
        
        <div class="container">
            <div class="row">
                
                <!-- Listagem de consultas -->
                <div class="col-md-6">
                    <h3>Consultas do dia</h3>
                    <div id="consultas-list">
                        <?php echo $__env->make('consultas-list', ['consultas' => $consultas], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

                <?php if(Auth::user()->permission_level == 1 || Auth::user()->permission_level == 2): ?>
                    <!-- Calendário -->
                    <div class="col-md-6">
                        <h3>Selecione uma data</h3>
                        <input type="date" id="calendar" class="form-control" value="<?php echo e(now()->toDateString()); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- -------------------------------  Sobre Nós  -------------------------------  -->
    <section class="info-clinica">
        <h3>Informações sobre a clínica</h3>
        <div class="info-aling">
            <div class="info-item">
                <img src="clinica.jpg" alt="Imagem da Clínica">
                <div>
                    <h4>Um espaço amplo e agradável.</h4>
                    <p>Lorem ipsum dolor sit amet, aut delectus labore aut quos possimus ut perfere...</p>
                    <span>Set 4, 2022</span>
                </div>
            </div>
            <div class="info-item">
                <img src="clinica.jpg" alt="Imagem da Clínica">
                <div>
                    <h4>Um espaço amplo e agradável.</h4>
                    <p>Lorem ipsum dolor sit amet, aut delectus labore aut quos possimus ut perfere...</p>
                    <span>Set 4, 2022</span>
                </div>
            </div>
        </div>
    </section>

    <!-- -------------------------------  Profissionais  -------------------------------  -->
    <section class="property-listings">
        <h2>Apartments Available For Rent</h2>
        <div class="listing-grid">
            <div class="listing-item featured">
                <img src="apartment1.jpg" alt="Apartment 1">
                <h3>New Luxury Apartment</h3>
                <p>John Smith - Sep 15, 2022</p>
                <p>Breana Mill</p>
                <button>View Property</button>
            </div>
            <div class="listing-item new">
                <img src="apartment2.jpg" alt="Apartment 2">
                <h3>New Luxury Apartment</h3>
                <p>John Smith - Sep 15, 2022</p>
                <p>Breana Mill</p>
                <button>View Property</button>
            </div>
            <div class="listing-item new">
                <img src="apartment3.jpg" alt="Apartment 3">
                <h3>New Luxury Apartment</h3>
                <p>John Smith - Sep 15, 2022</p>
                <p>Breana Mill</p>
                <button>View Property</button>
            </div>
            <div class="listing-item featured">
                <img src="apartment4.jpg" alt="Apartment 4">
                <h3>New Luxury Apartment</h3>
                <p>John Smith - Sep 15, 2022</p>
                <p>Breana Mill</p>
                <button>View Property</button>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('calendar').addEventListener('change', function() {
            const selectedDate = this.value; // A data no formato YYYY-MM-DD

            fetch(`/consultas/${selectedDate}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na requisição: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.html) {
                        document.getElementById('consultas-list').innerHTML = data.html;
                    } else {
                        document.getElementById('consultas-list').innerHTML = '<p>Erro ao carregar consultas.</p>';
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById('consultas-list').innerHTML = '<p>Erro ao carregar consultas.</p>';
                });
        });
    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\MICRO\Downloads\meta 14 - barra de pesquisa, status novo\resources\views/welcome.blade.php ENDPATH**/ ?>