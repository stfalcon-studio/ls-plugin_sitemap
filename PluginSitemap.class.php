<?php
/**
 * Плагин для генерации sitemap
 *
 * @author Stepan Tanasiychuk <http://stfalcon.com>
 */
class PluginSitemap extends Plugin {

        /**
         * Активация плагина
         *
         * @return boolean
         */
	public function Activate() {
		return true;
	}

        /**
         * Инициализация плагина
         *
         * @return void
         */
	public function Init() {
	}

        /**
         * Деактивация плагина
         * 
         * @return boolean
         */
	public function Deactivate() {
		return true;
	}
        
}