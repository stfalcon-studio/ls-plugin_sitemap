<?php

class PluginSitemap_ModuleUser_EntityUser extends ModuleUser_EntityUser {

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
        return Router::GetPath('my') . $this->getLogin() . '/comment/';
    }

    /**
     * Get web path to page with user topics
     *
     * @return string
     */
    public function getUserTopicsWebPath() {
        return Router::GetPath('my') . $this->getLogin() . '/';
    }

}
