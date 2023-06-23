// let pessoa = ['Leticia', 17, '01/11/2005']

// let pessoa2 = {
//     nome: 'Leticia',
//     idade: 17,
//     dataNascimento: '01/11/2005'
// }

// document.write(pessoa2.nome)


// const cachorro = {
//     raca: 'Doberman',
//     cor: 'Preto',
//     idade: 5,
//     uivar: function(){
//         document.write('Auuuuuuuuuuuuu!')
//     },
//     rosanar: function(){
//         document.write('grrrrrrrrrrrrr!')
//     }
// }
// document.write(cachorro.raca, '<br>')

// cachorro.uivar()

// class Cachorro {
//     constructor(raca, cor, idade){
//         this.raca = raca
//         this.cor = cor
//         this.idade = idade
//     }
//     latir(){
//         document.write('au au au')

//     }
// }

// let cofap = new Cachorro('Copaf', 'Preto', 2)
// let pitBull = new Cachorro('PitBull', 'Preto', 3)
// document.write(cofap.raca)
// document.write('<br>',cofap.cor)
// document.write('<br>',cofap.idade)

// pitBull.latir()

// const corDog = document.querySelector('#cor')
// const botao = document.querySelector('#botao')

// class Cachorro {
//     constructor(raca, cor){
//         this.raca = raca
//         this.cor = cor
//     }
//     latir(){
//         document.write('au au')
//     }
//     get getCor(){
//         return this.cor
//     }
//     set setCor(cor){
//         this.cor = cor

//     }
// }

// let pastor = new Cachorro('Pastor Alemão', 'Sem Cor')


// botao.addEventListener('click', function(){
//     pastor.setCor = corDog.value
//     document.write(pastor.cor)
//  })



//Criar uma classe de um carro que contenha
//Modelo, Cor, Marca, Estado
//o carro deve ter um metodo de estado/
//esse estado define se o carro esta em movimento ou parado

class Carro{
        constructor(modelo, cor, marca, estado){
            this.modelo = modelo
            this.cor = cor
            this.marca = marca
            this.estado = estado
        }
         getEstado(){
            return this.estado
        }
         setEstado(estado){
            this.estado = estado
    }
}
let corolla = new Carro('Corolla', 'Preto', 'Toyota', 'Parado')

corolla.setEstado('Andando')

document.write(corolla.estado)