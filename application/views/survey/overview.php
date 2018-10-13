<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span data-icon="&#xe067;"> </span>
                <?php echo STO0540_LABEL_TITLE; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-user-search create-table">
                    <tr>
                        <td class="title"><?php echo STO0540_LABEL_SALESMAN_CODE; ?></td>
                        <td>
                            <div>:
                                <input type="text" class="form-control-dms" ng-enter="search()"
                                       ng-model="model.form.searchParam.searchInput.salesmanCode"
                                       value='{{model.form.searchParam.searchInput.salesmanCode}}'>
                            </div>
                        </td>
                        <td class="title"><?php echo STO0540_LABEL_SALESMAN_NAME; ?></td>
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
                        <?php echo COMMON_BUTTON_SEARCH; ?>
                    </button>
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
                                    class="fa fa-chevron-down"></i><?php echo STO0540_LABEL_SALESMAN_CODE; ?></th>
                            <th ng-click="sortCode()"><i
                                    ng-if="model.hidden.sortCode==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortCode==true"
                                    class="fa fa-chevron-down"></i><?php echo STO0540_LABEL_SALESMAN_NAME; ?></th>

                            <th ng-click="sortName()"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i><?php echo STO0540_LABEL_SURVEY_OVERVIEW; ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-if="model.form.STO0540SearchDataResult.resultSearch.salInfo.length>0"
                            ng-repeat="salItem in model.form.STO0540SearchDataResult.resultSearch.salInfo">
                            <td><a href="/SAL0300/{{salItem.salesmanCode}}">{{salItem.salesmanCode}}</a></td>
                            <td>{{salItem.salesmanName}}</td>
                            <td>{{salItem.email}}</td>
                        </tr>
                        <!--Empty - Begin-->
                        <tr  ng-if="model.form.STO0540SearchDataResult.resultSearch.salInfo.length == null">
                            <td colspan="7"><?php echo COM0000_EMPTY_RESULT;?></td>
                        </tr>
                        <!--Empty - End-->

                        </tbody>
                    </table>
                    <div class="paging"
                         ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != null">
                        <ul class="pagination">
                            <li class="disabled"><span>{{model.form.STO0540SearchDataResult.resultSearch.pagingInfo.stRow}}-{{model.form.STO0540SearchDataResult.resultSearch.pagingInfo.edRow}}/{{model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlRow}}</span></li>
                            <li class="disabled"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == null "><a
                                    href="#">&lt;&lt;</a></li>
                            <li ng-click="startPage()"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != null "><a
                                    href="#">&lt;&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == null"><a
                                    href="#">&lt;</a></li>
                            <li ng-click="prevPage()"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != null "><a
                                    href="#">&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlPages || model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == null"><a
                                    href="#">&gt;</a></li>
                            <li ng-click="nextPage()"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlPages && model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != null "><a
                                    href="#">&gt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlPages || model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage == null"><a
                                    href="#">&gt;&gt;</a></li>
                            <li ng-click="endPage()"
                                ng-if="model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlPages && model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage != null"><a
                                    href="#">&gt;&gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>