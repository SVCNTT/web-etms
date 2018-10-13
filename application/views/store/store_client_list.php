<div class="panel-form">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="icon-list"> </span>
				<?php echo STO0300_LABEL_CLIENT_LIST; ?>
			</h3>
		</div>
		<div class="panel-body">
            <div class="modal-alert" ng-if="model.form.STO0310Alert.proResult.proFlg=='NG'">
                <div class="alert alert-danger fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">×</span><span class="sr-only"></span>
                    </button>
                    <div class="message">{{model.form.STO0310Alert.proResult.message}}</div>
                </div>
            </div>

            <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
			<div class="add-region">
				<div class="add-action">
					<ul>
						<li>
							<div>
								<?php echo STO0300_LABEL_CLIENT_TAB; ?>
							</div> <select chosen-select="model.form.STO0310InitDataModel.initData.clientInfo.clientList" chosen-width="65%"
							ng-model="model.hidden.selectedClient" data-placeholder="<?php echo STO0300_LABEL_CHOOSE_CLIENT; ?>"
							ng-options="item.clientId as item.clientName for item in model.form.STO0310InitDataModel.initData.clientInfo.clientList">
						</select>
							<button ng-click="regisClientStore()" ng-disabled="model.hidden.selectedClient == null"
								class="btn btn-default btn-sm  btn-success btn-width-default pull-right" style="margin-top: 0">
								<?php echo STO0300_BUTTON_ADD;?>
							</button>
						</li>
					</ul>

				</div>
			</div>
            <!-- </sec:authorize> -->

			<div class="list-client">
				<div class="div-scroll scrollbarCustom ">
					<ul class="list-ul-table ul-body" ng-repeat="clientItem in model.form.STO0310InitDataModel.initData.searchClientStore">
						<li class="">{{clientItem.clientName}}
                            <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')">  -->
                            <span 
							class="delete pull-right icon-close dropdown-toggle"  data-toggle="dropdown"></span>
							<div class="popover-confirm dropdown-menu">
								<div class="arrow"> </div>
								<div class="content-confirm">
									{{model.hidden.deleteConfirm.message}} 
								</div>
								<div class="button-group-action text-center">

                                    <button class="btn  btn-default btn-info btn-xs" ng-click="deleteClientStore(clientItem)" >
                                        <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                    </button>
									<button class="btn btn-default btn-danger btn-xs">
										<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
									</button>
							    	
								</div>
							</div>	
                            <!-- </sec:authorize> -->
						</li>
					</ul>
					
				</div>

			</div>

		</div>
	</div>
</div>