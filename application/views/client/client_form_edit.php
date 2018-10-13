<div class="modal-confirm edit-client">
<div class="modal-info">
	<div class="header">
		<span class="title" class="pull-left"><?php echo CLI0310_LABEL_FORM; ?> </span> <span
			class="pull-right close icon-close"
			ng-click="closeEditClientModal()"></span>
	</div>
	
	<div class="body">
		<div class="form-create">
			<table class="table create-table create-client">
				<tr>
					<td><?php echo CLI0310_LABEL_CLIENT_NAME; ?><span
						class="required"><?php echo CLI0310_LABEL_REQUIRED; ?></span></td>
					<td>:<input type="text" name="clientName"
						ng-model="model.form.CLI0310InitOutputModel.clientInfo.clientInfo.clientName"
						class="form-control-dms width-250"></td>
				</tr>
				<tr>
					<td><?php echo CLI0310_LABEL_AVATAR; ?></td>
					<td><label class="pull-left">: </label>
						<div class="choose-file">
							<input ng-file-select="onFileSelect($files)" class="ng-hide"
								type="file" name="file" id="cli0310ChooseFile"> <a
								ng-click="chooseFile()" name="file"
								class="btn btn-default btn-sm btn-normal btn-width-default pull-left choose-file-custom">
								<span class="icon-folder"></span> <?php echo CLI0310_BUTTON_UPFILE; ?>
							</a>
						</div>

						<div class="image-choose">
							<img
								ng-if="model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath ==null"
								ng-src="{{model.hidden.no_img}}"> <img
								ng-if="model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath !=null"
								ng-src="{{model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath}}">
						</div>
					</td>
				</tr>
				<tr>
					<td><?php echo CLI0310_LABEL_RATE_POINT; ?> <span
						class="required"><?php echo CLI0310_LABEL_REQUIRED; ?></span></td>
					<td>:<input type="hidden" name="ratePoint"
						ng-model="model.form.CLI0310InitOutputModel.clientInfo.clientInfo.ratePoint"
						value="{{model.form.CLI0310InitOutputModel.clientInfo.clientInfo.ratePoint">
						<input numeric fcsa-number="{ maxDecimals: 0 }" type="text"
						ng-model="model.form.CLI0310InitOutputModel.clientInfo.clientInfo.ratePoint"
						class="currency form-control-dms width-250" required autofocus>
						<span> <?php echo CLI0310_LABEL_RATE_UNIT; ?></span></td>

				</tr>
			</table>
		</div>
	</div>
	<div class="footer">
		<button ng-click="updateClient()"
			class="btn btn-default btn-sm  btn-warning btn-width-default pull-right">
			<span class="fa fa-floppy-o"></span>
			<?php echo CLI0310_BUTTON_UPDATE; ?>
		</button>
	</div>
</div>
</div>