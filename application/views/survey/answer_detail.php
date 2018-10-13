
<div class="main-container">
    <div class="wrapper-container"  >
        <div class="content-list scrollbarCustom">
            <div class="create-client">
                <div class="breadcrums">
                </div>
                <div class="panel-form">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="fa fa-comments"></span>
                                <?php echo STO0523_LABEL_FORM;?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-create create-user-form">
                                <div class="group">
                                    <div>
                                        <span><?php echo STO0521_LABEL_SURVEY;?>&nbsp;</span>:
                                        <span ng-model="model.form.data.resultGet.answer.store_code">{{model.form.data.resultGet.answer.name}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo STO0521_LABEL_STORE_CODE;?>&nbsp;</span>:
                                        <span ng-model="model.form.data.resultGet.answer.store_code">{{model.form.data.resultGet.answer.store_code}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo STO0521_LABEL_STORE_NAME;?>&nbsp;</span>:
                                        <span ng-model="model.form.data.resultGet.answer.store_name">{{model.form.data.resultGet.answer.store_name}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo STO0521_LABEL_SALESMAN_CODE;?>&nbsp;</span>:
                                        <span ng-model="model.form.data.resultGet.answer.salesman_code">{{model.form.data.resultGet.answer.salesman_code}}</span>
                                    </div>
                                    <div>
                                        <span><?php echo STO0521_LABEL_CREATED_DATE;?></span>:
                                        <span ng-model="model.form.data.resultGet.answer.cre_ts">{{model.form.data.resultGet.answer.cre_ts}}</span>
                                    </div>
                                </div>
                                <div style="clear: both"></div>
                                <div class="detail-answer col-md-12">
                                    <h5><?php echo STO0523_LABEL_SURVEY;?> "{{model.form.data.resultGet.answer.name}}":</h5>
                                    <div>
                                        <ul ng-repeat="(key, item) in model.form.data.resultGet.answer.answer" type="none">
                                            <li>{{key+1}}, <?php echo STO0523_LABEL_QUESTION;?>: {{item.content}}<br/>
                                                <i class="fa fa-share"></i> <?php echo STO0523_LABEL_ANSWER;?>: {{item.answer}}
                                            </li>
                                            <p ng-if="key+1 != model.form.data.resultGet.answer.answer.length" class="divider"></p>
                                        </ul>
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

<input id="survey-id" type="hidden" value="<?php echo $survey_id?>" ng-model="model.hidden.survey_id">
<input id="survey-answer-id" type="hidden" value="<?php echo $survey_answer_id?>" ng-model="model.hidden.id">
<input id="survey-answer-tk" type="hidden" value="<?php echo $survey_answer_token?>" ng-model="model.hidden.token">