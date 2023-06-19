<?php verificaPermissaoPagina(2) ?>
<div class="container">
	<div class="box-content objeto-color">

		<h2><i class="fas fa-user-plus"></i> Cadastrar usuário</h2>
		
		<form method="post" enctype="multipart/form-data">
			<?php 
				if(isset($_POST['acao'])){
					$nome = $_POST['nome'];
					$user = $_POST['usuario'];
					$senha = $_POST['password'];
					$cargo = $_POST['cargo'];
					$imagem = $_FILES['imagem'];

					if($nome == ''){
						Painel::alert('erro','Escolha um nome de usuário!');
					}else if($senha == ''){
						Painel::alert('erro','Escolha uma senha!');
					}else if($user == ''){
						Painel::alert('erro','Insira um nome!');
					}else if($cargo == ''){
						Painel::alert('erro','Selecione um cargo!');
					}else if($imagem['name'] == ''){
						Painel::alert('erro','A imagem precisa estar selecionada!');
					}else{
						if($cargo >= $_SESSION['cargo']){
							Painel::alert('erro','Precisa adicionar um cargo menor que o seu!');
						}else if(Painel::imagemValida($imagem) ==  false){
							Painel::alert('erro','A imagem não é válida!');
						}else if(Usuario::usuarioExiste($user)){
							Painel::alert('erro','Este usuario já existe!');
						}else{
							$usuario = new Usuario();
							$imagem = Painel::uploadFile($imagem);
							$usuario->cadastrarUsuario($user,$senha,$imagem,$nome,$cargo);
							Painel::alert('sucesso','O cadastro do usuário '.$user.' foi um sucesso!');
						}
					}


				}
			?>

			<div class="form-group">
				<label>Nome:</label>
				<input type="text" name="nome" value="">
			</div><!-- form-group -->

			<div class="form-group">
				<label>Usuário:</label>
				<input type="text" name="usuario" value="">
			</div><!-- form-group -->

			<div class="form-group">
				<label>Senha:</label>
				<input type="password" name="password" value="">
			</div><!-- form-group -->

			<div class="form-group">
				<label>Cargo:</label>
				<select name="cargo">
					<?php
						foreach (Painel::$cargos as $key => $value) {
							if($key < $_SESSION['cargo']){
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
						}
					?>
				</select>
			</div><!-- form-group -->

			<div class="form-group">
				<label>Imagem:</label>
				<input type="file" name="imagem"/>
			</div><!--form-group-->

			<div class="form-group">
				<input class="btn-color" type="submit" name="acao" value="Cadastrar!">
			</div><!--form-group-->
		</form><!-- form -->

	</div><!-- box-content -->
</div><!-- container -->