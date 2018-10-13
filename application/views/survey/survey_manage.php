<div class="manage-staff call-record">
    <div class="panel-form" style="width:50%">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="icon-list"></span>
                    <?php echo STO0510_LABEL_SURVEY_LIST; ?>
                </h3>
            </div>
            <div class="panel-body">

                <div class="group-search">
                    <div class="condition-search">
                        <ul>
                            <li>
                                <span><?php echo STO0510_LABEL_SURVEY_NAME;?></span>:
                                <input type="text" class="form-control-dms width-200"
                                       ng-model="model.form.searchParam.searchInput.surveyName" ng-enter="searchData()">
                            </li>
                        </ul>

                    </div>
                    <div class="action-search">
                        <button class="btn btn-normal btn-sm btn-width-default"
                                ng-click="searchData()">
                            <?php echo STO0510_BUTTON_SEARCH; ?>
                        </button>

                    <?php if (check_ACL($profile, 'store', 'im_survey')) { ?>
                        <button ng-click="importSurvey()" class="btn btn-sm  btn-info btn-width-default" style="width: 140px;">
                            <span> </span>
                            <?php echo STO0510_BUTTON_IMPORT_SURVEY; ?>
                        </button>
                    <?php } ?>

                    </div>

                </div>
                <div class="result-search">
                    <div class="table-region">

                        <table id="product-group-list" class="list-table store-table table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo STO0510_LABEL_CREATED_DATE; ?></th>
                                    <th><?php echo STO0510_LABEL_PRODUCT_GROUP_NAME; ?></th>
                                    <th><?php echo STO0510_LABEL_PRODUCT_GROUP_PRODUCT; ?></th>
                                    <th><?php echo STO0510_LABEL_PRODUCT_GROUP_STATUS; ?></th>
                                    <th><?php echo STO0510_LABEL_ACTION; ?></th>
                                    <th style="width: 38px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr	ng-if="model.form.STO0510SearchData.resultSearch.surveyList.length > 0"
                                    ng-repeat="item in model.form.STO0510SearchData.resultSearch.surveyList">
                                    <td ng-click="getQuestion(item)" style="cursor: pointer">{{item.cre_ts}} </td>
                                    <td ng-click="getQuestion(item)" style="cursor: pointer">{{item.name}} </td>
                                    <td ng-click="getQuestion(item)" style="cursor: pointer">{{item.product}} </td>
                                    <td ng-if="item.status == 1"><b style="color: #5cb85c"><?php echo STO0510_STATUS_ACTIVE;?></b></td>
                                    <td ng-if="item.status == 0"><b><?php echo STO0510_STATUS_INACTIVE;?></b></td>
                                    <td>
                                        <button ng-if="item.status == 0" ng-click="activeSurvey(item, <?php echo SURVEY_STATUS_ENABLE;?>)" class="btn btn-xs btn-success" style="margin-top: 0 !important;"><?php echo STO0510_STATUS_ACTIVE?></button>
                                        <button ng-if="item.status == 1" ng-click="activeSurvey(item, <?php echo SURVEY_STATUS_DISABLE;?>)" class="btn btn-xs btn-normal" style="margin-top: 0 !important;"><?php echo STO0510_STATUS_INACTIVE?></button>

                                    </td>
                                    <td style="position: relative">
                                        <span ng-click="" title="<?php echo REC0200_TIP_DELETE_RECORD;?>"
                                               class="delete-user pull-right icon-close dropdown-toggle"
                                               data-toggle="dropdown">
                                        </span>
                                        <div class="popover-confirm dropdown-menu" style="right: -7px; top: 33px">
                                            <div class="arrow"> </div>
                                            <div class="content-confirm">
                                                {{model.hidden.deleteConfirm.message}}
                                            </div>
                                            <div class="button-group-action text-center">

                                                <button class="btn  btn-default btn-info btn-xs" ng-click="deleteSurvey(item)">
                                                    <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                </button>
                                                <button class="btn btn-default btn-danger btn-xs">
                                                    <span><?php echo COMMON_BUTTON_CANCEL; ?></span>
                                                </button>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <!--Empty - Begin-->
                            <tr  ng-if="model.form.STO0510SearchData.resultSearch.surveyList.length == null">
                                <td colspan="6"><?php echo COM0000_EMPTY_RESULT;?></td>
                            </tr>
                            <!--Empty - End-->


                            </tbody>
                        </table>
                        <div class="paging"  ng-if="model.form.STO0510SearchData.resultSearch.surveyList.length > 0 "
                            >
                            <ul class="pagination">
                                <li class="disabled"><span>{{model.form.STO0510SearchData.resultSearch.pagingInfo.stRow}}-{{model.form.STO0510SearchData.resultSearch.pagingInfo.edRow}}/{{model.form.STO0510SearchData.resultSearch.pagingInfo.ttlRow}}</span></li>
                                <li class="disabled"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == null "><a
                                        href="#">&lt;&lt;</a></li>
                                <li ng-click="startPage()"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != null "><a
                                        href="#">&lt;&lt;</a></li>

                                <li class="disabled"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == null"><a
                                        href="#">&lt;</a></li>
                                <li ng-click="prevPage()"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != null "><a
                                        href="#">&lt;</a></li>

                                <li class="disabled"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == model.form.STO0510SearchData.resultSearch.pagingInfo.ttlPages || model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == null"><a
                                        href="#">&gt;</a></li>
                                <li ng-click="nextPage()"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != model.form.STO0510SearchData.resultSearch.pagingInfo.ttlPages && model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != null "><a
                                        href="#">&gt;</a></li>

                                <li class="disabled"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == model.form.STO0510SearchData.resultSearch.pagingInfo.ttlPages || model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage == null"><a
                                        href="#">&gt;&gt;</a></li>
                                <li ng-click="endPage()"
                                    ng-if="model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != model.form.STO0510SearchData.resultSearch.pagingInfo.ttlPages && model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage != null"><a
                                        href="#">&gt;&gt;</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="panel-form" style="width:48%">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="icon-plus"> </span>
                    <?php echo STO0510_LABEL_QUESTIONS_LIST; ?>
                </h3>
            </div>
            <div class="result-search">
                <div class="group-question" ng-if="model.form.dataQuestion.survey_id == null">
                    <em><?php echo STO0510_HINT_VIEW_QUESTIONS;?></em>
                </div>
                <div class="group-question" ng-if="model.form.dataQuestion.survey_id == -1">
                    <em><?php echo STO0510_LOADING;?></em>
                </div>
                <div class="group-question" ng-if="model.form.dataQuestion.survey_id != null && model.form.dataQuestion.survey_id != -1">
                    <p><?php echo STO0510_LABEL_SURVEY_NAME;?> <b>{{model.form.dataQuestion.survey_name}}</b></p>

                    <div class="dd" id="list-question">
                        <ol class="dd-list">
                            <li class="dd-item dd3-item" ng-repeat="item in model.form.dataQuestion.list">
                                <label ng-model="item">{{item.content}}</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:         linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
    .dd3-handle:hover { background: #ddd; }
</style>