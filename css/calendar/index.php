<!DOCTYPE html>
<html>
<head>
	<title>Caledarios en jQuery UI - Tuwebonada.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/calendario.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/calendario.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#fecha1").datepicker();
			$("#fecha2").datepicker({
				changeMonth:true,
				changeYear:true,
			});
			$("#fecha3").datepicker({
				changeMonth:true,
				changeYear:true,
				showOn: "button",
				buttonImage: "css/images/ico.png",
				buttonImageOnly: true,
				showButtonPanel: true,
			})
		})
	</script>
</head>
<body>
	<div class="container">
		<h1>Calendario en jQuery IU en español</h1>
		<hr/>
		<div class="formulario">
			<h2>Formulario de fechas</h2>
			<form method="post">
				<label>Fecha 1:</label><br/>
				<input type="text" name="fecha1" id="fecha1"><br/>
				<label>Fecha 2:</label><br/>
				<input type="text" name="fecha2" id="fecha2"><br/>
				<label>Fecha 3:</label><br/>
				<input type="text" name="fecha3" id="fecha3"><br/>
			</form>
		</div>
	</div>
</body>
</html>