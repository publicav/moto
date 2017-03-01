<?php
try {
    include_once 'vendor/autoload.php';
    include_once 'core/config.php';

    mb_internal_encoding( 'UTF-8' );
    $pdo = \db::getLink()->getDb();
    Base\Auth::sessionStart();

    $route = \Navigation\Route::init();
    $conroler = $route->getController();
    $action = $route->getAction();
    $contoller = new $conroler();
    $contoller->$action();

} catch ( Exception\BadRequestException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 4, $e->getMessage() );
} catch ( Exception\InputException $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
} catch ( Exception $e ) {
    header( "HTTP/1.1 400 Bad Request", true, 400 );
    echo Exception\JsonError::exitError( false, 1, $e->getMessage() );
    echo $e->getMessage();
}


