<?php

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

    /**
     * Этот метод переопределяется в других плагинах и добавляет их наборы данных
     * к основному набору
     *
     * @return array
     */
    public function getExternalCounters() {
        return array();
    }


    /**
     * Этот метод переопределяется в других плагинах и добавляет нужные ссылки на
     * сайтмапы к основному набору ссылок
     *
     * @return array
     */
    public function getExternalLinks() {
        return array();
    }

    /**
     * Данные для Sitemap общих страниц сайта
     *
     * @param integer $iCurrPage
     * @return array
     */
    public function getDataForGeneral($iCurrPage) {
        $aData = array();
        $aData[] = $this->GetDataForSitemapRow(
            Config::Get('path.root.web'),
            time(),
            Config::Get('plugin.sitemap.general.mainpage.sitemap_priority'),
            Config::Get('plugin.sitemap.general.mainpage.sitemap_changefreq')
        );
        $aData[] = $this->GetDataForSitemapRow(
            Config::Get('path.root.web') . '/comments/',
            null, //time(),
            Config::Get('plugin.sitemap.general.comments.sitemap_priority'),
            Config::Get('plugin.sitemap.general.comments.sitemap_changefreq')
        );
        return $aData;
    }

    /**
     * Данные для Sitemap открытых коллективных блогов
     *
     * @param integer $iCurrPage
     * @return array
     */
    public function getDataForBlogs($iCurrPage) {
        return $this->PluginSitemap_Blog_GetOpenCollectiveBlogsForSitemap($iCurrPage);
    }

    /**
     * Данные для Sitemap опубликованных топиков
     *
     * @param integer $iCurrPage
     * @return void
     */
    public function getDataForTopics($iCurrPage) {
        return $this->PluginSitemap_Topic_GetOpenTopicsForSitemap($iCurrPage);
    }

    /**
     * Данные для Sitemap пользовательских профилей, топиков и комментариев
     *
     * @param integer $iCurrPage
     * @return void
     */
    public function getDataForUsers($iCurrPage) {
        return $this->PluginSitemap_User_GetUsersForSitemap($iCurrPage);
    }

}
