function validar() {

	var formulario = document.registrologin
	if(formulario.email.value == null || formulario.email.value == ""){
        document.getElementById('emailerror').style.display='block'
        document.registrologin.email.focus()
        return false;
      }
      if(formulario.password.value == null || formulario.password.value == ""){
        document.getElementById('passerror').style.display='block'
        document.registrologin.password.focus()
        return false;
      }
     return true;
}