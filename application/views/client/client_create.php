<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<form method="post" id="fromFileUpload" name="fromFileUpload" 
				modelAttribute="regisClient" enctype="multipart/form-data"
				action="/CLI0200">
				<div class="create-client">
					<div class="breadcrums">
						<a class="btn btn-warning btn-sm  btn-width-default"
							href="/CLI0100"> <span
							class="icon-arrow-left"> </span> <?php echo CLI0200_BUTTON_BACK; ?>
						</a>

					</div>
					<div class="panel-form">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									<span class="icon-plus"> </span>
									<?php echo CLI0200_LABEL_FORM; ?>
								</h3>
							</div>
							<div class="panel-body">
								<?php if (!empty($message)) {?>
									<?php if ($message["proFlg"] == 'NG') { ?>
										<div class="modal-alert">
											<div class="alert alert-danger fade in" role="alert">
												<button type="button" class="close" data-dismiss="alert">
													<span aria-hidden="true">×</span><span class="sr-only"></span>
												</button>
												<div class="message green"><?php echo $message["message"]; ?></div>

											</div>
										</div>
									<?php } ?>
									<?php if ($message["proFlg"] == 'OK') { ?>
										<div class="modal-alert">
											<div class="alert alert-success fade in" role="alert">
												<button type="button" class="close" data-dismiss="alert">
													<span aria-hidden="true">×</span><span class="sr-only"></span>
												</button>
												<div class="message green"><?php echo $message["message"]; ?></div>


											</div>
										</div>
									<?php } ?>

								<?php } ?>
								<div class="form-create">
									<table class="table create-table create-client">
										<tr>
											<td><?php echo CLI0200_LABEL_CLIENT_NAME; ?><span
												class="required"><?php echo CLI0200_LABEL_REQUIRED; ?></span></td>
											<td>:<input type="text" name="clientName" value="<?php echo $clientName; ?>" 
												class="form-control-dms width-250" required autofocus>
											</td>
										</tr>
										<tr>
											<td><?php echo CLI0200_LABEL_AVATAR; ?></td>
											<td><label class="pull-left">: </label>
												<div class="choose-file">
													<input ng-file-select="onFileSelect($files)"
														class="ng-hide" type="file" name="file" id="ChooseFile">
													<a ng-click="chooseFile()" name="file"
														class="btn btn-default btn-sm btn-normal btn-width-default pull-left choose-file-custom">
														<span class="icon-folder"></span> <?php echo CLI0200_BUTTON_UPFILE; ?>
													</a>
												</div>

												<div class="image-choose">

													<img ng-if="model.form.urlImage ==null"
														ng-src="{{model.hidden.no_img}}"> <img
														ng-if="model.form.urlImage !=null"
														ng-src="{{model.form.urlImage}}">
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo CLI0200_LABEL_RATE_POINT; ?>
												<span class="required"><?php echo CLI0200_LABEL_REQUIRED; ?></span></td>
											<td>:<input type="hidden" name="ratePoint"
												ng-model="model.form.ratePoint"
												value="{{model.form.ratePoint}}"> <input numeric
												fcsa-number="{ maxDecimals: 0 }" type="text"
												ng-model="model.form.ratePoint"
												class="currency form-control-dms width-250" required
												autofocus> <span> <?php echo CLI0200_LABEL_RATE_UNIT; ?></span></td>

										</tr>
										<tr>
											<td><?php echo CLI0200_CLIENT_TYPE; ?></td>
											<td>:<select
												chosen-select="model.form.CLI0200InitOutputModel.clientType"
												ng-model="model.form.clientType" chosen-width="250px"
											
												data-placeholder="<?php echo CLI0200_LABEL_CHOOSE_CLIENT_TYPE; ?>"
												ng-options="item.codeCd as item.dispText for item in model.form.CLI0200InitOutputModel.clientType">
											</select> <input type="hidden" name="clienType"
												ng-model="model.form.clientType"
												value="{{model.form.clientType}}"></td>

										</tr>
									</table>
								</div>
							</div>
						</div>

					</div>

					<div class="btn-group-action">
						<button type="submit" name="save" value="save"
							class="btn btn-default btn-sm btn-success btn-width-default ">
							<span class="icon-plus"></span>
							<?php echo CLI0200_BUTTON_CREAT; ?>
						</button>
						<button type="submit" name="saveContinus" value="saveContinus"
							class="btn btn-default btn-sm btn-success  no-width ">
							<?php echo CLI0200_BUTTON_CREAT_CONTINUE; ?>
						</button>
					</div>

				</div>
			</form>
		</div>
	</div>


</div>
