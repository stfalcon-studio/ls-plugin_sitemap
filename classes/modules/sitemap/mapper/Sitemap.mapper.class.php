<?php

/**
 * Маппер для плагина генерации sitemap
 */
class PluginSitemap_ModuleSitemap_MapperSitemap extends Mapper {

        /**
         * Максимальная айдишка для коллективных блогов
         *
         * @return integer
         */
	public function getMaxOfCollectiveBlogs(){
		$sql = 'SELECT 
                                MAX(pb.blog_id)
                        FROM
                                `' . Config::Get('db.table.blog') . '` pb
                        WHERE
                                pb.blog_type <> "personal"
                        ';
		
		return $this->oDb->selectCell($sql);
	}

        /**
         * Список коллективных блогов
         *
         * @param integer $from
         * @return array
         */
	public function getCollectiveBlogList($from) {
		$sql = 'SELECT 
                                DATE(IF(pb.blog_date_edit IS NULL, pb.blog_date_add, pb.blog_date_edit)) AS lastmod, pb.blog_url
                        FROM
                                `' . Config::Get('db.table.blog') . '` pb
                        WHERE
                                pb.blog_type <> "personal" AND
                                pb.blog_id > ?d AND
                                pb.blog_id <= ?d
                        ORDER BY
                                pb.blog_id ASC
                        ';
		
		$blogList = $this->oDb->query($sql, $from, $from + Config::Get('plugin.sitemap.objects_per_page'));
		return (is_array($blogList)) ? $blogList : array();
	}

        /**
         * Максимайная айдишка для топиков
         * 
         * @return integer
         */
	public function getMaxOfTopics() {
		$sql = 'SELECT 
                                MAX(pt.topic_id)
                        FROM
                                `' . Config::Get('db.table.topic') . '` pt
                        WHERE
                                pt.topic_publish = 1
                        ';
		
		return $this->oDb->selectCell($sql);
	}

        /**
         * Список топиков
         *
         * @param integer $from
         * @return array
         */
	public function getAllTopicList($from) {
		$sql = 'SELECT 
                                pt.topic_id, DATE(IF(pt.topic_date_edit IS NULL, pt.topic_date_add, pt.topic_date_edit)) AS lastmod, pb.blog_type, pb.blog_url
                        FROM
                                `' . Config::Get('db.table.topic') . '` pt,
                                `' . Config::Get('db.table.blog') . '` pb
                        WHERE
                                pt.topic_publish = 1 AND
                                pb.blog_id = pt.blog_id AND
                                pt.topic_id > ?d AND
                                pt.topic_id <= ?d
                        ORDER BY
                                pt.topic_id ASC
                        ';
		
		$topicList = $this->oDb->query($sql, $from, $from + Config::Get('plugin.sitemap.objects_per_page'));
		return (is_array($topicList)) ? $topicList : array();
	}

        /**
         * Максимальная айдишка для юзеров
         *
         * @return integer
         */
	public function getMaxOfUsers(){
		$sql = 'SELECT 
                                MAX(pu.user_id)
                        FROM
                                `' . Config::Get('db.table.user') . '` pu
                        ';
		
		return $this->oDb->selectCell($sql);
	}

        /**
         * Список пользователей
         *
         * @param integer $from
         * @return array
         */
	public function getUserList($from){
		$sql = 'SELECT 
                                pu.user_login, DATE(pu.user_date_register) AS lastmod
                        FROM
                                `' . Config::Get('db.table.user') . '` pu
                        WHERE
                                user_id > ?d AND
                                user_id <= ?d
                        ORDER BY
                                user_id ASC
                        ';
		
		$userList = $this->oDb->query($sql, $from, $from + Config::Get('plugin.sitemap.objects_per_page'));
		return (is_array($userList)) ? $userList : array();
	}
}