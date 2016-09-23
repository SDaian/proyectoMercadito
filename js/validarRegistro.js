function validar() {
      var letters = /^[A-Za-z]+$/;
      document.getElementById('errornombre').style.display='none'
      document.getElementById('errorapellido').style.display='none'
      document.getElementById('emailerror').style.display='none'
      document.getElementById('success').style.display='none' 
      document.getElementById('erroremail').style.display='none'
      document.getElementById('errortelefono').style.display='none'
      document.getElementById('errorpass').style.display='none'
      document.getElementById('errorpassf').style.display='none'
      
      var formulario = document.registro
      var nombre = document.forms["registro"]["nombre"].value;
      if(formulario.nombre.value == null || formulario.nombre.value == "" || !letters.test(nombre)){
        document.getElementById('errornombre').style.display='block'
        document.registro.InputName.focus()
        return false;
      }
      var apellido = document.forms["registro"]["apellido"].value;
      if(formulario.apellido.value == null || formulario.apellido.value == "" || !letters.test(apellido)){
        document.getElementById('errorapellido').style.display='block'
        document.registro.InputName.focus()
        return false;
      }
      if(formulario.email.value == null || formulario.email.value == ""){
        document.getElementById('erroremail').style.display='block'
        document.registro.InputName.focus()
        return false;
      }
      if(formulario.telefono.value == null || formulario.telefono.value == ""){
        document.getElementById('errortelefono').style.display='block'
        document.registro.InputName.focus()
        return false;
      }
      if(formulario.passf.value == null || formulario.passf.value == ""){
        document.getElementById('errorpass').style.display='block'
        document.registro.InputPasswordF.focus()
        return false;
      }
      if(formulario.passs.value != formulario.passf.value){
        document.getElementById('errorpassf').style.display='block'
        document.registro.InputPasswordS.focus()
        return false;
      }
      if(formulario.passs.value != formulario.passf.value){
        document.getElementById('errorpassf').style.display='block'
        document.registro.InputPasswordS.focus()
        return false;
      }
      
      
      return true;
  }
function validarCategoria(){
  document.getElementById('nameerror').style.display='none'
  document.getElementById('nameerrortwo').style.display='none'
  var letters = /^[A-Za-z]+$/;
  var nombre = document.forms["formcategoria"]["nombrecategoria"].value;
  var formulario = document.formcategoria
  if(formulario.nombrecategoria.value == null || formulario.nombrecategoria.value == "" || !letters.test(nombre)){
        document.getElementById('nameerrortwo').style.display='block'
        document.formcategoria.nombrecategoria.focus()
        return false;
      }
  return true;
}