<!DOCTYPE html>
<html>
  @include('layouts.partials.header')
  <body class="hold-transition login-page">
    <div class="login-box"> 

      {{-- Logo --}}
      <div align="center">
          <img  class="img-responsive pad" src="{{base_url('resources/img/logos/logo.png')}}" alt="Photo" width="270px" height="270px">
      </div>

      {{-- Alertas --}}
      @include('layouts.partials.alert')    

      {{-- Cuerpo --}}
      <div class="login-box-body">
        @yield('content')
      </div>

    </div>

    {{-- Scripts --}}
    @include('layouts.partials.script')

  </body>
</html>