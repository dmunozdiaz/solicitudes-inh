<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\PmGroups;
use App\Models\RoleUser;
use App\Models\Passusers;
use App\Traits\UtilsTrait;

use App\Models\PmgrupoUser;
use Illuminate\Support\Str;
use App\Models\DireccionUser;
use App\Models\TipoSolicitudUser;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;

use App\Services\QueryResultService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "users";
    protected $primaryKey = "id";

    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UtilsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*public function roles() {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }*/

    public function roles()
    {
        $roles = User::select(
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
            ->where("role_user.user_id", "=", Auth::user()->id)->get();

        return $roles;
    }

    public function supervi()
    {
        $roles = User::select(
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
            ->where("role_user.user_id", "=", Auth::user()->id)->get();

        return $roles;
    }

    public function tipossolictud()
    {
        $tipos = User::select(
            "tipsolicitudes.id",
            "tipsolicitudes.idsolicitud",
            "tipsolicitudes.nombresolicitud"
        )
            ->join("tiposolicitud_user", "users.id", "=", "tiposolicitud_user.user_id")
            ->join("tipsolicitudes", "tiposolicitud_user.tiposolicitud_id", "=", "tipsolicitudes.id")
            ->where("tiposolicitud_user.user_id", "=", Auth::user()->id)->get();

        return $tipos;
    }

    public function solictudesDireccion()
    {
        $tipos = User::select(
            "tipsolicitudes.id",
            "tipsolicitudes.idsolicitud",
            "tipsolicitudes.nombresolicitud"
        )
            ->join("tiposolicitud_user", "users.id", "=", "tiposolicitud_user.user_id")
            ->join("tipsolicitudes", "tiposolicitud_user.tiposolicitud_id", "=", "tipsolicitudes.id")
            ->where("tiposolicitud_user.user_id", "=", Auth::user()->id)->get();

        return $tipos;
    }


    public function areas()
    {
        $tipos = User::select(
            "tipsolicitudes.area"
        )
            ->join("tiposolicitud_user", "users.id", "=", "tiposolicitud_user.user_id")
            ->join("tipsolicitudes", "tiposolicitud_user.tiposolicitud_id", "=", "tipsolicitudes.id")
            ->groupBy("tipsolicitudes.area")
            ->where("tiposolicitud_user.user_id", "=", Auth::user()->id)->get();

        return $tipos;
    }


    public function grupospm()
    {
        $roles = User::select(
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
            ->where("role_user.user_id", "=", Auth::user()->id)->get();

        return $roles;
    }

    public function authorizeRoles($roles)
    {
        abort_unless($this->hasAnyRole($roles), 401);
        return true;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /*public function hasRole($role) {
        if ($this->roles()->where('role_user.name', $role)->first()) {
            return true;
        }
        return false;
    }*/

    public function hasRole($role)
    {
        $roles = Role::select(
            "roles.id",
            "roles.name",
            "roles.description",
            "roles.created_at",
            "roles.updated_at",
            "roles.deleted_at",
            "role_user.user_id as pivot_user_id",
            "role_user.role_id as pivot_role_id",
            "role_user.created_at as pivot_created_at",
            "role_user.updated_at as pivot_updated_at"
        )
            ->join("role_user", "roles.id", "=", "role_user.role_id")
            ->where("role_user.user_id", "=", Auth::user()->id)
            ->where("roles.name", "=", $role)->first();

        if ($roles) {
            return true;
        }
        return false;
    }

    /**
     * Se sobreescribe esta función para permitir cargar un template personalizado en la notificación
     * de recuperación de contraseñas
     * @param type $token
     */
    public function sendPasswordResetNotification($token)
    {
        $data = [
            $this->email
        ];

        Mail::send('email.reset-password', [
            'fullname' => $this->name . ' ' . $this->lastname,
            'expires' => (config('auth.passwords.users.expire')) / 60,
            'reset_url' => route('password.reset', ['token' => $token, 'email' => $this->email]),
                ], function ($message) use ($data) {
                    $message->subject('Modificar contraseña');
                    $message->to($data[0]);
                });
    }

    /**
     * Contraseñas del usuario
     */
    public function passes()
    {
        return $this->hasMany(Passusers::class, 'uid', 'id');
    }

    

    public function rol()
    {
        return $this->hasMany(RoleUser::class, 'user_id', 'id');
    }


    public function tiposolicitud()
    {
        return $this->hasMany(TipoSolicitudUser::class, 'user_id', 'id');
    }


    public function grupopm() 
    {
        return $this->hasMany(PmgrupoUser::class, 'user_id', 'id');
    }

    public function direccion() 
    {
        return $this->hasMany(DireccionUser::class, 'user_id', 'id');
    }

    public function getUsuarios($startPage, $limitPage, $search, $columnOrder)
    {
        $users = User::select(
            "users.id as id_usuario",
            "rut",
            DB::raw(" CONCAT(nombres ,' ', apellidos) as nombre"),
            "email",
            "users.enabled as habilitado",
            DB::raw(" CASE WHEN users.enabled = 1
            THEN 'Habilitado'
            ELSE 'Deshabilitado' END as estado")
        )
        ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'role_user.role_id')
        ->whereNull('users.deleted_at')
        ->groupBy('users.id', 'rut', 'nombre', 'email', 'habilitado', 'estado')
        ->offset($startPage)->limit($limitPage);

       
        if (is_null($search) == false) {
            $users->where(function ($queryAux) use ($search) {
                $queryAux->where("rut", "like", "%". $search . "%")
                    ->orWhere(DB::raw("  UPPER( CONCAT( nombres ,' ', apellidos) ) "), "like", "%".mb_strtoupper($search). "%");
            });
        }

        $usercount = User::select(DB::raw("COUNT(id) as total"))
            ->offset($startPage)->limit($limitPage)
            ->whereNull('users.deleted_at')
            ->first();

        $usertotal = User::select(DB::raw("COUNT(id) as total"))
            ->whereNull('users.deleted_at')
            ->first();
        $aUser =  $users->get()->toArray();
        $i = 0;
        foreach ($aUser as $user) {
            $aUser[$i]['perfil'] = $this->getRolesUsuario($user['id_usuario']);
            $aUser[$i]['grupopm'] = $this->getGruposPmUsuario($user['id_usuario']);
            $i++;
        }
            
        return [
            "users" => $aUser,
            "total" => $usertotal->total,
            "users_cout" => $usercount->total
        ];
    }

    public function getRolesUsuario($iIdUsuario)
    {
        $ruser = RoleUser::where('user_id', '=', $iIdUsuario)->get();
        $aRoles = [];
        foreach ($ruser as $user) {
            $role = Role::where('id', '=', $user->role_id)->first();
        
            $aRoles[] = $role->description;
        }

        return implode(' ', $aRoles);
    }
    public function getGruposPmUsuario($iIdUsuario)
    {
        $ruser = PmgrupoUser::where('user_id', '=', $iIdUsuario)->get();
        $aRoles = [];
        foreach ($ruser as $user) {
            $role = PmGroups::where('id', '=', $user->pmgrupo_id)->first();
        
            $aRoles[] = $role->description;
        }

        return implode(' ', $aRoles);
    }

    public function getCountUsuariosAdmin($iduser)
    {
        $users = User::select(
            "users.id as id_usuario",
            "roles.id as perfil"
        )
        ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'role_user.role_id')
        ->where([['users.enabled','=', true],['roles.id','=',1],['users.id','<>',$iduser]])
        ->get();

        return $users->count();
    }

    public function agregar($data, $password, $uidpm)
    {
        // $sequence = DB::getSequence();

        //dd($data);
        $user = new User();
        
        $aRut = explode('-', $data['add-rut']);
        $user->rut = str_replace('.', '', $aRut[0]);
        $user->dv = $aRut[1];
        $user->nombres = $data['add-nombre'];
        $user->apellidos = $data['add-appaterno'];
        $user->email = $data['add-email'];
        $user->uidpm = $uidpm;
        
        $now = Carbon::now();
        $user->pass_created_at =$now->subYear();
        $hashPassword = Hash::make($password);
        $user->password = $hashPassword;
        $user->user_created  = Auth::user()->id;
        $user->enabled = true;

        $payload = [
            'iss' => "auth-processmaker", // Issuer of the token
            'sub' => $data['add-email'], // Subject of the token
            'pass' => $password,
            'iat' => time(),
            'exp' => time() + 60 * 300,

        ];

        $token = $this->encrypt_decrypt('encrypt', json_encode($payload));
        $user->tokenpm = $token;

        $user->save();

        $user->passes()->create(['password' => $hashPassword]);

       
         
        $role = new RoleUser();
        foreach ($data['add-perfil'] as $rol) {
            $user->rol()->create(['role_id' => $rol]);
        }

        if (isset($data['add-grupopm'])==true) {
            foreach ($data['add-grupopm'] as $gpm) {
                $user->grupopm()->create(['pmgrupo_id' => $gpm]);
            }
        }

        if (isset($data['add-direccionfuncionario'])==true) {
            foreach ($data['add-direccionfuncionario'] as $gpm) {
                $user->grupopm()->create(['pmgrupo_id' => $gpm]);
            }
        }

        if (isset($data['add-direccion'])==true) {
            foreach ($data['add-direccion'] as $tipo) {
                $user->direccion()->create(['direccion_id' => $tipo]);
            }
        }

        if (isset($data['add-tiposolicitud'])==true) {
            foreach ($data['add-tiposolicitud'] as $tipo) {
                $user->tiposolicitud()->create(['tiposolicitud_id' => $tipo]);
            }
        }
        

        return $password;
    }

    public function editar($data)
    {
        //dd($data);
        $user = User::where('id', '=', $data['id_usuario'])->first();

        $user->nombres = $data['edit-nombre'];
        $user->apellidos = $data['edit-appaterno'];
        $user->email = $data['edit-email'];
        $user->user_updated  = Auth::user()->id;
        $user->save();

        
        $roles  = RoleUser::where('user_id', '=', $data['id_usuario'])->get();

        foreach ($roles as $rol) {
            $rol->delete();
        }

        $grupos = PmgrupoUser::where('user_id', '=', $data['id_usuario'])->get();

        foreach ($grupos as $grupo) {
            $grupo->delete();
        }

        $tipos = TipoSolicitudUser::where('user_id', '=', $data['id_usuario'])->get();

        foreach ($tipos as $tipo) {
            $tipo->delete();
        }

        foreach ($data['edit-perfil'] as $rol) {
            $user->rol()->create(['role_id' => $rol]);
        }

        if (isset($data['edit-grupopm'])==true) {
            foreach ($data['edit-grupopm'] as $gpm) {
                $user->grupopm()->create(['pmgrupo_id' => $gpm]);
            }
        }

        if (isset($data['edit-direccionfuncionario'])==true) {
            foreach ($data['edit-direccionfuncionario'] as $gpm) {
                $user->grupopm()->create(['pmgrupo_id' => $gpm]);
            }
        }

        if (isset($data['edit-direccion'])==true) {
            foreach ($data['edit-direccion'] as $tipo) {
                $user->direccion()->create(['direccion_id' => $tipo]);
            }
        }

        if (isset($data['edit-tiposolicitud'])==true) {
            foreach ($data['edit-tiposolicitud'] as $tipo) {
                $user->tiposolicitud()->create(['tiposolicitud_id' => $tipo]);
            }
        }
    }

    public function deshabilitar($data)
    {
        $user = User::where('id', '=', $data['id_usuario'])->first();
        $user->enabled = false;
        $user->user_updated  = Auth::user()->id;
        $user->save();
    }

    public function habilitar($data)
    {
        $user = User::where('id', '=', $data['id_usuario'])->first();
        $user->enabled = true;
        $user->user_updated  = Auth::user()->id;
        $user->save();
    }

    public function getUser($iduser)
    {
        $user = User::where('id', '=', $iduser)->first();

        $auser = $user->toArray();
        $auser['roles'] = $user->rol()->get();
        $auser['grupospm'] = [];
        $auser['tipsolicitudes'] = [];

        $tipEncargado = PmGroups::select('id')->where('id_tipogrupo','=',1)->get()->toArray();
        $aTipEncargado = PmgrupoUser::whereIn('pmgrupo_id',$tipEncargado)->where('user_id','=', $iduser)->get();
        if (empty($aTipEncargado)==false) {
            $auser['grupospm'] = $aTipEncargado;
        }


        $tipFuncionario = PmGroups::select('id')->where('id_tipogrupo','=',2)->get()->toArray();
        $aTipFuncionario = PmgrupoUser::whereIn('pmgrupo_id',$tipFuncionario)->where('user_id','=', $iduser)->get();
        if (empty($aTipFuncionario)==false) {
            $auser['gruposfuncionario'] = $aTipFuncionario;
        }

        if (empty($user->direccion()->get()->toArray())==false) {
            $auser['direccion'] = $user->direccion()->get();
        }

        if (empty($user->tiposolicitud()->get()->toArray())==false) {
            $auser['tipsolicitudes'] = $user->tiposolicitud()->get();
        }
       
        return QueryResultService::usuario($auser);
    }
}
