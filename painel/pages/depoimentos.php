<div class="container">
	<div class="box-content objeto-color">
		<h2><i class="fas fa-comment-dots"></i> Cadastrar depoimentos</h2>

		<form method="post" enctype="multipart/form-data">
			<?php 
				if(isset($_POST['acao'])){
					if(Painel::inserirNoBanco($_POST)){
						Painel::alert('sucesso','Depoimento cadastrado com sucesso!');
					}else{
						Painel::alert('erro','Campos vazios não são permitidos!');
					}
				}
			?>
			<div class="form-group">
				<label>Nome do cliente:</label>
				<input type="text" name="nome">
			</div><!--form-group-->

			<div class="form-group">
				<label>Depoimento:</label>
				<textarea name="depoimento"></textarea>
			</div><!--form-group-->

			<div class="form-group">
				<label>Data:</label>
				<input formato="data" type="text" name="data">
			</div><!--form-group-->

			<div class="form-group">
				<input type="hidden" name="order_id" value="0" />
				<input type="hidden" name="nome_tabela" value="tb_site.depoimentos" />
				<input class="btn-color" type="submit" name="acao" value="Cadastrar!">
			</div><!--form-group-->

		</form>
	</div><!-- box-content -->

	<div class="box-content objeto-color">
		<h2><i class="fas fa-comment-dots"></i> Lista de depoimentos</h2>
		<div class="table-responsive tb-respons">
			<div class="row table-color">
				<div class="col-depoimento">
					<span>Nome:</span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span>Data:</span>
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
			//verifica o get na barra de endereço e apaga se for o caso
				if(isset($_GET['excluir'])){
					$idExcluir = intval($_GET['excluir']);
					Painel::deletarRegistro('tb_site.depoimentos',$idExcluir);
					Painel::redirecionar(INCLUDE_PATH_PAINEL.'depoimentos');
				}else if(isset($_GET['order']) && isset($_GET['id'])){
					Painel::ordenarItem('tb_site.depoimentos',$_GET['order'],$_GET['id']);
				}
			//se o get existir o valor deverá ser o proprio em inteiro, do corntrario é 1
				$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
				$porPagina = 4;
			//pagina atual menos 1 evita que comece do indice 1 e quando mutiplica ele aumenta numero de paginas
				$listaDepoimentos = Painel::listarTudo('tb_site.depoimentos',($paginaAtual - 1) * $porPagina,$porPagina);
				foreach ($listaDepoimentos as $key => $value) {
			?>
			<div class="row color-texto">
				<div class="col-depoimento">
					<span><?php echo $value['nome']; ?></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><?php echo $value['data']; ?></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a class="btn-editar" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-depoimento?id=<?php echo $value['id']; ?>"><i class="far fa-edit"></i> Editar</a></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
				<!-- o link manda um get com o excluir e o valor do id do depoimento e exclui -->
				<!-- o action é para poder usar o JS para exibir pergunta de excluir ou não -->
					<span><a actionBtn="deletar" class="btn-excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>depoimentos?excluir=<?php echo $value['id']; ?>"><i class="far fa-trash-alt"></i> Excluir</a></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a class="arrow-up" href="<?php echo INCLUDE_PATH_PAINEL; ?>depoimentos?order=up&id=<?php echo $value['id']; ?>"><i class="fas fa-caret-up"></i></a></span>
				</div><!--col-depoimento-->
				<div class="col-depoimento">
					<span><a class="arrow-down" href="<?php echo INCLUDE_PATH_PAINEL; ?>depoimentos?order=down&id=<?php echo $value['id']; ?>"><i class="fas fa-caret-down"></i></a></span>
				</div><!--col-depoimento-->

				<div class="clear"></div>
			</div><!--row-->
			<?php } ?>

		</div><!--table-responsive-->

		<div class="paginacao">
			<?php
			//contando tando de elementos existentes e dividindo pelo por paginas
			//ceil é para que possa haver numero de paginas quebrados tipo 3 sendo duas com 2 elementos e uma com 1
				$totalPaginas = ceil(count(Painel::listarTudo('tb_site.depoimentos')) / $porPagina);
				for($i = 1; $i <= $totalPaginas; $i++){
					if($i == $paginaAtual){
						echo '<a class="btn-pagina-selected" href="'.INCLUDE_PATH_PAINEL.'depoimentos?pagina='.$i.'">'.$i.'</a>';
					}else{
						echo '<a class="btn-pagina" href="'.INCLUDE_PATH_PAINEL.'depoimentos?pagina='.$i.'">'.$i.'</a>';
					}
				}
			?>
		</div><!-- paginacao -->
		
	</div><!-- box-content -->
</div><!-- container -->