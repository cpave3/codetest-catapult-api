<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Validator;

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
     * @return object|array
     */
    public function transform() {
      return [
        'email' => $this->email,
        'firstname' => $this->firstname,
        'lastname' => $this->lastname,
      ];
    }

    /**
     * Used to validate incoming requests for CRUD operations
     */
    public static function validatePayload(array $payload, string $operation) {
      $validator = new Validator();
      switch ($operation) {
        case 'create':
          $validationSchema = [
            'firstname' => [
              'required'  => true
            ],
            'lastname' => [
              'required'  => true
            ],
            'email' => [
              'required'  => true,
              'email'     => true,
              'unique'    => true,
            ],
            'password' => [
              'required'  => true,
              'min'       => 8
            ],
          ];
          break;
        default:
          $validationSchema = [];
          break;
      }
      return $validator
        ->setSchema($validationSchema)
        ->setPayload($payload)
        ->evaluate()
        ->getResult();
    }
}