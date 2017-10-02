<!-- [!] Estos div's cierran  <div class="container"> y <div class="row"> de todas las pantallas  -->
</div>
</div>
<!-- Impostantes para footer -->

<div class="container custom-footer">
    <div class="col-xs-offset-3 col-xs-6" align="center">
        <p>2017</p>
    </div>
</div>

<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="<?php echo app_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>js/Chart.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>js/Pikaday/pikaday.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>js/Pikaday/plugins/pikaday.jquery.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>plugins/Timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo app_url(); ?>plugins/Timepicker/i18n/jquery-ui-timepicker-es.js"></script>
<script src="<?php echo app_url(); ?>plugins/lodash.js"></script>

<script type="text/javascript">
    $('document').ready(function () {
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

        $('#fecha, #fecha2, #new_fecha,#e-fecha, #reagendarCita-fecha').pikaday({
            format: 'YYYY-MM-DD',
            disableDayFn: function (date) {
                var today = moment().add(1, 'd').format('YYYY-MM-DD');
                //var today = moment().format('YYYY-MM-DD');
                var ban = moment(date).format('YYYY-MM-DD');

                return moment(ban).isBefore(today);
                // return true;
            }
        });

        $('#fechaAbierta').pikaday({
            format: 'YYYY-MM-DD'
        });

        Date.prototype.fromString = function (str, ddmmyyyy) {
            var m = str.match(/(\d+)(-|\/)(\d+)(?:-|\/)(?:(\d+)\s+(\d+):(\d+)(?::(\d+))?(?:\.(\d+))?)?/);
            if (m[2] == "/") {
                if (ddmmyyyy === false)
                    return new Date(+m[4], +m[1] - 1, +m[3], m[5] ? +m[5] : 0, m[6] ? +m[6] : 0, m[7] ? +m[7] : 0, m[8] ? +m[8] * 100 : 0);
                return new Date(+m[4], +m[3] - 1, +m[1], m[5] ? +m[5] : 0, m[6] ? +m[6] : 0, m[7] ? +m[7] : 0, m[8] ? +m[8] * 100 : 0);
            }
            return new Date(+m[1], +m[3] - 1, +m[4], m[5] ? +m[5] : 0, m[6] ? +m[6] : 0, m[7] ? +m[7] : 0, m[8] ? +m[8] * 100 : 0);
        };

        if ($("#counterEnEspera").length) {
            countEnEspera();
            setInterval(countEnEspera, 300000);
        }

        function countEnEspera() {
            $.ajax({
                type: 'POST',
                url: APP_URL + 'class/Medico.php',
                data: {
                    get: 'countEnEspera'
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.estado == 1) {
                        $("#counterEnEspera").html(response.pacientes);
                    }
                }
            });
        }
    });

    //  SE LLAMA LA REFERENCIA AL TOOLTIP, QUE SERVIRÁ DE APOYO PARA QUE EL USUARIO TENGA UNA DESCRIPCIÓN DEL SISTEMA
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $('.selectpicker').selectpicker({
          size: 4
        });

        $('.dropdown-submenu a.test').on("click", function (e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });

    $('#hora, #hora2, #new_hora, #reagendarCita-hora').timepicker(
        $.timepicker.regional['es']
    );
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo app_url(); ?>js/bootstrap-select.min.js"></script>
<div class="loading" id="wait"></div>
</body>
</html>