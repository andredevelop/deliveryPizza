<?php 
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$depoimento = Painel::listar('tb_site.depoimentos','id = ?',array($id));
	}else{
		Painel::alert('erro','Você precisa passar o id');
		die();
	}
?>
<div class="container">
	<div class="box-content objeto-color">
		<h2><i class="fas fa-comment-dots"></i> Editar depoimento</h2>

		<form method="post" enctype="multipart/form-data">
			<?php 
				if(isset($_POST['acao'])){
					if(Painel::atualizarBanco($_POST)){
						Painel::alert('sucesso','Depoimento editado com sucesso!');
						$depoimento = Painel::listar('tb_site.depoimentos','id = ?',array($id));
					}else{
						Painel::alert('erro','Campos vazios não são permitidos!');
					}
				}
			?>
			<div class="form-group">
				<label>Nome do cliente:</label>
				<input type="text" name="nome" value="<?php echo $depoimento['nome'] ?>">
			</div><!--form-group-->

			<div class="form-group">
				<label>Depoimento:</label>
				<textarea name="depoimento"><?php echo $depoimento['depoimento'] ?></textarea>
			</div><!--form-group-->

			<div class="form-group">
				<label>Data:</label>
				<input formato="data" type="text" name="data" value="<?php echo $depoimento['data'] ?>">
			</div><!--form-group-->

			<div class="form-group">
				<input type="hidden" name="id" value="<?php echo $depoimento['id']; ?>" />
				<input type="hidden" name="nome_tabela" value="tb_site.depoimentos" />
				<input class="btn-color" type="submit" name="acao" value="Atualizar!">
			</div><!--form-group-->

		</form>
	</div><!-- box-content -->
</div><!-- container -->