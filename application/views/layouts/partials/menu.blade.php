<li class="header">MENÚ PRINCIPAL</li>


{{-- Inicio--}}

  <li>
    <a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>
        <span>Inicio</span>
    </a>
  </li>


{{-- Perfil --}}

<li class="treeview">
  <a href="#">
    <i class="fa fa fa-user"></i>
    <span>Perfil</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Usuarios/Editar/'.$auth[0]->Id)}}"><i class="fa fa-pencil"></i> Editar Información</a>
    </li>
    <li>
      <a href="{{base_url('Password')}}"><i class="fa fa-lock"></i> Editar Contraseña</a>
    </li>
  </ul>
</li>

{{-- Apoderados --}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-mortar-board"></i>
    <span>Apoderados</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Apoderados')}}"><i class="fa fa-list"></i> Listar Apoderados</a>
    </li>
    <li>
      <a href="{{base_url('Apoderados/Crear')}}"><i class="fa  fa-plus"></i> Nuevo Apoderado</a>
    </li>
  </ul>
</li>


{{-- Casos --}}

<li class="treeview">
  <a href="#">
    <i class="fa fa  fa-balance-scale"></i>
    <span>Casos</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Casos')}}"><i class="fa fa-list"></i> Listar Casos</a>
    </li>
    <li>
      <a href="{{base_url('Casos/Crear')}}"><i class="fa  fa-plus"></i> Nuevo Caso</a>
    </li>
  </ul>
</li>

{{-- Comparendos --}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-file-text"></i>
    <span>Comparendos</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Comparendos')}}"><i class="fa fa-list"></i> Listar Comparendos</a>
    </li>
    <li>
      <a href="{{base_url('Comparendos/Crear')}}"><i class="fa  fa-plus"></i> Nuevo Comparendo</a>
    </li>
  </ul>
</li>


{{-- Personas --}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-child"></i>
    <span>Personas</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Personas')}}"><i class="fa fa-list"></i> Listar Personas</a>
    </li>
    <li>
      <a href="{{base_url('Personas/Crear')}}"><i class="fa  fa-plus"></i> Nueva Persona</a>
    </li>
  </ul>
</li>

  {{-- Eventos --}}

 <li>
    <a href="{{base_url('Eventos')}}"><i class="fa fa-calendar"></i>
        <span>Eventos</span>
    </a>
  </li>


{{-- Audiencias --}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-university"></i>
    <span>Audiencias</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Audiencias')}}"><i class="fa fa-list"></i> Listar Audiencias</a>
    </li>
    <li>
      <a href="{{base_url('Audiencias/Crear')}}"><i class="fa  fa-plus"></i> Nueva Audencia</a>
    </li>
  </ul>
</li>

{{-- Usuarios --}}
@if ($auth[0]->Rol == 'ADMINISTRADOR')
<li class="treeview">
  <a href="#">
    <i class="fa fa-users"></i>
    <span>Usuarios</span>
    <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{base_url('Usuarios')}}"><i class="fa fa-list"></i> Listar Usuarios</a>
    </li>
    <li>
      <a href="{{base_url('Usuarios/Crear')}}"><i class="fa  fa-plus"></i> Nuevo Usuario</a>
    </li>
  </ul>
</li>
@endif

{{-- Plantilla --}}
<li class="header">PLANTILLAS</li>
<li>
    <a href="{{base_url('Casos/Plantilla/Editar')}}"><i class="fa  fa-edit "></i>
        <span>Actualizar Casos</span>
    </a>
  </li>





