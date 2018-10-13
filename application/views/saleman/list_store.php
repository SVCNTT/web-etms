<div class="manage-staff store-tab">
	<div class="panel-form" style="width:50%">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"></span>
                    <?php echo SAL0330_LABEL_STORE_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">
			     
				<div class="group-search">
					<div class="condition-search">
						<ul>
							<li><span><?php echo SAL0330_LABEL_REGION; ?>
							</span>:
								<div class="my-areas btn-group my-button">
									<button type="button"
										class="dropdown-toggle chooseRegion width-200"
										data-toggle="dropdown" aria-expanded="false">
										{{model.hidden.defaultAreaName}}
									</button>
									<div class="my-areas-icon"><b></b></div>
									<ul class="dropdown-menu areaList scrollbarCustom" role="menu">
										<li ng-repeat="areaGroupItem in model.form.SAL0330InitOutputModel.initData.areaDropdown.items" >
											
										     <div class="groupAreaName"   ng-click="chooseArea(areaGroupItem.areaName,areaGroupItem.areaId)"> {{areaGroupItem.areaName}}    </div>
										     <ul class="area">
										         <li ng-repeat="areaItem in areaGroupItem.items">
										             <div class="areaName" ng-click="chooseArea(areaItem.areaName,areaItem.areaId)">{{areaItem.areaName}}</div>
										         </li>
										     </ul>
										</li>
										
									</ul>
								</div>
							</li>
							
							<li>
                                <span><?php echo SAL0330_LABEL_STORE_CODE;?></span>:
                                <input type="text" class="form-control-dms width-200" ng-enter="searchStore()"
								ng-model="model.form.SAL0330SearchData.searchInput.storeCode">
                            </li>
							<li>
                                <span><?php echo SAL0330_LABEL_STORE_NAME;?></span>:
                                <input type="text" class="form-control-dms width-200" ng-enter="searchStore()"
								ng-model="model.form.SAL0330SearchData.searchInput.storeName">
                            </li>
						</ul>

					</div>
					<div class="action-search">
						<button class="btn btn-normal btn-sm btn-width-default"
							ng-click="searchStore()">
							<?php echo SAL0330_BUTTON_SEARCH; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="table-region">

						<table
							class="list-table manage-staff-table store-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo SAL0330_LABEL_REGION; ?></th>
									<th><?php echo SAL0330_LABEL_STORE; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr	ng-if="model.form.SAL0330InitOutputModel.resultSearch.storeInfo.length> 0"
								ng-repeat="item in model.form.SAL0330InitOutputModel.resultSearch.storeInfo">
									<td>{{item.areaName}} </td>
									<td style="position:relative">
										
                                        <?php if (check_ACL($profile, 'sale', 'add_customer')) {?>
										<span class=" icon-close delete-product pull-right dropdown-toggle"  data-toggle="dropdown" ></span>
										<div class="popover-confirm dropdown-menu">
											<div class="arrow"> </div>
											<div class="content-confirm">
												{{model.hidden.deleteConfirm.message}} 
											</div>
											<div class="button-group-action text-center">

                                                <button class="btn  btn-default btn-info btn-xs"  ng-click="deleteStore(item)">
                                                    <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                </button>
												<button class="btn btn-default btn-danger btn-xs">
													<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
												</button>
										    	
											</div>
										</div>
                                        <?php }?>

                                        {{item.storeCode}} - {{item.storeName}} <br/>
										<i>{{item.adddress}}</i>
										
									</td>

								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.SAL0330InitOutputModel.resultSearch.storeInfo.length == null">
                                    <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->

								
							</tbody>
						</table>
						<div class="paging"  ng-if="model.form.SAL0330InitOutputModel.resultSearch.storeInfo.length > 0 "
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.stRow}}-{{model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.edRow}}/{{model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == 1 || model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageStore()"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != 1 && model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == 1 || model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageStore()"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != 1 && model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlPages || model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageStore()"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlPages && model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlPages || model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageStore()"
									ng-if="model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlPages && model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
    
    <?php if (check_ACL($profile, 'sale', 'add_customer')) {?>
	<div class="panel-form" style="width:48%">

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-plus"> </span>
					<?php echo SAL0330_LABEL_STORE_ADD; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="modal-alert"
					ng-if="model.form.SAL0330CreateResultDto.proResult.proFlg=='NG'">
					<div class="alert alert-danger fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span><span class="sr-only"></span>
						</button>
						<div class="message">{{model.form.SAL0330CreateResultDto.proResult.message}}</div>


					</div>
				</div>
				<div class="modal-alert"
					ng-if="model.form.SAL0330CreateResultDto.proResult.proFlg=='OK'">
					<div class="alert alert-success fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span><span class="sr-only"></span>
						</button>
						<div class="message">{{model.form.SAL0330CreateResultDto.proResult.message}}</div>


					</div>
				</div>
				<div class="group-add" style="float: right;">
					<div style="overflow: hidden; padding: 0 10px 10px;">
						<button ng-click="addStore()" ng-disabled="model.form.listSelectStore.length ==0"
							class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
<!--							<span class="icon-plus"></span>-->
							<?php echo SAL0330_BUTTON_ADD; ?>
						</button>
					</div>
					
				</div>
				<div class="group-search">
					<div class="condition-search">
					
						<ul>
							<li><span> <?php echo SAL0330_LABEL_REGION; ?>
							</span>:
								<div class="my-areas btn-group my-button">
									<button type="button"
										class="dropdown-toggle chooseRegion width-200"
										data-toggle="dropdown" aria-expanded="false">
										{{model.hidden.defaultAreaNameNotAssign}}
									</button>
									<div class="my-areas-icon"><b></b></div>
									<ul class="dropdown-menu areaList scrollbarCustom width-200" role="menu">
										<li ng-repeat="areaGroupItem in model.form.SAL0330InitOutputModel.initData.areaDropdown.items" >
											
										     <div class="groupAreaName"   ng-click="chooseAreaNotAssign(areaGroupItem.areaName,areaGroupItem.areaId)"> {{areaGroupItem.areaName}}    </div>
										     <ul class="area">
										         <li ng-repeat="areaItem in areaGroupItem.items">
										             <div class="areaName" ng-click="chooseAreaNotAssign(areaItem.areaName,areaItem.areaId)">{{areaItem.areaName}}</div>
										         </li>
										     </ul>
										</li>
										
									</ul>
								</div>
							</li>
						<!-- </ul>
						<ul> -->
							<li><span><?php echo SAL0330_LABEL_STORE_CODE;?>
									
							</span>: <input type="text" class="form-control-dms width-200" ng-enter="searchStoreNotAssign()"
								ng-model="model.form.SAL0330SearchDataStoreNotAssign.searchInput.storeCode"></li>
						<!-- </ul>
						<ul> -->
							<li><span> <?php echo SAL0330_LABEL_STORE_NAME; ?>
							</span>: <input type="text" class="form-control-dms width-200" ng-enter="searchStoreNotAssign()"
								ng-model="model.form.SAL0330SearchDataStoreNotAssign.searchInput.storeName"></li>
						</ul>

					</div>
					<div class="action-search">
						<button class="btn btn-normal btn-sm btn-width-default" ng-click="searchStoreNotAssign()">
<!--							<span class="icon-magnifier"> </span>-->
							<?php echo SAL0330_BUTTON_SEARCH; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="table-region">

						<table class="list-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><input ng-change="chooseAll()"
										ng-model="model.form.chooseAll" type="checkbox"
										id="checkboxAllPage{{model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage}}"
										class="regular-checkbox" /><label
										for="checkboxAllPage{{model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage}}"></label></th>
									<th><?php echo SAL0330_LABEL_STORE; ?></th>
									

								</tr>
							</thead>
							<tbody>
								<tr ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length > 0"
								ng-repeat="item in model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo">
									<td><input type="checkbox" id="store{{item.storeId}}"
										ng-change="chooseStore(item)" ng-model="item.choose"
										class="regular-checkbox" /><label
										for="store{{item.storeId}}"></label></td>
									<td>
										<label>{{item.areaName}}</label> <br/>
										<label class="italic">{{item.storeCode}}  {{item.storeName}} </label> <br/>
										<label class="pull-left">{{item.adddress}}</label>
									</td>
									
								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length == null">
                                    <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
							</tbody>
						</table>
						<div class="paging"  ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length > 0"
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.stRow}}-{{model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.edRow}}/{{model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == 1 || model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageStoreNotAssign()"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != 1 && model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == 1 || model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageStoreNotAssign()"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != 1 && model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages || model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageStoreNotAssign()"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages && model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages || model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageStoreNotAssign()"
									ng-if="model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages && model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>

				</div>
			</div>
		</div> 
	</div> 
    <?php }?>

</div>