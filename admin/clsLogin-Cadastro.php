<?php
class User
{
    private $pdo; 
	public $msgErro = "";
	public function conectar()
	{
		global $pdo;
		try 
		{
             $pdo = new PDO("mysql:dbname="."u359090171_corretor".";host="."193.203.175.228", "u359090171_corretor", "Ricardosouza1");

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

?>
