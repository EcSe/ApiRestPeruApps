<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsuarioModel;

class UsuarioController extends Controller
{
    public function Registro(Request $request){

        $json = $request->input('json',null);
       $parametros = json_decode($json);

        $idusuario = (!is_null($json) && isset($parametros->idusuario)) ? $parametros->idusuario : null;
        $password = (!is_null($json) && isset($parametros->password)) ? $parametros->password : null;
        $nombre = (!is_null($json) && isset($parametros->nombre)) ? $parametros->nombre : null;
        $apellido_pat = (!is_null($json) && isset($parametros->apellido_pat)) ? $parametros->apellido_pat : null;
        $apellido_mat = (!is_null($json) && isset($parametros->apellido_mat)) ? $parametros->apellido_mat : null;
        $direccion = (!is_null($json) && isset($parametros->direccion)) ? $parametros->direccion : null;
        $dni = (!is_null($json) && isset($parametros->dni)) ? $parametros->dni : null;
        $foto = (!is_null($json) && isset($parametros->foto)) ? $parametros->foto : null;

        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
        $usuario_bd =  UsuarioModel::where('CH_ID_USUARIO','=',$idusuario)->first();
        $dni_bd = UsuarioModel::where('VC_DNI','=',$dni)->first();

        if(count($usuario_bd) > 0)
        {
            $data = array(
                'status' => 'failed',
                'codigo' => '400',
                'mensaje' => 'El ID de usuario ya esta siendo usado'
            );
        }
         else if(count($dni_bd) > 0)
         {
            $data = array(
                'status' => 'failed',
                'code' => '400',
                'mensaje' => 'Este DNI ya ha sido registrado'
            );
         }else{
             $usuarioSave = new UsuarioModel();
             $usuarioSave->CH_ID_USUARIO = $idusuario;
             $usuarioSave->VC_PASSWORD = $pass_hash;
             $usuarioSave->VC_NOMBRE = $nombre;
             $usuarioSave->VC_APELLIDO_PAT = $apellido_pat;
             $usuarioSave->VC_APELLIDO_MAT = $apellido_mat;
             $usuarioSave->VC_DIRECCION = $direccion;
             $usuarioSave->VC_DNI = $dni;
             $usuarioSave->VC_FOTO = $foto;

             $usuarioSave->save();
             $data = array(
                 'status' => 'success',
                 'code' => '200',
                 'mensaje' => 'El usuario se ha agregado correctamente'
             );
         }
         return response()->json($data,'200');  

    }

    public function Login(Request $request)
    {
       $json = $request->input('json',null);
       $obj = json_decode($json);

       $idusuario = (!is_null($obj) && isset($obj->idusuario)) ? $obj->idusuario : null;
       $password = (!is_null($obj) && isset($obj->password)) ? $obj->password : null;
       
       $usuario_bd = UsuarioModel::where('CH_ID_USUARIO',$idusuario)
                                ->first();

       if( count($usuario_bd) > 0 && password_verify($password,$usuario_bd->VC_PASSWORD))
        {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'mensaje' => 'Bienvenid@'
            );
            
        }else{
            $data = array(
                'status' => 'failed',
                'code' => '400',
                'mensaje' => 'El usuario y/o contraseña son incorrectos'
            );
        }
        return response()->json($data,'200');
    }

    public function destroy ($idusuario)
    {
         $usuario = UsuarioModel::find($idusuario);
        if($usuario){
            $usuario->delete();
            $data = array(
                'status' => 'success',
                'code' => '200',
                'mensaje' => 'El usuario se ha eliminado correctamente'
            );
        }else
        {
            $data = array(
                'status' => 'failed',
                'code' => '400',
                'mensaje' => 'El usuario no existe'
            );
        }
        return response()->json($data,'200');
    }

    public function show($idusuario)
    {
        return UsuarioModel::where('CH_ID_USUARIO',$idusuario)->get();
    }

    public function update(Request $request,$idusuario)
    {
        $json = $request->input('json', null);
        $obj = json_decode($json);

        //$idusuario = (!is_null($json) && isset($parametros->idusuario)) ? $parametros->idusuario : null;
        $password = (!is_null($json) && isset($obj->password)) ? $obj->password : null;
        $nombre = (!is_null($json) && isset($obj->nombre)) ? $obj->nombre : null;
        $apellido_pat = (!is_null($json) && isset($obj->apellido_pat)) ? $obj->apellido_pat : null;
        $apellido_mat = (!is_null($json) && isset($obj->apellido_mat)) ? $obj->apellido_mat : null;
        $direccion = (!is_null($json) && isset($obj->direccion)) ? $obj->direccion : null;
        $dni = (!is_null($json) && isset($obj->dni)) ? $obj->dni : null;
        $foto = (!is_null($json) && isset($obj->foto)) ? $obj->foto : null;

        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
        
        $usuario = UsuarioModel::find($idusuario);
        //var_dump($usuario);
        if( isset ($usuario))
        {
             $usuario->VC_PASSWORD = $pass_hash;
             $usuario->VC_NOMBRE = $nombre;
             $usuario->VC_APELLIDO_PAT = $apellido_pat;
             $usuario->VC_APELLIDO_MAT = $apellido_mat;
             $usuario->VC_DIRECCION = $direccion;
             $usuario->VC_DNI = $dni;
             $usuario->VC_FOTO = $foto;

             $usuario->save();
             $data = array(
                 'status' => 'success',
                 'code' => '200',
                 'mensaje' => 'El usuario se ha actualizado correctamente'
             );
        }else
        {
            $data = array(
                'status' => 'failed',
                'code' => '400',
                'mensaje' => 'Ha fallado la actualizacion'
            );
        }

        return response()->json($data,'200');
    }
}
