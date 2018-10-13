<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<div class="group-action">
			</div>

			<div class="panel-form">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="icon-list"> </span>
							<?php echo CLI0100_LABEL_FORM; ?>
						</h3>
					</div>
					<div class="panel-body">

						<div class="form-create">
							<table class="table create-table list-store-search">
								<tr>
									<td class="title"><?php echo CLI0100_LABEL_CLIENT_NAME; ?>
									</td>
									<td>
										<div>:
											<input type="text" class="form-control-dms width200 "
												ng-model="model.form.nameSearch"
												value='{{model.form.nameSearch}}'>
										</div>
									</td>
								</tr>
							</table>
							<div class="btn-action-search">
								<button class="btn btn-normal btn-sm btn-width-default"
									ng-click="search()">
<!--									<span class="icon-magnifier"> </span>-->
									<?php echo CLI0100_BUTTON_SEARCH; ?>
								</button>

                                <a class="btn btn-default btn-sm  btn-width-default btn-success" href="/CLI0200">
<!--                                    <span class="icon-plus"> </span>-->
                                    <?php echo CLI0100_BUTTON_CREAT; ?>
                                </a>
							</div>


						</div>
						<div class="result-search">
							<div class="table-region">
								<table
									class="list-table product-table table list-client table-striped table-bordered"
									ng-click="preventClose()">
									<thead>
										<tr>
											<th ng-click="sortName()"><i
												ng-if="model.hidden.sortName==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortName==true"
												class="fa fa-chevron-down"></i><?php echo CLI0100_LABEL_AVATAR; ?></th>
											<th ng-click="sortCode()"><i
												ng-if="model.hidden.sortCode==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortCode==true"
												class="fa fa-chevron-down"></i> <?php echo CLI0100_LABEL_NAME;?></th>
											<th ng-click="sortCode()"><i
												ng-if="model.hidden.sortCode==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortCode==true"
												class="fa fa-chevron-down"></i><?php echo CLI0100_LABEL_NAME_TYPE; ?></th>
											<th ng-click="sortName()"><i
												ng-if="model.hidden.sortName==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortName==true"
												class="fa fa-chevron-down"></i> <?php echo CLI0100_LABEL_RATE_POINT; ?></th>
											<th ng-click="sortName()"><i
												ng-if="model.hidden.sortName==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortName==true"
												class="fa fa-chevron-down"></i> <?php echo CLI0100_LABEL_MANAGER_REGION; ?></th>
											<th ng-click="sortName()"><i
												ng-if="model.hidden.sortName==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortName==true"
												class="fa fa-chevron-down"></i> <?php echo CLI0100_LABEL_MANAGER_SALE; ?></th>
                                            <th  style="width: 100px"><?php echo CLI0100_LABEL_SUB_LEADER; ?></th>
											<th ng-click="sortName()"><i
												ng-if="model.hidden.sortName==false"
												class="fa fa-chevron-up"></i> <i
												ng-if="model.hidden.sortName==true"
												class="fa fa-chevron-down"></i> <?php echo CLI0100_LABEL_SALE; ?></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-class="{'active': $index == model.hidden.activeRow}"
											ng-repeat="clientItem in model.form.CLI0100InitDataModel.cliInfo.clientList">
											<td><img ng-src="{{clientItem.imageUrl}}"></td>
											<!-- <td ng-click="showPopupDetail(clientItem)" class="link">{{clientItem.clientName}}</td> -->
											<td><a
												href="/CLI0300/{{clientItem.clientCode}}">{{clientItem.clientName}}</a></td>
											<td>{{clientItem.clientTypeName}}</td>
											<td>{{clientItem.ratePoint | noFractionCurrency:""}}</td>
											<td>{{clientItem.numSaleManManager|number}}</td>
											<td>{{clientItem.numSaleManLeader|number}}</td>
                                            <td>{{clientItem.numSaleManSubLeader|number}}</td>
											<td>{{clientItem.numSaleMan|number}}</td>
										</tr>
		                                <!--Empty - Begin-->
		                                <tr  ng-if="model.form.CLI0100InitDataModel.cliInfo.clientList.length == null">
		                                    <td colspan="8"><?php echo COM0000_EMPTY_RESULT;?></td>
		                                </tr>
		                                <!--Empty - End-->

									</tbody>
								</table>
								<div class="paging"
									ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage != null">
									<ul class="pagination">
										<li class="disabled"><span>{{model.form.CLI0100InitDataModel.pagingInfo.stRow}}-{{model.form.CLI0100InitDataModel.pagingInfo.edRow}}/{{model.form.CLI0100InitDataModel.pagingInfo.ttlRow}}</span></li>
										<li class="disabled"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage == 1 || model.form.CLI0100InitDataModel.pagingInfo.crtPage == null "><a
											href="#">&lt;&lt;</a></li>
										<li ng-click="startPage()"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage != 1 && model.form.CLI0100InitDataModel.pagingInfo.crtPage != null "><a
											href="#">&lt;&lt;</a></li>

										<li class="disabled"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage == 1 || model.form.CLI0100InitDataModel.pagingInfo.crtPage == null"><a
											href="#">&lt;</a></li>
										<li ng-click="prevPage()"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage != 1 && model.form.CLI0100InitDataModel.pagingInfo.crtPage != null "><a
											href="#">&lt;</a></li>

										<li class="disabled"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage == model.form.CLI0100InitDataModel.pagingInfo.ttlPages || model.form.CLI0100InitDataModel.pagingInfo.crtPage == null"><a
											href="#">&gt;</a></li>
										<li ng-click="nextPage()"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage != model.form.CLI0100InitDataModel.pagingInfo.ttlPages && model.form.CLI0100InitDataModel.pagingInfo.crtPage != null "><a
											href="#">&gt;</a></li>

										<li class="disabled"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage == model.form.CLI0100InitDataModel.pagingInfo.ttlPages || model.form.CLI0100InitDataModel.pagingInfo.crtPage == null"><a
											href="#">&gt;&gt;</a></li>
										<li ng-click="endPage()"
											ng-if="model.form.CLI0100InitDataModel.pagingInfo.crtPage != model.form.CLI0100InitDataModel.pagingInfo.ttlPages && model.form.CLI0100InitDataModel.pagingInfo.crtPage != null"><a
											href="#">&gt;&gt;</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>
