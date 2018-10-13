
<div class="main-container">
    <div class="wrapper-container"  >
        <div class="content-list scrollbarCustom">
            <div class="create-client">
                <div class="breadcrums">
                    <button class="btn btn-warning btn-sm  btn-width-default" onclick="window.history.back();">
                        <?php echo REC0230_BUTTON_BACK;?>
                    </button>

                </div>
                <div class="panel-form">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="fa fa-comments"></span>
                                <?php echo REC0230_LABEL_FORM;?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-create create-user-form">
                                <div class="group">
                                    <div>
                                        <span><?php echo REC0230_LABEL_MR;?>&nbsp;</span>:
                                        <span ng-model="model.form.REC0230GetData.resultGet.callRecord.mr_name">{{model.form.REC0230GetData.resultGet.callRecord.mr_name}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_STORE;?>&nbsp;</span>:
                                        <span ng-model="model.form.REC0230GetData.resultGet.callRecord.store_name">{{model.form.REC0230GetData.resultGet.callRecord.store_name}} - {{model.form.REC0230GetData.resultGet.callRecord.store_class}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_VALIDATE;?></span>:
                                        <span ng-model="model.form.REC0230GetData.resultGet.callRecord.validate_name">{{model.form.REC0230GetData.resultGet.callRecord.validate_name}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_CREATED_DATE;?></span>:
                                        <span ng-model="model.form.REC0230GetData.resultGet.callRecord.cre_ts">{{model.form.REC0230GetData.resultGet.callRecord.mod_ts}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_MR_FEEDBACK;?></span>:
                                        <span ng-if="!model.form.REC0230GetData.resultGet.callRecord.detail.note.mr_feedback"><em><?php echo REC0230_LABEL_EMPTY;?></em></span>
                                        <span ng-if="model.form.REC0230GetData.resultGet.callRecord.detail.note.mr_feedback">{{model.form.REC0230GetData.resultGet.callRecord.detail.note.mr_feedback}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_CUSTOMER_FEEDBACK;?></span>:
                                        <span ng-if="!model.form.REC0230GetData.resultGet.callRecord.detail.note.customer_feedback"><em><?php echo REC0230_LABEL_EMPTY;?></em></span>
                                        <span ng-if="model.form.REC0230GetData.resultGet.callRecord.detail.note.customer_feedback">{{model.form.REC0230GetData.resultGet.callRecord.detail.note.customer_feedback}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_COMPETITOR;?></span>:
                                        <span ng-if="!model.form.REC0230GetData.resultGet.callRecord.detail.note.competitor"><em><?php echo REC0230_LABEL_EMPTY;?></em></span>
                                        <span ng-if="model.form.REC0230GetData.resultGet.callRecord.detail.note.competitor">{{model.form.REC0230GetData.resultGet.callRecord.detail.note.competitor}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo REC0230_LABEL_COMPETITOR_ACTIVITY;?></span>:
                                        <span ng-if="!model.form.REC0230GetData.resultGet.callRecord.detail.note.competitor_activity"><em><?php echo REC0230_LABEL_EMPTY;?></em></span>
                                        <span ng-if="model.form.REC0230GetData.resultGet.callRecord.detail.note.competitor_activity">{{model.form.REC0230GetData.resultGet.callRecord.detail.note.competitor_activity}}</span>
                                    </div>
                                </div>
                                <div style="clear: both"></div>
                                <div class="call-record-answer col-md-4" ng-repeat="item in model.form.REC0230GetData.resultGet.callRecord.detail.answer">
                                    <h5>{{item.name}}</h5>
                                    <div>
                                        <p class="call-record-comment" ng-if="item.comment == ''"><?php echo REC0230_LABEL_COMMENT;?>: <em><?php echo REC0230_LABEL_EMPTY;?></em></p>
                                        <p class="call-record-comment" ng-if="item.comment != ''"><?php echo REC0230_LABEL_COMMENT;?>: {{item.comment}}</p>
                                        <div class="call-record-answer-item" ng-repeat="question in item.listQuestions">
                                            <p class="divider"></p>
                                            <p><i class="fa fa-share"></i> <?php echo REC0230_LABEL_QUESTION;?>: {{question.question}}</p>
                                            <p><?php echo REC0230_LABEL_ANSWER;?>:
                                                <span ng-if="question.answer == 0"><?php echo REC0230_ANSWER_NO;?></span>
                                                <span ng-if="question.answer == 1"><?php echo REC0230_ANSWER_YES;?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input id="call-record-id" type="hidden" value="<?php echo $call_record_id?>" ng-model="model.hidden.call_record_id">
<input id="call-record-tk" type="hidden" value="<?php echo $token?>" ng-model="model.hidden.token">