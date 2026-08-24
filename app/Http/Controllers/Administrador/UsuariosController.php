<?php

namespace App\Http\Controllers\Administrador;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\PmGroups;
use App\Traits\UtilsTrait;
use App\Models\PmgrupoUser;
use Illuminate\Support\Str;
use App\Mail\ChangePassword;
use Illuminate\Http\Request;


use App\Models\TipSolicitudes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Services\Validator\UsuarioValidatorServices;


class UsuariosController extends Controller
{
    use UtilsTrait;
    
   

    public function view()
    {
        $tipsol = collect(TipSolicitudes::all()->toArray());
        
        return view('administracion.usuarios.view')->with([
            'tiposol' => $tipsol->groupBy('area')->toArray()
        ]);
    }

    public function listado(Request $request, User $user)
    {
        $startPage = $request->input('start');
        $limitPage = $request->input('length');
        $search = $request->input('filtro');
        $columnOrder = $request->input('order');

        $dataUser = $user->getUsuarios($startPage, $limitPage, $search, $columnOrder);
        

        return response()->json([
            'data' => $dataUser['users'],
            'draw' => $request->input('draw'),
            'recordsTotal' => $dataUser['total'],
            'recordsFiltered' => $dataUser['users_cout']
        ]);
    }

    public function usuariobyid(Request $request, User $user)
    {
        $error = UsuarioValidatorServices::validarUsuario($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $usuario = $user->getUser($request->id_usuario);

        return response()->json(['success' => true, 'usuario'=>$usuario]);
    }


    public function encargados(Request $request)
    {
        if(isset($request->direccion)==true){
            $encargados = PmGroups::select('id','name')->whereIn('id_direccion',$request->direccion)->where('id_tipogrupo','=',$request->tipousuario)->get();
            return response()->json(['success' => true, 'encargados'=>$encargados]);
        }else{
            return response()->json(['success' => true, 'encargados'=>[]]);
        }
       
       
    }


    public function tipsolicitudes(Request $request)
    {
        if(isset($request->direccion)==true){
            $tipsolicitudes = TipSolicitudes::select('id','nombresolicitud')->whereIn('id_direccion',$request->direccion)->get();
            return response()->json(['success' => true, 'tipsolicitudes'=>$tipsolicitudes]);
        }else{
            return response()->json(['success' => true, 'tipsolicitudes'=>[]]);
        }
    }

    public function agregar(Request $request, User $user)
    {
        $error = UsuarioValidatorServices::validarAgregarUsuario($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }
        
        DB::beginTransaction();
        try {

            

            $aUser = $request->all();
            
            $password =Str::random(8);
          

            $pmrole = 'PROCESSMAKER_OPERATOR';
            if(in_array('1',$aUser['add-perfil'])){
                $pmrole = 'PROCESSMAKER_ADMIN';
            }

            $pmUserParams = [
                'usr_username' => $aUser['add-email'],
                'usr_firstname' => $aUser['add-nombre'],
                'usr_lastname' =>  $aUser['add-appaterno'],
                'usr_email' =>  $aUser['add-email'],
                'usr_due_date' => '2500-12-31',
                'usr_status' => 'ACTIVE',
                'usr_role' => $pmrole,
                'usr_new_pass' =>  $password,
                'usr_cnf_pass' =>   $password,
                'usr_phone' => ''
            ];
    
           
            $wspm = $this->getProcessMakerWs();
            $oUserPM = $wspm->newUser($pmUserParams);

            if(is_null($oUserPM)==true){
                return response()->json([
                    'success' => false]);
            }

            if(in_array(2, $aUser['add-perfil'])== true){
                $wspm->setGroupUser(env('UID_GRUPO_USUARIO_SUPERVISOR'), $oUserPM->USR_UID);
            }

            if (isset($aUser['add-grupopm'])==true) {
                $oGruposPm = PmGroups::whereIn('id', $aUser['add-grupopm'])->get();
                foreach ($oGruposPm as $gpm) {
                    $wspm->setGroupUser($gpm->idpmgrupo, $oUserPM->USR_UID);
                }
            }


            if (isset($aUser['add-direccionfuncionario'])==true) {
                $oGruposPm = PmGroups::whereIn('id', $aUser['add-direccionfuncionario'])->get();
                foreach ($oGruposPm as $gpm) {
                    $wspm->setGroupUser($gpm->idpmgrupo, $oUserPM->USR_UID);
                }
            }

            $password = $user->agregar($aUser, $password, $oUserPM->USR_UID);

            
            DB::commit();
           
           
            $this->sendNotificacion($request->{'add-nombre'}.' '.$aUser['add-appaterno'],  $aUser['add-email'], 'Cuenta de usuario habilitada – Sistema de Solicitudes Ciudadanas');
            
            return response()->json([
                'success' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function editar(Request $request, User $user)
    {
        $error = UsuarioValidatorServices::validarEditarUsuario($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        DB::beginTransaction();
        try {

            $aUser = $request->all();
            $user = User::where('id', '=', $aUser['id_usuario'])->first();
            $pmrole = 'PROCESSMAKER_OPERATOR';
            if(in_array('1',$aUser['edit-perfil'])){
                $pmrole = 'PROCESSMAKER_ADMIN';
            }

            $pmUserParams = [
                'usr_username' => $aUser['edit-email'],
                'usr_firstname' => $aUser['edit-nombre'],
                'usr_lastname' =>  $aUser['edit-appaterno'],
                'usr_email' =>  $aUser['edit-email'],
                'usr_due_date' => '2500-12-31',
                'usr_status' => 'ACTIVE',
                'usr_role' => $pmrole,
                'usr_phone' => ''
            ];
    
           
            $wspm = $this->getProcessMakerWs();
            $oUserPM = $wspm->updateUser($user->uidpm, $pmUserParams);

            $gruposUser = PmgrupoUser::where('user_id','=',$aUser['id_usuario'])->get();

            $aGrupoUser = [];
            foreach ($gruposUser as $guser) {
                $gruop = PmGroups::where([['id','=',$guser->pmgrupo_id],['id_tipogrupo','=',1]])->first();
                if(isset($gruop->idpmgrupo)==true){
                    $aGrupoUser[] = $gruop->idpmgrupo;
                }
                
            }

            $aGrupoFunc = [];
            foreach ($gruposUser as $guser) {
                $gruop = PmGroups::where([['id','=',$guser->pmgrupo_id],['id_tipogrupo','=',2]])->first();
                if(isset($gruop->idpmgrupo)==true){
                    $aGrupoFunc[] = $gruop->idpmgrupo;
                }
                
            }

            $superviser = User::select(
                "roles.id",
                "roles.name",
                "roles.description",
                "role_user.user_id as pivot_user_id",
                "role_user.role_id as pivot_role_id",
                "role_user.created_at as pivot_created_at",
                "role_user.updated_at as pivot_updated_at"
            )
                ->join("role_user", "users.id", "=", "role_user.user_id")
                ->join("roles", "role_user.role_id", "=", "roles.id")
                ->where([["role_user.user_id", "=", $aUser['id_usuario']],['roles.id','=',2]])->first();
          

            if(empty($superviser)==false){
                if(in_array(2, $aUser['edit-perfil'])== false){
                    $wspm->unassignGroupUser(env('UID_GRUPO_USUARIO_SUPERVISOR'), $user->uidpm);
                }
            }else{
                if(in_array(2, $aUser['edit-perfil'])== true){
                    $wspm->setGroupUser(env('UID_GRUPO_USUARIO_SUPERVISOR'), $user->uidpm);
                }
            }    
            
            
            $aGrupoDelete = [];

            if (isset($aUser['edit-grupopm'])) {
                $oGruposPm = PmGroups::whereIn('id',$aUser['edit-grupopm'])->get();
                foreach ( $oGruposPm as $gpm) {
                    
                    if(in_array($gpm->idpmgrupo, $aGrupoUser) == false ){
                        $wspm->setGroupUser($gpm->idpmgrupo, $user->uidpm);
                    }else{
                        $aGrupoDelete[] = $gpm->idpmgrupo;      
                    }
                }
                
                
                foreach ($aGrupoUser as $idpmgrupo) {
                    if(in_array($idpmgrupo, $aGrupoDelete)==false){
                        //$oGrupoPm = PmGroups::where('id','=',$idpmgrupo)->first();
                        $wspm->unassignGroupUser($idpmgrupo, $user->uidpm);
                    }
                } 
            }else{
                foreach ($aGrupoUser as $idpmgrupo) {
                   
                        
                        $wspm->unassignGroupUser($idpmgrupo, $user->uidpm);
                    
                }
            }


            $aGrupoDelete = [];

            if (isset($aUser['edit-direccionfuncionario'])) {
                $oGruposPm = PmGroups::whereIn('id',$aUser['edit-direccionfuncionario'])->get();
                foreach ( $oGruposPm as $gpm) {
                    
                    if(in_array($gpm->idpmgrupo, $aGrupoFunc) == false ){
                        $wspm->setGroupUser($gpm->idpmgrupo, $user->uidpm);
                    }else{
                        $aGrupoDelete[] = $gpm->idpmgrupo;      
                    }
                }
                
                
                foreach ($aGrupoFunc as $idpmgrupo) {
                    if(in_array($idpmgrupo, $aGrupoDelete)==false){
                        //$oGrupoPm = PmGroups::where('id','=',$idpmgrupo)->first();
                        $wspm->unassignGroupUser($idpmgrupo, $user->uidpm);
                    }
                } 
            }else{
                foreach ($aGrupoFunc as $idpmgrupo) {
                   
                        
                        $wspm->unassignGroupUser($idpmgrupo, $user->uidpm);
                    
                }
            }
           

            

            $password = $user->editar($aUser);
            
            DB::commit();
           
            return response()->json([
                'success' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function deshabilitar(Request $request, User $user)
    {
        $error = UsuarioValidatorServices::validarUsuario($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }


        $count = $user->getCountUsuariosAdmin($request->id_usuario);

        if ($count==0) {
            return response()->json([
                'success' => false,'msg'=>'No es posible deshabilitar a todos los administradores, ya que debe haber al menos uno.']);
        }

        if (Auth::user()->id == $request->id_usuario) {
            return response()->json([
                'success' => false,'msg'=>'No es posible deshabilitase a sí mismo. Otro administrador debe deshabilitarlo.']);
        }

        DB::beginTransaction();
        try {
            $user->deshabilitar($request->all());
            
            DB::commit();
             
            return response()->json([
                'success' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function habilitar(Request $request, User $user)
    {
        $error = UsuarioValidatorServices::validarUsuario($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }


        

        DB::beginTransaction();
        try {
            $user->habilitar($request->all());
            
            DB::commit();
             
            return response()->json([
                'success' => true]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e]);
        }
    }

    public function validadadmin(Request $request)
    {
        $error = UsuarioValidatorServices::validarPerfil($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        $roles = Role::whereIn('id',$request->perfil)->get()->toArray();
       
        foreach ($roles as $rol) {
            if (in_array($rol['name'], ['admin']) ==  true) {
                return response()->json([
                    'success' => true]);
            }
        }

        return response()->json([
            'success' => false]);
    }

    public function validadadminedit(Request $request, User $user)
    {
        $error = UsuarioValidatorServices::validarPerfil($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }

        
        
        $error = UsuarioValidatorServices::validarUsuario($request->all());
        if ($error) {
            return response()->json(['error' => $error, 'codigo' => 400]);
        }
        $usuario = $user->getUser($request->id_usuario);

        $rol = Role::where('id', '=', $request->perfil)->first();
        $roluser = Role::where('id', '=', $usuario['perfil'])->first();

        if($rol->name == $roluser->name){
            return response()->json([
                'success' => false]);
        }

        if (in_array($rol->name, ['admin']) ==  true) {
            return response()->json([
                'success' => true]);
        }

        return response()->json([
            'success' => false]);
    }

    /**
     * Se envía la notificacion al usuario
     * @param type $titulo
     * @return type
     */
    private function sendNotificacion($nombre, $email, $titulo)
    {
        $this->sendMail($nombre, $email, $titulo);
    }

    private function sendMail($nombre,$email, $titulo)
    {
        $details = [
            'title' => $titulo,
            'nombre' => $nombre
        ];

        \Mail::to($email)->send(new ChangePassword($details));
    }
}
