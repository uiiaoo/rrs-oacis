<?php
namespace rrsoacis\component\setting\cluster;

use rrsoacis\system\Config;
use rrsoacis\component\common\AbstractController;
use rrsoacis\manager\AppManager;
use rrsoacis\manager\ClusterManager;

class SettingsClustersListController extends AbstractController
{
    public function get()
    {
        $clusters = ClusterManager::getClusters();
        $needUpdate = false;
        foreach ($clusters as $cluster)
        {
            if ($cluster["check_status"] == 1)
            {
                ClusterManager::updateStatus($cluster["name"]);
            }
        }

        include(Config::$SRC_REAL_URL . 'component/setting/cluster/SettingsClustersListView.php');
    }
}
?>
