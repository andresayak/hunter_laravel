<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;
use App\Models\Domain;
use App\Models\DomainContact;

class DomainGetInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $domain;
    /**
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api_key = env('HUNTER_API_TOKEN');
        $url = 'https://api.hunter.io/v2/domain-search?domain='.$this->domain->domain_name.'&api_key='.$api_key;
        $client = new Client();
        $response = (string)$client->request('GET', $url)->getBody();
        $json = json_decode($response, true);
        
        if($json && isset($json['data'])){
            foreach ($json['data']['emails'] AS $item){
                $domain = DomainContact::updateOrCreate([
                    'domain_id' =>  $this->domain->id,
                    'email' => $item['value']
                ], [
                    'first_name'    =>  $item['first_name'],
                    'last_name'    =>  $item['last_name'],
                    'confidence'    =>  $item['confidence']
                ]);
                $domain->save();
            }
        }
    }
}