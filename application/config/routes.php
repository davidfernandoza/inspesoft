<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'LoginController';
$route['404_override'] = 'InicioController';
$route['translate_uri_dashes'] = FALSE;


// Inicio: completo
$route['Inicio'] = 													'InicioController';

// login: completo
$route['Login']						= 								"LoginController";
$route['Login/Autenticar']			= 					"LoginController/autenticar";
$route['Login/Salir']				= 							"LoginController/salir";

// Password: completo
$route["Password"]	= 											"PasswordController";
$route["Password/Email"]	= 								"PasswordController/email";
$route["Password/Enviar"]	= 								"PasswordController/enviar";
$route["Password/Actualizar"]	= 						"PasswordController/update";

// Usuarios: completo
$route['Usuarios']						= 						"UsuariosController";
$route['Usuarios/Crear'] 				= 					"UsuariosController/create";
$route['Usuarios/Editar/(:any)'] 		= 			"UsuariosController/edit/$1";
$route["Usuarios/Guardar"] 				= 				"UsuariosController/store"; 
$route["Usuarios/Actualizar"]= 							"UsuariosController/update";
$route["Usuarios/Eliminar/(:any)"] = 				"UsuariosController/delete/$1";
$route["Usuarios/Activar/(:any)"]	= 				"UsuariosController/activate/$1";

// Casos: completo.
$route['Casos']						= 																	"CasosController";
$route['Casos/Ver/(:any)']						= 											"CasosController/show/$1";
$route['Casos/Crear'] 				= 															"CasosController/create";
$route['Casos/Editar/(:any)'] 		= 													"CasosController/edit/$1";
$route["Casos/Guardar"] 				= 														"CasosController/store"; 
$route["Casos/Actualizar"]= 																	"CasosController/update";
$route["Casos/Involucrados/Eliminar/(:any)/(:any)/(:any)/(:any)"]= 	
"CasosController/delete/$1/$2/$3/$4";
$route["Casos/Representar/(:any)/(:any)/(:any)"] = 						"CasosController/represent/$1/$2/$3";
$route["Casos/Representar/Persona"] = 												"CasosController/attorney";

// Impresiones: completo.
$route["Imprimir/(:any)"] = 																	"ImpresionesController/show/$1";
$route["Casos/Plantilla/Editar"]=															"ImpresionesController/edit";
$route["Plantilla/Actualizar"]=																"ImpresionesController/update";

// Fallos: completo
$route['Fallos/Crear/(:any)'] 	=									"FallosController/create/$1";
$route['Fallos/Editar/(:any)/(:any)'] =						"FallosController/edit/$1/$2";
$route["Fallos/Guardar"] 				= 								"FallosController/store"; 
$route["Fallos/Actualizar"]= 											"FallosController/update";
$route["Fallos/Eliminar/(:any)/(:any)/(:any)"] = 	"FallosController/delete/$1/$2/$3";

// Comparendos: completo
$route['Comparendos']						= 								"ComparendosController";
$route['Comparendos/Ver/(:any)']						= 		"ComparendosController/show/$1";
$route['Comparendos/Crear'] 				= 						"ComparendosController/create";
$route['Comparendos/Editar/(:any)'] 		= 				"ComparendosController/edit/$1";
$route["Comparendos/Guardar"] 				= 					"ComparendosController/store"; 
$route["Comparendos/Actualizar"]= 								"ComparendosController/update";
$route["Comparendos/Ver/Eliminar/(:any)"]=				"ComparendosController/delete/$1";

// Personas: completo.
$route['Personas']						= 								"PersonasController";
$route['Personas/Crear'] 				= 							"PersonasController/create";
$route['Personas/Editar/(:any)'] 		= 					"PersonasController/edit/$1";
$route["Personas/Guardar"] 				= 						"PersonasController/store"; 
$route["Personas/Actualizar"]= 									"PersonasController/update";
$route['Personas/Involucrar/(:any)'] =					"PersonasController/involve/$1";
$route['Personas/Implicar'] =										"PersonasController/imply";
$route['Personas/Ver/(:any)']						= 			"PersonasController/show/$1";

// Apoderados: completo.
$route['Apoderados']						= 							"ApoderadosController";
$route['Apoderados/Crear'] 				= 						"ApoderadosController/create";
$route['Apoderados/Editar/(:any)'] 		= 				"ApoderadosController/edit/$1";
$route['Apoderados/Ver/(:any)'] 		= 					"ApoderadosController/show/$1";
$route["Apoderados/Guardar"] 				= 					"ApoderadosController/store"; 
$route["Apoderados/Actualizar"]= 								"ApoderadosController/update";

// Eventos: completo
$route['Eventos']						= 									"EventosController";
$route['Eventos/Ver/(:any)'] = 									"EventosController/show/$1";
$route['Eventos/Ajax/Consultar'] = 							"EventosController/consult";
$route['Eventos/Ajax/Notificaciones'] = 				"EventosController/notifications";
$route['Eventos/Acciones/(:any)'] 				= 		"EventosController/actions/$1";

// Audiencias: completo
$route['Audiencias']						= 							"AudienciasController";
$route['Audiencias/Crear'] 				= 						"AudienciasController/create";
$route['Audiencias/Ver/(:any)'] 		= 					"AudienciasController/show/$1";
$route["Audiencias/Guardar"] 				= 					"AudienciasController/store"; 
$route["Audiencias/Escusar/D"] = 								"AudienciasController/updated";
$route["Audiencias/Escusar/C"] = 								"AudienciasController/updatec";
$route["Audiencias/Editar/(:any)"] = 						"AudienciasController/edit/$1";
$route["Audiencias/Actualizar"] = 							"AudienciasController/update";





