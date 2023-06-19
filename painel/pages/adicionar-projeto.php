<div class="container">

    <div class="box-content objeto-color">
		<h2><i class="fas fa-sitemap"></i> Cadastrar Frete</h2>
		
		<form method="post">

			<?php 
				if(isset($_POST['acaoFrete'])){
					$valor = $_POST['valorFrete'];
					if($sql = MySql::conectar()->prepare("UPDATE `tb_admin.frete` SET valor = $valor")){
						$sql->execute();
						Painel::alert('sucesso','Frete novo adicionado com sucesso!');
					}
				}
			?>

			<div class="form-group">
				<label>Valor frete:</label>
				<input type="text" name="valorFrete"/>
			</div><!--form-group-->

			<div class="form-group">
				<input type="hidden" name="nome_tabela" value="tb_admin.frete">
				<input class="btn-color" type="submit" name="acaoFrete" value="Cadastrar!">
			</div><!--form-group-->
		</form><!-- form -->
	</div><!-- box-content -->

	<div class="box-content objeto-color">
		<h2><i class="fas fa-sitemap"></i> Cadastrar Produto</h2>
		
		<form method="post" enctype="multipart/form-data">

			<?php 
				if(isset($_POST['acao'])){
					$nome_site = $_POST['nome_site'];
					$preco = $_POST['preco'];
					$descricao = $_POST['descricao'];
					$imagem = $_FILES['imagem'];

					if($nome_site == ''){
						Painel::alert('erro','O nome não pode estar vazio!');
					}else if($preco == ''){
						Painel::alert('erro','O link não pode estar vazio!');
					}else if ($imagem['name'] != '') {
						if(Painel::imagemValida($imagem) == false){
							Painel::alert('erro','A imagem não é válida!');
						}else{
							$imagem = Painel::uploadFile($imagem);
							$sql = MySql::conectar()->prepare("INSERT INTO `tb_site.produtos` VALUES (null,?,?,?,?)");
							if($sql->execute(array($nome_site,$preco,$descricao,$imagem))){
								Painel::alert('sucesso','Produto novo adicionado com sucesso!');
							}else{
								$imagem = '';
								Painel::alert('erro','Erro ao adicionar novo produto!');
							}
						}
					}else{
						Painel::alert('erro','Imagem está vazia!');
					}
				}

			?>

			<div class="form-group">
				<label>Nome do produto:</label>
				<input type="text" name="nome_site"/>
			</div><!--form-group-->

			<div class="form-group">
				<label>Preço:</label>
				<textarea name="preco"></textarea>
			</div><!--form-group-->

			<div class="form-group">
				<label>Descrição:</label>
				<textarea name="descricao"></textarea>
			</div><!--form-group-->

			<div class="form-group">
				<label>Imagem do produto:</label>
				<input type="file" name="imagem"/>
			</div><!--form-group-->
<!-- -------------------------------------------------------------------------------------------------- -->
			<div class="form-group">
				<input class="btn-color" type="submit" name="acao" value="Cadastrar!">
			</div><!--form-group-->
		</form><!-- form -->
	</div><!-- box-content -->

	<div class="box-content objeto-color">
		<h2><i class="fas fa-sitemap"></i> Lista de Produtos</h2>
		<div class="table-responsive tb-respons">
			<div class="row table-color">
				<div class="col-proj">
					<span>Nome:</span>
				</div><!--col-depoimento-->
				<div class="col-proj">
					<span>Imagem:</span>
				</div><!--col-depoimento-->
				<div class="col-proj">
					<span>Editar:</span>
				</div><!--col-depoimento-->
				<div class="col-proj">
					<span>Excluir:</span>
				</div><!--col-depoimento-->
				<div class="clear"></div>
			</div><!--row-->
			<?php 
				if(isset($_GET['excluir'])){
					$idExcluir = intval($_GET['excluir']);
					$projImg = Painel::listar('tb_site.produtos','id = ?',array($idExcluir));
					$img = $projImg['imagem'];
					Painel::deleteFile($img);
					Painel::deletarRegistro('tb_site.produtos',$idExcluir);
					Painel::redirecionar(INCLUDE_PATH_PAINEL.'adicionar-projeto');
				}

				$listaProjetos = Painel::selecionarTudo('tb_site.produtos');
				foreach ($listaProjetos as $key => $value) {
			?>
			<div class="row color-texto">
				<div class="col-proj">
					<span><?php echo $value['nome']; ?></span>
				</div><!--col-depoimento-->
				<div class="col-proj">
					<span><img style="width:60px" src="<?php echo INCLUDE_PATH_PAINEL ?>/uploads/<?php echo $value['imagem']; ?>"></span>
				</div><!--col-depoimento-->
				<div class="col-proj">
					<span><a class="btn-editar" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-projeto?id=<?php echo $value['id']; ?>"><i class="far fa-edit"></i> Editar</a></span>
				</div><!--col-depoimento-->
				<div class="col-proj">
					<span><a actionBtn="deletar" class="btn-excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-projeto?excluir=<?php echo $value['id']; ?>"><i class="far fa-trash-alt"></i> Excluir</a></span>
				</div><!--col-depoimento-->
				<div class="clear"></div>
			</div><!--row-->
			<?php } ?>
		</div><!--table-responsive-->
		
	</div><!-- box-content -->
</div><!-- container -->