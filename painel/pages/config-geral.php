<div class="container">
	<div class="box-content objeto-color">
		<h2><i class="fas fa-sliders-h"></i> Configuração geral</h2>
		
		<form method="post" enctype="multipart/form-data">
			<?php 
				if(isset($_POST['acao'])){
					$titulo = $_POST['titulo'];
					$chamada = $_POST['chamada'];
					$imagem = $_FILES['imagem'];
					$imagem_atual = $_POST['imagem_atual'];
					$sobre = $_POST['sobre_empresa'];
				//para poder puxar imagem atual do site index
				//so vai funcionar se tiver uma imagem na tabela, mas é inperceptivel pois vai
				//ser adicionado no primeiro acesso
					$sql = MySql::conectar()->prepare("SELECT `imagem` FROM `tb_site.config`");
					$sql->execute();
					$sql = $sql->fetch();
				//agora a imagem atual é a imagem da tabela
					$imagem_atual = $sql['imagem'];
				//////////////////////////////////////////////////////
					if($titulo == ''){
						Painel::alert('erro','O título não pode estar vazio!');
					}else if($chamada == ''){
						Painel::alert('erro','A chamada não pode estar vazia!');
					}else if($sobre == ''){
						Painel::alert('erro','Sobre empresa não pode estar vazio!');
					}else if($imagem['name'] != ''){	
						//se a imagem nao for valida
						if(Painel::imagemValida($imagem) ==  false){
							Painel::alert('erro','A imagem não é válida!');
						}else{
						//se a imagem for valida
							//apaga a imagem atual para substituir
							Painel::deleteFile($imagem_atual);
							//substituir por essa do upload feito pela class
							$imagem = Painel::uploadFile($imagem);
							$sql = MySql::conectar()->prepare("UPDATE `tb_site.config` SET titulo = ?, chamada = ?, imagem = ?, sobre_empresa = ? WHERE id =? ");
							if($sql->execute(array($titulo,$chamada,$imagem,$sobre,1))){
								Painel::alert('sucesso','Configurações cadastradas com sucesso!');
							}else{
								Painel::alert('erro','Erro ao cadastrar configurações!');
							};
						}
					}else{
					//se nao for trocar a imagem ela vai ser a propria imagem_atual que ja tem na tabela
						$imagem = $imagem_atual;
						$sql = MySql::conectar()->prepare("UPDATE `tb_site.config` SET titulo = ?, chamada = ?, imagem = ?, sobre_empresa = ? WHERE id =? ");
						if($sql->execute(array($titulo,$chamada,$imagem,$sobre,1))){
							Painel::alert('sucesso','Configurações cadastradas com sucesso!');
						}else{
							Painel::alert('erro','Algum erro ocorreu, pode ser que a imagem esteja vazia!');
						}
					}
				}
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
				$sql->execute();
				$sql = $sql->fetch();
			?>
		
			<div class="form-group">
				<label>Título do site:</label>
				<input type="text" name="titulo" value="<?php echo $sql['titulo'] ?>" />
			</div><!--form-group-->

			<div style="display:none;" class="form-group">
				<label>Texto do banner:</label>
				<textarea name="chamada">pode deixar em branco</textarea>
			</div><!--form-group-->

			<div style="display:none;" class="form-group">
				<label>Imagem do banner:</label>
				<input type="file" name="imagem"/>
				<input type="hidden" name="imagem_atual" value="<?php echo $imagem_atual; ?>">
			</div><!--form-group-->
<!-- -------------------------------------------------------------------------------------------------- -->
			<div style="display:none;" class="form-group">
				<label>Aqui pode deixar uma #:</label>
				<textarea name="sobre_empresa">#</textarea>
			</div><!--form-group-->
<!-- -------------------------------------------------------------------------------------------------- -->
			<div class="form-group">
				<input class="btn-color" type="submit" name="acao" value="Atualizar!">
			</div><!--form-group-->
		</form><!-- form -->
	</div><!-- box-content -->
</div><!-- container -->