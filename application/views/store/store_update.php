
<script src='//maps.googleapis.com/maps/api/js?sensor=false'></script>
	<div class="main-container">
		<div class="wrapper-container">
			<div class="content-list scrollbarCustom">
				<div class="create-client">
					<div class="breadcrums">
						<a class="btn btn-warning btn-sm  btn-width-default"
							href="/STO0100">
                            <?php echo STO0210_BUTTON_BACK; ?>
						</a>

					</div>
					<div class="panel-form">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									<span class="icon-pencil"> </span>
									<?php echo STO0210_LABEL_FORM; ?>
								</h3>
							</div>
							<div class="panel-body">
								<div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
								    <ul>
								    	<li ng-if="model.hidden.validated.storeName.isErrored == true">
								    	 	{{model.hidden.validated.storeName.msg}}
									    </li>
                                        <li ng-if="model.hidden.validated.zoneId.isErrored == true">
                                            {{model.hidden.validated.zoneId.msg}}
                                        </li>
                                        <li ng-if="model.hidden.validated.productTypeId.isErrored == true">
                                            {{model.hidden.validated.productTypeId.msg}}
                                        </li>
									     <li ng-if="model.hidden.validated.areaId.isErrored == true">
									    	 	{{model.hidden.validated.areaId.msg}}
									    </li>
								    </ul>
								    
								</div>
								<div class="form-create create-store">
									<div class="group">
										<div class="storename">
											<span><?php echo STO0210_LABEL_STORE_CODE; ?></span> <span>:&nbsp;&nbsp;{{model.form.STO0210SelectStoreResultDto.selectSore.storeCode}}</span>
										</div>
										<div class="storename">
											<span><?php echo STO0210_LABEL_STORE_NAME; ?><span
                                            class="required"><?php echo COMMON_REQUIRED; ?></span></span> :<input id="storeId"
												type="hidden" value="<?php echo $storeId; ?>"
												ng-model="model.hidden.storeId"> <input ng-class="{'validate': model.hidden.validated.storeName.isErrored == true}"
												ng-model="model.form.STO0210SelectStoreResultDto.selectSore.storeName"
												type="text" class="form-control-dms"
												value="{{model.form.STO0210SelectStoreResultDto.selectSore.storeName}}">
										</div>
										<div class="class">
											<span><?php echo STO0200_LABEL_DOCTOR_CLASS; ?></span> : 
												<input ng-model="model.form.STO0210SelectStoreResultDto.selectSore.classs"
												type="text" class="form-control-dms"
												value="{{model.form.STO0210SelectStoreResultDto.selectSore.classs}}">
										</div>	
										<div class="zone">
											<span><?php echo STO0200_LABEL_DOCTOR_ZONE; ?>
                                                <span class="required"><?php echo COMMON_REQUIRED; ?></span>
                                            </span> :
			                                <select chosen-select="model.form.STO0210InitDataOutputModel.initData.zoneList"
                                                    ng-class="{'validate': model.hidden.validated.zoneId.isErrored == true}"
			                                    data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_GROUP; ?>"
			                                    chosen-width="200px" 
			                                    ng-model="model.form.STO0210SelectStoreResultDto.selectSore.zoneId"
			                                    ng-options="item.zoneId as item.zoneName for item in model.form.STO0210InitDataOutputModel.initData.zoneList">
			                                </select>   
										</div>										
										<div class="bu">
											<span><?php echo STO0200_LABEL_DOCTOR_BU; ?>
                                                <span class="required"><?php echo COMMON_REQUIRED; ?></span>
                                            </span> :
			                                <select chosen-select="model.form.STO0210InitDataOutputModel.initData.productTypeList"
                                                    ng-class="{'validate': model.hidden.validated.productTypeId.isErrored == true}"
			                                    data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_GROUP; ?>"
			                                    chosen-width="200px" 
			                                    ng-model="model.form.STO0210SelectStoreResultDto.selectSore.productTypeId"
			                                    ng-options="item.productTypeId as item.productTypeName for item in model.form.STO0210InitDataOutputModel.initData.productTypeList">
			                                </select>   
										</div>
										<div class="region">
											<span><?php echo STO0210_LABEL_REGION; ?>
                                                <span class="required"><?php echo COMMON_REQUIRED; ?></span>
                                            </span>&nbsp;:
											<div class="my-areas btn-group my-button">
												<button type="button" ng-class="{'validate': model.hidden.validated.areaId.isErrored == true}"
													class="btn-default dropdown-toggle chooseRegion"
													data-toggle="dropdown" aria-expanded="false">
													{{model.hidden.defaultAreaName}}</button>
													<div class="my-areas-icon"><b></b></div>
												<ul class="dropdown-menu areaList scrollbarCustom" role="menu">
													<li
														ng-repeat="areaGroupItem in model.form.STO0210InitDataOutputModel.initData.areaInfo.items">
													<div class="groupAreaName "  ng-if="areaGroupItem.items.length>0"> {{areaGroupItem.areaName}}</div>
													 
														<div class="groupAreaName " ng-if="areaGroupItem.items.length==0 || areaGroupItem.items ==null"
															ng-click="chooseArea(areaGroupItem.areaName,areaGroupItem.areaId)">
															{{areaGroupItem.areaName}}</div>
														<ul class="area">
															<li
																ng-repeat="areaItem in areaGroupItem.items">
																<div class="areaName "
																	ng-click="chooseArea(areaItem.areaName,areaItem.areaId)">{{areaItem.areaName}}</div>
															</li>
														</ul>
													</li>

												</ul>
											</div>
										</div>

										<div class="address">
											<span><?php echo STO0210_LABEL_ADDRESS; ?></span>&nbsp;:
											<input
												ng-model="model.form.STO0210SelectStoreResultDto.selectSore.address"
												type="text" class="form-control-dms address"
												value="{{model.form.STO0210SelectStoreResultDto.selectSore.address}}">
	                                        <button ng-click="findLocationEdit()"
	                                            class="find_location btn btn-default btn-sm btn-normal btn-width-default ">
	                                            <?php echo STO0200_BUTTON_FIND_LOCATION; ?>
	                                        </button>
										</div>
										<div class="position">
											<span><?php echo STO0210_LABEL_POSITION; ?></span>&nbsp;:
                                            <input type="text" value="{{model.hidden.map.latitude}}"
												class="form-control-dms"
												ng-model="model.hidden.map.latitude"> <input
												type="text" value="{{model.hidden.map.longitude}}"
												class="form-control-dms"
												ng-model="model.hidden.map.longitude">
											<button ng-click="showLocation()"
												class="find_map btn btn-default btn-sm btn-normal btn-width-default ">
												<?php echo STO0210_BUTTON_FIND_MAP; ?>
											</button>
										</div>
										<i>{{model.form.clickAddress}}</i>
										<div class="map">
											<ui-gmap-google-map center="map.center" events="map.events"
												zoom="map.zoom" style="height:300px;width:600px">
											<ui-gmap-marker coords="marker.coords"
												options="marker.options" events="marker.events"
												idkey="marker.id"> </ui-gmap-marker> </ui-gmap-google-map>
										</div>

									</div>

                                <div class="group2 scrollbarCustom" ng-if="model.form.listPos.results">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item" ng-repeat="address in model.form.listPos.results | filter:{types:street_address}" ng-click="choosePos(address)">{{address.formatted_address}}</a>
                                    </div>
                                </div>
								</div>
							</div>
						</div>

					</div>

					<div class="btn-group-action"> 
						<button ng-click="updateStoreContinus()"
							class="btn btn-default btn-sm btn-success no-width ">
							<?php echo STO0210_BUTTON_CREAT_CONTINUE; ?>
						</button>
					</div>

				</div>
			</div>
		</div> 
	</div>
 