<div class="modal-confirm ">
    <div class="modal-info">
        <div class="header">
            <span class="title" class="pull-left"> {{model.form.data.store_code}}
            </span> <span class="pull-right close icon-close"
                          ng-click="closeModalViewSalesman()"></span>
        </div>

        <div class="body">
            <span><?php echo STO0536_LABEL_TITLE; ?></span>

            <div class="salesman-list">
                <ul ng-repeat="item in model.form.data.salesmans">
                    <li>{{item.salesman_code}} - {{item.salesman_name}}</li>
                </ul>
            </div>

        </div>

        <div class="footer">
            <button type="button" ng-click="closeModalViewSalesman()"
                    class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
                <span class="icon-close"> </span>
                <?php echo COMMON_BUTTON_CLOSE; ?>
            </button>
        </div>
    </div>
</div>