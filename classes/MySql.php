<?php 
//essa class e para fazer as validações iniciais do banco de dados
class MySql{
	//variavel para acessar so na class
	private static $pdo;

	public static function conectar(){
		if(self::$pdo == null){
			try{
			self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}catch(Exception $e){
				echo '<h1>Erro no site!</h1>';
                echo '<hr />';
				echo '<h2>Aguarde um tempo, depois volte a acessar!</h2>';
                echo '<hr />';
				echo '<p>Provavelmente o servidor caiu, pode demorar minutos, horas ou dias para voltar.</p>';
                echo '<hr />';
				echo '<p>Mas não se preocupe, acesse nosso instagram: <b><a style="color:red;" href="https://www.instagram.com/freellince/">@freellince</a></b> e conheça meu trabalho!</p>';
			}
		}
		return self::$pdo;
	}
}

?>