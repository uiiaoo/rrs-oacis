<?php
namespace rrsoacis\component\setting\restrict;

use rrsoacis\system\Config;
use rrsoacis\manager\AccessManager;
use rrsoacis\component\common\AbstractController;

class SettingsRestrictAccessSetController extends AbstractController
{
    public function anyIndex($param = 0)
    {
        self::get($param);
    }

    public function get ($isEnable = 0)
    {
        if ($isEnable == 1) { AccessManager::enableFilter(); }
        else { AccessManager::disableFilter(); }

        header('location: '.Config::$TOP_PATH.'settings-restrict');
    }
}
?>