<div class="main-container">
    <div class="wrapper-container">
        <div class="content-list scrollbarCustom">
            <div class="group-action"></div>

            <div class="panel-form">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="icon-list"></span>
                            <?php echo USR0100_LABEL_FORM;?>
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-create">
                            <table
                                class="table list-user-search create-table">
                                <tr>
                                    <td class="title">
                                        <?php echo USR0100_LABEL_POSITION;?>
                                    </td>
                                    <td>
                                        <div>:
                                            <select
                                                chosen-select="model.form.USR0100InitDataModel.initSearch.conditionSearch.lstRoleCd"
                                                data-placeholder="<?php echo USR0100_LABEL_CHOOSE_POSITION;?>"
                                                chosen-width="200px"
                                                ng-model="model.form.USR0100InitDataModel.initSearch.conditionSearch.defaultRoleCd"
                                                ng-options="item.roleCd as item.roleName for item in model.form.USR0100InitDataModel.initSearch.conditionSearch.lstRoleCd">
                                            </select>
                                        </div>
                                    </td>

<!--                                    <td class="title">-->
<!--                                        --><?php //echo USR0100_LABEL_CLIENT;?>
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <div>:-->
<!--                                            <select-->
<!--                                                chosen-select="model.form.USR0100InitDataModel.initSearch.conditionSearch.lstClient"-->
<!--                                                data-placeholder="--><?php //echo USR0100_LABEL_CHOOSE_CLIENT;?><!--"-->
<!--                                                chosen-width="200px"-->
<!--                                                ng-model="model.form.USR0100InitDataModel.initSearch.conditionSearch.defaultClientId"-->
<!--                                                ng-options="item.clientId as item.clientName for item in model.form.USR0100InitDataModel.initSearch.conditionSearch.lstClient">-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </td>-->

                                    <td class="title">
                                        <?php echo USR0100_LABEL_USER_CODE;?>
                                    </td>
                                    <td>
                                        <div>:
                                            <input
                                                type="text"
                                                class="form-control-dms"
                                                ng-enter="search()"
                                                ng-model="model.form.searchParam.searchInput.userCode"
                                                value='{{model.form.searchParam.searchInput.userCode}}'>
                                        </div>
                                    </td>

                                    <td class="title">
                                        <?php echo USR0100_LABEL_USER_NAME;?>
                                    </td>
                                    <td>
                                        <div>:
                                            <input
                                                type="text"
                                                class="form-control-dms"
                                                ng-enter="search()"
                                                ng-model="model.form.searchParam.searchInput.userName"
                                                value='{{model.form.searchParam.searchInput.userName}}'>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                            <div class="btn-action-search">
                                <button
                                    class="btn btn-normal btn-sm btn-width-default"
                                    ng-click="search()">
<!--                                    <span class="icon-magnifier"></span>-->
                                    <?php echo USR0100_BUTTON_SEARCH;?>
                                </button>

                                <?php if (check_ACL($profile, 'user', 'create')) {?>
                                    <a class="btn btn-default btn-sm  btn-width-default btn-success" href="/USR0200">
                                        <!--                        <span class="icon-plus"> </span>-->
                                        <?php echo USR0100_BUTTON_CREAT;?>
                                    </a>
                                <?php }?>
                            </div>


                        </div>
                        <div class="result-search">
                            <div class="table-region">

                                <table
                                    class="list-table product-table table list-user table-striped table-bordered"
                                    ng-click="preventClose()">
                                    <thead>
                                    <tr>
<!--                                        <th-->
<!--                                            ng-click="sortName()"><i-->
<!--                                                ng-if="model.hidden.sortName==false"-->
<!--                                                class="fa fa-chevron-up"></i>-->
<!--                                            <i-->
<!--                                                ng-if="model.hidden.sortName==true"-->
<!--                                                class="fa fa-chevron-down"></i>-->
<!--                                            --><?php //echo USR0100_LABEL_CLIENT;?>
<!--                                        </th>-->
                                        <th ng-click="sortCode()" style="width: 15%"><i
                                                ng-if="model.hidden.sortCode==false"
                                                class="fa fa-chevron-up"></i>
                                            <i
                                                ng-if="model.hidden.sortCode==true"
                                                class="fa fa-chevron-down"></i>
                                            <?php echo USR0100_LABEL_CODE;?>
                                        </th>

                                        <th ng-click="sortName()" style="width: 15%"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i>
                                            <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i>
                                            <?php echo USR0100_LABEL_NAME;?>
                                        </th>
                                        <th ng-click="sortName()" style="width: 15%"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i>
                                            <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i>
                                            <?php echo USR0100_LABEL_POSITION;?>
                                        </th>
                                        <th ng-click="sortName()" style="width: 15%"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i>
                                            <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i>
                                            <?php echo USR0100_LABEL_EMAIL;?>
                                        </th>
                                        <th ng-click="sortName()" style="width: 15%"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i>
                                            <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i>
                                            <?php echo USR0100_LABEL_PHONE;?>
                                        </th>
                                        <th ng-click="sortName()" style="width: 25%"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i>
                                            <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i>
                                            <?php echo USR0100_LABEL_MANAGER_INFORMATION;?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        ng-repeat="userItem in model.form.USR0100InitDataModel.initSearch.userInfo.lstUser">
<!--                                        <td>{{userItem.clientName}}</td>-->
                                        <td>{{userItem.userCode}}</td>
                                        <td>{{userItem.fullName}}</td>
                                        <td>{{userItem.roleName}}</td>
                                        <td>{{userItem.email}}</td>
                                        <td>{{userItem.phone}}</td>
                                        <td>
                                            <ul class="list-manager-show">
                                                <li ng-repeat="managerItem in userItem.lstManagerArea">
                                                    {{managerItem.userCode}}
                                                    {{managerItem.fullName}}
                                                </li>
                                            </ul>

                                            <ul class="list-manager-show">
                                                <li ng-repeat="areaItem in userItem.lstArea">
                                                    {{areaItem}}
                                                </li>
                                            </ul>

                                            <ul class="list-manager-show">
                                                <span ng-show="userItem.lstRegionalManager != null"><?php echo USR0100_REGIONAL_MANAGER_LIST;?></span>
                                                <li ng-repeat="item in userItem.lstRegionalManager">
                                                    {{item.userCode}}
                                                    {{item.fullName}}
                                                </li>
                                                <span ng-show="userItem.lstRegionalManager != null">--------------------------</span>
                                            </ul>

                                            <ul class="list-manager-show">
                                                <span ng-show="userItem.lstProduct != null"><?php echo USR0100_PRODUCT_LIST;?></span>
                                                <li ng-repeat="productItem in userItem.lstProduct">
                                                    {{productItem.productName}}
                                                </li>
                                                <span ng-show="userItem.lstProduct != null">--------------------------</span>
                                            </ul>

                                            <ul class="list-manager-show">
                                                <span ng-show="userItem.lstSalesman != null"><?php echo USR0100_SALESMAN_LIST;?></span>
                                                <li ng-repeat="salesmanItem in userItem.lstSalesman">
                                                    {{salesmanItem.salesmanCode}} - {{salesmanItem.salesmanName}}
                                                </li>
                                                <span ng-show="userItem.lstSalesman != null">--------------------------</span>
                                            </ul>

                                            <?php if (check_ACL($profile, 'user', 'manage')) {?>
                                                <span ng-click="" title="<?php echo USR0100_TIP_DELETE_USER;?>"
                                                      class="delete-user pull-right icon-close dropdown-toggle"
                                                      data-toggle="dropdown">
                                                </span>
                                                <a href="/USR0210/{{userItem.userCode}}"
                                                   class="pull-right edit-user"
                                                   title="<?php echo USR0100_TIP_EDIT_USER; ?>">
                                                        <span
                                                            class="icon-note"></span>
                                                </a>
                                                <span
                                                    class="password-user pull-right icon-key"
                                                    title="<?php echo USR0100_TIP_CHANGE_PASSWORD; ?>"
                                                    ng-click="showModalPasswordReset(userItem)"></span>
                                                <div class="popover-confirm dropdown-menu">
                                                    <div
                                                        class="arrow">
                                                    </div>
                                                    <div
                                                        class="content-confirm">
                                                        {{model.hidden.deleteConfirm.message}}
                                                    </div>

                                                    <div
                                                        class="button-group-action text-center">

                                                        <button
                                                            class="btn btn-default btn-info btn-xs"
                                                            ng-click="deleteUser(userItem)">
                                                                <span>
                                                                    <?php echo COMMON_BUTTON_OK; ?>
                                                                </span>
                                                        </button>
                                                        <button
                                                            class="btn btn-default btn-danger btn-xs">
                                                            <span><?php echo COMMON_BUTTON_CANCEL; ?></span>
                                                        </button>

                                                    </div>

                                                </div>
                                            <?php }?>
                                        </td>
                                    </tr>

                                    <!--Empty - Begin-->
                                    <tr ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlRow == 0">
                                        <td colspan="7"><?php echo COM0000_EMPTY_RESULT;?></td>
                                    </tr>
                                    <!--Empty - End-->

                                    </tbody>
                                </table>
                                <div class="paging" ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlRow != 0">
                                    <ul class="pagination">
                                        <li class="disabled"><span>{{model.form.USR0100InitDataModel.initSearch.pagingInfo.stRow}}-{{model.form.USR0100InitDataModel.initSearch.pagingInfo.edRow}}/{{model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlRow}}</span></li>
                                        <li class="disabled"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == 1 || model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == null "><a
                                                href="#">&lt;&lt;</a></li>
                                        <li
                                            ng-click="startPage()"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != 1 && model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != null "><a
                                                href="#">&lt;&lt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == 1 || model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == null"><a
                                                href="#">&lt;</a></li>
                                        <li
                                            ng-click="prevPage()"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != 1 && model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != null "><a
                                                href="#">&lt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlPages || model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == null"><a
                                                href="#">&gt;</a></li>
                                        <li
                                            ng-click="nextPage()"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlPages && model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != null "><a
                                                href="#">&gt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlPages || model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage == null"><a
                                                href="#">&gt;&gt;</a></li>
                                        <li
                                            ng-click="endPage()"
                                            ng-if="model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlPages && model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage != null"><a
                                                href="#">&gt;&gt;</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (check_ACL($profile, 'user', 'manage')) {?>
<div ng-if="model.hidden.showModalResetPassword">
    <div ng-include="'/USR0110'"
        ng-controller="USR0110Ctrl" ng-init="init()">
    </div>
</div>
<?php }?>