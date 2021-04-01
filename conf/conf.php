<?php
return [
    'name' => 'FrameNet Brasil CARMA',
    'options' => [
        'app' => 'carma',
        'debug' => true,
        'charset' => 'UTF-8',
        'timezone' => "America/Sao_Paulo",
        'separatorDate' => '/',
        'formatDate' => 'd/m/Y',
        'formatTimestamp' => 'd/m/Y H:i:s',
        'csv' => ';',
        'mode' => 'DEV',
        'dispatch' => 'index.php',
        'tmpPath' => sys_get_temp_dir(),
        'locale' => array("pt_BR.utf8", "ptb"), // linux: check installed locales - "locale -a"
        'fetchStyle' => \FETCH_ASSOC,
        'language' => 'en',
        'defaultPassword' => 'default',
        'pageTitle' => 'FNBr CARMA [github]',
        'mainTitle' => 'FrameNet Brasil CARMA 2.0 [github]',
        'idLanguage' => 2
    ],
    'login' => [
        'handler' => 'login',
        'AUTH0_CLIENT_ID' => '',
        'AUTH0_DOMAIN' => 'framenetbr.auth0.com',
        'AUTH0_ISSUER' => 'https://framenetbr.auth0.com/',
        'AUTH0_AUDIENCE' => 'https://lutma.frame.net.br',
        'AUTH0_CLIENT_SECRET' => '',
        'AUTH0_CALLBACK_URL' => 'http://localhost:8700/main/main/auth0Callback',
        'logout' => 'https://framenetbr.auth0.com/v2/logout?returnTo=',
        'class' => "Orkester\\Security\\MAuth",
        'check' => false
    ],
    'mailer' => [
        'smtpServer' => 'smtp.gmail.com',
        'smtpFrom' => 'x@gmail.com',
        'smtpFromName' => 'Project Name',
        'smtpTo' => '',
        'smtpAuth' => true,
        'smtpPass' => '',
        'smtpPort' => 587,
    ],
    'session' => [
        'handler' => "file",
        'timeout' => "30",
        'exception' => false,
        'check' => true,
        'dbsession' => false,
    ],
    'logs' => [
        'channel' => 'orkester',
        'path' => __DIR__ . '/../var/log',
        'level' => 1,
        'handler' => "socket",
        'peer' => '200.131.19.163',//isset($_SERVER['REMOTE_ADDR']) ? 'host.docker.internal' : 'localhost',
        //'strict' => '127.0.0.1',
        'port' => 9999,
        'console' => 1,
        'errorCodes' => [
            E_ERROR,
            E_WARNING,
            E_PARSE,
            E_RECOVERABLE_ERROR,
            E_USER_ERROR,
            E_COMPILE_ERROR,
            E_CORE_ERROR
        ],
    ],
    'cache' => [
        'type' => "apcu", // php, java, apc, apcu, memcache
        'path' => __DIR__ . '/../var/cache',
        'memcache' => [
            'host' => "127.0.0.1",
            'port' => "11211",
            'default.ttl' => 0
        ],
        'apc' => [
            'default.ttl' => 0
        ]
    ],

];
