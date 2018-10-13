<div class="manage-staff">
	<div class="panel-form">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo CLI0330_LABEL_STAFF_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">
			     
				<div class="group-search">
					<div class="condition-search">
						<ul>
                            <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN', 'MANAGER')"> -->
							<li>
                                <span> <?php echo CLI0330_LABEL_STAFF_MANAGER; ?>
    							</span> :<select chosen-select="model.form.listManager"
    								data-placeholder="<?php echo CLI0330_LABEL_STAFF_MANAGER_CHOOSE; ?>"
    								chosen-width="150px"
    								ng-model="model.form.CLI0330InitOutputModel.initData.defaultUserId"
    								ng-options="item.userId as item.fullname for item in model.form.listManager">
    							</select>
                            </li>
                            <!-- </sec:authorize> -->
							<li><span> <?php echo CLI0330_LABEL_SALE_CODE; ?>
							</span>: <input type="text" class="form-control-dms"
								ng-model="model.form.CLI0330SearchData.searchInput.salesmanCode"></li>
                            
						</ul>
						<ul>
							<li><span> <?php echo CLI0330_LABEL_NAME; ?>
							</span>: <input type="text" class="form-control-dms "
								ng-model="model.form.CLI0330SearchData.searchInput.salesmanName"></li>
							<li><span> <?php echo CLI0330_LABEL_PHONE; ?>
									
							</span>: <input type="text" class="form-control-dms "
								ng-model="model.form.CLI0330SearchData.searchInput.mobile"></li>

						</ul>

					</div>
					<div class="action-search">
						<button class="btn btn-normal btn-sm btn-width-default"
							ng-click="searchSale()">
							<span class="icon-magnifier"> </span>
							<?php echo CLI0330_BUTTON_SEARCH; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="table-region" ng-if="model.form.CLI0330InitOutputModel.resultSearch.searchSalList.length>0">

						<table
							class="list-table manage-staff-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo CLI0330_LABEL_SALE_MANAGER; ?></th>

									<th><?php echo CLI0330_LABEL_STAFF_SALE; ?></th>
									<th><?php echo CLI0330_LABEL_CONTACT; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr
									ng-repeat="item in model.form.CLI0330InitOutputModel.resultSearch.searchSalList">
									<td><label>{{item.userCode}} </label> <br /> <label>{{item.userLastName}}
											{{item.userFirstName}}</label></td>
									<td>
                                        <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
                                            <a href="/SAL0300/{{item.salesmanCode}}">{{item.salesmanCode}}</a>
                                        <!-- </sec:authorize>
                                        
                                        <sec:authorize access="hasAnyRole('MANAGER', 'LEADER', 'SUB_LEADER')"> -->
                                            <label>{{item.salesmanCode}}</label>
                                        <!-- </sec:authorize> -->
                                        
										<br /> <label> {{item.salesmanName}}</label></td>
									<td>
                                        <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
                                        <span class=" icon-close delete-product pull-right dropdown-toggle"  data-toggle="dropdown" ></span>
                                        
										<div class="popover-confirm dropdown-menu">
											<div class="arrow"> </div>
											<div class="content-confirm">
												{{model.hidden.deleteConfirm.message}} 
											</div>
											<div class="button-group-action text-center">

                                                <button class="btn  btn-default btn-info btn-xs"  ng-click="deleteUserSalesman(item)">
                                                    <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                </button>
												<button class="btn btn-default btn-danger btn-xs">
													<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
												</button>
										    	
											</div>
										</div>
                                        <!-- </sec:authorize> -->
										<label> {{item.salesmanMobile}}</label> <br /> <label>{{item.salesmanEmail}}
									</label></td>

								</tr>

							</tbody>
						</table>
						<div class="paging"
							ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != null">
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.stRow}}-{{model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.edRow}}/{{model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageSale()"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageSale()"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlPages || model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageSale()"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlPages && model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlPages || model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageSale()"
									ng-if="model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlPages && model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
    
    <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
	<div class="panel-form">

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-plus"> </span>
					<?php echo CLI0330_LABEL_ADD_STAFF; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="group-add">
					<div style="overflow: hidden; padding: 10px;">
						<button ng-click="regisUserSalesman()" ng-disabled="model.form.CLI0330CreateInputModel.userId == null || model.form.listSelectSalesman.length==0"
							class="btn btn-default btn-xs  btn-success btn-width-default pull-right">
							<span class="icon-plus"></span>
							<?php echo CLI0330_BUTTON_ADD; ?>
						</button>
					</div>
					<div class="choose-staff-group">
						<div>
							<?php echo CLI0330_LABEL_STAFF_MANAGER_CHOOSE; ?>
							:
						</div>
						<select chosen-select="model.form.listManagerToAdd"
							chosen-width="65%"
							data-placeholder="<?php echo CLI0330_LABEL_STAFF_MANAGER_CHOOSE; ?>"
							ng-model="model.form.CLI0330CreateInputModel.userId"
							ng-options="item.userId as item.fullname for item in model.form.listManagerToAdd">
						</select>
					</div>
				</div>
				<div class="group-search">
					<div class="condition-search">
						<div>
							<?php echo CLI0330_LABEL_STAFF_SALE_CHOOSE; ?>
						</div>
						<ul>
							<li><span> <?php echo CLI0330_LABEL_CODE; ?>
							</span>: <input type="text" class="form-control-dms width-250"
								ng-model="model.form.CLI0330SearchDataSalmanNotAssign.searchInput.salesmanCode"></li>
						</ul>
						<ul>
							<li><span> <?php echo CLI0330_LABEL_NAME; ?>
									
							</span>: <input type="text" class="form-control-dms width-250"
								ng-model="model.form.CLI0330SearchDataSalmanNotAssign.searchInput.salesmanName"></li>
						</ul>
						<ul>
							<li><span> <?php echo CLI0330_LABEL_PHONE; ?>
							</span>: <input type="text" class="form-control-dms width-250"
								ng-model="model.form.CLI0330SearchDataSalmanNotAssign.searchInput.mobile"></li>
						</ul>

					</div>
					<div class="action-search" ng-click="searchSaleNotAssign()">
						<button class="btn btn-normal btn-sm btn-width-default">
							<span class="icon-magnifier"> </span>
							<?php echo CLI0330_BUTTON_SEARCH; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="table-region"  ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length>0">

						<table class="list-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><input ng-change="chooseAll()"
										ng-model="model.form.chooseAll" type="checkbox"
										id="checkboxAllPage{{model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage}}"
										class="regular-checkbox" /><label
										for="checkboxAllPage{{model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage}}"></label></th>
									<th><?php echo CLI0330_LABEL_CODE; ?></th>
									<th><?php echo CLI0330_LABEL_NAME; ?></th>
									<th><?php echo CLI0330_LABEL_PHONE; ?></th>

								</tr>
							</thead>
							<tbody>
								<tr
									ng-repeat="item in model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList">
									<td><input type="checkbox" id="sale{{item.salesmanId}}"
										ng-change="chooseSale(item)" ng-model="item.choose"
										class="regular-checkbox" /><label
										for="sale{{item.salesmanId}}"></label></td>
									<td>{{item.salesmanCode}}</td>
									<td>{{item.salesmanName}}</td>
									<td>{{item.salesmanMobile}}</td>

								</tr>

							</tbody>
						</table>
						<div class="paging"
							ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != null">
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.stRow}}-{{model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.edRow}}/{{model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageSaleNotAssign()"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageSaleNotAssign()"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlPages || model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageSaleNotAssign()"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlPages && model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlPages || model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageSaleNotAssign()"
									ng-if="model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlPages && model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div>

	</div>
    
    <!-- </sec:authorize> -->

</div>