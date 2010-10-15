<?php

//require_once('mapper/Sitemap.mapper.class.php');

/**
 * Модуль для плагина генерации Sitemap
 */
class PluginSitemap_ModuleSitemap extends Module {

    /**
     * Маппер
     * @var PluginSitemap_ModuleSitemap_MapperSitemap
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
     * Конвертирует дату в формат W3C Datetime
     *
     * @param mixed $mDate - UNIX timestamp или дата в формате понимаемом функцией strtotime()
     * @return string - дата в формате W3C Datetime (http://www.w3.org/TR/NOTE-datetime)
     */
    private function _convDateToLastMod($mDate = null) {
        if (is_null($mDate)) {
            return null;
        }
        
        $mDate = is_int($mDate) ? $mDate : strtotime($mDate);
        return date('Y-m-d\TH:i:s+00:00', $mDate);
    }

    /**
     * Test for active plugin
     * @param string $sName
     * @return boolean
     */
    public function isActivePlugin($sName) {
        return in_array($sName, $this->Plugin_GetActivePlugins());
    }

    /**
     * Возвращает массив с данными для генерации sitemap'а
     *
     * @param string $sUrl
     * @param mixed $sLastMod
     * @param mixed $sChangeFreq
     * @param mixed $sPriority
     * @return array 
     */
    public function getDataForSitemapRow($sUrl, $sLastMod = null, $sChangeFreq = null, $sPriority = null) {
        return array(
            'loc' => $sUrl,
            'lastmod' => $this->_convDateToLastMod($sLastMod),
            'priority' => $sChangeFreq,
            'changefreq' => $sPriority,
        );
    }

//    /**
//     * Number of gallery categories
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryCategories() {
//        return $this->oMapper->getNumberOfGalleryCategories();
//    }
//
//    /**
//     * List of gallery categories
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryCategoriesList($from) {
//        $cacheKey = "sitemap_gallery_categories_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
//        if (false === ($data = $this->Cache_Get($cacheKey))) {
//            if ($data = $this->oMapper->getAllGalleryCategoriesList($from)) {
//                $this->Cache_Set($data, $cacheKey, array('gallery_category_new'), 60 * 30);
//            }
//        }
//        return $data;
//    }
//
//    /**
//     * Number of gallery tags
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryTags() {
//        return $this->oMapper->getNumberOfGalleryTags();
//    }
//
//    /**
//     * List of gallery tags
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryTagsList($from) {
//        $cacheKey = "sitemap_gallery_tags_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
//        if (false === ($data = $this->Cache_Get($cacheKey))) {
//            if ($data = $this->oMapper->getAllGalleryTagsList($from)) {
//                $this->Cache_Set($data, $cacheKey, array('gallery_tag_new'), 60 * 30);
//            }
//        }
//        return $data;
//    }
//

//
//    /**
//     * Number of photos in all albums
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryAlbumsPhotos() {
//        return $this->oMapper->getNumberOfGalleryAlbumsPhotos();
//    }
//
//    /**
//     * List of albums photos
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryAlbumsPhotosList($from) {
//        $cacheKey = "sitemap_photos_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
//
//        if (false === ($data = $this->Cache_Get($cacheKey))) {
//            if ($data = $this->oMapper->getAllGalleryAlbumsPhotosList($from)) {
//                $this->Cache_Set($data, $cacheKey, array('gallery_photo_new'), 60 * 30);
//            }
//        }
//        return $data;
//    }
//
//    /**
//     * Number of photos in all categories
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryCategoriesPhotos() {
//        return $this->oMapper->getNumberOfGalleryCategoriesPhotos();
//    }
//
//    /**
//     * List of albums photos
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryCategoriesPhotosList($from) {
//        $cacheKey = "sitemap_categories_photos_{$from}_" . Config::Get('plugin.sitemap.objects_per_page');
//
//        if (false === ($data = $this->Cache_Get($cacheKey))) {
//            if ($data = $this->oMapper->getAllGalleryCategoriesPhotosList($from)) {
//                $this->Cache_Set($data, $cacheKey, array('gallery_category_photo_new'), 60 * 30);
//            }
//        }
//        return $data;
//    }

//    /**
//     * Add NiceUrl plugin url to data
//     * @param array $aData
//     * @return array
//     */
//    public function NiceUrl_Url($aData) {
//        $this->Viewer_Assign('isPlugin_NiceUrl', true);
//        foreach ($aData as $iK => $aRow) {
//            $oTopic = $this->Topic_GetTopicById($aRow['topic_id']);
//            $aData[$iK]['nice_url'] = $this->PluginNiceurl_ModuleNiceurl_BuildUrlForTopic($oTopic);
//        }
//        return $aData;
//    }

}
