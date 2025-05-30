<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Ejemplo para especificarle explicitamente a que tabla se tiene que conectar
    // si no queremos seguir la convencion en ingles
    protected $table = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Aqui en el modelo especificamos el tipo de relacion que existe entre esta tabla con la que tiene el FK "Profile"
    // vamos a decir que hay una relacion de uno a uno, el nombre del metodo es con el cual queremos recuperar la relacion
    // en este caso se llama para obtener el perfil de un determina usuario
    public function profile()
    {
        // Solo podraa recuperar un perfil, dentro del metodo le especificamos el modelo con el cual queremos relacionarlo
        return $this->hasOne(Profile::class);

        // En el caso de no seguir la convencion del nombre de los campos, como segundo parametro a este metodo especificandole el nombre
        // que le dimos que seria: FKName, PKdeEstaTabla
        //      return $this->hasOne(Profile::class, 'user_id', 'id');
    }
}
