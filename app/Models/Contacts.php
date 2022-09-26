<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Contacts extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $table = "contacts";

    protected $fillable = [
        'author', 'date_accessioned', 'date_available','identifier_uri', 'title', 'contact_address','contact_country','contact_department','contact_institution','contact_email','contact_firstname','contact_lastname', 'contact_phoneNumber','contact_fax', 'contact_type','contact_position','contact_prefix', 'identifier_treaty','updated',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;
}
