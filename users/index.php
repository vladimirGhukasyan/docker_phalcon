<?php


use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Db\Adapter\Pdo\Sqlite ;

try {

    $config = include __DIR__ . '/app/config/config.php';
    $di = new FactoryDefault();
    $di->set('db', function () use ($config) {
        return new Sqlite(
            [
                "dbname" => $config->database->name
            ]
        );
    });

    $di->setShared(
        'session',
        function () {
            $session = new Session();
            $session->start();
            return $session;
        }
    );


    $loader = new Loader();
    $loader->registerDirs([$config->application->modelsDir, $config->application->controllersDir,$config->application->migrationsDir])->register();
    $app = new Micro($di);

    $request = $_REQUEST;
    if ($request) {

        if (!isset($request['jsonrpc']) || $request['jsonrpc'] !== '2.0') {

            $app->response->setStatusCode(501, 'Not Found');
            $app->response->setContent('Eror');
            $app->response->send();

        } else {

            if (isset($request['method'])) {



                $method = explode('_', $request['method']);
                $str = $method[0];
                $class = $str . 'Controller';
                $controller = new $class();


                try{
                    $app->map(
                        "/",
                        [
                            $controller,
                            $method[1] . "Action"
                        ]
                    );
                }catch (\Exception $e){}

            } else {

                $app->response->setStatusCode(500, 'Not Found');
                $app->response->setContent('Eror');
                $app->response->send();
            }
        }
    }

    $app->notFound(function () use ($app) {
        echo 404;
        echo "Your IP Address is ", $app->request->getClientAddress();

    });
    $app->handle();

} catch (\Exception $e) {

    echo $e->getMessage(), PHP_EOL;
    echo $e->getTraceAsString();
}

