<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	class Email{

		private $mailer;
		
		public function __construct($host,$username,$senha,$name){
			
			$this->mailer = new PHPMailer(true);
			
			$this->mailer->SMTPDebug =0;                  
		    $this->mailer->isSMTP();                                           
		 	$this->mailer->Host = $host;/*'smtp.gmail.com'; */    
		 	$this->mailer->SMTPAuth= true;             
		  	$this->mailer->Username = $username;/*'andreduartesilva5@gmail.com';*/
			$this->mailer->Password = $senha;/*'naobula123';*/
			$this->mailer->SMTPSecure = 'STARTTLS';
			$this->mailer->Port = 587;                           

			$this->mailer->setFrom($username,$name);
			$this->mailer->isHTML(true);
			$this->mailer->CharSet = 'UTF-8';


		}

		public function addAdress($email,$nome){
		    $this->mailer->addAddress($email,$nome);     
		}

		public function formatarEmail($info){
			$this->mailer->Subject = $info['assunto'];
			$this->mailer->Body = $info['corpo'];
			$this->mailer->AltBody = strip_tags($info['corpo']);
		}

		public function enviarEmail(){
			if($this->mailer->send()){
				return true;
			}else{
				return false;
			}
		}
	}

?>