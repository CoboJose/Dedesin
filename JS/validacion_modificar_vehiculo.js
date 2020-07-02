function validateModificarDatosVehiculo() {

	var error1 = matriculaValidation();
	        
	var error2 = kmtotalesValidation();
		
	var error3 = itvValidation();
	
	var error4 = seguroValidation();
	
	var error5 = numeroTrabajadorValidation();
	        
	return (error1.length==0) && (error2.length==0) && (error3.length==0) && (error4.length==0) && (error5.length==0);
}

function validateCrearVehiculo() {

	var error1 = matriculaValidation();
	        
	var error2 = kmtotalesValidation();
		
	var error3 = itvValidation();
	
	var error4 = seguroValidation();
	
	var error5 = numeroTrabajadorValidation();
	
	var error6 = numeroBastidorValidation();
	        
	return (error1.length==0) && (error2.length==0) && (error3.length==0) && (error4.length==0) && (error5.length==0)
	&& (error6.length==0);
}

function matriculaValidation(){
	var matricula = document.getElementById("Matricula");
	var mat = matricula.value;
	var valid = true;

	valid = valid && (mat.length!=0);
		
	var hasPattern = /^[0-9]{4} [A-Z]{3}$/;
	var hasPattern2 = /^[A-Z]{2} [0-9]{4} [A-Z]{2}$/;
	valid = valid && (hasPattern.test(mat) || hasPattern2.test(mat));
		
	if(!valid){
		var error = "La matricula debe ser 4 dígitos y 3 letras o 2 letras, 4 dígitos y 2 letras";
	}else{
		var error = "";
	}
	if(error.length>0){
		//matricula.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function kmtotalesValidation(){
	var kmtotales = document.getElementById("KmTotales");
	var km = kmtotales.value;
	var valid = true;
	
	var hasPattern = /^[0-9]*$/;

	valid = valid && hasPattern.test(km);
		
	if(!valid){
		var error = "Los KMs deben ser un número entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//kmtotales.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function itvValidation(){
	var itv = document.getElementById("ITV");
	var fec = itv.value;
	var valid = true;

	var hasPattern = /^(\d{1,2})\/(\d{1,2})\/(\d{3,4})$/;
	var hasPattern2 = /^(\d{1,2})-(\d{1,2})-(\d{3,4})$/;

	$valid = valid && (hasPattern.test(fec) || hasPattern2.test(fec));
		
	if(!valid){
		var error = "El formato de la fecha de ITV debe ser mm/dd/yyyy o mm-dd-yyyy";
	}else{
		var error = "";
	}
	if(error.length>0){
		//itv.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function seguroValidation(){
	var seguro = document.getElementById("Seguro");
	var fec = seguro.value;
	var valid = true;

	var hasPattern = /^(\d{1,2})\/(\d{1,2})\/(\d{3,4})$/;
	var hasPattern2 = /^(\d{1,2})-(\d{1,2})-(\d{3,4})$/;

	$valid = valid && (hasPattern.test(fec) || hasPattern2.test(fec));
		
	if(!valid){
		var error = "El formato de la fecha de seguro debe ser mm/dd/yyyy o mm-dd-yyyy";
	}else{
		var error = "";
	}
	if(error.length>0){
		//seguro.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function numeroTrabajadorValidation(){
	var numtrabajador = document.getElementById("NumTrabajador");
	var num = numtrabajador.value;
	var valid = true;
		
	var hasPattern = /^[0-9]*$/;
	valid = valid && hasPattern.test(num);
		
	if(!valid){
		var error = "El ID del trabajador debe de ser un número entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//numtrabajador.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function numeroBastidorValidation(){
	var numbastidor = document.getElementById("NumBastidor");
	var num = numbastidor.value;
	var valid = true;
		
	var hasPattern = /^[A-Z]{5}[0-9][A-Z]{2}[0-9][A-Z][0-9]{6}$/;
	valid = valid && hasPattern.test(num);
		
	if(!valid){
		var error = "El numero de bastidor debe seguir el patrón XXXXX0XX0X000000";
	}else{
		var error = "";
	}
	if(error.length>0){
		//numbastidor.setCustomValidity(error);
		alert(error);
	}
	return error;
}
