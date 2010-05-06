<?php

/**
 * Набор действий для плагина sitemap
 */
class PluginSitemap_ActionSitemap extends ActionPlugin {

	/**
         * Инициализация
         * 
         * @return void
         */
        public function Init() {
		$this->SetDefaultEvent('index');
		Router::SetIsShowStats(false);
	}

        /**
         * Регистрация событий
         *
         * @return void
         */
	protected function RegisterEvent() {
		$this->AddEvent('index','eventIndex');
		$this->AddEvent('general','eventGeneral');
		$this->AddEvent('blogs','eventBlogs');
		$this->AddEvent('topics','eventTopics');
		$this->AddEvent('users','eventUsers');
	}
	
        /**
         * Генерирует карту Sitemap-ов, разбивая каждый тип сущностей на наборы по 50000 URL-ов
         *
         * @return void
         */
	protected function eventIndex(){
                $objects_per_page = Config::Get('plugin.sitemap.objects_per_page');
		$counters = array(
			'general' => 1,
			'blogs' => ceil($this->PluginSitemap_Sitemap_getMaxOfCollectiveBlogs() / $objects_per_page),
			'topics' => ceil($this->PluginSitemap_Sitemap_getMaxOfTopics() / $objects_per_page),
			'users' => ceil($this->PluginSitemap_Sitemap_getMaxOfUsers() / $objects_per_page),
		);
		
		$aObjects = array();
		foreach($counters AS $oType => $oCount){
			for($i = 1; $i <= $oCount; ++$i){
				$aObjects[] = array('type' => $oType, 'index' => $i);
			}
		}
		
		$this->Viewer_Assign('aObjects', $aObjects);
	}
	
	/**
	* Генерирует Sitemap общих, не изменяемых URL страниц сайта
	*
	**/
	protected function eventGeneral(){

	}
	
        /**
         * Генерирует Sitemap коллективных блогов. В одном наборе максимум 50000 URL-ов
         */
	protected function eventBlogs(){
		$aObjects = $this->PluginSitemap_Sitemap_getCollectiveBlogList($this->getChunkFirstIdx());
		
		$aContent = array();
		foreach($aObjects AS $tRow){
                        $aContent[] = $tRow;
		}

		$this->Viewer_Assign('aBlogs', $aContent);
	}
	
	/**
	* Генерирует Sitemap топиков. В одном наборе максимум 50000 URL-ов
	*
	**/
	protected function eventTopics(){
		$aObjects = $this->PluginSitemap_Sitemap_getAllTopicList($this->getChunkFirstIdx());

		$aContent = array();
		foreach($aObjects AS $tRow){
				$tRow['blogURL'] = ($tRow['blog_type'] != 'personal') ? $tRow['blog_url'].'/' : '';
				
				$aContent[] = $tRow;
		}
		$this->Viewer_Assign('aTopics', $aContent);
	}
	
	/**
	* Генерирует Sitemap пользовательских профилей, топиков, комментариев. В одном наборе максимум 50000 URL-ов
	*
	**/
	protected function eventUsers(){
		$aObjects = $this->PluginSitemap_Sitemap_getUserList($this->getChunkFirstIdx());
		
		$aContent = array();
		foreach($aObjects AS $tRow){
				$aContent[] = $tRow;
		}
		$this->Viewer_Assign('aUsers', $aContent);
	}
	
	private function getChunkIdx(){
		$idx = intval(preg_replace('#^sitemap_(\d+)\.xml$#', '\1', $this->getParam(0)));
		
		return ($idx > 1) ? $idx : 1;
	}
	
	private function getChunkFirstIdx(){
		return (($this->getChunkIdx() - 1) * Config::Get('plugin.sitemap.objects_per_page'));
	}
}