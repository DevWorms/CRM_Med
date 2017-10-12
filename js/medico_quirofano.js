$(document).ready(function() {

    $("#searchProd").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                url: APP_URL + 'class/Inventario.php',
                data: {
                    get: "searchProductoToOut",
                    busqueda: $("#searchProd").val()
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data.productos, function(el) {
                        return el.id + " - " + el.nombre + " - " + el.existencia;
                    }));
                },
                error: function(data) {
                    console.log("error" + data);
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 300,
        select: function(event, ui) {
            //var terms = split(this.value) ;
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            var valores = ui.item.value.split(" - ");
            if (!isDuplicatedProduct(valores[0])) {
                addToPre(valores[0], valores[1], valores[2]);
            } else {
                $.notify("Ya tienes agregado el producto", "warning");
            }
            $("#searchProd").val("");
            return false;
        }
    });

    $("#searchPac").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                post: 'autoSearch',
                url: APP_URL + 'class/Paciente.php',
                data: {
                    post: 'allSearch',
                    param: $("#searchPac").val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function(el) {
                        if (el.is_paciente == "1")
                            return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 300,
        select: function(event, ui) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            var paciente_id = ui.item.value.split(" - ")[0];
            $("#paciente").val(paciente_id);
              $.ajax({
			        type: 'POST',
			        url: APP_URL + 'class/Medico.php',
			        data: {
			            get: 'getExpediente1',
			            id: paciente_id
			        },
			        beforeSend: function () {
			            $("#wait").show();
			        },
			        success: function (response) {
			            response = JSON.parse(response);
			            if (response.estado == 1) {
			                var paciente = response.paciente;

			                //Nombre
			                var nombre = paciente.nombre;
			                if (paciente.apPaterno) {
			                    nombre = nombre + " " + paciente.apPaterno;
			                }

			                if (paciente.apMaterno) {
			                    nombre = nombre + " " + paciente.apMaterno;
			                }
			                nombre = nombre + " - " + paciente.id

			                $("#header").html('<h2 style="display:inline; color:#337ab7;">' + nombre + '</h2>');

			                // Informacion del paciente
			                var domicilio = "", ocupacion = "", fecha_nacimiento = "", edad = "", created_at = "";
			                if (paciente.domicilio) {
			                    domicilio = paciente.domicilio;
			                }

			                if (paciente.ocupacion) {
			                    ocupacion = paciente.ocupacion;
			                }

			                if (paciente.fecha_nacimiento) {
			                    fecha_nacimiento = paciente.fecha_nacimiento;
			                }

			                if (paciente.edad) {
			                    edad = paciente.edad;
			                }

			                if (paciente.created_at) {
			                    created_at = paciente.created_at;
			                }

			                $("#info").html("<strong>Dirección</strong>: " + domicilio + "<br><strong>Ocupación</strong>: " + ocupacion +
			                    "<br><strong>Fecha de Nacimiento</strong>: " + fecha_nacimiento + "<br><strong>Edad</strong>: " + edad +
			                    "<br><br>Agregado</strong>: " + created_at);

			                // Contacto
			                var telefono = "", telefono2 = "", email = "", nombreFamiliar = "", telefonoFamiliar = "";
			                if (paciente.telefono) {
			                    telefono = paciente.telefono;
			                }

			                if (paciente.telefono2) {
			                    telefono2 = paciente.telefono2;
			                }

			                if (paciente.email) {
			                    email = paciente.email;
			                }

			                if (paciente.nombreFamiliar) {
			                    nombreFamiliar = paciente.nombreFamiliar;
			                }

			                if (paciente.telefonoFamiliar) {
			                    telefonoFamiliar = paciente.telefonoFamiliar;
			                }

			                $("#contacto").html("<strong>Teléfono</strong>: " + telefono + "<br><strong>Teléfono 2</strong>: " + telefono2 + "<br><strong>Email</strong>: " + email +
			                    "<br><strong>Nombre de Familiar</strong>: " + nombreFamiliar + "<br><strong>Teléfono de Familiar</strong>: " + telefonoFamiliar);

			                var table = document.getElementById("historial");
			                for (var i = table.rows.length - 1; i > 0; i--) {
			                    table.deleteRow(i);
			                }

			               
			                response.historial.forEach(function (presupuesto) {
			                    var sesiones = "", last_date = "", porcentaje_operacion = "";
			                    if (presupuesto.numero_sesiones) {
			                        sesiones = presupuesto.numero_sesiones;
			                    }

			                    if (presupuesto.last_date) {
			                        last_date = presupuesto.last_date;
			                    }

			                    if (presupuesto.porcentaje_operacion) {
			                        porcentaje_operacion = presupuesto.porcentaje_operacion;
			                    }

			                    $('#historial tr:last').after('<tr>' +
			                        '<td>' + presupuesto.nombre + '</td>' +
			                        '<td>' + sesiones + '</td>' +
			                        '<td>' + last_date + '</td>' +
			                        '<td>' + presupuesto.porcentajePagado + '%</td>' +
			                        '</tr>');

			 
			                });

			                // antecedentes
			                if (response.antecedentes.length > 0) {
			                    var a = response.antecedentes[0];
			                    $("#quirurgicos_div").append(a.quirurgicos);
			                    $("#alergicos_div").append(a.alergicos);
			                    $("#anestesia_div").append(a.anestecia);
			                    $("#padecimientos_div").append(a.padecimientos);
			                    $("#medicamentos_div").append(a.medicamentos);
			                    $("#tabaquismo_div").append(a.tabaquismo);
			                    $("#otros_div").append(a.otro);

			                    $("#quirurgicos_txt").val(a.quirurgicos);
			                    $("#alergicos_txt").val(a.alergicos);
			                    $("#anestesia_txt").val(a.anestecia);
			                    $("#padeceimientos_txt").val(a.padecimientos);
			                    $("#medicamentos_txt").val(a.medicamentos);
			                    $("#tabaquismo_txt").val(a.tabaquismo);
			                    $("#otros_txt").val(a.otro);
			                }
			            } else {
			                $("#error").fadeIn(1000, function () {
			                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
			                });
			            }
			        },
			        error: function (response) {
			            $("#error").fadeIn(1000, function () {
			                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
			            });
			        },
			        complete: function () {
			            $("#wait").hide();
			        }
			    });
            return false;
        }
    });

    $("#searchMed").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                post: 'autoSearch',
                url: APP_URL + 'class/Usuarios.php',
                data: {
                    get: 'getMedicosSearch',
                    param: $("#searchMed").val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    response($.map(data.medicos, function(el) {
                        return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 300,
        select: function(event, ui) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            var medico = ui.item.value.split(" - ")[0];
            $("#medico").val(medico);
            return false;
        }
    });
    $("#searchMedCirugia").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                post: 'autoSearch',
                url: APP_URL + 'class/Usuarios.php',
                data: {
                    get: 'getMedicosSearch',
                    param: $("#searchMedCirugia").val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    response($.map(data.medicos, function(el) {
                        return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 300,
        select: function(event, ui) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            var medico = ui.item.value.split(" - ")[0];
            $("#medicoCirugia").val(medico);
            return false;
        }
    });
});

