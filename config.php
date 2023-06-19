<?php 
	session_start();
		date_default_timezone_set('America/Fortaleza');
		//autoload para as classes
		$autoload = function($class){
			if($class == 'Email'){
				require_once('vendor/phpmailer/phpmailer/src/PHPMailer.php');
			};
			include('classes/'.$class.'.php');
		};
	//vai registrar o autoload e se não tiver ativo ela será ativada fazendo assim as classes serem ativadas
	spl_autoload_register($autoload);
	
	//diretorio principal
	define('INCLUDE_PATH', 'http://localhost');
	//isso serve para o painel de controle
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');
	//essa constante foi criada na class painel para poder verificar a pasta uploads
	//dir é uma constante fix do proprio php que pega o diretorio em que nos encontramos
	define('BASE_DIR_PAINEL',__DIR__.'/painel/');

	//para caso precise do nome da empresa
	define('NOME_EMPRESA','yourName');

	//Para conectar ao banco de dados
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','delivery');

	//funções
	function pegaCargo($indice){
		//classificacao de cargo do painel 
		//se encontra na class painel agora
		//retorna o cargo que eu passar la onde chamo a função
		return Painel::$cargos[$indice];
	}

	function pegaCargoHome($indice){
		//classificacao de cargo do painel 
		//se encontra na class painel agora
		//retorna o cargo que eu passar la onde chamo a função
		return Painel::$cargosHome[$indice];
	}

	function selecionadoMenu($par){
	//função para deixar selecionado o link de acodro com url
	//o parametro par vai equivaler a url clicada pois foi passado dentro dos parentesis nos links
	//cria variavel e separa de acordo com barra e pega o que vem depois
		$url = explode('/', @$_GET['url'])[0];
		if($url == $par){
		//se a url for igual do par
		//da echo nessa class dentro do link
			echo 'class="active"';
		}
	}

	function verificaPermissaoMenu($permissao){
	//se o cargo do user em sessáo for maior ou igual que o parametro
		if($_SESSION['cargo'] >= $permissao){
		//so retorna normal
			return;
		}else{
		//se for meno vai apagar o menu correpondente
			echo 'style="display:none;"';
		}
	}

	function verificaPermissaoPagina($permissao){
	//se o cargo do user em sessáo for maior ou igual que o parametro
		if($_SESSION['cargo'] >= $permissao){
		//so retorna normal
			return;
		}else{
		//se for meno vai apagar a pagina correpondente
			include('painel/pages/permissao-negada.php');
			die();
		}
	}
?>