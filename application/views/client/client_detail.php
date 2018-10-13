<div class="manage-staff store-tab">
	<div class="panel-form">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo CLI0380_LABEL_STORE_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">
			     
				 <div class="group-search">
					<div class="condition-search">
                        <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN', 'MANAGER')"> -->
						<!-- <ul style="list-style-type: none;padding-left:12px;">
							
						</ul> -->
                        <!-- </sec:authorize> -->
						<ul style="list-style-type: none;padding-left:12px;">
						<li>
                            <span class="store-search-dashboard"> <?php echo CLI0380_LABEL_REGION; ?></span>:
								<div class="btn-group my-button my-areas my-areas-search">
									<button type="button" 
										class="dropdown-toggle chooseRegion  width-250"
										data-toggle="dropdown" aria-expanded="false">
										{{model.hidden.defaultAreaName}}
									</button>
									<div class="my-areas-icon"><b></b></div>
									<ul class="dropdown-menu areaList scrollbarCustom width-250" role="menu">
										<li ng-repeat="areaGroupItem in model.form.CLI0380InitOutputModel.initData.areaDropdown.items" >
											
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
                                <span class="store-search-dashboard"> <?php echo CLI0380_LABEL_STORE_CODE; ?></span>:
                                <input type="text" class="form-control-dms width-250" ng-enter="searchStore()"
								ng-model="model.form.CLI0380SearchData.searchInput.storeCode"></li>
							<li>
                                <span class="store-search-dashboard"> <?php echo CLI0380_LABEL_STORE_NAME; ?></span>:
                                <input type="text" class="form-control-dms width-250" ng-enter="searchStore()"
								ng-model="model.form.CLI0380SearchData.searchInput.storeName"></li>

						</ul>
					</div>
					<div class="action-search">
						<button class="btn btn-normal btn-sm btn-width-default "
							ng-click="searchStore()">
							<?php echo CLI0380_BUTTON_SEARCH; ?>
						</button>
					</div>
                </div>
				<div class="result-search">
					<div class="table-region">

						<table
							class="list-table manage-staff-table store-table table table-striped table-bordered">
							<thead>
								<tr>
									<th><?php echo CLI0380_LABEL_REGION; ?></th>
									<th><?php echo CLI0380_LABEL_STORE; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr  ng-if="model.form.CLI0380InitOutputModel.resultSearch.storeInfo.length> 0"
									ng-repeat="item in model.form.CLI0380InitOutputModel.resultSearch.storeInfo">
									<td>{{item.areaName}} </td>
									<td style="position:relative">
										
                                        <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')">
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
                                        </sec:authorize>
                                         <a class="link-store" style="" href="/STO0300/{{item.storeCode}}"> {{item.storeCode}}</a>
                                        - {{item.storeName}} <br/>
										<i>{{item.adddress}}</i>
										
									</td>

								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.CLI0380InitOutputModel.resultSearch.storeInfo.length == null">
                                    <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->								
							</tbody>
						</table>
						<div class="paging" ng-if="model.form.CLI0380InitOutputModel.resultSearch.storeInfo.length > 0"
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.stRow}}-{{model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.edRow}}/{{model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageStore()"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == 1 || model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageStore()"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != 1 && model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlPages || model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageStore()"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlPages && model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlPages || model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageStore()"
									ng-if="model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlPages && model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage != null"><a
									href="#">&gt;&gt;</a></li>
							</ul>
						</div>

					</div>
				</div>
				</div>
			</div>
    </div>
    
    
<!--     <sec:authorize access="hasAnyRole('ADMIN','SUB_ADMIN')">
 -->    
	<div class="panel-form">

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-plus"> </span>
					<?php echo CLI0380_LABEL_STORE_ADD; ?>
				</h3>
			</div>
			<div class="panel-body">
				<div class="modal-alert"
					ng-if="model.form.CLI0380CreateResultDto.proResult.proFlg=='NG'">
					<div class="alert alert-danger fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span><span class="sr-only"></span>
						</button>
						<div class="message">{{model.form.CLI0380CreateResultDto.proResult.message}}</div>


					</div>
				</div>
				<div class="modal-alert"
					ng-if="model.form.CLI0380CreateResultDto.proResult.proFlg=='OK'">
					<div class="alert alert-success fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span><span class="sr-only"></span>
						</button>
						<div class="message">{{model.form.CLI0380CreateResultDto.proResult.message}}</div>


					</div>
				</div>
				<div class="group-add" style="float:right;">
					<div style="overflow: hidden; padding: 0 10px 10px;">
						<button ng-click="addStore()" ng-disabled="model.form.listSelectStore.length ==0"
							class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
							<?php echo CLI0380_BUTTON_ADD; ?>
						</button>
					</div>
					
				</div>
				<div class="group-search">
					<div class="condition-search">
					
						<!-- <ul>
							
						</ul> -->
						<ul style="list-style-type: none;">
						<li><span> <?php echo CLI0380_LABEL_REGION; ?></span>:
								<div class="btn-group my-button my-areas my-areas-search">
									<button type="button" 
										class="dropdown-toggle chooseRegion width-250"
										data-toggle="dropdown" aria-expanded="false">
										{{model.hidden.defaultAreaNameNotAssign}}
									</button>
									<div class="my-areas-icon"><b></b></div>
									<ul class="dropdown-menu areaList scrollbarCustom width-250" role="menu">
										<li ng-repeat="areaGroupItem in model.form.CLI0380InitOutputModel.initData.areaDropdown.items" >
											
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
							<li><span> <?php echo CLI0380_LABEL_STORE_CODE; ?></span>:
                                <input type="text" class="form-control-dms width-250" ng-enter="searchStoreNotAssign()"
								ng-model="model.form.CLI0380SearchDataStoreNotAssign.searchInput.storeCode"></li>

							<li><span> <?php echo CLI0380_LABEL_STORE_NAME; ?></span>:
                                <input type="text" class="form-control-dms width-250" ng-enter="searchStoreNotAssign()"
								ng-model="model.form.CLI0380SearchDataStoreNotAssign.searchInput.storeName"></li>
						</ul>
						<!-- <ul>
							
						</ul> -->

					</div>
					<div class="action-search" >
						<button ng-click="searchStoreNotAssign()" class="btn btn-normal btn-sm btn-width-default">
							<?php echo CLI0380_BUTTON_SEARCH; ?>
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
										id="checkboxAllPage{{model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage}}"
										class="regular-checkbox" /><label
										for="checkboxAllPage{{model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage}}"></label></th>
									<th><?php echo CLI0380_LABEL_STORE; ?></th>
									

								</tr>
							</thead>
							<tbody>
								<tr	
								 ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length > 0"
								ng-repeat="item in model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo">
									<td><input type="checkbox" id="store{{item.storeId}}"
										ng-change="chooseStore(item)" ng-model="item.choose"
										class="regular-checkbox" /><label
										for="store{{item.storeId}}"></label></td>
									<td>
										<label>{{item.areaName}}</label> <br/>
										<label class="italic">{{item.storeCode}}  {{item.storeName}} </label> <br/>
										<label class="pull-right">{{item.adddress}}</label>
									</td>
									
								</tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length == null">
                                    <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
							</tbody>
						</table>
						<div class="paging" 
							 ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length > 0"
							>
							<ul class="pagination">
								<li class="disabled"><span>{{model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.stRow}}-{{model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.edRow}}/{{model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlRow}}</span></li>
								<li class="disabled"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == 1 || model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null "><a
									href="#">&lt;&lt;</a></li>
								<li ng-click="startPageStoreNotAssign()"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != 1 && model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == 1 || model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null"><a
									href="#">&lt;</a></li>
								<li ng-click="prevPageStoreNotAssign()"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != 1 && model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null "><a
									href="#">&lt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages || model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;</a></li>
								<li ng-click="nextPageStoreNotAssign()"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages && model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null "><a
									href="#">&gt;</a></li>

								<li class="disabled"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages || model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage == null"><a
									href="#">&gt;&gt;</a></li>
								<li ng-click="endPageStoreNotAssign()"
									ng-if="model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages && model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage != null"><a
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