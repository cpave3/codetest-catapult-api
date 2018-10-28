<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'meta'];

    /**
     * Used to validate incoming requests for CRUD operations
     */
    public static function validatePayload(array $payload, string $operation) {
      switch ($operation) {
        case 'create':
          $validationSchema = [
            'firstname' => [
              'required' => true
            ],
            'lastname' => [
              'required' => true
            ],
            'email' => [
              'required' => true
            ],
            'password' => [
              'required' => true,
              'min' => 8
            ],
          ];
          break;
        default:
          break;
      }
    }
}