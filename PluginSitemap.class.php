<?php

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

/**
 * Плагин для генерации sitemap
 *
 * @author Stepan Tanasiychuk <http://stfalcon.com>
 */
class PluginSitemap extends Plugin {

    /**
     * Указанные в массивы делегаты будут переданы движку автоматически
     * перед инициализацией плагина
     */
    protected $aInherits = array(
        'entity' => array(
            'ModuleBlog_EntityBlog' => '_ModuleBlog_EntityBlog',
            'ModuleTopic_EntityTopic' => '_ModuleTopic_EntityTopic',
            'ModuleUser_EntityUser' => '_ModuleUser_EntityUser',
        ),
    );

    /**
     * Активация плагина
     *
     * @return boolean
     */
    public function Activate() {
        return true;
    }

    /**
     * Инициализация плагина
     *
     * @return void
     */
    public function Init() {
        // @todo в LS r986 эти пути добавили в ядро движка
        // http://trac.lsdev.ru/livestreet/changeset/986
        // путь к папке темплейтов плагина
        $this->Viewer_Assign('sTemplateWebPathPluginSitemap', Plugin::GetTemplateWebPath(__CLASS__));
    }

    /**
     * Деактивация плагина
     *
     * @return boolean
     */
    public function Deactivate() {
        return true;
    }

}