<div class="main-container">
<div class="wrapper-container">
	<div>
		<div class="sidebar">
			<div class="customer-info">
				<div class="customer-header">
					<a style="font-size: 15px;" class="button-back pull-left"  href="/SAL0100">
                        <span class="icon-arrow-left"> </span>
                    </a>
					<span class="title"><?php echo SAL0300_LABEL_FORM; ?></span>

                    <?php if (check_ACL($profile, 'sale', 'edit')) {?>
					<button class="button-edit pull-right"
						ng-click="showModalEditSale()">
						<span  class="icon-note"> </span>
					</button>
                    <?php }?>

                    <?php if (check_ACL($profile, 'sale', 'resetpass')) {?>
					<button class="button-edit pull-right"
						ng-click="resetPasswordSale()">
						<span class="icon-key"> </span>
					</button>
                    <?php }?>

				</div>
				<!-- START param sale from server -->
				<input id="salesmanId" type="hidden"
						value="<?php echo $salesmanId; ?>"
						ng-model="model.hidden.salesmanId">
				<input id="salesmanCode" type="hidden"
						value="<?php echo $salesmanCode; ?>"
						ng-model="model.hidden.salesmanCode">
				<input id="salesmanName" type="hidden"
						value="<?php echo $salesmanName; ?>"
						ng-model="model.hidden.salesmanName">
				<input id="email" type="hidden"
						value="<?php echo  $email; ?>"
						ng-model="model.hidden.email">
				<input id="mobile" type="hidden"
						value="<?php echo  $mobile; ?>"
						ng-model="model.hidden.mobile">

				 <input id="location" type="hidden"
						value="<?php echo $location;?>"
						ng-model="model.hidden.location">

				<input id="gender" type="hidden"
					value="<?php echo $gender; ?>"
					ng-model="model.hidden.gender">

					<input id="jobTitle" type="hidden"
						 value="<?php echo $jobTitle;?>"
						 ng-model="model.hidden.jobTitle">

				<input id="imei" type="hidden"
					value="<?php echo $imei; ?>"
					ng-model="model.hidden.imei">
				<!-- END param sale from server -->
				<div class="customer-code"><?php echo $salesmanCode; ?></div>
				<div class="customer-name">
					<h4><?php echo $salesmanName; ?></h4>
				</div>
			    <div class="customer-logo">
			    	<?php if (!is_null($imagePath)){?> 
                        <img ng-src="{{model.hidden.imageUrl}}">
                        <input id="imageSale" type="hidden" value="../<?php echo $imagePath;?> " ng-model="model.hidden.imageUrl">
                    <?php }?>
                </div>
				<div class="customer-code"><?php echo $mobile; ?></div>
				<div class="customer-code"><?php echo $email; ?></div>
			</div>
		</div>
		<div class="content scrollbarCustom">
			<div class="tab-content">
				<div ng-init="activeTab =1" class="tabs">
					<ul>
						<li ng-class="{'active': activeTab ==1}" ng-click="activeTab =1"><?php echo SAL0300_LABEL_INFO_TAB; ?></li>
						<li ng-class="{'active': activeTab ==2}" ng-click="activeTab =2"><?php echo SAL0300_LABEL_VACATION_TAB; ?></li> 
					</ul>
				</div>
				<div class="content-tab-product scrollbarCustom" ng-if="activeTab ==1">
					 <div  ng-include="'/SAL0330'"  ng-controller="SAL0330Ctrl" ng-init="init()" >  </div>
				</div>
				<div class="content-tab-product scrollbarCustom" ng-if="activeTab ==2">  <div ng-include="'/SAL0340'"  ng-controller="SAL0340Ctrl" ng-init="init()" >  </div>
				</div>

			</div>
			
		</div>
	</div>
</div>
</div>
			
<!--  START SAL0310  -->
<div ng-if="model.hidden.showSAL0310"
	ng-include="'/SAL0310'" ng-controller="SAL0310Ctrl"
	ng-init="init()"></div>
<!--  START SAL0310  -->
<div ng-if="model.hidden.showSAL0320"
	ng-include="'/SAL0320'" ng-controller="SAL0320Ctrl"
	ng-init="init()"></div> 