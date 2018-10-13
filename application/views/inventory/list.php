<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"> </span><?php echo STO0600_LABEL_FORM; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-store-search">
                    <tr>
                        <td class="title"><?php echo MRPT0200_MONTHLY_LABEL; ?></td>
                        <td>
                            <div id="date" class="input-append" datetimez
                                 ng-model="model.hidden.currentMonth">:
                                <input data-format="MM-yyyy" type="text" value="{{model.hidden.currentMonth}}"
                                       style="width: 150px; padding-left: 5px; margin-right: 5px">
                                </input>
                                <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                </span>
                            </div>
                        </td>
                        <td class="title"><?php echo USR0200_LABEL_SALE_MANAGER; ?></td>
                        <td>

                            <div>:
                                <select
                                        chosen-select="model.form.STO0600InitDataModel.salesManager"
                                        data-placeholder="<?php echo DAS0140_LABEL_BU_CHOOSE_ALL;?>"
                                        chosen-width="200px" ng-change="changeSaleManage()"
                                        ng-model="model.hidden.salesManagerId"
                                        ng-options="item.user_id as item.last_name + ' ' + item.first_name for item in model.form.STO0600InitDataModel.salesManager">
                                </select>
                            </div>
                        </td>
                        <td class="title"><?php echo USR0200_LABEL_MANAGER; ?></td>
                        <td>
                            <div>:
                                <select
                                        chosen-select="model.form.STO0600InitDataModel.regionalManager"
                                        data-placeholder="<?php echo DAS0140_LABEL_BU_CHOOSE_ALL;?>"
                                        chosen-width="200px"
                                        ng-model="model.hidden.regionalManagerId"
                                        ng-options="item.user_id as item.last_name + ' ' + item.first_name for item in model.form.STO0600InitDataModel.regionalManager">
                                </select>
                            </div>
                        </td>
                    </tr>

                </table>
                <div class="btn-action-search">
                    <button class="btn btn-normal btn-sm btn-width-default" ng-click="search()">
                        <?php echo COMMON_BUTTON_SEARCH; ?>
                    </button>

                    <?php if (check_ACL($profile, 'store', 'inventory_import')) { ?>
                        <button ng-click="importInventory()" class="btn btn-sm  btn-info btn-width-default">
                            <span> </span>
                            <?php echo CLI0300_BUTTON_CHOOSE_FILE; ?>
                        </button>
                    <?php } ?>

                    <?php if (check_ACL($profile, 'store', 'inventory_export')) { ?>
                        <button
                                class="btn btn-success btn-sm btn-width-default"
                                ng-click="exportInventory()">
                            <?php echo COMMON_BUTTON_EXPORT; ?>
                        </button>
                    <?php } ?>
                </div>
            </div>
            <div class="result-search">
                <div class="table-region">
                    <table
                            class="list-table table table-striped table-bordered"
                    >
                        <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle;"><?php echo STO0600_LABEL_PRODUCT_NAME; ?></th>
                            <th colspan="2" style="text-align: center;" ng-repeat="(key, zoneName) in model.form.STO0600InitDataModel.resultSearch.zoneList">{{zoneName}}</th>
                            <th colspan="2" style="text-align: center;">Total</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;" ng-repeat-start="(key, zoneName) in model.form.STO0600InitDataModel.resultSearch.zoneList">Sales in (Qty)</th>
                            <th style="text-align: center;" ng-repeat-end>Sales out (Qty)</th>
                            <th style="text-align: center;">Sales in (Qty)</th>
                            <th style="text-align: center;">Sales out (Qty)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(productkey, productName) in model.form.STO0600InitDataModel.resultSearch.productList">
                            <td>{{productName}}</td>
                            <td style="text-align: right;" ng-repeat-start="(key, zoneName) in model.form.STO0600InitDataModel.resultSearch.zoneList">
                                {{model.form.STO0600InitDataModel.resultSearch.inventoryInfo[productkey][key].sales_in | number:0}}
                            </td>
                            <td style="text-align: right;" ng-repeat-end>
                                {{model.form.STO0600InitDataModel.resultSearch.inventoryInfo[productkey][key].sales_out | number:0}}
                            </td>
                            <td style="text-align: right;">
                                {{model.form.STO0600InitDataModel.resultSearch.inventoryTotal[productkey].total_in | number:0}}
                            </td>
                            <td style="text-align: right;">
                                {{model.form.STO0600InitDataModel.resultSearch.inventoryTotal[productkey].total_out | number:0}}
                            </td>
                        </tr>

                        <!--Empty - Begin-->
                        <tr ng-if="model.form.STO0600InitDataModel.resultSearch.inventoryInfo == null">
                            <td colspan="100"><?php echo COM0000_EMPTY_RESULT; ?></td>
                        </tr>
                        <!--Empty - End-->

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-create">
                <table class="table list-store-search col-md-6">
                    <tr>
                        <td class="title col-md-1 col-md-offset-1 text-right">State</td>
                        <td class="col-md-4">

                            <div>:
                                <select
                                        chosen-select="model.form.STO0600InitDataModel.resultSearch.zoneList"
                                        data-placeholder="{{model.form.STO0600InitDataModel.resultSearch.zoneList[model.hidden.zoneId]}}"
                                        chosen-width="200px" ng-change="updateChart()"
                                        ng-options="key as value for (key , value) in model.form.STO0600InitDataModel.resultSearch.zoneList"
                                        ng-model="model.hidden.zoneId"
                                >
                                </select>
                            </div>
                        </td>
                        <td class="col-md-6"></td>
                    </tr>
                </table>
            </div>
            <div class="result-search">
                <div class="table-region">
                    <div class="col-md-6">
                        <highchart id="chart1" config="chartByProduct"></highchart>
                    </div>
                    <div class="col-md-6">
                        <highchart id="chart2" config="chartTotal"></highchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
