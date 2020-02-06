<?php

namespace App\Models;

class DomainContact extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'domain_contact';
    /**
     * @var array
     */
    protected $fillable = [
        'domain_id', 'first_name', 'last_name', 'email', 'confidence'
    ];
    public $timestamps = false;
    
}
