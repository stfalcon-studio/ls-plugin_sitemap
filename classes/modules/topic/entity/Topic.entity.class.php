<?php

class PluginSitemap_ModuleTopic_EntityTopic extends PluginSitemap_Inherit_ModuleTopic_EntityTopic {

    /**
     * Get date of last topic modification
     *
     * @return string
     */
    public function getDateLastMod() {
        return is_null($this->getDateEdit()) ? $this->getDateAdd() : $this->getDateEdit();
    }
    
}
