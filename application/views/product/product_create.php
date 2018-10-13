<div class="modal-confirm create-product">
	<div class="modal-info">
		<div class="header">
			<span ng-if="model.hidden.buttonModeAdd == true" class="title"
				class="pull-left"><?php echo PRO1120_LABEL_TITLE; ?>
			</span> <span ng-if="model.hidden.buttonModeAdd == false" class="title"
				class="pull-left"><?php echo PRO1120_LABEL_TITLE_UPDATE; ?>
			</span> <span class="pull-right close icon-close"
				ng-click="closeAddProduct()"></span>
		</div>
		<div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
		    <ul>
		    	<li ng-if="model.hidden.validated.productTypeId.isErrored == true">
		    	 	{{model.hidden.validated.productTypeId.msg}}
			    </li>
		    	<li ng-if="model.hidden.validated.productGroupId.isErrored == true">
		    	 	{{model.hidden.validated.productGroupId.msg}}
			    </li>
			     <li ng-if="model.hidden.validated.productModel.isErrored == true">
			    	 	{{model.hidden.validated.productModel.msg}}
			    </li>
			     <li ng-if="model.hidden.validated.productName.isErrored == true">
			    	 	{{model.hidden.validated.productName.msg}}
			    </li>
			     <li ng-if="model.hidden.validated.price.isErrored == true">
			    	 	{{model.hidden.validated.price.msg}}
			    </li>
			    
		    </ul>
		    
		</div>
		<div class="body">
			<div class="product-code">
				<span><?php echo PRO1120_LABEL_PRODUCT_TYPE; ?><span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
             
				:<select chosen-select="model.form.PRO1120InitData.proTypeList.productTypeList"
					data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_TYPE; ?>"
					chosen-width="245px"  ng-class="{'validate': model.hidden.validated.productTypeId.isErrored == true}"
					ng-model="model.form.PRO1120ModelAddProduct.productTypeId" ng-change="onchangeProductType(model.form.PRO1120ModelAddProduct.productTypeId)"
					ng-options="item.productTypeId as item.productTypeName for item in model.form.PRO1120InitData.proTypeList.productTypeList">
				</select>
			</div>
			
			<div class="product-code">
				<span><?php echo PRO1120_LABEL_PRODUCT_GROUP; ?><span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
             
				:<select chosen-select="model.form.PRO1120InitData.proGroupList.productGroupList"
					data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_GROUP; ?>"
					chosen-width="245px"  ng-class="{'validate': model.hidden.validated.productGroupId.isErrored == true}"
					ng-model="model.form.PRO1120ModelAddProduct.productGroupId"
					ng-options="item.productGroupId as item.productGroupName for item in model.form.PRO1120InitData.proGroupList.productGroupList">
				</select>
			</div>			
			<!-- <div class="product-code">
				<span><?php echo PRO1120_LABEL_PRODUCT_CODE; ?><span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
				:<input ng-model="model.form.PRO1120ModelAddProduct.productModel"  ng-class="{'validate': model.hidden.validated.productModel.isErrored == true}"
					type="text" class="form-control-dms">
			</div> -->
			<div class="product-name">
				<span><?php echo PRO1120_LABEL_PRODUCT_NAME; ?><span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
				:<input type="text"  ng-class="{'validate': model.hidden.validated.productName.isErrored == true}"
					ng-model="model.form.PRO1120ModelAddProduct.productName"
					class="form-control-dms">
			</div>
			<div class="product-price">
				<span><?php echo PRO1120_LABEL_PRODUCT_PRICE; ?><span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
				:<input type="text" ng-class="{'validate': model.hidden.validated.price.isErrored == true}"
					ng-model="model.form.PRO1120ModelAddProduct.price" numeric
					fcsa-number="{ maxDecimals: 0 }" class="form-control-dms currency">
			</div>
		</div>
		<div class="footer">
			<button ng-if="model.hidden.buttonModeAdd == true"
				ng-click="addProduct()"
				class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
				<?php echo PRO1120_BUTTON_CREAT; ?>
			</button>

			<button ng-if="model.hidden.buttonModeAdd == false"
				ng-click="updateProduct()"
				class="btn btn-default btn-sm  btn-warning btn-width-default pull-right">
				<?php echo PRO1120_BUTTON_EDIT; ?>
			</button>
		</div>
	</div>
</div>