function validateLogIn() {
	var noValidation = document.getElementById("#login");

	var error1 = dniValidation();
	
	var error2 = contrasenaValidation();
	        
	return (error1.length==0) && (error2.length==0);
}

function dniValidation(){
	var dni_cif = document.getElementById("DNI_CIF");
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

function contrasenaValidation(){
	var contrasena = document.getElementById("Contrasena");
	var cont = contrasena.value;
	var valid = true;
		
	var hasNumber = /\d/;
	var hasUpperCases = /[A-Z]/;
	var hasLowerCases = /[a-z]/;
	valid = valid && (hasNumber.test(cont)) && (hasUpperCases.test(cont)) && (hasLowerCases.test(cont));
		
	if(!valid){
		var error = "La contraseña debe tener al menos 8 carácteres incluyendo números, mayúsculas y minúsculas";
	}else{
		var error = "";
	}
	if(error.length>0){
		//contrasena.setCustomValidity(error);
		alert(error);
	}
	return error;
}