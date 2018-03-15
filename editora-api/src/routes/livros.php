<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Carrega todos os livros
$app->get('/api/livros', function(Request $request, Response $response){
    $sql = "SELECT * FROM livros";
    try{
        // Cria objeto para conexão ao BD
        $bd = new bd();
        // Cria Conexão com o BD
        $bd = $bd->connect();
        $stmt = $bd->query($sql);
        //retorna as linhas da tabela de acordo com o comando sql
        $listaLivros = $stmt->fetchAll(PDO::FETCH_OBJ);
        $bd = null;
        $response->withJson($listaLivros);
    } catch(PDOException $e){
        echo '{"Erro": '.$e->getMessage().'}';
    }
});

// Busca um livro pelo título
$app->get('/api/livro/{titulo}', function(Request $request, Response $response){
    $titulo = $request->getAttribute('titulo');
    $sql = "SELECT * FROM livros WHERE UPPER(titulo) LIKE '%$titulo%'";
    try{
        $bd = new bd();
        $bd = $bd->connect();
        $stmt = $bd->query($sql);
        $livro = $stmt->fetchAll(PDO::FETCH_OBJ);
        $bd = null;
        $response->withJson($livro);
    } catch(PDOException $e){
        echo '{"Erro":'.$e->getMessage().'}';
    }
});

//Adiciona um novo livro
$app->post('/api/livro/adicionar', function(Request $request, Response $response){
    $titulo = $request->getParam('titulo');
    $autor = $request->getParam('autor');
    $editora = $request->getParam('editora');
    $preco = $request->getParam('preco');
    $paginas = $request->getParam('paginas');
    $sql = "INSERT INTO livros (titulo, autor, editora, preco, paginas) VALUES
                                  (:titulo, :autor, :editora, :preco, :paginas)";
    try{
        $bd = new bd();
        $bd = $bd->connect();
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor',  $autor);
        $stmt->bindParam(':editora', $editora);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':paginas', $paginas);
        $stmt->execute();
        echo 'Adicionado';
    } catch(PDOException $e){
        echo '{"Erro":'.$e->getMessage().'}';
    }
});

