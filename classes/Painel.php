<?php 
	
class Painel
{
	//1
	public static function logado(){
		//retorna se a sessao login existir, se nao nao retorna
		return isset($_SESSION['login']) ? true : false;
	}
	//2
	public static function loggout(){
		//destroi o longi (logout) e cookie e redireciona
		setcookie('lembrar',true,time()-1,'/');
		session_destroy();
		header('Location: '.INCLUDE_PATH_PAINEL);
	}
	//3
	public static function carregarPagina(){
	//se existir o url
		if(isset($_GET['url'])){
		//vai armazenar a url depois da barra por causa do explode que separa
		//exem: meusite/home (vai pegar a home) e botar nessa variavel
			$url = explode('/',$_GET['url']);
		//se existir um arquivo com nome que foi pego da url na pasta 'pages'
			if(file_exists('pages/'.$url[0].'.php')){
			//inclue a mesma
				include('pages/'.$url[0].'.php');
			}else{
				//pagina nao existe vai pra home
				header('Location: '.INCLUDE_PATH_PAINEL);
			}

		}else{
			include('pages/home.php');
		}
	}
	//5
	public static function listarUsuariosOnline(){
		self::limparUsuariosInativos();
		//seleciona tudo
		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
		$sql->execute();
		return $sql->fetchAll();
	}
	//6
	public static function limparUsuariosInativos(){
		$date = date('Y-m-d H:i:s');
		//deleta se ja tiver passado 1 minuto desde a data e hora atual
		$sql = MySql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 3 MINUTE ");
	}
	//8
	public static function pegaVisitasTotal(){
		//seleciona tudo, executa a query e da rowCount para contar quantas existem
		$pegarTotalVisitas = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas`");
		$pegarTotalVisitas->execute();
		$pegarTotalVisitas = $pegarTotalVisitas->rowCount();
		//isso vai retornar o resultado da contagem e será chamado na home
		return $pegarTotalVisitas;
	}
	//9
	public static function visitasHoje(){
		//seleciona tudo, executa a query e da rowCount para contar quantas existem se dia for igual hoje(dia corrente)
		$visitasHoje = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` WHERE dia = ?");
		$visitasHoje->execute(array(date('Y-m-d')));
		$visitasHoje = $visitasHoje->rowCount();
		//isso vai retornar o resultado da contagem e será chamado na home
		return $visitasHoje;
	}
	//10
	public static function alert($tipo,$mensagem){
		if($tipo == 'sucesso'){
			echo '<div class="sucesso-box"><i class="fas fa-check-circle"></i> '.$mensagem.'</div>';
		}else if($tipo == 'erro'){
			echo '<div class="erro-box"><i class="fas fa-times-circle"></i> '.$mensagem.'</div>';
		}
	}
	//12
	public static function imagemValida($imagem){
	//se a imagem selecionada for de algum desses tipos
		if($imagem['type'] == 'image/jpeg' ||
		 	$imagem['type'] == 'image/jpg' ||
		 	$imagem['type'] == 'image/png' ){
		//vai pegar o tamanho em KB dividindo os bits por 1024 e dando intval para ficar inteiro
			$tamanho = intval($imagem['size']/1024);
		//se o tamanho for menor que 9000kb da true e se nao, da false
			if($tamanho < 9000){
				return true;
			}else{
				return false;
			}
		//retorna true se tudo correr bem
			return true;
		}else{
		//caso de errado
			return false;
		}
	}
	//13
	public static function uploadFile($file){
	//essa vai pegar o tipo de arquivo que fica depois do ponto ex: .jpg
		$formatoAquivo = explode('.', $file['name']);
	//essa vai receber um id unico que terminará com .indice[0] de $formatoArquivo
	//mesmo que dizer ex: uniqic.jpg
		$imagemNome = uniqid().'.'.$formatoAquivo[count($formatoAquivo) - 1];
	//se conseguir mover o arquivo para a pasta
		if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome)){
		//retorna o nome do arquivo para ficar selecionado no input file
			return $imagemNome;
		}else{
			return false;
		}
	}
	//14
	public static function deleteFile($file){
	//apaga o arquivo no diretorio relativo
	//file é o arquivo passado
		@unlink('uploads/'.$file);
	}
	//15
	public static $cargos = [
	//variavel static global de cargos
		'0' => '<i class="fas fa-user-circle icon-color"></i> Normal',
		'1' => '<i class="fas fa-user-tie icon-color"></i> Sub Administrador',
		'2' => '<i class="fas fa-briefcase icon-color"></i> CEO'
	];
	//18
	public static $cargosHome = [
	//variavel static global de cargos
		'0' => '<i class="fas fa-user-circle"></i> Normal',
		'1' => '<i class="fas fa-user-tie"></i> Sub Administrador',
		'2' => '<i class="fas fa-briefcase"></i> CEO'
	];
	//19
	public static function inserirNoBanco($arr){
	//variavel auxiliar e variavel que recupera nome da tabela
		$certo = true;
		$nome_tabela = $arr['nome_tabela'];
		//começo da query
		$query = "INSERT INTO `$nome_tabela` VALUES (null";
		//esse vai percorrer o parameto da função e achar os valores postados
		//imagina esse foreach dentro da query tipo prepare("coisa do database values (foreach juntando tudo)");
		foreach ($arr as $key => $value) {
			//key é tipo $titulo => valor do form dentro do array
			$nome = $key;
			$valor = $value;
			if($nome == 'acao' || $nome == 'nome_tabela')
				continue;
			if($value == ''){
			//se o valor for vazio para o codigo
				$certo = false;
				break;
			}
			//sendo verdadeiro continua montando a query aqui dentro do foreach
			$query.=",?";//esse interrogação e como se tivesse adicionando cada vez que entra novo dado obtifo do looping
			$parametros[] = $value;//esse parameto é o conjunto de todos os valores postados
		}
		//aqui finaliza a query
		$query.=")";
		if($certo == true){
			//se certo for true quer dizer que ele nao parou no meio do codigo
			//entao conecta e coloca a query no prepare e executa o parametro com todos os valores
			$sql = MySql::conectar()->prepare($query);
			$sql->execute($parametros);
			$lastId = MySql::conectar()->lastInsertId();
			$sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastId");
			$sql->execute(array($lastId));
		}
		//retorna o certo é o mesmo que true
		return $certo;
	}
	//20
	// $start = null,$end = null opcionais. seleciona tudo
	public static function listarTudo($tabela,$start = null,$end = null){
		if($start == null && $end == null){
			$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
		}else{
			$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
		}

		$sql->execute();
		return $sql->fetchAll();
	}
	//21
	public static function deletarRegistro($tabela,$id = false){
	//se não tiver id
		if($id == false){
			$sql = MySql::conectar()->prepare("DELETE FROM `$tabela`");
		}else{
	//se tiver id
			$sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
		}
		$sql->execute();
	}
	//22
	public static function redirecionar($url){
		echo '<script>location.href="'.$url.'"</script>';
		die();
	}
	//23
	//seleciona apenas 1 com base na tabela, na query e no array
	//ex: SELECT * FROM `$tabela` WHERE id = $arr
	public static function listar($tabela,$query,$arr){
		$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE $query");
		$sql->execute($arr);
		return $sql->fetch();
	}
	//24
	public static function atualizarBanco($arr){
	//parecido com o de inserir
		$first = false;
		$certo = true;
		$nome_tabela = $arr['nome_tabela'];
		$query = "UPDATE `$nome_tabela` SET ";
		foreach ($arr as $key => $value) {
			$nome = $key;
			$valor = $value;
			if($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
				continue;
			if($value == ''){
				$certo = false;
				break;
			}
			if($first ==  false){
				$first = true;
				$query.="$nome=?";
			}else{
				$query.=",$nome=?";
			}
			$parametros[] = $value;

		}
		if($certo == true){
			$parametros[] = $arr['id'];
			$sql = MySql::conectar()->prepare($query.' WHERE id=? ');
			$sql->execute($parametros);
		}
		return $certo;
	}
	//25
	public static function ordenarItem($tabela,$orderType,$idItem){
		if($orderType == 'up'){
			$infoItemAtual = Painel::listar($tabela,'id=?',array($idItem));
			$order_id = $infoItemAtual['order_id'];
			$itemAntes = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");	
			$itemAntes->execute();
			if($itemAntes->rowCount()==0){
				return;
			}
			$itemAntes = $itemAntes->fetch();
			Painel::atualizarBanco(array('nome_tabela'=>$tabela,'id'=>$itemAntes['id'],'order_id'=>$infoItemAtual['order_id']));
			Painel::atualizarBanco(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemAntes['order_id']));

		}else if($orderType == 'down'){
			$infoItemAtual = Painel::listar($tabela,'id=?',array($idItem));
			$order_id = $infoItemAtual['order_id'];
			$itemDepois = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");	
			$itemDepois->execute();
			if($itemDepois->rowCount()==0){
				return;
			}
			$itemDepois = $itemDepois->fetch();
			Painel::atualizarBanco(array('nome_tabela'=>$tabela,'id'=>$itemDepois['id'],'order_id'=>$infoItemAtual['order_id']));
			Painel::atualizarBanco(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemDepois['order_id']));
		}
	}
	//26
	public static function selecionarTudo($tabela,$start = null,$end = null){
		if($start == null && $end == null){
			$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela`");
		}else{
			$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` DESC LIMIT $start,$end");
		}

		$sql->execute();
		return $sql->fetchAll();
	}
    //27
	//sem order id
	public static function inserirDataBase($arr){
	//variavel auxiliar e variavel que recupera nome da tabela
		$certo = true;
		$nome_tabela = $arr['nome_tabela'];
		//começo da query
		$query = "INSERT INTO `$nome_tabela` VALUES (null";
		//esse vai percorrer o parameto da função e achar os valores postados
		//imagina esse foreach dentro da query tipo prepare("coisa do database values (foreach juntando tudo)");
		foreach ($arr as $key => $value) {
			//key é tipo $titulo => valor do form dentro do array
			$nome = $key;
			//$valor = $value;
			if($nome == 'acao' || $nome == 'nome_tabela')
				continue;
			if($value == ''){
			//se o valor for vazio para o codigo
				$certo = false;
				break;
			}
			//sendo verdadeiro continua montando a query aqui dentro do foreach
			$query.=",?";//esse interrogação e como se tivesse adicionando cada vez que entra novo dado obtido do looping
			$parametros[] = $value;//esse parameto é o conjunto de todos os valores postados
		}
		//aqui finaliza a query
		$query.=")";
			

		if($certo == true){
			//se certo for true quer dizer que ele nao parou no meio do codigo
			//entao conecta e coloca a query no prepare e executa o parametro com todos os valores
			$sql = MySql::conectar()->prepare($query);
			$sql->execute($parametros);
		}
		//retorna o certo é o mesmo que true
		return $certo;
	}

}

?>