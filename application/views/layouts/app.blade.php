<!DOCTYPE html>
<html>
  @include('layouts.partials.header')
  <body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="{{base_url('Inicio')}}" class="logo">
        <span class="logo-mini"><b>In</b>St</span>
        <span class="logo-lg"><b>Inspe</b>Soft</span>
      </a>
      {{-- Fin logo--}}

      <nav class="navbar navbar-static-top" role="navigation">

        {{-- Botón móvil --}}
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        </a>

        {{-- Menú superior--}}
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">



            {{-- Menú Notificaciones --}}

            <li class="dropdown notifications-menu">

              <!-- Botón Notificaciones -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <div class="label label-warning" id="NumNotificaciones"></div> {{--Numero de Notificaciones--}}
              </a>

              <!-- Cuerpo de las Notificaciones -->
              <ul class="dropdown-menu">
                <li class="header" id="HeadNotificaciones"></li>
                <li>

                  <!-- Contenedor -->
                  <ul class="menu" id="MenuNotificaciones">
                  </ul>
                </li>
                <li class="footer"><a href="{{base_url('Eventos')}}">Ir al calendario</a></li>
              </ul>
            </li>
            {{--Fin Menu Notificaciones--}}



            {{-- Menu de usuario--}}

            <li class="dropdown user user-menu">

              <!-- Boton del menu -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa fa-user"></i>
                <span class="hidden-xs">{{$auth[0]->Nombre}}</span>
              </a>


              <!-- Logo IMG -->
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="{{base_url('resources/img/logos/logo.png')}}" class="img-circle" alt="Foto de usuario"/>
                  <p>
                    
                    <small>{{$auth[0]->Rol}}</small>
                  </p>
                </li>


                <!-- Cuerpo del menú de usuario-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{base_url('Password')}}"
                       class="btn btn-default btn-flat">Editar Contraseña</a>
                  </div>
                  <form action="{{base_url('Login/Salir')}}" method="post">            
                    <div class="pull-right">
                      <button class="btn btn-default btn-flat">Cerrar Sesión</button>
                    </div>
                  </form>
                </li>

              </ul>
            </li>
            {{--Fin Menú Usuario --}}
          </ul>
        </div>
      </nav>
    </header>
    {{-- Fin barra Cabecera --}}



    {{-- Menu Izquierdo--}}
    <aside class="main-sidebar">
      <section class="sidebar "><br>
        <div class="user-panel">

          <!-- Logo de AyudApp -->
          <div align="center">
            <a href="{{base_url('Inicio')}}">
              <img class="img-responsive" src="{{base_url('resources/img/logos/logo.png')}}">
            </a>
          </div>
        </div>

        <!-- Cuerpo Menu -->
        <ul class="sidebar-menu">
          @include('layouts.partials.menu')
        </ul>
      </section>
    </aside>




    {{-- Cuerpo de la pagina --}}
    <div class="content-wrapper">
      <section class="content">
        @include('layouts.partials.alert')
        @yield('content')
      </section>
    </div>


    {{-- Footer con logos --}}
    <footer class="main-footer">
  	  @include('layouts.partials.footer')
    </footer>


  </div>

  {{-- Scripts --}}
  @include('layouts.partials.script')

</body>
</html>



