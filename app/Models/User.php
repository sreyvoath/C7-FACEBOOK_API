<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /**
     * @OA\Schema(
     *     schema="User",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="John Doe"),
     *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
     *     @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00.000000Z"),
     *     @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00.000000Z")
     * )
     */

    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    public static function list()
    {
        return self::all();
    }
    public static function store($request)
    {
        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(20),
        ]);
        //Set permission and role for user account
        $user->syncRoles(["User"]);
        $user->syncPermissions(["view_users", "view_roles", "view_permissions"]);
        // Create the token for API access
        $token = $user->createToken('auth_token')->plainTextToken;
        return $token;
    }
    public static function edit($request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $user;
    }
}
