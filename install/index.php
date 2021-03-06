<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\IO\Directory;


Loc::loadMessages(__FILE__);

if (class_exists('mx_bitrixcolorproperty')) {
    return;
}

/**
 * Class mx_bitrixcolorproperty
 */
class mx_bitrixcolorproperty extends \CModule
{
    const MODULE_ID = 'mx.bitrixcolorproperty';

    function __construct() {
        $this->MODULE_ID = self::MODULE_ID;
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_NAME = Loc::getMessage('MX_BITRIXCOLORPROPERTY:MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MX_BITRIXCOLORPROPERTY:MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'Y';
        $this->PARTNER_NAME = "ООО \"Максимастер\"";
        $this->PARTNER_URI = "http://maximaster.ru";
    }

    /**
     * Install module to system
     *
     * @return bool
     */
    public function doInstall()
    {
        $this->installFiles();
        $this->installDB();
        ModuleManager::registerModule($this->MODULE_ID);
        return true;
    }

    /**
     * UnInstall module from system
     *
     * @return bool
     */
    public function doUnInstall()
    {
        $this->unInstallFiles();
        $this->unInstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);

        return true;
    }

    function installDB()
    {
        $handler = EventManager::getInstance();

        $handler->registerEventHandler('iblock', 'OnIBlockPropertyBuildList', $this->MODULE_ID,
            '\\Maximaster\\BitrixColorProperty', 'getDescription');
        $handler->registerEventHandler('main', 'OnUserTypeBuildList', $this->MODULE_ID,
            '\\Maximaster\\BitrixColorProperty', 'getDescription');
    }

    function unInstallDB()
    {
        $handler = EventManager::getInstance();

        $handler->unRegisterEventHandler('iblock', 'OnIBlockPropertyBuildList', $this->MODULE_ID,
            '\\Maximaster\\BitrixColorProperty', 'getDescription');
        $handler->unRegisterEventHandler('main', 'OnUserTypeBuildList', $this->MODULE_ID,
            '\\Maximaster\\BitrixColorProperty', 'getDescription');
    }
}
