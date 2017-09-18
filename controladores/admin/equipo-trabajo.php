    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>

    <div class="container">
        <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
    </div>
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>
            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
                        
                        <form>
                        <h4><a href="#">Equipo de Trabajo</a></h4>    
                            
                            <div class="form-group row">
                                <div class="col-md-offset-6">
                                <fieldset class="form-inline">
                                    <label for="">Fecha de Incorporación&nbsp&nbsp</label>
                                    <div class="input-group">
                                    <input type="text" class="search-query form-control" placeholder="dd / mm / aaaa" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </button>
                                        </span>
                                    </div>
                                </fieldset>
                                </div>
                            </div>


                            <div class="form-group row space">
                                <div class="col-md-9">
                                    <fieldset class="form-inline">
                                        <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                                        <input type="text" class="form-control" id="apellido_paterno" placeholder="Apellido Paterno">
                                        <input type="text" class="form-control" id="apellido_materno" placeholder="Apellido Materno">
                                    </fieldset>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <select class="selectpicker">
                                      <option>Administrador</option>
                                      <option>Médico</option>
                                      <option>Recepción</option>
                                      <option>Cajero</option>
                                      <option>Cirujano</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group" align="right">
                                <button type="submit" class="derecha btn btn-primary">Añadir al Equipo</button>        
                            </div>
                        </form> 

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div id="custom-search-input">
                                    <div class="input-group col-md-12">
                                        <input type="text" class="search-query form-control" placeholder="Buscar ..." />
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>Número Trabajador</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Fecha Incorporación</th>
                                    <th>Dado de baja</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td align="center">1</td>
                                    <td>Analilia Domínguez</td>
                                    <td>Administradora</td>
                                    <td>21/03/2016</td>
                                    <td align="center"><input id="radio1" name="radio" type="radio" class="custom-control-input"></td>
                                  </tr>
                                  <tr>
                                    <td align="center">2</td>
                                    <td>Guzmán Arenas</td>
                                    <td>Médico</td>
                                    <td>21/03/2016</td>
                                    <td align="center"><input id="radio2" name="radio" type="radio" class="custom-control-input"></td>
                                  </tr>
                                  <tr>
                                    <td align="center">3</td>
                                    <td>Antonia Limón</td>
                                    <td>Recepción</td>
                                    <td>21/03/2016</td>
                                    <td align="center"><input id="radio1" name="radio" type="radio" class="custom-control-input"></td>
                                  </tr>
                                    <tr>
                                    <td align="center">4</td>
                                    <td>Zoe Perez</td>
                                    <td>Cajera</td>
                                    <td>21/03/2016</td>
                                    <td align="center"><input id="radio1" name="radio" type="radio" class="custom-control-input"></td>
                                  </tr>
                                    <tr>
                                    <td align="center">5</td>
                                    <td>Lilia Martínez</td>
                                    <td>Cirujano</td>
                                    <td>21/03/2016</td>
                                    <td align="center"><input id="radio1" name="radio" type="radio" class="custom-control-input"></td>
                                  </tr>
                                </tbody>
                        </table>

                        <div align="center" clas="thumbnail">
                            <ul class="pagination" >
                                <li><a href="#">&laquo;</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">&raquo;</a></li>
                            </ul>
                        </div>
                
                    <!-- /Caption full -->
                    </div>
                <!-- /Thumbnail-->
                </div>
                <!-- /Col -->
                </div>      
        </div>
    </div>

    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>