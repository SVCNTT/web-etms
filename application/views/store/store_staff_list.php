<div class="staff-region">
    
	<div class="panel-form" >
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo STO0300_LABEL_SALE_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">

				<div class="list-sale">

					<ul class="list-ul-table ul-header">
                        <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
						<!-- <li><?php echo STO0300_LABEL_CLIENT_TAB; ?></li> -->
                        <!-- </sec:authorize> -->
						<li><?php echo STO0300_LABEL_STAFF_CODE; ?></li>
						<li><?php echo STO0300_LABEL_NAME; ?></li>
					</ul>
					<div class="div-scroll scrollbarCustom store-staff-list">
						<ul class="list-ul-table ul-body"
							ng-class="{'active': $index == model.hidden.activeRow}"
							ng-repeat="saleItem in model.form.STO0320SalesmanByStoreClientOutputModel.selectSalesmanByStoreClient">
							<li>{{saleItem.salesmanCode}}</li>
							<li>{{saleItem.salesmanName}} 

                                <?php if (check_ACL($profile, 'store', 'add_mr')) {?>
							<span 
								class="delete  pull-right icon-close dropdown-toggle"  data-toggle="dropdown"></span>
								<div class="popover-confirm dropdown-menu">
									<div class="arrow"> </div>
									<div class="content-confirm">
										{{model.hidden.deleteConfirm.message}} 
									</div>
									<div class="button-group-action text-center">

                                        <button class="btn  btn-default btn-info btn-xs" ng-click="deleteSaleman(saleItem)">
                                            <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                        </button>
										<button class="btn btn-default btn-danger btn-xs">
											<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
										</button>
								    	
									</div>
								</div>	
                                <?php }?>

							</li>
						</ul>
                        <!--Empty - Begin-->
                        <ul class="list-ul-table ul-body" ng-if="model.form.STO0320SalesmanByStoreClientOutputModel.selectSalesmanByStoreClient.length <=0 ">
                            <li><?php echo COM0000_EMPTY_RESULT;?></li>
                        </ul>
                        <!--Empty - End-->
					</div>

				</div>

			</div>
		</div>

	</div> 

    <?php if (check_ACL($profile, 'store', 'add_mr')) {?>
    <div class="panel-form">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="icon-plus"> </span>
                    <?php echo STO0300_LABEL_ADD_SALE; ?>
                </h3>
            </div>
            <div class="panel-body">
                 <div class="modal-alert" ng-if="model.form.STO0320Alert.proResult.proFlg=='NG'">
                    <div class="alert alert-danger fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">×</span><span class="sr-only"></span>
                        </button>
                        <div class="message">{{model.form.STO0320Alert.proResult.message}}</div>
    
    
                    </div>
                </div>

                <div class="group-add">
                    <div>
                        <button ng-click="regisSalesmanStore()" ng-disabled="model.form.STO0320ListSaleRegis.length==0"
                            class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
                            <?php echo STO0300_BUTTON_ADD; ?>
                        </button>
                    </div>
                </div>
                <div class="group-search">
                    <div class="condition-search">
                           <div style="display:none;">
                         <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
                                <span> <?php echo STO0300_LABEL_CLIENT_TAB; ?></span>
                                :<select
                                    chosen-select="model.form.STO0320InitDataModel.clientInfo" data-placeholder="<?php echo STO0300_LABEL_CHOOSE_CLIENT; ?>"
                                    chosen-width="200px" ng-change="selectSalesmanByStoreClient()"
                                    ng-model="model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId"
                                    ng-options="item.clientId as item.clientName for item in model.form.STO0320InitDataModel.clientInfo">
                                </select>
                               <!-- </sec:authorize> -->
                         </div>
                        <div>
                            <span> <?php echo STO0300_LABEL_STAFF_CODE; ?></span>
                            :<input type="text" class="form-control-dms width180"
                                ng-model="model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.salesmanCode">
                        </div>
                        <div>
                            <span> <?php echo STO0300_LABEL_NAME; ?></span> :<input
                                type="text" class="form-control-dms width180"
                                ng-model="model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.salesmanName">
                        </div>


                    </div>
                    <div class="action-search">
                        <button class="btn btn-normal btn-sm btn-width-default"
                            ng-click="selectSalesmanNotAssingnStore()">
                            <?php echo STO0300_BUTTON_SEARCH; ?>
                        </button>
                    </div>

                </div>
                <div class="result-search">
                    <div class="table-region">

                        <table
                            class="list-table product-table table table-striped table-bordered table-add-salesman"
                            ng-click="preventClose()">
                            <thead>
                                <tr>
                                    <th class="col-select"><input type="checkbox" id="ChooseAll"
                                        ng-change="chooseAll()"
                                        ng-model="model.form.chooseAll" class="regular-checkbox" /><label
                                        for="ChooseAll"></label></th>
                                    <th  class="col-code"><?php echo STO0300_LABEL_STAFF_CODE; ?></th>
                                    <th><?php echo STO0300_LABEL_NAME; ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    ng-repeat="saleItem in model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore ">
                                    <td class="col-select"><input type="checkbox" ng-init="saleItem.choose =false"
                                        id="sale{{saleItem.salesmanId}}"
                                        ng-change="chooseSale(saleItem)"
                                        ng-model="saleItem.choose"
                                        class="regular-checkbox" /><label
                                        for="sale{{saleItem.salesmanId}}"></label></td>
                                    <td class="col-code">{{saleItem.salesmanCode}}</td>
                                    <td>{{saleItem.salesmanName}}</td>

                                </tr>
                                <!--Empty - Begin-->
                                <tr  ng-if="model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length== null">
                                    <td colspan="3"><?php echo COM0000_EMPTY_RESULT;?></td>
                                </tr>
                                <!--Empty - End-->
                            </tbody>
                        </table>
                        <div class="paging" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != null">
                             <ul class="pagination">
                                 <li class="disabled"><span>{{model.form.STO0320InitDataModel.searchResult.pagingInfo.stRow}}-{{model.form.STO0320InitDataModel.searchResult.pagingInfo.edRow}}/{{model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlRow}}</span></li>
                                 <li class="disabled" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == 1 || model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == null "><a href="#">&lt;&lt;</a></li>
                                 <li ng-click="startPage()" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != 1 && model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != null "><a href="#">&lt;&lt;</a></li>
                                 
                                 <li class="disabled" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == 1 || model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == null"><a href="#">&lt;</a></li>
                                 <li ng-click="prevPage()" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != 1 && model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != null "><a href="#">&lt;</a></li>
                                 
                                 <li class="disabled" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlPages || model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == null"><a href="#">&gt;</a></li>
                                 <li ng-click="nextPage()" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlPages && model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != null "><a href="#">&gt;</a></li>
                                 
                                 <li class="disabled"  ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlPages || model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage == null"><a href="#">&gt;&gt;</a></li>
                                 <li ng-click="endPage()" ng-if="model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlPages && model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage != null"><a href="#">&gt;&gt;</a></li>
                             </ul>
                         </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php }?>
</div>