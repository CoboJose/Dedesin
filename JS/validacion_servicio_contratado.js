function validateForm() {
	
	var error1 = nombreValidation();
	        
	var error2 = idscValidation();
		
	var error3 = lugarValidation();
	
	var error4 = fechaValidation();
	
	var error5 = numeroTrabajadorValidation();
	
	var error6 = tipoTratamientoValidation();
	
	var error7 = horaValidation();
	
	var error8 = tipoMaquinaValidation();
	
	var error9 = tipoMaterialValidation();
	
	var error10 = tipoServicioValidation();
	
	var error11 = tipoPlagaValidation();
	
	var error12 = observacionesValidation();
	        
	return (error1.length==0) && (error2.length==0) && (error3.length==0) && (error4.length==0) && (error5.length==0) 
	&& (error6.length==0) && (error7.length==0) && (error8.length==0) && (error9.length==0) && (error10.length==0)
	&& (error11.length==0) && (error12.length==0);
}

function nombreValidation(){
	var nombre = document.getElementById("NOMBRE");
	var nom = nombre.value;
	var valid = true;

	valid = valid && (nom.length>0);
		
	if(!valid){
		var error = "El nombre no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//nombre.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function idscValidation(){
	var idsc = document.getElementById("ID_SC");
	var id = idsc.value;
	var valid = true;
		
	var hasPattern = /^[0-9]*$/;
	valid = valid && (hasPattern.test(id));
		
	if(!valid){
		var error = "Id_SC debe de ser un entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//telefono.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function lugarValidation(){
	var lugar = document.getElementById("LUGAR");
	var lg = lugar.value;
	var valid = true;

	valid = valid && (lg.length>0);
		
	if(!valid){
		var error = "El lugar no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//lugar.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function fechaValidation(){
	var fecha = document.getElementById("FECHA");
	var fec = fecha.value;
	var valid = true;

	var hasPattern = /^(\d{1,2})\/(\d{1,2})\/(\d{3,4})$/;
	var hasPattern2 = /^(\d{1,2})-(\d{1,2})-(\d{3,4})$/;

	$valid = valid && (hasPattern.test(fec) || hasPattern2.test(fec));
		
	if(!valid){
		var error = "El formato de fecha debe ser mm-dd-yyyy";
	}else{
		var error = "";
	}
	if(error.length>0){
		//fecha.setCustomValidity(error);
		alert(error);
	}
	return error;
	
}

function numeroTrabajadorValidation(){
	var numeroTrabajador = document.getElementById("NUMEROTRABAJADOR");
	var trabajador = numeroTrabajador.value;
	var valid = true;
		
	var hasPattern = /^[0-9]*$/;
	valid = valid && (hasPattern.test(trabajador));
		
	if(!valid){
		var error = "El numero de trabajador debe de ser un entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//numeroTrabajador.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoTratamientoValidation(){
	var tipoTratamiento = document.getElementById("TIPOTRATAMIENTO");
	var tipo = tipoTratamiento.value;
	var valid = true;
		
	valid = valid && (tipo.length>0);
		
	if(!valid){
		var error = "El tipo de tratamiento no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoTratamiento.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function horaValidation(){
	var hora = document.getElementById("HORA");
	var hour = hora.value;
	var valid = true;
		
	var hasPattern = /^([01][0-9]|2[0-3]):[0-5][0-9]$/;
	valid = valid && (hasPattern.test(hour));
		
	if(!valid){
		var error = "El formato de la hora debe se HH:MM";
	}else{
		var error = "";
	}
	if(error.length>0){
		//hora.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoMaquinaValidation(){
	var tipoMaquina = document.getElementById("TIPOMAQUINAS");
	var tipo = tipoMaquina.value;
	var valid = true;
		
	valid = valid && (tipo.length>0);
		
	if(!valid){
		var error = "El tipo de máquina no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoTratamiento.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoMaterialValidation(){
	var tipoMaterial = document.getElementById("TIPOMATERIALES");
	var tipo = tipoMaterial.value;
	var valid = true;
		
	valid = valid && (tipo.length>0);
		
	if(!valid){
		var error = "El tipo de material no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoTratamiento.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoServicioValidation(){
	var tipoServicio = document.getElementById("TIPOSERVICIOS");
	var tipo = tipoServicio.value;
	var valid = true;
		
	valid = valid && (tipo.length>0);
		
	if(!valid){
		var error = "El tipo de servicio no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoTratamiento.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoPlagaValidation(){
	var tipoPlaga = document.getElementById("TIPOPLAGAS");
	var tipo = tipoPlaga.value;
	var valid = true;
		
	valid = valid && (tipo.length>0);
		
	if(!valid){
		var error = "El tipo de plaga no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoTratamiento.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function observacionesValidation(){
	var observacion = document.getElementById("OBSERVACIONES");
	var obser = observacion.value;
	var valid = true;
		
	valid = valid && (obser.length>0);
		
	if(!valid){
		var error = "Las observaciones no pueden estar vacías";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoTratamiento.setCustomValidity(error);
		alert(error);
	}
	return error;
}
