<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"> </span>
                <?php echo DAS0150_LABEL_WORKING_SCHEDULE; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-user-search create-table">
                    <tbody>
                    <tr>
                        <td class="title">
                            <?php echo DAS0150_LABEL_BU; ?>
                        </td>
                        <td>
                            <div>:
                                <select
                                    chosen-select="model.form.DAS0150InitOutputModel.productTypeInfo" chosen-width="400px"
                                    ng-model="model.form.DAS0150SearchInputModel.productTypeId"
                                    ng-options="item.product_type_id as item.product_type_name for item in model.form.DAS0150InitOutputModel.productTypeInfo">
                                </select>
                            </div>
                        </td>

                        <td class="title">
                            <?php echo DAS0150_LABEL_DATE; ?>
                        </td>
                        <td style="display: flex;vertical-align: middle;line-height: 30px;">
                            <span>:</span>
                            <div class="datepicker"
                                 ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
                                <datepicker date-id="startDate"
                                            date-value="model.form.DAS0150SearchInputModel.startDate"></datepicker>

                            </div>
                            <span>&nbsp;~&nbsp;</span>

                            <div class="datepicker"
                                 ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
                                <datepicker date-id="endDate"
                                            date-value="model.form.DAS0150SearchInputModel.endDate"></datepicker>

                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-action-search">
                    <button ng-click="searchData()" class="btn btn-normal btn-sm btn-width-default">
                        <?php echo DAS0150_BUTTON_SEARCH; ?>
                    </button>
                </div>
            </div>

            <div class="result-search">
                <div class="store-list-img"
                     ng-repeat="scheduleResultItem in model.form.DAS0150InitOutputModel.scheduleInfo.scheduleResult">
                    <div class="das-list-date">
                        <h3>{{scheduleResultItem.scheduleDate}}</h3>
                    </div>
                    <div class="das-list-schedule">
                        <table
                            class="list-table product-table table list-user table-striped table-bordered"
                            ng-click="preventClose()">
                            <thead>
                            <tr>
                                <th ng-click="sortCode()" style="width: 20%"><i
                                        ng-if="model.hidden.sortCode==false"
                                        class="fa fa-chevron-up"></i>
                                    <i
                                        ng-if="model.hidden.sortCode==true"
                                        class="fa fa-chevron-down"></i>
                                    <?php echo DAS0150_LABEL_TYPE;?>
                                </th>
                                <th>
                                    <?php echo DAS0150_LABEL_REGISTER_IN_DATE;?>
                                </th>
                                <th ng-click="sortName()" style="width: 40%"><i
                                        ng-if="model.hidden.sortName==false"
                                        class="fa fa-chevron-up"></i>
                                    <i
                                        ng-if="model.hidden.sortName==true"
                                        class="fa fa-chevron-down"></i>
                                    <?php echo DAS0150_LABEL_MR;?>
                                </th>
                                <th ng-click="sortName()" style="width: 40%"><i
                                        ng-if="model.hidden.sortName==false"
                                        class="fa fa-chevron-up"></i>
                                    <i
                                        ng-if="model.hidden.sortName==true"
                                        class="fa fa-chevron-down"></i>
                                    <?php echo DAS0150_LABEL_NOTE;?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr
                                ng-repeat="scheduleItem in scheduleResultItem.schedule">
                                <td class="das-type-schedule-{{scheduleItem.type}}">
                                    {{scheduleItem.type_name}}
                                </td>
                                <td>{{scheduleItem.register_in_date}}</td>
                                <td>{{scheduleItem.salesman_name}}</td>
                                <td>{{scheduleItem.cont_text}}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="paging das-paging" ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != null">
                    <ul class="pagination">
                        <li class="disabled"><span>{{model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.stRow}}-{{model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.edRow}}/{{model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlRow}}</span>
                        </li>
                        <li class="disabled"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == 1 || model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&lt;&lt;</a></li>
                        <li ng-click="startPage()"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != 1 && model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&lt;&lt;</a></li>

                        <li class="disabled"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == 1 || model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&lt;</a></li>
                        <li ng-click="prevPage()"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != 1 && model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&lt;</a></li>

                        <li class="disabled"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlPages || model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&gt;</a></li>
                        <li ng-click="nextPage()"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlPages && model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&gt;</a></li>

                        <li class="disabled"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlPages || model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&gt;&gt;</a></li>
                        <li ng-click="endPage()"
                            ng-if="model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlPages && model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&gt;&gt;</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>