<?php $__env->startSection('content'); ?>
<?php if(Session::has('message')): ?>
<div class="templatemo-content-widget green-bg">
    <i class="fa fa-times"></i>
    <div class="media">
        <div class="media-body">
            <h2><?php echo e(Session::get('message')); ?></h2>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container-index">
    <?php echo Html::image("/images/dermoplastica.jpg", "Dermoplástica"); ?>

    <p>A DERMOPLÁSTICA é uma clínica especializada em promover o bem-estar dos seus pacientes aliando
        profissionalismo com a atenção especial que eles merecem em um ambiente projetado especialmente para atingir
        esse objetivo.</p>
    <h2>NOSSA HISTÓRIA</h2>
    <p>A Dermoplástica foi fundada em 2002, a partir da visão do casal de médicos Fábio Lucena e Suzana Kilian, de
        aliar profissionalismo e bem-estar, em um ambiente moderno e aconchegante, em que cada detalhe foi projetado
        para atender ao paciente com atenção especial e modernidade.</p>
    <h2>NOSSA VISÃO</h2>
    <p>Ser o maior e mais completo centro de referência em Cirurgia Plástica Estética, Dermatologia Cosmiátrica e
        Estética Facial e Corporal da Paraíba.</p>
    <h2>NOSSA MISSÃO</h2>
    <p>Promover a melhora da qualidade de vida, bem-estar e autoestima dos nossos pacientes, através de uma equipe
        multidisciplinar que atua na promoção da saúde, valorizando a estética facial e corporal, utilizando
        conhecimentos atualizados e inovações tecnológicas.</p>
    <h2>NOSSOS VALORES</h2>
    <ul>
        <li>O bem-estar dos nossos pacientes e colaboradores;</li>
        <li>Respeito à ética profissional;</li>
        <li>Cumprimento às leis tributárias;</li>
        <li>Princípios cristãos: amor fraternal, honestidade e integridade.</li>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>