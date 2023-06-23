const form = document.querySelector('#livroform')
const tituloInput = document.querySelector('#tituloInput')
const autorInput = document.querySelector('#autorInput')
const ano_publicacaoInput = document.querySelector('#ano_publicacaoInput')
const URL = 'http://localhost:8080/livros.php'

const tableBody = document.querySelector('#livrosTable')

function carregarLivros() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        mode: 'cors'
    })
        .then(response => response.json())
        .then(livros => {
            tableBody.innerHTML = ''

            for (let i = 0; i < livros.length; i++) {
                const tr = document.createElement('tr')
                const livro = livros[i]
                tr.innerHTML = `
                    <td>${livro.id}</td>
                    <td>${livro.titulo}</td>
                    <td>${livro.autor}</td>
                    <td>${livro.ano_publicacao}</td>
                    <td>
                    <button data-id="$(livro.id)"onclick="atualizarLivro(${livro.id})">Editar</button>
                    <button onclick="excluirLivro(${livro.id})">Excluir</button>
                    </td>
                `
                tableBody.appendChild(tr)
            }

        })
}

//função para criar um livro
function adicionarLivro(event) {

    event.preventDefault()

    const titulo = tituloInput.value
    const autor = autorInput.value
    const ano_publicacao = ano_publicacaoInput.value

    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `titulo=${encodeURIComponent(titulo)}&autor=${encodeURIComponent(autor)}&ano_publicacao=${encodeURIComponent(ano_publicacao)}`
    })
        .then(response => {
            if (response.ok) {
                carregarLivros()
                tituloInput.value = ''
                autorInput.value = ''
                ano_publicacaoInput.value = ''
            } else {
                console.error('Erro ao add livro')
                alert('Erro ao add Livro')
            }
        })
}

function atualizarLivro(id){
    const novoTitulo = prompt("Digite o novo titulo")
    const novoAutor = prompt("Digite o novo Autor")
    const novoAno = prompt("Digite o novo ano")
    if (novoTitulo && novoAno && novoAutor){
        fetch(`${URL}?id=${id}`,{
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `titulo=${encodeURIComponent(novoTitulo)}&autor=${encodeURIComponent(novoAutor)}&ano_publicacao=${encodeURIComponent(novoAno)}`
        })
            .then(response => {
                if(response.ok){
                    carregarLivros()
                } else {
                    console.error('Erro ao att livro')
                    alert('erro ao att livro')
                }
            })
    }
}

function excluirLivro(id){
    if(confirm('Deseja excluir esse livro?')){
        fetch(`${URL}?id=${id}`,{
            method:'DELETE'
        })
        .then(response => {
            if(response.ok){
                carregarLivros()
            }else{
                console.error('Erro ao excluir o livro')
                alert('Erro ao excluir Livro')
            }
        })
    }
}


form.addEventListener('submit', adicionarLivro)

carregarLivros()

    
