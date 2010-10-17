<?php

/**
 * Модуль User плагина Sitemap
 */
class PluginSitemap_ModuleUser extends Module {

    /**
     * Маппер
     * @var PluginSitemap_ModuleUser_MapperUser
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
     * Количество пользователей
     *
     * @return integer
     */
    public function getUsersCount() {
        $aStatUsers = $this->User_GetStatUsers();
        return $aStatUsers['count_all'];
    }

    /**
     * Список пользователей (с кешированием)
     *
     * @param integer $iCurrPage
     * @return array
     */
    public function getUsersForSitemap($iCurrPage) {
        // в sitemap пользователей в 3ри раза больше ссылок
        $iPerPage = floor(Config::Get('plugin.sitemap.objects_per_page') / 3);

        $sCacheKey = "sitemap_users_{$iCurrPage}_{$iPerPage}";

        if (false === ($aData = $this->Cache_Get($sCacheKey))) {
            $aUsersId = $this->oMapper->getUsersId($iCount, $iCurrPage, $iPerPage);
            $aUsers = $this->User_GetUsersByArrayId($aUsersId);

            $aData = array();
            foreach ($aUsers as $oUser) {
                // профиль пользователя
                $aData[] = $this->PluginSitemap_Sitemap_GetDataForSitemapRow(
                        $oUser->getUserWebPath(),
                        $oUser->getDateLastMod(),
                        Config::Get('plugin.sitemap.users.profile.sitemap_priority'),
                        Config::Get('plugin.sitemap.users.profile.sitemap_changefreq')
                );

                // публикации пользователя
                $aData[] = $this->PluginSitemap_Sitemap_GetDataForSitemapRow(
                        $oUser->getUserTopicsWebPath(),
                        // @todo временем изменения страницы публикаций должно быть время последней публикации пользователя
                        null,
                        Config::Get('plugin.sitemap.users.my.sitemap_priority'),
                        Config::Get('plugin.sitemap.users.my.sitemap_changefreq')
                );

                // комментарии пользователя
                $aData[] = $this->PluginSitemap_Sitemap_GetDataForSitemapRow(
                        $oUser->getUserCommentsWebPath(),
                        $oUser->getDateCommentLast(),
                        Config::Get('plugin.sitemap.users.comments.sitemap_priority'),
                        Config::Get('plugin.sitemap.users.comments.sitemap_changefreq')
                );

                $this->Cache_Set($aData, $sCacheKey, array('user_new', 'user_update'), Config::Get('plugin.sitemap.users.cache_lifetime'));
            }
        }

        return $aData;
    }

}