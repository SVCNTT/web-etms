<div class="modal-confirm create-password">
    <div class="modal-info">
        <div class="header">
            <span class="title" class="pull-left"><?php echo SAL0310_LABEL_FORM;?> </span> <span 
                class="pull-right close icon-close" ng-click="closePassword()"></span>
        </div>
        <div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
		    <ul>
		    	
			    <li ng-if="model.hidden.validated.password.isErrored == true && model.hidden.validated.password.msg!=''">
			    	 	{{model.hidden.validated.password.msg}}
			    </li>
			    <li ng-if="model.hidden.validated.rePassword.isErrored == true && model.hidden.validated.rePassword.msg!=''">
			    	 	{{model.hidden.validated.rePassword.msg}}
			    </li>
			     <li ng-if="model.hidden.validated.checkPassword.isErrored == true">
			    	 	{{model.hidden.validated.checkPassword.msg}}	
			    </li>
			    
		    </ul>
		    
		</div>
        <div class="body">
        
            <div class="sale-pass">
                <span><?php echo SAL0310_PASSWORD; ?>  <span class="required"><?php echo USR0200_LABEL_REQUIRED; ?></span></span>
                :<input ng-model="model.form.CLI0310ResetPassword.pinCode"  ng-class="{'validate': model.hidden.validated.password.isErrored == true}"
                    type="password" class="form-control-dms width200">
            </div>
            <div class="sale-confirm-pass">
                <span><?php echo SAL0310_CONFIRM_PASSWORD; ?>  <span
                                                    class="required"><?php echo USR0200_LABEL_REQUIRED; ?></span></span>
                :<input type="password"  ng-class="{'validate': model.hidden.validated.rePassword.isErrored == true}"
                    ng-model="model.form.CLI0310ResetPassword.pinCodeConfirm"
                    class="form-control-dms width200">
            </div>
            
        </div>
        <div class="footer">
            <button  ng-click="resetPassword()"
                class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
<!--                <span class="fa fa-floppy-o"></span>-->
                <?php echo SAL0310_BUTTON_CHANGE; ?>
            </button>
        </div>
    </div>
</div>