<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"> </span><?php echo STO0530_LABEL_TITLE; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-store-search">
                    <tr>

                        <td class="title" style="width: 15% !important;"> <?php echo STO0530_LABEL_STORE_CODE; ?>    </td>
                        <td>
                            <div>:
                                <input type="text" class="form-control-dms width200" ng-enter="search()"
                                       ng-model="model.hidden.storeCode" value='{{model.hidden.storeCode}}'>
                            </div>
                        </td>

                    </tr>

                </table>
                <div class="btn-action-search">
                    <button class="btn btn-normal btn-sm btn-width-default" ng-click="search()">
                        <?php echo COMMON_BUTTON_SEARCH; ?>
                    </button>

                    <?php if (check_ACL($profile, 'store', 'im_customer_survey')) { ?>
                        <button ng-click="importStoreSurvey()" class="btn btn-sm  btn-info btn-width-default" style="width: 140px;">
                            <span> </span>
                            <?php echo STO0530_BUTTON_IMPORT_CUSTOMER; ?>
                        </button>
                    <?php } ?>
                </div>


            </div>
            <div class="result-search">
                <div class="table-region">
                    <table
                        class="list-table product-table table list-store table-striped table-bordered"
                        >
                        <thead>
                        <tr>
                            <th><?php echo STO0530_LABEL_STORE_CODE; ?>
<!--                            <th>--><?php //echo STO0530_LABEL_STORE_NAME; ?>
                            <th><?php echo STO0530_LABEL_PRODUCT; ?>
                            <th><?php echo STO0530_LABEL_SUB_GROUP; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="storeItem in model.form.STO0100InitDataModel.resultSearch.storeInfo">

                            <td>{{storeItem.storeCode}}</td>
<!--                            <td>{{storeItem.storeName}}</a></td>-->
                            <td>
                                <label ng-repeat="(key, productItem) in storeItem.product_list">
                                    <b ng-if="key != 0">, </b>
                                    {{productItem.product}}
                                </label>
                            </td>
                            <td>
                                {{storeItem.subGroup}}

                                <span
                                    class="view-salesman pull-right icon-users"
                                    title="<?php echo STO0530_TITLE_VIEW_SALESMAN; ?>"
                                    ng-click="showModalSalesman(storeItem)"></span>

                                <span class="delete-store pull-right icon-close dropdown-toggle"
                                      data-toggle="dropdown"></span>

                                <div class="popover-confirm dropdown-menu">
                                    <div class="arrow"></div>
                                    <div class="content-confirm">
                                        {{model.hidden.deleteConfirm.message}}
                                    </div>
                                    <div class="button-group-action text-center">

                                        <button class="btn  btn-default btn-info btn-xs"
                                                ng-click="deleteStore(storeItem)">
                                            <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                        </button>
                                        <button class="btn btn-default btn-danger btn-xs">
                                            <span><?php echo COMMON_BUTTON_CANCEL; ?></span>
                                        </button>

                                    </div>
                                </div>
                            </td>

                        </tr>
                        <!--Empty - Begin-->
                        <tr ng-if="model.form.STO0100InitDataModel.resultSearch.storeInfo.length == null">
                            <td colspan="3"><?php echo COM0000_EMPTY_RESULT; ?></td>
                        </tr>
                        <!--Empty - End-->

                        </tbody>
                    </table>
                    <div class="paging"
                         ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                        <ul class="pagination">
                            <li class="disabled"><span>{{model.form.STO0100InitDataModel.resultSearch.pagingInfo.stRow}}-{{model.form.STO0100InitDataModel.resultSearch.pagingInfo.edRow}}/{{model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlRow}}</span>
                            </li>
                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null ">
                                <a href="#">&lt;&lt;</a></li>
                            <li ng-click="startPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                <a href="#">&lt;&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                <a href="#">&lt;</a></li>
                            <li ng-click="prevPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                <a href="#">&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                <a href="#">&gt;</a></li>
                            <li ng-click="nextPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                <a href="#">&gt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages ||model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                <a href="#">&gt;&gt;</a></li>
                            <li ng-click="endPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                                <a href="#">&gt;&gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
