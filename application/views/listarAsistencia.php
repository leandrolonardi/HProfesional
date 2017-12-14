<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
function realizarProceso(){
		document.getElementById("contenido").hidden = false;
		var fecha = document.getElementById("fecha").value;
		var turno = document.getElementById("selectTurno").value;

		var titulo = document.getElementById("tituloAsist");
		titulo.innerHTML = "Asistencia del dia: "+fecha;

		var parametros = {
				"fecha" : fecha,
				"turno" : turno
		};

        $.ajax({
                data:  parametros,
                url:   '<?php echo base_url(); ?>listarAsistencia/probador',
                type:  'post',
                success:  function (response) {
                        $("#output").html(response);
                }
        });
}

function pdfExport(idName){ 
	fileName = document.getElementById("tituloAsist").innerHTML;
    kendo.drawing.drawDOM($('#'+idName)).then(function (group) {
		kendo.drawing.pdf.saveAs(group,fileName+'.pdf');
    });    
}

</script>

<?php foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<style>
	.contenedor{
		display: flex;
	}

	.btnFiltrar{
		margin-left: 5px;
	}

@media screen and (max-width:800px){
	.contenedor{
		flex-direction: column;
		margin-left: 0px;
	}
}
</style>



		<?php echo form_open("listarAsistencia/Hacerlo");  ?>

		<div class="contenedor">
			<div>
				<label>Fecha: </label> <input id="fecha" name="fecha" type="date" value="<?php echo date("Y-m-d");?>">
			</div>
			
			<div>
				<label>Turno: </label>
				<select name="selectTurno" id="selectTurno">
					<option value="0">Mañana</option>
					<option value="1">Tarde</option>
				</select>
			</div>

			<div>
				<input type="button" class="btnFiltrar" id="Filtrar" value="Listar" onclick="realizarProceso()">
			</div>
		</div>
		<?php echo form_close(); ?>
		
		<div id="contenido" hidden>
			<br>
			<h4 id="tituloAsist"></h4> 					

			<div id="output" style="margin-top: 25px;"></div>

			<button id="botonExportar" onclick="pdfExport('contenido')" style="margin-top: 10px;">Exportar a PDF</button>
		</div>
		
		
		
	</div>
</body>
</html>