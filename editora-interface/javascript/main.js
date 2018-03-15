
$(function(){
    var $livros = $('#resultado-busca');
    var $titulo = $('#titulo');
    var $tituloNovo = $('#titulo-novo');
    var $autor = $('#autor');
    var $editora = $('#editora');
    var $preco = $('#preco');
    var $paginas = $('#paginas');
    var $mensagemAdicionar = $('#mensagem-adicionar');

    $('#pesquisar-livro').on('click', function(){
        $($livros).empty();
        if($titulo.val() !== ''){
        $.ajax({
            type: 'GET',
            url: 'http://localhost/editora-api/public/index.php/api/livro/' + $titulo.val(),
            dataType: "json",
            success: function(livro){
                if(livro == ""){
                    $livros.append('Sua busca não retornou nenhum resultado');
                }else{

                    $livros.append('<tr><th>Titulo</th><th>Autor</th><th>Editora</th><th>Preço</th><th>Páginas</th></tr>');
                    $.each(livro, function(i, item){


                    $livros.append('<tr><td>' + item.titulo +
                                    '</td><td>' + item.autor + 
                                    ' </td><td>' + item.editora + 
                                    ' </td><td>' + item.preco + 
                                    ' </td><td>' + item.paginas + ' </td></tr>');
                                
            });}
        },
        error: function(){
            alert('Erro ao carregar dados');
        }
        });
    }
    });

    $('#adicionar-livro').on('click', function(){
        $($mensagemAdicionar).empty();
        if($tituloNovo.val() !== '' && $autor.val() !== '' && $editora.val() !== '' && 
        $preco.val() !== '' && $paginas.val() !== ''){
        var novoLivro = {
            titulo: $tituloNovo.val(),
            autor: $autor.val(),
            editora: $editora.val(),
            preco: $preco.val(),
            paginas: $paginas.val(),
        };
        
        $.ajax({
            type: 'POST',
            url: 'http://localhost/editora-api/public/index.php/api/livro/adicionar',
            data: novoLivro,
            success: function(novoLivro){
                $mensagemAdicionar.append('Livro Adicionado!');
                $tituloNovo.val('');
                $autor.val('');
                $editora.val('');
                $preco.val('');
                $paginas.val('');
            },
        error: function(){
            $mensagemAdicionar.append('Erro ao adicionar livro');
        }
        });
    } else{
        $mensagemAdicionar.append('Preencha todos os campos corretamente!');
    }
    });
});