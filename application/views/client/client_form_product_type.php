<div class="pill-info product-type">

	<div class="panel-form">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">  
					<span class="icon-list"> </span>
					<?php echo CLI0360_LABEL_PRODUCT_TYPE; ?>
				</h3>
			</div> 
			<div class="panel-body">
				
                <?php if (check_ACL($profile, 'dashboard', 'medicine_type_add')) {?>
				<div class="add-region">

					<div class="add-action">
						<ul>
							<li>
								<div class="field-type-name">
									<?php echo CLI0360_LABEL_PRODUCT_TYPE_NAME; ?>
									:
								</div> <input style="width:100%"
								placeholder="<?php echo CLI0360_LABEL_PRODUCT_TYPE_NAME; ?>"
								type="text"
								ng-model="model.form.CLI0360RegisInputModel.productTypeName"
								class="form-control-dms">
							</li>
						</ul>
						
						<ul class="group-action-btn">
							<li>
								<button ng-click="regisProductType()" ng-disabled="model.form.CLI0360RegisInputModel.productTypeName =='' || model.form.CLI0360RegisInputModel.productTypeName==null"
									class="btn btn-default btn-sm  btn-success btn-width-default">
									<?php echo CLI0360_BUTTON_ADD; ?>
								</button>
								
							</li>
						</ul>

					</div>
				</div>
                <?php }?>

				<div class="list-pill-info list-product-type">
					<div class="div-scroll scrollbarCustom ">
						<ul class="list-ul-table ul-body" ng-repeat="itemType in model.form.CLI0360SelProTypeOutputModel.proTypeList.productTypeList">
							<li class="medicine_type_item" ><span ng-click="getProductGroupList(itemType)">{{itemType.productTypeName	}}</span>
                                <?php if (check_ACL($profile, 'dashboard', 'medicine_type_del')) {?>
                                <span class="delete pull-right icon-close dropdown-toggle"  data-toggle="dropdown" style="right: 6px"></span>
								<div class="popover-confirm dropdown-menu">
									<div class="arrow"> </div>
									<div class="content-confirm">
										{{model.hidden.deleteConfirm.message}} 
									</div>
									<div class="button-group-action text-center">

                                        <button class="btn  btn-default btn-info btn-xs" ng-click="deleteProductType(itemType)">
                                            <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                        </button>
										<button class="btn btn-default btn-danger btn-xs">
											<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
										</button>
								    	
									</div>
								</div>	
                                <?php }?>

                                <?php if (check_ACL($profile, 'dashboard', 'medicine_type_edit')) {?>
                                <span	class="delete pull-right icon-note" ng-click="editProductType(itemType)" style="right: 6px"></span>
                                <?php }?>
							</li>
								
						</ul>
						
					</div>

				</div>

			</div>
		</div>

	</div>
	
	<div class="panel-form" style="width:53%;margin-right: 0px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span>
					<?php echo CLI0360_LABEL_PRODUCT_GROUP; ?>
				</h3>
			</div>
			<div class="panel-body">

                <?php if (check_ACL($profile, 'dashboard', 'medicine_type_add')) {?>
				<div class="add-region">

					<div class="add-action">
						<ul>
							<li>
								<div class="field-type-name">
									<?php echo CLI0360_LABEL_PRODUCT_GROUP_NAME; ?>
									:
								</div> <input style="width:100%"
								placeholder="<?php echo CLI0360_LABEL_PRODUCT_GROUP_NAME; ?>"
								type="text"
								ng-model="model.form.CLI0360RegisGroupInputModel.productGroupName"
								class="form-control-dms">
							</li>
						</ul>

						<ul class="group-action-btn">
							<li>
								<button ng-click="regisProductGroup()" ng-disabled="model.form.CLI0360RegisGroupInputModel.productGroupName =='' || model.form.CLI0360RegisGroupInputModel.productGroupName==null"
									class="btn btn-default btn-sm  btn-success btn-width-default">
									<?php echo CLI0360_BUTTON_ADD; ?>
								</button>

							</li>
						</ul>

					</div>
				</div>
                <?php }?>

				<div class="list-pill-info list-product-type">
					<div class="div-scroll scrollbarCustom ">
						<ul class="list-ul-table ul-body" ng-repeat="itemGroup in model.form.CLI0360SelProGroupOutputModel.proGroupList.productGroupList">
							<li class="">{{itemGroup.productGroupName	}}
                                <?php if (check_ACL($profile, 'dashboard', 'medicine_type_del')) {?>
                                <span class="delete pull-right icon-close dropdown-toggle"  data-toggle="dropdown" style="right: 6px;"></span>
                                <div class="popover-confirm dropdown-menu">
                                    <div class="arrow"> </div>
                                    <div class="content-confirm">
                                        {{model.hidden.deleteConfirm.message}}
                                    </div>
                                    <div class="button-group-action text-center">

                                        <button class="btn  btn-default btn-info btn-xs" ng-click="deleteProductGroup(itemGroup)">
                                            <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                        </button>
                                        <button class="btn btn-default btn-danger btn-xs">
                                            <span><?php echo COMMON_BUTTON_CANCEL; ?></span>
                                        </button>

                                    </div>
                                </div>
                                <?php }?>

                                <?php if (check_ACL($profile, 'dashboard', 'medicine_type_edit')) {?>
                                <span	class="delete pull-right icon-note" ng-click="editProductGroup(itemGroup)" style="right: 6px;"></span>
                                <?php }?>
							</li>

						</ul>

					</div>

				</div>

			</div>
		</div>

	</div>

</div>