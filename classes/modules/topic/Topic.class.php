<?php

/**
 * Модуль Topic плагина Sitemap
 */
class PluginSitemap_ModuleTopic extends Module {

    /**
     * Mapper
     * @var PluginSitemap_ModuleTopic_MapperTopic
     */
    protected $oMapper;

    /**
     * Инициализация
     *
     * @return void
     */
    public function Init() {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    /**
     * Фильтр для выборки опубликованых топиков в открытых блогах
     *
     * @return array
     */
    protected function _getFilterForTopics() {
        return array(
            'blog_type' => array(
                'open',
            ),
            'topic_publish' => 1,
        );
    }

    /**
     * Количество опубликованых топиков в открытых блогах
     *
     * @return integer
     */
    public function getOpenTopicsCount() {
        return (int) $this->Topic_GetCountTopicsByFilter($this->_getFilterForTopics());
    }

    /**
     * Список опубликованых топиков в открытых блогах (с кешированием)
     *
     * @param integer $iCurrPage
     * @return array
     */
    public function getOpenTopicsForSitemap($iCurrPage = 0) {
        $sCacheKey = "sitemap_topics_{$iCurrPage}_" . Config::Get('plugin.sitemap.objects_per_page');

        if (false === ($aData = $this->Cache_Get($sCacheKey))) {
            $aTopics = $this->Topic_GetTopicsByFilter($this->_getFilterForTopics(), $iCurrPage, Config::Get('plugin.sitemap.objects_per_page'), array('blog' => array()));

            $aData = array();
            foreach ($aTopics['collection'] as $oTopic) {
                $aData[] = $this->PluginSitemap_ModuleSitemap_GetDataForSitemapRow(
                        $oTopic->getUrl(),
                        $oTopic->getDateLastMod(),
                        Config::Get('plugin.sitemap.topics.sitemap_priority'),
                        Config::Get('plugin.sitemap.topics.sitemap_changefreq')
                );
            }

            // тег 'blog_update' т.к. при редактировании блога его тип может измениться
            // с открытого на закрытый или наоборот
            $this->Cache_Set($aData, $sCacheKey, array('topic_new', 'blog_update'), Config::Get('plugin.sitemap.topics.cache_lifetime')); // @todo в конфиг
        }

        return $aData;
    }

}