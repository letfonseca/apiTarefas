<?php

namespace App\controllers;

use Core\model\Container;
use Core\controller\Action;
use App\controllers\AuthController;
use App\Models\CategoriaModel;

class ArquivoController extends Action
{
    public function index()
    {
        AuthController::validaAutenticacao();

        $arquivo = Container::getModel("Arquivo");
        $arquivos = $arquivo->getArquivos();
        $this->view->dados = $arquivos;
        $this->view->title = "Admin - Arquivos";

        $this->render("index", "template_admin");
    }

    public function arquivo_show()
    {
        AuthController::validaAutenticacao();

        $idArquivo = $_GET['id'];

        $this->view->title = "Admin - Arquivos";

        $arquivo = Container::getModel("Arquivo");
        $arquivos = $arquivo->getArquivoPorId($idArquivo);
        $this->view->dados = $arquivos;       

        $imagem = Container::getModel("Imagem");
        $imagens = $imagem->getImagens($arquivos["id"]);
        $this->view->imagens = $imagens; 

        $this->render("show", "template_admin");
    }

    

    public function cadastrar()
    {
        AuthController::validaAutenticacao();

        $this->view->title = "Admin - Arquivos";

        $categoria = Container::getModel("categoria");

        $categorias = $categoria->getCategorias();

        $this->view->dados = $categorias;

        $this->render("cadastrar", "template_admin");
    }

    public function salvar_arquivo()
    {
        AuthController::validaAutenticacao();
        $arquivo = Container::getModel('Arquivo');

        //seta os dados do form nos atributos da classe 
        $arquivo->__set('id_usuario', isset($_SESSION['id']) ? $_SESSION['id'] : "");
        $arquivo->__set('id_categoria', isset($_POST['categoria']) ? $_POST['categoria'] : "");
        $arquivo->__set('titulo', isset($_POST['titulo']) ? $_POST['titulo'] : "");
        $arquivo->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : "");

        $arquivo->__set('visualizacoes', 0);
        $arquivo->__set('ativo', 1);
        $arquivo->__set('deleted_at', null);
        $arquivo->__set('updated_at', null);

        if ($arquivo->validarCadastro()) {
            //SUCCESS ao validar cadastro

            
            if (count($arquivo->getArquivoPorNome()) == 0) {
                // $imagem = formataArrayFile($_FILES['imagem']);

                if (isset($_FILES['arquivo']) && $_FILES['arquivo']['size'] > 0) {

                    
;
                    $arquivo->__set('arquivo', upload($_FILES['arquivo'], "arquivos"));
                    $arquivo->__set('extensao', pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
                    $arquivo->__set('tamanho', $_FILES['arquivo']['size']);

                    $arquivo->salvar();

                    

                    if (isset($_FILES['imagem']) && $_FILES['imagem']['size'][0] > 0) {
                        $imagemFile = formataArrayFile($_FILES['imagem']);
                        

                        $qtdeImagem = $imagemFile[0]['name'] === '' ? 0 : count(array_filter($imagemFile));

                        if ($qtdeImagem > 0) {
                            $imagem = Container::getModel('Imagem');

                            for ($i = 0; $i < $qtdeImagem; $i++) {

                                // dd(uploadWithResize($imagemFile[$i], "teste", 500, 500));

                                $imagem->__set('nome', removerEspacosTexto(upload($imagemFile[$i], "imagens")));
                                $imagem->__set('id_arquivo', $arquivo->__get('id'));

                                $imagem->salvar();
                            }
                        }
                    } else {
                        removerArquivoServidor("arquivos", $arquivo->__get('arquivo'));
                        $arquivo->rowbackArquivo($arquivo->__get('id'));
                        $this->errorConfigMsg("Erro ao cadastrar arquivo: ao menos uma imagem deve ser selecionada");
                    }

                    $this->view->status = array(
                        "status" => "SUCCESS",
                        "msg"    => "Cadastro realizado com sucesso"
                    );

                    $this->view->title = "Admin - arquivos";

                    $categoria = Container::getModel("categoria");

                    $categorias = $categoria->getCategorias();

                    $this->view->dados = $categorias;

                    $this->render("cadastrar", "template_admin");
                } else {
                    $this->errorConfigMsg("Erro ao cadastrar arquivo: o arquivo deve ser selecionado");
                }
            } else {
                $this->errorConfigMsg("Erro ao cadastrar arquivo: o nome já existe no banco de dados");
            }
        } else {
            $this->errorConfigMsg("Erro ao cadastrar arquivo: verifique os campos digitados e tente novamente");
        }
    }

    public function errorConfigMsg(string $msg)
    {
        //caso retornar 1 linha na query - indica que ja esta cadastrado no banco de dados
        $this->view->status = array(
            "status" => "ERROR",
            "msg"    => $msg
        );

        $this->view->tempArquivo = array(
            "titulo"      => isset($_POST['titulo']) ? $_POST['titulo'] : "",
            "categoria"      => isset($_POST['categoria']) ? $_POST['categoria'] : "",
            "descricao"      => isset($_POST['descricao']) ? $_POST['descricao'] : "",
        );

        $this->view->title = "Admin - arquivos";

        $categoria = Container::getModel("categoria");

        $categorias = $categoria->getCategorias();

        $this->view->dados = $categorias;

        $this->render("cadastrar", "template_admin");
    }

    public function atualizar()
    {
        AuthController::validaAutenticacao();

        //faz a instancia de produto com a conexão com banco de dados
        $categoria = Container::getModel('Categoria');

        //seta os dados do form nos atributos da classe Usuário
        $categoria->__set('id', isset($_POST['id']) ? $_POST['id'] : "");
        $categoria->__set('nome', isset($_POST['nome']) ? $_POST['nome'] : "");

        if ($categoria->validarCadastro()) {
            //SUCCESS ao validar cadastro

            if (count($categoria->getCategoriaPorNome()) == 0 || $_POST['nome'] === $_POST['nome_atual']) {

                $categoria->atualizar();

                //podemos criar um atributo generico no objeto pois estamos herdando de action o view
                $this->view->status = array(
                    "status" => "SUCCESS",
                    "msg"    => "Categoria atulizada com sucesso"
                );

                $categorias = $categoria->getCategoriaPorId();
                $this->view->dados = $categorias;

                $this->render("editar", "template_admin");
            } else {
                //caso retornar 1 linha na query - indica que ja esta cadastrado no banco de dados
                $this->view->status = array(
                    "status" => "ERROR",
                    "msg"    => "Erro ao editar categoria, nome já existe no banco de dados"
                );

                $this->view->tempArquivo = array(
                    "nome"      => isset($_POST['nome']) ? $_POST['nome'] : "",
                );

                $this->view->title = "Admin - Categorias";

                $this->render("editar", "template_admin");
            }
        } else {
            //erro na digitação < que 3 caracteres
            //armazena os dados para recarregar o form

            $this->view->tempArquivo = array(
                "nome" => isset($_POST['nome']) ? $_POST['nome'] : "",
            );

            // dd($this->view->tempArquivo);

            $this->view->status = array(
                "status" => "ERROR",
                "msg"    => "Erro ao editar categoria, verifique os campos digitados e tente novamente"
            );

            $this->view->title = "Admin - Categorias";
            $this->render("editar", "template_admin");
        }
    }

    public function editar()
    {
        AuthController::validaAutenticacao();

        $categoria = Container::getModel('Categoria');

        //seta o id no atributos id da classe Usuário
        $categoria->__set('id', isset($_GET['id']) ? $_GET['id'] : "");

        $categorias = $categoria->getCategoriaPorId();
        $this->view->dados = $categorias;

        $this->view->title = "Admin - Categorias";

        $this->render("editar", "template_admin");
    }

    public function excluir()
    {
        AuthController::validaAutenticacao();

        $id_categoria = isset($_GET['id']) ? $_GET['id'] : '';

        $categoria = Container::getModel('Categoria');
        $categoria->deletarCategoria($id_categoria);

        // $this->index();
        header("Location: /categoria");
    }
}



// IndexController
