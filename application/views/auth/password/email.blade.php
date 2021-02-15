@extends('layouts.auth')

@section('content')
  <h3 class="login-box-msg">Recuperar contraseña</h3>
  <form id="formID" action="{{base_url('Password/Enviar')}}" method="POST" autocomplete="off">

    {{-- Email --}}
    <div class="form-group has-feedback">
      <input type="text" class="form-control login-field"  placeholder="Correo Electronico" name="email" required>
      <span class="fa fa-envelope form-control-feedback"></span>
    </div>

    {{-- Botones --}}
      <table align="center" class="table table-bordered text-center">
        <tr>
          <td>
            <button type="submit" class="btn btn-block btn-success btn-sm" name="enviar" id="entrar">Enviar  </button>
          </td>
          <td>
            <a href="{{base_url('Login')}}" class="btn btn-block btn-danger btn-sm">Cancelar</a>
          </td>
        </tr>

      </table>
      <center><span>Se enviara la restauración a su correo.</span><br></center>
    </div>
  </form>
  
@endsection
