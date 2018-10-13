<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"></span>
                <?php echo REC0100_TAB_REPORT;?>
            </h3>
        </div>

        <div class="panel-body">
            <div class="form-create">
                <table
                    class="table list-user-search create-table">
                    <tr>
                        <td class="title">
                            <?php echo REC0200_LABEL_MR;?>
                        </td>
                        <td>
                            <div>:
                                <select
                                    chosen-select="model.form.REC0210initData.resultInit.mr"
                                    data-placeholder="<?php echo REC0200_LABEL_CHOOSE_MR;?>"
                                    chosen-width="200px"
                                    ng-model="model.form.searchParam.mr_id"
                                    ng-options="item.salesman_id as item.salesman_name for item in model.form.REC0210initData.resultInit.mr">
                                </select>
                            </div>
                        </td>

                        <td class="title">
                            <?php echo REC0200_LABEL_STORE;?>
                        </td>
                        <td>
                            <div>:
                                <select
                                    chosen-select="model.form.REC0210initData.resultInit.store"
                                    data-placeholder="<?php echo REC0200_LABEL_CHOOSE_STORE;?>"
                                    chosen-width="200px"
                                    ng-model="model.form.searchParam.store_id"
                                    ng-options="item.store_id as item.store_name for item in model.form.REC0210initData.resultInit.store">
                                </select>
                            </div>
                        </td>

                        <td class="title">
                            <?php echo REC0200_LABEL_PRODUCT_GROUP;?>
                        </td>
                        <td>
                            <div>:
                                <select
                                    chosen-select="model.form.REC0210initData.resultInit.product_group"
                                    data-placeholder="<?php echo REC0200_LABEL_CHOOSE_PRODUCT_GROUP;?>"
                                    chosen-width="200px"
                                    ng-model="model.form.searchParam.product_group_id"
                                    ng-options="item.product_group_id as item.product_group_name for item in model.form.REC0210initData.resultInit.product_group">
                                </select>
                            </div>
                        </td>

                        <td class="title">
                            <?php echo REC0200_LABEL_VALIDATE;?>
                        </td>
                        <td>
                            <div>:
                                <select
                                    chosen-select="model.form.REC0210initData.resultInit.validate"
                                    data-placeholder="<?php echo REC0200_LABEL_CHOOSE_VALIDATE;?>"
                                    chosen-width="200px"
                                    ng-model="model.form.searchParam.validate"
                                    ng-options="item.validate_id as item.validate_name for item in model.form.REC0210initData.resultInit.validate">
                                </select>
                            </div>
                        </td>
                    </tr>

                </table>
                <div class="btn-action-search">
                    <button
                        class="btn btn-normal btn-sm btn-width-default"
                        ng-click="searchData()">
                        <?php echo REC0200_BUTTON_SEARCH;?>
                    </button>
                </div>


            </div>
            <div class="result-search">
                <div class="table-region">

                    <table
                        class="list-table product-table table list-user table-striped table-bordered"
                        ng-click="preventClose()">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th ng-click="sortCode()" style="width: 20%"><i
                                    ng-if="model.hidden.sortCode==false"
                                    class="fa fa-chevron-up"></i>
                                <i
                                    ng-if="model.hidden.sortCode==true"
                                    class="fa fa-chevron-down"></i>
                                <?php echo REC0200_LABEL_MR;?>
                            </th>

                            <th ng-click="sortName()" style="width: 20%"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i>
                                <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>
                                <?php echo REC0200_LABEL_STORE;?>
                            </th>
                            <th ng-click="sortName()" style="width: 20%"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i>
                                <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>
                                <?php echo REC0200_LABEL_PRODUCT_GROUP;?>
                            </th>
                            <th ng-click="sortName()" style="width: 15%"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i>
                                <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>
                                <?php echo REC0200_LABEL_VALIDATE;?>
                            </th>
							 <th ng-click="sortName()" style="width: 15%"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i>
                                <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>
                                <?php echo REC0200_LABEL_CREATE_DATE;?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            ng-repeat="item in model.form.resultSearch.callRecord">
                            <td><a href="/REC0230/{{item.call_record_id}}/{{item.token}}">{{item.call_record_id}}</a></td>
                            <td>{{item.mr_name}}</td>
                            <td>{{item.store_name}}</td>
                            <td>{{item.product_group_name}}</td>
                            <td>{{item.validate_name}}</td>
                            <td>
                                {{item.cre_ts}}
                                <?php if (check_ACL($profile, 'rec', 'delete')) {?>
                                <span ng-click="" title="<?php echo REC0200_TIP_DELETE_RECORD;?>"
                                      class="delete-user pull-right icon-close dropdown-toggle"
                                      data-toggle="dropdown">
                                </span>

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
                                            ng-click="deleteRecord(item)">
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
                        <tr ng-if="model.form.resultSearch.pagingInfo.ttlRow == 0">
                            <td colspan="7"><?php echo COM0000_EMPTY_RESULT;?></td>
                        </tr>
                        <!--Empty - End-->

                        </tbody>
                    </table>
                    <div class="paging" ng-if="model.form.resultSearch.pagingInfo.ttlRow != 0">
                        <ul class="pagination">
                            <li class="disabled"><span>{{model.form.resultSearch.pagingInfo.stRow}}-{{model.form.resultSearch.pagingInfo.edRow}}/{{model.form.resultSearch.pagingInfo.ttlRow}}</span></li>
                            <li class="disabled"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage == 1 || model.form.resultSearch.pagingInfo.crtPage == null "><a
                                    href="#">&lt;&lt;</a></li>
                            <li
                                ng-click="startPage()"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage != 1 && model.form.resultSearch.pagingInfo.crtPage != null "><a
                                    href="#">&lt;&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage == 1 || model.form.resultSearch.pagingInfo.crtPage == null"><a
                                    href="#">&lt;</a></li>
                            <li
                                ng-click="prevPage()"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage != 1 && model.form.resultSearch.pagingInfo.crtPage != null "><a
                                    href="#">&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage == model.form.resultSearch.pagingInfo.ttlPages || model.form.resultSearch.pagingInfo.crtPage == null"><a
                                    href="#">&gt;</a></li>
                            <li
                                ng-click="nextPage()"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage != model.form.resultSearch.pagingInfo.ttlPages && model.form.resultSearch.pagingInfo.crtPage != null "><a
                                    href="#">&gt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage == model.form.resultSearch.pagingInfo.ttlPages || model.form.resultSearch.pagingInfo.crtPage == null"><a
                                    href="#">&gt;&gt;</a></li>
                            <li
                                ng-click="endPage()"
                                ng-if="model.form.resultSearch.pagingInfo.crtPage != model.form.resultSearch.pagingInfo.ttlPages && model.form.resultSearch.pagingInfo.crtPage != null"><a
                                    href="#">&gt;&gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>