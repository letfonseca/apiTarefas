const form = document.querySelector('#gestaoTarefas')
const nomeTable = document.querySelector('#nomeTable')
const descricaoTable = document.querySelector('#descricaoTable')
const vencimentoTable = document.querySelector('#vencimentoTable')
const URL = 'http://localhost:8080/tarefas.php'

const tableBody = document.querySelector ('#gestaoTarefas')

function carregarTarefas() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        mode: 'cors'
    })
        .then(response => response.json())
        .then(tarefas => {
            tableBody.innerHTML = ''

            for (let i = 0; i < tarefas.length; i++) {
                const tr = document.createElement('tr')
                const tarefas = tarefas[i]
                tr.innerHTML = `
                    <td>${tarefa.id}</td>
                    <td>${tarefa.nome}</td>
                    <td>${tarefa.descricao}</td>
                    <td>${tarefa.data_de_vencimento}</td>
                    <td>
                    <button data-id="$(tarefa.id)"onclick="atualizarTarefa(${tarefa.id})">Editar</button>
                    <button onclick="excluirTarefa(${tarefa.id})">Excluir</button>
                    </td>
                `
                tableBody.appendChild(tr)
            }

        })
}



//função para criar uma tarefa
function adicionarTarefa(event) {

    event.preventDefault()

    const nome = nomeTable.value
    const descricao = descricaoTable.value
    const data_de_vencimento = data_de_vencimentoTable.value

    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `nome=${encodeURIComponent(nome)}&descricao=${encodeURIComponent(descricao)}&data_de_vencimento=${encodeURIComponent(data_de_vencimento)}`
    })
        .then(response => {
            if (response.ok) {
                carregarTarefas()
                nomeTable.value = ''
                descricaoTable.value = ''
                data_de_vencimentoTable.value = ''
            } else {
                console.error('Erro ao add a tarefa')
                alert('Erro ao add a tarefa')
            }
        })
}


function atualizarTarefa(id){
    const  novoNome = prompt("Digite o novo nome")
    const novoDescricao = prompt("Digite uma nova descrição")
    const novoData = prompt("Digite uma data de vencimento")
    if (novoNome && novoDescricao && novoData){
        fetch(`${URL}?id=${id}`,{
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `nome=${encodeURIComponent(novoNome)}&descricao=${encodeURIComponent(novoDescricao)}&data_de_vencimento=${encodeURIComponent(novoData)}`
        })
            .then(response => {
                if(response.ok){
                    carregarTarefas()
                } else {
                    console.error('Erro ao att tarefa')
                    alert('erro ao att tarefa')
                }
            })
    }
}