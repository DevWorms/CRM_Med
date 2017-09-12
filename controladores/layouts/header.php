<?php
    include dirname(__FILE__) . '/../datos/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo app_url(); ?>img/HiAppHere_com_giannisgx89.morena.icons.png" type="image/x-icon">
    <title>Medilaser CRM</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo app_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo app_url(); ?>css/administrador-style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo app_url(); ?>css/directorio-style.css">
    <link rel="stylesheet" href="<?php echo app_url(); ?>css/hr-styles.css">
    <link rel="stylesheet" href="<?php echo app_url(); ?>css/custom-style.css">
    <link rel="stylesheet" href="<?php echo app_url(); ?>css/function-style.css">
    <link rel="stylesheet" href="<?php echo app_url(); ?>js/Pikaday/css/pikaday.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo app_url(); ?>css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo app_url(); ?>css/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="<?php echo app_url(); ?>js/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="<?php echo app_url(); ?>js/validation.min.js"></script>
    <script type="text/javascript" src="<?php echo app_url(); ?>js/notify.min.js"></script>
    <script src="<?php echo app_url(); ?>js/jquery-ui.js"></script>
    <!--   FullCalendar Libraries  -->
    <link href='<?php echo app_url(); ?>plugins/FullCalendar/fullcalendar.min.css' rel='stylesheet' />
    <link href='<?php echo app_url(); ?>plugins/FullCalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link type='text/css' rel='stylesheet' href='<?php echo app_url(); ?>plugins/Timepicker/jquery-ui-timepicker-addon.css' />
    <script src='<?php echo app_url(); ?>plugins/FullCalendar/lib/moment.min.js'></script>
    <script src='<?php echo app_url(); ?>plugins/FullCalendar/fullcalendar.min.js'></script>
    <script src='<?php echo app_url(); ?>plugins/FullCalendar/lang/es.js'></script>
    <!-- HoverBuzz -->    
    <link href="<?php echo app_url(); ?>plugins/HoverBuzz/hover.css" rel="stylesheet" media="all">

    <style>
        .select-row:hover {
            background-color: #E0E6F8;
        }
        .ui-draggable, .ui-droppable {
            background-position: top;
        }

        .cuadradoAsitio {
            width: 20px;
            height: 20px;
            background: #19ff60;
            position: absolute;
        }

        .cuadradoNoAsitio {
            width: 20px;
            height: 20px;
            background: #ff1919;
            position: absolute;
        }

        @media print {
            .visible-print  { display: inherit !important; }
            .hidden-print   { display: none !important; }
        }

        .loading {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('img/FhHRx.gif')
            50% 50%
            no-repeat;
        }

        .counting {
            margin-top: 1%;
            margin-left: 2%;
            display: inline-block;
            position: absolute;
        }

        #progressbox {border: 1px solid #0099CC;padding: 1px;position: relative;border-radius: 3px;margin: 10px;text-align: left;background: #fff;box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);}
        #progressbox .progressbar{height: 20px;border-radius: 3px;background-color: #59B5FF;width: 0;box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);}
        #progressbox .statustxt{top:3px;left:50%;position:absolute;display:inline-block;color: #000000;}
    </style>

    <script type="text/javascript">
        var APP_URL = '<?php echo app_url(); ?>';
    </script>

</head>

<body style="padding-top: 30px">