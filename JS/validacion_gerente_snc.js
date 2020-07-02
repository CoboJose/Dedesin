function validateSNC() {
	
	var error1 = dniValidation();
	        
	var error2 = fechaValidation();
		
	var error3 = horaValidation();
	
	var error4 = observacionesValidation();
	
	var error5 = tipoPlagaValidation();
	
	var error6 = idsncValidation();
	        
	return (error1.length==0) && (error2.length==0) && (error3.length==0) && (error4.length==0) && (error5.length==0) &&
	(error6.length==0);
}

function dniValidation(){
	var dni_cif = document.getElementById("dni_cif");
	var dni = dni_cif.value;
	var valid = true;

	valid = valid && (dni.length==9);
		
	var hasPattern = /^[0-9]{8}[A-Z]$/;
	valid = valid && (hasPattern.test(dni));
		
	if(!valid){
		var error = "Por favor el DNI debe tener 8 dígitos y una letra mayúscula al final";
	}else{
		var error = "";
	}
	if(error.length>0){
		//dni_cif.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function fechaValidation(){
	var fecha = document.getElementById("fecha");
	var fec = fecha.value;
	var valid = true;
	
	var hasPattern = /^(\d{1,2})\/(\d{1,2})\/(\d{3,4})$/;
	var hasPattern2 = /^(\d{1,2})-(\d{1,2})-(\d{3,4})$/;

	$valid = valid && ((hasPattern.test(fec))||(hasPattern2.test(fec)));
		
	if(!valid){
		var error = "<p>El formato de fecha debe ser mm-dd-yyyy o mm/dd/yyyy</p>";
	}else{
		var error = "";
	}
	if(error.length>0){
		//fecha.setCustomValidity(error);
		alert(error);
	}
	return error;
	
}

function horaValidation(){
	var hora = document.getElementById("hora");
	var hour = hora.value;
	var valid = true;
		
	var hasPattern = /^([01][0-9]|2[0-3]|[1-9]):[0-5][0-9]$/;
	valid = valid && (hasPattern.test(hour));
		
	if(!valid){
		var error = "<p>El formato de la hora debe se HH:MM</p>";
	}else{
		var error = "";
	}
	if(error.length>0){
		//hora.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function observacionesValidation(){
	var observaciones = document.getElementById("observaciones");
	var obser = observaciones.value;
	var valid = true;

	valid = valid && (obser.length!=0) && obser.length<=400;
			
	if(!valid){
		var error = "Las observaciones deben estar completas en menos de 400 carácteres";
	}else{
		var error = "";
	}
	if(error.length>0){
		//observaciones.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoPlagaValidation(){
	var tipoPlaga = document.getElementById("tipoPlagas");
	var tipo = tipoPlaga.value;
	var valid = true;

	valid = valid && (tipo=="Cucaracha" || tipo=="Avispas" || tipo=="Termitas" || tipo=="Ratas" || tipo=="Legionella");
			
	if(!valid){
		var error = "Los tipo plagas no pueden ser diferentes a: Cucaracha,Avispas,Termitas,Ratas,Legionella";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoPlaga.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function idsncValidation(){
	var idsnc = document.getElementById("id_snc");
	var id = idsnc.value;
	var valid = true;

	var hasPattern = /^[0-9]*$/;
	
	valid = valid && (id.length!=0) && hasPattern.test(id);
			
	if(!valid){
		var error = "El id snc debe de ser un entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//idsnc.setCustomValidity(error);
		alert(error);
	}
	return error;
}

