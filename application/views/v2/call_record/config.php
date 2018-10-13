<div class="manage-staff call-record">
    <div class="panel-form" style="width:50%">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="icon-list"></span>
                    <?php echo REC0300_LABEL_PRODUCT_GROUP_LIST; ?>
                </h3>
            </div>
            <div class="panel-body">

                <div class="group-search">
                    <div class="condition-search">
                        <ul>
                            <li>
                                <span><?php echo REC0300_LABEL_PRODUCT_GROUP_NAME;?></span>:
                                <input type="text" class="form-control-dms width-200"
                                       ng-model="model.form.searchParam.searchInput.productGroupName" ng-enter="searchData()">
                            </li>
                        </ul>

                    </div>
                    <div class="action-search">
                        <button class="btn btn-normal btn-sm btn-width-default"
                                ng-click="searchData()">
                            <?php echo REC0300_BUTTON_SEARCH; ?>
                        </button>
                    </div>

                </div>
                <div class="result-search">
                    <div class="table-region">

                        <table id="product-group-list" class="list-table manage-staff-table store-table table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo REC0300_LABEL_PRODUCT_GROUP_NAME; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr	ng-if="model.form.REC0300SearchData.resultSearch.productGroup.length> 0"
                                    ng-repeat="item in model.form.REC0300SearchData.resultSearch.productGroup"
                                    ng-click = "getQuestion(item)">
                                    <td>{{item.product_group_name}} </td>

                                </tr>
                            <!--Empty - Begin-->
                            <tr  ng-if="model.form.REC0300SearchData.resultSearch.productGroup.length == null">
                                <td colspan="2"><?php echo COM0000_EMPTY_RESULT;?></td>
                            </tr>
                            <!--Empty - End-->


                            </tbody>
                        </table>
                        <div class="paging"  ng-if="model.form.REC0300SearchData.resultSearch.productGroup.length > 0 "
                            >
                            <ul class="pagination">
                                <li class="disabled"><span>{{model.form.REC0300SearchData.resultSearch.pagingInfo.stRow}}-{{model.form.REC0300SearchData.resultSearch.pagingInfo.edRow}}/{{model.form.REC0300SearchData.resultSearch.pagingInfo.ttlRow}}</span></li>
                                <li class="disabled"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == 1 || model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == null "><a
                                        href="#">&lt;&lt;</a></li>
                                <li ng-click="startPage()"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != 1 && model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != null "><a
                                        href="#">&lt;&lt;</a></li>

                                <li class="disabled"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == 1 || model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == null"><a
                                        href="#">&lt;</a></li>
                                <li ng-click="prevPage()"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != 1 && model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != null "><a
                                        href="#">&lt;</a></li>

                                <li class="disabled"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == model.form.REC0300SearchData.resultSearch.pagingInfo.ttlPages || model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == null"><a
                                        href="#">&gt;</a></li>
                                <li ng-click="nextPage()"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != model.form.REC0300SearchData.resultSearch.pagingInfo.ttlPages && model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != null "><a
                                        href="#">&gt;</a></li>

                                <li class="disabled"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == model.form.REC0300SearchData.resultSearch.pagingInfo.ttlPages || model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage == null"><a
                                        href="#">&gt;&gt;</a></li>
                                <li ng-click="endPage()"
                                    ng-if="model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != model.form.REC0300SearchData.resultSearch.pagingInfo.ttlPages && model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage != null"><a
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
                    <?php echo REC0300_LABEL_QUESTIONS; ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="group-question" ng-if="model.form.dataQuestion.product_group_id == null">
                    <em><?php echo REC0300_HINT_QUESTION;?></em>
                </div>
                <div class="group-question" ng-if="model.form.dataQuestion.product_group_id == -1">
                    <em><?php echo REC0300_LOADING;?></em>
                </div>
                <div class="group-question" ng-if="model.form.dataQuestion.product_group_id != null && model.form.dataQuestion.product_group_id != -1">
                    <p><?php echo REC0300_LABEL_PREFIX_QUESTION_LIST;?> <b>{{model.form.dataQuestion.product_group_name}}</b></p>

                    <div class="dd" id="list-question">
                        <ol class="dd-list">
                            <li class="dd-item dd3-item" ng-repeat="item in model.form.dataQuestion.list">
                                <div class="dd-handle dd3-handle">Drag</div>
                                <textarea ng-model="item.question">{{item.question}}</textarea>
                                <span title="<?php echo REC0300_LABEL_REMOVE_QUESTIONS;?>" style="min-width: 15px ! important;" ng-click="removeQuestion(item)" class="delete-store pull-right icon-close delete-input"></span>
                            </li>
                        </ol>
                    </div>
                    <button ng-click="addQuestion()" class="btn btn-default btn-sm btn-success btn-width-default"><?php echo REC0300_BUTTON_ADD_QUESTION;?></button>
                    <button ng-click="saveQuestion()" class="btn btn-default btn-sm btn-info btn-width-default"><?php echo REC0300_BUTTON_SAVE_QUESTION;?></button>
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
<link href="<?php echo STATIC_SERVER; ?>/lib/nestable/nestable.css" rel="stylesheet" media="screen">
<script type="application/javascript" src="<?php echo STATIC_SERVER;?>/lib/nestable/jquery.nestable.js"/>
<script type="application/javascript">
    function initListQuestion() {
        $('#list-question').nestable({
            maxDepth: 1,
            dragClass: 'dd-dragel'
        });
    }
    $(document).ready(function(){
        initListQuestion();
    });
</script>