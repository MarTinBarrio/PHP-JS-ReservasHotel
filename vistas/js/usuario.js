/**
 * Limpiar formularios
 */



$('.modal.formulario').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('input[name="registroNombre"]').val('');
    $('input[name="registroEmail"]').val('');
    $('input[name="registroPassword"]').val('');
    $('input[name="ingresoEmail"]').val('');
    $('input[name="ingresoPassword"]').val('');
})

$("input[name='registroEmail']").change(function() {
    $(".alert").remove();
})

/**
 * validar email repetido en forma on line
 */
$('input[name="registroEmail"]').change(function() {

    let email = $(this).val();
    //console.log("email: ", email);

    let datos = new FormData();
    datos.append("validarEmail", email);

    /**ejecuto ajax */
    $.ajax({
        url: urlPrincipal + "ajax/usuario.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log("respuesta: ", respuesta);
            if (respuesta) {

                let modo = respuesta["modo"];
                if (modo == "directo") {
                    modo = "esta página";
                }

                $("input[name='registroEmail']").val("");
                $("input[name='registroEmail']").after(`
                    <div class="alert alert-warning">
                        <strong>ERROR:</strong>
                        El correo ya existe en la base de datos, fue registrado a traves de ` + modo + `, por favor ingrese otro correo diferente.
                    </div>
                `);
                return;

            }
        }
    });
})

/**
 * Boton facebook
 */
$(".facebook").click(function() {
    FB.login(function(response) {
        //console.log("response", response);
        validarUsuario();
    }, { scope: 'public_profile, email' })
})

/**validar el ingreso */
function validarUsuario() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    })
}

/**validar el cambio de estado en facebook */
function statusChangeCallback(response) {
    if (response.status === 'connected') {
        testApi();
    } else {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Ocurrió un error en el ingreso con FaceBook, por favor, vuelve a intentarlo!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        }).then(function(result) {
            if (result.value) {
                //history.back();
            }
        });
        return;
    }
}

/**Ingreso a la api de facebook */
function testApi() {
    FB.api('/me?fields=id,name,email,picture', function(response) {
        if (response.email == null) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Para poder ingresar al sistema debe proporcionar la información del correo electrónico!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {
                if (result.value) {
                    //history.back();
                }
            });
            return;
        } else { // response.email trae información...

            let email = response.email;
            let nombre = response.name;
            let foto = "http://graph.facebook.com/" + response.id + "/pincture?type=large";
            /* 

                        console.log("email: ", email);
                        console.log("nombre: ", nombre);
                        console.log("foto: ", foto);
             */

            let datos = new FormData();
            datos.append("email", email);
            datos.append("nombre", nombre);
            datos.append("foto", foto);

            /**ejecuto ajax */
            $.ajax({
                url: urlPrincipal + "ajax/usuario.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta) {

                    //console.log("respuesta:", respuesta);

                    if (respuesta == "ok") {
                        //console.log("entró, redirigue a:", urlPrincipal + "perfil");
                        setTimeout(() => {
                            window.location = urlPrincipal + "perfil";
                        }, 500);

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "El correo electrónico " + email + " ya está registrado con un método diferente a Facebook!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result) {
                            if (result.value) {

                                //borro las cookies del loego de Facebook!
                                FB.getLoginStatus(function(response) {
                                        if (response.status === 'connected') {
                                            FB.logout(function(response) {
                                                //deleteCookie("fblo_IDdeAPPdeFB")
                                                deleteCookie("fblo_1474179063051347");
                                                setTimeout(() => {
                                                    window.location = urlPrincipal + "salir";
                                                }, 500);
                                            });

                                            function deleteCookie(name) {
                                                document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                                            }
                                        }
                                    })
                                    /************************************ */
                            }
                        });

                    }

                }
            })
        }
    })
}

/***Salir de facebook */
$(".salir").click(function(e) {
    e.preventDefault();

    //borro las cookies del loego de Facebook!
    FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.logout(function(response) {
                    //deleteCookie("fblo_IDdeAPPdeFB")
                    deleteCookie("fblo_1474179063051347");

                    setTimeout(() => {
                        window.location = urlPrincipal + "salir";
                    }, 500);
                });

                function deleteCookie(name) {
                    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                }
            }
        })
        /************************************ */

})