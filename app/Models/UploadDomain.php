<?php

namespace App\Models;

class UploadDomain extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'upload_domain';
    /**
     * @var array
     */
    protected $fillable = [
        'domain_id', 'upload_list_id'
    ];
    public $timestamps = false;
    
    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
    
    public function uploadList()
    {
        return $this->belongsTo(UploadList::class, 'upload_list_id');
    }
}
