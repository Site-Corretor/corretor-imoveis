<?php

/*CÓDIGO ANTIGO COMENTADO DEPOIS QUE FOR FEITO A HOSPEDAGEM RETIRAR O NOVO E USAR O ANTIGO */

/*
class User
{
    private $pdo; 
	public $msgErro = "";
	public function conectar()
	{
		global $pdo;
		try 
		{
            $pdo = new PDO( 'mysql:host=localhost;dbname=corretora', 'root');
            //$pdo = new PDO("mysql:dbname="."u830382291_corretor".";host="."br-asc-web1181.main-hosting.eu", "u830382291_corretor", "Ricardosouza1");

		} 
		catch (PDOException $e) 
		{
		 	$msgErro = $e->getMessage();
		} 
	}

    public function cadastrar($usuario, $senha, $email){
        global $pdo; 
        $sql = $pdo->prepare("INSERT INTO cadastro (usuario,senha, email) VALUES (:nome, :senha, :email);");
        $sql->bindValue(":nome", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":email", $email);
        $sql->execute();
        return true;
    }

    public function cadastrarImovel()
    {

    }

    public function logar($user,$senha){
        global $pdo; 
        $sql =$pdo->prepare("SELECT * FROM cadastro WHERE usuario = '".$user."' AND senha = '".$senha."';");
        $sql->execute(); 
        if($sql->rowCount() > 0)
        {		
            session_start();
            $dado = $sql->fetch();
            $_SESSION = $dado;
            $_SESSION['usuario'] = $dado['usuario'];
            $_SESSION['acesso'] = $dado['acesso'];
            return true; 
        }
        else
        {
            return false;
        }
    }
    public function seguranca(){
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM seguranca;");   
  
        $sql->execute();
        $lista = $sql->fetchAll();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }

   
}
*/

/*CÓDIGO NOVO PARA TESTE LOCAL */


class User
{
    private $pdo;
    public $msgErro = "";

    public function conectar()
    {
        global $pdo;

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=corretora', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->msgErro = $e->getMessage();
        }
    }

    /*public function cadastrar($usuario, $senha, $email)
    {
        global $pdo;

        $sql = $pdo->prepare("INSERT INTO cadastro (usuario, senha, email) VALUES (:nome, :senha, :email)");
        $sql->bindValue(":nome", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":email", $email);
        $sql->execute();

        return true;
    }*/

    public function cadastrar($usuario, $senha, $email)
    {
        global $pdo;

        $sql = $pdo->prepare("SELECT id FROM cadastro WHERE usuario = :usuario OR email = :email LIMIT 1;");
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $dadosExistentes = $sql->fetch(PDO::FETCH_ASSOC);

            $sqlUsuario = $pdo->prepare("SELECT id FROM cadastro WHERE usuario = :usuario LIMIT 1;");
            $sqlUsuario->bindValue(":usuario", $usuario);
            $sqlUsuario->execute();

            if ($sqlUsuario->rowCount() > 0) {
                return "Este nome de usuário já está cadastrado.";
            }

            $sqlEmail = $pdo->prepare("SELECT id FROM cadastro WHERE email = :email LIMIT 1;");
            $sqlEmail->bindValue(":email", $email);
            $sqlEmail->execute();

            if ($sqlEmail->rowCount() > 0) {
                return "Este e-mail já está cadastrado.";
            }

            return "Usuário já cadastrado.";
        }

        $sql = $pdo->prepare("INSERT INTO cadastro (usuario, senha, email) VALUES (:usuario, :senha, :email);");
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":email", $email);
        $sql->execute();

        return true;
    }

    public function cadastrarImovel()
    {
        // Método reservado para uso futuro
    }

    public function logar($user, $senha)
    {
        global $pdo;

        $sql = $pdo->prepare("SELECT * FROM cadastro WHERE usuario = :usuario AND senha = :senha");
        $sql->bindValue(":usuario", $user);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $dado = $sql->fetch(PDO::FETCH_ASSOC);

            $_SESSION = $dado;
            $_SESSION['usuario'] = $dado['usuario'];
            $_SESSION['acesso'] = $dado['acesso'];

            return true;
        } else {
            return false;
        }
    }

    public function seguranca()
    {
        global $pdo;

        try {
            $sql = $pdo->prepare("SELECT * FROM seguranca");
            $sql->execute();

            $lista = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($sql->rowCount() > 0) {
                return $lista;
            } else {
                return [
                    ['seguranca' => '123456']
                ];
            }
        } catch (PDOException $e) {
            return [
                ['seguranca' => '123456']
            ];
        }
    }
}


?>
