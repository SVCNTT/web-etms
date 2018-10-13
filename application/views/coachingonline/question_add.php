<div class="modal-confirm create-password add-question edit-sale">
    <div class="modal-info" style="width: 550px;">
        <div class="header">
            <span class="title" class="pull-left"><?php echo COA0220_LABEL_FORM; ?> </span> <span 
                class="pull-right close icon-close" ng-click="closeEdit()"></span>
        </div>
        <div class="alert alert-danger" role="alert" ng-if="model.hidden.validated.isErrored == true">
		    <ul>
		    	<li ng-if="model.hidden.validated.questionTitle.isErrored == true">
		    	 	{{model.hidden.validated.questionTitle.msg}}
			    </li>
		    	<li ng-if="model.hidden.validated.optionValues.isErrored == true">
		    	 	{{model.hidden.validated.optionValues.msg}}
			    </li>
			    
		    </ul>
		    
		</div>
        <div class="body" id="space-for-buttons" style="overflow-y: scroll; max-height: 320px;"> 
	            <div class="question-title">
	                <span><?php echo COA0200_LABEL_QUESTION_TITLE; ?>  <span
						                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
	                :<input type="text"  ng-class="{'validate': model.hidden.validated.questionTitle.isErrored == true}"
	                    ng-model="model.form.COA0220CreateQuestionInputModel.questionTitle"
	                    class="form-control-dms "  style="width:215px !important">
	            </div>
            	<div class="question-calculate">
	                <span><?php echo COA0200_LABEL_QUESTION_NEED_CALCULATE; ?></span>
	                :<input type="checkbox"  
	                    ng-model="model.form.COA0220CreateQuestionInputModel.needToCalculate"
	                    class="form-control-dms "  ng-true-value="'1'" ng-false-value="'0'"  style="width:34px !important; margin-top:10px;">
	            </div>
				<div class="coa-question-type">
                <span><?php echo COA0200_LABEL_QUESTION_TYPE; ?> <span
						                                                    class="required"><?php echo COMMON_REQUIRED; ?></span></span>
						                : <select
                                                chosen-select="model.form.CAO0200InitDataModel.initData.typeList"
                                                chosen-width="215px"
                                                data-placeholder="<?php echo COA0200_LABEL_QUESTION_STATUS; ?>"
                                                ng-model="model.form.COA0220CreateQuestionInputModel.questionType"
                                                ng-options="item.codeCd as item.displayText for item in model.form.CAO0200InitDataModel.initData.typeList">
                                            </select>
            	</div>
	            <div class = "answer-main" ng-repeat="item in model.form.COA0220CreateQuestionInputModel.optionValues">
                <span></span>
                <input type="checkbox" class="checkbox-answer"  disabled="disabled"/>
	                <span id="{{item.coachingTemplateSectionItemId}}">
	                <input type="text" ng-model="model.form.COA0220CreateQuestionInputModel.optionValues[$index].sectionItemTitle"
	                    class="form-control-dms width200"><span style="min-width: 15px ! important;" ng-click="removeItem($event)"  class="delete-store pull-right icon-close  delete-input" ></span>
		        	</span>
            </div>
        </div>
        <div class="body">
        	<div class="answer-notes">
                <span></span>
                <input type="checkbox" class="checkbox-answer" disabled="disabled"/>
                <input type="text" ng-click="addItem()" placeholder="Click to add option" maxlength="32"
                    class="form-control-dms width200"> <span style="min-width: 50px; width: 110px ! important; margin-left:15px;">or  <a href=""  ng-click="addItem()">Add "Other"</a></span>
            </div>
        </div>
       
        <div class="footer">
            <button  ng-click="createQuestion()"
                class="btn btn-default btn-sm btn-success btn-width-default pull-right">
<!--                <span class="fa fa-floppy-o"></span>-->
                <?php echo COA0220_BUTTON_DONE; ?>
            </button>
        </div>
    </div>
</div>