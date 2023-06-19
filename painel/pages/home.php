<?php 
	$usuariosOnline = Painel::listarUsuariosOnline();
	$totalVisitas = Painel::pegaVisitasTotal();
	$visitasHoje = Painel::visitasHoje();
?>
<div class="container">
	<div class="box-content objeto-color">
		<h2><i class="fas fa-eye"></i> Visitantes - <?php echo NOME_EMPRESA ?><img src="<?php echo INCLUDE_PATH ?>favicon.ico"></h2>

		<div class="usuarioOnline w33">
			<h2>Usuários online</h2>
			<h2 class="color-texto-content"><?php echo count($usuariosOnline); ?></h2>
		</div><!-- usuario online -->
		<div class="totalVisita w33">
			<h2>Total de visitas</h2>
			<h2 class="color-texto-content"><?php echo $totalVisitas; ?></h2>
		</div><!-- total visita -->
		<div class="visitaHoje w33">
			<h2>Visitas hoje</h2>
			<h2 class="color-texto-content"><?php echo $visitasHoje; ?></h2>
		</div><!-- visita hoje -->
	</div><!-- box-content -->

	<div class="box-content objeto-color">
		<h2><i class="fas fa-anchor"></i> Usuários online no site</h2>
		<div class="table-responsive">
			<div class="row table-color">
				<div class="col">
					<span>IP</span>
				</div><!--col-->
				<div class="col">
					<span>Última Ação</span>
				</div><!--col-->
				<div class="clear"></div>
			</div><!--row-->
			<?php 
				foreach ($usuariosOnline as $key => $value) {
			?>
			<div class="row color-texto">
				<div class="col">
					<span><?php echo $value['ip']; ?></span>
				</div><!--col-->
				<div class="col">
					<span><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao'])); ?></span>
				</div><!--col-->
				<div class="clear"></div>
			</div><!--row-->
			<?php } ?>
		</div><!--table-responsive-->
	</div><!-- box-content -->

	<div class="box-content objeto-color">
		<h2><i class="fas fa-users"></i> Equipe do painel</h2>
		<div class="table-responsive">
			<div class="row table-color">
				<div class="col">
					<span>Nome</span>
				</div><!--col-->
				<div class="col">
					<span>Cargo</span>
				</div><!--col-->
				<div class="clear"></div>
			</div><!--row-->
			<?php 
				$listaEquipe = Painel::selecionarTudo('tb_admin.usuarios');
				foreach ($listaEquipe as $key => $value) {
			?>
			<div class="row color-texto">
				<div class="col">
					<span><?php echo $value['nome']; ?></span>
				</div><!--col-->
				<div class="col">
					<span><?php echo pegaCargoHome($value['cargo']); ?></span>
				</div><!--col-->
				<div class="clear"></div>
			</div><!--row-->
			<?php } ?>
		</div><!--table-responsive-->
	</div><!-- box-content -->

</div><!-- container -->