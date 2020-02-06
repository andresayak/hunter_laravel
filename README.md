```
[program:domain_get_info-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/andres/www/test1/artisan queue:work redis --queue=domain_get_info --tries=3
autostart=true
autorestart=true
user=andres
numprocs=8
redirect_stderr=true
```
