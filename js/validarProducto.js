function validar() {
document.getElementById('errornombre').style.display='none'
document.getElementById('errordescripcion').style.display='none'
document.getElementById('errorprecio').style.display='none'

	var formulario = document.registro
	    if(formulario.nombre.value == null || formulario.nombre.value == ""){
        document.getElementById('errornombre').style.display='block'
        document.registro.nombre.focus()
        return false;
      }
      if(formulario.descripcion.value == null || formulario.descripcion.value == ""){
        document.getElementById('errordescripcion').style.display='block'
        document.registro.descripcion.focus()
        return false;
      }
      if(formulario.precio.value == null || formulario.precio.value == ""){
        document.getElementById('errorprecio').style.display='block'
        document.registro.precio.focus()
        return false;
      }
         if (FileUploadPath == '') {
                    document.getElementById('errorimagen').style.display='block'
                    return false;
        }
        else{
            return true;
        }

function ValidateFileUpload() {
        var fuData = document.getElementById('imagen');
        var FileUploadPath = fuData.value;

//To check if user upload any file
        if (FileUploadPath == '') {
            document.getElementById('errorimagen').style.display='block'
            return false;

        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

if (Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg") {

// To Display
                if (fuData.files && fuData.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imagen').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(fuData.files[0]);
                    return true;
                }

            } 

//The file upload is NOT an image
else {
                alert("Photo only allows file types of GIF, PNG, JPG, JPEG and BMP. ");
                return false;

            }
        }
    }