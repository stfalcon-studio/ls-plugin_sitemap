<?php

class PluginSitemap_ModuleUser_EntityUser extends PluginSitemap_Inherit_ModuleUser_EntityUser {

    /**
     * Get date of last user modification
     *
     * @return string
     */
    public function getDateLastMod() {
        return is_null($this->getProfileDate()) ? $this->getDateRegister() : $this->getProfileDate();
    }

    /**
     * Get web path to page with user comments
     *
     * @return string
     */
    public function getUserCommentsWebPath() {
        return $this->getUserWebPath() . 'created/comments/';
    }

    /**
     * Get web path to page with user topics
     *
     * @return string
     */
    public function getUserTopicsWebPath() {
        return $this->getUserWebPath() . 'created/topics/';
    }

}
