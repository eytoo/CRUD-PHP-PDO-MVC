<?php include 'partials/head.php';?>
<?php include 'partials/menu.php';?>

<?php

include '../controlador/UsuarioControlador.php';
include '../helps/helps.php';

$usuario = null;

if (isset($_GET["id"])) {
    $id      = validar_campo($_GET["id"]);
    $usuario = UsuarioControlador::getUsuarioPorId($id);
}

?>

<div class="container">

	<div class="starter-template">
		<br>
		<br>
		<br>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="crear_usuario_logic.php" method="POST" role="form">

							<?php if (is_null($usuario)) {?>
							<legend>Crear nuevo usuario</legend>
							<?php } else {?>
							<legend>Editar usuario [<?php echo $usuario->getNombre() ?>]</legend>
							<input type="hidden" name="id" value="<?php echo $usuario->getId() ?>">
							<?php }?>

							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" name="txtNombre" class="form-control" id="nombre" autofocus required placeholder="Ingresa tu nombre" value="<?php echo is_null($usuario) ? "" : $usuario->getNombre() ?>">
							</div>

							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" name="txtEmail" class="form-control" id="email"  required placeholder="Ingresa tu dirección de e-mail" value="<?php echo is_null($usuario) ? "" : $usuario->getEmail() ?>">
							</div>

							<div class="form-group">
								<label for="usuario">Usuario</label>
								<input type="text" name="txtUsuario" class="form-control" id="usuario" autofocus required placeholder="usuario" value="<?php echo is_null($usuario) ? "" : $usuario->getUsuario() ?>">
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="txtPassword" class="form-control" required id="password" placeholder="****">
							</div>

							<button type="submit" class="btn btn-success"> <?php echo is_null($usuario) ? "Agregar" : "Editar" ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div><!-- /.container -->

<?php include 'partials/footer.php';?>