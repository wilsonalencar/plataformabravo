var id = $("#id").val();
if (id > 0) {
   getDataUsuario(id);
}

function getDataUsuario(id)
{
   $.ajax({
        url : 'usuarios.php',
        type: 'post',
        dataType: 'JSON',
        data:
        {
            'action':2,
            'id':id
        },
        success: function(d)
        {
            if (!d.success) {
               alert(d.msg);
               return false;
            }
            $("#divResetSenha").show();
            $("#id").val(d.data.id);
            $("#nome").val(d.data.nome);
            $("#email").val(d.data.email);
            $("#id_plataforma").val(d.data.id_perfilusuario);
            
            if (d.data.id_perfilusuario == 0) {
              $('.apontamento').css('display', 'none');
              $('.agenda').css('display', 'none');
              $('.portal').css('display', 'none');
            }

            if (d.data.id_perfilusuario == 1) {
              $('.apontamento').css('display', 'block');
              $('.agenda').css('display', 'block');
              $('.portal').css('display', 'block');
            }

            if (d.data.id_perfilusuario == 2) {
              $('.apontamento').css('display', 'none');
              $('.agenda').css('display', 'block');
              $('.portal').css('display', 'none');
            }

            if (d.data.id_perfilusuario == 3) {
              $('.agenda').css('display', 'none');
              $('.apontamento').css('display', 'block');
              $('.portal').css('display', 'none');
            }

            if (d.data.id_perfilusuario == 4) {
              $('.apontamento').css('display', 'block');
              $('.agenda').css('display', 'block');
              $('.portal').css('display', 'none');
            }

            //BPO e Fornecedor
            if (d.data.id_perfilusuario == 5) {
              $('.apontamento').css('display', 'none');
              $('.agenda').css('display', 'block');
              $('.portal').css('display', 'block');
            }

            //BPO, Fornecedor e Projeto
            if (d.data.id_perfilusuario == 6) {
              $('.apontamento').css('display', 'block');
              $('.agenda').css('display', 'block');
              $('.portal').css('display', 'block');
            }

            //Fornecedor
            if (d.data.id_perfilusuario == 7) {
              $('.apontamento').css('display', 'none');
              $('.agenda').css('display', 'none');
              $('.portal').css('display', 'block');
            }

            //Projeto e Fornecedor
            if (d.data.id_perfilusuario == 8) {
              $('.apontamento').css('display', 'block');
              $('.agenda').css('display', 'none');
              $('.portal').css('display', 'block');
            }


            if (d.data.id_responsabilidade != '') {
                $("#id_responsabilidade").val(d.data.id_responsabilidade);
            } else {
                $("#id_responsabilidade").val(0);
            }
                        
            $("#status").val(d.data.status);
            $("#senha").val(d.data.senha);
        }
    });
}

$( document ).ready(function() {
  $( "#submit" ).click(function() {
    if ($("#nome").val() == '') {
        alert('Informar o nome do Usuario');
        $("#nome").focus();
        return false;
    }

    if ($("#email").val() == '') {
        alert('Informar o email do usuário');
        $("#email").focus();
        return false;
    }

    if ($("#id_plataforma").val() == '') {
        alert('Informar o perfil do Usuario para a plataforma Bravo');
        $("#id_plataforma").focus();
        return false;
    }

    return true;
  });

});
