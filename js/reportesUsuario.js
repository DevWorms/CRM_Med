$(document).ready(function(){
	reporteCitasUsuarios();

	//SEARCH POR ENTER
	$("#searchRepUsuario").keypress(function(e){
		if(e.keyCode == 13){
			reporteCitasUsuariosBySearch();
		}
	});
});
function reporteUsuarioMasCitasPv(){
	$.ajax({
		url: APP_URL + 'class/Usuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {"get": 'reporteUsuarioMasCitasPv'},
		beforeSend: function(){
			$.notify("Obteniendo usuario que generó mas citas de primera vez", "info");
		},
		success : function(response){
			if(response.estado == 1){
				var usuario = response.rows[0];
				var nombre = usuario.nombre +" " + ((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
				var numero = usuario.numeroUsuario;
				$("#masCitasPv").html("<b>" + nombre + "<br> #Usuario: " + numero + "</b>");
			}
		},error: function(error){
			$.notify(error, "error");
		},complete: function(){
			$("#wait").hide();
		}
	});
	
}
function reporteUsuarioMenosCitasPv(){
	$.ajax({
		url: APP_URL + 'class/Usuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {"get": 'reporteUsuarioMenosCitasPv'},
		beforeSend: function(){
			$.notify("Obteniendo usuario que generó menos citas de primera vez", "info");
		},
		success : function(response){
			if(response.estado == 1){
				var usuario = response.rows[0];
				var nombre = usuario.nombre +" " +((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
				var numero = usuario.numeroUsuario;
				$("#menosCitasPv").html("<b>" +nombre + "<br> #Usuario: " + numero+ "</b>");
			}
		},error: function(error){
			$.notify(error, "error");
		},complete: function(){
			reporteUsuarioMasCitasPv();
		}
	});
	
}
function reporteUsuarioMasCitasTotal(){
	$.ajax({
		url: APP_URL + 'class/Usuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {"get": 'reporteUsuarioMasCitasTotal'},
		beforeSend: function(){
			$.notify("Obteniendo usuario que generó mas citas en total", "info");
		},
		success : function(response){
			if(response.estado == 1){
				var usuario = response.rows[0];
				var nombre = usuario.nombre + " " +((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
				var numero = usuario.numeroUsuario;
				$("#masCitasTotal").html("<b>" +nombre + "<br> #Usuario: " + numero+ "</b>");
			}
		},error: function(error){
			$.notify(error, "error");
		},complete: function(){
			reporteUsuarioMenosCitasPv();
		}
	});
	
} 
function reporteUsuarioMenosCitasTotal(){
	$.ajax({
		url: APP_URL + 'class/Usuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {"get": 'reporteUsuarioMenosCitasTotal'},
		beforeSend: function(){
			$.notify("Obteniendo usuario que generó menos citas en total", "info");
		},
		success : function(response){
			if(response.estado == 1){
				var usuario = response.rows[0];
				var nombre = usuario.nombre +" " +((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
				var numero = usuario.numeroUsuario;
				$("#menosCitasTotal").html("<b>" +nombre + "<br> #Usuario: " + numero+ "</b>");
			}
		},error: function(error){
			$.notify(error, "error");
		},complete: function(){
			reporteUsuarioMasCitasTotal();
		}
	});
	
}
function reporteCitasUsuarios(){
	$.ajax({
		url: APP_URL + 'class/Usuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {"get": 'reporteCitasUsuarios'},
		beforeSend: function(){
			$("#wait").show();
			$.notify("Cargando reporte de citas generadas por usuario", "info");
		},
		success : function(response){
			if(response.estado == 1){
				var reporte = response.rows;
				var contenido = "";
				reporte.forEach(function(item){
					contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno)+ "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" +item.primeravez +"</td>";
                    contenido += "<td>" +item.preoperatorios +"</td>";
                    contenido += "<td>" +item.cirugia +"</td>";
                    contenido += "<td>" +item.postoperatorio +"</td>";
                    contenido += "<td>" +item.valoracion +"</td>";
                    contenido += "<td>" +item.revision +"</td>";
                    contenido += "<td>" +item.tratamiento +"</td>";
					contenido += "</tr>";
				});

				$("#tblReporteCitasUsr").html(contenido);
			}
		},error: function(error){
			$.notify(error, "error");
		},complete: function(){
			reporteUsuarioMenosCitasTotal();
		}
	});
} 

function reporteCitasUsuariosBySearch(){
	$.ajax({
		url: APP_URL + 'class/Usuarios.php',
		type: 'POST',
		dataType: 'json',
		data: {"get": 'reporteCitasUsuariosBySearch' , "search" : document.getElementById("searchRepUsuario").value},
		beforeSend: function(){
			$("#wait").show();
		},
		success : function(response){
			if(response.estado == 1){
				var reporte = response.rows;
				var contenido = "";
				reporte.forEach(function(item){
					contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno)+ "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" +item.primeravez +"</td>";
                    contenido += "<td>" +item.preoperatorios +"</td>";
                    contenido += "<td>" +item.cirugia +"</td>";
                    contenido += "<td>" +item.postoperatorio +"</td>";
                    contenido += "<td>" +item.valoracion +"</td>";
                    contenido += "<td>" +item.revision +"</td>";
                    contenido += "<td>" +item.tratamiento +"</td>";
					contenido += "</tr>";
				});

				$("#tblReporteCitasUsr").html(contenido);
			}
		},error: function(error){
			$.notify(error, "error");
			$("#wait").hide();
		},complete: function(){
			$("#wait").hide();
		}
	});
} 