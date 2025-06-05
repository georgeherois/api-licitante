<?php

class authenticationController extends controller {
	
	public function index(){

		$email = addslashes($_POST['email']);
		$password = addslashes($_POST['password']);

		$usuario  = new Usuarios();

		if(!empty($email) && (!empty($password))){
			if($usuario->login($email, $password)){
					if($_SESSION['tb_cod_situacao'] == 1){
						header("Location:".BASE_URL."home");
						exit;	

					}else{
						unset($_SESSION['tbLogin']);
						unset($_SESSION['tb_id']);
						session_destroy();
						$dados['alert'] = '<div class="alert alert-danger" role="alert">Usuário Suspenso!</div>';
						$this->loadView('auth-normal-sign-in', $dados);	
						}

			}else{
				$dados['alert'] = '<div class="alert alert-danger" role="alert">Email ou/ senha incorretos!</div>';
				$this->loadView('auth-normal-sign-in', $dados);	
				}

		}else{
			
			$this->loadView('auth-normal-sign-in');	
			}
		
		
	}
	


	public function sair(){
	session_start();
	session_destroy();	
	session_unset();
	
	$this->loadView('auth-normal-sign-in');

	}

}	