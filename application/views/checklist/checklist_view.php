<div class="main-container">
    <div class="wrapper-container">
        <div class="content-list scrollbarCustom">
            <div class="create-client">
                <div class="breadcrums">
                    <a class="btn btn-warning btn-sm  btn-width-default" href="<?php echo site_url('CHE0100'); ?>">
                        <?php echo CHE0200_BUTTON_BACK; ?>
                    </a>
                </div>

                <!-- 	START CHECKLIST   -->
                <div class="panel-form" id="checklist">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="<?php echo $CHE0200_LABEL_FORM_ICON; ?>"
                                      style="padding-right: 5px;"> </span>
                                <?php echo $CHE0200_LABEL_FORM; ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-create create-store">
                                <!-- Start create checklist -->
                                <input id="checklistId"
                                       ng-model="model.form.CHE0200CreateChecklistInputModel.checklistId"
                                       ng-init="model.form.CHE0200CreateChecklistInputModel.checklistId='<?php echo $checklistId; ?>'"
                                       value="<?php echo $checklistId; ?>"
                                       type="hidden" class="form-control-dms"">
                                <div class="group">
                                    <div class="checklistName">
                                        <span><?php echo CHE0200_LABEL_CHECKLIST_NAME; ?></span> :<input
                                            ng-class="{'validate': model.hidden.validated.coachingName.isErrored == true}"
                                            ng-model="model.form.CHE0200CreateChecklistInputModel.checklistName"
                                            ng-init="model.form.CHE0200CreateChecklistInputModel.checklistName='<?php echo $checklistName; ?>'"
                                            type="hidden" class="form-control-dms">
                                        <span style="margin-left:5px;"><?php echo $checklistName; ?></span>
                                    </div>
                                    <div class="coa-startday">
                                        <span><?php echo CHE0200_LABEL_CHECKLIST_STARTDAY; ?></span> :
                                        <span style="margin-left:5px;"><?php echo $startDay; ?></span>
                                    </div>
                                    <div class="coa-endday">
                                        <span><?php echo CHE0200_LABEL_CHECKLIST_ENDDAY; ?></span> :
                                        <span style="margin-left:5px;"><?php echo $endDay; ?></span>

                                    </div>
                                </div>
                                <!-- End create checklist -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- 	END CHECKLIST   -->

                <!-- 	START VIEW INVITED -->
                <div class="panel-form" id="assign-regional-mark-user">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="icon-list"> </span>
                                <?php echo CHE0400_LABEL_INVITED_LIST; ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="group-search" style="margin-left: 10px; margin-right: 10px;">
                                <div class="condition-search" style="padding-top: 5px;">

                                    <ul>
                                        <li><span> <?php echo CHE0400_LABEL_INVITED_LIST_NAME; ?>: </span>
                                            <input type="text" class="form-control-dms width-200"
                                                ng-model="model.form.CHE0100InputDataModel.searchInput.doctorName" />

                                        <li><span style="margin-left: 25px;">
                                                <?php echo CHE0400_LABEL_INVITED_LIST_HOSPITAL; ?>:
							                </span><input type="text" class="form-control-dms width-200"
                                                ng-model="model.form.CHE0100InputDataModel.searchInput.hospital">
                                        </li>

                                        <li>
                                            <div style="width: 170px;  text-align:center;">
                                                <button class="btn btn-normal btn-sm btn-width-default"
                                                        style="margin-top: -5px;"
                                                        ng-click="searchUserMark()">
                                                    <?php echo CHE0100_BUTTON_SEARCH; ?>
                                                </button>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                            </div>
                            <div class="result-search">
                                <div class="table-region">

                                    <table class="list-table table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_NAME; ?></th>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_TITLE; ?></th>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_POSITION; ?></th>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_SPECIALTY; ?></th>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_DEPARTMENT; ?></th>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_HOSPITAL; ?></th>
                                            <th><?php echo CHE0400_LABEL_INVITED_LIST_INVITED_BY; ?></th>
                                            <th>
                                            <input ng-change="chooseAllChecklist()"
												ng-model="model.form.chooseAllChecklist" type="checkbox"
												id="checkboxAllPage{{model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage}}"
												class="regular-checkbox" /><label
												for="checkboxAllPage{{model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage}}"></label>
												
												<?php echo CHE0400_LABEL_INVITED_LIST_ATTENDANCE; ?>
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-if="model.form.CHE0100InitDataModel.resultSearch.cheInfo.length > 0"
                                            ng-repeat="item in model.form.CHE0100InitDataModel.resultSearch.cheInfo">
                                            <td><label>{{item.doctorName}}</label></td>
                                            <td><label>{{item.title}}</label></td>
                                            <td><label>{{item.position}}</label></td>
                                            <td><label>{{item.specialty}}</label></td>
                                            <td><label>{{item.department}}</label></td>
                                            <td><label>{{item.hospital}}</label></td>
                                            <td><label>{{item.invitedBy}}</label></td>
                                            <td><input type="checkbox" id="checklist{{item.customerEventId}}"
										ng-change="chooseChecklist(item)" ng-model="item.choose"
										class="regular-checkbox" /><label
										for="checklist{{item.customerEventId}}"></label></td>

                                        </tr>
                                        <!--Empty - Begin-->
                                        <tr ng-if="model.form.CHE0100InitDataModel.resultSearch.cheInfo.length == null">
                                            <td colspan="8"><?php echo COM0000_EMPTY_RESULT; ?></td>
                                        </tr>
                                        <!--Empty - End-->
                                        </tbody>
                                    </table>
                                    <div class="paging"
                                         ng-if="model.form.CHE0100InitDataModel.resultSearch.cheInfo.length > 0"
                                        >
                                        <ul class="pagination">
                                            <li class="disabled"><span>{{model.form.CHE0100InitDataModel.resultSearch.pagingInfo.stRow}}-{{model.form.CHE0100InitDataModel.resultSearch.pagingInfo.edRow}}/{{model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlRow}}</span>
                                            </li>
                                            <li class="disabled"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == null ">
                                                <a
                                                    href="#">&lt;&lt;</a></li>
                                            <li ng-click="startPageUserMark()"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                                <a
                                                    href="#">&lt;&lt;</a></li>

                                            <li class="disabled"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                                <a
                                                    href="#">&lt;</a></li>
                                            <li ng-click="prevPageUserMark()"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                                <a
                                                    href="#">&lt;</a></li>

                                            <li class="disabled"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                                <a
                                                    href="#">&gt;</a></li>
                                            <li ng-click="nextPageUserMark()"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                                <a
                                                    href="#">&gt;</a></li>

                                            <li class="disabled"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                                <a
                                                    href="#">&gt;&gt;</a></li>
                                            <li ng-click="endPageUserMark()"
                                                ng-if="model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                                                <a
                                                    href="#">&gt;&gt;</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 	END VIEW INVITED -->


                <div class="btn-group-action">
                    <button id="finish_coaching" ng-click="viewListChecklist()"
                            class="btn btn-default btn-sm btn-success btn-width-default ">
                        <?php echo CHE0100_BUTTON_FINISH; ?>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>