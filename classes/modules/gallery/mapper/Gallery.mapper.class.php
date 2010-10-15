<?php

/**
 * Маппер Gallery модуля Gallery плагина Sitemap
 */
class PluginSitemap_ModuleGallery_MapperGallery extends Mapper {


    /**
     * Number of albums
     *
     * @return integer
     */
    public function getOpenAlbumsCount() {
        $sql = 'SELECT
                        COUNT(`gallery_album`.`album_id`)
                FROM
                        `' . Config::Get('db.table.gallery.album') . '` AS `gallery_album`
                WHERE
                        `gallery_album`.`album_type` = "open"
                ';
        
        return $this->oDb->selectCell($sql);
    }
//
//    /**
//     * List of gallery albums
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryAlbumsList($from) {
//        $sql = 'SELECT
//                    album_id , DATE(IF(album_date_edit IS NULL OR album_date_edit="0000-00-00 00:00:00", album_date_add, album_date_edit)) AS lastmod, USR.user_login
//                FROM
//                    `' . Config::Get('db.table.gallery.album') . '` ALB
//                LEFT JOIN
//                    `' . Config::Get('db.table.user') . '` USR ON USR.user_id=ALB.album_user_id
//                WHERE
//                    album_type = "open"
//                ORDER BY
//                    album_id ASC
//                LIMIT
//                    ?d, ?d
//                        ';
//
//        $aAlbumsList = $this->oDb->query($sql, $from, Config::Get('plugin.sitemap.objects_per_page'));
//        return (is_array($aAlbumsList)) ? $aAlbumsList : array();
//    }

}
