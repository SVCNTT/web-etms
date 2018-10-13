<div class="panel-form" >
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span data-icon="&#xe067;"> </span>
                <?php echo PRO1100_LABEL_TITLE; ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="form-create">
                    <table class="table list-user-search create-table">
                        <tbody>
                        <tr>
                        <td class="title">
                            <?php echo PRO1120_LABEL_PRODUCT_TYPE; ?>
                        </td>
                            <td>
                            <div>:
			                <select chosen-select="model.form.InitData.productTypeLst"
			                    data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_TYPE; ?>"
			                    chosen-width="180px" 
			                    ng-model="model.hidden.productTypeId"
			                    ng-options="item.productTypeId as item.productTypeName for item in model.form.InitData.productTypeLst">
			                </select>
                            </div>
                        </td>
                      
                        <td class="title">
                            <?php echo PRO1100_LABEL_PRODUCT_NAME_FILTER; ?>
                            </td>
                            <td>
                            <div>:
                                <input type="text" ng-enter="searchPRO1100()"
                            ng-model="model.form.PRO1100ParamSearch.searchInput.productName"
                                class="form-control-dms">
                            </div>
                        </td>

                        <td class="title">
                            <?php echo PRO1100_LABEL_PRODUCT_GROUP; ?>
                            </td>
                            <td>
                            <div>:
                                <select chosen-select="model.form.InitData.productGroupLst"
                                    data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_GROUP; ?>"
                                    chosen-width="180px" 
                                    ng-model="model.hidden.productGroupId"
                                    ng-options="item.productGroupId as item.productGroupName for item in model.form.InitData.productGroupLst">
                                </select>                            
                            </div>
                            </td>
                          </tr>  
                        </tbody>
                    </table> 
                <div class="btn-action-search">
                    <button class="btn btn-normal btn-sm btn-width-default"
                        ng-click="searchPRO1100()">
                        <?php echo PRO1100__BUTTON_SEARCH; ?>
                    </button>

                    <?php if (check_ACL($profile, 'dashboard', 'medicine_import')) {?>
                    <button ng-click="importProduct()"
                        class="btn btn-default btn-sm  btn-info btn-width-default">
                        <?php echo CLI0300_BUTTON_CHOOSE_FILE; ?>
                    </button>
                    <?php }?>

                    <?php if (check_ACL($profile, 'dashboard', 'medicine_add')) {?>
                    <button ng-click="showCreatePro()"
                        class="btn btn-default btn-sm  btn-width-default btn-success">
                        <?php echo CLI0300_BUTTON_CREAT; ?>
                    </button>
                    <?php }?>
                </div>
            </div>

            <div class="result-search">
                <div class="table-region">

                    <table
                        class="list-table product-table table table-striped table-bordered"
                        ng-click="preventClose()">
                        <thead>
                            <tr>
                            	  <th> <?php echo PRO1100_LABEL_PRODUCT_TYPE; ?></th>
                                 <th ng-click="sortName()"><i
                                    ng-if="model.hidden.sortName==false" class="fa fa-chevron-up"></i>
                                    <i ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>
                                <?php echo PRO1100_LABEL_PRODUCT_NAME; ?></th>

                             <th ng-click="sortGroupName()"><i
                                    ng-if="model.hidden.sortGroupName==false" class="fa fa-chevron-up"></i>
                                    <i ng-if="model.hidden.sortGroupName==true"
                                    class="fa fa-chevron-down"></i> <?php echo PRO1100_LABEL_PRODUCT_GROUP_NAME; ?></th>
                             
                                <th ng-click="sortPrice()" class="numeric-text"><i
                                    ng-if="model.hidden.sortPrice==false" class="fa fa-chevron-up"></i>
                                    <i ng-if="model.hidden.sortPrice    ==true"
                                    class="fa fa-chevron-down"></i> <?php echo PRO1100_LABEL_PRODUCT_PRICE; ?></th>

                                <?php if (check_ACL($profile, 'dashboard', 'medicine_del') || check_ACL($profile, 'dashboard', 'medicine_edit')) {?>
                                    <th style="width: 6%;">Action</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-class="{'active': $index == model.hidden.activeRow}"
                                ng-repeat="productItem in model.form.PRO1100SearchDataModel.productInfoList ">
                                <td>{{productItem.pproductTypeName}}</td>
                                <td>{{productItem.productName}}</td>
                                <td>{{productItem.productGroupName}}</td>
                                <!-- <td>{{productItem.productModel}}</td> -->
                               
                                <td class="numeric-text">{{productItem.price | noFractionCurrency:""}} 
                                </td>
                                <?php if (check_ACL($profile, 'dashboard', 'medicine_del') || check_ACL($profile, 'dashboard', 'medicine_edit')) {?>
                                <td>
                                    <?php if (check_ACL($profile, 'dashboard', 'medicine_del')) {?>
                                    <span style="position: relative"
                                     class="delete-product pull-right icon-close dropdown-toggle"  data-toggle="dropdown"></span>
                                    <div class="popover-confirm dropdown-menu">
										<div class="arrow"> </div>
										<div class="content-confirm">
											{{model.hidden.deleteConfirm.message}} 
										</div>
										<div class="button-group-action text-center">

                                            <button class="btn  btn-default btn-info btn-xs" ng-click="deleteProduct(productItem)">
                                                <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                            </button>
											<button class="btn btn-default btn-danger btn-xs">
												<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
											</button>
									    	
										</div>
									</div>
                                    <?php }?>

                                    <?php if (check_ACL($profile, 'dashboard', 'medicine_edit')) {?>
                                    <span  style="position: relative" class="edit-product pull-right icon-note"
                                    ng-click="showModalEditPro(productItem)"></span> 
                                    <?php }?>
                                </td>
                                <?php }?>
                            </tr>

                            <!--Empty - Begin-->
                            <tr ng-if="model.form.PRO1100SearchDataModel.pagingInfo.ttlRow == 0">
                                <td colspan="7"><?php echo COM0000_EMPTY_RESULT;?></td>
                            </tr>
                            <!--Empty - End-->

                        </tbody>
                    </table>
                    
                    
                    <div class="paging" ng-if="model.form.PRO1100SearchDataModel.pagingInfo.ttlRow > 0">
                        <ul class="pagination">
                            <li class="disabled"><span>{{model.form.PRO1100SearchDataModel.pagingInfo.stRow}}-{{model.form.PRO1100SearchDataModel.pagingInfo.edRow}}/{{model.form.PRO1100SearchDataModel.pagingInfo.ttlRow}}</span></li>
                            <li class="disabled"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage == 1 || model.form.PRO1100SearchDataModel.pagingInfo.crtPage == null"><a
                                href="#">&lt;&lt;</a></li>
                            <li ng-click="startPagePRO1100()"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage != 1 && model.form.PRO1100SearchDataModel.pagingInfo.crtPage != null"><a
                                href="#">&lt;&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage == 1 || model.form.PRO1100SearchDataModel.pagingInfo.crtPage == null"><a
                                href="#">&lt;</a></li>
                            <li ng-click="prevPagePRO1100()"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage != 1 && model.form.PRO1100SearchDataModel.pagingInfo.crtPage != null"><a
                                href="#">&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage == model.form.PRO1100SearchDataModel.pagingInfo.ttlPages || model.form.PRO1100SearchDataModel.pagingInfo.crtPage == null"><a
                                href="#">&gt;</a></li>
                            <li ng-click="nextPagePRO1100()"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage != model.form.PRO1100SearchDataModel.pagingInfo.ttlPages && model.form.PRO1100SearchDataModel.pagingInfo.crtPage != null"><a
                                href="#">&gt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage == model.form.PRO1100SearchDataModel.pagingInfo.ttlPages || model.form.PRO1100SearchDataModel.pagingInfo.crtPage == null"><a
                                href="#">&gt;&gt;</a></li>
                            <li ng-click="endPagePRO1100()"
                                ng-if="model.form.PRO1100SearchDataModel.pagingInfo.crtPage != model.form.PRO1100SearchDataModel.pagingInfo.ttlPages && model.form.PRO1100SearchDataModel.pagingInfo.crtPage != null"><a
                                href="#">&gt;&gt;</a></li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>