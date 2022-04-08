<?php include('header.php') ?>
<?php include('connection.php') ?>
<?php
    if($_POST) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        
        $fecha = new DateTime();
        
        $imagen = $fecha->getTimestamp()."_".$_FILES['archivo']['name'];

        $img_temp = $_FILES['archivo']['tmp_name'];
        move_uploaded_file($img_temp, "img/".$imagen);

        $objConexion = new Conexion();
        $sql = "INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion');";
        $objConexion->Ejecutar($sql);

        header("Location:portfolio.php");
    }
    
    if($_GET) {
        $id = $_GET['borrar'];
        $objConexion = new Conexion();
        
        $imagen = $objConexion->consultar("SELECT imagen FROM `proyectos` WHERE id=".$id);
        unlink("img/".$imagen[0]["imagen"]);
        
        ///print_r($imagen);
        ///print_r($imagen[0]["imagen"]);
        
        $sql = "DELETE FROM `proyectos` WHERE `proyectos`.`id` = ".$_GET['borrar'];
        $objConexion->Ejecutar($sql);

        header("Location:portfolio.php");
    }
    
    $objConexion = new Conexion();
    $proyectos = $objConexion->Consultar("SELECT * FROM `proyectos`");
    ///print_r($resultado);
    
    ?>
<br/>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Datos del Proyecto
                </div>
                <div class="card-body">
                    <form  action="portfolio.php" method="post" enctype="multipart/form-data">
                        Nombre del proyecto:
                        <input class="form-control" type="text" name="nombre" required><br/>
                        Imagen del proyecto: 
                        <input class="form-control" type="file" name="archivo" required><br/>
                        Descripción: 
                        <textarea class="form-control" name="descripcion" rows="3" required></textarea><br/>
                    
                        <input class="btn btn-success" type="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Tabla de Datos
                </div>
                <div class="card-body">
                    <table class="table" >
                    <caption></caption>
                        <thead>
                            <tr>
                                <th>ID:</th> 
                                <th>Nombre: </th>
                                <th>Imagen: </th>
                                <th>Descripción: </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proyectos as $proyecto) { ?>
                                <tr>
                                    <td><?= $proyecto['id'] ?></td>
                                    <td><?= $proyecto['nombre'] ?></td>
                                    <td>
                                        <img  height="100" src="img/<?= $proyecto['imagen'] ?>" alt="<?= $proyecto['imagen'] ?>" title="<?= $proyecto['imagen'] ?>">
                                    </td>
                                    <td><?= $proyecto['descripcion'] ?></td>
                                    <td><a class="btn btn-danger" href="?borrar= <?= $proyecto['id'] ?>" >Eliminar</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php') ?>