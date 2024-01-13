<?php
class User
{
    private $pdo;
    public $msgErro = "";
    public function conectar()
    {
        global $pdo;
        try {
            // $pdo = new PDO('mysql:host=localhost;dbname=corretora', 'root');
            $pdo = new PDO("mysql:dbname="."u830382291_corretor".";host="."br-asc-web1181.main-hosting.eu", "u830382291_corretor", "Ricardosouza1");
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        }
    }

    public function cadastrar($usuario, $senha, $email)
    {
        global $pdo;
        $sql = $pdo->prepare("INSERT INTO cadastro (usuario,senha, email) VALUES (:nome, :senha, :email);");
        $sql->bindValue(":nome", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":email", $email);
        $sql->execute();
        return true;
    }

    public function cadastrarImovel($titulo, $descricao, $total_area, $dormitorios, $banheiros, $tipoImovel, $vagas, $preco, $cidade, $destaque)
    {
        global $pdo;

        do {
            $codigo = rand(1, 10000);
            $sqlVerifica = $pdo->prepare("SELECT COUNT(*) FROM imoveis WHERE codigo = :codigo");
            $sqlVerifica->bindValue(":codigo", $codigo);
            $sqlVerifica->execute();
            $jaExiste = $sqlVerifica->fetchColumn() > 0;
        } while ($jaExiste);


        $sql = $pdo->prepare("INSERT INTO imoveis (codigo,titulo, descricao,total_area,dormitorios,banheiros,tipo_imovel,vagas,preco,cidade,destaque) 
        VALUES (:codigo,:titulo,:descricao,:total_area,:dormitorios,:banheiros,:tipo_imovel,:vagas,:preco,:cidade,:destaque);");
        $sql->bindValue(":codigo", $codigo);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":total_area", $total_area);
        $sql->bindValue(":dormitorios", $dormitorios);
        $sql->bindValue(":banheiros", $banheiros);
        $sql->bindValue(":tipo_imovel", $tipoImovel);
        $sql->bindValue(":vagas", $vagas);
        $sql->bindValue(":preco", $preco);
        $sql->bindValue(":cidade", $cidade);
        $sql->bindValue(":destaque", $destaque);
        $sql->execute();
        return $codigo;
    }

    public function VisualizarImoveis()
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM imoveis where ativo = 1;");
        $sql->execute();
        $lista = $sql->fetchAll();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }
    public function VisualizarImoveisUnico($codigo)
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM imoveis where codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        $lista = $sql->fetch();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }

    public function casaDestaque()
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM imoveis where destaque = 'sim';");
        $sql->execute();
        $lista = $sql->fetchAll();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }

    public function EditarCasa($codigo)
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM imoveis where codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        $lista = $sql->fetchAll();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }

    public function EditarImovel($codigo, $titulo, $descricao, $total_area, $dormitorios, $banheiros, $tipoImovel, $vagas, $preco, $cidade, $destaque)
    {
        global $pdo;

        $sql = $pdo->prepare("UPDATE imoveis SET `titulo` = :titulo, `descricao` = :descricao, `total_area` = :total_area, `dormitorios` = :dormitorios, `banheiros` = :banheiros, `tipo_imovel` = :tipo_imovel, `vagas` = :vagas, `preco` = :preco, `cidade` = :cidade, `destaque` = :destaque   
        WHERE codigo = :codigo;");

        $sql->bindValue(":codigo", $codigo);
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":total_area", $total_area);
        $sql->bindValue(":dormitorios", $dormitorios);
        $sql->bindValue(":banheiros", $banheiros);
        $sql->bindValue(":tipo_imovel", $tipoImovel);
        $sql->bindValue(":vagas", $vagas);
        $sql->bindValue(":preco", $preco);
        $sql->bindValue(":cidade", $cidade);
        $sql->bindValue(":destaque", $destaque);
        $sql->execute();
        return true;
    }

    public function  ExcluiCasa($codigo)
    {
        global $pdo;

        $sql = $pdo->prepare("UPDATE imoveis SET `ativo` = '0' WHERE codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        return true;
    }
    public function  VisualizarCasa($codigo)
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM imoveis WHERE codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        $lista = $sql->fetchAll();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }

    public function updateImagem($codigo, $caminho, $img)
    {
        global $pdo;
        $sql = $pdo->prepare("INSERT INTO regstro_anexos (codigo,caminho,img)
        VALUES (:codigo,:caminho,:img);");
        $sql->bindValue(":codigo", $codigo);
        $sql->bindValue(":caminho", $caminho);
        $sql->bindValue(":img", $img);
        $sql->execute();
        return true;
    }

    public function getImagens($codigo)
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM regstro_anexos WHERE codigo = :codigo;");
        $sql->bindValue(":codigo", $codigo);
        $sql->execute();
        $lista = $sql->fetchAll();
        if ($sql->rowCount() > 0) {
            return $lista;
        } else {
            return false;
        }
    }

    public function deleteImagem($codigo, $img)
    {
        global $pdo;

      

        // Agora, exclua o registro do banco de dados
        $sql = $pdo->prepare("DELETE FROM regstro_anexos WHERE codigo = :codigo AND img = :img;");
        $sql->bindValue(":codigo", $codigo);
        $sql->bindValue(":img", $img);
        $sql->execute();
    }
}
