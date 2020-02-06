<?php

namespace App\Models;

class Domain extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'domain';
    /**
     * @var array
     */
    protected $fillable = [
        'domain_name'
    ];
    
    protected $with = ['contacts'];
    
    public $timestamps = false;
    
    public function contacts()
    {
        return $this->hasMany(DomainContact::class);
    }
}
