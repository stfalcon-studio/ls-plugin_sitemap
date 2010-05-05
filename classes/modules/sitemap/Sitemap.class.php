<?php

require_once('mapper/Sitemap.mapper.class.php');

/**
 * Модуль для плагина генерации Sitemap
 */
class PluginSitemap_Sitemap extends Module {

        /**
         * Маппер
         * @var PluginSitemap_Mapper_Sitemap
         */
	protected $oMapper;
	
	/**
	 * Инициализация модуля
	 *
         * @return void
	 */
	public function Init() {				
		$this->oMapper=new PluginSitemap_Mapper_Sitemap($this->Database_GetConnect());
	}
	
	/**
	 * При завершенни модуля загружаем в шалон объект текущего юзера
	 *
         * @return void
	 */
	public function Shutdown() {
	}

        /**
         * Максимальная айдишка для коллективных блогов
         * 
         * @return integer
         */
	public function getMaxOfCollectiveBlogs(){		
		return $this->oMapper->getMaxOfCollectiveBlogs();
	}

        /**
         * Список коллективных блогов (с кешированием)
         *
         * @param integer $from
         * @return array
         */
	public function getCollectiveBlogList($from) {
		$cacheKey = "sitemap_blogs_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
		
		if (false === ($data = $this->Cache_Get($cacheKey))) {			
			if ($data = $this->oMapper->getCollectiveBlogList($from)) {
				$this->Cache_Set($data, $cacheKey, array('blog_new'), 60*60*8);
			}
		}
		return $data;
	}

        /**
         * Максимайная айдишка для топиков
         *
         * @return integer
         */
	public function getMaxOfTopics(){
		return $this->oMapper->getMaxOfTopics();
	}

        /**
         * Список топиков (с кешированием)
         *
         * @param integer $from
         * @return array
         */
	public function getAllTopicList($from){
		$cacheKey = "sitemap_topics_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
		
		if (false === ($data = $this->Cache_Get($cacheKey))) {			
			if ($data = $this->oMapper->getAllTopicList($from)) {
				$this->Cache_Set($data, $cacheKey, array('topic_new'), 60*30);
			}
		}
		return $data;
	}

        /**
         * Максимальная айдишка для юзеров
         *
         * @return integer
         */
	public function getMaxOfUsers(){
		return $this->oMapper->getMaxOfUsers();
	}

        /**
         * Список пользователей (с кешированием)
         *
         * @param integer $from
         * @return array
         */
	public function getUserList($from){
		$cacheKey = "sitemap_users_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
		
		if (false === ($data = $this->Cache_Get($cacheKey))) {			
			if ($data = $this->oMapper->getUserList($from)) {
				$this->Cache_Set($data, $cacheKey, array('user_new'), 60*60*1);
			}
		}
		
		return $data;
	}
}
