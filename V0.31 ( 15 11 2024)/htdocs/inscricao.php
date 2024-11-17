<?php include_once('forcaRota.php'); ?>

<html>

<head>

<?php include_once('b.php'); ?>

</head>

<?php include_once('Styles/inscricao.css'); ?>
<?php include_once('Styles/card.css'); ?>

<body>

<?php include_once('header.php'); ?>

<label class="lblTitulo">Inscrições</label>

<div class="row">

	<?php foreach ($dadosLit as $literatura) { ?>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <?php include('cardLivro.php'); ?>
    </div>
	<?php } ?>

</div><!--row-->

</body>

</html>