<div class="container">
	<div class="box-content objeto-color">
		<h2><i class="fas fa-user-edit"></i> Editar usuário</h2>
		
		<form method="post" enctype="multipart/form-data">
			<?php 
			//se exisitir o pos cria variaveis com os posts do formulario
				if(isset($_POST['acao'])){
					$nome = $_POST['nome'];
					$user = $_POST['usuario'];
					$senha = $_POST['password'];
				//essa imagem aqui é do input file
					$imagem = $_FILES['imagem'];
				//essa é do input hidden com a imagem da sessao para caso de nao querer trocar
					$imagem_atual = $_POST['imagem_atual'];
				//instanciando a classe usuario
					$usuario = new Usuario();
					if($imagem['name'] != ''){
					//se o nome da imagem upada for diferente de vazio
						if(Painel::imagemValida($imagem)){
						//se o a imagem for valida deleta a imagem atual
						//e depois colocar o upload numa variavel imagem com a imagem pegada no files
							Painel::deleteFile($imagem_atual);
							$imagem = Painel::uploadFile($imagem);
							if($usuario->atualizarUsuario($user,$nome,$senha,$imagem)){
							//se a condição a cima for verdade cria duas sessoes img e nome
							//isso vai fazer mudar nome e imagem ao atualiar a pagina sem ter que sair
								$_SESSION['img'] = $imagem;
								$_SESSION['nome'] = $nome;
								Painel::alert('sucesso','Sucesso ao atualizar usuario!');
							}else{
								Painel::alert('erro','Ocorreu um erro ao atualizar usuario!');
							}
						}else{
							Painel::alert('erro','Formato da imagem não é válido!');
						}
					}else{
						//se der errado ou se estivar vazio entao usa a imagem_atual
						$imagem = $imagem_atual;
						if($usuario->atualizarUsuario($user,$nome,$senha,$imagem)){
							Painel::alert('sucesso','Sucesso ao atualizar usuario!');
						}else{
							Painel::alert('erro','Ocorreu um erro ao atualizar usuario!');
						}
					}
				}
			?>

			<div class="form-group">
				<label>Nome:</label>
				<input type="text" name="nome" value="<?php echo $_SESSION['nome'] ?>">
			</div><!-- form-group -->

			<div class="form-group">
				<label>Usuário:</label>
				<input type="text" name="usuario" value="<?php echo $_SESSION['user'] ?>">
			</div><!-- form-group -->

			<div class="form-group">
				<label>Senha:</label>
				<input type="password" name="password" value="<?php echo $_SESSION['password'] ?>">
			</div><!-- form-group -->

			<div class="form-group">
				<label>Imagem:</label>
				<input type="file" name="imagem"/>
				<input type="hidden" name="imagem_atual" value="<?php echo $_SESSION['img']; ?>">
			</div><!--form-group-->

			<div class="form-group">
				<input class="btn-color" type="submit" name="acao" value="Atualizar!">
			</div><!--form-group-->
		</form><!-- form -->

	</div><!-- box-content -->
</div><!-- container -->
