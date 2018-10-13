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
				<div class="list-pill-info list-product-type">
					<div class="div-scroll scrollbarCustom ">
						<ul class="list-ul-table ul-body" ng-repeat="itemType in model.form.CLI0363SelProTypeOutputModel.proTypeList.productTypeList">
							<li class="medicine_type_item" >
								<span>{{itemType.productTypeName}}<span
                                                class="required"><?php echo COMMON_REQUIRED; ?></span>:</span>
								<select id="{{itemType.productTypeId}}" 
									name="{{itemType.productTypeId}}" 
									chosen-select="model.form.CLI0363DocSelProTypeClassModel.classId"
                                    data-placeholder="Class"
                                    chosen-width="200px"
                                    ng-model="model.form.CLI0363DocSelProTypeClassModel.classId"
                                    ng-options="item.classId as item.className for item in model.form.CLI0363DocSelProTypeClassModel">
                                </select>
							</li>	
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>