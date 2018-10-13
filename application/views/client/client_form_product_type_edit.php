<div class="modal-confirm create-product"
	>
	<div class="modal-info">
		<div class="header">
			 <span class="title"
				class="pull-left"><?php echo CLI0361_LABEL_TITLE_UPDATE; ?>
			</span> <span class="pull-right close icon-close"
				ng-click="closeUpdateProductTypeModal()"></span>
		</div>
		
		<div class="body">
			
			<div class="rival-name">
				<span style="min-width:50px !important"><?php echo CLI0370_LABEL_NAME; ?>:</span>
				<input type="text"
					ng-model="model.form.CLI0361UpdateProductType.productTypeName"  class="form-control-dms">
			</div>
		</div>
		<div class="footer">
			<button 
				ng-click="updateProductType()" ng-disabled="model.form.CLI0361UpdateProductType.productTypeName == null || model.form.CLI0361UpdateProductType.productTypeName ==''"
				class="btn btn-default btn-sm  btn-warning btn-width-default pull-right">
				<?php echo CLI0361_BUTTON_EDIT; ?>
			</button>
		</div>
	</div>
</div>