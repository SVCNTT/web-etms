<div class="modal-confirm create-product"
    >
    <div class="modal-info">
        <div class="header">
			 <span class="title"
                   class="pull-left"><?php echo AUT0200_CHANGE_PASSWORD;?>
			</span> <span class="pull-right close icon-close"
                          ng-click="closeChangePassword()"></span>
        </div>
        <div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
            <ul>

                <li ng-if="model.hidden.validated.oldPassword.isErrored == true && model.hidden.validated.oldPassword.msg!=''">
                    {{model.hidden.validated.oldPassword.msg}}
                </li>
                <li ng-if="model.hidden.validated.newPassword.isErrored == true && model.hidden.validated.newPassword.msg!=''">
                    {{model.hidden.validated.newPassword.msg}}
                </li>
                <li ng-if="model.hidden.validated.confirmPassword.isErrored == true && model.hidden.validated.confirmPassword.msg!=''">
                    {{model.hidden.validated.confirmPassword.msg}}
                </li>
                <li ng-if="model.hidden.validated.checkPassword.isErrored == true">
                    {{model.hidden.validated.checkPassword.msg}}
                </li>

            </ul>

        </div>
        <div class="body">

            <div class="password-field">
                <div><?php echo AUT0200_LABEL_OLD_PASSWORD_1;?><span
                        class="required"> <?php echo COMMON_REQUIRED;?></span></div>:
                <input type="password"  ng-class="{'validate': model.hidden.validated.oldPassword.isErrored == true}"
                       ng-model="model.form.AUT0200ChangePasswordInputModel.oldPassword"  class="form-control-dms">
                <div><?php echo AUT0200_LABEL_NEW_PASSWORD_1;?><span
                        class="required"> <?php echo COMMON_REQUIRED;?></span></div>:
                <input type="password" ng-class="{'validate': model.hidden.validated.newPassword.isErrored == true}"
                       ng-model="model.form.AUT0200ChangePasswordInputModel.newPassword"  class="form-control-dms">
                <div><?php echo AUT0200_LABEL_CONFIRM_PASSWORD_1;?><span
                        class="required"> <?php echo COMMON_REQUIRED;?></span></div>:
                <input type="password" ng-class="{'validate': model.hidden.validated.confirmPassword.isErrored == true}"
                       ng-model="model.form.AUT0200ChangePasswordInputModel.confirmPassword"  class="form-control-dms">

            </div>
        </div>
        <div class="footer">
            <button
                ng-click="updatePassword()"
                class="btn btn-default btn-sm btn-success btn-width-default pull-right">
                <?php echo AUT0200_BUTTON_UPDATE;?>
            </button>
        </div>
    </div>
</div>