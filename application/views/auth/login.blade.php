@extends('layouts.auth')

@section('content')
  <h2 class="login-box-msg">Inicio de sesión</h2>

  <form id="formID" action="{{base_url('Login/Autenticar')}}" method="post">
    
    {{-- Email --}}
    <div class="form-group has-feedback">
      <input type="text" class="form-control login-field"  placeholder="Correo Electronico" name="email" required>
      <span class="fa fa-envelope form-control-feedback"></span>
    </div>

    {{-- Password  --}}
    <div class="form-group has-feedback">
      <input type="password" class="form-control login-field" placeholder="Contraseña" name="password" required>
      <span class="fa fa-key form-control-feedback"></span>
    </div>
    <div class="row">

      <table align="center" class="table table-bordered text-center">
        <tr>
          <td>
            <button type="submit" class="btn btn-block btn-success btn-sm" name="entrar" id="entrar">Entrar</button>
          </td>
        </tr>   
      </table>
    </div>
  </form>
  <center><a href="{{base_url('Password/Email')}}">Olvidé mi contraseña</a><br></center>
@endsection
