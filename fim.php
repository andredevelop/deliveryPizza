<?php include('config.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Finalizando pedido</title>
	<!-- font open sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<!-- metatags -->
	<meta name="description" content="Desenvolvedor fullstack brasileiro e legitimamente cearense e pronto para solucionar seu problema! Acesse, e veja o que posso fazer por você e seu negócio."/>
	<meta name="keywords" content="ande duarte pacajus programador desenvolvedor de site site como fazer como fazer um site mesmo você tipo criar jogo web mobile aplicativo loja virtual pizzaria delivery" />
	<meta name="author" content="Francisco André - Dev. Web, mobile">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
	<!-- icone site -->
	<link rel="shortcut icon" type="image-x/png" href="<?php echo INCLUDE_PATH ?>favicon.ico">
	<!-- charset -->
	<meta charset="utf-8">
	<!-- font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
	<script src="https://kit.fontawesome.com/d76df92ddf.js" crossorigin="anonymous"></script>
	<link href="<?php echo INCLUDE_PATH ?>css/all.css" rel="stylesheet"/>
	<!-- estilo -->
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/jquery.fancybox.css"/>
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css"/>

	<style>
		.btnPadrao3{
			font-size: 18px;
			color: white;
			width: 100%;
			padding: 10px 0;
			background-color: #18A558;
			display: inline-block;
			text-align: center;
			border: 0;
			cursor: pointer;
			margin: 20px auto 0 auto;
			text-decoration: none;
		}
		h4{
			font-size: 30px;
			margin: 10px;
		}
		p{
			margin-left: 20px;
		}
	</style>
</head>
<body>

	<header id="home">
	<i class="fas fa-bars right"></i><!-- menu mobile tn -->
		<div class="container">
		
			<div class="logo-wraper">
				<a href="home"><img src="<?php echo INCLUDE_PATH; ?>image/logo.png"></a>
			</div>

			<div class="clear"></div>
		</div><!-- container -->
</header><!-- header -->

	<h4>Confira seu pedido!</h4>

	<?php
	$valorF = Painel::selecionarTudo('tb_admin.frete');

    foreach ($valorF as $key => $value) {

      $frete = $value['valor'];

    }
	$total = 0;

	foreach($_SESSION['mycar'] as $key =>$value){
	  	$total += $value['preco']*$value['quantidade'];
		echo '<p>'.$value['nome'].'</p>';
		echo '<p>Quantidade: '.$value['quantidade'].'</p>';
		echo '<p>'.$_SESSION['endereco'].'</p>';
		echo '<p>'.$_SESSION['tipo_pagamento'].'</p>';
		echo '<p>'.$_SESSION['observacao'].'</p>';
		echo '<hr />';
	}
	
	$totalCtroco = $total + $frete;
	echo '<p>Total: R$ '.number_format($totalCtroco,2,',','.').'</p>';

	if((int)$_SESSION['troco']=='0'){

	}else{
		echo '<p>Mão do cliente: R$ '.number_format((int)$_SESSION['troco'],2,',','.').'</p>';
		echo '<p style="color:red">Troco: R$ '.number_format((int)$_SESSION['troco'] - $totalCtroco,2,',','.').'</p>';
	}
		
	?>

	<?php 

		if((int)$_SESSION['troco']!='0'){

	?>

	<a href="https://api.whatsapp.com/send?phone=yourNumber&text=Olá, acabei de realizar o seguinte pedido: <?php foreach($_SESSION['mycar'] as $key =>$value){
		echo '*Nome:* '.$value['nome'].' -> <hr> *Unidades:* ('.$value['quantidade'].') | ';
	}?> *Total à pagar (frete incluso)* <?php echo 'R$ '.number_format($total+$frete,2,',','.') ?> -> <?php echo '*Endereço:* '.$_SESSION['endereco'].'-> *Tipo de Pagamento:* '.$_SESSION['tipo_pagamento'].' -> *Troco:* R$ '.@number_format((int)$_SESSION['troco'] - $totalCtroco,2,',','.').' -> *Observação:* '.$_SESSION['observacao']?>" target="_blank" class="btnPadrao3">Finalizar pedido</a>

	<?php }else{ ?>

	<a href="https://api.whatsapp.com/send?phone=yourNumber&text=Olá, acabei de realizar o seguinte pedido: <?php foreach($_SESSION['mycar'] as $key =>$value){
		echo '*Nome:* '.$value['nome'].' -> *Unidades:* ('.$value['quantidade'].') | ';
	}?> *Total à pagar (frete incluso)* <?php echo 'R$ '.number_format($total+$frete,2,',','.') ?> -> <?php echo '*Endereço:* '.$_SESSION['endereco'].'-> *Tipo de Pagamento:* '.$_SESSION['tipo_pagamento'].' -> *Observação:* '.$_SESSION['observacao']?>" target="_blank" class="btnPadrao3">Finalizar pedido</a>

	<?php } ?>


</body>
</html>