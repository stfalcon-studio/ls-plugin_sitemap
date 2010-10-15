<?php

/**
 * Маппер User модуля User плагина Sitemap
 */
class PluginSitemap_ModuleUser_MapperUser extends Mapper {

    /**
     * Список айдишек активных пользователей
     *
     * @param integer $iCount
     * @param integer $iCurrPage
     * @param integer $iPerPage
     * @return array
     */
    public function getUsersId(&$iCount, $iCurrPage, $iPerPage) {
        $sql = 'SELECT
                    `user`.`user_id`
                FROM
                    `' . Config::Get('db.table.user') . '` AS `user`
                WHERE
                    `user`.`user_activate` = 1
                ORDER BY
                    `user`.`user_id` ASC
                LIMIT
                    ?d, ?d
                ';
        $aReturn = array();
        if ($aRows = $this->oDb->selectPage($iCount, $sql, ($iCurrPage-1) * $iPerPage, $iPerPage)) {
            foreach ($aRows as $aRow) {
                $aReturn[] = $aRow['user_id'];
            }
        }

        return $aReturn;
    }

}
