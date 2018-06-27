# Crea un proyecto de Symfony 4
composer create-project symfony/skeleton webservice

## Instalamos los componentes a utilizar
```
cd webservice/
composer require symfony/web-server-bundle --dev
composer require annotations
composer require symfony/maker-bundle --dev
composer require symfony/var-dumper
composer require --dev symfony/profiler-pack
composer require symfony/twig-bundle
```

Para añadir el componente de base de datos
```
composer require doctrine/doctrine-bundle
composer require doctrine-orm
```

## Para crear un controlador
php bin/console make:controller
