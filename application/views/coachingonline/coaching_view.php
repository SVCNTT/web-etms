
<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<div class="create-client">
				<div class="breadcrums">
					<a class="btn btn-warning btn-sm  btn-width-default" href="<?php echo site_url('COA0100');?>">
                        <?php echo COA0200_BUTTON_BACK; ?>
					</a>
				</div>

	<!-- 	START COACHING TEMPLATE  -->
				<div class="panel-form"   id="coaching_template">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="<?php echo $COA0200_LABEL_FORM_ICON; ?>" style="padding-right: 5px;"> </span>
								<?php echo $COA0200_LABEL_FORM; ?>
							</h3>
						</div>
						<div class="panel-body">
								<div class="form-create create-store">
								<input id="coachingTemplateIdFirsLoad" type="hidden" class="form-control-dms" value="<?php echo $coachingTemplateId; ?>">
												
								<input id="coachingTemplateId" ng-model="model.form.COA0200CreateCoachingInputModel.coachingTemplateId"
								ng-init="model.form.COA0200CreateCoachingInputModel.coachingTemplateId='<?php echo $coachingTemplateId; ?>'"
												type="hidden" class="form-control-dms" value="{{model.form.COA0200CreateCoachingInputModel.coachingTemplateId}}">
												
									<input id="coachingTemplateSectionId" ng-model="model.form.coachingTemplateSectionId"
									type="hidden" class="form-control-dms" value="{{model.form.coachingTemplateSectionId}}">
									<!-- Start create coaching template -->
									<div class="group">
										<div class="coachingname">
											<span><?php echo COA0200_LABEL_COACHING_NAME; ?></span> :<input ng-class="{'validate': model.hidden.validated.coachingName.isErrored == true}"
												ng-model="model.form.COA0200CreateCoachingInputModel.coachingName"
												ng-init="model.form.COA0200CreateCoachingInputModel.coachingName='<?php echo $coachingName; ?>'"
												type="hidden" class="form-control-dms">
												<span style="margin-left:5px;"><?php echo $coachingName; ?></span>
										</div> 
							             <div class="coa-startday">
							                <span><?php echo COA0200_LABEL_COACHING_STARTDAY; ?></span>
							                :<div style="display: none;" class="datepicker" ng-class="{'validate': model.hidden.validated.coachingStartday.isErrored == true}"
															ng-class="{'error': model.hidden.validation.coachingStartday.isErrored == true}">
															<datepicker date-id="coachingStartday" style="width:200px"  
															ng-init="model.form.COA0200CreateCoachingInputModel.coachingStartday='<?php echo $startDay; ?>'"
																date-value="model.form.COA0200CreateCoachingInputModel.coachingStartday"></datepicker>
											</div>
											<span style="margin-left:5px;"><?php echo $startDay; ?></span>
							            </div>
							             <div class="coa-endday">
							                <span><?php echo COA0200_LABEL_COACHING_ENDDAY; ?></span>
							                :<div style="display:none;" class="datepicker" style="width:200px" ng-class="{'validate': model.hidden.validated.coachingEndday.isErrored == true}"
															ng-class="{'error': model.hidden.validation.coachingEndday.isErrored == true}">
															<datepicker date-id="coachingEndday"
															ng-init="model.form.COA0200CreateCoachingInputModel.coachingEndday='<?php echo $endDay; ?>'"
																date-value="model.form.COA0200CreateCoachingInputModel.coachingEndday"></datepicker>
							
											</div>
											<span style="margin-left:5px;"><?php echo $startDay; ?></span>
											
							            </div>
									</div>
									<!-- End create coaching template --> 
									 
								</div>
						</div>
					</div>
				</div>
	<!-- 	END COACHING TEMPLATE  -->
				
	<!-- 	START LIST QUESTION  -->
				<div class="panel-form"   id="coaching_template_question" style="display:none;">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="icon-list"> </span>
								<?php echo COA0200_LABEL_QUESTION_LIST; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="form-create create-store">
					                    <table class="list-table product-table table table-striped"
				                        ng-click="preventClose()">
				 
				                        <tbody>
				                            <tr style="border:none;background:none;" ng-repeat="coachingSection in model.form.COA0200CreateCoachingSectionResultDto.resultSearch.coaSectionInfo ">
				                                <td style="border:none;background:none;" >{{coachingSection.section_title}}
				                                	<ul style="list-style: outside none none;">
				                                		<li ng-repeat="item in coachingSection.sectionItems"><input type="checkbox" class="checkbox-answer"  disabled="disabled"/>{{item.section_item_title}}</li>
				                                	</ul>
				                                </td>
				                                <td style="border:none;background:none;" id="{{coachingSection.coaching_template_section_id}}">
												</td>
				                            </tr>
				
				                        </tbody>
				                    </table>
									</div>
							</div>
						</div>
					</div>
<!-- 	END LIST QUESTION  -->
					
<!-- 	START VIEW ASSIGN REGIONAL MANAGER				 -->
	<div class="panel-form"  id="assign-regional-manager" >
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo COA0230_LABEL_ASSIGN_ADD; ?>
				</h3>
			</div>
			<div class="panel-body"> 
				<div class="group-search" style="margin-left: 10px; margin-right: 10px;">
					<div class="condition-search" style="padding-top: 5px;">
					
						<ul>
						<li><span> <?php echo COA0230_LABEL_ASSIGN_CODE; ?>
							</span>: <input type="text" class="form-control-dms width-200" ng-model="model.form.COA0330SearchDataUserAssign.searchInput.userCode"
							></li>
							
							<li><span style="float: left; width: 138px; margin-left: 25px;"> <?php echo COA0230_LABEL_ASSIGN_NAME; ?>
							</span>: <input type="text"   class="form-control-dms width-200"  ng-enter="searchType()"
								ng-model="model.form.COA0330SearchDataUserAssign.searchInput.userName"></li>
								
								<li>
									<div style="width: 177px; text-align:center;">
										<button class="btn btn-normal btn-sm btn-width-default" style="margin-top: -5px;"
		                                    ng-click="searchType()">
		                                    <?php echo COA0100_BUTTON_SEARCH; ?>
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
									<th><?php echo COA0230_LABEL_ASSIGN_CODE; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_NAME; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_VIEW_ANSWER; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length > 0"
								ng-repeat="item in model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo">
									<td ng-click="viewUserMark(item)">
										<label>{{item.userCode}}</label>
									</td>
									<td ng-click="viewUserMark(item)">
										<label>{{item.fullName}}</label>
									</td>
									<td>
										<label ng-click="viewUserMark(item)" style="cursor: pointer;">View mark user</label>
									</td>
								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length == null">
                                    <td colspan="4"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
							</tbody>
						</table>
						<div class="paging"  ng-if="model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.userInfo.length > 0"
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
	<!-- 	END VIEW ASSIGN REGIONAL MANAGER -->
	
	<!-- 	START VIEW USER -->
	<div class="panel-form" style="display:none;" id="assign-regional-mark-user" >
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo COA0230_LABEL_ASSIGN_USER_LIST; ?>
				</h3>
			</div>
			<div class="panel-body"> 
				<div class="group-search" style="margin-left: 10px; margin-right: 10px;">
					<div class="condition-search" style="padding-top: 5px;">
					
						<ul>
						<li><span> <?php echo COA0200_LABEL_FORM_ASSIGN; ?>
							</span>: <input type="text" class="form-control-dms width-200" ng-model="model.form.COA0200CreateCoachingInputModel.coachingName"
							disabled="disabled"></li>
							
							<li><span style="float: left; width: 138px; margin-left: 25px;"> <?php echo COA0230_LABEL_ASSIGN_USER_NAME; ?>
							</span>: <input type="text"  class="form-control-dms width-200"  ng-enter="searchUserMark()"
								ng-model="model.form.COA0330SearchDataUserMark.searchInput.userName"></li>
								
								<li>
									<div style="width: 170px;  text-align:center;">
										<button class="btn btn-normal btn-sm btn-width-default" style="margin-top: -5px;"
		                                    ng-click="searchUserMark()">
		                                    <?php echo COA0100_BUTTON_SEARCH; ?>
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
									<th><?php echo COA0230_LABEL_ASSIGN_CODE; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_USER_NAME; ?></th>
                                    <th><?php echo COA0230_LABEL_ASSIGN_USER_STORES; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_USER_DAY_SENT; ?></th>
									<th><?php echo COA0230_LABEL_ASSIGN_VIEW_ANSWER; ?></th>
									
								</tr>
							</thead>
							<tbody>
								<tr ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.userInfo.length > 0"
								ng-repeat="item in model.form.COA0330ResultSearchUserMarkModel.resultUserMark.userInfo">
									<td ng-click="viewAnswer(item)">
										<label>{{item.salesmanCode}}</label>
									</td>
									<td ng-click="viewAnswer(item)">
										<label>{{item.salesmanName}}</label>
									</td>
									<td ng-click="viewAnswer(item)">
                                        <label>{{item.stores}}</label>
                                    </td>
									<td ng-click="viewAnswer(item)">
										<label>{{item.createDate}}</label>
									</td>									
									
									<td>
										<label ng-click="viewAnswer(item)" style="cursor: pointer;">View answer</label>
									</td>
								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.userInfo.length == null">
                                    <td colspan="6"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
							</tbody>
						</table>
						<div class="paging"  ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.userInfo.length > 0"
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.stRow}}-{{model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.edRow}}/{{model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == 1 || model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageUserMark()"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != 1 && model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == 1 || model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageUserMark()"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != 1 && model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlPages || model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageUserMark()"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlPages && model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlPages || model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageUserMark()"
									ng-if="model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlPages && model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>
					<button style="margin-left: 10px; margin-bottom: 10px;width:170px;" ng-click="backListManger()" 
							class="btn btn-warning btn-sm  btn-width-default">
							<?php echo COA0400_BUTTON_BACK_MANAGER; ?>
					</button>
				</div>
			</div>
		</div> 
	</div> 
	<!-- 	END VIEW USER -->
	
	<!-- 	START LIST QUESTION  -->
	<div class="panel-form"   id="coaching_template_answer"  style="display:none;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo COA0200_LABEL_QUESTION_ANSWER; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="form-create create-store" style="padding-left: 35px;">
							<div>{{model.form.COA0200CreateCoachingSectionResult.initData.coachingTemplate.name}}</div>
                    <div><span style="float: left; width: 100px;">Target (SMART)</span>:
                        {{model.form.COA0200CreateCoachingSectionResult.initData.target}}
                    </div>
		                    <table class="list-table product-table table table-striped" style="margin-left: 20px;">
		                        <tbody>
                        <tr style="border:none;background:none;"
                            ng-repeat="coachingSection in model.form.COA0200CreateCoachingSectionResult.initData.listSections ">
		                                <td style="border:none;background:none;" >{{coachingSection.coachingTemplateSection.title}}
		                                	<ul style="list-style: outside none none;">
                                    <li ng-repeat="item in coachingSection.listSectionItems">
                                        <input type="checkbox" ng-checked="{{item.value}}" class="checkbox-answer"/>
                                            {{item.coachingTemplateSectionItem.title}}
		                                		</li>
		                                	</ul>
                                <div><span style="float: left; width: 50px;">Marked</span>: {{coachingSection.mark}}
                                </div>
                                <div><span style="float: left; width: 50px;">Noted</span>: {{coachingSection.note}}
                                </div>
		                                </td>
		                                <td style="border:none;background:none;" id="{{coachingSection}}">
										</td>
		                            </tr>
		
		                        </tbody>
	                    	</table>
                    <div><span style="float: left; width: 95px;">Average mark</span>:
                        {{model.form.COA0200CreateCoachingSectionResult.initData.averageMark}}
                    </div>
                    <div><span style="float: left; width: 95px;">Achievement</span>:
                        {{model.form.COA0200CreateCoachingSectionResult.initData.achievement}}
                    </div>
                    <div><span style="float: left; width: 95px;">Need Approve</span>:
                        {{model.form.COA0200CreateCoachingSectionResult.initData.needApprove}}
                    </div>
                    <div><span style="float: left; width: 95px;">Next Plan</span>:
                        {{model.form.COA0200CreateCoachingSectionResult.initData.nextPlan}}
                    </div>

                    	  
					</div>
						
				</div>
				<button style="margin-left: 10px; margin-bottom: 10px; width:150px;" ng-click="backListUser()" 
							class="btn btn-warning btn-sm  btn-width-default">
							<?php echo COA0400_BUTTON_BACK; ?>
				</button>
			</div>
		</div>
<!-- 	END LIST QUESTION  -->
	
		<div class="btn-group-action">
			<button ng-click="backStore()" id="back_coaching" style="display:none;"
				class="btn btn-warning btn-sm  btn-width-default">
				<?php echo COA0100_BUTTON_BACK; ?>
			</button>
			<button style="width: 125px;" ng-click="nextCoaching()" id="next-coaching"
				class="btn btn-default btn-sm btn-success btn-width-default ">
				<?php echo COA0100_BUTTON_VIEW_QUESTION; ?>
			</button>
		<!-- 	<button style="width: 145px; display:none;" ng-click="nextCoaching()" id="next-assign"
				class="btn btn-default btn-sm btn-success btn-width-default ">
				<?php echo COA0100_BUTTON_VIEW_ASSIGN_USER; ?>
			</button>  -->
			<button id="finish_coaching" style="display:none;" ng-click="viewListCoaching()"
				class="btn btn-default btn-sm btn-success btn-width-default ">
				<?php echo COA0100_BUTTON_FINISH; ?>
			</button>
		</div>

			</div>
		</div>
	</div>
</div>
<div ng-if="model.hidden.showCOA0220"
	ng-include="'/COA0220'" ng-controller="COA0220Ctrl"
	ng-init="init()"></div>
	