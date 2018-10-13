/**
 * Created by ledaicanh on 11/16/17.
 */
/**
 * START KPI
 */
var kpi0100Module = angular.module("kpi0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner"]).controller("KPI0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", "$filter", function (a, d, c, e, f) {
    a.init = function () {
        a.model = {};
        a.model.hidden = {
            productTypeId: 0,
            currentMonth: "",
            productTypeKpiId: 0
        };
        a.model.form = {
            KPI0100ResultSearchTeamModel: null,
            KPI0100Model: {
                productTypeKpiId: "",
                productTypeId: "",
                currentMonth: "",
                trainingDays: "",
                callRate: "",
                promotionDays: "",
                meetingDays: "",
                holidays: "",
                leaveTaken: "",
                frequency1: "",
                frequency2: "",
                frequency3: ""

            },
            KPI0100SearchDataSalesmanResult: {
                resultSearch: {
                    pagingInfo: null
                }
            }
        };
        a.initData()
    };
    a.saveKpi = function () {
        d.doPost("/KPI0100/saveKpi", {
            productTypeKpiId: a.model.form.KPI0100Model.productTypeKpiId,
            productTypeId: a.model.hidden.productTypeId,
            currentMonth: a.model.form.KPI0100Model.currentMonth,
            trainingDays: a.model.form.KPI0100Model.trainingDays,
            callRate: a.model.form.KPI0100Model.callRate,
            promotionDays: a.model.form.KPI0100Model.promotionDays,
            meetingDays: a.model.form.KPI0100Model.meetingDays,
            holidays: a.model.form.KPI0100Model.holidays,
            leaveTaken: a.model.form.KPI0100Model.leaveTaken,
            frequency1: a.model.form.KPI0100Model.frequency1,
            frequency2: a.model.form.KPI0100Model.frequency2,
            frequency3: a.model.form.KPI0100Model.frequency3

        }, function (b) {
            a.model.form.KPI0100Model.productTypeKpiId = b.productTypeKpiId;
            null != b.proResult && ("NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message,
                null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml"))

        })
    }
    a.loadDetailKpi = function (b) {
        a.model.hidden.productTypeId = b.productTypeId;
        today = new Date();
        a.model.hidden.currentMonth = today
        $("#input1").val(f("date")(new Date, "MM-yyyy"))
        $("#result-add-times").css("display", "inline-block");
        a.searchData();
    };
    a.loadDataWhenChangeMonth = function (b) {
        a.model.hidden.currentMonth = b
        a.searchData();
    }
    a.search = function () {
        a.searchDataOnly();
    };
    a.prevPage = function () {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage = a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };

    a.initData = function () {
        d.doPost("/KPI0100/initData", {}, function (b) {
            a.model.form.KPI0100ResultSearchTeamModel = b;
        })
    };

    a.searchData = function () {
        d.doPost("/KPI0100/searchData", {
            searchInput: {
                productTypeId: a.model.hidden.productTypeId,
                currentMonth: a.model.hidden.currentMonth,
            },
            pagingInfo: {
                ttlRow: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ? a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ?
                    a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ? a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.KPI0100SearchDataSalesmanResult = b;
            a.model.form.KPI0100Model = b.timeInfo
            if (a.model.form.KPI0100Model.currentMonth == undefined) {
                a.model.form.KPI0100Model.currentMonth = a.model.hidden.currentMonth;
            } else {
                a.model.hidden.currentMonth = a.model.form.KPI0100Model.currentMonth;
            }
        })
    };
    a.searchDataOnly = function () {
        d.doPost("/COA0100/searchData", {
            searchInput: {
                coachingCode: a.model.form.searchParam.searchInput.coachingCode,
                coachingName: a.model.form.searchParam.searchInput.coachingName,
            },
            pagingInfo: {
                ttlRow: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ? a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ?
                    a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ? a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.COA0100SearchDataResult = b;
            a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.coaInfo =
                a.model.form.COA0100SearchDataResult.resultSearch.coaInfo;
            a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo = a.model.form.COA0100SearchDataResult.resultSearch.pagingInfo;
        })
    }
}]);

kpi0100Module.directive('numbersOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }

            ngModelCtrl.$parsers.push(fromUser);
        }
    };
});

kpi0100Module.directive('datetimez', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            element.datetimepicker({
                format: "MM-yyyy",
                viewMode: "months",
                minViewMode: "months",
                pickTime: false
            }).on('changeDate', function (e) {
                ngModelCtrl.$setViewValue(e.date);
                scope.$apply();
                scope.loadDataWhenChangeMonth(e.date);
            });
        }
    };
});

/**
 * END KPI
 */