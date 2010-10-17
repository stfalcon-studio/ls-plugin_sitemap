<?php

class PluginSitemap_ModuleBlog_EntityBlog extends PluginSitemap_Inherit_ModuleBlog_EntityBlog {

    /**
     * Get blog add date
     * It's temporary fix for bug in LS 0.4.2 http://trac.lsdev.ru/livestreet/ticket/158
     *
     * @return string|null
     */
    public function getDateAdd() {
        return $this->_aData['blog_date_add'];
    }

    /**
     * Get blog edit date
     * It's temporary fix for bug in LS 0.4.2 http://trac.lsdev.ru/livestreet/ticket/158
     * 
     * @return string|null
     */
    public function getDateEdit() {
        return $this->_aData['blog_date_edit'];
    }

    /**
     * Set blog add date
     * It's temporary fix for bug in LS 0.4.2 http://trac.lsdev.ru/livestreet/ticket/158
     * 
     * @return void
     */
    public function setDateAdd($data) {
        $this->_aData['blog_date_add'] = $data;
    }

    /**
     * Set blog edit date
     * It's temporary fix for bug in LS 0.4.2 http://trac.lsdev.ru/livestreet/ticket/158
     * 
     * @return void
     */
    public function setDateEdit($data) {
        $this->_aData['blog_date_edit'] = $data;
    }

    /**
     * Get date of last blog modification
     *
     * @return string
     */
    public function getDateLastMod() {
        return is_null($this->getDateEdit()) ? $this->getDateAdd() : $this->getDateEdit();
    }
}
