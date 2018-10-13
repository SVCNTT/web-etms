<div class="modal-confirm create-password edit-sale">
    <div class="modal-info">
        <div class="header">
            <span class="title" class="pull-left"><?php echo SAL0320_LABEL_FORM; ?> </span> <span 
                class="pull-right close icon-close" ng-click="closeEdit()"></span>
        </div>
        <div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
		    <ul>
		    	<li ng-if="model.hidden.validated.salesmanName.isErrored == true">
		    	 	{{model.hidden.validated.salesmanName.msg}}
			    </li>
			     <li ng-if="model.hidden.validated.email.isErrored == true">
				 	{{model.hidden.validated.email.msg}}
			    </li>
			    <li ng-if="model.hidden.validated.checkEmail.isErrored == true">
			    	 	{{model.hidden.validated.checkEmail.msg}}
			    </li>
			    <li ng-if="model.hidden.validated.mobile.isErrored == true">
			    	 	{{model.hidden.validated.mobile.msg}}
			    </li>

			    
			    
		    </ul>
		    
		</div>
        <div class="body">
            <div class="sale-code">
                <span><?php echo SAL0320_LABEL_SALE_CODE; ?></span>
                :{{model.form.SAL0320UpdateSaleInputModel.salesmanCode}}
            </div>
            <div class="sale-name">
                <span><?php echo SAL0320_LABEL_SALE_NAME; ?> <span
                                                    class="required"><?php echo USR0200_LABEL_REQUIRED; ?></span></span>
                :<input type="text"  ng-class="{'validate': model.hidden.validated.salesmanName.isErrored == true}"
                    ng-model="model.form.SAL0320UpdateSaleInputModel.salesmanName"
                    class="form-control-dms width200" >
            </div>
             <div class="sale-email">
                <span><?php echo SAL0320_LABEL_SALE_EMAIL; ?> <span
                                                    class="required"><?php echo USR0200_LABEL_REQUIRED; ?></span></span>
                :<input type="text" ng-class="{'validate': model.hidden.validated.email.isErrored == true ||  model.hidden.validated.checkEmail.isErrored == true}"
                    ng-model="model.form.SAL0320UpdateSaleInputModel.email"
                    class="form-control-dms width200">
            </div>
             <div class="sale-phone">
                <span><?php echo SAL0320_LABEL_SALE_PHONE; ?></span>
                :<input type="text" ng-class="{'validate': model.hidden.validated.mobile.isErrored == true}"
                    ng-model="model.form.SAL0320UpdateSaleInputModel.mobile"
                    class="form-control-dms width200">
            </div>
          <div class="sale-phone">
                <span><?php echo SAL0320_LABEL_IMEI; ?></span>
                :<input type="text"
                    ng-model="model.form.SAL0320UpdateSaleInputModel.imei" maxlength="32"
                    class="form-control-dms width200">
            </div>   

            <div class="sale-location">
               <span><?php echo SAL0320_LABEL_SALE_LOCATION; ?></span>
               :<input type="text"
                   ng-model="model.form.SAL0320UpdateSaleInputModel.location" maxlength="20"
                   class="form-control-dms width200">
							</div>

           <div class="sale-gender">
              <span><?php echo SAL0320_LABEL_SALE_GENDER; ?></span>
              :
              <input type="radio" ng-model="model.form.SAL0320UpdateSaleInputModel.gender" value="1" style="width: 19px; margin-top: 8px;margin-left: 8px;"> Male
              <input type="radio" ng-model="model.form.SAL0320UpdateSaleInputModel.gender" value="0" style="width: 19px; margin-top: 8px;margin-left: 8px;"> Female

            </div>

          <div class="sale-jobTitle">
             <span><?php echo SAL0320_LABEL_SALE_JOBTITLE; ?></span>
             :<input type="text"
                 ng-model="model.form.SAL0320UpdateSaleInputModel.jobTitle" maxlength="100"
                 class="form-control-dms width200">
            </div>
            
        </div>
        <div class="footer">
            <button  ng-click="updateSale()"
                class="btn btn-default btn-sm btn-success btn-width-default pull-right">
<!--                <span class="fa fa-floppy-o"></span>-->
                <?php echo SAL0320_BUTTON_CHANGE; ?>
            </button>
        </div>
    </div>
</div>