<div class="main-container">
    <div class="wrapper-container">
        <div class="content">
            <div class="tab-content">
                <div class="tabs">
                    <ul>
                        <li
                            ng-class="{'active': model.activeTab == 1}"
                            ng-click="model.activeTab=1">
                            <?php echo DAS0100_TAB_GENERATE;?>
                        </li>
                        <li
                            ng-class="{'active': model.activeTab ==2}"
                            ng-click="model.activeTab =2">
                            <?php echo DAS0100_TAB_LOCATION;?>
                        </li>
                        <li
                            ng-class="{'active': model.activeTab ==3}"
                            ng-click="model.activeTab =3">
                            <?php echo DAS0100_TAB_WORKING_SCHEDULE;?>
                        </li>
                    </ul>
                </div>
                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==1" ng-include="'/DAS0110'" ng-controller="DAS0110Ctrl">
                </div>
                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==2" ng-include="'/DAS0140'" ng-controller="DAS0140Ctrl" ng-init="init()">

                </div>
                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==3" ng-include="'/DAS0150'" ng-controller="DAS0150Ctrl" ng-init="init()">

                </div>
            </div>
        </div>
    </div>
</div>