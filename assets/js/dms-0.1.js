/* MonthlyReport start */
var mrpt0200Module = angular.module("mrpt0200Module", ["dmsCommon", "toaster"]).controller("MRPT0200Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
        a.model = {};
        a.model = {
            hidden: {
                currentMonth: new Date()
            }
        };
        a.model.form = {
            MRPT0200ChangeMonthlyReportInputModel: {
                currentYear: null,
                currentMonth: new Date(),
                bu: null,
                productTypeInfo: null
            },
            MRPT0200ResultModal: null
        }
        a.initData();
    };
    a.initData = function() {
        d.doPost("/MRPT0200/initData", null, function(b) {
            a.model.form.MRPT0200ChangeMonthlyReportInputModel.productTypeInfo = b.productTypeInfo;
        })
        a.loadDataWhenChangeMonth(new Date());
    };
    a.loadDataWhenChangeMonth = function (b) {
        a.model.hidden.currentMonth = b;
        a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentMonth = (b.getMonth() + 1);
        a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentYear = b.getFullYear();
    }
    a.closeMonthlyReport = function () {
        c.$broadcast("MRPT0200#closeMonthlyReportModal", {})
    };
    a.exportMonthlyReport = function () {

        (param = {
            monthReport: a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentMonth,
            yearReport: a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentYear,
            bu: a.model.form.MRPT0200ChangeMonthlyReportInputModel.bu
        }, a.chgMonthReport(param, function (b) {
            a.model.form.MRPT0200ResultModal = b.proResult;
            if ("NG" != a.model.form.MRPT0200ResultModal.proFlg) {
                var pathFile = a.model.form.MRPT0200ResultModal.pathFile;
                window.location.href = pathFile;
            }
            "NG" == a.model.form.MRPT0200ResultModal.proFlg ? e.pop("error", a.model.form.MRPT0200ResultModal.message,
                null, "trustedHtml") : (e.pop("success", a.model.form.MRPT0200ResultModal.message, null, "trustedHtml"), c.$broadcast("MRPT0200#closeMonthlyReportModal", {}))
        }))
    };
    a.chgMonthReport = function (a, f) {
        d.doPost("/MRPT0200/export", a, function (a) {
            (f || angular.noop)(a)
        })
    }
}]);

mrpt0200Module.directive('datetimez', function () {
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

/* MonthlyReport end */

angular.module("aut0200Module", ["dmsCommon", "toaster"]).controller("AUT0200Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.chgPassData = function (a, f) {
        d.doPost("/AUT0200/chgPass", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function () {
        a.model = {};
        a.model = {
            hidden: {
                validated: {
                    isErrored: !1,
                    oldPassword: {
                        isErrored: !1,
                        msg: ""
                    },
                    newPassword: {
                        isErrored: !1,
                        msg: ""
                    },
                    confirmPassword: {
                        isErrored: !1,
                        msg: ""
                    },
                    checkPassword: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            AUT0200ChangePasswordInputModel: {
                oldPassword: null,
                newPassword: null,
                confirmPassword: null
            },
            AUT0200ResultModal: null
        }
    };
    a.closeChangePassword = function () {
        c.$broadcast("AUT0200#closeChangePasswordModal", {})
    };
    a.validate = function () {
        a.model.hidden.validated = {
            isErrored: !1,
            oldPassword: {
                isErrored: !1,
                msg: ""
            },
            newPassword: {
                isErrored: !1,
                msg: ""
            },
            confirmPassword: {
                isErrored: !1,
                msg: ""
            },
            checkPassword: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.AUT0200ChangePasswordInputModel.oldPassword)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.oldPassword.isErrored = !0, a.model.hidden.validated.oldPassword.msg = Messages.getMessage("E0000004", "AUT0200_LABEL_OLD_PASSWORD");
        if (!ValidateUtil.isValidTextRequired(a.model.form.AUT0200ChangePasswordInputModel.newPassword)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.newPassword.isErrored = !0, a.model.hidden.validated.newPassword.msg = Messages.getMessage("E0000004", "AUT0200_LABEL_NEW_PASSWORD");
        if (!ValidateUtil.isValidTextRequired(a.model.form.AUT0200ChangePasswordInputModel.confirmPassword)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.confirmPassword.isErrored = !0, a.model.hidden.validated.confirmPassword.msg = Messages.getMessage("E0000004", "AUT0200_LABEL_CONFIRM_PASSWORD");
        if (a.model.form.AUT0200ChangePasswordInputModel.newPassword != a.model.form.AUT0200ChangePasswordInputModel.confirmPassword) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkPassword.isErrored = !0, a.model.hidden.validated.newPassword.isErrored = !0, a.model.hidden.validated.confirmPassword.isErrored = !0, a.model.hidden.validated.checkPassword.msg =
            Messages.getMessage("E0000005")
    };
    a.updatePassword = function () {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            oldPassword: a.model.form.AUT0200ChangePasswordInputModel.oldPassword,
            newPassword: a.model.form.AUT0200ChangePasswordInputModel.newPassword,
            reNewPassword: a.model.form.AUT0200ChangePasswordInputModel.confirmPassword
        }, a.chgPassData(param, function (b) {
            a.model.form.AUT0200ResultModal = b.proResult;
            "NG" == a.model.form.AUT0200ResultModal.proFlg ? e.pop("error", a.model.form.AUT0200ResultModal.message,
                null, "trustedHtml") : (e.pop("success", a.model.form.AUT0200ResultModal.message, null, "trustedHtml"), c.$broadcast("AUT0200#closeChangePasswordModal", {}))
        }))
    }
}]);

var dmsCommon = angular.module("dmsCommon", ["toaster", "aut0200Module", "mrpt0200Module"]);
dmsCommon.filter("noFractionCurrency", ["$filter", "$locale", function (a, d) {
    var c = a("currency"),
        e = d.NUMBER_FORMATS;
    return function (a, f) {
        var d = c(a, f),
            g = d.indexOf(e.DECIMAL_SEP);
        return 0 <= a ? d.substring(0, g) : d.substring(0, g) + ")"
    }
}]);
dmsCommon.controller("commonCtrl", ["$scope", "$rootScope", "$http", "$window", "$filter", "serverService", "idleService", function (a, d, c, e, b, f, h) {
    a.model = {};
    a.model = {
        form: {}
    };
    a.model = {
        hidden: {
            monthlyReport: !1,
            changePassword: !1
        }
    };
    a.$on("AUT0200#closeChangePasswordModal", function () {
        a.model.hidden.changePassword = !1
    });

    a.$on("MRPT0200#closeMonthlyReportModal", function () {
        a.model.hidden.monthlyReport = !1
    });
    a.$on("doPost", function (a, b) {
        f.doPost(b.action, b.params, b.callback)
    });
    a.getMessages = function (a) {
        d.$broadcast("doPost", {
            action: "DAS0100/getMessages",
            callback: function (b) {
                (a || angular.noop)(b)
            }
        })
    };
    Messages.hasMessage() ||
    a.getMessages(function (a) {
        Messages.setMessage(a.msgList)
    });
    h.start()
}]);
dmsCommon.service("serverService", ["$http", "$window", "toaster", "idleService", function (a, d, c, e) {
    this.doPost = function (b, f, d, g) {
        null != b && 0 < b.length && "/" != b.substring(0, 1) && (b = "/" + b);
        b = {
            headers: {
                "X-CSRF-TOKEN": $("meta[name=_csrf]").attr("content")
            },
            method: "POST",
            url: getContextPath() + b,
            data: angular.copy(f)
        };
        b.actionStartDate = new Date;
        Fukyo.utils.LogUtils.isDebug() && (Fukyo.utils.LogUtils.trace("[ACTION   START] : " + b.url), Fukyo.utils.LogUtils.trace("[ACTION   INPUT] : " + angular.toJson(f)));
        a(b).success(function (a,
                               b, f, g) {
            Fukyo.utils.LogUtils.isDebug() && (Fukyo.utils.LogUtils.trace("[ACTION   END  ] : " + g.url + " [" + (new Date - g.actionStartDate) + "ms]"), Fukyo.utils.LogUtils.trace("[ACTION   OUTPUT] : ", a));
            b = new Date;
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK START] : " + g.url);
            angular.isDefined(a) && null != a && "NG" == a.returnCd && c.pop("error", a.returnMsg, null, "trustedHtml");
            (d || angular.noop)(a);
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK END  ] : " + g.url + " [" + (new Date -
            b) + "ms]");
            e.reset()
        }).error(function (a, b, f, e) {
            Fukyo.utils.LogUtils.isDebug() && (Fukyo.utils.LogUtils.trace("[ACTION   ERROR] : " + e.url + " [" + (new Date - e.actionStartDate) + "ms]"), Fukyo.utils.LogUtils.trace(f), Fukyo.utils.LogUtils.trace(b));
            Fukyo.utils.LogUtils.error(a);
            (g || angular.noop)(a);
            c.pop("error", Messages.getMessage("F0000001"), null, "trustedHtml")
        })
    };
    this.downloadFile = function (a, f) {
        var c = getContextPath() + a,
            e = document.createElement("form");
        e._submit_function_ = e.submit;
        e.setAttribute("method", "POST");
        e.setAttribute("action", c);
        e.setAttribute("name", "form");
        for (var d in f) f.hasOwnProperty(d) && void 0 != f[d] && null != f[d] && (c = document.createElement("input"), c.setAttribute("type", "hidden"), c.setAttribute("name", d), c.setAttribute("value", f[d]), e.appendChild(c));
        Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[SUBMIT   START] : " + a, f);
        document.body.appendChild(e);
        e._submit_function_()
    };
    this.uploadFile = function (b, f, e, d, i) {
        var k = new Date,
            j = getContextPath() + b,
            b = new FormData;
        null != f && b.append("file",
            f);
        if (angular.isDefined(e) && null != e) {
            var l = angular.toJson(e);
            b.append("param", l)
        }
        Fukyo.utils.LogUtils.isDebug() && (Fukyo.utils.LogUtils.trace("[ACTION   START] : " + j), Fukyo.utils.LogUtils.trace("[ACTION   FILE] : " + f), Fukyo.utils.LogUtils.trace("[ACTION   INPUT] : " + angular.toJson(e)));
        a.post(j, b, {
            transformRequest: angular.identity,
            headers: {
                "Content-Type": void 0,
                Accept: "application/json; charset=utf-8",
                "X-CSRF-TOKEN": $("meta[name=_csrf]").attr("content")
            }
        }).success(function (a) {
            Fukyo.utils.LogUtils.isDebug() &&
            (Fukyo.utils.LogUtils.trace("[ACTION   END  ] : " + j + " [" + (new Date - k) + "ms]"), Fukyo.utils.LogUtils.trace("[ACTION   OUTPUT] : " + angular.toJson(a)));
            angular.isDefined(a) && null != a && "NG" == a.returnCd && c.pop("error", a.returnMsg, null, "trustedHtml");
            if (Fukyo.utils.LogUtils.isDebug()) {
                var b = new Date;
                Fukyo.utils.LogUtils.trace("[CALLBACK START] : " + j)
            }
            (d || angular.noop)(a);
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK END  ] : " + j + " [" + (new Date - b) + "ms]")
        }).error(function (a) {
            Fukyo.utils.LogUtils.isDebug() &&
            (Fukyo.utils.LogUtils.trace("[ACTION   END  ] : " + j + " [" + (new Date - k) + "ms]"), Fukyo.utils.LogUtils.trace("[ACTION   OUTPUT] : " + angular.toJson(a)));
            if (Fukyo.utils.LogUtils.isDebug()) {
                var b = new Date;
                Fukyo.utils.LogUtils.trace("[CALLBACK START] : " + j)
            }
            (i || angular.noop)(a);
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK END  ] : " + j + " [" + (new Date - b) + "ms]");
            c.pop("error", Messages.getMessage("F0000001"), null, "trustedHtml")
        })
    }
}]);
dmsCommon.directive("chosenSelect", function () {
    return {
        restrict: "A",
        link: function (a, d, c) {
            var e = c.chosenWidth,
                b = c.chosenSelect,
                f = c.ngDisabled,
                h = c.chosenDeselect;
            a.$on("chosen#updateList", function () {
                a.$watch(c.list, function () {
                    $(d).trigger("liszt:updated");
                    $(d).trigger("chosen:updated")
                })
            });
            angular.isDefined(c.list) && null !== c.list && a.$watch(c.list, function () {
                $(d).trigger("liszt:updated");
                $(d).trigger("chosen:updated")
            });
            angular.isDefined(b) && null !== b && a.$watch(b, function () {
                $(d).trigger("liszt:updated");
                $(d).trigger("chosen:updated")
            });
            a.$watch(c.ngModel, function () {
                $(d).trigger("chosen:updated")
            });
            angular.isDefined(f) && null !== f && a.$watch(f, function (a) {
                $(d).prop("disabled", a);
                $(d).trigger("liszt:updated");
                $(d).trigger("chosen:updated")
            });
            a.$watch(c.ngModel, function () {
                $(d).trigger("chosen:updated")
            });
            e = null == e || "" == e || void 0 === e ? "auto" : e;
            $(d).chosen({
                width: e,
                allow_single_deselect: !0,
                disable_search_threshold: 5
            });
            $(d).data("chosen").allow_single_deselect = null == h || "" === h || "true" === h || !0 == h ? !0 : "false" ===
            h || !1 == h ? !1 : !0
        }
    }
});
dmsCommon.directive("ngFileSelect", function () {
    return {
        link: function (a, d) {
            d.bind("change", function (c) {
                for (var i = 0; i < c.target.files.length; i++) {
                    a.file = (c.srcElement || c.target).files[i];
                    a.getFile(a.file)
                }

            })
        }
    }
});
dmsCommon.directive("currencyInput", function (a, d) {
    return {
        require: "ngModel",
        link: function (c, e, b, f) {
            var h = function () {
                var b = e.val().replace(/,/g, "");
                e.val(a("number")(b, !1))
            };
            f.$parsers.push(function (a) {
                return a.replace(/,/g, "")
            });
            f.$render = function () {
                e.val(a("number")(f.$viewValue, !1))
            };
            e.bind("change", h);
            e.bind("keydown", function (a) {
                a = a.keyCode;
                91 == a || 15 < a && 19 > a || 37 <= a && 40 >= a || d.defer(h)
            });
            e.bind("paste cut", function () {
                d.defer(h)
            })
        }
    }
});
dmsCommon.directive("datepicker", ["$document", function (a) {
    return {
        restrict: "E",
        templateUrl: getContextPath() + "/common/datepicker",
        scope: {
            dateId: "@",
            dateType: "=",
            dateValue: "=",
            dateMinValue: "=",
            dateMaxValue: "=",
            dateValidation: "="
        },
        link: function (d, c) {
            d.datepickerTrigger = 0 !== angular.element(c).prev(".datepickerTrigger").length ? angular.element(c).prev(".datepickerTrigger") : void 0;
            "button" === d.dateType && (angular.element(c).hide(), angular.element(d.datepickerTrigger).on("click", function () {
                angular.element(this).hide();
                angular.element(c).show().find(".dmsDatepicker > input").focus()
            }), a.on("click", function (a) {
                var b = $(a.target).closest(d.datepickerTrigger).length,
                    f = $(a.target).closest(c).length,
                    h = $(a.target).closest(".ui-datepicker-group").length;
                if (a.isPropagationStopped()) return !1;
                a.stopPropagation();
                if (null === f || void 0 === f) return !1;
                !b && !f && !h && (angular.element(c).hide(), angular.element(d.datepickerTrigger).show())
            }))
        },
        controller: "dmsDatepcikerController"
    }
}]).controller("dmsDatepcikerController", ["$scope", "$element",
    "$attrs", "$filter",
    function (a, d, c, e) {
        a.id = a.dateId;
        a.name = c.name;
        a.today = e("date")(new Date, "dd-MM-yyyy");
        a.initDatePicker = function () {
            $("#" + a.id).datepicker({
                dateFormat: "dd-mm-yy",
                numberOfMonths: 1,
                showCurrentAtPos: 0,
                onSelect: function (b) {
                    "button" === a.dateType && (a.$apply(function () {
                        a.dateValue = b
                    }), angular.element(this).closest("datepicker").hide(), angular.element(this).closest("datepicker").prev().show());
                    a.$apply(function () {
                        a.updateDatepicker()
                    })
                }
            })
        };
        a.formatCheck = function () {
            var b = $("#" + a.dateId),
                f = a.dateValue,
                c = e("date")(new Date(b.val()), "dd-MM-yyyy"),
                d = e("date")(new Date(f), "dd-MM-yyyy");
            if (b.val() !== f && c === d) a.dateValue = b.val()
        };
        a.updateDatepicker = function () {
            ("" === a.dateMinValue || null === a.dateMinValue || void 0 === a.dateMinValue || "" === a.dateMaxValue || null === a.dateMaxValue || void 0 === a.dateMaxVaule) && $("#" + a.id).datepicker("option", "defaultDate", null);
            a.changeMonthDisplay(a.dateMaxValue, "maxDate", 2);
            a.changeMonthDisplay(a.dateMinValue, "minDate", 0);
            null !== a.dateValue && void 0 !== a.dateValue &&
            "" !== $("#" + a.id).val() && $("#" + a.id).datepicker("option", "showCurrentAtPos", 0);
            a.dateValue = $("#" + a.dateId).val()
        };
        a.changeMonthDisplay = function (b, f, c) {
            var d = void 0,
                i = b;
            if (null !== b && void 0 !== b)
                if (10 === b.length) {
                    if (null == b || angular.isUndefined(b)) b = a.today;
                    d = e("date")(b, "dd-MM-yyyy");
                    b = {
                        showCurrentAtPos: c,
                        defaultDate: d
                    };
                    b[f] = i;
                    $("#" + a.id).datepicker("option", b)
                } else $("#" + a.id).datepicker("option", f, null), $("#" + a.id).datepicker("option", "showCurrentAtPos", 0)
        };
        a.moveDay = function (b) {
            var f = "";
            if (null ==
                a.dateValue || "" === a.dateValue) a.dateValue = a.today;
            f = new Date(a.dateValue.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            formatCheck = e("date")(f, "dd-MM-yyyy");
            if (angular.isDate(f) && "Invalid Date" !== f.toString() && angular.isNumber(b)) a.dateValue = e("date")(f.setDate(f.getDate() + b), "dd-MM-yyyy"), a.changeDayRange(a.dateValue)
        };
        a.getToday = function () {
            a.dateValue = a.today;
            a.changeDayRange(a.dateValue)
        };
        a.changeDayRange = function (b) {
            if (null != a.dateMinValue && void 0 !== a.dateMinValue && a.dateMinValue > b) a.dateMinValue =
                b;
            if (null != a.dateMaxValue && void 0 !== a.dateMaxValue && a.dateMaxValue < b) a.dateMaxValue = b
        };
        a.dateValidationFunc = function () {
            a.invalid = null === a.dateValue || void 0 === a.dateValue || "" === a.dateValue ? !0 : !1
        };
        angular.isArray(a.dateValidation) && a.dateValidation.push(a.dateValidationFunc)
    }
]);
dmsCommon.directive("fileModel", ["$parse", function (a) {
    return {
        restrict: "A",
        link: function (d, c, e) {
            var b = a(e.fileModel).assign;
            c.bind("change", function () {
                d.$apply(function () {
                    b(d, c[0].files[0])
                })
            })
        }
    }
}]);
(function (a) {
    a.factory("fileReader", ["$q", "$log", function (a) {
        var c = function (a, b, c) {
                return function () {
                    c.$apply(function () {
                        b.resolve(a.result)
                    })
                }
            },
            e = function (a, b, c) {
                return function () {
                    c.$apply(function () {
                        b.reject(a.result)
                    })
                }
            },
            b = function (a, b) {
                return function (a) {
                    b.$broadcast("fileProgress", {
                        total: a.total,
                        loaded: a.loaded
                    })
                }
            };
        return {
            readAsDataUrl: function (f, h) {
                var g = a.defer(),
                    i = new FileReader;
                i.onload = c(i, g, h);
                i.onerror = e(i, g, h);
                i.onprogress = b(i, h);
                i.readAsDataURL(f);
                return g.promise
            }
        }
    }])
})(angular.module("dmsCommon"));
dmsCommon.directive("numeric", function () {
    return function (a, d) {
        $(d[0]).numericInput({
            allowFloat: !0
        })
    }
});
dmsCommon.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});
dmsCommon.service("idleService", ["$timeout", "$window", function (a, d) {
    var c = null;
    this.start = function () {
        //null == c && (c = a(this._logoff, 18E5))
    };
    this.reset = function () {
        this._clear();
        this.start()
    };
    this._logoff = function () {
        d.location.href = getContextPath() + "/admin"
    };
    this._clear = function () {
        null != c && (a.cancel(c), c = null)
    }
}]);
if ("undefined" == typeof Fukyo || !Fukyo) var Fukyo = {};
Fukyo.namespace = function () {
    var a = arguments,
        d = null,
        c, e, b;
    for (c = 0; c < a.length; c += 1) {
        b = ("" + a[c]).split(".");
        d = Fukyo;
        for (e = "Fukyo" == b[0] ? 1 : 0; e < b.length; e += 1) d[b[e]] = d[b[e]] || {}, d = d[b[e]]
    }
    return d
};
Function.prototype.inheritsFrom = function (a) {
    a.constructor == Function ? (this.prototype = new a, this.prototype.constructor = this, this.prototype.parent = a.prototype) : (this.prototype = a, this.prototype.constructor = this, this.prototype.parent = a);
    return this
};
Fukyo.namespace("Fukyo.utils");
Fukyo.utils.LogUtils = {
    isDebug: function () {
        return !1
    },
    trace: function (a) {
        if (this.isDebug() && (console.log("[TRACE] " + Fukyo.utils.DateTimeUtils.getNowString() + ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    },
    debug: function (a) {
        if (this.isDebug() && (console.log("[DEBUG] " + Fukyo.utils.DateTimeUtils.getNowString() + ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    },
    info: function (a) {
        if (this.isDebug() && (console.log("[INFO] " + Fukyo.utils.DateTimeUtils.getNowString() +
            ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    },
    error: function (a) {
        if (this.isDebug() && (console.log("[ERROR] " + Fukyo.utils.DateTimeUtils.getNowString() + ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    }
};
Fukyo.utils.DateTimeUtils = {
    getNowString: function () {
        var a = new Date;
        return a.toLocaleDateString() + " " + a.toLocaleTimeString() + "." + a.getMilliseconds()
    },
    formatTimestamp: function (a) {
        return a.toLocaleDateString() + " " + a.toLocaleTimeString() + "." + a.getMilliseconds()
    }
};
var Messages = {},
    Messages = {
        setMessage: function (a) {
            void 0 == a || null == a || localStorage.setItem("messages", JSON.stringify(a))
        },
        getMessage: function (a, d) {
            var c = localStorage.getItem("messages");
            if (null == c || void 0 == c) return null;
            c = JSON.parse(c)[a];
            if (void 0 == d || null == d) return c;
            for (var e = d.split(","), b = 0; b < e.length; b++) var f = this.getMessage(e[b]),
                c = c.replace(/\{[0-9]+\}/, f ? f : e[b]);
            c = c.toLowerCase();
            return c.charAt(0).toUpperCase() + c.slice(1);
        },
        hasMessage: function () {
            var a = localStorage.getItem("messages");
            return void 0 == a || null == a ? !1 : !0
        },
        clearMessage: function () {
            localStorage.removeItem("messages")
        }
    },
    TextUtil = {},
    TextUtil = {
        isEmpty: function (a) {
            return null == a || "" == a
        },
        toString: function (a) {
            return void 0 == a || null == a || "null" === a ? null : a.constructor === String ? a : a.toString()
        }
    },
    ValidateUtil = {},
    ValidateUtil = {
        _isValidated: function (a, d) {
            return d.test(a)
        },
        _trimEnd: function (a) {
            return TextUtil.isEmpty(a) ? a : a.replace(/\s+$/g, "")
        },
        isValidTextRequired: function (a) {
            var d = this._trimEnd(a);
            return TextUtil.isEmpty(d) ? !1 : a ? this.isValidTextLength(d, 1, Infinity) : a
        },
        isValidTextInvalidChars: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ?
                !0 : !0 == this._isValidated(a, /[]/) ? !1 : !0
        },
        isValidTextLength: function (a, d, c) {
            a = this._trimEnd(a);
            if (TextUtil.isEmpty(a)) return !0;
            void 0 == c && (c = d);
            return d <= a.length && a.length <= c
        },
        isValidTextNumeric: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, /^[\d]*$/)
        },
        isValidTextNumber: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, /^[\d-\u002E]*$/) && isFinite(a)
        },
        isValidTextAlpha: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a,
                /^[A-Za-z]*$/)
        },
        isValidTextAlphaNumeric: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, /^[A-Za-z\d]*$/)
        },
        isValidTextHalf: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, RegExp("^[A-Za-z\\d -/:-@\u00a5[-`{-~]*$"))
        },
        isValidTextDate: function (a) {
            var d = this._trimEnd(a);
            if (TextUtil.isEmpty(d)) return !0;
            return this._isValidated(d, /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/) ? (a = new Date(d.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")), console.log(d),
                d = d.split("-"), a.getFullYear() === +d[2] && a.getMonth() + 1 === +d[1] && a.getDate() === +d[0]) : !1
        },
        isValidTextTelNo: function (a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : !1 == this._isValidated(a, /^[0-9-]*$/) || !0 == this._isValidated(a, /^-.*/) || !0 == this._isValidated(a, /.*-$/) ? !1 : !0
        },
        isValidBytesLength: function (a, d) {
            var c = this._trimEnd(a);
            return TextUtil.isEmpty(c) ? !0 : (new Blob([c], {
                type: "text/plain"
            })).size > d ? !1 : !0
        },
        isValidEmail: function (a) {
            return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(a) ? !0 :
                !1
        }
    };
(function (a) {
    function d(a) {
        if (a.selectionStart) return a.selectionStart;
        if (document.selection) {
            a.focus();
            var b = document.selection.createRange();
            if (null == b) return 0;
            var a = a.createTextRange(),
                f = a.duplicate();
            a.moveToBookmark(b.getBookmark());
            f.setEndPoint("EndToStart", a);
            return f.text.length
        }
        return 0
    }

    var c = {
        allowFloat: !1,
        allowNegative: !1
    };
    a.fn.numericInput = function (e) {
        var e = a.extend({}, c, e),
            b = e.allowFloat,
            f = e.allowNegative;
        this.keypress(function (c) {
            var c = c.which,
                e = a(this).val();
            if (0 < c && (48 > c || 57 < c))
                if (!0 ==
                    b && 46 == c) {
                    if (!0 == f && 0 == d(this) && "-" == e.charAt(0) || e.match(/[.]/)) return !1
                } else if (!0 == f && 45 == c) {
                    if ("-" == e.charAt(0) || 0 != d(this)) return !1
                } else return 8 == c ? !0 : !1;
            else if (0 < c && 48 <= c && 57 >= c && !0 == f && "-" == e.charAt(0) && 0 == d(this)) return !1
        });
        return this
    }
})(jQuery);


angular.module("rpt0100Module", "dmsCommon,rpt0100Module,rpt0101Module,rpt0102Module,rpt0103Module,rpt0104Module".split(",")).controller("RPT0100Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.init = function () {
        a.model = {
            hidden: {
                week: "0",
                month: "1",
                sale: "0",
                store: "1",
                activeRegion: !1,
                defaultAreaName: Messages.getMessage("RPT0100_LABEL_REGION_CHOOSE"),
                areaId: null,
                clientId: null,
                timeType: null,
                reportType: null,
                RPT0100SearchInputModel: {
                    searchInput: {
                        fromDate: "",
                        toDate: "",
                        timeType: "0",
                        clientId: "",
                        areaId: "",
                        reportType: "1",
                        storeCode: "",
                        storeName: "",
                        saleCode: "",
                        saleName: ""
                    },
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: 0,
                        rowNumber: null
                    }
                },
                validated: {
                    isErrored: !1,
                    fromDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    toDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    checkDate: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            RPT0100InitDataModel: null,
            RPT0100SearchDataOutputModel: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({}, function (c) {
            a.model.form.RPT0100InitDataModel = c;
            a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate = a.model.form.RPT0100InitDataModel.initData.fromDate;
            a.model.hidden.RPT0100SearchInputModel.searchInput.toDate = a.model.form.RPT0100InitDataModel.initData.toDate
        })
    };
    a.validate = function () {
        a.model.hidden.validated = {
            isErrored: !1,
            fromDate: {
                isErrored: !1,
                msg: ""
            },
            toDate: {
                isErrored: !1,
                msg: ""
            },
            checkDate: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000004",
            "RPT0100_LABEL_START_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000011", "RPT0100_LABEL_START_DATE");
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg =
            Messages.getMessage("E0000004", "RPT0100_LABEL_END_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000011", "RPT0100_LABEL_END_DATE");
        var c = new Date(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")),
            e = new Date(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate.replace(/(\d{2})-(\d{2})-(\d{4})/,
                "$2/$1/$3"));
        if (0 < c.getTime() - e.getTime()) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.checkDate.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.checkDate.msg = Messages.getMessage("E0000012")
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage +=
            1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseArea = function (c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.initData = function (a, e) {
        d.doPost("/RPT0100/initData", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.searchData = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = null,
                c = "1" == TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType) ? {
                    searchInput: {
                        fromDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate),
                        toDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate),
                        timeType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.timeType),
                        clientId: TextUtil.toString(a.model.hidden.clientId),
                        areaId: TextUtil.toString(a.model.hidden.areaId),
                        reportType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType),
                        storeCode: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.storeCode),
                        storeName: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.storeName),
                        salesmanCode: null,
                        salesmanName: null
                    },
                    pagingInfo: {
                        ttlRow: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                        crtPage: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                        rowNumber: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                    }
                } : {
                    searchInput: {
                        fromDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate),
                        toDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate),
                        timeType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.timeType),
                        clientId: TextUtil.toString(a.model.hidden.clientId),
                        areaId: TextUtil.toString(a.model.hidden.areaId),
                        reportType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType),
                        storeCode: null,
                        storeName: null,
                        salesmanCode: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.saleCode),
                        salesmanName: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.saleName)
                    },
                    pagingInfo: {
                        ttlRow: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                        crtPage: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                        rowNumber: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                    }
                };
            d.doPost("/RPT0100/searchData", c, function (c) {
                a.model.form.RPT0100SearchDataOutputModel = c;
                a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0100SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.timeType = a.model.hidden.RPT0100SearchInputModel.searchInput.timeType;
                a.model.hidden.reportType = a.model.hidden.RPT0100SearchInputModel.searchInput.reportType
            })
        }
    };
    a.searchDataOnly = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = null,
                c = "1" == TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType) ? {
                    searchInput: {
                        fromDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate),
                        toDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate),
                        timeType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.timeType),
                        clientId: TextUtil.toString(a.model.hidden.clientId),
                        areaId: TextUtil.toString(a.model.hidden.areaId),
                        reportType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType),
                        storeCode: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.storeCode),
                        storeName: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.storeName),
                        salesmanCode: null,
                        salesmanName: null
                    },
                    pagingInfo: {
                        ttlRow: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                        crtPage: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                        rowNumber: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                    }
                } : {
                    searchInput: {
                        fromDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate),
                        toDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate),
                        timeType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.timeType),
                        clientId: TextUtil.toString(a.model.hidden.clientId),
                        areaId: TextUtil.toString(a.model.hidden.areaId),
                        reportType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType),
                        storeCode: null,
                        storeName: null,
                        salesmanCode: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.saleCode),
                        salesmanName: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.saleName)
                    },
                    pagingInfo: {
                        ttlRow: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                        crtPage: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                        rowNumber: null != a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                    }
                };
            d.doPost("/RPT0100/searchData", c, function (c) {
                a.model.form.RPT0100SearchDataOutputModel =
                    c;
                a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0100SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.timeType = a.model.hidden.RPT0100SearchInputModel.searchInput.timeType;
                a.model.hidden.reportType = a.model.hidden.RPT0100SearchInputModel.searchInput.reportType
            })
        }
    };
    a.download = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = {
                fromDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate),
                toDate: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.toDate),
                timeType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.timeType),
                clientId: TextUtil.toString(a.model.hidden.clientId),
                areaId: TextUtil.toString(a.model.hidden.areaId),
                reportType: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.reportType),
                storeCode: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.storeCode),
                storeName: TextUtil.toString(a.model.hidden.RPT0100SearchInputModel.searchInput.storeName)
            };
            d.downloadFile("/RPT0100/printData", c, function () {
            })
        }
    }
}]);
angular.module("rpt0101Module", ["dmsCommon", "rpt0101Module"]).controller("RPT0101Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0101InitDataModel: null
    };
    a.init = function () {
        a.initData()
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0101/initData", {}, function (c) {
            a.model.form.RPT0101InitDataModel = c;
            a.model.form.RPT0101InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0101InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0101InitDataModel.timeType = "0";
            a.model.form.RPT0101InitDataModel.reportType = "0"
        })
    };
    a.searchData =
        function () {
            d.doPost("/RPT0101/searchData", {
                    searchInput: {
                        fromDate: a.model.form.RPT0101InitDataModel.fromDate,
                        toDate: a.model.form.RPT0101InitDataModel.toDate,
                        timeType: a.model.form.RPT0101InitDataModel.timeType,
                        clientId: a.model.form.RPT0101InitDataModel.clientId,
                        reportType: a.model.form.RPT0101InitDataModel.reportType,
                        storeCode: a.model.form.RPT0101InitDataModel.storeCode,
                        storeName: a.model.form.RPT0101InitDataModel.storeName,
                        salesmanStore: a.model.form.RPT0101InitDataModel.salesmanStore,
                        salesmanName: a.model.form.RPT0101InitDataModel.salesmanName
                    }
                },
                function () {
                })
        };
    a.download = function () {
        d.downloadFile("/RPT0101/printData", {}, function () {
        })
    }
}]);
angular.module("rpt0102Module", ["dmsCommon", "rpt0102Module"]).controller("RPT0102Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0102InitDataModel: null
    };
    a.init = function () {
        a.initData()
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0102/initData", {}, function (c) {
            a.model.form.RPT0102InitDataModel = c;
            a.model.form.RPT0102InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0102InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0102InitDataModel.timeType = "0";
            a.model.form.RPT0102InitDataModel.reportType = "0"
        })
    };
    a.searchData =
        function () {
            d.doPost("/RPT0102/searchData", {
                    searchInput: {
                        fromDate: a.model.form.RPT0102InitDataModel.fromDate,
                        toDate: a.model.form.RPT0102InitDataModel.toDate,
                        timeType: a.model.form.RPT0102InitDataModel.timeType,
                        clientId: a.model.form.RPT0102InitDataModel.clientId,
                        reportType: a.model.form.RPT0102InitDataModel.reportType,
                        storeCode: a.model.form.RPT0102InitDataModel.storeCode,
                        storeName: a.model.form.RPT0102InitDataModel.storeName,
                        salesmanStore: a.model.form.RPT0102InitDataModel.salesmanStore,
                        salesmanName: a.model.form.RPT0102InitDataModel.salesmanName
                    }
                },
                function () {
                })
        };
    a.download = function () {
        d.downloadFile("/RPT0102/printData", {}, function () {
        })
    }
}]);
angular.module("rpt0103Module", ["dmsCommon", "rpt0103Module"]).controller("RPT0103Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0103InitDataModel: null
    };
    a.init = function () {
        a.initData()
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0103/initData", {}, function (c) {
            a.model.form.RPT0103InitDataModel = c;
            a.model.form.RPT0103InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0103InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0103InitDataModel.timeType = "0";
            a.model.form.RPT0103InitDataModel.reportType = "0"
        })
    };
    a.searchData =
        function () {
            d.doPost("/RPT0103/searchData", {
                    searchInput: {
                        fromDate: a.model.form.RPT0103InitDataModel.fromDate,
                        toDate: a.model.form.RPT0103InitDataModel.toDate,
                        timeType: a.model.form.RPT0103InitDataModel.timeType,
                        clientId: a.model.form.RPT0103InitDataModel.clientId,
                        reportType: a.model.form.RPT0103InitDataModel.reportType,
                        storeCode: a.model.form.RPT0103InitDataModel.storeCode,
                        storeName: a.model.form.RPT0103InitDataModel.storeName,
                        salesmanStore: a.model.form.RPT0103InitDataModel.salesmanStore,
                        salesmanName: a.model.form.RPT0103InitDataModel.salesmanName
                    }
                },
                function (a) {
                })
        };
    a.download = function () {
        d.downloadFile("/RPT0103/printData", {}, function (a) {
        })
    }
}]);
angular.module("rpt0104Module", ["dmsCommon", "rpt0104Module"]).controller("RPT0104Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0104InitDataModel: null
    };
    a.init = function () {
        a.initData()
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0104/initData", {}, function (c) {
            a.model.form.RPT0104InitDataModel = c;
            a.model.form.RPT0104InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0104InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0104InitDataModel.timeType = "0";
            a.model.form.RPT0104InitDataModel.reportType = "0";
        })
    };
    a.searchData = function () {
        d.doPost("/RPT0104/searchData", {
                searchInput: {
                    fromDate: a.model.form.RPT0104InitDataModel.fromDate,
                    toDate: a.model.form.RPT0104InitDataModel.toDate,
                    timeType: a.model.form.RPT0104InitDataModel.timeType,
                    clientId: a.model.form.RPT0104InitDataModel.clientId,
                    reportType: a.model.form.RPT0104InitDataModel.reportType,
                    storeCode: a.model.form.RPT0104InitDataModel.storeCode,
                    storeName: a.model.form.RPT0104InitDataModel.storeName,
                    salesmanStore: a.model.form.RPT0104InitDataModel.salesmanStore,
                    salesmanName: a.model.form.RPT0104InitDataModel.salesmanName
                }
            },
            function (a) {
            })
    };
    a.download = function () {
        d.downloadFile("/RPT0104/printData", {}, function (a) {
        })
    }
}]);
angular.module("rpt0200Module", ["dmsCommon"]).controller("RPT0200Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.createPrintTime = function () {
        var c = new Date;
        c.getDate();
        var e = c.getMonth() + 1;
        a.model.hidden.disabledPrev = !1;
        a.model.hidden.disabledNext = !0;
        c = c.getFullYear();
        10 > e && (e = "0" + e);
        a.model.hidden.currentMonth = e;
        a.model.hidden.monthSaleCurrent = e;
        a.model.hidden.yearSaleCurrent = c;
        e = {
            value: c
        };
        a.model.hidden.currentYear = c;
        a.model.hidden.lastYear = c - 1;
        c = {
            value: c - 1
        };
        a.model.hidden.yearList.push(e);
        a.model.hidden.yearList.push(c);
        for (e = 1; 12 >= e; e++) a.model.hidden.monthList.push({
            value: e
        })
    };
    $("body").click(function () {
        a.model.hidden.showPrintTime = !1;
        a.$apply()
    });
    a.preventClose = function () {
        event.stopPropagation()
    };
    a.init = function () {
        a.model = {
            hidden: {
                defaultClientId: null,
                salesmanCode: null,
                salesmanName: null,
                showPrintTime: !1,
                no_img: getContextPathImageDefault() + "/img/no_img.png",
                RPT0200SearchInputModel: {
                    searchInput: {
                        defaultClientId: null,
                        salesmanCode: "",
                        salesmanName: ""
                    },
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: 0,
                        rowNumber: null
                    }
                },
                currentSalesmanItem: null,
                yearChoose: null,
                monthChoose: null,
                yearList: [],
                monthList: [],
                yearMonth: null,
                lastYear: null,
                currentYear: null,
                currentMonth: null,
                disabledPrev: !1,
                disabledNext: !1,
                monthSaleCurrent: null,
                yearSaleCurrent: null
            }
        };
        a.model.form = {
            RPT0200InitDataModel: null,
            RPT0200SearchDataOutputModel: null,
            RPT0200SearchSalesmanTimesheetResult: null,
            listSelectSalesman: [],
            chooseAll: !1
        };
        a.model.hidden.defaultClientId = angular.element("#clientId").val();
        a.createPrintTime();
        a.initData()
    };
    a.showPrintTime =
        function () {
            event.stopPropagation();
            a.model.hidden.showPrintTime = !0
        };
    a.prevMonth = function () {
        var c = angular.copy(parseInt(a.model.hidden.monthSaleCurrent)),
            e = angular.copy(parseInt(a.model.hidden.yearSaleCurrent)),
            c = c - 1;
        0 == c && (c = 12, e -= 1);
        a.model.hidden.lastYear > e ? a.model.hidden.disabledPrev = !0 : (a.model.hidden.disabledPrev = !1, a.model.hidden.disabledNext = !1, 10 > c && (c = "0" + c), a.model.hidden.monthSaleCurrent = c, a.model.hidden.yearSaleCurrent = e, a.searchSalesmanTimesheet())
    };
    a.nextMonth = function () {
        var c = angular.copy(parseInt(a.model.hidden.monthSaleCurrent)),
            e = angular.copy(parseInt(a.model.hidden.yearSaleCurrent)),
            c = c + 1;
        12 < c && (c = 1, e += 1);
        e > a.model.hidden.currentYear || e == a.model.hidden.currentYear && c > a.model.hidden.currentMonth ? a.model.hidden.disabledNext = !0 : (a.model.hidden.disabledNext = !1, a.model.hidden.disabledPrev = !1, 10 > c && (c = "0" + c), a.model.hidden.monthSaleCurrent = c, a.model.hidden.yearSaleCurrent = e, a.searchSalesmanTimesheet())
    };
    a.chooseSale = function (c) {
        !1 == c.choose && a.removeSaleItem(c);
        !0 == c.choose && a.addSaleItem(c)
    };
    a.removeSaleItem = function (c) {
        for (var e =
            0; e < a.model.form.listSelectSalesman.length; e++)
            if (a.model.form.listSelectSalesman[e] == c.salesmanId) {
                a.model.form.listSelectSalesman.splice(e, 1);
                break
            }
        a.checkChooseAll()
    };
    a.addSaleItem = function (c) {
        a.model.form.listSelectSalesman.push(c.salesmanId);
        a.checkChooseAll()
    };
    a.chooseAll = function () {
        if (null != a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult)
            if (!1 == a.model.form.chooseAll)
                for (var c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++) {
                    var e = a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c];
                    e.choose = !1;
                    for (var b = 0; b < a.model.form.listSelectSalesman.length; b++) a.model.form.listSelectSalesman[b] == e.salesmanId && a.model.form.listSelectSalesman.splice(b, 1)
                } else
                for (c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++) e = a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c], e.choose = !0, a.model.form.listSelectSalesman.push(e.salesmanId)
    };
    a.checkChooseAll = function () {
        if (0 < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length) {
            a.model.form.chooseAll = !0;
            for (var c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++)
                if (!1 == a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function () {
        // if (null != a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult) {
        //     for (var c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++) {
        //         var e = a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c];
        //         e.choose = !1;
        //         for (var b = 0; b < a.model.form.listSelectSalesman.length; b++)
        //             if (a.model.form.listSelectSalesman[b] == e.salesmanId) e.choose = !0
        //     }
        //     a.checkChooseAll()
        // }
        a.model.form.listSelectSalesman = [];
        a.model.form.chooseAll = 1;
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseSalesmanItem = function (c) {
        a.model.hidden.currentSalesmanItem = c;
        c = getContextPath() + a.model.hidden.currentSalesmanItem.imagePath;
        a.model.hidden.currentSalesmanItem.urlImg = c;
        a.searchSalesmanTimesheet()
    };
    a.searchSalesmanTimesheet = function () {
        a.searchSalesmanTimesheetData({
            searchInput: {
                clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
                salesmanIdList: [a.model.hidden.currentSalesmanItem.salesmanId],
                yearMonth: a.model.hidden.yearSaleCurrent + "-" + a.model.hidden.monthSaleCurrent
            }
        }, function (c) {
            a.model.form.RPT0200SearchSalesmanTimesheetResult = c
        })
    };
    a.initData = function () {
        d.doPost("/RPT0200/initData", {}, function (c) {
            a.model.form.RPT0200InitDataModel = c
        })
    };
    a.searchData = function () {
        d.doPost("/RPT0200/searchData", {
            searchInput: {
                clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
                salesmanCode: a.model.hidden.RPT0200SearchInputModel.searchInput.salesmanCode,
                salesmanName: a.model.hidden.RPT0200SearchInputModel.searchInput.salesmanName
            },
            pagingInfo: {
                ttlRow: null != a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (c) {
            a.model.form.RPT0200SearchDataOutputModel = c;
            a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0200SearchDataOutputModel.searchResult.pagingInfo;
            a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult = a.model.form.RPT0200SearchDataOutputModel.searchResult.salesmanSearchResult;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataOnly = function () {
        d.doPost("/RPT0200/searchData", {
            searchInput: {
                clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
                salesmanCode: a.model.hidden.RPT0200SearchInputModel.searchInput.salesmanCode,
                salesmanName: a.model.hidden.RPT0200SearchInputModel.searchInput.salesmanName
            },
            pagingInfo: {
                ttlRow: null != a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (c) {
            a.model.form.RPT0200SearchDataOutputModel =
                c;
            a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0200SearchDataOutputModel.searchResult.pagingInfo;
            a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult = a.model.form.RPT0200SearchDataOutputModel.searchResult.salesmanSearchResult;
            a.checkChooseAllAfterSearch();
            a.model.hidden.currentSalesmanItem = null
        })
    };
    a.print = function () {
        a.printData({
            clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
            salesmanIdList: [a.model.hidden.currentSalesmanItem.salesmanId],
            yearMonth: a.model.hidden.yearSaleCurrent + "-" + a.model.hidden.monthSaleCurrent
        }, function () {
        })
    };
    a.printAll = function () {
        if (null != a.model.hidden.yearChoose && null != a.model.hidden.monthChoose) {
            var c = angular.copy(a.model.hidden.monthChoose);
            10 > c && (c = "0" + c);
            a.model.hidden.yearMonth = a.model.hidden.yearChoose + "-" + c
        }
        a.printData({
            clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
            salesmanIdList: a.model.form.listSelectSalesman,
            yearMonth: a.model.hidden.yearMonth
        }, function () {
        })
    };
    a.printData =
        function (a, e) {
            d.downloadFile("/RPT0200/printData", a, function (a) {
                (e || angular.noop)(a)
            })
        };
    a.searchSalesmanTimesheetData = function (a, e) {
        d.doPost("/RPT0200/searchSalesmanTimesheet", a, function (a) {
            (e || angular.noop)(a)
        })
    }
}]);
angular.module("rpt0300Module", ["dmsCommon"]).controller("RPT0300Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hidden: {
            reportTypeChoose: 1
        }
    };
    a.model.form = {
        reportType: [{
            name: "B\u00e1o c\u00e1o b\u00e1n h\u00e0ng",
            value: 1
        }, {
            name: "B\u00e1o c\u00e1o gi\u1edd l\u00e0m vi\u1ec7c",
            value: 2
        }, {
            name: "Th\u1ed1ng k\u00ea kh\u00e1ch h\u00e0ng",
            value: 3
        }],
        saleReport: [{
            saleCode: "SAL1412000001",
            saleName: "Nguy\u1ec5n V\u0103n A",
            date: "2014-10-10",
            clientAgeOver30: "25",
            clientAgeBelow30: "20",
            clientAgeTotal: "45",
            clientContact: [{
                name: "CA",
                quantity: "5"
            }, {
                name: "Mild7",
                quantity: ""
            }, {
                name: "Marl",
                quantity: "4"
            }, {
                name: "Vina",
                quantity: "3"
            }, {
                name: "T.Long",
                quantity: ""
            }, {
                name: "T.Long",
                quantity: ""
            }, {
                name: "Jet,Hero",
                quantity: ""
            }, {
                name: "Other",
                quantity: "1"
            }, {
                name: "Total",
                quantity: "13"
            }],
            clientBuy: [{
                name: "555-V\u00e0ng",
                quantity: "5"
            }, {
                name: "555-tr\u1eafng",
                quantity: ""
            }, {
                name: "555-xanh",
                quantity: "4"
            }, {
                name: "Vina",
                quantity: "3"
            }, {
                name: "Ken-HD",
                quantity: ""
            }, {
                name: "Ken-KC",
                quantity: ""
            }, {
                name: "CAFK-CADS",
                quantity: ""
            }, {
                name: "CAFK-CA 20s",
                quantity: "1"
            }, {
                name: "Total",
                quantity: "12"
            }],
            quantitySale: [{
                name: "555-V\u00e0ng",
                quantity: "5"
            }, {
                name: "555-tr\u1eafng",
                quantity: ""
            }, {
                name: "555-xanh",
                quantity: "4"
            }, {
                name: "Vina",
                quantity: "3"
            }, {
                name: "Ken-HD",
                quantity: ""
            }, {
                name: "Ken-KC",
                quantity: ""
            }, {
                name: "CAFK-CADS",
                quantity: ""
            }, {
                name: "CAFK-CA 20s",
                quantity: "1"
            }, {
                name: "Total",
                quantity: "12"
            }],
            present: [{
                name: "Massage voucher",
                quantity: "12"
            }, {
                name: "lighter",
                quantity: "12"
            }, {
                name: "Zippo",
                quantity: "12"
            }]
        }],
        saleLogMonth: [{
            saleCode: "SAL1412000001",
            saleName: "Nguy\u1ec5n V\u0103n A",
            phone: "0123456789",
            startDate: "2014/09/11",
            checkSaleLogIn: {
                month: "2014-10",
                listDate: []
            }
        }],
        saleStatistic: [{
            supName: "Ho\u00e0ng V\u0103n A ",
            saleCode: "SAL14120000001",
            saleName: "Nguy\u1ec5n V\u0103n A",
            clientName: "Phan V\u0103n Nam",
            phone: "0123456789",
            productUse: [{
                name: "555",
                quantity: 3
            }, {
                name: "CA",
                quantity: 3
            }, {
                name: "Mild7",
                quantity: 3
            }, {
                name: "Vina",
                quantity: 3
            }, {
                name: "T.Long",
                quantity: 3
            }, {
                name: "Jet,Hero",
                quantity: 3
            }, {
                name: "T\u1ed5ng",
                quantity: 23
            }],
            quantityBuy: [{
                name: "555-V\u00e0ng",
                quantity: 3
            }, {
                name: "555-Tr\u1eafng",
                quantity: 3
            }, {
                name: "555-B\u1ea1c",
                quantity: 3
            }, {
                name: "Ken-HD",
                quantity: 3
            }, {
                name: "Ken-KC",
                quantity: 3
            }, {
                name: "CAFK-CADS",
                quantity: 3
            }, {
                name: "T\u1ed5ng",
                quantity: 23
            }]
        }]
    };
    a.init = function () {
        a.initData()
    };
    a.changeReportType = function (c) {
        2 == c && a.createSaleLogMonth()
    };
    a.createSaleLogMonth = function () {
        for (var c = new Date(a.model.form.saleLogMonth[0].checkSaleLogIn.month), e = c.getFullYear(), c = c.getMonth() + 1, e = (new Date(e, c, 0)).getDate(), c = 1; c <= e; c++) a.model.form.saleLogMonth[0].checkSaleLogIn.listDate.push({
            day: c,
            value: 5
        });
        a.model.form.saleLogMonth[0].checkSaleLogIn.listDate.push({
            day: "T\u1ed5ng",
            value: 191
        })
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0300/initData", {}, function (c) {
            a.model.form.RPT0300InitDataModel = c;
            a.model.form.RPT0300InitDataModel.fromDate = c.initData.fromDate;
            a.model.form.RPT0300InitDataModel.toDate = c.initData.toDate;
            a.model.form.RPT0300InitDataModel.reportType = c.initData.reportType
        })
    };
    a.searchData = function () {
        d.doPost("/RPT0300/searchData", {
            searchInput: {
                fromDate: a.model.form.RPT0300InitDataModel.fromDate,
                toDate: a.model.form.RPT0300InitDataModel.toDate,
                clientId: a.model.form.RPT0300InitDataModel.clientId,
                reportType: a.model.form.RPT0300InitDataModel.reportType
            },
            pagingInfo: {
                ttlRow: null != a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function () {
        })
    };
    a.download = function () {
        d.downloadFile("/RPT0300/printData", {
            fromDate: a.model.form.RPT0300InitDataModel.fromDate,
            toDate: a.model.form.RPT0300InitDataModel.toDate,
            clientId: a.model.form.RPT0300InitDataModel.clientId,
            reportType: 1
        }, function () {
        })
    }
}]);
angular.module("rpt0400Module", ["dmsCommon", "rpt0400Module", "rpt0401Module"]).controller("RPT0400Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d) {
    a.init = function () {
        a.model = {
            hidden: {
                activeRegion: !1,
                defaultAreaName: Messages.getMessage("RPT0400_LABEL_REGION_CHOOSE"),
                areaId: null,
                clientId: null,
                timeType: null,
                reportType: null,
                RPT0400SearchInputModel: {
                    searchInput: {
                        fromDate: "",
                        toDate: "",
                        clientId: null,
                        areaId: null,
                        rival: null,
                        productType: null
                    },
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: 0,
                        rowNumber: null
                    }
                },
                validated: {
                    isErrored: !1,
                    fromDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    toDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    clientId: {
                        isErrored: !1,
                        msg: ""
                    },
                    checkDate: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            RPT0400InitDataModel: null,
            RPT0400SearchDataOutputModel: null,
            RPT0400DownloadDataOutputModel: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({
            clientId: a.model.hidden.clientId
        }, function (c) {
            a.model.form.RPT0400InitDataModel = c;
            a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate = a.model.form.RPT0400InitDataModel.initData.fromDate;
            a.model.hidden.RPT0400SearchInputModel.searchInput.toDate = a.model.form.RPT0400InitDataModel.initData.toDate;
            if (null != a.model.form.RPT0400InitDataModel.initData.clientItem) a.model.hidden.RPT0400SearchInputModel.searchInput.clientId = a.model.form.RPT0400InitDataModel.initData.clientItem[0].itemId
        })
    };
    a.validate = function () {
        a.model.hidden.validated = {
            isErrored: !1,
            fromDate: {
                isErrored: !1,
                msg: ""
            },
            toDate: {
                isErrored: !1,
                msg: ""
            },
            clientId: {
                isErrored: !1,
                msg: ""
            },
            checkDate: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000004", "RPT0400_LABEL_START_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000011", "RPT0400_LABEL_START_DATE");
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.RPT0400SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000004", "RPT0400_LABEL_END_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.RPT0400SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000011", "RPT0400_LABEL_END_DATE");
        var c = new Date(a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate.replace(/(\d{2})-(\d{2})-(\d{4})/,
                "$2/$1/$3")),
            e = new Date(a.model.hidden.RPT0400SearchInputModel.searchInput.toDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
        if (0 < c.getTime() - e.getTime()) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.checkDate.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.checkDate.msg = Messages.getMessage("E0000012");
        if (null == a.model.hidden.clientId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.clientId.isErrored = !0, a.model.hidden.validated.clientId.msg = Messages.getMessage("E0000004", "RPT0400_LABEL_CLIENT")
    };
    a.chooseArea = function (c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseClient = function () {
        var c = TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.clientId);
        null != c && d.doPost("/RPT0400/clientChange", c, function (c) {
            a.model.form.RPT0400InitDataModel.initData.rivalItem = c.initData.rivalItem;
            a.model.form.RPT0400InitDataModel.initData.productTypeItem = c.initData.productTypeItem
        })
    };
    a.initData = function (a, e) {
        d.doPost("/RPT0400/initData", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.searchData = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            var c = {
                searchInput: {
                    fromDate: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate),
                    toDate: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.toDate),
                    clientId: a.model.hidden.clientId,
                    areaId: TextUtil.toString(a.model.hidden.areaId),
                    rival: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.rival),
                    productType: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.productType)
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            };
            d.doPost("/RPT0400/searchData", c, function (c) {
                a.model.form.RPT0400SearchDataOutputModel = c;
                a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo = c.searchResult.pagingInfo
            })
        }
    };
    a.searchDataOnly = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            var c = {
                searchInput: {
                    fromDate: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate),
                    toDate: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.toDate),
                    clientId: a.model.hidden.clientId,
                    areaId: TextUtil.toString(a.model.hidden.areaId),
                    rival: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.rival),
                    productType: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.productType)
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: 1,
                    rowNumber: null != a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            };
            d.doPost("/RPT0400/searchData",
                c,
                function (c) {
                    a.model.form.RPT0400SearchDataOutputModel = c;
                    if (null != a.model.form.RPT0400SearchDataOutputModel.searchResult) a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0400SearchDataOutputModel.searchResult.pagingInfo
                })
        }
    };
    a.download = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = {
                fromDate: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate),
                toDate: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.toDate),
                clientId: a.model.hidden.clientId,
                areaId: TextUtil.toString(a.model.hidden.areaId),
                rival: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.rival),
                productType: TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.productType)
            };
            d.downloadFile("/RPT0400/printData", c, function () {
            })
        }
    }
}]);
angular.module("rpt0401Module", ["dmsCommon", "rpt0401Module"]).controller("RPT0401Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0101InitDataModel: null
    };
    a.init = function () {
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0401/initData", {}, function (c) {
            a.model.form.RPT0101InitDataModel = c;
            a.model.form.RPT0101InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0101InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0101InitDataModel.timeType = "0";
            a.model.form.RPT0101InitDataModel.reportType = "0";
        })
    };
    a.searchData = function () {
        d.doPost("/RPT0101/searchData", {
                searchInput: {
                    fromDate: a.model.form.RPT0101InitDataModel.fromDate,
                    toDate: a.model.form.RPT0101InitDataModel.toDate,
                    timeType: a.model.form.RPT0101InitDataModel.timeType,
                    clientId: a.model.form.RPT0101InitDataModel.clientId,
                    reportType: a.model.form.RPT0101InitDataModel.reportType,
                    storeCode: a.model.form.RPT0101InitDataModel.storeCode,
                    storeName: a.model.form.RPT0101InitDataModel.storeName,
                    salesmanStore: a.model.form.RPT0101InitDataModel.salesmanStore,
                    salesmanName: a.model.form.RPT0101InitDataModel.salesmanName
                }
            },
            function (a) {
            })
    };
    a.download = function () {
        d.downloadFile("/RPT0401/printData", {}, function (a) {
        })
    }
}]);
angular.module("rpt0500Module", ["dmsCommon"]).controller("RPT0500Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.init = function () {
        a.model = {
            hidden: {
                week: "0",
                month: "1",
                activeRegion: !1,
                defaultAreaName: Messages.getMessage("RPT0500_LABEL_REGION_CHOOSE"),
                areaId: null,
                clientId: null,
                timeType: null,
                currentTimeType: null,
                RPT0500SearchInputModel: {
                    searchInput: {
                        fromDate: "",
                        toDate: "",
                        timeType: 0,
                        clientId: "",
                        areaId: "",
                        storeCode: "",
                        storeName: ""
                    },
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: 0,
                        rowNumber: null
                    }
                },
                validated: {
                    isErrored: !1,
                    fromDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    toDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    checkDate: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            RPT0500InitDataModel: null,
            RPT0500SearchDataOutputModel: null,
            tableWeekResult: null,
            tableMonthResult: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({}, function (c) {
            a.model.form.RPT0500InitDataModel = c;
            a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate = a.model.form.RPT0500InitDataModel.initData.fromDate;
            a.model.hidden.RPT0500SearchInputModel.searchInput.toDate =
                a.model.form.RPT0500InitDataModel.initData.toDate
        })
    };
    a.validate = function () {
        a.model.hidden.validated = {
            isErrored: !1,
            fromDate: {
                isErrored: !1,
                msg: ""
            },
            toDate: {
                isErrored: !1,
                msg: ""
            },
            checkDate: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000004", "RPT0500_LABEL_START_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000011", "RPT0500_LABEL_START_DATE");
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.RPT0500SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000004", "RPT0500_LABEL_END_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.RPT0500SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000011", "RPT0500_LABEL_END_DATE");
        var c = new Date(a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")),
            e = new Date(a.model.hidden.RPT0500SearchInputModel.searchInput.toDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
        if (0 < c.getTime() - e.getTime()) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.checkDate.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.checkDate.msg = Messages.getMessage("E0000012")
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseArea = function (c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.initData = function (a, e) {
        d.doPost("/RPT0500/initData", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.searchData = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = {
                searchInput: {
                    fromDate: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate),
                    toDate: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.toDate),
                    timeType: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType),
                    clientId: TextUtil.toString(a.model.hidden.clientId),
                    areaId: TextUtil.toString(a.model.hidden.areaId),
                    storeCode: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.storeCode),
                    storeName: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.storeName)
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo ?
                        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            };
            d.doPost("/RPT0500/searchData", c, function (c) {
                a.model.form.RPT0500SearchDataOutputModel = c;
                a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo =
                    a.model.form.RPT0500SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.currentTimeType = angular.copy(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType);
                a.model.hidden.timeType = a.model.hidden.RPT0500SearchInputModel.searchInput.timeType;
                a.model.hidden.reportType = a.model.hidden.RPT0500SearchInputModel.searchInput.reportType
            })
        }
    };
    a.searchDataOnly = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = {
                searchInput: {
                    fromDate: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate),
                    toDate: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.toDate),
                    timeType: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType),
                    clientId: TextUtil.toString(a.model.hidden.clientId),
                    areaId: TextUtil.toString(a.model.hidden.areaId),
                    storeCode: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.storeCode),
                    storeName: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.storeName)
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo ?
                        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: 1,
                    rowNumber: null != a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo ? a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            };
            d.doPost("/RPT0500/searchData", c, function (c) {
                a.model.form.RPT0500SearchDataOutputModel = c;
                a.model.hidden.currentTimeType = angular.copy(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType);
                a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0500SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.timeType = a.model.hidden.RPT0500SearchInputModel.searchInput.timeType
            })
        }
    };
    a.download = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            if (!1 == a.model.hidden.activeRegion) a.model.hidden.areaId = null;
            var c = {
                fromDate: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate),
                toDate: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.toDate),
                timeType: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType),
                clientId: TextUtil.toString(a.model.hidden.clientId),
                areaId: TextUtil.toString(a.model.hidden.areaId),
                storeCode: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.storeCode),
                storeName: TextUtil.toString(a.model.hidden.RPT0500SearchInputModel.searchInput.storeName)
            };
            d.downloadFile("/RPT0500/printData", c, function () {
            })
        }
    }
}]);
angular.module("set0100Module", ["dmsCommon", "set0110Module", "set0120Module", "set0130Module"]).controller("SET0100Ctrl", ["$scope", "serverService", "$rootScope", function (a) {
    a.init = function () {
        a.model = {
            hidden: {
                activeTab: 3
            }
        }
    }
}]);
angular.module("set0110Module", ["dmsCommon"]).controller("SET0110Ctrl", ["$scope", "serverService", "$rootScope", function (a, d, c) {
    a.init = function () {
        a.model = {
            hidden: {
                selectedRegion: 0,
                regionName: ""
            }
        };
        a.model.form = {
            regionAdd: "",
            regionList: [{
                name: "root",
                code: 0,
                listChild: []
            }]
        }
    };
    a.addRegion = function () {
        if (0 == a.model.hidden.selectedRegion) a.model.form.regionList.push({
            name: a.model.hidden.regionName,
            code: a.model.form.regionList.length,
            listChild: []
        });
        else
            for (var e = 0; e < a.model.form.regionList.length; e++) {
                var b =
                    a.model.form.regionList[e];
                b.code == a.model.hidden.selectedRegion && b.listChild.push({
                    name: a.model.hidden.regionName,
                    code: b.listChild.length
                })
            }
        c.$broadcast("chosen#updateList")
    }
}]);
angular.module("set0120Module", ["dmsCommon"]).controller("SET0120Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hiden: {
            week: "0",
            month: "1",
            sale: "0",
            store: "1"
        }
    };
    a.model.form = {
        RPT0100InitDataModel: null
    };
    a.init = function () {
        a.initData()
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/RPT0100/initData", {}, function (c) {
            a.model.form.RPT0100InitDataModel = c;
            a.model.form.RPT0100InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0100InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0100InitDataModel.timeType =
                "0";
            a.model.form.RPT0100InitDataModel.reportType = "0"
        })
    };
    a.searchData = function () {
        d.doPost("/RPT0100/searchData", {
            searchInput: {
                fromDate: a.model.form.RPT0100InitDataModel.fromDate,
                toDate: a.model.form.RPT0100InitDataModel.toDate,
                timeType: a.model.form.RPT0100InitDataModel.timeType,
                clientId: a.model.form.RPT0100InitDataModel.clientId,
                reportType: a.model.form.RPT0100InitDataModel.reportType,
                storeCode: a.model.form.RPT0100InitDataModel.storeCode,
                storeName: a.model.form.RPT0100InitDataModel.storeName,
                salesmanStore: a.model.form.RPT0100InitDataModel.salesmanStore,
                salesmanName: a.model.form.RPT0100InitDataModel.salesmanName
            }
        }, function () {
        })
    };
    a.download = function () {
        d.downloadFile("/RPT0100/printData", {}, function () {
        })
    }
}]);
angular.module("set0130Module", ["dmsCommon", "toaster"]).controller("SET0130Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
        a.model = {
            hidden: {
                activeTab: 3,
                clientId: null,
                SET0100SearchInputModel: {
                    searchInput: {
                        clientId: "",
                        fromDate: "",
                        toDate: ""
                    },
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: 0,
                        rowNumber: null
                    }
                },
                SET0100CreateInputModel: {
                    clientId: null,
                    title: "",
                    message: ""
                },
                validated: {
                    isErrored: !1,
                    fromDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    toDate: {
                        isErrored: !1,
                        msg: ""
                    },
                    checkDate: {
                        isErrored: !1,
                        msg: ""
                    }
                },
                validatedSend: {
                    isErrored: !1,
                    clientId: {
                        isErrored: !1,
                        msg: ""
                    },
                    title: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            SET0100InitDataModel: null,
            SET0100CreateDataOutputModel: null,
            SET0100SearchDataOutputModel: null
        };
        a.initData({}, function (b) {
            a.model.form.SET0100InitDataModel = b;
            a.model.hidden.SET0100SearchInputModel.searchInput.clientId = a.model.form.SET0100InitDataModel.initData.clientId;
            a.model.hidden.SET0100SearchInputModel.searchInput.fromDate = a.model.form.SET0100InitDataModel.initData.fromDate;
            a.model.hidden.SET0100SearchInputModel.searchInput.toDate =
                a.model.form.SET0100InitDataModel.initData.toDate
        })
    };
    a.validateSend = function () {
        a.model.hidden.validatedSend = {
            isErrored: !1,
            clientId: {
                isErrored: !1,
                msg: ""
            },
            title: {
                isErrored: !1,
                msg: ""
            }
        };
        if (null == TextUtil.toString(a.model.hidden.SET0100CreateInputModel.clientId)) a.model.hidden.validatedSend.isErrored = !0, a.model.hidden.validatedSend.clientId.isErrored = !0, a.model.hidden.validatedSend.clientId.msg = Messages.getMessage("E0000004", "SET0130_LABEL_CLIENT");
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.SET0100CreateInputModel.title)) a.model.hidden.validatedSend.isErrored = !0, a.model.hidden.validatedSend.title.isErrored = !0, a.model.hidden.validatedSend.title.msg = Messages.getMessage("E0000004", "SET0130_LABEL_TITLE")
    };
    a.validate = function () {
        a.model.hidden.validated = {
            isErrored: !1,
            clientId: {
                isErrored: !1,
                msg: ""
            },
            fromDate: {
                isErrored: !1,
                msg: ""
            },
            toDate: {
                isErrored: !1,
                msg: ""
            },
            checkDate: {
                isErrored: !1,
                msg: ""
            }
        };
        if (null == TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.clientId)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.clientId.isErrored = !0,
            a.model.hidden.validated.clientId.msg = Messages.getMessage("E0000004", "SET0130_LABEL_CLIENT");
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.SET0100SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000004", "SET0130_LABEL_FROM_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.SET0100SearchInputModel.searchInput.fromDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.fromDate.msg = Messages.getMessage("E0000011", "SET0130_LABEL_FROM_DATE");
        if (!ValidateUtil.isValidTextRequired(a.model.hidden.SET0100SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000004", "SET0130_LABEL_TO_DATE");
        if (!ValidateUtil.isValidTextDate(a.model.hidden.SET0100SearchInputModel.searchInput.toDate)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.toDate.msg = Messages.getMessage("E0000011", "SET0130_LABEL_TO_DATE");
        var b = new Date(a.model.hidden.SET0100SearchInputModel.searchInput.fromDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")),
            c = new Date(a.model.hidden.SET0100SearchInputModel.searchInput.toDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
        if (0 < b.getTime() - c.getTime()) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.fromDate.isErrored = !0, a.model.hidden.validated.checkDate.isErrored = !0, a.model.hidden.validated.toDate.isErrored = !0, a.model.hidden.validated.checkDate.msg = Messages.getMessage("E0000012")
    };
    a.sendMessage = function () {
        a.validateSend();
        !0 != a.model.hidden.validatedSend.isErrored && a.sendMessageData()
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function (a, c) {
        d.doPost("/SET0100/initData", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    a.sendMessageData = function () {
        var b = {
            clientId: TextUtil.toString(a.model.hidden.SET0100CreateInputModel.clientId),
            title: TextUtil.toString(a.model.hidden.SET0100CreateInputModel.title),
            message: TextUtil.toString(a.model.hidden.SET0100CreateInputModel.message)
        };
        d.doPost("/SET0100/sendMessage", b, function (b) {
            a.model.form.SET0100CreateDataOutputModel = b;
            if (null != a.model.form.SET0100CreateDataOutputModel) "OK" == a.model.form.SET0100CreateDataOutputModel.createResult.resultFlg ? (a.model.hidden.SET0100CreateInputModel.clientId = null, a.model.hidden.SET0100CreateInputModel.title = null, a.model.hidden.SET0100CreateInputModel.message = null, e.pop("success", a.model.form.SET0100CreateDataOutputModel.createResult.message, null, "trustedHtml")) : e.pop("error", a.model.form.SET0100CreateDataOutputModel.createResult.message,
                null, "trustedHtml")
        })
    };
    a.searchData = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            var b = {
                searchInput: {
                    fromDate: TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.fromDate),
                    toDate: TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.toDate),
                    clientId: TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.clientId)
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.SET0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.SET0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.SET0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            };
            d.doPost("/SET0100/searchData", b, function (b) {
                a.model.form.SET0100SearchDataOutputModel = b;
                a.model.form.SET0100InitDataModel.resultSearch.pagingInfo = a.model.form.SET0100SearchDataOutputModel.searchResult.pagingInfo
            })
        }
    };
    a.searchDataOnly = function () {
        a.validate();
        if (!0 != a.model.hidden.validated.isErrored) {
            var b = {
                searchInput: {
                    fromDate: TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.fromDate),
                    toDate: TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.toDate),
                    clientId: TextUtil.toString(a.model.hidden.SET0100SearchInputModel.searchInput.clientId)
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.SET0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: 1,
                    rowNumber: null != a.model.form.SET0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            };
            d.doPost("/SET0100/searchData", b, function (b) {
                a.model.form.SET0100SearchDataOutputModel = b;
                if (null != a.model.form.SET0100SearchDataOutputModel) "NG" == a.model.form.SET0100SearchDataOutputModel.returnCd ? e.pop("error", a.model.form.SET0100SearchDataOutputModel.returnMsg, null, "trustedHtml") : a.model.form.SET0100InitDataModel.resultSearch.pagingInfo =
                    a.model.form.SET0100SearchDataOutputModel.searchResult.pagingInfo
            })
        }
    }
}]);
