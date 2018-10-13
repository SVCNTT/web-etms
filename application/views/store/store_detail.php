
<div class="main-container">
	<div class="wrapper-container">
		<div>
			<div class="sidebar">
				<div class="store-info">
					<div class="store-header">
			            <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
						<a class="button-back"  href="/STO0100">
							<span class="icon-arrow-left"> </span>
						</a>

                        <?php if (check_ACL($profile, 'store', 'edit')) {?>
						<a class="button-edit pull-right" ng-if="model.form.STO0300SelectStoreResultDto.selectSore.isDoctor == '0'"  href="/STO0210/{{model.form.STO0300SelectStoreResultDto.selectSore.storeCode}}">
							<span class="icon-note"> </span>
						</a>
						<a class="button-edit pull-right"  ng-if="model.form.STO0300SelectStoreResultDto.selectSore.isDoctor == '1'"  href="/DOC0210/{{model.form.STO0300SelectStoreResultDto.selectSore.storeCode}}">
							<span class="icon-note"> </span>
						</a>
                        <?php }?>
						<span class="title" ng-if="model.form.STO0300SelectStoreResultDto.selectSore.isDoctor == '0'" ><?php echo STO0300_LABEL_FORM; ?></span>
						<span class="title" ng-if="model.form.STO0300SelectStoreResultDto.selectSore.isDoctor == '1'" ><?php echo STO0300_LABEL_FORM_DOCTOR; ?></span>
					</div>
                    <input id="storeId" type="hidden" value="<?php echo $storeId; ?>" ng-model="model.hidden.storeId"> 
					<div class="store-code">{{model.form.STO0300SelectStoreResultDto.selectSore.storeCode}}</div>
					<div class="store-name">{{model.form.STO0300SelectStoreResultDto.selectSore.storeName}}</div>
					<div class="doc-name">{{model.form.STO0300SelectStoreResultDto.selectSore.docName}}</div>
					<div class="title">{{model.form.STO0300SelectStoreResultDto.selectSore.title}}</div>
					<div class="position">{{model.form.STO0300SelectStoreResultDto.selectSore.position}}</div>
					<div class="specialty">{{model.form.STO0300SelectStoreResultDto.selectSore.specialty}}</div>
					<div class="department">{{model.form.STO0300SelectStoreResultDto.selectSore.department}}</div>
					<div class="hospital">{{model.form.STO0300SelectStoreResultDto.selectSore.hospital}}</div>
					<div class="classs">{{model.form.STO0300SelectStoreResultDto.selectSore.classs}}</div>
					<div class="zone">{{model.form.STO0300SelectStoreResultDto.selectSore.zone}}</div>
					<div class="bu">{{model.form.STO0300SelectStoreResultDto.selectSore.bu}}</div>
					
					<div class="store-address"  style="margin-top: 20px;">{{model.form.STO0300SelectStoreResultDto.selectSore.address}}</div>
					<div class="store-address area-name">{{model.form.STO0300SelectStoreResultDto.selectSore.areaName}}</div>
					<div class="map">
						<ui-gmap-google-map events="map.events" center="map.center"
							zoom="map.zoom" style="height:300px;width:600px">
						<ui-gmap-marker coords="marker.coords"
							options="marker.options" events="marker.events"
							idkey="marker.id"> </ui-gmap-marker> </ui-gmap-google-map>
					</div>

				</div>
			</div>
			<div class="content scrollbarCustom">
				<div class="tab-content">
					<div ng-init="activeTab =2" class="tabs">
						<ul>
							<li ng-class="{'active': activeTab ==2}"
								ng-click="activeTab =2;initTab2()"><?php echo STO0300_LABEL_STAFF_TAB; ?></li>
							<li ng-class="{'active': activeTab ==3}"
								ng-click="activeTab =3;initTab3()"><?php echo STO0300_LABEL_IMAGE_TAB; ?></li>

						</ul>
					</div>
					<div class="content-tab-product scrollbarCustom"
						ng-if="activeTab ==2">
						<div ng-include="'/STO0320'"  ng-controller="STO0320Ctrl" ng-init="init()" >  </div>
					</div>
					<div class="content-tab-info content-tab-product scrollbarCustom"
						ng-if="activeTab ==3">
						
						   <div ng-include="'/STO0330'"  ng-controller="STO0330Ctrl" ng-init="init()" >  </div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>