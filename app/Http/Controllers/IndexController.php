<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRequest;
use App\Models\Domain;
use App\Models\UploadList;

class IndexController extends Controller
{
    public function add(AddRequest $request)
    {
        $name = $request->input('name');
        $domains = explode("\n", $request->input('domains'));
        
        $count = 0;
        $domains_ids = [];
        foreach ($domains AS $domain) {
            $domain = Domain::firstOrCreate([
                'domain_name' => $domain
            ]);
            $domain->save();
            $count++;
            $domains_ids[] = $domain->id;
            dispatch(new \App\Jobs\DomainGetInfoJob($domain))
                ->onConnection('redis')
                ->onQueue('domain_get_info');
        }

        $model = new UploadList([
            'name'  =>  $name
        ]);
        $model->save();
        $model->domains()->sync($domains_ids);
        return $model;
    }
}
    
