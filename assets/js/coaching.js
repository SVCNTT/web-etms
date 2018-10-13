var coa0200Module = angular.module("coa0200Module", ["dmsCommon","coa0220Module", "toaster", "ngLoadingSpinner"]).controller("COA0200Ctrl", ["$scope", "$http", "$filter", "serverService", "toaster", function(a, d, c, e, f) {
    a.init = function() {
        a.model = {
            hidden: {
                showCOA0220: !1
            }
        };
        a.model.form = {
            chooseAll: !1,
            COA0200InitDataOutputModel: null,
            CAO0200InitDataModel:null,
            COA0200CreateCoachingInputModel: {
                coachingName: "",
                coachingStartday: "",
                coachingEndday: "",
                coachingCode:"",
                coachingTemplateId:0
            },
            COA0200CreateCoachingResultDto: null,
            COA0200CreateCoachingSectionResultDto:null,
            COA0330ResultSearchNotAssignModel: {
                resultUserNotAssign: {
                    searchInput: {
                        userName: "",
                        userCode:""
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            },
            COA0330ResultSearchUserAssignModel: {
                resultUserAssign: {
                    searchInput: {
                        userName: "",
                        userCode:""
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            },
            COA0330SearchDataUserNotAssign: {
                searchInput: {
                    userName:"",
                    userCode:""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            COA0330SearchDataUserAssign: {
                searchInput: {
                    userName:"",
                    userCode:""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            listSelectUser: []
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                coachingName: {
                    isErrored: !1,
                    msg: ""
                },
                coachingStartday: {
                    isErrored: !1,
                    msg: ""
                },
                coachingEndday: {
                    isErrored: !1,
                    msg: ""
                }
            }
        };
        a.$on("COA0200#showCOA0220", function(b, c) {
            a.model.hidden.showCOA0220 = c.showCOA0220
        });
        a.$on("COA0200#reloadSection", function() {
            a.getQuestion();
        })

    };
    a.searchType = function(){
        a.searchUserNotAssign();
    }
    a.countStep = 1;
    a.chooseAll = function() {
        if (null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) {
                    var c = a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b];
                    c.choose = !1;
                    for (var e = 0; e < a.model.form.listSelectUser.length; e++) a.model.form.listSelectUser[e] ==
                    c.userId && a.model.form.listSelectUser.splice(e, 1)
                } else
                for (b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) c = a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b], c.choose = !0, a.model.form.listSelectUser.push(c.userId)
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++)
                if (!1 ==
                    a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.finish = function(){
        window.location.href = getContextPath() + "/COA0100";
    };
    a.addUser = function() {
        a.addUserData({
            coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
            userIdList: a.model.form.listSelectUser
        }, function(b) {
//        
            null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
            a.searchDataUserNotAssignOnly();
            a.searchDataUserAssignOnly();
        })
    };
    a.chooseUser = function(b) {
        !1 == b.choose && a.removeUserItem(b);
        !0 == b.choose && a.addUserItem(b)
    };
    a.removeUserItem = function(b) {
        for (var f = 0; f < a.model.form.listSelectUser.length; f++)
            if (a.model.form.listSelectUser[f] == b.userId) {
                a.model.form.listSelectUser.splice(f,
                    1);
                break
            }
        a.checkChooseAll()
    };
    a.addUserItem = function(b) {
        a.model.form.listSelectUser.push(b.userId);
        a.checkChooseAll()
    };
    a.addUserData = function(a, c) {
        e.doPost("/COA0330/assignUserCoaching", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.checkChooseAllAfterSearch = function() {
        a.model.form.listSelectUser = [];
        a.model.form.chooseAll = 1;
    };

    a.searchUserNotAssign = function() {
        a.searchDataUserNotAssignOnly()
    };
    a.searchDataUserNotAssignOnly = function() {
        param = {
            searchInput: {
                coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserNotAssign.searchInput.userName,
                userCode: a.model.form.COA0330SearchDataUserNotAssign.searchInput.userCode

            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0330/searchUserNotAssign", param, function(b) {
            a.model.form.COA0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };

    a.checkChooseAllAfterSearch = function() {
//         if (null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo) {
//             for (var b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) {
//                 var f = a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b];
//                 f.choose = !1;
//                 for (var c = 0; c < a.model.form.listSelectUser.length; c++)
//                     if (a.model.form.listSelectUser[c] ==
//                         f.userId) f.choose = !0
//             }
//             a.checkChooseAll()
//         }
        a.model.form.listSelectUser = [];
        a.model.form.chooseAll = 1;
    };
    /**
     * Start not assign
     */

    a.prevPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage -= 1;
        a.searchDataUserNotAssignOnly()
    };
    a.nextPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage += 1;
        a.searchDataUserNotAssignOnly()
    };
    a.startPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage = 1;
        a.searchDataUserNotAssignOnly()
    };
    a.endPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages;
        a.searchDataUserNotAssignOnly()
    };

    /**
     * Start assign
     */
    a.searchUserAssign = function() {
        a.searchDataUserAssignOnly()
    };
    a.searchDataUserAssignOnly = function() {
        param = {
            searchInput: {
                coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserAssign.searchInput.userName,
                userCode: a.model.form.COA0330SearchDataUserAssign.searchInput.userCode

            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0430/searchUserAssign", param, function(b) {
            a.model.form.COA0330ResultSearchUserAssignModel = b;
        })
    };
    a.removeUser = function(b){
        e.doPost("/COA0430/removeUserFromCoaching", {
            coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
            userId:b.userId
        }, function(b) {
            null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
            a.searchDataUserNotAssignOnly();
            a.searchDataUserAssignOnly();
        })
    };
    a.prevPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage -= 1;
        a.searchDataUserAssignOnly()
    };
    a.nextPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage += 1;
        a.searchDataUserAssignOnly()
    };
    a.startPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage = 1;
        a.searchDataUserAssignOnly()
    };
    a.endPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages;
        a.searchDataUserAssignOnly()
    };

    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            coachingName: {
                isErrored: !1,
                msg: ""
            },
            coachingStartday: {
                isErrored: !1,
                msg: ""
            },
            coachingEndday: {
                isErrored: !1,
                msg: ""
            },
            coachingMoreStartDay: {
                isErrored: !1,
                msg: ""
            },
            coachingMoreEndDay: {
                isErrored: !1,
                msg: ""
            }
        };


        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.coachingName.isErrored = !0, a.model.hidden.validated.coachingName.msg = Messages.getMessage("E0000004", "COA0200_LABEL_COACHING_NAME");
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingStartday)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.coachingStartday.isErrored = !0, a.model.hidden.validated.coachingStartday.msg = Messages.getMessage("E0000004", "COA0200_LABEL_COACHING_STARTDAY");
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingEndday)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.coachingEndday.isErrored = !0, a.model.hidden.validated.coachingEndday.msg = Messages.getMessage("E0000004", "COA0200_LABEL_COACHING_ENDDAY");


        if ( ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingStartday)
            && ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingEndday)){

            console.log(a.model.form.COA0200CreateCoachingInputModel.coachingStartday)
            console.log(a.model.form.COA0200CreateCoachingInputModel.coachingEndday)

            var firstValue = a.model.form.COA0200CreateCoachingInputModel.coachingStartday.split('-');
            var secondValue = a.model.form.COA0200CreateCoachingInputModel.coachingEndday.split('-');

            var startDay = new Date(firstValue[2] + "-" + firstValue[1] + "-" + firstValue[0]).getTime();
            var endDay = new Date(secondValue[2] + "-" + secondValue[1] + "-" + secondValue[0]).getTime();
            var current = c("date")(new Date, "dd-MM-yyyy").split('-');
            var now = new Date(current[2] + "-" + current[1] + "-" + current[0]).getTime();
            if ((startDay < now) && $("#isEdit").val() == '0')
                a.model.hidden.validated.isErrored = !0,
                    a.model.hidden.validated.coachingMoreStartDay.isErrored = !0,
                    a.model.hidden.validated.coachingMoreStartDay.msg = Messages.getMessage("E0000030");

            if (startDay >=  endDay)
                a.model.hidden.validated.isErrored = !0,
                    a.model.hidden.validated.coachingMoreEndDay.isErrored = !0,
                    a.model.hidden.validated.coachingMoreEndDay.msg = Messages.getMessage("E0000031");

        }
    };

    a.nextCoaching = function() {
        if (a.countStep == 1){
            a.validate();
            !0 != a.model.hidden.validated.isErrored && a.createCoachingData({
                coachingName: a.model.form.COA0200CreateCoachingInputModel.coachingName,
                coachingStartday: a.model.form.COA0200CreateCoachingInputModel.coachingStartday,
                coachingEndday: a.model.form.COA0200CreateCoachingInputModel.coachingEndday,
                coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
            })

        }else{
            $("#assign-regional-manager").show();
            $("#coaching_template_question").hide();

            $("#next-coaching").hide();
            $("#next-assign").hide();

            $("#finish_coaching").show();
            a.countStep++;
            a.searchDataUserNotAssignOnly();
            a.searchDataUserAssignOnly();
        }
    };
    a.createCoachingData = function(b) {
        e.doPost("/COA0200/regisCoaching", b, function(b) {
            a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId = b.coachingTemplateId;
            a.getQuestion();
            $("#coaching_template").hide();
            $("#coaching_template_question").show();
            $("#back_coaching").show();

            $("#next-coaching").hide();
            $("#next-assign").show();
            a.countStep++;

        })
    };
    a.deleteSectionData = function(param) {
        e.doPost("/COA0200/deleteSection", param, function(b) {
            null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
            a.getQuestion();

        })
    };
    a.backStore = function(){
        if (a.countStep == 2){
            $("#coaching_template").show();
            $("#coaching_template_question").hide();
            $("#back_coaching").hide();
            $("#next-coaching").show();
            $("#next-assign").hide();

            a.countStep--;
        }
        if (a.countStep == 3){
            $("#coaching_template").hide();
            $("#assign-regional-manager").hide();
            $("#finish_coaching").hide();

            $("#coaching_template_question").show();
            $("#back_coaching").show();
            $("#next-coaching").hide();
            $("#next-assign").show();


            a.countStep--;
        }

    };
    a.addQuestions = function() {
        a.model.hidden.showCOA0220 = !0;
    }

    a.editQuestions = function(b){
        angular.element("#coachingTemplateSectionId").val(b.coaching_template_section_id);
        a.model.hidden.showCOA0220 = !0;
    };

    a.getQuestion = function(){
        a.getQuestionData({
            coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
        });
    };
    a.deleteSection = function(b){
        a.deleteSectionData({
            coachingTemplateSectionId:b.coaching_template_section_id
        })
    };

    a.getQuestionData = function(param) {
        e.doPost("/COA0200/coachingSection", param, function(b) {
            a.model.form.COA0200CreateCoachingSectionResultDto = b
            a.model.form.listSelectUser = a.model.form.COA0200CreateCoachingSectionResultDto.listSelectUser;

        })
    };


}]);
var coa0220Module = angular.module("coa0220Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("COA0220Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.createQuestionData = function(a, c) {
        d.doPost("/COA0220/saveQuestion", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.initData = function() {
        d.doPost("/COA0220/initData", {coachingTemplateSectionId: angular.element("#coachingTemplateSectionId").val()}, function(b) {
            a.model.form.CAO0200InitDataModel = b;
            a.model.form.COA0220CreateQuestionInputModel = b.initData.inforSection

        })
    };

    a.count = 0;
    a.init = function() {
        a.model = {
            hidden: {
                showCOA0220:  !1,
                coachingTemplateId:"",
                validated: {
                    isErrored: !1,
                    questionType: {
                        isErrored: !1,
                        msg: ""
                    },
                    questionTitle: {
                        isErrored: !1,
                        msg: ""
                    }
                },
                needToCalculate:1
            }
        };
        a.model.form = {
            CAO0200InitDataModel: null,
            COA0220CreateQuestionInputModel: {
                questionType: null,
                questionTitle:"",
                optionValues:[],
                needToCalculate:1
            },
            COA0220CreateQuestionResult:null,
            coachingTemplateSectionId:""
        };
        a.model.hidden.coachingTemplateId = angular.element("#coachingTemplateId").val();
        a.initData();

    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            questionType: {
                isErrored: !1,
                msg: ""
            },
            questionTitle: {
                isErrored: !1,
                msg: ""
            },
            optionValues: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0220CreateQuestionInputModel.questionTitle)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.questionTitle.isErrored = !0, a.model.hidden.validated.questionTitle.msg = Messages.getMessage("E0000004", "COA0200_LABEL_QUESTION_TITLE");
        if (a.model.form.COA0220CreateQuestionInputModel.optionValues.length <= 0 || a.model.form.COA0220CreateQuestionInputModel.optionValues[0]["sectionItemTitle"] == "")
            a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.optionValues.isErrored = !0,
                a.model.hidden.validated.optionValues.msg = Messages.getMessage("E0000004", "COA0200_LABEL_QUESTION_NOTE");
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0220CreateQuestionInputModel.questionType)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.questionType.isErrored = !0, a.model.hidden.validated.questionType.msg = Messages.getMessage("E0000004", "COA0200_LABEL_QUESTION_TYPE");
    };
    a.closeEdit = function() {
        a.model.hidden.showCOA0220 = !1;
        c.$broadcast("COA0200#showCOA0220", {
            showCOA0220: a.model.hidden.showCOA0220
        })
        angular.element("#coachingTemplateSectionId").val("")
    };
    a.addItem = function(){
        a.model.form.COA0220CreateQuestionInputModel.optionValues.push({"sectionItemTitle":""})
        setTimeout(function(){
            $("#space-for-buttons :input[type='text']").each(function(){
                if ($(this).val() == ""){
                    $(this).focus();
                }
            });
        }, 100);



    };
    a.removeItem = function($event) {
        var parent = $($event.target).parent();
        if (parent.attr("id") != "") {
            for (var c = 0; c < a.model.form.COA0220CreateQuestionInputModel.optionValues.length; c++)
                if (a.model.form.COA0220CreateQuestionInputModel.optionValues[c] != undefined &&
                    a.model.form.COA0220CreateQuestionInputModel.optionValues[c].coachingTemplateSectionItemId == parent.attr("id")) {
                    a.model.form.COA0220CreateQuestionInputModel.optionValues.splice(c, 1);
                    break
                }
        }else{
            $(parent).find('input[type=text]').each(function() {
                for (var c = 0; c < a.model.form.COA0220CreateQuestionInputModel.optionValues.length; c++)
                    if (a.model.form.COA0220CreateQuestionInputModel.optionValues[c] != undefined &&
                        a.model.form.COA0220CreateQuestionInputModel.optionValues[c].sectionItemTitle == $(this).val() ) {
                        a.model.form.COA0220CreateQuestionInputModel.optionValues.splice(c, 1);
                        break
                    }
            })
        }
    };
    a.createQuestion = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            coachingTemplateId: a.model.hidden.coachingTemplateId,
            coachingTemplateSectionId: angular.element("#coachingTemplateSectionId").val(),
            questionTitle: a.model.form.COA0220CreateQuestionInputModel.questionTitle,
            questionType: a.model.form.COA0220CreateQuestionInputModel.questionType,
            optionValues: a.model.form.COA0220CreateQuestionInputModel.optionValues,
            needToCalculate: a.model.form.COA0220CreateQuestionInputModel.needToCalculate == true ? 1 : 0
        }, a.createQuestionData(param, function(b) {
            a.model.form.COA0220CreateQuestionResult = b;
            null != a.model.form.COA0220CreateQuestionResult.proResult && ("NG" == a.model.form.COA0220CreateQuestionResult.proResult.proFlg ? e.pop("error", a.model.form.COA0220CreateQuestionResult.proResult.message,
                null, "trustedHtml") : e.pop("success", a.model.form.COA0220CreateQuestionResult.proResult.message, null, "trustedHtml"))
            a.closeEdit();
            c.$broadcast("COA0200#reloadSection");
        }))
    };
}]);
coa0220Module.directive("addbuttonsbutton", function(){
    return {
        restrict: "E",
        template: '<a href="" addbuttons>Add "Other"</a>'
    }
});

//Directive for adding buttons on click that show an alert on click
coa0220Module.directive("addbuttons", function($compile){
    return function(scope, element, attrs){
        element.bind("click", function(){
            scope.count++;
            var template = '<div class="answer-main" >' +
                '<span></span>' +
                '<input type="checkbox" class="checkbox-answer"  disabled="disabled"/>' +
                '<input type="text" ng-model="model.form.COA0220CreateQuestionInputModel.optionValues['+scope.count+'].sectionItemTitle"' +
                'class="form-control-dms width200"> <span style="min-width: 15px ! important;"  ng-click="removeItem($event)"  class="delete-store pull-right icon-close  delete-input" ></span>' +
                '</div>';
            angular.element(document.getElementById('space-for-buttons')).append($compile(template)(scope));
        });
    };
});

coa0200Module.directive('myOnChange', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        scope: {
            myOnChange: '='
        },
        link: function (scope, elm, attr) {
            if (attr.type === 'radio' || attr.type === 'checkbox') {
                return;
            }
            // store value when get focus
            elm.bind('focus', function () {
                scope.value = elm.val();

            });

            // execute the event when loose focus and value was change
            elm.bind('blur', function () {
                var currentValue = elm.val();
                if (scope.value !== currentValue) {
                    if (scope.myOnChange) {
                        scope.myOnChange();
                    }
                }
            });
        }
    };
});

var coa0400Module = angular.module("coa0400Module", ["dmsCommon","toaster", "ngLoadingSpinner"]).controller("COA0400Ctrl", ["$scope", "$http", "$filter", "serverService", "toaster", function(a, d, c, e, f) {
    a.init = function() {
        a.model = {
            hidden: {
                showCOA0220: !1
            }
        };
        a.model.form = {
            chooseAll: !1,
            COA0200InitDataOutputModel: null,
            CAO0200InitDataModel:null,
            COA0200CreateCoachingInputModel: {
                coachingName: "",
                coachingStartday: "",
                coachingEndday: "",
                coachingCode:"",
                coachingTemplateId:0
            },
            COA0200CreateCoachingResultDto: null,
            COA0200CreateCoachingSectionResult:null,
            COA0200CreateCoachingSectionResultDto:null,
            COA0330ResultSearchUserAssignModel: {
                resultUserAssign: {
                    searchInput: {
                        userName: "",
                        userCode:""
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            },
            COA0330ResultSearchUserMarkModel: {
                resultUserMark: {
                    searchInput: {
                        userName: "",
                        userCode:""
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            },
            COA0330SearchDataUserAssign: {
                searchInput: {
                    userName:"",
                    userCode:""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            COA0330SearchDataUserMark: {
                searchInput: {
                    userName:"",
                    userCode:"",
                    userId:0
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            listSelectUser: []
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                coachingName: {
                    isErrored: !1,
                    msg: ""
                },
                coachingStartday: {
                    isErrored: !1,
                    msg: ""
                },
                coachingEndday: {
                    isErrored: !1,
                    msg: ""
                }
            }
        };
        a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId = $('#coachingTemplateIdFirsLoad').val()
        a.searchType();
    };
    a.searchType = function(){
        a.searchUserAssign();
    }
    a.searchUserMark = function(){
        a.searchUserAssign();
    }
    a.countStep = 1;

    a.viewListCoaching = function() {
        window.location.href = getContextPath() + "/COA0100";
    };

    a.viewAnswer = function(b){
        a.viewAnswerData({
            coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
            userId: b.userId,
            coachingSalesmanId : b.coachingSalesmanId
        }, function(b) {
            a.model.form.COA0200CreateCoachingSectionResult = b
        })
    };

    a.viewAnswerData = function(a, c) {
        $("#coaching_template_answer").show();
        $("#assign-regional-manager").hide();
        $("#assign-regional-mark-user").hide();

        e.doPost("/COA0440/viewAnswerData", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.backListManger = function() {
        $("#assign-regional-mark-user").hide();
        $("#assign-regional-manager").show();
    };
    a.backListUser = function() {
        $("#assign-regional-mark-user").show();
        $("#assign-regional-manager").hide();
        $("#coaching_template_answer").hide();

    };

    a.chooseUser = function(b) {
        !1 == b.choose && a.removeUserItem(b);
        !0 == b.choose && a.addUserItem(b)
    };
    a.removeUserItem = function(b) {
        for (var f = 0; f < a.model.form.listSelectUser.length; f++)
            if (a.model.form.listSelectUser[f] == b.userId) {
                a.model.form.listSelectUser.splice(f,
                    1);
                break
            }
        a.checkChooseAll()
    };
    a.addUserItem = function(b) {
        a.model.form.listSelectUser.push(b.userId);
        a.checkChooseAll()
    };
    a.addUserData = function(a, c) {
        e.doPost("/COA0330/assignUserCoaching", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.checkChooseAllAfterSearch = function() {
        a.model.form.listSelectUser = [];
        a.model.form.chooseAll = 1;
    };

    a.searchUserAssign = function() {
        a.searchDataUserAssignOnly()
    };
    a.searchDataUserAssignOnly = function() {
        param = {
            searchInput: {
                coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserAssign.searchInput.userName,
                userCode: a.model.form.COA0330SearchDataUserAssign.searchInput.userCode
            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0430/searchUserAssign", param, function(b) {
            a.model.form.COA0330ResultSearchUserAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };

    a.prevPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage -= 1;
        a.searchDataUserAssignOnly()
    };
    a.nextPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage += 1;
        a.searchDataUserAssignOnly()
    };
    a.startPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage = 1;
        a.searchDataUserAssignOnly()
    };
    a.endPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages;
        a.searchDataUserAssignOnly()
    };

    a.searchUserMark = function() {
        a.searchDataUserMarkOnly()
    };
    a.searchDataUserMarkOnly = function() {
        param = {
            searchInput: {
                coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserMark.searchInput.userName,
                userId: a.model.form.COA0330SearchDataUserMark.searchInput.userId

            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo ? a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo ? a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo ? a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0430/searchUserMark", param, function(b) {
            a.model.form.COA0330ResultSearchUserMarkModel = b;
        })
    };

    a.viewUserMark = function(b){
        a.model.form.COA0330SearchDataUserMark.searchInput.userId = b.userId
        $("#assign-regional-mark-user").show();
        $("#assign-regional-manager").hide();

        a.searchDataUserMarkOnly();
    }

    a.prevPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage -= 1;
        a.searchDataUserMarkOnly()
    };
    a.nextPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage += 1;
        a.searchDataUserMarkOnly()
    };
    a.startPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage = 1;
        a.searchDataUserMarkOnly()
    };
    a.endPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlPages;
        a.searchDataUserMarkOnly()
    };

    a.nextCoaching = function() {
        if (a.countStep == 1){
            $("#coaching_template").hide();
            $("#coaching_template_question").show();
            $("#back_coaching").show();
            $("#next-coaching").hide();
            $("#next-assign").show();
            a.createCoachingData({
                coachingName: a.model.form.COA0200CreateCoachingInputModel.coachingName,
                coachingStartday: a.model.form.COA0200CreateCoachingInputModel.coachingStartday,
                coachingEndday: a.model.form.COA0200CreateCoachingInputModel.coachingEndday,
                coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
            })
            a.countStep++;
        }else{
            $("#coaching_template_question").hide();
            $("#next-coaching").hide();
            $("#next-assign").hide();
            a.countStep++;
            a.searchDataUserAssignOnly();
        }

        $("#finish_coaching").show();
        $("#coaching_template_answer").hide();
        $("#assign-regional-mark-user").hide();
        $("#assign-regional-manager").hide();

    };
    a.createCoachingData = function(b) {
        e.doPost("/COA0200/regisCoaching", b, function(b) {
            a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId = b.coachingTemplateId;
            a.getQuestion();
        })
    };
    a.backStore = function(){
        $("#coaching_template_answer").hide();
        $("#assign-regional-mark-user").hide();
        $("#assign-regional-manager").show();
        $("#coaching_template_question").show();
        $("#finish_coaching").hide();

        if (a.countStep == 2){
            $("#coaching_template").show();
            $("#coaching_template_question").hide();
            $("#back_coaching").hide();
            $("#next-coaching").show();
            $("#next-assign").hide();
            a.countStep--;
        }
        if (a.countStep == 3){
            $("#coaching_template").hide();
            $("#assign-regional-manager").hide();
            $("#finish_coaching").hide();

            $("#coaching_template_question").show();
            $("#back_coaching").show();
            $("#next-coaching").hide();
            $("#next-assign").show();
            a.countStep--;
        }

    };
    a.addQuestions = function() {
        a.model.hidden.showCOA0220 = !0;
    }

    a.editQuestions = function(b){
        angular.element("#coachingTemplateSectionId").val(b.coaching_template_section_id);
        a.model.hidden.showCOA0220 = !0;
    };

    a.getQuestion = function(){
        a.getQuestionData({
            coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
        });
    };

    a.getQuestionData = function(param) {
        e.doPost("/COA0200/coachingSection", param, function(b) {
            a.model.form.COA0200CreateCoachingSectionResultDto = b
            a.model.form.listSelectUser = a.model.form.COA0200CreateCoachingSectionResultDto.listSelectUser;

        })
    };


}]);

angular.module("coa0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner"]).controller("COA0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
        a.model = {
            hidden: {
                showModalResetPassword: !1,
                showModalEditUser: !1,
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                }
            }
        };
        a.model.form = {
            COA0100InitDataModel: null,
            searchParam: {
                searchInput: {
                    coachingName: "",
                    coachingCode: "",
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            COA0100SearchDataResult: null
        };
        a.initData()
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.deleteDataCoaching = function (param) {
        d.doPost("/COA0100/deleteCoaching", param, function (b) {
            null != b.proResult && ("NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message,
                null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml"))
            a.searchDataOnly()
        })

    };
    a.deleteCoaching = function (b) {
        a.deleteDataCoaching({
            coachingTemplateId: b.coaching_template_id
        })
    };

    a.initData = function () {
        d.doPost("/COA0100/initData", {}, function (b) {
            a.model.form.COA0100InitDataModel = b;
        })
    };
    a.searchData = function () {
        d.doPost("/COA0100/searchData", {
            searchInput: {
                coachingCode: a.model.form.searchParam.searchInput.coachingCode,
                coachingName: a.model.form.searchParam.searchInput.coachingName,
            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0100InitDataModel.resultSearch.pagingInfo ? a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0100InitDataModel.resultSearch.pagingInfo ?
                    a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.COA0100InitDataModel.resultSearch.pagingInfo ? a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.COA0100SearchDataResult = b;
            a.model.form.COA0100InitDataModel.resultSearch.coaInfo = a.model.form.COA0100SearchDataResult.resultSearch.coaInfo;
            a.model.form.COA0100InitDataModel.resultSearch.pagingInfo = a.model.form.COA0100SearchDataResult.resultSearch.pagingInfo
        })
    };
    a.searchDataOnly = function () {
        d.doPost("/COA0100/searchData", {
            searchInput: {
                coachingCode: a.model.form.searchParam.searchInput.coachingCode,
                coachingName: a.model.form.searchParam.searchInput.coachingName,
            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0100InitDataModel.resultSearch.pagingInfo ? a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0100InitDataModel.resultSearch.pagingInfo ?
                    a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.COA0100InitDataModel.resultSearch.pagingInfo ? a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.COA0100SearchDataResult = b;
            a.model.form.COA0100InitDataModel.resultSearch.coaInfo =
                a.model.form.COA0100SearchDataResult.resultSearch.coaInfo;
            a.model.form.COA0100InitDataModel.resultSearch.pagingInfo = a.model.form.COA0100SearchDataResult.resultSearch.pagingInfo;
        })
    }
}]);