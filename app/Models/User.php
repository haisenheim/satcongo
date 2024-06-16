<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(){
        return $this->belongsTo('App\Models\Role','role_id');
    }

    public function getProfilAttribute(){
        $profil = null;
        if($this->role_id==2){
            $profil = Enseignant::find($this->enseignant_id);
        }
        return $profil;
    }



    //protected function getDefaultGuardName(): string { return 'api'; }

    public function getRolesAttribute(){
        return $this->getRoleNames();
    }

    public function getPermissionsAttribute(){
        return $this->getAllPermissions();
    }

    public function getDirectPermissionsAttribute(){
        return $this->getDirectPermissions();
    }

    public function getPermissionsViaRolesAttribute(){
        return $this->getPermissionsViaRoles();
    }

      /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
