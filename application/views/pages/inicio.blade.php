@extends('layouts.app')

@section('content')

  {{-- Cabecera del cuerpo --}}
  <section class="content-header">
    <h1>InspeSoft <small>Inicio</small></h1>

    {{-- Menu de navegacion--}}
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    </ol>
  </section>


  <!-- Cuerpo -->
  {{-- Modulo 1 --}}
  <br><br>
  <section class="content">
      <div class="row">

        {{-- Perfil --}}
          <a href="{{base_url('Usuarios/Editar/'.$auth[0]->Id)}}" class="box">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h4><strong>Mi Perfil</strong></h4>
                  <p>Editar</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <div class="small-box-footer">
                  Más Información <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>

          {{-- Apoderados--}}
          <a href="{{base_url('Apoderados/Crear')}}" class="box">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h4><strong>Apoderados</strong></h4>
                  <p>Crear Nuevo</p>
                </div>
                <div class="icon">
                  <i class="fa fa-mortar-board"></i>
                </div>
                <div class="small-box-footer">
                  Más Información <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>

          {{-- Casos --}}
          <a href="{{base_url('Casos/Crear')}}" class="box">
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h4><strong>Casos</strong></h4>
                    <p>Crear Nuevo</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa  fa-balance-scale"></i>
                  </div>
                  <div class="small-box-footer">
                    Más Información <i class="fa fa-arrow-circle-right"></i>
                  </div>
                </div>
              </div>
            </a>

          {{-- Comparendos--}}
          <a href="{{base_url('Comparendos/Crear')}}" class="box">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h4><strong>Comparendos</strong></h4>
                  <p>Crear Nuevo</p>
                </div>
                <div class="icon">
                  <i class="fa fa-file-text"></i>
                </div>
                <div class="small-box-footer">
                  Más Información <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>

          
      </div>


      <br><br><br><br>


      <div class="row">

        {{-- Personas --}}
          <a href="{{base_url('Personas')}}" class="box">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner">
                  <h4><strong>Personas</strong></h4>
                  <p>Listar</p>
                </div>
                <div class="icon">
                  <i class="fa fa-child"></i>
                </div>
                <div class="small-box-footer">
                  Más Información <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>

        
          
          {{-- Eventos --}}
          <a href="{{base_url('Eventos')}}" class="box">
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h4><strong>Eventos</strong></h4>
                    <p>Ver Calendario</p>
                  </div>
                  <div class="icon">
                    <i class="fa  fa-calendar"></i>
                  </div>
                  <div class="small-box-footer">
                    Más Información <i class="fa fa-arrow-circle-right"></i>
                  </div>
                </div>
              </div>
            </a>

          {{-- Audiencias --}}
          <a href="{{base_url('Audiencias/Crear')}}" class="box">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h4><strong>Audencias</strong></h4>
                  <p>Crear Nueva</p>
                </div>
                <div class="icon">
                  <i class="fa fa-university"></i>
                </div>
                <div class="small-box-footer">
                  Más Información <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>

          {{-- Usuarios--}}
          @if ($auth[0]->Rol == 'ADMINISTRADOR')
          <a href="{{base_url('Usuarios')}}" class="box">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h4><strong>Usuarios</strong></h4>
                  <p>Listar</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <div class="small-box-footer">
                  Más Información <i class="fa fa-arrow-circle-right"></i>
                </div>
              </div>
            </div>
          </a>
          @endif
      </div>      
    </section>
@endsection