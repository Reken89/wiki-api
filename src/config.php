<?php

# Запускаем сессию
session_start();

# Определяем константы
define("ROOT", $_SERVER['DOCUMENT_ROOT']. "/wiki-api");
define("CONTROLLER_PATH", ROOT. "/controllers/");
define("MODEL_PATH", ROOT. "/models/");
define("VIEW_PATH", ROOT. "/views/");

# Подключаем файл с настройками БД, роутинг и конфигурацию MVC
require_once 'db.php';
require_once 'route.php';
require_once VIEW_PATH. 'View.php';
require_once MODEL_PATH. 'Model.php';
require_once CONTROLLER_PATH. 'Controller.php';

# Запускаем роутинг
Routing::buildRoute();

