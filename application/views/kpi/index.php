
<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<div class="create-client">
					<div class="manage-staff store-tab" style="width: 100%; float: left;"  id="assign-regional-manager" >
							<div class="panel-form" style="width:50%; float:left;margin-top: 20px;">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">
											<span class="icon-list"></span>
						                    <?php echo KPI0100_LABEL_TEAM_LIST; ?>
										</h3>
									</div>
									<div class="panel-body" style="">
										<div class="result-search">
											<div class="table-region">
													 
												<table
													class="list-table manage-staff-table store-table table table-striped table-bordered">
													<thead>
														<tr>
															<th><?php echo KPI0100_LABEL_TEAM_ID; ?></th>
															<th><?php echo KPI0100_LABEL_TEAM_NAME; ?></th>
														</tr>
													</thead>
													<tbody>
														<tr	ng-if="model.form.KPI0100ResultSearchTeamModel.resultTeam.teamInfo.length> 0"
														ng-repeat="item in model.form.KPI0100ResultSearchTeamModel.resultTeam.teamInfo">
															<td style="cursor: pointer;" ng-click="loadDetailKpi(item)">
																<label>{{item.productTypeId}}</label>
															</td>
															<td ng-click="loadDetailKpi(item)" style="cursor: pointer;">
																{{item.productTypeName}}
															</td>
						
														</tr>
						                                <!--Empty - Begin-->
						                                <tr  ng-if="model.form.KPI0100ResultSearchTeamModel.resultTeam.teamInfo.length == null">
						                                    <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
						                                </tr>
						                                <!--Empty - End-->
														
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>				
							<div class="panel-form" style="width:50%; display:none;margin-top: 20px;" id="result-add-times">
								<div class="panel panel-primary">
									<div class="panel-heading" style="padding: 5px 10px;">
										<h3 class="panel-title">
											<span class="icon-plus"> </span>
											<?php echo KPI0100_LABEL_TIME_ADD; ?>
											<div id="date" class="input-append" datetimez ng-model="model.form.KPI0100Model.currentMonth">
										      <input data-format="MM-yyyy" type="text" style="width: 100px; margin-left: 30px; padding-left: 5px;"  id="input1" name="input1"></input>
										      <span class="add-on">
										        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
										      </span>
										    </div>
										</h3>
									</div>
									<div class="panel-body">  
										<div class="group-search"  style="margin-left: 10px; margin-right: 10px; margin-top: 7px;">
											<div class="condition-search">
												<table class="kpi-edit">
													
													<tr >
													<td style="width: 44%;">
														<div class="training-days">
							                                <span><?php echo KPI0100_LABEL_TRAINING_DAYS;?></span>:
							                                <input type="text" numbers-only class="form-control-dms width-190"
															ng-model="model.form.KPI0100Model.trainingDays">
							                        	 </div>
													</td>
													<td>
														<div class="call-rate">
														 	<span> <?php echo KPI0100_LABEL_CALL_RATE; ?>
															</span>: <input type="text" numbers-only  class="form-control-dms width-190"
																ng-model="model.form.KPI0100Model.callRate">
														</div>
													</td>
													</tr>
													<tr>
													<td>
														<div class="promotion-days">
							                                <span><?php echo KPI0100_LABEL_PROMOTION_DAYS;?></span>:
							                                <input type="text"  numbers-only class="form-control-dms width-190"
															ng-model="model.form.KPI0100Model.promotionDays">
							                        	 </div>
													</td>
													<td>
														<div class="meeting-days">
														 	<span> <?php echo KPI0100_LABEL_MEETING_DAYS; ?>
															</span>: <input type="text"  numbers-only class="form-control-dms width-190"
																ng-model="model.form.KPI0100Model.meetingDays">
														</div>
													</td>
													</tr>
													<tr>
													<td>
														<div class="holidays">
							                                <span><?php echo KPI0100_LABEL_HOLIDAYS;?></span>:
							                                <input type="text"  numbers-only class="form-control-dms width-190"
															ng-model="model.form.KPI0100Model.holidays">
							                        	 </div>
													</td>
													<td>
														<div class="leave-taken">
														 	<span> <?php echo KPI0100_LABEL_LEAVE_TAKEN; ?>
															</span>: <input type="text"  numbers-only class="form-control-dms width-190"
																ng-model="model.form.KPI0100Model.leaveTaken">
														</div>
													</td>
													</tr>	
													<tr>
													<td colspan="2">
														<div class="frequency">
							                                <span><?php echo KPI0100_LABEL_FREQUENCY;?></span>:
							                                <input type="text"  numbers-only class="form-control-dms width-190" placeholder="A"
															ng-model="model.form.KPI0100Model.frequency1">
															<label style="margin-left: 45px;">&nbsp:</label>
															<input type="text"  numbers-only class="form-control-dms width-190" placeholder="B"
															ng-model="model.form.KPI0100Model.frequency2">
															
															<label style="margin-left: 32px;">&nbsp:</label>
															<input type="text"  numbers-only class="form-control-dms width-190" placeholder="C"
															ng-model="model.form.KPI0100Model.frequency3">
							                        	 </div>
													</td>
													</tr>												
												</table>
						
											</div>
						 					<div class="action-search"> 
                                                <?php if (check_ACL($profile, 'kpi', 'save')) {?>
												<button ng-click="saveKpi()" ng-disabled="
												model.form.KPI0100Model.frequency1 == null 
												&& model.form.KPI0100Model.frequency2 == null 
												&& model.form.KPI0100Model.frequency3 == null 
												&& model.form.KPI0100Model.trainingDays == null
												&& model.form.KPI0100Model.callRate == null  
												&& model.form.KPI0100Model.promotionDays == null  
												&& model.form.KPI0100Model.meetingDays == null  
												&& model.form.KPI0100Model.holidays == null  
												&& model.form.KPI0100Model.leaveTaken == null  
												"
													class="btn btn-default btn-sm  btn-success btn-width-default">
													<?php echo KPI0100_BUTTON_SAVE; ?>
												</button>
                                                <?php }?>
											</div>
						
										</div>
										<div class="result-search">
											<div class="table-region">
						
												<table class="list-table table table-striped table-bordered">
													<thead>
														<tr>
															<th><?php echo KPI0100_LABEL_ADD_CODE; ?></th>
															<th><?php echo KPI0100_LABEL_ADD_NAME; ?></th>
														</tr>
													</thead>
													<tbody>
														<tr ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.salesmanInfo.length > 0"
														ng-repeat="item in model.form.KPI0100SearchDataSalesmanResult.resultSearch.salesmanInfo">
															<td>
																<label>{{item.salesmanCode}}</label>
															</td>
															<td>
																<label>{{item.salesmanName}}</label>
															</td>
														</tr>
						                                <!--Empty - Begin-->
						                                <tr  ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.salesmanInfo.length == null">
						                                    <td colspan="3"><?php echo COM0000_EMPTY_RESULT;?></td>
						                                </tr>
						                                <!--Empty - End-->
													</tbody>
												</table>
												<div class="paging"  ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.salesmanInfo.length > 0"
													>
													<ul class="pagination">
														<li class="disabled"><span>{{model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.stRow}}-{{model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.edRow}}/{{model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlRow}}</span></li>
														<li class="disabled"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == 1 || model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == null "><a
															href="#">&lt;&lt;</a></li>
														<li ng-click="startPage()"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != 1 && model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != null "><a
															href="#">&lt;&lt;</a></li>
						
														<li class="disabled"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == 1 || model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == null"><a
															href="#">&lt;</a></li>
														<li ng-click="prevPage()"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != 1 && model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != null "><a
															href="#">&lt;</a></li>
						
														<li class="disabled"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlPages || model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == null"><a
															href="#">&gt;</a></li>
														<li ng-click="nextPage()"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlPages && model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != null "><a
															href="#">&gt;</a></li>
						
														<li class="disabled"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlPages || model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage == null"><a
															href="#">&gt;&gt;</a></li>
														<li ng-click="endPage()"
															ng-if="model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlPages && model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage != null"><a
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
	