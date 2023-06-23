$(document).ready(function () {
    $('.confirma-delete').click(function (e) {
        e.preventDefault();

        var id = $(this).val();
        // alert(id)


        swal({
            title: "Deseja continuar?",
            text: "Uma vez excluído, você não poderá recuperar este usuário!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "/usuario_excluir?id="+id;
                } 
                // else {
                //     swal("Your imaginary file is safe!");
                // }
            });
    });
});

$(document).ready(function () {
    $('.confirma-delete-categoria').click(function (e) {
        e.preventDefault();

        var id = $(this).val();
        // alert(id)


        swal({
            title: "Deseja continuar?",
            text: "Uma vez excluído, você não poderá recuperar esta categoria!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "/categoria_excluir?id="+id;
                } 
                // else {
                //     swal("Your imaginary file is safe!");
                // }
            });
    });
});


