
 <script src='//maps.googleapis.com/maps/api/js?sensor=false'></script> 
<div class="main-container">
	<div class="wrapper-container">
		<div class="content-list scrollbarCustom">
			<div class="create-client">
				<div class="breadcrums">
					<a class="btn btn-warning btn-sm  btn-width-default" href="<?php echo site_url('STO0100');?>">
                        <?php echo STO0200_BUTTON_BACK; ?>
					</a>

				</div>
				<div class="panel-form">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="icon-plus"> </span>
								<?php echo STO0200_LABEL_FORM_DOCTOR; ?>
							</h3>
						</div>
						<div class="panel-body">
						<div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
							    <ul>
							    	<li ng-if="model.hidden.validated.docName.isErrored == true">
							    	 	{{model.hidden.validated.docName.msg}}
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
								<div class="group col-sm-6">
									<div class="docname">
										<span><?php echo STO0200_LABEL_STORE_NAME; ?> <span
                                        class="required"><?php echo COMMON_REQUIRED; ?></span></span> :<input ng-class="{'validate': model.hidden.validated.docName.isErrored == true}"
											ng-model="model.form.STO0200CreateStoreInputModel.docName"
											type="text" class="form-control-dms">
									</div>
									<div class="title">
										<span><?php echo STO0200_LABEL_DOCTOR_TITLE; ?></span> :<input 
											ng-model="model.form.STO0200CreateStoreInputModel.title"
											type="text" class="form-control-dms">
									</div>
									<div class="leval">
										<span><?php echo STO0200_LABEL_DOCTOR_POSITION; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.position"
											type="text" class="form-control-dms">
									</div>
									<div class="specialty">
										<span><?php echo STO0200_LABEL_DOCTOR_SPECIALTY; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.specialty"
											type="text" class="form-control-dms">
									</div>	
									<div class="department">
										<span><?php echo STO0200_LABEL_DOCTOR_DEPARTMENT; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.department"
											type="text" class="form-control-dms">
									</div>
									<div class="class">
										<span><?php echo STO0200_LABEL_DOCTOR_CLASS; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.classs"
											type="text" class="form-control-dms">
									</div>									
									<div class="hospital">
										<span><?php echo STO0200_LABEL_DOCTOR_HOSPITAL; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.hospital"
											type="text" class="form-control-dms">
									</div>	
									<div class="zone">
										<span><?php echo STO0200_LABEL_DOCTOR_ZONE; ?> <span
                                                class="required"><?php echo COMMON_REQUIRED; ?></span></span> :
											<select chosen-select="model.form.STO0200InitDataOutputModel.initData.zoneList"
                                                    ng-class="{'validate': model.hidden.validated.zoneId.isErrored == true}"
			                                    data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_GROUP; ?>"
			                                    chosen-width="200px" 
			                                    ng-model="model.form.STO0200CreateStoreInputModel.zoneId"
			                                    ng-options="item.zoneId as item.zoneName for item in model.form.STO0200InitDataOutputModel.initData.zoneList">
			                                </select>   
									</div>	
									<div class="bu">
											<span><?php echo STO0200_LABEL_DOCTOR_BU; ?> <span
                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span> :
			                                <select chosen-select="model.form.STO0200InitDataOutputModel.initData.productTypeList"
                                                    ng-class="{'validate': model.hidden.validated.productTypeId.isErrored == true}"
			                                    data-placeholder="<?php echo PRO1120_LABEL_CHOOSE_PRODUCT_GROUP; ?>"
			                                    chosen-width="200px" 
			                                    ng-model="model.form.STO0200CreateStoreInputModel.productTypeId"
			                                    ng-options="item.productTypeId as item.productTypeName for item in model.form.STO0200InitDataOutputModel.initData.productTypeList">
			                                </select>   
									</div>									
									<!-- <div class="mr">
										<span><?php echo STO0200_LABEL_DOCTOR_MR; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.mr"
											type="text" class="form-control-dms">
									</div>
									<div class="bu">
										<span><?php echo STO0200_LABEL_DOCTOR_BU; ?></span> :<input
											ng-model="model.form.STO0200CreateStoreInputModel.bu"
											type="text" class="form-control-dms">
									</div>		 -->							
									<div class="region">
										<span><?php echo STO0200_LABEL_REGION; ?> <span
                                        class="required"><?php echo COMMON_REQUIRED; ?></span></span>

										:<div class="my-areas btn-group my-button">
											<button type="button"
												class="dropdown-toggle chooseRegion" ng-class="{'validate': model.hidden.validated.areaId.isErrored == true}"
												data-toggle="dropdown" aria-expanded="false">
												{{model.hidden.defaultAreaName}}
											</button>
											<div class="my-areas-icon"><b></b></div>
											<ul class="dropdown-menu areaList scrollbarCustom" role="menu">
												<li ng-repeat="areaGroupItem in model.form.STO0200InitDataOutputModel.initData.areaInfo.items" >
													<div class="groupAreaName "  ng-if="areaGroupItem.items.length>0"> {{areaGroupItem.areaName}}</div>
												     <div class="groupAreaName " ng-if="areaGroupItem.items.length==0 || areaGroupItem.items ==null"  ng-click="chooseArea(areaGroupItem.areaName,areaGroupItem.areaId)"> {{areaGroupItem.areaName}}    </div>
												     <ul class="area">
												         <li ng-repeat="areaItem in areaGroupItem.items">
												             <div class="areaName " ng-click="chooseArea(areaItem.areaName,areaItem.areaId)">{{areaItem.areaName}}</div>
												         </li>
												     </ul>
												</li>
												
											</ul>
										</div>
									
									</div>
									<div class="address">
										<span><?php echo STO0200_LABEL_ADDRESS; ?></span>
										:<input
											ng-model="model.form.STO0200CreateStoreInputModel.adress"
											type="text" class="form-control-dms address">
                                        <button ng-click="findLocation()"
                                            class="find_location btn btn-default btn-sm btn-normal btn-width-default ">
                                            <?php echo STO0200_BUTTON_FIND_LOCATION; ?>
                                        </button>
									</div>


									<div class="position">
										<span><?php echo STO0200_LABEL_POSITION; ?>
											</span> :<input type="text" value={{map.center.latitude}}
											class="form-control-dms"
											ng-model="model.hidden.map.latitude"> <input
											type="text" value={{map.center.longitude}}
											class="form-control-dms"
											ng-model="model.hidden.map.longitude">
										<button ng-click="showLocation()"
											class="find_map btn btn-default btn-sm btn-normal btn-width-default ">
											<?php echo STO0200_BUTTON_FIND_MAP; ?>
										</button>
									</div>
                                    <i>{{model.form.clickAddress}}</i>
									<div class="map">
										<ui-gmap-google-map events="map.events" center="map.center"
											zoom="map.zoom" style="height:300px;width:600px">
										<ui-gmap-marker coords="marker.coords"
											options="marker.options" events="marker.events"
											idkey="marker.id"> </ui-gmap-marker> </ui-gmap-google-map>
									</div>

								</div>
								<div  class="col-sm-5">
									<div ng-include="'/CLI0363'" ng-controller="CLI0363Ctrl" ng-init="init()" > </div>
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

					<button ng-click="createStore()"
						class="btn btn-default btn-sm btn-success btn-width-default ">
						<?php echo STO0200_BUTTON_CREAT; ?>
					</button>
					<button ng-click="createStoreContinus()"
						class="btn btn-default btn-sm btn-success no-width ">
						<?php echo STO0200_BUTTON_CREAT_CONTINUE; ?>
					</button>
				</div>

			</div>
		</div>
	</div>
</div>