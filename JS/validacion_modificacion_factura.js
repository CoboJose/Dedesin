function validateFactura() {
	var error1 = fechaValidation();
	        
	var error2 = numeroFacturaValidation();
		
	var error3 = serieValidation();
	
	var error4 = conceptoValidation();
	
	var error5 = tipoImpositivoValidation();
	
	var error6 = ivaValidation();
	
	var error7 = totalValidation();
	
	var error8 = fechaPagoValidation();
	
	var error9 = importeValidation();
	
	var error10 = formaPagoValidation();
	
	var error11 = statusValidation();
	
	var error12 = pagoValidation();
	
	var error13 = recepcionValidation();
	
	var error14 = personaRecepcionValidation();
	
	var error15 = fechaRecepcionValidation();
	
	var error16 = observacionesValidation();
	        
	return (error1.length==0) && (error2.length==0) && (error3.length==0) && (error4.length==0) && (error5.length==0) 
	&& (error6.length==0) && (error7.length==0) && (error8.length==0) && (error9.length==0) && (error10.length==0) && 
	(error11.length==0) && (error12.length==0) && (error13.length==0) && (error14.length==0) && (error15.length==0) &&
	(error16.length==0);
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

function numeroFacturaValidation(){
	var numeroFactura = document.getElementById("NUMEROFACTURA");
	var num = numeroFactura.value;
	var valid = true;
	
	var hasPattern = /^[0-9]*$/;
	
	valid = valid && hasPattern.test(num);
		
	if(!valid){
		var error = "El numero de la factura debe de ser un entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//numeroFactura.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function serieValidation(){
	var serie = document.getElementById("SERIE");
	var sr = serie.value;
	var valid = true;

	valid = valid && (sr.length!=0);
		
	if(!valid){
		var error = "El serie no puede estar vacío";
	}else{
		var error = "";
	}
	if(error.length>0){
		//serie.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function conceptoValidation(){
	var concepto = document.getElementById("CONCEPTO");
	var con= concepto.value;
	var valid = true;

	valid = valid && (con.length!=0);
			
	if(!valid){
		var error = "El concepto no debe estar vacio";
	}else{
		var error = "";
	}
	if(error.length>0){
		//concepto.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function tipoImpositivoValidation(){
	var tipoImpositivo = document.getElementById("TIPOIMPOSITIVO");
	var tipo = tipoImpositivo.value;
	var valid = true;
	
	var hasPattern = /^[0-9]*$/;	
	
	valid = valid && hasPattern.test(tipo);
		
	if(!valid){
		var error = "El tipo impositivo debe de ser un número entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//tipoImpositivo.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function ivaValidation(){
	var iva= document.getElementById("IVA");
	var iv = iva.value;
	var valid = true;
		
	var hasPattern = /^[0-9]*$/;	
	
	valid = valid && hasPattern.test(iv);
		
	if(!valid){
		var error = "El IVA debe de ser un número entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//iva.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function totalValidation(){
	var total= document.getElementById("TOTAL");
	var tt = total.value;
	var valid = true;
		
	var hasPattern = /^[0-9]*$/;	
	
	valid = valid && hasPattern.test(tt);
		
	if(!valid){
		var error = "El Total debe de ser un número entero";
	}else{
		var error = "";
	}
	if(error.length>0){
		//total.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function fechaPagoValidation(){
	var fecha = document.getElementById("FECHAPAGO");
	var fec = fecha.value;
	var valid = true;

	var hasPattern = /^(\d{1,2})\/(\d{1,2})\/(\d{3,4})$/;
	var hasPattern2 = /^(\d{1,2})-(\d{1,2})-(\d{3,4})$/;

	$valid = valid && (hasPattern.test(fec) || hasPattern2.test(fec));
		
	if(!valid){
		var error = "El formato de fecha de pago debe ser mm-dd-yyyy";
	}else{
		var error = "";
	}
	if(error.length>0){
		//fecha.setCustomValidity(error);
		alert(error);
	}
	return error;
	
}

function importeValidation(){
	var importe = document.getElementById("IMPORTE");
	var impor = importe.value;
	var valid = true;
		
	var hasPattern = /^([0-9]{4}|[0-9]{3}|[0-9]{2}|[0-9]{1}),[0-9]{2}$/;
	valid = valid && hasPattern.test(impor);
		
	if(!valid){
		var error = "El importe debe tener dos decimales y como máximo sera 9999,99";
	}else{
		var error = "";
	}
	if(error.length>0){
		importe.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function formaPagoValidation(){
	var formaPago = document.getElementById("FORMAPAGO");
	var forma = formaPago.value;
	var valid = true;
		
	valid = valid && (forma.length!=0) && (forma.length<=15);
		
	if(!valid){
		var error = "La forma de pago debe estar completa con menos de 15 carácteres";
	}else{
		var error = "";
	}
	if(error.length>0){
		//formaPago.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function statusValidation(){
	var status = document.getElementById("STATUS");
	var stt = status.value;
	var valid = true;
		
	valid = valid && (stt.length!=0) && (stt.length<=10);
		
	if(!valid){
		var error = "El status debe estar completo con menos de 10 carácteres";
	}else{
		var error = "";
	}
	if(error.length>0){
		//status.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function pagoValidation(){
	var pago = document.getElementById("PAGO");
	var pg = pago.value;
	var valid = true;
	
	var hasPattern = /^[01]$/;
		
	valid = valid && hasPattern.test(pg);
		
	if(!valid){
		var error = "El pago debe ser 0 o 1";
	}else{
		var error = "";
	}
	if(error.length>0){
		//pago.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function recepcionValidation(){
	var recepcion = document.getElementById("RECEPCION");
	var recep = recepcion.value;
	var valid = true;
		
	valid = valid && (recep==0 || recep==1);
		
	if(!valid){
		var error = "La recepcion debe ser 0 o 1";
	}else{
		var error = "";
	}
	if(error.length>0){
		//recepcion.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function personaRecepcionValidation(){
	var personaRecepcion = document.getElementById("PERSONARECEPCION");
	var persona = personaRecepcion.value;
	var valid = true;
		
	valid = valid && (persona.length!=0) && (persona.length<=20);
		
	if(!valid){
		var error = "La persona debe estar completa con menos de 20 carácteres";
	}else{
		var error = "";
	}
	if(error.length>0){
		//personaRecepcion.setCustomValidity(error);
		alert(error);
	}
	return error;
}

function fechaRecepcionValidation(){
	var fecha = document.getElementById("FECHARECEPCION");
	var fec = fecha.value;
	var valid = true;

	var hasPattern = /^(\d{1,2})\/(\d{1,2})\/(\d{3,4})$/;
	var hasPattern2 = /^(\d{1,2})-(\d{1,2})-(\d{3,4})$/;

	$valid = valid && (hasPattern.test(fec) || hasPattern2.test(fec));
		
	if(!valid){
		var error = "El formato de fecha de recepcion debe ser mm-dd-yyyy";
	}else{
		var error = "";
	}
	if(error.length>0){
		//fecha.setCustomValidity(error);
		alert(error);
	}
	return error;
	
}

function observacionesValidation(){
	var observacion = document.getElementById("OBSERVACIONES");
	var obser = observacion.value;
	var valid = true;
		
	valid = valid && (obser.length!=0) && (obser.length<=20);
		
	if(!valid){
		var error = "Las observaciones debe estar completa con menos de 300 carácteres";
	}else{
		var error = "";
	}
	if(error.length>0){
		//observacion.setCustomValidity(error);
		alert(error);
	}
	return error;
}