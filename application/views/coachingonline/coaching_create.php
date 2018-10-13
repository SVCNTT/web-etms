
<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<div class="create-client">
				<div class="breadcrums">
					<a class="btn btn-warning btn-sm  btn-width-default" href="<?php echo site_url('COA0100');?>">
                        <?php echo COA0200_BUTTON_BACK; ?>
					</a>

				</div>
				<div class="panel-form"   id="coaching_template">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="<?php echo $COA0200_LABEL_FORM_ICON; ?>" style="padding-right: 5px;"> </span>
								<?php echo $COA0200_LABEL_FORM; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
								    <ul>
								    	<li ng-if="model.hidden.validated.coachingName.isErrored == true">
								    	 	{{model.hidden.validated.coachingName.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.coachingStartday.isErrored == true">
								    	 	{{model.hidden.validated.coachingStartday.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.coachingEndday.isErrored == true">
								    	 	{{model.hidden.validated.coachingEndday.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.coachingMoreStartDay.isErrored == true">
								    	 	{{model.hidden.validated.coachingMoreStartDay.msg}}
									    </li>
									    <li ng-if="model.hidden.validated.coachingMoreEndDay.isErrored == true">
								    	 	{{model.hidden.validated.coachingMoreEndDay.msg}}
									    </li>
								    </ul>
								    
								</div>
								<div class="form-create create-store">
								
								<input id="isEdit" type="hidden" class="form-control-dms" value="<?php echo $isEdit; ?>">
												
								<input id="coachingTemplateId" ng-model="model.form.COA0200CreateCoachingInputModel.coachingTemplateId"
								ng-init="model.form.COA0200CreateCoachingInputModel.coachingTemplateId='<?php echo $coachingTemplateId; ?>'"
												type="hidden" class="form-control-dms" value="{{model.form.COA0200CreateCoachingInputModel.coachingTemplateId}}">
												
									<input id="coachingTemplateSectionId" ng-model="model.form.coachingTemplateSectionId"
									type="hidden" class="form-control-dms" value="{{model.form.coachingTemplateSectionId}}">
									<!-- Start create coaching template -->
									<div class="group">
										<div class="coachingname">
											<span><?php echo COA0200_LABEL_COACHING_NAME; ?> <span
	                                        class="required"><?php echo COMMON_REQUIRED; ?></span></span> :<input ng-class="{'validate': model.hidden.validated.coachingName.isErrored == true}"
												ng-model="model.form.COA0200CreateCoachingInputModel.coachingName"
												ng-init="model.form.COA0200CreateCoachingInputModel.coachingName='<?php echo $coachingName; ?>'"
												type="text" class="form-control-dms">
										</div> 
							             <div class="coa-startday">
							                <span><?php echo COA0200_LABEL_COACHING_STARTDAY; ?> <span
							                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
							                :<div class="datepicker" ng-class="{'validate': model.hidden.validated.coachingStartday.isErrored == true}"
															ng-class="{'error': model.hidden.validation.coachingStartday.isErrored == true}">
															<datepicker date-id="coachingStartday" style="width:200px"  
															ng-init="model.form.COA0200CreateCoachingInputModel.coachingStartday='<?php echo $startDay; ?>'"
																date-value="model.form.COA0200CreateCoachingInputModel.coachingStartday"></datepicker>
							
											</div>
							            </div>
							             <div class="coa-endday">
							                <span><?php echo COA0200_LABEL_COACHING_ENDDAY; ?> <span
							                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
							                :<div class="datepicker" style="width:200px" ng-class="{'validate': model.hidden.validated.coachingEndday.isErrored == true}"
															ng-class="{'error': model.hidden.validation.coachingEndday.isErrored == true}">
															<datepicker date-id="coachingEndday"
															ng-init="model.form.COA0200CreateCoachingInputModel.coachingEndday='<?php echo $endDay; ?>'"
																date-value="model.form.COA0200CreateCoachingInputModel.coachingEndday"></datepicker>
							
											</div>
							            </div>
									</div>
									<!-- End create coaching template --> 
									 
								</div>
						</div>
					</div>
				</div>
				<div class="panel-form"   id="coaching_template_question" style="display:none;">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="icon-plus"> </span>
								<?php echo COA0200_LABEL_QUESTION_ADD; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="form-create create-store">
					                    <table class="list-table product-table table table-striped"
				                        ng-click="preventClose()">
				 
				                        <tbody>
				                            <tr style="border:none;background:none;" ng-repeat="coachingSection in model.form.COA0200CreateCoachingSectionResultDto.resultSearch.coaSectionInfo ">
				                                <td style="border:none;background:none;" ng-click="editQuestions(coachingSection)" >{{coachingSection.section_title}}
				                                	<ul style="list-style: outside none none;">
				                                		<li ng-repeat="item in coachingSection.sectionItems"><input type="checkbox" class="checkbox-answer"  disabled="disabled"/>{{item.section_item_title}}</li>
				                                	</ul>
				                                </td>
				                                <td style="border:none;background:none;" id="{{coachingSection.coaching_template_section_id}}">
													<span  class="delete-store pull-right icon-close dropdown-toggle"  data-toggle="dropdown"></span>
													<a class="edit-store pull-right" ng-click="editQuestions(coachingSection)"><span class="icon-note"></span> </a>
													<div class="popover-confirm dropdown-menu">
														<div class="arrow"> </div>
														<div class="content-confirm">
															{{model.hidden.deleteConfirm.message}} 
														</div>
														<div class="button-group-action text-center">

                                                            <button class="btn  btn-default btn-info btn-xs" ng-click="deleteSection(coachingSection)">
                                                                <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                            </button>
															<button class="btn btn-default btn-danger btn-xs">
																<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
															</button>
													    	
														</div>
													</div>
												</td>
				                            </tr>
				
				                        </tbody>
				                    </table>
                    
				 					<button ng-click="addQuestions()"
										class="btn btn-default btn-sm btn-success btn-width-default " style="width:115px;">
										<?php echo COA0200_BUTTON_ADD_ITEM; ?>
									</button>
									</div>
							</div>
						</div>
					</div>
	<div class="manage-staff store-tab" style="display: none;width: 100%; float: left;"  id="assign-regional-manager" >
	<div class="panel-form" style="width:50%; float:left">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"></span>
                    <?php echo COA0230_LABEL_ASSIGN_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">
			     
				<div class="group-search" style="margin-left: 10px;margin-right: 10px;">
					<div class="condition-search">
						<ul>
							<li>
                                <span><?php echo COA0230_LABEL_ASSIGN_CODE;?></span>:
                                <input type="text" class="form-control-dms width-190"
								ng-model="model.form.COA0330SearchDataUserAssign.searchInput.userCode">
                            </li>
							<li>
                                <span style="margin-left: 20px;"><?php echo COA0200_LABEL_FORM_ASSIGN;?></span>:
                                <input type="text" class="form-control-dms width-190"
								ng-model="model.form.COA0330SearchDataUserAssign.searchInput.userName">
                            </li>
						</ul>

					</div>
					<div class="action-search">
						<button class="btn btn-normal btn-sm btn-width-default"
							ng-click="searchUserAssign()">
<!--							<span class="icon-magnifier"> </span>-->
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
									<th><?php echo COA0230_LABEL_ASSIGN_CODE; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_NAME; ?></th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr	ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length> 0"
								ng-repeat="item in model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo">
									<td>
										<label>{{item.userCode}}</label>
									</td>
									<td>
										<label>{{item.fullName}}</label>
									</td>
									<td>
									<div style="position:relative;">
										<span  class=" icon-close delete-product pull-right dropdown-toggle"  data-toggle="dropdown" ></span>
										<div class="popover-confirm dropdown-menu">
											<div class="arrow"> </div>
											<div class="content-confirm">
												{{model.hidden.deleteConfirm.message}} 
											</div>
											<div class="button-group-action text-center">

                                                <button class="btn  btn-default btn-info btn-xs"  ng-click="removeUser(item)">
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
                                <tr  ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length == null">
                                    <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->

								
							</tbody>
						</table>
						<div class="paging"  ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length > 0 "
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.stRow}}-{{model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.edRow}}/{{model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == 1 || model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageUserAssign()"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != 1 && model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == 1 || model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageUserAssign()"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != 1 && model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages || model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageUserAssign()"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages && model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages || model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageUserAssign()"
									ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages && model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>				
	<div class="panel-form" style="width:50%; display:inline-block;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-plus"> </span>
					<?php echo COA0230_LABEL_ASSIGN_ADD; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="group-search"  style="margin-left: 10px;margin-right: 10px;">
					<div class="condition-search">
						<ul>
							<li>
                                <span><?php echo COA0230_LABEL_ASSIGN_CODE;?></span>:
                                <input type="text" class="form-control-dms width-190"
								ng-model="model.form.COA0330SearchDataUserNotAssign.searchInput.userCode">
                            </li>
							
							<li><span style="float: left; width: 138px;margin-left: 20px;"> <?php echo COA0230_LABEL_ASSIGN_NAME; ?>
							</span>: <input type="text" ng-model-options='{ debounce: 1000 }'" class="form-control-dms width-190"
								ng-model="model.form.COA0330SearchDataUserNotAssign.searchInput.userName"></li>
								
						</ul>

					</div>
 					<div class="action-search"> 
						<button class="btn btn-normal btn-sm btn-width-default" ng-click="searchUserNotAssign()">
							<?php echo SAL0330_BUTTON_SEARCH; ?>
						</button>
						<button ng-click="addUser()" ng-disabled="model.form.listSelectUser.length ==0"
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
									<th><?php echo COA0230_LABEL_ASSIGN_CODE; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_NAME; ?></th>
									<th><input ng-change="chooseAll()"
										ng-model="model.form.chooseAll" type="checkbox"
										id="checkboxAllPage{{model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage}}"
										class="regular-checkbox" /><label
										for="checkboxAllPage{{model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage}}"></label></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length > 0"
								ng-repeat="item in model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo">
									<td>
										<label>{{item.userCode}}</label>
									</td>
									<td>
										<label>{{item.fullName}}</label>
									</td>
									<td><input type="checkbox" id="user{{item.userId}}"
										ng-change="chooseUser(item)" ng-model="item.choose"
										class="regular-checkbox" /><label
										for="user{{item.userId}}"></label></td>
								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length == null">
                                    <td colspan="3"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
							</tbody>
						</table>
						<div class="paging"  ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length > 0"
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.stRow}}-{{model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.edRow}}/{{model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == 1 || model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageUserNotAssign()"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != 1 && model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == 1 || model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageUserNotAssign()"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != 1 && model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages || model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageUserNotAssign()"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages && model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages || model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageUserNotAssign()"
									ng-if="model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages && model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage != null"><a
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

				<div class="btn-group-action" style="padding-top: 0px; margin-top: -20px; float:left;">
					<button ng-click="backStore()" id="back_coaching" style="display:none;"
						class="btn btn-warning btn-sm  btn-width-default">
						<?php echo COA0100_BUTTON_BACK; ?>
					</button>
					<button style="width: 125px;" ng-click="nextCoaching()" id="next-coaching"
						class="btn btn-default btn-sm btn-success btn-width-default ">
						<?php echo COA0100_BUTTON_ADD_QUESTION; ?>
					</button>
					<button style="width: 112px; display:none;" ng-click="nextCoaching()" id="next-assign"
						class="btn btn-default btn-sm btn-success btn-width-default ">
						<?php echo COA0100_BUTTON_ADD_ASSIGN_USER; ?>
					</button>
					<button id="finish_coaching" style="display:none;" ng-click="finish()"
						class="btn btn-default btn-sm btn-success btn-width-default ">
						<?php echo COA0100_BUTTON_FINISH; ?>
					</button>
				</div>

			</div>
		</div>
	</div>
<!-- </div> -->
git
<div ng-if="model.hidden.showCOA0220"
	ng-include="'/COA0220'" ng-controller="COA0220Ctrl"
	ng-init="init()"></div>
	