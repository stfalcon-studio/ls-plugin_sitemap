<?php

/**
 * Набор действий для плагина генерации sitemap
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
        $this->AddEvent('index', 'eventIndex');
        $this->AddEvent('general', 'eventGeneral');
        $this->AddEvent('blogs', 'eventBlogs');
        $this->AddEvent('topics', 'eventTopics');
        $this->AddEvent('users', 'eventUsers');
        $this->AddEvent('pages', 'eventPages');
//        $this->AddEvent('gallery_categories', 'eventGalleryCategories');
//        $this->AddEvent('gallery_tags', 'eventGalleryTags');
        $this->AddEvent('gallery_albums', 'eventGalleryAlbums');
//        $this->AddEvent('gallery_albums_photos', 'eventGalleryAlbumsPhotos');
//        $this->AddEvent('gallery_categories_photos', 'eventGalleryCategoriesPhotos');
    }

    /**
     * Устанавливат соответсвующий сonten-type и шаблон для sitemap'a
     *
     * @param array $aData
     * @return void        header("Content-type: application/xml");

     */
    protected function _displaySitemap(array $aData, $sTemplate = 'sitemap.tpl') {
        header("Content-type: application/xml");
        $this->Viewer_Assign('aData', $aData);
        $this->SetTemplate(Plugin::GetTemplatePath('sitemap') . $sTemplate);
    }
    
    /**
     * Генерирует карту Sitemap-ов, разбивая каждый тип сущностей на наборы
     *
     * @return void
     */
    protected function eventIndex() {
        $iPerPage = Config::Get('plugin.sitemap.objects_per_page');
        $aCounters = array(
            'general' => 1,
            'blogs' => ceil($this->PluginSitemap_Blog_GetOpenCollectiveBlogsCount() / $iPerPage),
            'topics' => ceil($this->PluginSitemap_Topic_GetOpenTopicsCount() / $iPerPage),
            // в sitemap пользователей в 3ри раза больше ссылок
            'users' => ceil($this->PluginSitemap_User_GetUsersCount() / floor($iPerPage / 3)),
        );

        // Support for plugin "Page"
        if ($this->PluginSitemap_Sitemap_IsActivePlugin('page')) {
            $aCounters['pages'] = ceil($this->PluginSitemap_Page_GetActivePagesCount() / $iPerPage);
        }

        // Support for plugin "Gallery"
        if ($this->PluginSitemap_Sitemap_IsActivePlugin('gallery')) {
//            $counters[Config::Get('module.sitemap.gallery_name') . '_categories'] =
//                    ceil($this->PluginSitemap_Sitemap_getNumberOfGalleryCategories() / $objects_per_page);
            $aCounters['gallery_albums'] = ceil($this->PluginSitemap_Gallery_GetOpenAlbumsCount() / $iPerPage);
//            $counters[Config::Get('module.sitemap.gallery_name') . '_albums_photos'] =
//                    ceil($this->PluginSitemap_Sitemap_getNumberOfGalleryAlbumsPhotos() / $objects_per_page);
//            $counters[Config::Get('module.sitemap.gallery_name') . '_categories_photos'] =
//                    ceil($this->PluginSitemap_Sitemap_getNumberOfGalleryCategoriesPhotos() / $objects_per_page);
//            $counters[Config::Get('module.sitemap.gallery_name') . '_tags'] =
//                    ceil($this->PluginSitemap_Sitemap_getNumberOfGalleryTags() / $objects_per_page);
        }

        $aData = array();
        foreach ($aCounters as $sType => $iCount) {
            for ($i = 1; $i <= $iCount; ++$i) {
                $aData[] = array(
                    'loc' => Config::Get('path.root.web') . '/sitemap_' . $sType . '_' . $i . '.xml'
                );
            }
        }

        $this->_displaySitemap($aData, 'sitemap_index.tpl');
    }

    /**
     * Генерирует Sitemap общих, не изменяемых URL страниц сайта
     *
     * @return void
     */
    protected function eventGeneral() {
        $aData = array();
        $aData[] = $this->PluginSitemap_Sitemap_GetDataForSitemapRow(
            Config::Get('path.root.web'), 
            time(),
            Config::Get('plugin.sitemap.general.mainpage.sitemap_priority'),
            Config::Get('plugin.sitemap.general.mainpage.sitemap_changefreq')
        );
        $aData[] = $this->PluginSitemap_Sitemap_GetDataForSitemapRow(
            Config::Get('path.root.web') . '/comments/', 
            null, //time(),
            Config::Get('plugin.sitemap.general.comments.sitemap_priority'),
            Config::Get('plugin.sitemap.general.comments.sitemap_changefreq')
        );
        
        $this->_displaySitemap($aData);
    }

    /**
     * Генерирует постраничный Sitemap открытых коллективных блогов
     *
     * @return void
     */
    protected function eventBlogs() {
        $aData = $this->PluginSitemap_Blog_GetOpenCollectiveBlogsForSitemap(
                $this->getChunkIdx());
        $this->_displaySitemap($aData);
    }

    /**
     * Генерирует постраничный Sitemap топиков
     *
     * @return void
     */
    protected function eventTopics() {
        $aData = $this->PluginSitemap_Topic_GetOpenTopicsForSitemap(
                $this->getChunkIdx());
        $this->_displaySitemap($aData);
    }

    /**
     * Генерирует Sitemap пользовательских профилей, топиков и комментариев
     *
     * @return void
     */
    protected function eventUsers() {
        $aData = $this->PluginSitemap_User_GetUsersForSitemap(
                $this->getChunkIdx());
        $this->_displaySitemap($aData);
    }

    /**
     * Generate Sitemap of static pages
     *
     * @return void
     */
    protected function eventPages() {
        $aData = $this->PluginSitemap_ModulePage_GetPagesForSitemap(
                $this->getChunkIdx());
        $this->_displaySitemap($aData);
    }

//    /**
//     * Generate Sitemap of gallery categories with maximum of 50000 URLs in one set
//     *
//     * */
//    protected function eventGalleryCategories() {
//        $aObjects = $this->PluginSitemap_Sitemap_getAllGalleryCategoriesList($this->getChunkFirstIdx());
//        $this->Viewer_Assign('aCategories', $aObjects);
//    }
//
//    /**
//     * Generate Sitemap of gallery tags with maximum of 50000 URLs in one set
//     *
//     * */
//    protected function eventGalleryTags() {
//        $aObjects = $this->PluginSitemap_Sitemap_getAllGalleryTagsList($this->getChunkFirstIdx());
//        $this->Viewer_Assign('aTags', $aObjects);
//    }
//

    /**
     * Generate Sitemap of gallery albums
     *
     * @return void
     */
    protected function eventGalleryAlbums() {
        $aData = $this->PluginSitemap_Gallery_GetOpenAlbumsForSitemap(
                $this->getChunkIdx());
        $this->_displaySitemap($aData);
    }

//    /**
//     * Generate Sitemap of gallery albums photos with maximum of 50000 URLs in one set
//     *
//     *
//     */
//    protected function eventGalleryAlbumsPhotos() {
//        $aObjects = $this->PluginSitemap_Sitemap_getAllGalleryAlbumsPhotosList($this->getChunkFirstIdx());
//        $this->Viewer_Assign('aPhotos', $aObjects);
//    }
//
//    /**
//     * Generate Sitemap of gallery categories photos with maximum of 50000 URLs in one set
//     *
//     * */
//    protected function eventGalleryCategoriesPhotos() {
//        $aObjects = $this->PluginSitemap_Sitemap_getAllGalleryCategoriesPhotosList($this->getChunkFirstIdx());
//        $this->Viewer_Assign('aPhotos', $aObjects);
//    }

    private function getChunkIdx() {
        $idx = intval(preg_replace('#^sitemap_(\d+)\.xml$#', '\1', $this->getParam(0)));

        return ($idx > 1) ? $idx : 1;
    }

//    private function getChunkFirstIdx() {
//        return (($this->getChunkIdx() - 1) * Config::Get('plugin.sitemap.objects_per_page'));
//    }

}