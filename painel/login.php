<?php 
//se existir o cookie vai resgatar o cookie user e password
//depois vai consultar no BDD se o usuario existe
//se existir faz o login
	if(isset($_COOKIE['lembrar'])){
		$user = $_COOKIE['user'];
		$password = $_COOKIE['password'];
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
		$sql->execute(array($user,$password));
		if($sql->rowCount() == 1){
			$info = $sql->fetch();
			$_SESSION['login'] = true;
			$_SESSION['user'] = $user;
			$_SESSION['password'] = $password;
			$_SESSION['cargo'] = $info['cargo'];
			$_SESSION['nome'] = $info['nome'];
			$_SESSION['img'] = $info['img'];
			header('Location: '.INCLUDE_PATH_PAINEL);
			die();
		}
	}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Painel de controle</title>
	<!-- font open sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- metatags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
	<!-- icone site -->
	<link rel="shortcut icon" type="image-x/png" href="favicon.ico">
	<!-- charset -->
	<meta charset="utf-8">
	<!-- font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
	<!-- icone site -->
	<link rel="shortcut icon" type="image-x/png" href="<?php echo INCLUDE_PATH ?>favicon.ico">
	<!-- estilo -->
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/painel_style.css">
</head>
<body>

	<section class="login">
	<!-- da post e cria variaveis que armazenarão inputs -->
		<?php 
			if(isset($_POST['acao'])){
				$user = $_POST['user'];
				$password = $_POST['password'];
				//depois de armazenado chama o sql para a tabela de usuarios para pegar user e senha
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user = ? AND password = ?");
				//esses valores serap passados pelos post dentro das respectivas variaveis
				$sql->execute(array($user,$password));
				//conta a linha e se ouver apenas 1 valor igual, loga
				if($sql->rowCount() == 1){
					//se logar cria sessoes e redireciona com header
					//depois da um die();
					$info = $sql->fetch();//para pegar so uma coluna, no caso a do cargo
					$_SESSION['login'] = true;
					$_SESSION['user'] = $user;
					$_SESSION['password'] = $password;
					$_SESSION['cargo'] = $info['cargo'];//aqui eu passo o parametro cargo para puxar no fetch
					$_SESSION['nome'] = $info['nome'];//aqui eu passo o parametro nome para puxar no fetch
					$_SESSION['img'] = $info['img'];//aqui eu passo o parametro img para puxar no fetch
					if(isset($_POST['lembrar'])){//se existir post lembrar
						setcookie('lembrar',true,time()+(60*60*24),'/');//seta esse cookie
						setcookie('user',$user,time()+(60*60*24),'/');//seta esse cookie
						setcookie('password',$password,time()+(60*60*24),'/');//seta esse cookie
					}
					header('Location: '.INCLUDE_PATH_PAINEL);
					die();
				}else{
					echo '<div class="erro-box"><i class="fas fa-exclamation-triangle"></i> Usuário e/ou senha incorretos</div>';
				}
			}
		?>
		<div class="container">
			<h2>EFETUE SEU LOGIN:</h2>
			<form method="post">
				<input type="text" name="user" placeholder="Login..." required>
				<input type="password" name="password" placeholder="Senha..." required>
				<div class="form-group-login left">
					<input class="btn-color" type="submit" name="acao" value="Logar!">
				</div>
				<div class="form-group-login right">
					<label>Lembrar-me</label>
					<input type="checkbox" name="lembrar" />
				</div>
				<div class="clear"></div>
			</form><!-- form -->
		</div><!-- container -->
	</section><!-- login -->

<script src="<?php echo INCLUDE_PATH_PAINEL ?>js/jquery.js"></script>
</body>
</html>