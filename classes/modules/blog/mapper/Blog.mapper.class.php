<?php

/**
 * Маппер Blog модуля Blog плагина Sitemap
 */
class PluginSitemap_ModuleBlog_MapperBlog extends ModuleBlog_MapperBlog {
        
    /**
     * Количество открытых коллективных блогов
     *
     * @return integer
     */
    public function getNumberOfCollectiveBlogs() {
        $sql = 'SELECT
                        COUNT(`blog`.`blog_id`)
                FROM
                        `' . Config::Get('db.table.blog') . '` AS `blog`
                WHERE
                        `blog`.`blog_type` = "open"
                ';

        return $this->oDb->selectCell($sql);
    }

    /**
     * Список айдишек открытых коллективных блогов
     *
     * @param integer $iCount
     * @param integer $iCurrPage
     * @param integer $iPerPage
     * @return array
     */
    public function getIdCollectiveBlogs(&$iCount, $iCurrPage, $iPerPage) {
        $sql = 'SELECT
                        `blog`.`blog_id`
                FROM
                        `' . Config::Get('db.table.blog') . '` AS `blog`
                WHERE
                        `blog`.`blog_type` = "open"
                ORDER BY
                        `blog`.`blog_id` ASC
                LIMIT
                        ?d, ?d
                ';
        $aReturn = array();
        if ($aRows = $this->oDb->selectPage($iCount, $sql, ($iCurrPage-1) * $iPerPage, $iPerPage)) {
            foreach ($aRows as $aRow) {
                $aReturn[] = $aRow['blog_id'];
            }
        }

        return $aReturn;
    }

}
