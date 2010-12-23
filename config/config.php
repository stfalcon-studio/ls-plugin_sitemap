<?php

// Добавляем rewrite rules для sitemap'ов в роутер
$aRouterUri = Config::Get('router.uri');
$aRouterUri['/^sitemap\.xml/i'] = "sitemap";
$aRouterUri['/^sitemap_(\w+)_(\d+)\.xml/i'] = "sitemap/sitemap/\\1/\\2";
Config::Set('router.uri', $aRouterUri);

// Добавляем экшен плагина в роутер
Config::Set('router.page.sitemap', 'PluginSitemap_ActionSitemap');


$config = array();

$config['objects_per_page'] = 50000; // максимальное количество ссылок на одной странице карты

/**
 * Настройки времени жизни кеша данных, приоритета страниц, вероятной частоты изменений страницы
 * 
 * cache_lifetime - время жизни кеша для наборов извлекаемых из БД. значение задается в секундах
 * sitemap_priority - приоритет страницы. значение от 0 до 1
 * sitemap_changefreq - вероятная частота изменений страницы. значения always|hourly|daily|weekly|monthly|yearly|never
 */

// Главная страница и комментарии
$config['general'] = array (
    // Главная страница
    'mainpage' => array (
        'sitemap_priority' => '1',
        'sitemap_changefreq' => 'hourly'
    ),
    // Страница комментариев
    'comments' => array (
        'sitemap_priority' => '0.7',
        'sitemap_changefreq' => 'hourly'
    ),
);
// Блоги
$config['blogs'] = array (
    'cache_lifetime' => 60 * 60 * 8, // 8 часов
    'sitemap_priority' => '0.8',
    'sitemap_changefreq' => 'weekly'
);
// Записи
$config['topics'] = array (
    'cache_lifetime' => 60 * 60 * 0.5, // 30 минут
    'sitemap_priority' => '0.9',
    'sitemap_changefreq' => 'weekly'
);
// Пользователи
$config['users'] = array (
    'cache_lifetime' => 60 * 60 * 1, // 1 час
    // Профиль пользователя
    'profile' => array (
        'sitemap_priority' => '0.5',
        'sitemap_changefreq' => 'weekly'
    ),
    // Комментарии пользователя
    'comments' => array (
        'sitemap_priority' => '0.7',
        'sitemap_changefreq' => 'weekly'
    ),
    // Топики пользователя
    'my' => array (
        'sitemap_priority' => '0.8',
        'sitemap_changefreq' => 'weekly'
    ),
);

return $config;