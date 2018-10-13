<div class="main-container">
    <div class="wrapper-container">
        <div class="content">
            <div class="tab-content">
                <div class="tabs">
                    <ul>
                        <li
                            ng-class="{'active': model.activeTab == 1}"
                            ng-click="model.activeTab=1">
                            <?php echo STO0100_TAB_LIST; ?>
                        </li>

                        <li
                            ng-class="{'active': model.activeTab ==2}"
                            ng-click="model.activeTab =2">
                            <?php echo STO0100_TAB_STORE_SURVEY; ?>
                        </li>

                        <li
                            ng-class="{'active': model.activeTab ==3}"
                            ng-click="model.activeTab =3">
                            <?php echo STO0100_TAB_MANAGE_SURVEY_QUESTION; ?>
                        </li>

                        <li
                            ng-class="{'active': model.activeTab ==4}"
                            ng-click="model.activeTab =4">
                            <?php echo STO0100_TAB_REPORT_SURVEY_ANSWER; ?>
                        </li>

<!--                        <li-->
<!--                            ng-class="{'active': model.activeTab ==5}"-->
<!--                            ng-click="model.activeTab =5">-->
<!--                            --><?php //echo STO0100_TAB_OVERVIEW; ?>
<!--                        </li>-->

                        <li
                            ng-class="{'active': model.activeTab ==6}"
                            ng-click="model.activeTab =6">
                            <?php echo STO0100_TAB_INVENTORY; ?>
                        </li>
                    </ul>
                </div>

                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==1" ng-include="'/STO0500'" ng-controller="STO0100Ctrl" ng-init="init()">
                </div>

                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==2" ng-include="'/STO0530'" ng-controller="STO0530Ctrl" ng-init="init()">
                </div>

                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==3" ng-include="'/STO0510'" ng-controller="STO0510Ctrl" ng-init="init()">
                </div>

                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==4" ng-include="'/STO0520'" ng-controller="STO0520Ctrl" ng-init="init()">
                </div>

<!--                <div class="content-tab-product scrollbarCustom"-->
<!--                     ng-if="model.activeTab==5" ng-include="'/STO0540'" ng-controller="STO0540Ctrl" ng-init="init()">-->
<!--                </div>-->

                <div class="content-tab-product scrollbarCustom"
                     ng-if="model.activeTab==6" ng-include="'/STO0600'" ng-controller="STO0600Ctrl" ng-init="init()">
                </div>
            </div>
        </div>
    </div>
</div>

<div ng-if="model.hidden.showImportStore" ng-include="'/STO0110'" ng-controller="STO0110Ctrl"
     ng-init="init()"></div> <!-- import store -->

<div ng-if="model.hidden.showImportSurvey" ng-include="'/STO0512/formImport'" ng-controller="STO0511Ctrl"
     ng-init="init()"></div> <!-- import survey question -->

<div ng-if="model.hidden.showImportStoreSurvey" ng-include="'/STO0534/formImport'" ng-controller="STO0531Ctrl"
     ng-init="init()"></div> <!-- import store survey -->

<div ng-if="model.hidden.showModalViewSalesman">
    <div ng-include="'/STO0536/viewSalesman'" ng-controller="STO0536Ctrl"
         ng-init="init(model.hidden.storeId, model.hidden.storeCode, model.hidden.token)">
    </div>
</div>
<div ng-if="model.hidden.showImportInventory" ng-include="'/STO0610'" ng-controller="STO0610Ctrl"
     ng-init="init()"></div> <!-- import inventory -->