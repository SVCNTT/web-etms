<div class="modal-confirm reset-password">
    <div class="modal-info">
        <div class="header">
            <span class="title" class="pull-left"><?php echo USR0100_TIP_CHANGE_PASSWORD;?></span> <span
                class="pull-right close icon-close"
                ng-click="closeResetPassword()"></span>
        </div>
        <div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
            <ul>
                <li ng-if="model.hidden.validated.firstName.isErrored == true">
                    {{model.hidden.validated.firstName.msg}}
                </li>
                <li ng-if="model.hidden.validated.lastName.isErrored == true">
                    {{model.hidden.validated.lastName.msg}}
                </li>
                <li ng-if="model.hidden.validated.defaultRoleCd.isErrored == true">
                    {{model.hidden.validated.defaultRoleCd.msg}}
                </li>
                <li ng-if="model.hidden.validated.email.isErrored == true">
                    {{model.hidden.validated.email.msg}}
                </li>
                <li ng-if="model.hidden.validated.phone.isErrored == true">
                    {{model.hidden.validated.phone.msg}}
                </li>
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
            <div class="password-code">
                <span style="text-transform: capitalize;"><?php echo USR0100_LABEL_PASSWORD;?> <span class="required">(*)</span></span>: <input ng-class="{'validate': model.hidden.validated.password.isErrored == true}"
                                                                               type="password" class="form-control-dms" ng-model="model.form.USR0110ResetPasswordInput.password" required autofocus>
            </div>
            <div class="product-name">
                <span style="text-transform: capitalize;"><?php echo USR0100_LABEL_CONFIRM_PASSWORD;?> <span class="required">(*)</span></span>:
                <input type="password"  ng-class="{'validate': model.hidden.validated.rePassword.isErrored == true}"
                       class="form-control-dms" ng-model="model.form.USR0110ResetPasswordInput.rePassword" required autofocus>
            </div>

        </div>
        <div class="footer">
            <button ng-click="resetPassword()"
                    class="btn btn-default btn-sm btn-success btn-width-default pull-right">
<!--                <span class="fa fa-floppy-o"></span>-->
                <?php echo COMMON_BUTTON_UPDATE;?>
            </button>
        </div>
    </div>
</div>