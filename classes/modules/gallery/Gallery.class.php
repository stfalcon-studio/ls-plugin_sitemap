<?php

/**
 * Модуль Gallery плагина Sitemap
 */
class PluginSitemap_ModuleGallery extends Module {

    /**
     * Маппер
     * @var PluginSitemap_ModuleGallery_MapperGallery
     */
    protected $oMapper;

    /**
     * Инициализация модуля
     *
     * @return void
     */
    public function Init() {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    /**
     * Count of open albums
     *
     * @return integer
     */
    public function getOpenAlbumsCount() {
        return $this->oMapper->getOpenAlbumsCount();
    }

    /**
     * List of gallery albums
     *
     * @param integer $iCurrPage
     * @return array
     */
    public function getOpenAlbumsForSitemap($iCurrPage = 0) {
        $sCacheKey = "sitemap_albums_{$iCurrPage}_" . Config::Get('plugin.sitemap.objects_per_page');

        if (false === ($aData = $this->Cache_Get($sCacheKey))) {
            $iCount = 0;
            $aGalleryAlbums = $this->PluginGallery_Gallery_GetAlbumsLast($iCurrPage, Config::Get('plugin.sitemap.objects_per_page'), 0);
            
            $aData = array();
            foreach ($aGalleryAlbums['collection'] as $oGalleryAlbum) {
                $aData[] = $this->PluginSitemap_ModuleSitemap_GetDataForSitemapRow(
                        // @todo refact
                        Config::Get('path.root.web') . Config::Get('gallery.url') . '/user/'. $oGalleryAlbum->getUser()->getLogin() . '/' . $oGalleryAlbum->getId(),
                        // @todo refact
                        $oGalleryAlbum->getDateAdd(),
                        Config::Get('plugin.sitemap.gallery.albums.sitemap_priority'),
                        Config::Get('plugin.sitemap.gallery.albums.sitemap_changefreq')
                );
            }

            $this->Cache_Set($aData, $sCacheKey, array('album_new', 'album_update'), Config::Get('plugin.sitemap.gallery.cache_lifetime')); 
        }

        return $aData;
    }

}