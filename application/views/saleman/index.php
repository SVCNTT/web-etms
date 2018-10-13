<div class="main-container">
    <div class="wrapper-container">
        <div class="content-list scrollbarCustom">
            <div class="group-action"></div>

            <div class="panel-form">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span data-icon="&#xe067;"> </span>
                            <?php echo SAL0100_LABEL_FORM; ?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-create">
                            <table class="table list-user-search create-table">
                                <tr>
                                    <td class="title"><?php echo SAL0100_LABEL_STATUS; ?></td>
                                    <td>
                                        <div>:

                                            <select
                                                chosen-select="model.form.SAL0100InitDataModel.initData.usrStsLst"
                                                chosen-width="170px"
                                                data-placeholder="<?php echo SAL0100_LABEL_CHOOSE_STATUS; ?>"
                                                ng-model="model.form.searchParam.searchInput.salesmanSts"
                                                ng-options="item.codeCd as item.dispText for item in model.form.SAL0100InitDataModel.initData.usrStsLst">
                                            </select>
                                        </div>
                                    </td>
                                    <td class="title"><?php echo SAL0100_LABEL_CODE; ?></td>
                                    <td>
                                        <div>:
                                            <input type="text" class="form-control-dms" ng-enter="search()"
                                                ng-model="model.form.searchParam.searchInput.salesmanCode"
                                                value='{{model.form.searchParam.searchInput.salesmanCode}}'>
                                        </div>
                                    </td>
                                    <td class="title"><?php echo SAL0100_LABEL_NAME; ?></td>
                                    <td>
                                        <div>:
                                            <input type="text" class="form-control-dms" ng-enter="search()"
                                                ng-model="model.form.searchParam.searchInput.salesmanName"
                                                value='{{model.form.searchParam.searchInput.salesmanName'>
                                        </div>
                                    </td>

                                </tr>
                            </table>
                            <div class="btn-action-search">
                                <button class="btn btn-normal btn-sm btn-width-default"
                                    ng-click="search()">
                                    <?php echo SAL0100_BUTTON_SEARCH; ?>
                                </button>

                                <?php if (check_ACL($profile, 'sale', 'import')) {?>
                                <button ng-click="importMrs()" class="btn btn-default btn-sm  btn-info btn-width-default">
                                    <span> </span>
                                    <?php echo SAL0100_BUTTON_CHOOSE_FILE;?>
                                </button>
                                <?php }?>

                            </div>


                        </div>
                        <div class="result-search">
                            <div class="table-region">
                                <table
                                    class="list-table product-table table  list-sale table-striped table-bordered"
                                    ng-click="preventClose()">
                                    <thead>
                                        <tr>
                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0100_LABEL_AVARTAR; ?></th>
                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0100_LABEL_CODE; ?></th>
                                            <th ng-click="sortCode()"><i
                                                ng-if="model.hidden.sortCode==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortCode==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0100_LABEL_NAME; ?></th>

                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0100_LABEL_EMAIL; ?></th>
                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0100_LABEL_PHONE; ?></th>
                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0320_LABEL_SALE_GENDER; ?></th>
                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo SAL0100_LABEL_STARTDAY; ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-if="model.form.SAL0100InitDataModel.resultSearch.salInfo.length>0"
                                            ng-repeat="salItem in model.form.SAL0100InitDataModel.resultSearch.salInfo">
                                            <td>  <a  ng-if="salItem.imagePath" class="image-sale" href="{{salItem.imagePathUrl}}" data-lightbox="billImage"> <img ng-if="salItem.imagePathUrl"
                                                ng-src="{{salItem.imagePathUrl}}"></a>
                                            </td>
                                            <td><a
                                                href="/SAL0300/{{salItem.salesmanCode}}">{{salItem.salesmanCode}}</a></td>
                                            <td>{{salItem.salesmanName}}
                                            </td>
                                            <td>{{salItem.email}}</td>
                                            <td>{{salItem.mobile}}</td>

                                            <td>{{salItem.gender === '1'? "Male": "Female"}}</td>
                                            <td>{{salItem.activeDate}} 
                                          
                                                <?php if (check_ACL($profile, 'sale', 'delete')) {?>
                                                <span data-icon="&#xe082;" title="<?php echo SAL0100_TIP_DELETE;?>"
                                                                    class="delete-mr pull-right dropdown-toggle"
                                                                    data-toggle="dropdown"></span>
                                                <?php }?>

                                                <?php if (check_ACL($profile, 'sale', 'active')) {?>
                                                <span ng-if="salItem.salesmanSts == 0"
                                                                    class="active-mr fa fa-unlock-alt pull-right"
                                                                    ng-click="activeSal(salItem)"></span>                                                                    
                                                <?php }?>

                                                <?php if (check_ACL($profile, 'sale', 'delete')) {?>
                                            <div class="popover-confirm dropdown-menu">
                                                    <div class="arrow"></div>
                                                    <div class="content-confirm">
                                                        {{model.hidden.deleteConfirm.message}}
                                                    </div>
                                                    <div class="button-group-action text-center">

                                                        <button
                                                            class="btn btn-default btn-info btn-xs"
                                                            ng-click="deleteSale(salItem)">
                                                            <span><?php echo  COMMON_BUTTON_OK; ?>
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
                                        <tr  ng-if="model.form.SAL0100InitDataModel.resultSearch.salInfo.length == null">
                                            <td colspan="7"><?php echo COM0000_EMPTY_RESULT;?></td>
                                        </tr>
                                        <!--Empty - End-->

                                    </tbody>
                                </table>
                                <div class="paging"
                                    ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                                    <ul class="pagination">
                                        <li class="disabled"><span>{{model.form.SAL0100InitDataModel.resultSearch.pagingInfo.stRow}}-{{model.form.SAL0100InitDataModel.resultSearch.pagingInfo.edRow}}/{{model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlRow}}</span></li>
                                        <li class="disabled"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == null "><a
                                            href="#">&lt;&lt;</a></li>
                                        <li ng-click="startPage()"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != null "><a
                                            href="#">&lt;&lt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == null"><a
                                            href="#">&lt;</a></li>
                                        <li ng-click="prevPage()"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != null "><a
                                            href="#">&lt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == null"><a
                                            href="#">&gt;</a></li>
                                        <li ng-click="nextPage()"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != null "><a
                                            href="#">&gt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage == null"><a
                                            href="#">&gt;&gt;</a></li>
                                        <li ng-click="endPage()"
                                            ng-if="model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage != null"><a
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
<div  ng-if="model.hidden.showImportMrs" ng-include="'/SAL0110'"  ng-controller="SAL0110Ctrl" ng-init="init()" > </div> <!-- import store -->
