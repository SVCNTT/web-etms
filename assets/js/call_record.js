/*Call record - Begin*/
var rec0100Module = angular.module("rec0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner"]).controller("REC0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {};
        a.model.activeTab = 1
    }
}]);
rec0100Module.controller("REC0200Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.initData = function(a, e) {
        d.doPost("/REC0210/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model.hidden = {
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            }
        };
        a.model.form = {
            REC0210initData: {
                resultInit: {
                    mr: null
                }
            },
            searchParam : {
                mr_id : null,
                store_id : null,
                product_group_id : null,
                validate : null
            },
            resultSearch : {
                callRecordList: null,
                pagingInfo: {
                    ttlRow: null,
                    crtPage: null,
                    rowNumber: null,
                    ttlPages: 0
                }
            }
        },
            a.initData({}, function(c) {
                a.model.form.REC0210initData = c
                a.searchData();
            })
    }
    a.prevPage = function() {
        a.model.form.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.resultSearch.pagingInfo.crtPage = a.model.form.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function() {
        d.doPost("/REC0220/searchData", {
            mr_id : a.model.form.searchParam.mr_id,
            store_id : a.model.form.searchParam.store_id,
            product_group_id : a.model.form.searchParam.product_group_id,
            validate : a.model.form.searchParam.validate,
            pagingInfo: {
                ttlRow: null != a.model.form.resultSearch.pagingInfo ? a.model.form.resultSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.resultSearch.pagingInfo ? a.model.form.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.resultSearch.pagingInfo ? a.model.form.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
            a.model.form.resultSearch = b.resultSearch
        })
    };
    a.deleteRecord = function(b) {
        d.doPost("/REC0240/deleteRecord", {
            id : b.call_record_id,
            token : b.token
        }, function(b) {
            "OK" == b.proResult.proFlg && (e.pop("success", b.proResult.message, null, "trustedHtml"), a.searchData());
            "NG" == b.proResult.proFlg && e.pop("error", b.proResult.message, null, "trustedHtml")
        })
    };
}]);
rec0100Module.controller("REC0300Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.initData = function(a, e) {
        d.doPost("/REC0310/getData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model.form = {
            REC0300SearchData: null,
            postQuestion: null,
            searchParam: {
                searchInput: {
                    productGroupName: ""
                }
            },
            resultSearch: {
                pagingInfo: {
                    ttlRow: null,
                    crtPage: null,
                    rowNumber: null,
                    ttlPages: 0
                }
            },
            dataQuestion: {
                product_group_id: null,
                product_group_name: null,
                list : null
            }
        };

        a.initData({}, function(c) {
            a.model.form.REC0300SearchData = c
        })
    };
    a.searchProductGroup  = function() {
        a.initData(a, e);
    };
    a.prevPage = function() {
        a.model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage = a.model.form.REC0300SearchData.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function() {
        d.doPost("/REC0310/getData", {
            productGroupName: a.model.form.searchParam.searchInput.productGroupName,
            pagingInfo: {
                ttlRow: null != a.model.form.REC0300SearchData.resultSearch.pagingInfo ? a.model.form.REC0300SearchData.resultSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.REC0300SearchData.resultSearch.pagingInfo ? a.model.form.REC0300SearchData.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.REC0300SearchData.resultSearch.pagingInfo ? a.model.form.REC0300SearchData.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
            a.model.form.REC0300SearchData = b;
        })
    };
    a.getQuestion = function(item) {
        a.model.form.dataQuestion.product_group_id = -1;
        d.doPost("/REC0320/getQuestion", {
            product_group_id: item.product_group_id
        }, function(b){
            a.model.form.dataQuestion.product_group_id = item.product_group_id;
            a.model.form.dataQuestion.product_group_name = item.product_group_name;
            a.model.form.dataQuestion.list = b.resultSearch.questions;

            initListQuestion();
        });
    }
    a.refreshQuestion = function() {
        a.model.form.postQuestion = [];
        $('#list-question textarea').each(function(i)
        {
            a.model.form.postQuestion.push({'question':$(this).val()});
        });
        a.model.form.dataQuestion.list = a.model.form.postQuestion;
    }
    a.addQuestion = function() {
        a.refreshQuestion();
        a.model.form.dataQuestion.list.push({'question':''});
        initListQuestion();
    }
    a.removeQuestion = function(question) {
        a.refreshQuestion();
        var index = null;
        for (var temp in a.model.form.dataQuestion.list) {
            if (a.model.form.dataQuestion.list[temp].question == question.question) {
                index = temp;
                break;
            }
        }

        if (index != null) {
            if (confirm(Messages.getMessage("REC0300_CONFIRM_REMOVE_QUESTION"))) {
                a.model.form.dataQuestion.list.splice(index, 1);
            }
        }
    }
    a.saveQuestion = function() {
        a.refreshQuestion();

        d.doPost("/REC0330/saveQuestion", {
            product_group_id : a.model.form.dataQuestion.product_group_id,
            questions: a.model.form.dataQuestion.list
        }, function(b){
            "OK" == b.proResult.proFlg ? e.pop("success", b.proResult.message, null, "trustedHtml") : e.pop("error", b.proResult.message, null, "trustedHtml")
        });
    }
}]);

rec0100Module.controller("REC0230Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {};
        a.model.form = {
            REC0230GetData: null
        };
        a.model.hidden = {
            call_record_id: angular.element("#call-record-id").val(),
            token: angular.element("#call-record-tk").val()
        };
        a.initData(
            {
                call_record_id: a.model.hidden.call_record_id,
                token: a.model.hidden.token
            }, function(c) {
                a.model.form.REC0230GetData = c;
            })
    }
    a.initData = function(a, e) {
        d.doPost("/REC0230/getDetail", a, function(a) {
            (e || angular.noop)(a)
        })
    };
}]);
/*Call record - End*/