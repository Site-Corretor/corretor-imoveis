<?php
class Principal
{
    private $pdo; 
	public $msgErro = "";
	public function conectar()
	{
		global $pdo;
		try 
		{
            // $pdo = new PDO( 'mysql:host=localhost;dbname=corretora', 'root');
            $pdo = new PDO("mysql:dbname="."u830382291_corretor".";host="."br-asc-web1181.main-hosting.eu", "u830382291_corretor", "Ricardosouza1");

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

    public function logar($user,$senha){
        global $pdo; 
        $sql =$pdo->prepare("SELECT * FROM cadastro WHERE usuario = '".$user."' AND senha = '".$senha."';");
        $sql->execute(); 
        $lista = $sql->fetch();
        if($sql->rowCount() > 0)
        {		

            return $lista; 
        }
        else
        {
            return false;

        }
    }

    public function visualizar(){
        global $pdo; 
        $sql = $pdo->prepare("SELECT * FROM imoveis;");
        $sql->execute(); 
        $lista = $sql->fetchAll();
        if($sql->rowCount() > 0)
        {		
            return $lista; 
        }
        else
        {
            return false;

        }
    }

    public function imovel($codigo){
        global $pdo; 
        $sql =$pdo->prepare("SELECT * FROM imoveis WHERE codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute(); 
        $lista = $sql->fetch();
        if($sql->rowCount() > 0)
        {		
            return $lista; 
        }   
        else
        {
            return false;

        }
    }

    public function imagem($codigo) {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM regstro_anexos WHERE codigo = :codigo AND capa = 1;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        
        $imagemCapa = $sql->fetch();
        
        if ($sql->rowCount() > 0) {
            return $imagemCapa; 
        } else {
            return false;
        }
    }
    
    public function tdsImagem($codigo) {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM regstro_anexos WHERE codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        
        $imagemGeral = $sql->fetchAll();
        
        if ($sql->rowCount() > 0) {
            return $imagemGeral; 
        } else {
            return false;
        }
    }

}

?>