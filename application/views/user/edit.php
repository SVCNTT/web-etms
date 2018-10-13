
<div class="main-container">
    <div class="wrapper-container"  >
        <div class="content-list scrollbarCustom">
            <div class="create-client">
                <div class="breadcrums">
                    <a class="btn btn-warning btn-sm  btn-width-default"
                       href="<?php echo site_url('USR0100');?>">
<!--                        <span class="icon-arrow-left"> </span>-->
                        <?php echo USR0210_BUTTON_BACK;?>
                    </a>

                </div>
                <div class="panel-form">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="icon-pencil"></span>
                                <?php echo USR0210_LABEL_FORM;?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
                                <ul>
                                    <li ng-if="model.hidden.validated.firstName.isErrored == true">
                                        {{model.hidden.validated.firstName.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.lastName.isErrored == true">
                                        {{model.hidden.validated.lastName.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.defaultRoleCd.isErrored == true">
                                        {{model.hidden.validated.defaultRoleCd.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.defaultClientId.isErrored == true">
                                        {{model.hidden.validated.defaultClientId.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.email.isErrored == true">
                                        {{model.hidden.validated.email.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.checkEmail.isErrored == true">
                                        {{model.hidden.validated.checkEmail.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.phone.isErrored == true">
                                        {{model.hidden.validated.phone.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.password.isErrored == true && model.hidden.validated.password.msg!=''">
                                        {{model.hidden.validated.password.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.rePassword.isErrored == true && model.hidden.validated.rePassword.msg!=''">
                                        {{model.hidden.validated.rePassword.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.checkPassword.isErrored == true">
                                        {{model.hidden.validated.checkPassword.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.selectedSalesManager.isErrored == true">
                                        {{model.hidden.validated.selectedSalesManager.msg}}
                                    </li>
                                    <li ng-if="model.hidden.validated.selectedUserLeaders.isErrored == true">
                                        {{model.hidden.validated.selectedUserLeaders.msg}}
                                    </li>
                                </ul>
                            </div>

                            <div class="form-create create-user-form">
                                <div class="group">
                                    <div>
                                        <span><?php echo USR0210_LABEL_FIRSTNAME;?>&nbsp;<span class="required"><?php echo USR0200_LABEL_REQUIRED;?></span></span>:
                                        <input  ng-class="{'validate': model.hidden.validated.firstName.isErrored == true}" ng-model="model.form.USR0210CreateUserInputModel.firstName" type="text" class="form-control-dms"> </td>
                                    </div>
                                    <div>
                                        <span><?php echo USR0210_LABEL_LASTNAME;?>&nbsp;<span class="required"><?php echo USR0200_LABEL_REQUIRED;?></span></span>:
                                        <input ng-class="{'validate': model.hidden.validated.lastName.isErrored == true}" type="text" ng-model="model.form.USR0210CreateUserInputModel.lastName" class="form-control-dms"></td>
                                    </div>
                                    <div class="usercode">
                                        <span><?php echo USR0210_LABEL_USERCODE;?></span>:
                                        <input disabled value="{{model.hidden.userCode}}" type="text" class="form-control-dms" ng-model="model.hidden.userCode">
                                    </div>
                                    <div class="position">
                                        <span><?php echo USR0210_LABEL_POSITION;?>&nbsp;<span class="required"><?php echo USR0200_LABEL_REQUIRED;?></span> </span>:
                                        <select  ng-class="{'validate': model.hidden.validated.defaultRoleCd.isErrored == true}" chosen-select="model.form.USR0210InitDataOutputModel.initData.lstRole" ng-change="searchUserRole()"
                                                 chosen-width="255px" ng-model="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd" data-placeholder="<?php echo USR0210_LABEL_CHOOSE_POSITION;?>"
                                                ng-options="item.roleCd as item.rolName for item in model.form.USR0210InitDataOutputModel.initData.lstRole">
                                        <option></option>
                                        </select>
                                    </div>
                                    <div class="client" ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == -2 || model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == -2 || model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == -2">
                                    <span><?php echo USR0210_LABEL_CLIENT;?>&nbsp;<span class="required"><?php echo USR0200_LABEL_REQUIRED;?></span></span>:
                                        <select chosen-select="model.form.USR0210InitDataOutputModel.initData.lstClient" ng-change="searchUserRole()" ng-class="{'validate': model.hidden.validated.defaultClientId.isErrored == true}"
                                                chosen-width="200px" ng-model="model.form.USR0210InitDataOutputModel.initData.defaultClientId"  data-placeholder="<?php echo USR0210_LABEL_CHOOSE_CLIENT;?>"
                                                ng-options="item.clientId as item.clientName for item in model.form.USR0210InitDataOutputModel.initData.lstClient">
                                        <option></option>
                                        </select>
                                    </div>

                                    <div class="email">
                                    <span><?php echo USR0210_LABEL_EMAIL;?>&nbsp;<span class="required"><?php echo USR0210_LABEL_REQUIRED;?></span> </span>:
                                        <input type="text"  ng-class="{'validate': model.hidden.validated.email.isErrored == true  || model.hidden.validated.checkEmail.isErrored == true}"
                                            class="form-control-dms" ng-model="model.form.USR0210CreateUserInputModel.email" required autofocus>
                                    </div>
                                    <div class="phone">
                                        <span><?php echo USR0210_LABEL_PHONE;?></span>:
                                        <input type="text"   ng-class="{'validate': model.hidden.validated.phone.isErrored == true}"
                                               ng-model="model.form.USR0210CreateUserInputModel.phone" class="form-control-dms">
                                    </div>
                                </div>

                                <div class="group">
                                    <div class="manager"
                                         ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_MOD_CD;?>">
                                        <span><?php echo USR0200_LABEL_REGION;?></span>:
                                        <div class="list-manager scrollbarCustom">
                                            <ul
                                                ng-repeat="item in model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items"
                                                ng-click="chooseArea(item)">
                                                <li ><input type="checkbox" ng-model="item.itemChoose" disabled
                                                            id="area{{item.areaId}}" class="regular-checkbox"><label
                                                        for="area{{item.areaId}}"></label></li>
                                                <li title="{{item.areaName}}">{{item.areaName}}</li>
                                            </ul>

                                        </div>
                                    </div>

                                    <div class="manager" ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_BU_CD;?>">
                                        <span><?php echo USR0210_LABEL_MANAGER;?></span>:
                                        <div class="list-manager scrollbarCustom">
                                            <ul ng-class="{active: itemChoose ==true}"
                                                ng-repeat="item in model.form.USR0210SearchUserResultDto.lstSalesManager"
                                                ng-click="chooseSalesManager(item)">
                                                <li ><input type="checkbox" ng-model="item.itemChoose" disabled
                                                            id="subLeader{{item.userId}}" class="regular-checkbox"><label
                                                        for="subLeader{{item.userId}}"></label></li>
                                                <li title="{{item.userName}}">{{item.userName}}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="region-manager"  ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_SALES_MANAGER_CD;?>">
                                        <span><?php echo USR0200_LABEL_BU;?> <span class="required"><?php echo USR0200_LABEL_REQUIRED;?></span></span>:
                                        <select ng-class="{'validate': model.hidden.validated.selectedUserLeaders.isErrored == true}"
                                                chosen-select="model.form.USR0210SearchUserResultDto.lstUserLeader" chosen-width="255px" ng-change="chooseBU()"
                                                ng-model="model.form.USR0210CreateUserInputModel.selectedUserLeaders"  data-placeholder="<?php echo USR0200_LABEL_CHOOSE_REGION_MANAGER;?>"
                                                ng-options="item.userId as item.userName for item in model.form.USR0210SearchUserResultDto.lstUserLeader">
                                        </select>
                                    </div>

                                    <div class="manager" ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_SALES_MANAGER_CD;?>">
                                        <span><?php echo USR0200_LABEL_MANAGER;?></span>:
                                        <div class="list-manager scrollbarCustom">
                                            <ul ng-class="{active: item.itemChoose ==true}"
                                                ng-repeat="item in model.form.USR0210SearchUserResultDto.lstUserSubLeader"
                                                ng-click="chooseSubLeader(item)">
                                                <li ><input type="checkbox" ng-model="item.itemChoose" disabled
                                                            id="subLeader{{item.userId}}" class="regular-checkbox"><label
                                                        for="subLeader{{item.userId}}"></label></li>
                                                <li title="{{item.userName}}">{{item.userName}}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="region-manager"  ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_REGION_MANAGER_CD;?>">
                                    <span><?php echo USR0200_LABEL_SALES_MANAGER;?>&nbsp;<span class="required"><?php echo USR0210_LABEL_REQUIRED;?></span></span>:
                                        <select ng-class="{'validate': model.hidden.validated.selectedSalesManager.isErrored == true}"
                                            chosen-select="model.form.USR0210SearchUserResultDto.lstSalesManager" chosen-width="255px" ng-change="chooseRegionManager()"
                                            ng-model="model.form.USR0210CreateUserInputModel.selectedSalesManager"  data-placeholder="<?php echo USR0200_LABEL_CHOOSE_SALES_MANAGER;?>"
                                            ng-options="item.userId as item.userName for item in model.form.USR0210SearchUserResultDto.lstSalesManager">
                                        </select>
                                    </div>

                                    <div class="manager" style="padding-top: 0" ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_REGION_MANAGER_CD;?>">
                                        <span><?php echo USR0200_LABEL_PRODUCT;?></span>:
                                        <div class="list-manager scrollbarCustom">
                                            <ul ng-class="{active: itemChoose ==true}"
                                                ng-repeat="item in model.form.USR0210SearchUserResultDto.lstProduct"
                                                ng-click="chooseProduct(item)">
                                                <li ><input type="checkbox" ng-model="item.itemChoose" disabled
                                                            id="product{{item.product_type_name}}" class="regular-checkbox"><label
                                                        for="product{{item.product_type_id}}"></label></li>
                                                <li title="{{item.product_type_name}}">{{item.product_type_name}}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="manager" style="padding-top: 0" ng-show="model.form.USR0210InitDataOutputModel.initData.defaultRoleCd == <?php echo ROLE_REGION_MANAGER_CD;?>">
                                        <span><?php echo USR0200_LABEL_SALESMAN;?></span>:

                                        <select multiple
                                            chosen-select="model.form.USR0210SearchUserResultDto.lstSalesman"
                                            data-placeholder="<?php echo USR0200_LABEL_CHOOSE_SALESMAN;?>"
                                            chosen-width="60%"
                                            ng-model="model.form.USR0210CreateUserInputModel.selectedSalesman"
                                            ng-options="item.salesman_id as item.display_name for item in model.form.USR0210SearchUserResultDto.lstSalesman">
                                        </select>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="btn-group-action">

                    <button ng-click="createUserContinus()"
                            class="btn btn-default btn-sm btn-success  no-width ">
                        <?php echo USR0210_BUTTON_UPDATE_CONTINUE;?>
                    </button>
                </div>

            </div>
        </div>
    </div>


</div>

<input id="userCode" type="hidden" value="<?php echo $user_code;?>" ng-model="model.hidden.userCode">