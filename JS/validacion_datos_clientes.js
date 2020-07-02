function validateDatosCliente() {

	var error1 = dniValidation();
	        
	var error2 = nombreValidation();
		
	var error3 = telefonoValidation();
	
	var error4 = emailValidation();
	
	var error5 = formaPagoValidation();
	
	var error6 = numCuentaValidation();
	        
	return (error1.length==0) && (error2.length==0) && (error3.length==0) && (error4.length==0) && (error5.length==0) 
	&& (error6.length==0);
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

function nombreValidation(){
	var nombre = document.getElementById("Nombre");
	var nmb = nombre.value;
	var valid = true;

	valid = valid && (nmb.length>0);
		
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

function telefonoValidation(){
	var telefono = document.getElementById("Telefono");
	var tlf = telefono.value;
	var valid = true;

	valid = valid && (tlf.length==9);
		
	var hasPattern = /^[0-9]{9}$/;
	valid = valid && (hasPattern.test(tlf));
		
	if(!valid){
		var error = "El número de telefono debe tener 9 dígitos";
	}else{
		var error = "";
	}
	if(error.length>0){
		//telefono.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function emailValidation(){
	var email = document.getElementById("Email");
	var mail = email.value;
	var valid = true;
		
	var hasPattern = /^[0-9a-zA-Z]*@[0-9a-zA-Z]*.[0-9a-zA-Z]*$/;
	valid = valid && (hasPattern.test(mail));
		
	if(!valid){
		var error = "El email debe empezar con una letra y ser del formato nombre@dominio.extension";
	}else{
		var error = "";
	}
	if(error.length>0){
		//email.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function formaPagoValidation(){
	var formaPago = document.getElementById("FormaPago");
	var pago = formaPago.value;
	var valid = true;
		
	valid = valid && (pago=="Tarjeta" || pago=="Efectivo");
		
	if(!valid){
		var error = "La forma de pago debe ser Tarjeta/Efectivo";
	}else{
		var error = "";
	}
	if(error.length>0){
		//formaPago.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function numCuentaValidation(){
	var NumeroCuenta = document.getElementById("NumeroCuenta");
	var cuenta = NumeroCuenta.value;
	var valid = true;
		
	var hasPattern = /^ES[0-9]{22}$/;
	valid = valid && (hasPattern.test(cuenta));
		
	if(!valid){
		var error = "La cuenta debe empezar por ES y seguido de 22 numeros";
	}else{
		var error = "";
	}
	if(error.length>0){
		//formaPago.setCustomValidity(error);
		alert(error);
	}
	return error;
}