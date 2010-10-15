<?php

/**
 * Маппер для плагина генерации sitemap
 */
class PluginSitemap_ModuleSitemap_MapperSitemap extends Mapper {

//    /**
//     * Number of gallery categories
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryCategories() {
//        $sql = 'SELECT
//                                COUNT(category_id)
//                        FROM
//                                `' . Config::Get('db.table.gallery.category') . '`
//                        WHERE
//                                category_pid IS NOT null
//                        ';
//
//        return $this->oDb->selectCell($sql);
//    }
//
//    /**
//     * List of gallery categories
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryCategoriesList($from) {
//        $sql = 'SELECT
//                                category_id , now() AS lastmod,category_url
//                        FROM
//                                `' . Config::Get('db.table.gallery.category') . '`
//                        WHERE
//                                category_pid IS NOT null
//                        ORDER BY
//                                category_id ASC
//                        LIMIT
//                                ?d, ?d
//                        ';
//
//        $aCategoryList = $this->oDb->query($sql, $from, Config::Get('plugin.sitemap.objects_per_page'));
//        return (is_array($aCategoryList)) ? $aCategoryList : array();
//    }
//
//    /**
//     * Number of gallery tags
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryTags() {
//        $sql = 'SELECT
//                                COUNT(image_tag_id)
//                        FROM
//                                `' . Config::Get('db.table.gallery.image_tag') . '`
//                        GROUP BY
//				image_tag_text
//                        ';
//
//        return $this->oDb->selectCell($sql);
//    }
//
//    /**
//     * List of gallery tags
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryTagsList($from) {
//        $sql = 'SELECT
//                                NOW() as lastmod,image_tag_text
//                        FROM
//                                `' . Config::Get('db.table.gallery.image_tag') . '`
//                        GROUP BY
//				image_tag_text
//                        ORDER BY
//                                image_tag_id ASC
//                        LIMIT
//                                ?d, ?d
//                        ';
//
//        $aTagsList = $this->oDb->query($sql, $from, Config::Get('plugin.sitemap.objects_per_page'));
//        return (is_array($aTagsList)) ? $aTagsList : array();
//    }
//
//    /**
//     * Number of gallery photos in albums
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryAlbumsPhotos() {
//        $sql = 'SELECT
//                                COUNT(image_id)
//                        FROM
//                                `' . Config::Get('db.table.gallery.image') . '`
//
//                        ';
//
//        return $this->oDb->selectCell($sql);
//    }
//
//    /**
//     * List of gallery albums
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryAlbumsPhotosList($from) {
//        $sql = 'SELECT
//                                IMG.album_id, image_id , image_date_add AS lastmod, USR.user_login
//                        FROM
//                                `' . Config::Get('db.table.gallery.image') . '` IMG
//                        LEFT JOIN
//                                `' . Config::Get('db.table.gallery.album') . '` ALB ON IMG.album_id=ALB.album_id
//                        LEFT JOIN
//                                `' . Config::Get('db.table.user') . '` USR ON USR.user_id=ALB.album_user_id
//                        WHERE
//                                album_type = "open"
//                        ORDER BY
//                                image_id  ASC
//                        LIMIT
//                                ?d, ?d
//                        ';
//
//        $aPhotosList = $this->oDb->query($sql, $from, Config::Get('plugin.sitemap.objects_per_page'));
//        return (is_array($aPhotosList)) ? $aPhotosList : array();
//    }
//
//    /**
//     * Number of gallery photos in categories
//     *
//     * @return integer
//     */
//    public function getNumberOfGalleryCategoriesPhotos() {
//        $sql = 'SELECT
//                                COUNT(image_id)
//                        FROM
//                                `' . Config::Get('db.table.gallery.image') . '`
//                        WHERE   category_id IS NOT null
//                        ';
//
//        return $this->oDb->selectCell($sql);
//    }
//
//    /**
//     * List of gallery  photos in categories
//     *
//     * @param integer $from
//     * @return array
//     */
//    public function getAllGalleryCategoriesPhotosList($from) {
//        $sql = 'SELECT
//                                IMG.album_id, image_id , image_date_add AS lastmod, USR.user_login
//                        FROM
//                                `' . Config::Get('db.table.gallery.image') . '` IMG
//                        LEFT JOIN
//                                `' . Config::Get('db.table.gallery.album') . '` ALB ON IMG.album_id=ALB.album_id
//                        LEFT JOIN
//                                `' . Config::Get('db.table.user') . '` USR ON USR.user_id=ALB.album_user_id
//                        WHERE
//                                IMG.category_id IS NOT null
//                        ORDER BY
//                                image_id  ASC
//                        LIMIT
//                                ?d, ?d
//                        ';
//
//        $aPhotosList = $this->oDb->query($sql, $from, Config::Get('plugin.sitemap.objects_per_page'));
//        return (is_array($aPhotosList)) ? $aPhotosList : array();
//    }

}