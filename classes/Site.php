<?php 

	class Site{

		//4
		public static function updateUsuarioOnline(){
		//se existir a sessao online
			if(isset($_SESSION['online'])){
			//o token sera a sessao online
			//horaAtual é o q já diz
				$token = $_SESSION['online'];
				$horarioAtual = date('Y-m-d H:i:s');
			//para checar o id em relacao ao token da session online
			//Isso vai servir para que verifique o numero antes de deletar da tabela
				$check = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ? ");
				$check->execute(array($_SESSION['online']));
			//se a contagem for exatamente 1, ou seja: so a 1 id para 1 token executa a UPDATE
				if($check->rowCount() == 1){
				//dando UPDATE no sql na tabela online inserindo os valores pegados nas variaveis
					$sql = MySql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");
				//aqui esta inserindo os valores nos lugares das "?"
					$sql->execute(array($horarioAtual,$token));
				}else{
					//mesma coisa do passo a baixo mesno a session pois ja existe
					$ip = $_SERVER['REMOTE_ADDR'];
					$token = $_SESSION['online'];
					$horarioAtual = date('Y-m-d H:i:s');
					$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?) ");
					$sql->execute(array($ip,$horarioAtual,$token));
				}
			}else{
			//se nao existir a sessao online cria uma com um unicoID gerado pelo php
				$_SESSION['online'] = uniqid();
			//o ip será pego pelo php com essa função que retorna justamento o ip do usuario online
				$ip = $_SERVER['REMOTE_ADDR'];
			//token agora recebe a sessao com uniqID gerado anteriormente
				$token = $_SESSION['online'];
			//mesma coisa da anterios
				$horarioAtual = date('Y-m-d H:i:s');
			//agora ao inves de update é inseridos os dados a cima na tabela
			//esse NULL é o id que é automatico entao coloca assim pra num da erro e deixar a tabela fazer o dela sozinha
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?) ");
			//novamente subistituindo os pontos de "?"
				$sql->execute(array($ip,$horarioAtual,$token));
			}

		}//updateUsuarioOnline------------------

		//7
		public static function contadorVisitas(){
			if(!isset($_COOKIE['visita'])){
			//se nao existir o cookie visita então cria 1 que expira em 7 dias
				setcookie('visita',true,time() + (60*60*24*7) );
			//insere no banco de dados o IP e a DATA de hoje(dia corrente)
				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES (null,?,?) ");
				$sql->execute(array($_SERVER['REMOTE_ADDR'],date('Y-m-d')));
				//está sendo chamado no index do site
			}
		}//contadorVisitas------------------
	}
?>