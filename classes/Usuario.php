<?php 
	
	class Usuario{

		//11
		public function atualizarUsuario($usuario,$nome,$senha,$imagem){
		//os parametros sao os posts da pagina editar-usuario
		//estou dando update nas colunas correpondentes onde o usuario for igual o da sessao
			$sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET user =?,password = ?,img = ?,nome = ? WHERE user = ?");
		//se conseguir executar isso retorna true e se não, retorna false
			if($sql->execute(array($usuario,$senha,$imagem,$nome,$_SESSION['user']))){
				return true;
			}else{
				return false;
			}
		}
		//16
		public static function usuarioExiste($user){
		//seleciona pelo id todos os usuario
		//o $user e passado na pagina de cadastro e é o post usuario
			$sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.usuarios` WHERE user = ?");
			$sql->execute(array($user));
			if($sql->rowCount() == 1){
			//se quando percorrer existir algum usuario igual retorna true
			//assim ele entra no if e ativa a mensagem do painel
				return true;
			}else{
			//se nao ecistir ele nao retorna nada e passa direto
				return false;
			}
		}
		//17
		public static function cadastrarUsuario($user,$senha,$img,$nome,$cargo){
		//insere o que recebe na tabela
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES (null,?,?,?,?,?)");
		//executa
			$sql->execute(array($user,$senha,$img,$nome,$cargo));
		}
	}

?>