<?php return [
    ["path" => 'collection/phpappbuilder/router/collection' , "name" => 'Test route', "value" => App\my\example\Route::class ],
    ["path" => 'key/phpappbuilder/router/err404' , "name" => 'Reponse for 404 status sergey edition', "value" => new App\phpappbuilder\controller\Response('Not Found sergey - edition', 404) ],
    ["path" => 'collection/root/core/cli' , "name" => 'Build price for mprom.ua', "value" => new App\my\example\Cli\Build() ]
];
