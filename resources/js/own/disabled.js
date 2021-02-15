function selectTipo() 
{
	var tipo = document.getElementById('tipoPersona').value;
	var subtipo = document.getElementById('subtipoPersona');
	var hidden = document.getElementById('subtipoPersonaHidden');

	if (tipo === "DENUNCIANTE") 
	{
		subtipo.disabled = false;
		hidden.disabled = true;
	}
	else
	{
		subtipo.disabled = true;
		hidden.disabled = false;		
	}
}



