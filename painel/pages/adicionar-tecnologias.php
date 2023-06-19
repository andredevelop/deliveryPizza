<div class="container">
	<div class="box-content objeto-color">
		<h2><i class="fas fa-code"></i> Cadastrar Aviso</h2>
		
		<form method="post" enctype="multipart/form-data">
			<?php
				if(isset($_POST['acao'])){
					$titulo = $_POST['titulo'];
					$descricao = $_POST['descricao'];

					if($titulo == ''){
						Painel::alert('erro','O titulo não pode estar vazio!');
					}else if($descricao == ''){
						Painel::alert('erro','A descrição não pode estar vazia!');
					}else{
						Painel::inserirNoBanco($_POST);
						Painel::alert('sucesso','Aviso cadastrado com sucesso!');
					}
				}
			?>

			<div class="form-group">
				<label>Titulo:</label>
				<input type="text" name="titulo" />
			</div><!--form-group-->

			<div class="form-group">
				<label>Descrição:</label>
				<textarea name="descricao"></textarea>
			</div><!--form-group-->

			<div class="form-group">
				<input type="hidden" name="order_id" value="0" />
				<input type="hidden" name="nome_tabela" value="tb_site.aviso" />
				<input class="btn-color" type="submit" name="acao" value="Cadastrar!">
			</div><!--form-group-->
		</form><!-- form -->
	</div><!-- box-content -->

<!-- -------------------------------------------------------------------------------------------------- -->

	<div class="box-content objeto-color">
		<h2><i class="fas fa-code"></i> Lista de Avisos</h2>
		<div class="table-responsive tb-respons">
			<div class="row table-color">
				<div class="col-depoimento">
					<span>Titulo:</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span>Descricao:</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span>Editar:</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span>Excluir:</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span>Up:</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span>Down:</span>
				</div><!--col-depoimento-->
				
				<div class="clear"></div>
			</div><!--row-->

			<?php
				if(isset($_GET['excluir'])){
					$idExcluir = intval($_GET['excluir']);
					Painel::deletarRegistro('tb_site.aviso',$idExcluir);
					Painel::redirecionar(INCLUDE_PATH_PAINEL.'adicionar-tecnologias');
				}else if(isset($_GET['order']) && isset($_GET['id'])){
					Painel::ordenarItem('tb_site.aviso',$_GET['order'],$_GET['id']);
				}

				$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
				$porPagina = 4;
				$listaTecnologias = Painel::listarTudo('tb_site.aviso',($paginaAtual - 1) * $porPagina,$porPagina);
				foreach ($listaTecnologias as $key => $value) {
			?>
			<div class="row color-texto">
				<div class="col-depoimento">
					<span><?php echo $value['titulo']; ?></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><?php echo substr($value['descricao'],0,40)  ?>...</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a class="btn-editar" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-tecnologia?id=<?php echo $value['id']; ?>"><i class="far fa-edit"></i> Editar</a></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a actionBtn="deletar" class="btn-excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-tecnologias?excluir=<?php echo $value['id']; ?>"><i class="far fa-trash-alt"></i> Excluir</a></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a class="arrow-up" href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-tecnologias?order=up&id=<?php echo $value['id']; ?>"><i class="fas fa-caret-up"></i></a></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a class="arrow-down" href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-tecnologias?order=down&id=<?php echo $value['id']; ?>"><i class="fas fa-caret-down"></i></a></span>
				</div><!--col-depoimento-->

				<div class="clear"></div>
			</div><!--row-->
			<?php } ?>

		</div><!--table-responsive-->

		<div class="paginacao">
			<?php
				$totalPaginas = ceil(count(Painel::listarTudo('tb_site.aviso')) / $porPagina);
				for($i = 1; $i <= $totalPaginas; $i++){
					if($i == $paginaAtual){
						echo '<a class="btn-pagina-selected" href="'.INCLUDE_PATH_PAINEL.'adicionar-tecnologias?pagina='.$i.'">'.$i.'</a>';
					}else{
						echo '<a class="btn-pagina" href="'.INCLUDE_PATH_PAINEL.'adicionar-tecnologias?pagina='.$i.'">'.$i.'</a>';
					}
				}
			?>
		</div><!-- paginacao -->
		
	</div><!-- box-content -->
</div><!-- container -->