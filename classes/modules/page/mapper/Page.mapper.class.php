<?php

/**
 * Маппер Page модуля Page плагина Sitemap
 */
class PluginSitemap_ModulePage_MapperPage extends PluginPage_ModulePage_MapperPage {

    /**
     * Number of pages
     *
     * @return integer
     */
    public function getActivePagesCount() {
        $sql = 'SELECT
                    COUNT(`page`.`page_id`)
                FROM
                    `' . Config::Get('plugin.page.table.page') . '` AS `page`
                WHERE
                    `page`.`page_active` = 1
                ';

        return $this->oDb->selectCell($sql);
    }

    /**
     * List of pages
     *
     * @param integer $iCount
     * @param integer $iCurrPage
     * @param integer $iPerPage
     * @return array
     */
    public function getActivePages(&$iCount, $iCurrPage, $iPerPage) {
        $sql = 'SELECT
                        `page`.*
                FROM
                        `' . Config::Get('plugin.page.table.page') . '` AS `page`
                WHERE
                        `page`.`page_active` = 1
                ORDER BY
                        `page`.`page_id` ASC
                LIMIT
                        ?d, ?d
                ';
        $aPages = array();
        if ($aRows = $this->oDb->selectPage($iCount, $sql, ($iCurrPage - 1) * $iPerPage, $iPerPage)) {
            foreach ($aRows as $aPage) {
                $aPages[] = Engine::GetEntity('PluginPage_Page', $aPage);
            }
        }

        return $aPages;
    }

}
