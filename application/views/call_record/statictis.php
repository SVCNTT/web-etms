<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"> </span>
                <?php echo DAS0110_LABEL_CALL_RECORD_LIST; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-user-search create-table">
                    <tbody>
                    <tr>

                        <td class="title">
                            <?php echo DAS0110_LABEL_DATE; ?>
                        </td>
                        <td style="display: flex;vertical-align: middle;line-height: 30px;">
                            <span>:</span>

                            <div class="datepicker"
                                 ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
                                <datepicker date-id="startDate"
                                            date-value="model.form.DAS0110SearchInputModel.startDate"></datepicker>

                            </div>
                            <span>&nbsp;-&nbsp;</span>

                            <div class="datepicker"
                                 ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
                                <datepicker date-id="endDate"
                                            date-value="model.form.DAS0110SearchInputModel.endDate"></datepicker>

    </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-action-search">
                    <button ng-click="searchData()" class="btn btn-normal btn-sm btn-width-default">
                        <?php echo DAS0110_BUTTON_SEARCH; ?>
                    </button>
                </div>
            </div>

            <div class="result-search">
                <highchart id="chart1" config="chart"></highchart>
</div>
        </div>
    </div>
</div>

