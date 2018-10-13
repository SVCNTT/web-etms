<div class="cl-mcont">
    <div class="row">
        <div class="col-md-12">
            <div class="block-flat">
                <div class="header">
                    <h3><?php echo DAS0110_LABEL_CALL_RECORD_LIST;?></h3>
                </div>

                <div class="content">
                    <form id="my-form" method="post">
                        <input type="hidden" id="pi" name="pi" value="<?php echo isset($pi) ? $pi : 1;?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-right" style="line-height: 34px">
                                    <div class="dataTables_filter" id="datatable_filter">
                                        <label>
                                            <button ng-click="searchData()" class="btn btn-default">
                                                <?php echo DAS0110_BUTTON_SEARCH; ?>
                                            </button>
                                        </label>
                                        <label><input type="text" name="keyword" value="<?php echo isset($keyword) ? $keyword : '';?>"
                                                   class="form-control"
                                                   placeholder="Search title">
                                        </label>
                                        <label>&nbsp;-&nbsp;</label>
                                        <label><input type="text" name="keyword" value="<?php echo isset($keyword) ? $keyword : '';?>"
                                                   class="form-control"
                                                   placeholder="Search title">
                                        </label>
                                        <label><?php echo DAS0110_LABEL_DATE;?>&nbsp;</label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="result-search">
                            <highchart id="chart1" config="chart"></highchart>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>