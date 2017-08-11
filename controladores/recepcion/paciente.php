    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
        include dirname(__FILE__) . '/../utilidades/funciones/func_option_select.php'; 
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
                        <div id="error"></div>
                        <h2 style="display:inline; color:#337ab7;">Recepción - Paciente</h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Muestra la información del paciente"></span>
                        <hr>
                        <div id="error"></div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div id="header">
                                        <H4>  </H4>
                                    </div>
                                    <div id="folio">
                                        Folio N°
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h5>Próxima cita</h5>
                                    <div id="proximaCita">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h5>Otras citas</h5>
                                    <div id="otrasCitas">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    <H4><b> Información del Paciente </b></H4>
                                    <div id="info">
                                        Dirección:
                                        <br>
                                        Ocupación:
                                        <br>
                                        Fecha de Nacimiento:
                                        <br>
                                        Edad:
                                        <br><br>
                                        Agregado:
                                    </div>
                                </div>


                                <div class="col-md-5">
                                    <H4><b> Medios de Contacto </b></H4>
                                    <div id="contacto">
                                        Teléfono:
                                        <br>
                                        Email:
                                        <br><br>
                                        Nombre de Familiar:
                                        <br>
                                        Teléfono de Familiar:
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <hr class="gradient">
                                    <H3 align="center"> Historial de Pagos </H3>
                                    <br>
                                    Sesiones programadas:
                                    <br>
                                    Sesiones pagadas:
                                    <br>
                                    Sesiones faltantes:
                                    <br><br>

                                    <table class="table table-hover" id="table_pagos">
                                        <thead>
                                            <tr>
                                                <th>Monto</th>
                                                <th>Concepto</th>
                                                <th>Nombre de presupuesto</th>
                                                <th>Precio de presupuesto</th>
                                                <th>Número de Recibo</th>
                                                <th>Restante</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                    </div> 
                </div>          
            </div>
        </div>
    </div>
            <script src="<?php echo app_url(); ?>js/paciente.js" type="text/javascript"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
            <div id="modalsCitas"></div>
            <script type="text/template" id="modal_cita_paciente">
                <!-- Modal -->
                <div id="cita_${id}" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center">Información de cita</h4>
                            </div>
                            <div class="modal-body">

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div id="header">
                                            <H4> Procedimiento: </H4>
                                        </div>
                                        <div id="procedimiento">
                                            ${nombre}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="header">
                                            <H4> Observaciones: </H4>
                                        </div>
                                        <div id="procedimiento_observaciones">
                                            ${comentario}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr class="dotted">
                                    <h3 align="center">Editar Cita</h3>
                                </div>

                                <div class="form-group row space" align="center">
                                    <div class="col-md-4">
                                        <fieldset class="form-inline">
                                            <label for="">Fechas Disponibles</label>
                                            <fieldset class="form-inline">
                                                <div class="input-group">
                                                    <input type="text" class="search-query form-control" id="fecha_${id}" name="fecha_${id}" placeholder="aaaa / mm / dd" value="${fecha}" required/>
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </button>
                                                </span>
                                                </div>
                                            </fieldset>
                                            <br><br>
                                            <table class="table table-striped" id="citas_by_date_${id}">
                                                <thead>
                                                <tr>
                                                    <th style="text-align:center">Hora</th>
                                                    <th style="text-align:center">Tipo de Cita</th>
                                                </tr>
                                                </thead>
                                                <tbody style="text-align:center;">
                                                </tbody>
                                            </table>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-4">
                                        <fieldset class="form-inline">
                                            <div align="center">
                                                <label for="hora_${id}">Seleccionar Hora</label>
                                                <input type="text" id="hora_${id}" placeholder="hh:mm am" value="${hora_ini}" />
                                            </div>
                                        </fieldset>

                                        <br>
                                        <fieldset class="form-inline">
                                            <div align="center">
                                                <label for="tipo_cita_${id}">Tipo de Cita</label>
                                                <select class="form-control" id="tipo_cita_${id}">
                                                </select>
                                            </div>
                                        </fieldset>

                                        <br>
                                        <fieldset class="form-inline">
                                            <div align="center">
                                                <label for="tratamientos_${id}">Tratamiento</label>
                                                <select class="form-control" id="tratamientos_${id}">
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-4">
                                        <fieldset class="form-inline">
                                            <div align="center">
                                                <label for="comentario_cita_${id}">Añadir Comentario (Opcional)</label>
                                                <textarea id="comentario_cita_${id}" name="comentario_cita_${id}" class="form-control" rows="3">${comentario}</textarea>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="form-group row space" align="center">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"><button onclick="event.preventDefault(); cancelarCita(${id});" class="btn btn-danger">Cancelar cita</button></div>
                                    <div class="col-md-4"><button onclick="event.preventDefault(); actualizarCita(${id}, ${pacientes_id});" class="btn btn-primary">Actualizar cita</button></div>
                            </div>
                        </div>

                    </div>
                </div>
                <script>
                    $(function() {
                        var nowDate = new Date();
                        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

                        $('#fecha_' + ${id}).pikaday({
                            format: 'YYYY-MM-DD',
                            disableDayFn: function (date) {
                                var today = moment().add(1, 'd').format('YYYY-MM-DD');
                                //var today = moment().format('YYYY-MM-DD');
                                var ban = moment(date).format('YYYY-MM-DD');

                                return moment(ban).isBefore(today);
                                // return true;
                            }
                        });

                        $('#fecha_' + ${id}).change(function() {
                            console.log("test");
                            var date = Date.parse($('#fecha_' + ${id}).val());
                            if(!isNaN(date)) {
                                getCitas(${id});
                            }
                        });

                        $("#hora_" + ${id}).timepicker(
                            $.timepicker.regional['es']
                        );

                        getTratamientos(${pacientes_id}, ${id});
                        getTipoDeCitas(${id});
                    });
                </script>
            </script>
