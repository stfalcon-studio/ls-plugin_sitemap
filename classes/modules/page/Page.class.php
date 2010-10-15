<?php

/**
 * Модуль Page плагина Sitemap
 */
class PluginSitemap_ModulePage extends PluginPage_ModulePage {

    /**
     * Инициализация
     *
     * @return void
     */
    public function Init() {
        parent::Init();
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    /**
     * Get count of pages
     *
     * @return integer
     */
    public function getActivePagesCount() {
        return (int) $this->oMapper->getActivePagesCount();
    }

    /**
     * List of pages
     *
     * @param integer $from
     * @return array
     */
    public function getPagesForSitemap($iCurrPage = 0) {
        $sCacheKey = "sitemap_pages_{$iCurrPage}_" . Config::Get('plugin.sitemap.objects_per_page');;

        if (false === ($aData = $this->Cache_Get($sCacheKey))) {
            $iCount = 0;
            $aPages = $this->oMapper->getActivePages($iCount, $iCurrPage, Config::Get('plugin.sitemap.objects_per_page'));

            $aData = array();
            foreach ($aPages as $oPage) {
                $aData[] = $this->PluginSitemap_ModuleSitemap_GetDataForSitemapRow(
                        $oPage->getUrlFull(),
                        $oPage->getDateLastMod(),
                        Config::Get('plugin.sitemap.pages.sitemap_priority'),
                        Config::Get('plugin.sitemap.pages.sitemap_changefreq')
                );
            }

            $this->Cache_Set($aData, $sCacheKey, array('page_change'), Config::Get('plugin.sitemap.Pages.cache_lifetime')); // @todo в конфиг
        }

        return $aData;
    }


}