<?php
    include dirname(__FILE__) . '/../layouts/header.php';
?>

<div class="container">
    <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
</div>

<link href='../../css/calendarioCorte/fullcalendar.min.css' rel='stylesheet' />
<script src='../../js/calendarioCorte/lib/moment.min.js'></script>
<script src='../../js/calendarioCorte/lib/jquery.min.js'></script>
<script src='../../js/calendarioCorte/fullcalendar.min.js'></script>
<script src='../../js/calendarioCorte/locale-all.js'></script>

<!-- Page Content -->

<script>

    $(document).ready(function() {
        
        $('#calendarCorte').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            locale: 'es',
            defaultDate: '2017-09-12',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                // Display the modal.
                // You could fill in the start and end fields based on the parameters
                $('.modal').modal('show');
            },
            eventClick: function(event, element) {
                // Display the modal and set the values to the event values.
                $('.modal').modal('show');
                $('.modal').find('#title').val(event.title);
                $('.modal').find('#starts-at').val(event.start);
                $('.modal').find('#ends-at').val(event.end);
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2017-09-01'
                },
                {
                    title: 'Long Event',
                    start: '2017-09-07',
                    end: '2017-09-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-09-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2017-09-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2017-09-11',
                    end: '2017-09-11'
                },
                {
                    title: 'Meeting',
                    start: '2017-09-12T10:30:00',
                    end: '2017-09-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2017-09-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2017-09-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2017-09-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2017-09-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2017-09-13T07:00:00'
                },
                {
                    title: 'Corte de Caja',  

                    start: '2017-09-28'
                }
            ]
        });
        
    });

</script>

<div class="container">
    <div class="row">
        
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

        <div class="col-md-9">
            <div class="thumbnail">
                <div class="caption-full">
                    <h3 style="display:inline; color:#337ab7;">Administrador - Corte de Caja</h3>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""></span>
                    <div id="error"></div>
                    <hr>
                    <br>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div id='calendarCorte'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">    
            <!-- Modal content-->
            <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Fecha: 05/10/2017</h4>
        </div>
        <div class="modal-body">
            <p>Datos:</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn prymary" data-dismiss="modal">Imprimir</button>
        </div>
      </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>