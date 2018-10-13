<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<div class="create-client">
				<div class="breadcrums">
					<a class="btn btn-warning btn-sm  btn-width-default" href="<?php echo site_url('CHE0100');?>">
                        <?php echo CHE0200_BUTTON_BACK; ?>
					</a>

				</div>
				<div class="panel-form"   id="checklist">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
                                <span class="<?php echo $CHE0200_LABEL_FORM_ICON; ?>"
                                      style="padding-right: 5px;"> </span>
								<?php echo $CHE0200_LABEL_FORM; ?>
							</h3>
						</div>
						<div class="panel-body">
                            <div class="alert alert-danger" role="alert"
                                 ng-if="model.hidden.validated.isErrored == true">
								    <ul>
								    	<li ng-if="model.hidden.validated.checklistName.isErrored == true">
								    	 	{{model.hidden.validated.checklistName.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.checklistStartday.isErrored == true">
								    	 	{{model.hidden.validated.checklistStartday.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.checklistEndday.isErrored == true">
								    	 	{{model.hidden.validated.checklistEndday.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.checklistMoreEndDay.isErrored == true">
								    	 	{{model.hidden.validated.checklistMoreEndDay.msg}}
									    </li>
								    </ul>
								    
								</div>
								<div class="form-create create-store">
                                <input id="checklistId"
                                       ng-model="model.form.CHE0200CreateChecklistInputModel.checklistId"
								ng-init="model.form.CHE0200CreateChecklistInputModel.checklistId='<?php echo $checklistId; ?>'"
                                       type="hidden" class="form-control-dms"
                                       value="{{model.form.CHE0200CreateChecklistInputModel.checklistId}}">
												
									<input id="coachingTemplateSectionId" ng-model="model.form.coachingTemplateSectionId"
                                       type="hidden" class="form-control-dms"
                                       value="{{model.form.coachingTemplateSectionId}}">
									<!-- Start create checklist -->
									<div class="group">
										<div class="checklistName">
											<span><?php echo CHE0200_LABEL_CHECKLIST_NAME; ?> <span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
                                        :<input
                                            ng-class="{'validate': model.hidden.validated.checklistName.isErrored == true}"
												ng-model="model.form.CHE0200CreateChecklistInputModel.checklistName"
												ng-init="model.form.CHE0200CreateChecklistInputModel.checklistName='<?php echo $checklistName; ?>'"
												type="text" class="form-control-dms">
										</div> 
							             <div class="coa-startday">
							                <span><?php echo CHE0200_LABEL_CHECKLIST_STARTDAY; ?> <span
							                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
                                        :
                                        <div class="datepicker"
                                             ng-class="{'validate': model.hidden.validated.checklistStartday.isErrored == true}"
															ng-class="{'error': model.hidden.validation.checklistStartday.isErrored == true}">
															<datepicker date-id="checklistStartday" style="width:200px"  
															ng-init="model.form.CHE0200CreateChecklistInputModel.checklistStartday='<?php echo $startDay; ?>'"
																date-value="model.form.CHE0200CreateChecklistInputModel.checklistStartday"></datepicker>
							
											</div>
							            </div>
							             <div class="coa-endday">
							                <span><?php echo CHE0200_LABEL_CHECKLIST_ENDDAY; ?> <span
							                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
                                        :
                                        <div class="datepicker" style="width:200px"
                                             ng-class="{'validate': model.hidden.validated.checklistEndday.isErrored == true}"
															ng-class="{'error': model.hidden.validation.checklistEndday.isErrored == true}">
															<datepicker date-id="checklistEndday"
															ng-init="model.form.CHE0200CreateChecklistInputModel.checklistEndday='<?php echo $endDay; ?>'"
																date-value="model.form.CHE0200CreateChecklistInputModel.checklistEndday"></datepicker>
							
											</div>
							            </div>
									</div>
									<!-- End create checklist --> 
									 
								</div>
						</div>
					</div>
				</div>
                <div id="assign-checklist" style="display: none">
                    <div class="content" style="padding-left: 0px; position: relative">
                        <div class="tab-content">
                            <div class="tabs">
                                <ul>
                                    <li
                                        ng-class="{'active': model.activeTab == 1}"
                                        ng-click="model.activeTab=1">
                                        <?php echo CHE0230_LABEL_MR_NAME; ?>
                                    </li>
                                    <li
                                        ng-class="{'active': model.activeTab == 2}"
                                        ng-click="model.activeTab =2">
                                        <?php echo CHE0230_LABEL_RM_NAME; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="content-tab-product scrollbarCustom"
                                 ng-if="model.activeTab==1">

                                <div class="manage-staff store-tab" style="width: 100%;">
	<div class="panel-form" style="width:50%; float:left">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"></span>
                                                    <?php echo CHE0230_LABEL_ASSIGN_MR_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="group-search" style="margin-left: 10px;margin-right: 10px;">
					<div class="condition-search">
						<ul>
							<li>
                                <span><?php echo CHE0230_LABEL_ASSIGN_CODE;?></span>:
                                <input type="text" class="form-control-dms width-190"
                                    ng-enter="searchUserAssign()"
								ng-model="model.form.CHE0330SearchDataUserAssign.searchInput.userCode">
                            </li>
                                                            <li>
                                <span><?php echo CHE0230_LABEL_ASSIGN_NAME;?></span>:
                                <input type="text" class="form-control-dms width-190"
                                    ng-enter="searchUserAssign()"
								ng-model="model.form.CHE0330SearchDataUserAssign.searchInput.userName">
                            </li>
						</ul>

					</div>
					<div class="action-search">
						<button class="btn btn-normal btn-sm btn-width-default"
							ng-click="searchUserAssign()">
							<?php echo SAL0330_BUTTON_SEARCH; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="table-region">
							 
						<table
							class="list-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo CHE0230_LABEL_ASSIGN_CODE; ?></th>
									<th><?php echo CHE0230_LABEL_ASSIGN_NAME; ?></th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr	ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length> 0"
								ng-repeat="item in model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.userInfo">
									<td>
										<label>{{item.userCode}}</label>
									</td>
									<td>
											<label>{{item.salesmanName}}</label>
									</td>
									<td>
									<div style="position:relative;">
                                                        <span
                                                            class=" icon-close delete-product pull-right dropdown-toggle"
                                                            data-toggle="dropdown" style="margin-top: 5px"></span>

										<div class="popover-confirm dropdown-menu">
											<div class="arrow"> </div>
											<div class="content-confirm">
												{{model.hidden.deleteConfirm.message}} 
											</div>
											<div class="button-group-action text-center">
                                                                                <button class="btn  btn-default btn-info btn-xs"
                                                                                        ng-click="removeUser(item)">
                                                    <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                </button>
												<button class="btn btn-default btn-danger btn-xs">
													<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
												</button>
											</div>
										</div>
										</div>
									</td>

								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length == null">
                                                                <td colspan="3"><?php echo COM0000_EMPTY_RESULT; ?></td>
                                </tr>
                                <!--Empty - End-->

								
							</tbody>
						</table>
                                                        <div class="paging"
                                                             ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length > 0 "
							>
							<ul class="pagination">
                                                                <li class="disabled"><span>{{model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.stRow}}-{{model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.edRow}}/{{model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow}}</span>
                                                                </li>
								<li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == 1 || model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null ">
                                                                    <a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageUserAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != 1 && model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null ">
                                                                    <a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == 1 || model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null">
                                                                    <a
									href="#">&lt;</a></li>
								<li ng-click="prevPageUserAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != 1 && model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null ">
                                                                    <a
									href="#">&lt;</a></li>

								<li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages || model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null">
                                                                    <a
									href="#">&gt;</a></li>
								<li ng-click="nextPageUserAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages && model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null ">
                                                                    <a
									href="#">&gt;</a></li>

								<li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages || model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null">
                                                                    <a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageUserAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages && model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null">
                                                                    <a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>				
                                    <div class="panel-form" style="width:49%; display:inline-block;">
		<div class="panel panel-primary">
			<div class="panel-heading">
			</div>
			<div class="panel-body">  
				<div class="group-search"  style="margin-left: 10px;margin-right: 10px;">
					<div class="condition-search">
						<ul>
							<li>
                                <span><?php echo CHE0230_LABEL_ASSIGN_CODE;?></span>:
                                <input type="text" class="form-control-dms width-190"
                                    ng-enter="searchUserNotAssign()"
								ng-model="model.form.CHE0330SearchDataUserNotAssign.searchInput.userCode">
                            </li>
							
                                                            <li>
                                <span> <?php echo CHE0230_LABEL_ASSIGN_NAME; ?></span>:
                                <input type="text" class="form-control-dms width-190"
                                    ng-enter="searchUserNotAssign()"
                                                                       ng-model="model.form.CHE0330SearchDataUserNotAssign.searchInput.userName">
                                                            </li>
								
						</ul>

					</div>
 					<div class="action-search"> 
                                                        <button class="btn btn-normal btn-sm btn-width-default"
                                                                ng-click="searchUserNotAssign()">
							<?php echo SAL0330_BUTTON_SEARCH; ?>
						</button>
                                                        <button ng-click="addUser()"
                                                                ng-disabled="model.form.listSelectUser.length ==0"
							class="btn btn-default btn-sm  btn-success btn-width-default">
							<?php echo SAL0330_BUTTON_ADD; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="table-region">

						<table class="list-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo CHE0230_LABEL_ASSIGN_CODE; ?></th>
									<th><?php echo CHE0230_LABEL_ASSIGN_NAME; ?></th>
                                                                <th style="text-align: center"><input
                                                                        ng-change="chooseAll()"
										ng-model="model.form.chooseAll" type="checkbox"
										id="checkboxAllPage{{model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage}}"
										class="regular-checkbox" /><label
                                                                        for="checkboxAllPage{{model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage}}"></label>
                                                                </th>
								</tr>
							</thead>
							<tbody>
								<tr ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length > 0"
								ng-repeat="item in model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo">
									<td>
										<label>{{item.userCode}}</label>
									</td>
									<td>
										<label>{{item.salesmanName}}</label>
									</td>
                                                                <td style="text-align: center;"><input type="checkbox"
                                                                                                       id="user{{item.userId}}"
                                                                                                       ng-change="chooseUser(item)"
                                                                                                       ng-model="item.choose"
										class="regular-checkbox" /><label
										for="user{{item.userId}}"></label></td>
								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length == null">
                                    <td colspan="3"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
							</tbody>
						</table>
                                                        <div class="paging"
                                                             ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length > 0"
                                                            >
                                                            <ul class="pagination">
                                                                <li class="disabled"><span>{{model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.stRow}}-{{model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.edRow}}/{{model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow}}</span>
                                                                </li>
                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == 1 || model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null ">
                                                                    <a
                                                                        href="#">&lt;&lt;</a></li>
                                                                <li ng-click="startPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != 1 && model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null ">
                                                                    <a
                                                                        href="#">&lt;&lt;</a></li>

                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == 1 || model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null">
                                                                    <a
                                                                        href="#">&lt;</a></li>
                                                                <li ng-click="prevPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != 1 && model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null ">
                                                                    <a
                                                                        href="#">&lt;</a></li>

                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages || model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null">
                                                                    <a
                                                                        href="#">&gt;</a></li>
                                                                <li ng-click="nextPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages && model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null ">
                                                                    <a
                                                                        href="#">&gt;</a></li>

                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages || model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null">
                                                                    <a
                                                                        href="#">&gt;&gt;</a></li>
                                                                <li ng-click="endPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages && model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null">
                                                                    <a
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
                            <div class="content-tab-product scrollbarCustom"
                                 ng-if="model.activeTab==2">

                                <div class="manage-staff store-tab" style="width: 100%;">
                                    <div class="panel-form" style="width:50%; float:left">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <span class="icon-list"></span>
                                                    <?php echo CHE0230_LABEL_ASSIGN_RM_LIST; ?>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="group-search" style="margin-left: 10px;margin-right: 10px;">
                                                    <div class="condition-search">
                                                        <ul>
                                                            <li>
                                                                <span><?php echo CHE0230_LABEL_ASSIGN_CODE; ?></span>:
                                                                <input type="text" class="form-control-dms width-190"
                                                                       ng-enter="searchRMUserAssign()"
                                                                       ng-model="model.form.CHE0340SearchDataUserAssign.searchInput.userCode">
                                                            </li>
                                                            <li>
                                                                <span><?php echo CHE0230_LABEL_ASSIGN_NAME; ?></span>:
                                                                <input type="text" class="form-control-dms width-190"
                                                                       ng-enter="searchRMUserAssign()"
                                                                       ng-model="model.form.CHE0340SearchDataUserAssign.searchInput.userName">
                                                            </li>
                                                        </ul>

                                                    </div>
                                                    <div class="action-search">
                                                        <button class="btn btn-normal btn-sm btn-width-default"
                                                                ng-click="searchRMUserAssign()">
                                                            <?php echo SAL0330_BUTTON_SEARCH; ?>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="result-search">
                                                    <div class="table-region">

                                                        <table
                                                            class="list-table table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th><?php echo CHE0230_LABEL_ASSIGN_CODE; ?></th>
                                                                <th><?php echo CHE0230_LABEL_ASSIGN_NAME; ?></th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.userInfo.length> 0"
                                                                ng-repeat="item in model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.userInfo">
                                                                <td>
                                                                    <label>{{item.userCode}}</label>
                                                                </td>
                                                                <td>
                                                                    <label>{{item.fullname}}</label>
                                                                </td>
                                                                <td>
                                                                    <div style="position:relative;">
                                                        <span
                                                            class=" icon-close delete-product pull-right dropdown-toggle"
                                                            data-toggle="dropdown" style="margin-top: 5px"></span>

                                                                        <div class="popover-confirm dropdown-menu">
                                                                            <div class="arrow"></div>
                                                                            <div class="content-confirm">
                                                                                {{model.hidden.deleteConfirm.message}}
                                                                            </div>
                                                                            <div class="button-group-action text-center">
                                                                                <button class="btn  btn-default btn-info btn-xs"
                                                                                        ng-click="removeRMUser(item)">
                                                                                    <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                                                </button>
                                                                                <button class="btn btn-default btn-danger btn-xs">
                                                                                    <span><?php echo COMMON_BUTTON_CANCEL; ?></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!--Empty - Begin-->
                                                            <tr ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.userInfo.length == null">
                                                                <td colspan="3"><?php echo COM0000_EMPTY_RESULT; ?></td>
                                                            </tr>
                                                            <!--Empty - End-->


                                                            </tbody>
                                                        </table>
                                                        <div class="paging"
                                                             ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.userInfo.length > 0 "
                                                            >
                                                            <ul class="pagination">
                                                                <li class="disabled"><span>{{model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.stRow}}-{{model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.edRow}}/{{model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow}}</span>
                                                                </li>
                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == 1 || model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null ">
                                                                    <a
                                                                        href="#">&lt;&lt;</a></li>
                                                                <li ng-click="startPageUserAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != 1 && model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null ">
                                                                    <a
                                                                        href="#">&lt;&lt;</a></li>

                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == 1 || model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null">
                                                                    <a
                                                                        href="#">&lt;</a></li>
                                                                <li ng-click="prevPageUserAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != 1 && model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null ">
                                                                    <a
                                                                        href="#">&lt;</a></li>

                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages || model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null">
                                                                    <a
                                                                        href="#">&gt;</a></li>
                                                                <li ng-click="nextPageUserAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages && model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null ">
                                                                    <a
                                                                        href="#">&gt;</a></li>

                                                                <li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages || model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null">
                                                                    <a
                                                                        href="#">&gt;&gt;</a></li>
                                                                <li ng-click="endPageUserAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages && model.form.CHE0340ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null">
                                                                    <a
                                                                        href="#">&gt;&gt;</a></li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-form" style="width:49%; display:inline-block;">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                            </div>
                                            <div class="panel-body">
                                                <div class="group-search" style="margin-left: 10px;margin-right: 10px;">
                                                    <div class="condition-search">
                                                        <ul>
                                                            <li>
                                                                <span><?php echo CHE0230_LABEL_ASSIGN_CODE; ?></span>:
                                                                <input type="text" class="form-control-dms width-190"
                                                                       ng-enter="searchRMUserNotAssign()"
                                                                       ng-model="model.form.CHE0340SearchDataUserNotAssign.searchInput.userCode">
                                                            </li>

                                                            <li>
                                                                <span> <?php echo CHE0230_LABEL_ASSIGN_NAME; ?></span>:
                                                                <input type="text" class="form-control-dms width-190"
                                                                       ng-enter="searchRMUserNotAssign()"
                                                                       ng-model="model.form.CHE0340SearchDataUserNotAssign.searchInput.userName">
                                                            </li>

                                                        </ul>

                                                    </div>
                                                    <div class="action-search">
                                                        <button class="btn btn-normal btn-sm btn-width-default"
                                                                ng-click="searchRMUserNotAssign()">
                                                            <?php echo SAL0330_BUTTON_SEARCH; ?>
                                                        </button>
                                                        <button ng-click="addRMUser()"
                                                                ng-disabled="model.form.listSelectRMUser.length ==0"
                                                                class="btn btn-default btn-sm  btn-success btn-width-default">
                                                            <?php echo SAL0330_BUTTON_ADD; ?>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="result-search">
                                                    <div class="table-region">

                                                        <table class="list-table table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th><?php echo CHE0230_LABEL_ASSIGN_CODE; ?></th>
                                                                <th><?php echo CHE0230_LABEL_ASSIGN_NAME; ?></th>
                                                                <th style="text-align: center"><input
                                                                        ng-change="chooseAllRM()"
                                                                        ng-model="model.form.chooseAllRM" type="checkbox"
                                                                        id="checkboxAllRMPage{{model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage}}"
                                                                        class="regular-checkbox"/><label
                                                                        for="checkboxAllRMPage{{model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage}}"></label>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length > 0"
                                                                ng-repeat="item in model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo">
                                                                <td>
                                                                    <label>{{item.userCode}}</label>
                                                                </td>
                                                                <td>
                                                                    <label>{{item.rmName}}</label>
                                                                </td>
                                                                <td style="text-align: center;"><input type="checkbox"
                                                                                                       id="user{{item.userId}}"
                                                                                                       ng-change="chooseRMUser(item)"
                                                                                                       ng-model="item.choose"
                                                                                                       class="regular-checkbox"/><label
                                                                        for="user{{item.userId}}"></label></td>
                                                            </tr>
                                                            <!--Empty - Begin-->
                                                            <tr ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length == null">
                                                                <td colspan="3"><?php echo COM0000_EMPTY_RESULT; ?></td>
                                                            </tr>
                                                            <!--Empty - End-->
                                                            </tbody>
                                                        </table>
                                                        <div class="paging"
                                                             ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length > 0"
							>
							<ul class="pagination">
                                                                <li class="disabled"><span>{{model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.stRow}}-{{model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.edRow}}/{{model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow}}</span>
                                                                </li>
								<li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == 1 || model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null ">
                                                                    <a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != 1 && model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null ">
                                                                    <a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == 1 || model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null">
                                                                    <a
									href="#">&lt;</a></li>
								<li ng-click="prevPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != 1 && model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null ">
                                                                    <a
									href="#">&lt;</a></li>

								<li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages || model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null">
                                                                    <a
									href="#">&gt;</a></li>
								<li ng-click="nextPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages && model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null ">
                                                                    <a
									href="#">&gt;</a></li>

								<li class="disabled"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages || model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null">
                                                                    <a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageUserNotAssign()"
                                                                    ng-if="model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages && model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null">
                                                                    <a
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
	</div> 
	</div>
</div>

				<div class="btn-group-action" style="padding-top: 0px;">
					<button ng-click="backStore()" id="back_checklist" style="display:none;"
						class="btn btn-warning btn-sm  btn-width-default">
						<?php echo CHE0100_BUTTON_BACK; ?>
					</button>

					<button style="width: 125px;" ng-click="nextChecklist()" id="next-assign"
						class="btn btn-default btn-sm btn-success btn-width-default ">
                    <?php echo CHE0100_BUTTON_ADD_ASSIGN; ?>
					</button>
					<button id="finish_checklist" style="display:none;" ng-click="finish()"
						class="btn btn-default btn-sm btn-success btn-width-default ">
						<?php echo CHE0100_BUTTON_FINISH; ?>
					</button>
				</div>

			</div>
		</div>
	</div>
<!-- </div> -->
<div ng-if="model.hidden.showCHE0220"
	ng-include="'/CHE0220'" ng-controller="CHE0220Ctrl"
	ng-init="init()"></div>
