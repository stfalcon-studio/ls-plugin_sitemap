<?php

// Добавляем экшены плагина в роутер
$aRouters = Config::Get('router');
$aRouters['page']['sitemap.xml'] = 'PluginSitemap_ActionSitemap';
$aRouters['page']['sitemaps'] = 'PluginSitemap_ActionSitemap';
Config::Set('router', $aRouters);

$config = array();

/**
 * Количество обьектов на одной странице карты
 * @var integer
 */
$config['objects_per_page'] = 15000;

return $config;