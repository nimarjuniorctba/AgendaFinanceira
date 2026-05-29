$('#formLancamento').submit(function(e){
    e.preventDefault();

    $.post('financeiro_salvar.php', $(this).serialize(), function(){
        location.reload();
    });
});
