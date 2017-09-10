    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">

                        <h2 style="display:inline; color:#337ab7;">Recepción - Calendario </h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Revisa la agenda diaria."></span>
                        <button class="btn btn-default" id="print">Imprimir</button>
                        <div id="error"></div>


                        <hr>
                        <div id='calendar'></div>
                    </div>      
                </div>          
            </div>
            <div id="modalsEventos"></div>
            <script type="text/template" id="modal_detalle_evento">
                <div id="DetalleEvento-${cita_id}" class="modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" style="text-align:center;">${tipo_cita} - ${apPaterno} ${apMaterno} ${nombre}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <p>Paciente: ${apPaterno} ${apMaterno} ${nombre}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Folio: <strong>${id}</strong></p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Procedimiento: ${procedimiento}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Teléfono: ${telefono}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Tipo de cita: ${tipo_cita}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Fecha: ${fecha} ${hora_ini}</p>
                                    </div>
                                    <%
                                        if (is_paciente == 1) {
                                            if (!id_relacion_mp) {
                                    %>
                                    <div class="col-md-12" id="medico-asignado-${cita_id}">
                                        <label for="medico-${cita_id}">Asignar médico:</label>
                                        <select id="medico-${cita_id}"></select>
                                        <button class="btn btn-success btn-sm" onclick="asignarMedico('${id}', '${cita_id}');">Asignar</button>
                                    </div>
                                    <%      } else {
                                    %>
                                    <div class="col-md-12">
                                        <p>Médico asignado: ${medico_nombre} ${medico_apellido}</p>
                                    </div>
                                    <%      }
                                        }
                                    %>
                                    <div class="col-md-12">
                                        <form id="cerrar-${cita_id}" class="form-group">
                                            <div class="col-md-8" style="vertical-align: middle">
                                                <label for="asistio-${cita_id}">¿Se llevo acabo la cita?</label>
                                            </div>
                                            <% if (asistencia == 0) { %>
                                            <div class="col-md-4">
                                                <select id="asistio-${cita_id}" class="form-control">
                                                    <option disabled selected></option>
                                                    <option value="1">Si</option>
                                                    <option value="2">No</option>
                                                </select>
                                            </div>
                                            <% } else { %>
                                                <% if ((asistencia == 1) || (asistencia == 2)){ %>
                                                    <% if (asistencia == 1 ) { %>
                                                        <a href="control#user=${id}">Si</a>
                                                    <% } else { %>
                                                        <a href="control#user=${id}">No</a>
                                                    <% } %>
                                                <% } else { %>
                                                    <a href="control#user=${id}">En espera</a>
                                                <% } %>
                                            <% } %>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group" align="right">
                                    <div class="col-md-12">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary btn-block" type="submit" name="up_button" onclick="event.preventDefault(); setAsistencia(${cita_id}, ${id});" id="up_button">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </script>
    <script src="<?php echo app_url(); ?>js/printThis.js"></script>
    <script src="<?php echo app_url(); ?>js/calendario.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>