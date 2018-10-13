<style type="text/css">
    .chosen-drop {
        z-index: 9999 !important;
    }
</style>
<div class="modal-confirm" style="z-index: 999">
    <div class="modal-info">
        <div class="header">
            <span class="title" class="pull-left"> <?php echo MRPT0200_MONTHLY_REPORT; ?>
            </span> <span class="pull-right close icon-close"
                          ng-click="closeMonthlyReport()"></span>
        </div>

        <div class="body">
            <div>
                <span style="min-width: 15%; display: inline-block; text-align: right"><?php echo MRPT0200_BU_LABEL; ?>:</span>

                <div class="input-append">
                    <select style="padding-left: 5px"
                            chosen-select="model.form.MRPT0200ChangeMonthlyReportInputModel.productTypeInfo" chosen-width="150px"
                            ng-model="model.form.MRPT0200ChangeMonthlyReportInputModel.bu"
                            ng-options="item.product_type_id as item.product_type_name for item in model.form.MRPT0200ChangeMonthlyReportInputModel.productTypeInfo">
                    </select>
                </div>
            </div>

            <div style="margin-top: 10px">
                <span style="min-width: 15%; display: inline-block; text-align: right"><?php echo MRPT0200_MONTHLY_LABEL; ?>:</span>

                <div id="date" class="input-append" datetimez
                     ng-model="model.hidden.currentMonth">
                    <input data-format="MM-yyyy" type="text"
                           style="width: 150px; padding-left: 5px; margin-right: 5px" id="input1"
                           name="input1">

                    </input>
                    <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>
                </div>
            </div>

        </div>
        <div class="footer">
            <button ng-click="exportMonthlyReport()"
                class="btn btn-default btn-sm btn-success btn-width-default pull-right">
                <?php echo MRPT0200_BUTTON_EXPORT; ?>
            </button>
        </div>
    </div>
</div>