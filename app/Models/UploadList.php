<?php

namespace App\Models;

class UploadList extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'upload_list';
    /**
     * @var array
     */
    protected $fillable = [
        'upload_time', 'name'
    ];
    
    protected $with = ['domains'];
    
    public $timestamps = false;
    
    public function domains()
    {
        return $this->belongsToMany(Domain::class, 'upload_domain', 'upload_list_id', 'domain_id');
    }
}
