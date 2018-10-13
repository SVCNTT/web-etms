<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"></span>
                <?php echo STO0521_TAB_REPORT_ANSWER;?>
            </h3>
        </div>

        <div class="panel-body">
            <div class="form-create">
                <table
                    class="table list-user-search create-table">
                    <tr>
                        <td class="title">
                            <?php echo STO0521_LABEL_SURVEY;?>
                        </td>
                        <td>
                            <div>:
                                <select ng-change="searchData()"
                                    chosen-select="model.form.STO0521initData.resultInit.surveyList"
                                    data-placeholder="<?php echo STO0521_LABEL_CHOOSE_SURVEY;?>"
                                    chosen-width="200px"
                                    ng-model="model.form.searchParam.survey_id"
                                    ng-options="item.id as item.name for item in model.form.STO0521initData.resultInit.surveyList">
                                </select>
                            </div>
                        </td>

                        <td class="title"><?php echo STO0521_LABEL_STORE_CODE; ?></td>
                        <td>
                            <div>:
                                <input type="text" class="form-control-dms" ng-enter="search()"
                                       ng-model="model.form.searchParam.store_code"
                                       value='{{model.form.searchParam.store_code}}'>
                            </div>
                        </td>

                        <td class="title"><?php echo STO0521_LABEL_SALESMAN_CODE; ?></td>
                        <td>
                            <div>:
                                <input type="text" class="form-control-dms" ng-enter="search()"
                                       ng-model="model.form.searchParam.mr_code"
                                       value='{{model.form.searchParam.mr_code'>
                            </div>
                        </td>
                    </tr>

                </table>
                <div class="btn-action-search">
                    <button
                        class="btn btn-normal btn-sm btn-width-default"
                        ng-click="searchData()">
                        <?php echo STO0521_BUTTON_SEARCH;?>
                    </button>

                    <button
                        class="btn btn-success btn-sm btn-width-default"
                        ng-click="exportData()" ng-disabled="model.form.searchParam.survey_id == 0 || model.form.searchParam.survey_id == null">
                        <?php echo COMMON_BUTTON_EXPORT;?>
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
                            <th><?php echo STO0521_LABEL_ID;?></th>
                            <th style="width: 20%">
                                <?php echo STO0521_LABEL_STORE_CODE;?>
                            </th>
<!--                            <th style="width: 20%">-->
<!--                                --><?php //echo STO0521_LABEL_STORE_NAME;?>
<!--                            </th>-->
                            <th style="width: 20%">
                                <?php echo STO0521_LABEL_SALESMAN_CODE;?>
                            </th>
<!--                            <th style="width: 20%">-->
<!--                                --><?php //echo STO0521_LABEL_SALESMAN_NAME;?>
<!--                            </th>-->
                            <th>
                                <?php echo STO0521_LABEL_CREATED_DATE;?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            ng-repeat="item in model.form.resultSearch.answerList">
                            <td><a href="/STO0523/detail/{{item.survey_id}}/{{item.id}}/{{item.token}}" target="_blank">{{item.id}}</a></td>
                            <td>{{item.store_code}}</td>
<!--                            <td>{{item.store_name}}</td>-->
                            <td>{{item.salesman_code}}</td>
<!--                            <td>{{item.salesman_name}}</td>-->
                            <td>{{item.cre_ts}}</td>
                        </tr>

                        <!--Empty - Begin-->
                        <tr ng-if="model.form.resultSearch.pagingInfo.ttlRow == 0">
                            <td colspan="4"><?php echo COM0000_EMPTY_RESULT;?></td>
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