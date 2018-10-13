<div class="main-container">
    <div class="wrapper-container">
        <div class="content">
            <div class="tab-content">
                <div class="tabs rec-tabs">
                    <ul>
                        <?php if (check_ACL($profile, 'rec', 'report')) {?>
                        <li ng-class="{'active': model.activeTab == 1}"
                            ng-click="model.activeTab=1">
                            <?php echo REC0100_TAB_REPORT;?>
                        </li>
                        <?php }?>

                        <?php if (check_ACL($profile, 'rec', 'config')) {?>
                        <li ng-class="{'active': model.activeTab == 2}"
                            ng-click="model.activeTab=2">
                            <?php echo REC0100_TAB_CONFIGURE;?>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <?php if (check_ACL($profile, 'rec', 'report')) {?>
                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==1" ng-include="'/REC0200'" ng-controller="REC0200Ctrl" ng-init="init()">
                </div>
                <?php }?>

                <?php if (check_ACL($profile, 'rec', 'config')) {?>
                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==2" ng-include="'/REC0300'" ng-controller="REC0300Ctrl" ng-init="init()">
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>