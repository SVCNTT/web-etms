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
/* MonthlyReport start */
var mrpt0200Module = angular.module("mrpt0200Module", ["dmsCommon", "toaster"]).controller("MRPT0200Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.chgMonthReport = function(a, f) {
        d.doPost("/MRPT0200/chgMonRpt", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                currentMonth:new Date()
            }
        };
        a.model.form = {
            MRPT0200ChangeMonthlyReportInputModel: {
                currentYear : null,
                currentMonth: null
            },
            MRPT0200ResultModal: null
        }
        a.initData()
    };
    a.initData = function() {
      today = new Date();
      a.model.hidden.currentMonth = today;
      a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentMonth = (today.getMonth() + 1);
      a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentYear = today.getFullYear();
      $("#input1").val((new Date, "MM-yyyy"));
      $("#result-add-times").css("display","inline-block");
    };
    a.loadDataWhenChangeMonth = function(b){
    	a.model.hidden.currentMonth = b;
      a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentMonth = (b.getMonth() + 1);
      a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentYear = b.getFullYear();
    }
    a.closeMonthlyReport = function() {
        c.$broadcast("MRPT0200#closeMonthlyReportModal", {})
    };
    a.exportMonthlyReport = function() {

        (param = {
            monthReport: a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentMonth,
            yearReport: a.model.form.MRPT0200ChangeMonthlyReportInputModel.currentYear
        }, a.chgMonthReport(param, function(b) {
            a.model.form.MRPT0200ResultModal = b.proResult;
            if("NG" != a.model.form.MRPT0200ResultModal.proFlg){
                var pathFile =  a.model.form.MRPT0200ResultModal.pathFile;
                window.location.href = pathFile;
            }
            "NG" == a.model.form.MRPT0200ResultModal.proFlg ? e.pop("error", a.model.form.MRPT0200ResultModal.message,
                null, "trustedHtml") : (e.pop("success", a.model.form.MRPT0200ResultModal.message, null, "trustedHtml"), c.$broadcast("MRPT0200#closeMonthlyReportModal", {}))
        }))
    }
}]);

/* MonthlyReport end */

angular.module("aut0200Module", ["dmsCommon", "toaster"]).controller("AUT0200Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.chgPassData = function(a, f) {
        d.doPost("/AUT0200/chgPass", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function() {
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
    a.closeChangePassword = function() {
        c.$broadcast("AUT0200#closeChangePasswordModal", {})
    };
    a.validate = function() {
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
    a.updatePassword = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            oldPassword: a.model.form.AUT0200ChangePasswordInputModel.oldPassword,
            newPassword: a.model.form.AUT0200ChangePasswordInputModel.newPassword,
            reNewPassword: a.model.form.AUT0200ChangePasswordInputModel.confirmPassword
        }, a.chgPassData(param, function(b) {
            a.model.form.AUT0200ResultModal = b.proResult;
            "NG" == a.model.form.AUT0200ResultModal.proFlg ? e.pop("error", a.model.form.AUT0200ResultModal.message,
                null, "trustedHtml") : (e.pop("success", a.model.form.AUT0200ResultModal.message, null, "trustedHtml"), c.$broadcast("AUT0200#closeChangePasswordModal", {}))
        }))
    }
}]);
angular.module("cli0100Module", ["dmsCommon", "ngLoadingSpinner"]).controller("CLI0100Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hidden: {}
    };
    a.model.form = {
        CLI0100InitDataModel: null,
        CLI0100SearchDataInputModel: null,
        nameSearch: null
    };
    a.init = function() {
        a.initData()
    };
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.CLI0100InitDataModel.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.CLI0100InitDataModel.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage =
        function() {
            a.model.form.CLI0100InitDataModel.pagingInfo.crtPage = 1;
            a.searchData()
        };
    a.endPage = function() {
        a.model.form.CLI0100InitDataModel.pagingInfo.crtPage = a.model.form.CLI0100InitDataModel.pagingInfo.ttlPages;
        a.searchData()
    };
    a.getImage = function() {
        if (null != a.model.form.CLI0100InitDataModel.cliInfo.clientList)
            for (var c = a.model.form.CLI0100InitDataModel.cliInfo.clientList.length, e = 0; e < c; e++) {
                var b = a.model.form.CLI0100InitDataModel.cliInfo.clientList[e],
                    f = getContextPath() + b.logoPath;
                b.imageUrl = f
            }
    };
    a.initData =
        function() {
            d.doPost("/CLI0100/initData/", {}, function(c) {
                a.model.form.CLI0100InitDataModel = c;
                a.getImage()
            })
        };
    a.searchData = function() {
        d.doPost("/CLI0100/searchData/", {
            searchInput: {
                clientName: a.model.form.nameSearch
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0100InitDataModel.pagingInfo ? a.model.form.CLI0100InitDataModel.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CLI0100InitDataModel.pagingInfo ? a.model.form.CLI0100InitDataModel.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.CLI0100InitDataModel.pagingInfo ?
                    a.model.form.CLI0100InitDataModel.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.CLI0100SearchDataInputModel = c;
            a.model.form.CLI0100InitDataModel.cliInfo.clientList = a.model.form.CLI0100SearchDataInputModel.clientInfo.clientList;
            a.model.form.CLI0100InitDataModel.pagingInfo = a.model.form.CLI0100SearchDataInputModel.pagingInfo;
            a.getImage()
        })
    };
    a.searchDataOnly = function() {
        d.doPost("/CLI0100/searchData/", {
            searchInput: {
                clientName: a.model.form.nameSearch
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0100InitDataModel.pagingInfo ?
                    a.model.form.CLI0100InitDataModel.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.CLI0100InitDataModel.pagingInfo ? a.model.form.CLI0100InitDataModel.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.CLI0100SearchDataInputModel = c;
            a.model.form.CLI0100InitDataModel.cliInfo.clientList = a.model.form.CLI0100SearchDataInputModel.clientInfo.clientList;
            a.model.form.CLI0100InitDataModel.pagingInfo = a.model.form.CLI0100SearchDataInputModel.pagingInfo;
            a.getImage()
        })
    }
}]);
angular.module("cli0200Module", ["dmsCommon", "fcsa-number"]).controller("CLI0200Ctrl", ["$scope", "serverService", "fileReader", function(a, d, c) {
    a.chooseFile = function() {
        /*event.stopPropagation();*/
        angular.element("#ChooseFile").click()
    };
    a.getFile = function() {
        c.readAsDataUrl(a.file, a).then(function(c) {
            a.model.form.urlImage = c
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                no_img: getContextPathImageDefault() + "/img/no_img.png"
            }
        };
        a.model.form = {
            CLI0200InitOutputModel: null,
            ratePoint: null,
            urlImage: null,
            clientType: null
        };
        param = {};
        a.initData(param, function(c) {
            a.model.form.CLI0200InitOutputModel = c;
            if (angular.isDefined(c.clientType) && 0 < c.clientType.length) a.model.form.clientType = c.clientType[0].codeCd
        })
    };
    a.initData = function(a, b) {
        d.doPost("/CLI0200/initData", a, function(a) {
            (b || angular.noop)(a)
        })
    }
}]);
angular.module("cli0300Module", "dmsCommon,fcsa-number,Slidebox,pro1100Module,pro1120Module,pro1130Module,cli0310Module,cli0330Module,cli0340Module,cli0350Module,cli0360Module,cli0361Module,cli0362Module,cli0370Module,cli0371Module,cli0372Module,cli0380Module,cli0390Module,cli0400Module,rpt0100Module,rpt0300Module,rpt0400Module,rpt0500Module".split(",")).controller("CLI0300Ctrl", ["$scope", "$rootScope", "serverService", "$timeout", function(a, d, c, e) {
    a.showPopupDetail = function(b) {
        a.model.hidden.activeRow = b;
        a.model.hidden.showPopupDetail = !0
    };
    a.importProduct = function() {
        a.model.hidden.showImportRivalProduct = !0;
        e(function() {
            d.$broadcast("PR01130#importProduct")
        })
    };
    a.showCreatePro = function() {
        a.model.hidden.showCreatePro = !0;
        d.$broadcast("PR01120#init", {
            showCreatePro: a.model.hidden.showCreatePro
        })
    };
    a.showModalEditCus = function() {
        a.model.hidden.showEditCus = !0
    };
    a.init = function() {
        a.model = {
            hidden: {
                sortCode: !1,
                sortName: !1,
                showPopupDetail: !1,
                showModalCSV: !1,
                showCreatePro: !1,
                showEditCus: !1,
                showModalEditPro: !1,
                no_img: getContextPathImageDefault() + "/img/no_img.png",
                showEditPro: !1,
                imageUrl: null,
                ratePoint: null,
                currentProductChoose: null,
                clientCode: null,
                showEditCus: !1,
                showCLI0310: !1,
                showImportRivalProduct: !1,
                activeTab: 6,
                showUpdateProductType: !1,
                showUpdateProductGroup: !1,
                showUpdateRiVal: !1,
                showAddProductRival: !1
            }
        };
        a.model.form = {
            PRO1120ModelAddProduct: {
                productModel: null,
                productName: null,
                price: null
            },
            PRO1120AddProductResult: null,
            PRO1120UpdateProductResult: null,
            PRO1100SearchDataModel: null,
            PRO1100ParamSearch: {
                searchInput: {
                    productModel: "",
                    productName: ""
                },
                pagingInfo: {
                    ttlRow: null,
                    crtPage: null,
                    rowNumber: null
                }
            },
            viewCustomer: null,
            selectedRegion: 0
        };
        a.model.hidden.imageUrl = getContextPath() + angular.element("#imageClient").val();
        a.model.hidden.ratePoint = angular.element("#ratePointClient").val();
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        a.$on("CLI0310#closeEditClientModal", function() {
            a.model.hidden.showCLI0310 = !1
        });
        a.$on("CLI0300#closeModalPRO1120", function() {
            a.model.hidden.showCreatePro = !1
        });
        a.$on("CLI0300#openImportRivalProduct", function(b, f) {
            a.model.hidden.showImportRivalProduct = !0;
            e(function() {
                d.$broadcast("PR01130#initFromRivalProduct", {
                    rivalId: f.rivalId
                })
            })
        });
        a.$on("CLI0300#closeImportProduct", function() {
            a.model.hidden.showImportRivalProduct = !1
        });
        a.$on("CLI0300#openEditProductModal", function(b, f) {
            a.model.hidden.showCreatePro = !0;
            e(function() {
                d.$broadcast("PR01120#edit", {
                    productInfo: f.productInfo
                })
            })
        });
        a.$on("CLI0300#openUpdateProductTypeModal", function(b, f) {
            a.model.hidden.showUpdateProductType = !0;
            e(function() {
                d.$broadcast("CLI0361#edit", {
                    itemProductType: f.itemProductType,
                    showUpdateProductType: !0
                })
            })
        });
        a.$on("CLI0300#closeUpdateProductTypeModal",
            function() {
                a.model.hidden.showUpdateProductType = !1
            });
        a.$on("CLI0300#openUpdateProductGroupModal", function(b, f) {
            a.model.hidden.showUpdateProductGroup = !0;
            e(function() {
                d.$broadcast("CLI0362#edit", {
                    itemProductGroup: f.itemProductGroup,
                    showUpdateProductGroup: !0
                })
            })
        });
        a.$on("CLI0300#closeUpdateProductGroupModal",
            function() {
                a.model.hidden.showUpdateProductGroup = !1
            });
        a.$on("CLI0300#openRivalModal", function(b, f) {
            a.model.hidden.showUpdateRiVal = !0;
            e(function() {
                d.$broadcast("CLI0371#edit", {
                    itemRival: angular.copy(f.itemRival),
                    showModalEditRival: !0
                })
            })
        });
        a.$on("CLI0300#closeRivalModal", function() {
            a.model.hidden.showUpdateRiVal = !1
        });
        a.$on("CLI0300#openRivalProductModal", function(b, f) {
            a.model.hidden.showAddProductRival = !0;
            e(function() {
                d.$broadcast("CLI0372#createRivalProduct", {
                    rivalId: f.rivalId
                })
            })
        });
        a.$on("CLI0300#closeRivalProductModal",
            function() {
                a.model.hidden.showAddProductRival = !1
            });
        a.$on("CLI0300#updateRivalProductModal", function(b, f) {
            a.model.hidden.showAddProductRival = !0;
            e(function() {
                d.$broadcast("CLI0372#showModalEditPro", {
                    productItem: f.productItem
                })
            })
        })
    };
    a.openEditClientModal = function() {
        a.model.hidden.showCLI0310 = !0;
        d.$broadcast("CLI0310#showEditClientModal")
    };
    a.sortCode = function() {
        a.model.hidden.sortCode = !1 == a.model.hidden.sortCode ? !0 : !1
    };
    a.sortName = function() {
        a.model.hidden.sortName = !1 == a.model.hidden.sortName ? !0 : !1
    }
}]);
var cli0310Module = angular.module("cli0310Module", ["dmsCommon"]).controller("CLI0310Ctrl", ["$scope", "serverService", "$rootScope", "toaster", "fileReader", function(a, d, c, e, b) {
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                clientCode: null,
                no_img: getContextPathImageDefault() + "/img/no_img.png"
            }
        };
        a.model.form = {
            ratePoint: null,
            urlImage: null,
            file: null,
            CLI0310InitOutputModel: null
        };
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        param = {
            clientCode: a.model.hidden.clientCode
        };
        a.initData(param, function(b) {
            a.model.form.CLI0310InitOutputModel =
                b;
            a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath = getContextPath() + a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath
        })
    };
    a.chooseFile = function() {
        // event.stopPropagation();
        angular.element("#cli0310ChooseFile").click()
    };
    a.getFile = function(f) {
        a.model.form.file = f;
        b.readAsDataUrl(f, a).then(function(b) {
            a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath = b
        })
    };
    a.closeEditClientModal = function() {
        window.location.href = getContextPath() + "/CLI0300/" + a.model.hidden.clientCode;
        c.$broadcast("CLI0310#closeEditClientModal")
    };
    a.updateClient = function() {
        param = {
            clientCode: a.model.hidden.clientCode,
            clientName: a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.clientName,
            clientType: a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.clientType,
            ratePoint: a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.ratePoint
        };
        a.updateClientData(param)
    };
    a.initData = function(a, b) {
        d.doPost("/CLI0310/initData", a, function(a) {
            (b || angular.noop)(a)
        })
    };
    a.updateClientData = function(b) {
        d.uploadFile("/CLI0310",
            a.model.form.file, b,
            function(b) {
                if (angular.isDefined(b.proResult) && null != b.proResult && "OK" == b.proResult.proFlg) window.location.href = getContextPath() + "/CLI0300/" + a.model.hidden.clientCode, e.pop("success", b.proResult.message, null, "trustedHtml");
                a.model.form.CLI0310UpdateClientResult = b.proResult
            })
    }
}]);
var cli0330Module = angular.module("cli0330Module", ["dmsCommon", "toaster"]).controller("CLI0330Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                }
            }
        };
        a.model.form = {
            chooseAll: !1,
            CLI0330InitOutputModel: null,
            CLI0330ResultSearchModel: null,
            CLI0330SearchData: {
                searchInput: {
                    clientId: null,
                    userId: null,
                    salesmanCode: "",
                    salesmanName: "",
                    mobile: ""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 0,
                    rowNumber: 0
                }
            },
            CLI0330ResultSearchNotAssignModel: {
                resultSearch: {
                    searchInput: {
                        clientId: 0,
                        salesmanCode: "",
                        salesmanName: "",
                        mobile: ""
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: null,
                        rowNumber: 0
                    }
                }
            },
            CLI0330SearchDataSalmanNotAssign: {
                searchInput: {
                    clientId: 0,
                    salesmanCode: "",
                    salesmanName: "",
                    mobile: ""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 0,
                    rowNumber: 0
                }
            },
            defaultUserId: null,
            CLI0330CreateResultDto: null,
            CLI0330DeleteResultDto: null,
            listManager: [],
            listSelectSalesman: []
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({
                clientId: a.model.hidden.clientId
            },
            function(b) {
                a.model.form.CLI0330InitOutputModel = b;
                if (0 < a.model.form.CLI0330InitOutputModel.initData.userManager.length && null != a.model.form.CLI0330InitOutputModel.initData.userManager) {
                    length = a.model.form.CLI0330InitOutputModel.initData.userManager.length;
                    for (b = 0; b < length; b++) {
                        var f = a.model.form.CLI0330InitOutputModel.initData.userManager[b];
                        if (null == f.lastName) f.lastName = "";
                        if (null == f.firstName) f.firstName = "";
                        a.model.form.listManager.push({
                            fullname: f.lastName +
                                " " + f.firstName,
                            userId: f.userId
                        })
                    }
                    a.model.form.listManagerToAdd = angular.copy(a.model.form.listManager);
                    for (b = 0; b < a.model.form.listManagerToAdd.length; b++) null == a.model.form.listManagerToAdd[b].userId && a.model.form.listManagerToAdd.splice(b, 1);
                    a.searchSale()
                }
            })
    };
    a.searchSale = function() {
        a.searchDataSaleOnly()
    };
    a.prevPageSale = function() {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchDataSale()
    };
    a.nextPageSale = function() {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataSale()
    };
    a.startPageSale = function() {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataSale()
    };
    a.endPageSale = function() {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataSale()
    };
    a.searchSaleNotAssign = function() {
        a.searchDataSaleNotAssignOnly()
    };
    a.prevPageSaleNotAssign =
        function() {
            a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage -= 1;
            a.searchDataSaleNotAssign()
        };
    a.nextPageSaleNotAssign = function() {
        a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataSaleNotAssign()
    };
    a.startPageSaleNotAssign = function() {
        a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataSaleNotAssign()
    };
    a.endPageSaleNotAssign = function() {
        a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage =
            a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataSaleNotAssign()
    };
    a.regisUserSalesman = function() {
        a.regisUserSalesmanData({
            clientId: a.model.hidden.clientId,
            userManagerId: a.model.form.CLI0330CreateInputModel.userId,
            selectSalesmanId: a.model.form.listSelectSalesman
        }, function(b) {
            a.model.form.CLI0330CreateResultDto = b.proResult;
            a.model.form.listSelectSalesman = [];
            a.searchDataSaleNotAssign();
            a.searchSale();
            null != a.model.form.CLI0330CreateResultDto && ("NG" == a.model.form.CLI0330CreateResultDto.proFlg ?
                e.pop("error", a.model.form.CLI0330CreateResultDto.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0330CreateResultDto.message, null, "trustedHtml"))
        })
    };
    a.deleteUserSalesman = function(b) {
        a.deleteUserSalesmanData({
            clientId: a.model.hidden.clientId,
            salesmanId: b.salesmanId
        }, function(b) {
            a.model.form.CLI0330DeleteResultDto = b;
            a.searchDataSale()
        })
    };
    a.chooseSale = function(b) {
        !1 == b.choose && a.removeSaleItem(b);
        !0 == b.choose && a.addSaleItem(b)
    };
    a.removeSaleItem = function(b) {
        for (var f = 0; f < a.model.form.listSelectSalesman.length; f++)
            if (a.model.form.listSelectSalesman[f] ==
                b.salesmanId) {
                a.model.form.listSelectSalesman.splice(f, 1);
                break
            }
        a.checkChooseAll()
    };
    a.addSaleItem = function(b) {
        a.model.form.listSelectSalesman.push(b.salesmanId);
        a.checkChooseAll()
    };
    a.chooseAll = function() {
        if (null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++) {
                    var f = a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b];
                    f.choose = !1;
                    for (var c = 0; c < a.model.form.listSelectSalesman.length; c++) a.model.form.listSelectSalesman[c] == f.salesmanId && a.model.form.listSelectSalesman.splice(c, 1)
                } else
                    for (b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++) f = a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b], f.choose = !0, a.model.form.listSelectSalesman.push(f.salesmanId)
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++)
                if (!1 == a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function() {
        // if (null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList) {
        //     for (var b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++) {
        //         var f = a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b];
        //         f.choose = !1;
        //         for (var c = 0; c < a.model.form.listSelectSalesman.length; c++)
        //             if (a.model.form.listSelectSalesman[c] == f.salesmanId) f.choose = !0
        //     }
        //     a.checkChooseAll()
        // }
        a.model.form.listSelectSalesman = [];
        a.model.form.chooseAll = 1;
    };
    a.initData = function(a, f) {
        d.doPost("/CLI0330/initData", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.searchDataSale = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                userId: a.model.form.CLI0330InitOutputModel.initData.defaultUserId,
                salesmanCode: a.model.form.CLI0330SearchData.searchInput.salesmanCode,
                salesmanName: a.model.form.CLI0330SearchData.searchInput.salesmanName,
                mobile: a.model.form.CLI0330SearchData.searchInput.mobile
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0330/searchDataSalman", param, function(b) {
            a.model.form.CLI0330ResultSearchModel = b;
            a.model.form.CLI0330InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0330ResultSearchModel.resultSearch.searchSalList;
            a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0330ResultSearchModel.resultSearch.pagingInfo
        })
    };
    a.searchDataSaleOnly = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                userId: a.model.form.CLI0330InitOutputModel.initData.defaultUserId,
                salesmanCode: a.model.form.CLI0330SearchData.searchInput.salesmanCode,
                salesmanName: a.model.form.CLI0330SearchData.searchInput.salesmanName,
                mobile: a.model.form.CLI0330SearchData.searchInput.mobile
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0330/searchDataSalman", param, function(b) {
            a.model.form.CLI0330ResultSearchModel = b;
            a.model.form.CLI0330InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0330ResultSearchModel.resultSearch.searchSalList;
            a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0330ResultSearchModel.resultSearch.pagingInfo
        })
    };
    a.searchDataSaleNotAssign = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                salesmanCode: a.model.form.CLI0330SearchDataSalmanNotAssign.searchInput.salesmanCode,
                salesmanName: a.model.form.CLI0330SearchDataSalmanNotAssign.searchInput.salesmanName,
                mobile: a.model.form.CLI0330SearchDataSalmanNotAssign.searchInput.mobile
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo ? a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo ? a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo ? a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0330/searchDataSalmanNotAssign", param, function(b) {
            a.model.form.CLI0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataSaleNotAssignOnly = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                salesmanCode: a.model.form.CLI0330SearchDataSalmanNotAssign.searchInput.salesmanCode,
                salesmanName: a.model.form.CLI0330SearchDataSalmanNotAssign.searchInput.salesmanName,
                mobile: a.model.form.CLI0330SearchDataSalmanNotAssign.searchInput.mobile
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo ? a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo ? a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0330/searchDataSalmanNotAssign", param, function(b) {
            a.model.form.CLI0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.regisUserSalesmanData = function(a, f) {
        d.doPost("/CLI0330/regisUserSalesman", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteUserSalesmanData = function(a, f) {
        d.doPost("/CLI0330/deleteUserSalesman", a, function(a) {
            (f || angular.noop)(a)
        })
    }
}]);
var cli0340Module = angular.module("cli0340Module", ["dmsCommon", "toaster"]).controller("CLI0340Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.initData = function(a, f) {
        d.doPost("/CLI0340/initData", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.regisCusmetaData = function(a, f) {
        d.doPost("/CLI0340/regisCusMeta", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.selectCusMetaData = function(a, f) {
        d.doPost("/CLI0340/selectCusMeta", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteCusMetaData = function(a, f) {
        d.doPost("/CLI0340/deleteCusMeta",
            a,
            function(a) {
                (f || angular.noop)(a)
            })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                showViewList: !1,
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                },
                validated: {
                    isErrored: !1,
                    listValAvai: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            CLI0340InitOutputModel: null,
            CLI0340RegisCusMeta: {
                cusmetaName: null,
                clientId: null,
                cusMetaType: null,
                listVal: ""
            },
            CLI0340RegisResult: null,
            listVal: [{
                name: ""
            }],
            CLI0340SelectResult: null,
            CLI0340ViewList: []
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({
                clientId: a.model.hidden.clientId
            },
            function(b) {
                a.model.form.CLI0340InitOutputModel = b;
                a.selectCusMeta()
            })
    };
    a.addItemVal = function() {
        a.model.form.listVal.push({
            name: ""
        })
    };
    a.removeItemVal = function(b) {
        a.model.form.listVal.splice(b, 1)
    };
    a.deleteItemView = function(b) {
        param = {
            cusMetaId: b.cusMetaId
        };
        a.deleteCusMetaData(param, function(b) {
            a.model.form.CLI0340DeleteResult = b.proResult;
            a.selectCusMeta();
            null != a.model.form.CLI0340DeleteResult && ("NG" == a.model.form.CLI0340DeleteResult.proFlg ?
                e.pop("error", a.model.form.CLI0340DeleteResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0340DeleteResult.message, null, "trustedHtml"))
        })
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            listValAvai: {
                isErrored: !1,
                msg: ""
            }
        };
        for (var b = !1, f = 0; f < a.model.form.listVal.length; f++) {
            var c = a.model.form.listVal[f];
            null != c.name && "" != c.name && (b = !0)
        }
        if (!1 == b && 3 != a.model.form.CLI0340RegisCusMeta.cusMetaType) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.listValAvai.isErrored = !0, a.model.hidden.validated.listValAvai.msg = Messages.getMessage("E0000027")
    };
    a.createListVal = function(b) {
        for (var f = "", c = 0; c < b.length; c++) var e = b[c],
            f = c == b.length - 1 ? f + e.name : f + (e.name + "|");
        a.model.form.CLI0340RegisCusMeta.listVal = f
    };
    a.regisCusmeta = function() {
        a.createListVal(a.model.form.listVal);
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            cusmetaName: a.model.form.CLI0340RegisCusMeta.cusmetaName,
            clientId: a.model.hidden.clientId,
            cusMetaType: a.model.form.CLI0340RegisCusMeta.cusMetaType,
            listVal: a.model.form.CLI0340RegisCusMeta.listVal
        }, a.regisCusmetaData(param, function(b) {
            a.model.form.CLI0340RegisResult = b.proResult;
            a.clear();
            a.model.hidden.showViewList = !1;
            a.selectCusMeta();
            null != a.model.form.CLI0340RegisResult && ("NG" == a.model.form.CLI0340RegisResult.proFlg ? e.pop("error", a.model.form.CLI0340RegisResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0340RegisResult.message, null, "trustedHtml"))
        }))
    };
    a.clear = function() {
        a.model.form.CLI0340RegisCusMeta = {
            CLI0340RegisCusMeta: {
                cusmetaName: null,
                clientId: null,
                cusMetaType: null,
                listVal: ""
            }
        };
        a.model.form.listVal = [{
            name: ""
        }];
        a.model.form.CLI0340RegisCusMeta = {
            listVal: [{
                name: ""
            }]
        }
    };
    a.selectCusMeta = function() {
        a.model.form.CLI0340ViewList = [];
        a.selectCusMetaData({
            clientId: a.model.hidden.clientId
        }, function(b) {
            a.model.form.CLI0340SelectResult = b;
            for (b = 0; b < a.model.form.CLI0340SelectResult.selectCusMeta.cusMetaInfo.length; b++) {
                var f = a.model.form.CLI0340SelectResult.selectCusMeta.cusMetaInfo[b],
                    c = [];
                if (null != f.listVal)
                    for (var e = f.listVal.split("|"), d = 0; d < e.length; d++) c.push({
                        name: e[d],
                        valChoose: null
                    });
                e = null;
                for (d = 0; d < a.model.form.CLI0340InitOutputModel.initData.dataType.length; d++) {
                    var k = a.model.form.CLI0340InitOutputModel.initData.dataType[d];
                    if (k.dataTypeCd == f.cusMetaType) e = k.dataTypeName
                }
                a.model.form.CLI0340ViewList.push({
                    cusMetaId: f.cusMetaId,
                    cusmetaName: f.cusMetaName,
                    cusMetaType: f.cusMetaType,
                    cusMetaTypeName: e,
                    listVal: c,
                    valChoose: null
                })
            }
        })
    }
}]);
var cli0350Module = angular.module("cli0350Module", ["dmsCommon"]).controller("CLI0350Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.initData = function(a, e) {
        d.doPost("/CLI0350/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.selectPhotoData = function(a, e) {
        d.doPost("/CLI0350/selectPhoto", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                no_img: getContextPathImageDefault() + "/img/no_img.png"
            }
        };
        a.model.form = {
            CLI0350InitOutputModel: null,
            CLI0350SearchInputModel: {
                clientId: null,
                storeId: null,
                startDate: null,
                endDate: null,
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: null,
                    rowNumber: 0
                }
            }
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({
            clientId: a.model.hidden.clientId
        }, function(c) {
            a.model.form.CLI0350InitOutputModel = c;
            for (c = 0; c < a.model.form.CLI0350InitOutputModel.photoInfo.photoCal.length; c++) {
                var e = a.model.form.CLI0350InitOutputModel.photoInfo.photoCal[c];
                if (null != e.photoStoreInfo)
                    for (var b = 0; b < e.photoStoreInfo.length; b++) {
                        var f =
                            e.photoStoreInfo[b];
                        if (null != f.photoPath)
                            for (var d = 0; d < f.photoPath.length; d++) {
                                var g = f.photoPath[d];
                                g.photoUrl = getContextPath() + g.photoPath
                            }
                    }
            }
        })
    };
    a.prevPage = function() {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage =
            a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function() {
        a.selectPhotoData({
            clientId: a.model.hidden.clientId,
            storeId: a.model.form.CLI0350SearchInputModel.storeId,
            startDate: a.model.form.CLI0350SearchInputModel.startDate,
            endDate: a.model.form.CLI0350SearchInputModel.endDate,
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo ? a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo ?
                    a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo ? a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.CLI0350InitOutputModel.photoInfo.photoCal = c.selectPhoto.photoCal;
            for (var e = 0; e < a.model.form.CLI0350InitOutputModel.photoInfo.photoCal.length; e++) {
                var b = a.model.form.CLI0350InitOutputModel.photoInfo.photoCal[e];
                if (null != b.photoStoreInfo)
                    for (var f = 0; f < b.photoStoreInfo.length; f++) {
                        var d =
                            b.photoStoreInfo[f];
                        if (null != d.photoPath)
                            for (var g = 0; g < d.photoPath.length; g++) {
                                var i = d.photoPath[g];
                                i.photoUrl = getContextPath() + i.photoPath
                            }
                    }
            }
            a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo = c.selectPhoto.pagingInfo
        })
    };
}]);
var cli0360Module = angular.module("cli0360Module", ["dmsCommon", "toaster"]).controller("CLI0360Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.selectProTypeData = function(a, f) {
        d.doPost("/CLI0360/selectProType", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.selectProGroupData = function(a, f) {
        d.doPost("/CLI0360/selectProGroup", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.regisProductTypeData = function(a, f) {
        d.doPost("/CLI0360/regisProductTye", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteProductTypeData = function(a, f) {
        d.doPost("/CLI0360/deleteProductTye", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.regisProductGroupData = function(a, f) {
        d.doPost("/CLI0360/regisProductGroup", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteProductGroupData = function(a, f) {
        d.doPost("/CLI0360/deleteProductGroup", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init =
        function() {
            a.model = {};
            a.model = {
                hidden: {
                    deleteConfirm: {
                        message: Messages.getMessage("C0000001")
                    }
                }
            };
            a.model.form = {
                CLI0360SelProTypeOutputModel: null,
                CLI0360SelProGroupOutputModel: null,
                CLI0360RegisResult: null,
                CLI0360RegisInputModel: {
                    clientId: null,
                    productTypeName: ""
                },
                CLI0360RegisGroupResult: null,
                CLI0360RegisGroupInputModel: {
                    clientId: null,
                    productTypeId:null,
                    productGroupName: ""
                }
            };
            a.$on("CLI0360#selectProductType", function() {
                a.selectProType()
            });
            a.$on("CLI0360#selectProductGroup", function() {
                a.selectProGroup()
            });
            a.model.hidden.clientId = angular.element("#clientId").val();
            a.selectProTypeData({
                clientId: a.model.hidden.clientId
            }, function(b) {
                a.model.form.CLI0360SelProTypeOutputModel = b;
                if(b.proTypeList.productTypeList[0] != undefined) {
                    a.model.hidden.productTypeId = b.proTypeList.productTypeList[0].productTypeId;
                } else {
                    a.model.hidden.productTypeId = '';
                }
                a.selectProGroupData({
                    clientId: a.model.hidden.clientId,
                    productTypeId: a.model.hidden.productTypeId
                }, function(b) {
                    a.model.form.CLI0360SelProGroupOutputModel = b;
                })
            })

        };
    a.getProductGroupList = function(b) {
      a.selectProGroupData({
          clientId: a.model.hidden.clientId,
          productTypeId: b.productTypeId
      }, function(b) {
          a.model.form.CLI0360SelProGroupOutputModel = b;
      })
    };
    a.selectProType = function() {
        a.selectProTypeData({
            clientId: a.model.hidden.clientId
        }, function(b) {
            a.model.form.CLI0360SelProTypeOutputModel = b;
        })
    };
    a.regisProductType = function() {
        a.regisProductTypeData({
            clientId: a.model.hidden.clientId,
            productTypeName: a.model.form.CLI0360RegisInputModel.productTypeName
        }, function(b) {
            a.model.form.CLI0360RegisResult = b.proResult;
            a.model.form.CLI0360RegisInputModel.productTypeName = "";
            a.selectProType();
            "NG" == a.model.form.CLI0360RegisResult.proFlg ?
                e.pop("error", a.model.form.CLI0360RegisResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0360RegisResult.message, null, "trustedHtml")
        })
    };
    a.deleteProductGroup = function(b) {
        a.deleteProductGroupData({
            clientId: a.model.hidden.clientId,
            productGroupId: b.productGroupId
        }, function(b) {
            a.model.form.CLI0360RegisResult = b.proResult;
            "NG" == a.model.form.CLI0360RegisResult.proFlg && e.pop("error", a.model.form.CLI0360RegisResult.message, null, "trustedHtml");
            a.selectProGroup()
        })
    };
    a.editProductType = function(a) {
        c.$broadcast("CLI0300#openUpdateProductTypeModal", {
            itemProductType: angular.copy(a)
        })
    }

    a.selectProGroup = function(){
      a.selectProGroupData({
          clientId: a.model.hidden.clientId,
          productTypeId: a.model.hidden.productTypeId
      }, function(b) {
          a.model.form.CLI0360SelProGroupOutputModel = b;
      })
    }
    a.regisProductGroup = function() {
        a.regisProductGroupData({
            clientId: a.model.hidden.clientId,
            productTypeId: a.model.hidden.productTypeId,
            productGroupName: a.model.form.CLI0360RegisGroupInputModel.productGroupName
        }, function(b) {
            a.model.form.CLI0360RegisGroupResult = b.proResult;
            a.model.form.CLI0360RegisGroupInputModel.productGroupName = "";
            a.selectProGroup();
            "NG" == a.model.form.CLI0360RegisGroupResult.proFlg ?
                e.pop("error", a.model.form.CLI0360RegisGroupResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0360RegisGroupResult.message, null, "trustedHtml")
        })
    };
    a.deleteProductType = function(b) {
        a.deleteProductTypeData({
            clientId: a.model.hidden.clientId,
            productTypeId: b.productTypeId
        }, function(b) {
            a.model.form.CLI0360RegisResult = b.proResult;
            "NG" == a.model.form.CLI0360RegisResult.proFlg && e.pop("error", a.model.form.CLI0360RegisResult.message, null, "trustedHtml");
            a.selectProType()
        })
    };
    a.editProductGroup = function(a) {
        c.$broadcast("CLI0300#openUpdateProductGroupModal", {
            itemProductGroup: angular.copy(a)
        })
    }


}]);
angular.module("cli0361Module", ["dmsCommon", "toaster"]).controller("CLI0361Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.updateProductTypeData = function(a, f) {
        d.doPost("/CLI0360/updateProductTye", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                showUpdateProductType: !1
            }
        };
        a.model.form = {
            CLI0361UpdateProductType: null,
            CLI0361UpdateRivalResult: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("CLI0361#edit", function(b, f) {
            a.model.form = {
                CLI0361UpdateProductType: null,
                CLI0361UpdateRivalResult: null
            };
            a.model.hidden.showUpdateProductType = f.showUpdateProductType;
            a.model.form.CLI0361UpdateProductType = f.itemProductType
        })
    };
    a.closeUpdateProductTypeModal = function() {
        c.$broadcast("CLI0300#closeUpdateProductTypeModal", {})
    };
    a.updateProductType = function() {
        a.updateProductTypeData({
                productTypeId: a.model.form.CLI0361UpdateProductType.productTypeId,
                productGroupId: a.model.form.CLI0361UpdateProductType.productGroupId,
                clientId: a.model.hidden.clientId,
                productTypeName: a.model.form.CLI0361UpdateProductType.productTypeName
            },
            function(b) {
                a.model.form.CLI0361UpdateRivalResult = b.proResult;
                a.model.hidden.showUpdateProductType = !1;
                c.$broadcast("CLI0360#selectProductType", null);
                "NG" == a.model.form.CLI0361UpdateRivalResult.proFlg ? e.pop("error", a.model.form.CLI0361UpdateRivalResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0361UpdateRivalResult.message, null, "trustedHtml");
                c.$broadcast("CLI0300#closeUpdateProductTypeModal", {})
            })
    }
}]);
angular.module("cli0362Module", ["dmsCommon", "toaster"]).controller("CLI0362Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.updateProductGroupData = function(a, f) {
        d.doPost("/CLI0360/updateProductGroup", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                showUpdateProductGroup: !1
            }
        };
        a.model.form = {
            CLI0362UpdateProductGroup: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("CLI0362#edit", function(b, f) {
            a.model.form = {
                CLI0361UpdateProductGroup: null
            };
            a.model.hidden.showUpdateProductGroup = f.showUpdateProductGroup;
            a.model.form.CLI0362UpdateProductGroup = f.itemProductGroup
        })
    };
    a.closeUpdateProductGroupModal = function() {
        c.$broadcast("CLI0300#closeUpdateProductGroupModal", {})
    };
    a.updateProductGroup = function() {
        a.updateProductGroupData({
                productTypeId: a.model.form.CLI0362UpdateProductGroup.productTypeId,
                productGroupId: a.model.form.CLI0362UpdateProductGroup.productGroupId,
                clientId: a.model.hidden.clientId,
                productGroupName: a.model.form.CLI0362UpdateProductGroup.productGroupName
            },
            function(b) {
                a.model.hidden.showUpdateProductGroup = !1;
                c.$broadcast("CLI0360#selectProductGroup", null);
                "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
                c.$broadcast("CLI0300#closeUpdateProductGroupModal", {});
                //c.$broadcast("CLI0300#reloadProductGroup", {productTypeId: a.model.form.CLI0362UpdateProductGroup.productTypeId})
            })
    }
}]);
var cli0370Module = angular.module("cli0370Module", ["dmsCommon", "toaster"]).controller("CLI0370Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.selectRivalData = function(a, f) {
        d.doPost("/CLI0370/selectRival", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.regisRivalData = function(a, f) {
        d.doPost("/CLI0370/regisRival", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteRivalData = function(a, f) {
        d.doPost("/CLI0370/deleteRival", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.selectRivalProductData = function(a,
        f) {
        d.doPost("/CLI0370/selectRivalProduct", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteRivalProductData = function(a, f) {
        d.doPost("/CLI0370/deleteRivalProduct", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                showUpdateRival: !1,
                rivalSelect: null,
                showRivalProduct: !1,
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                }
            }
        };
        a.model.form = {
            CLI0370SelProTypeOutputModel: null,
            CLI0370RegisResult: null,
            CLI0370RegisInputModel: {
                clientId: null,
                rivalName: ""
            },
            PRO1100SearchDataModel: null,
            CLI370SelectedRival: null
        };
        a.$on("CLI0370#selectRival", function() {
            a.selectRival()
        });
        a.$on("CLI0370#selectRivalProduct", function() {
            a.selectRivalProduct()
        });
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.selectRivalData({
            clientId: a.model.hidden.clientId
        }, function(b) {
            a.model.form.CLI0370SelProTypeOutputModel = b;
        });
        a.$on("CLI0300#closeImportProduct", function() {
            a.selectRivalProduct()
        })
    };
    a.selectRival = function() {
        a.selectRivalData({
                clientId: a.model.hidden.clientId
            },
            function(b) {
                a.model.form.CLI0370SelProTypeOutputModel = b;
            })
    };
    a.regisRival = function() {
        a.regisRivalData({
            clientId: a.model.hidden.clientId,
            rivalName: a.model.form.CLI0370RegisInputModel.rivalName
        }, function(b) {
            a.model.form.CLI0370RegisResult = b.proResult;
            a.model.form.CLI0370RegisInputModel.rivalName = "";
            a.selectRival();
            "NG" == a.model.form.CLI0370RegisResult.proFlg ? e.pop("error", a.model.form.CLI0370RegisResult.message, null, "trustedHtml") : e.pop("success",
                a.model.form.CLI0370RegisResult.message, null, "trustedHtml")
        })
    };
    a.deleteRival = function(b) {
        event.stopPropagation();
        a.deleteRivalData({
            clientId: a.model.hidden.clientId,
            rivalId: b.rivalId
        }, function(f) {
            a.model.form.CLI0370RegisResult = f;
            if (a.model.hidden.rivalSelect.rivalId == b.rivalId) a.model.hidden.rivalSelect = null, a.model.hidden.showRivalProduct = !1;
            a.selectRival()
        })
    };
    a.updateRival = function(a) {
        event.stopPropagation();
        c.$broadcast("CLI0300#openRivalModal", {
            itemRival: angular.copy(a)
        })
    };
    a.selectRivalItem =
        function(b) {
            a.model.hidden.rivalSelect = b;
            a.model.hidden.showRivalProduct = !0;
            a.selectRivalProduct()
        };
    a.selectRivalProduct = function() {
        param = {
            clientId: a.model.hidden.clientId,
            rivalId: a.model.hidden.rivalSelect.rivalId
        };
        a.selectRivalProductData(param, function(b) {
            a.model.form.CLI0370SelRivalProOutputModel = b
        })
    };
    a.deleteRivalProduct = function(b) {
        a.deleteRivalProductData({
            rivalProductId: b.rivalProductId,
            productName: b.productName,
            clientId: a.model.hidden.clientId
        }, function() {
            a.selectRivalProduct()
        })
    };
    a.importFile =
        function() {
            c.$broadcast("CLI0300#openImportRivalProduct", {
                rivalId: a.model.hidden.rivalSelect.rivalId
            })
        };
    a.regisRivalProduct = function() {
        c.$broadcast("CLI0300#openRivalProductModal", {
            rivalId: a.model.hidden.rivalSelect.rivalId
        })
    };
    a.showModalEditPro = function(a) {
        c.$broadcast("CLI0300#updateRivalProductModal", {
            productItem: a
        })
    }
}]);
angular.module("cli0371Module", ["dmsCommon", "toaster"]).controller("CLI0371Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.updateRivalData = function(a, f) {
        d.doPost("/CLI0370/updateRival", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                showUpdateRival: !1
            }
        };
        a.model.form = {
            CLI0371UpdateRival: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("CLI0371#edit", function(b, f) {
            a.model.hidden.showModalEditRival = f.showModalEditRival;
            a.model.form.CLI0371UpdateRival = f.itemRival
        })
    };
    a.closeUpdateRivalModal = function() {
        c.$broadcast("CLI0300#closeRivalModal", {})
    };
    a.updateRival = function() {
        a.updateRivalData({
            clientId: a.model.hidden.clientId,
            rivalId: a.model.form.CLI0371UpdateRival.rivalId,
            rivalName: a.model.form.CLI0371UpdateRival.rivalName
        }, function(b) {
            a.model.form.CLI0371RegisResult = b.proResult;
            a.model.hidden.showModalEditRival = !1;
            c.$broadcast("CLI0370#selectRival", null);
            "NG" == a.model.form.CLI0371RegisResult.proFlg ? e.pop("error", a.model.form.CLI0371RegisResult.message,
                null, "trustedHtml") : e.pop("success", a.model.form.CLI0371RegisResult.message, null, "trustedHtml");
            c.$broadcast("CLI0300#closeRivalModal", {})
        })
    }
}]);
angular.module("cli0372Module", ["dmsCommon", "toaster"]).controller("CLI0372Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {
            hidden: {
                showCreatePro: !1,
                buttonModeAdd: !0,
                clientCode: null,
                clientId: null,
                validated: {
                    isErrored: !1,
                    productTypeId: {
                        isErrored: !1,
                        msg: ""
                    },
                    unitName: {
                        isErrored: !1,
                        msg: ""
                    },
                    productName: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            CLI0372InitData: null,
            CLI0372ModelAddProduct: {
                clientId: null,
                rivalId: null,
                unitName: null,
                productName: null,
                productTypeId: null
            },
            CLI0372AddProductResult: null,
            rivalProductId: null
        };
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        a.model.hidden.clientId = angular.element("#clientId").val();
        param = {
            clientId: a.model.hidden.clientId
        };
        a.initData(param, function(b) {
            a.model.form.CLI0372InitOutPutModal = b
        });
        a.$on("CLI0372#createRivalProduct", function(b, f) {
            a.model.hidden.showRivalProductModal = !0;
            a.model.hidden.buttonModeAdd = !0;
            a.model.form.CLI0372ModelAddProduct.rivalId = f.rivalId
        });
        a.$on("CLI0372#showModalEditPro", function(b,
            f) {
            a.model.hidden.showRivalProductModal = !0;
            a.model.hidden.buttonModeAdd = !1;
            a.model.form.CLI0372ModelEditProduct = f.productItem;
            a.model.form.CLI0372ModelAddProduct.productTypeId = a.model.form.CLI0372ModelEditProduct.productTypeId;
            a.model.form.CLI0372ModelAddProduct.rivalId = a.model.form.CLI0372ModelEditProduct.rivalId;
            a.model.form.CLI0372ModelAddProduct.unitName = a.model.form.CLI0372ModelEditProduct.unitName;
            a.model.form.CLI0372ModelAddProduct.productName = a.model.form.CLI0372ModelEditProduct.productName;
            a.model.form.rivalProductId = a.model.form.CLI0372ModelEditProduct.rivalProductId
        });
        a.$on("CLI0372#edit", function(b, f) {
            a.model.hidden.showCreatePro = f.showCreatePro;
            a.model.hidden.buttonModeAdd = !1;
            param = {
                clientId: a.model.hidden.clientId,
                productId: f.productInfo.productId
            };
            a.selectProductData(param)
        })
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            productTypeId: {
                isErrored: !1,
                msg: ""
            },
            unitName: {
                isErrored: !1,
                msg: ""
            },
            productName: {
                isErrored: !1,
                msg: ""
            },
            productGroupId: {
                isErrored: !1,
                msg: ""
            }
        };
        if (null == a.model.form.CLI0372ModelAddProduct.productTypeId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productTypeId.isErrored = !0, a.model.hidden.validated.productTypeId.msg = Messages.getMessage("E0000004", "CLI0372_LABEL_PRODUCT_TYPE");
        if (!ValidateUtil.isValidTextRequired(a.model.form.CLI0372ModelAddProduct.unitName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.unitName.isErrored = !0, a.model.hidden.validated.unitName.msg = Messages.getMessage("E0000004", "CLI0372_LABEL_PRODUCT_UNIT");
        if (!ValidateUtil.isValidTextRequired(a.model.form.CLI0372ModelAddProduct.productName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productName.isErrored = !0, a.model.hidden.validated.productName.msg = Messages.getMessage("E0000004", "CLI0372_LABEL_PRODUCT_NAME")
    };
    a.clearProductValue = function() {
        a.model.form.CLI0372ModelAddProduct.unitName = "";
        a.model.form.CLI0372ModelAddProduct.productTypeId = null;
        a.model.form.CLI0372ModelAddProduct.productName = ""
    };
    a.regisRivalProduct = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            clientId: a.model.hidden.clientId,
            rivalId: a.model.form.CLI0372ModelAddProduct.rivalId,
            unitName: a.model.form.CLI0372ModelAddProduct.unitName,
            productName: a.model.form.CLI0372ModelAddProduct.productName,
            productTypeId: a.model.form.CLI0372ModelAddProduct.productTypeId
        }, a.regisRivalProductData(param, function(b) {
            a.model.form.CLI0372AddProductResult = b.proResult;
            a.clearProductValue();
            c.$broadcast("CLI0370#selectRivalProduct", null);
            null != a.model.form.CLI0372AddProductResult && ("NG" == a.model.form.CLI0372AddProductResult.proFlg ? e.pop("error", a.model.form.CLI0372AddProductResult.message, null, "trustedHtml") :
                (e.pop("success", a.model.form.CLI0372AddProductResult.message, null, "trustedHtml"), c.$broadcast("CLI0300#closeRivalProductModal", {})))
        }))
    };
    a.closeAddRivalProductModal = function() {
        a.model.form.CLI0372AddProductResult = null;
        c.$broadcast("CLI0300#closeRivalProductModal", {})
    };
    a.updateRivalProduct = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            clientId: a.model.hidden.clientId,
            unitName: a.model.form.CLI0372ModelAddProduct.unitName,
            productName: a.model.form.CLI0372ModelAddProduct.productName,
            productTypeId: a.model.form.CLI0372ModelAddProduct.productTypeId,
            rivalProductId: a.model.form.rivalProductId
        }, a.updateRivalProductData(param, function(b) {
            a.model.form.CLI0372AddProductResult = b.proResult;
            a.model.hidden.showRivalProductModal = !1;
            c.$broadcast("CLI0370#selectRivalProduct", null);
            null != a.model.form.CLI0372AddProductResult && ("NG" == a.model.form.CLI0372AddProductResult.proFlg ? e.pop("error", a.model.form.CLI0372AddProductResult.message, null, "trustedHtml") : (e.pop("success", a.model.form.CLI0372AddProductResult.message,
                null, "trustedHtml"), c.$broadcast("CLI0300#closeRivalProductModal", {})))
        }))
    };
    a.initData = function(a, f) {
        d.doPost("/CLI0370/initData", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.regisRivalProductData = function(a, f) {
        d.doPost("/CLI0370/regisRivalProduct", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.updateRivalProductData = function(a, f) {
        d.doPost("/CLI0370/updateRivalProduct", a, function(a) {
            (f || angular.noop)(a)
        })
    }
}]);
angular.module("cli0380Module", ["dmsCommon", "toaster","ngLoadingSpinner"]).controller("CLI0380Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                },
                areaId: null,
                areaIdNotAssign: null,
                defaultAreaName: Messages.getMessage("CLI0380_LABEL_REGION_CHOOSE"),
                defaultAreaNameNotAssign: Messages.getMessage("CLI0380_LABEL_REGION_CHOOSE")
            }
        };
        a.model.form = {
            chooseAll: !1,
            CLI0380InitOutputModel: null,
            CLI0380ResultSearchModel: null,
            CLI0380SearchData: {
                searchInput: {
                    clientId: 0,
                    storeCode: "",
                    storeName: "",
                    areaId: null
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 0,
                    rowNumber: 0
                }
            },
            CLI0380ResultSearchNotAssignModel: {
                resultStoreNotAssign: {
                    searchInput: {
                        clientId: 0,
                        storeCode: "",
                        storeName: "",
                        areaId: null
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            },
            CLI0380SearchDataStoreNotAssign: {
                searchInput: {
                    clientId: 0,
                    storeCode: "",
                    storeName: "",
                    areaId: null
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            defaultUserId: null,
            CLI0380CreateResultDto: null,
            CLI0380DeleteResultDto: null,
            listSelectStore: []
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.initData({
            clientId: a.model.hidden.clientId
        }, function(b) {
            a.model.form.CLI0380InitOutputModel = b
        })
        a.searchDataStoreNotAssignOnly();
    };
    a.chooseArea = function(b, f) {
        a.model.hidden.defaultAreaName = b;
        a.model.hidden.areaId = f
    };
    a.chooseAreaNotAssign = function(b, f) {
        a.model.hidden.defaultAreaNameNotAssign = b;
        a.model.hidden.areaIdNotAssign = f
    };
    a.searchStore = function() {
        a.searchDataStoreOnly()
    };
    a.prevPageStore = function() {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchDataStore()
    };
    a.nextPageStore = function() {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataStore()
    };
    a.startPageStore = function() {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataStore()
    };
    a.endPageStore = function() {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataStore()
    };
    a.searchStoreNotAssign = function() {
        a.searchDataStoreNotAssignOnly()
    };
    a.prevPageStoreNotAssign = function() {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage -= 1;
        a.searchDataStoreNotAssign()
    };
    a.nextPageStoreNotAssign = function() {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage += 1;
        a.searchDataStoreNotAssign()
    };
    a.startPageStoreNotAssign = function() {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage = 1;
        a.searchDataStoreNotAssign()
    };
    a.endPageStoreNotAssign = function() {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage =
            a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages;
        a.searchDataStoreNotAssign()
    };
    a.addStore = function() {
        a.addStoreData({
            clientId: a.model.hidden.clientId,
            storeIdList: a.model.form.listSelectStore
        }, function(b) {
            a.model.form.CLI0380CreateResultDto = b.proResult;
            a.model.form.listSelectStore = [];
            a.searchDataStoreNotAssign();
            a.searchStore();
            null != a.model.form.CLI0380CreateResultDto && ("NG" == a.model.form.CLI0380CreateResultDto.proFlg ? e.pop("error", a.model.form.CLI0380CreateResultDto.message,
                null, "trustedHtml") : e.pop("success", a.model.form.CLI0380CreateResultDto.message, null, "trustedHtml"))
        })
    };
    a.deleteStore = function(b) {
        a.deleteUserStoresmanData({
            clientId: a.model.hidden.clientId,
            storeId: b.storeId
        }, function(b) {
            a.model.form.CLI0380DeleteResultDto = b;
            a.searchDataStore()
        })
    };
    a.chooseStore = function(b) {
        !1 == b.choose && a.removeStoreItem(b);
        !0 == b.choose && a.addStoreItem(b)
    };
    a.removeStoreItem = function(b) {
        for (var f = 0; f < a.model.form.listSelectStore.length; f++)
            if (a.model.form.listSelectStore[f] == b.storeId) {
                a.model.form.listSelectStore.splice(f,
                    1);
                break
            }
        a.checkChooseAll()
    };
    a.addStoreItem = function(b) {
        a.model.form.listSelectStore.push(b.storeId);
        a.checkChooseAll()
    };
    a.chooseAll = function() {
        if (null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++) {
                    var f = a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b];
                    f.choose = !1;
                    for (var c = 0; c < a.model.form.listSelectStore.length; c++) a.model.form.listSelectStore[c] ==
                        f.storeId && a.model.form.listSelectStore.splice(c, 1)
                } else
                    for (b = 0; b < a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++) f = a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b], f.choose = !0, a.model.form.listSelectStore.push(f.storeId)
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++)
                if (!1 ==
                    a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function() {
        // if (null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo) {
        //     for (var b = 0; b < a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++) {
        //         var f = a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b];
        //         f.choose = !1;
        //         for (var c = 0; c < a.model.form.listSelectStore.length; c++)
        //             if (a.model.form.listSelectStore[c] ==
        //                 f.storeId) f.choose = !0
        //     }
        //     a.checkChooseAll()
        // }
        a.model.form.listSelectStore = [];
        a.model.form.chooseAll = 1;
    };
    a.initData = function(a, f) {
        d.doPost("/CLI0380/initData", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.searchDataStore = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                storeCode: a.model.form.CLI0380SearchData.searchInput.storeCode,
                storeName: a.model.form.CLI0380SearchData.searchInput.storeName,
                areaId: a.model.hidden.areaId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0380/searchStoreAssigned", param, function(b) {
            a.model.form.CLI0380ResultSearchModel = b;
            a.model.form.CLI0380InitOutputModel.resultSearch.storeInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreOnly = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                storeCode: a.model.form.CLI0380SearchData.searchInput.storeCode,
                storeName: a.model.form.CLI0380SearchData.searchInput.storeName,
                areaId: a.model.hidden.areaId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0380/searchStoreAssigned", param, function(b) {
            a.model.form.CLI0380ResultSearchModel = b;
            a.model.form.CLI0380InitOutputModel.resultSearch.storeInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreNotAssign = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                storeCode: a.model.form.CLI0380SearchDataStoreNotAssign.searchInput.storeCode,
                storeName: a.model.form.CLI0380SearchDataStoreNotAssign.searchInput.storeName,
                areaId: a.model.hidden.areaIdNotAssign
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ?
                    a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0380/searchStoreNotAssign", param, function(b) {
            a.model.form.CLI0380ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataStoreNotAssignOnly = function() {
        param = {
            searchInput: {
                clientId: a.model.hidden.clientId,
                storeCode: a.model.form.CLI0380SearchDataStoreNotAssign.searchInput.storeCode,
                storeName: a.model.form.CLI0380SearchDataStoreNotAssign.searchInput.storeName,
                areaId: a.model.hidden.areaIdNotAssign
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/CLI0380/searchStoreNotAssign", param, function(b) {
            a.model.form.CLI0380ResultSearchNotAssignModel = b;
            a.model.form.listSelectStore = [];
            a.checkChooseAllAfterSearch()
        })
    };
    a.addStoreData = function(a, f) {
        d.doPost("/CLI0380/addStore", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteUserStoresmanData = function(a, f) {
        d.doPost("/CLI0380/deleteStore", a, function(a) {
            (f || angular.noop)(a)
        })
    }
}]);
var cli0390Module = angular.module("cli0390Module", ["dmsCommon", "toaster"]).controller("CLI0390Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.selectProTypeData = function(a, f) {
        d.doPost("/CLI0390/selectProType", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.selectProGroupData = function(a, f) {
        d.doPost("/CLI0390/selectProGroup", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.regisProductTypeData = function(a, f) {
        d.doPost("/CLI0390/regisProductTye", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteProductTypeData = function(a, f) {
        d.doPost("/CLI0390/deleteProductTye", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.init =
        function() {
            a.model = {};
            a.model = {
                hidden: {
                    deleteConfirm: {
                        message: Messages.getMessage("C0000001")
                    }
                }
            };
            a.model.form = {
                CLI0390SelProTypeOutputModel: null,
                CLI0390SelProGroupOutputModel:null,
                CLI0390RegisResult: null,
                CLI0390RegisInputModel: {
                    clientId: null,
                    productTypeName: ""
                }
            };
            a.model.hidden.clientId = angular.element("#clientId").val()
        };
    a.selectProType = function() {
        a.selectProTypeData({
            clientId: a.model.hidden.clientId
        }, function(b) {
            a.model.form.CLI0390SelProTypeOutputModel = b;
        })
    };
    a.selectProGroup = function() {
        a.selectProGroupData({
            clientId: a.model.hidden.clientId
        }, function(b) {
            a.model.form.CLI0390SelProGroupOutputModel = b;
        })
    };
    a.regisProductType =
        function() {
            a.regisProductTypeData({
                clientId: a.model.hidden.clientId,
                productTypeName: a.model.form.CLI0390RegisInputModel.productTypeName
            }, function(b) {
                a.model.form.CLI0390RegisResult = b.proResult;
                a.model.form.CLI0390RegisInputModel.productTypeName = "";
                a.selectProType();
                "NG" == a.model.form.CLI0390RegisResult.proFlg ? e.pop("error", a.model.form.CLI0390RegisResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0390RegisResult.message, null, "trustedHtml")
            })
        };
    a.deleteProductType = function(b) {
        a.deleteProductTypeData({
            clientId: a.model.hidden.clientId,
            productTypeId: b.productTypeId
        }, function(b) {
            a.model.form.CLI0390RegisResult = b;
            a.selectProType()
        })
    };
    a.editProductType = function(a) {
        c.$broadcast("CLI0300#openUpdateProductTypeModal", {
            itemProductType: angular.copy(a)
        })
    }
}]);
angular.module("cli0400Module", ["dmsCommon", "sal0401Module", "sal0402Module", "sal0403Module", "sal0404Module"]).controller("CLI0400Ctrl", ["$scope", "serverService", "$rootScope", function(a, d, c) {
    a.initData = function(a, b) {
        d.doPost("/CLI0400/initData", a, function(a) {
            (b || angular.noop)(a)
        })
    };
    a.searchData = function(a, b) {
        d.doPost("/CLI0400/searchDataSalman", a, function(a) {
            (b || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                no_img: getContextPathImageDefault() + "/img/no_img.png",
                typeReport: 1,
                defaultAreaName: Messages.getMessage("CLI0400_LABEL_REGION_CHOOSE"),
                showDetailSale: !1,
                selectedDate: null
            }
        };
        a.model.form = {
            CLI0400InitOutputModel: null,
            CLI0400SearchDataSalman: {
                searchInput: {
                    areaId: null,
                    clientId: "",
                    salesmanCode: "",
                    salesmanName: ""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            CLI0400SearchDataSalmanResult: null,
            currentSaleChoose: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        param = {
            clientId: a.model.hidden.clientId
        };
        a.initData(param, function(c) {
            a.model.form.CLI0400InitOutputModel = c
        })
    };
    a.chooseArea = function(c, b) {
        a.model.hidden.defaultAreaName =
            c;
        a.model.hidden.areaId = b
    };
    a.chooseSale = function(e) {
        a.model.form.currentSaleChoose = e;
        a.model.hidden.showDetailSale = !0;
        a.model.form.currentSaleChoose.urlImg = getContextPath() + a.model.form.currentSaleChoose.imagePath;
        c.$broadcast("SAL0401#search", {
            saleChoose: e
        });
        c.$broadcast("SAL0402#search", {});
        c.$broadcast("SAL0404#search", {})
    };
    a.search = function() {
        a.searchData({
            searchInput: {
                areaId: a.model.hidden.areaId,
                clientId: a.model.hidden.clientId,
                salesmanCode: a.model.form.CLI0400SearchDataSalman.searchInput.salesmanCode,
                salesmanName: a.model.form.CLI0400SearchDataSalman.searchInput.salesmanNames
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.ttlPages : null,
                crtPage: 1,
                rowNumber: null != a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.CLI0400SearchDataSalmanResult = c;
            a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo =
                a.model.form.CLI0400SearchDataSalmanResult.resultSearch.pagingInfo;
            a.model.form.CLI0400InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0400SearchDataSalmanResult.resultSearch.searchSalList
        })
    };
    a.searchDataPaging = function() {
        a.searchData({
            searchInput: {
                areaId: a.model.hidden.areaId,
                clientId: a.model.hidden.clientId,
                salesmanCode: a.model.form.CLI0400SearchDataSalman.searchInput.salesmanCode,
                salesmanName: a.model.form.CLI0400SearchDataSalman.searchInput.salesmanNames
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo ?
                    a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.ttlPages : null,
                crtPage: null != a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo ? a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.CLI0400SearchDataSalmanResult = c;
            a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0400SearchDataSalmanResult.resultSearch.pagingInfo;
            a.model.form.CLI0400InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0400SearchDataSalmanResult.resultSearch.searchSalList
        })
    };
    a.prevPage = function() {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchDataPaging()
    };
    a.nextPage = function() {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataPaging()
    };
    a.startPage = function() {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataPaging()
    };
    a.endPage = function() {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage =
            a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataPaging()
    }
}]);
var dmsCommon = angular.module("dmsCommon", ["toaster", "aut0200Module", "mrpt0200Module"]);
dmsCommon.filter("noFractionCurrency", ["$filter", "$locale", function(a, d) {
    var c = a("currency"),
        e = d.NUMBER_FORMATS;
    return function(a, f) {
        var d = c(a, f),
            g = d.indexOf(e.DECIMAL_SEP);
        return 0 <= a ? d.substring(0, g) : d.substring(0, g) + ")"
    }
}]);
dmsCommon.controller("commonCtrl", ["$scope", "$rootScope", "$http", "$window", "$filter", "serverService", "idleService", function(a, d, c, e, b, f, h) {
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
    a.$on("AUT0200#closeChangePasswordModal", function() {
        a.model.hidden.changePassword = !1
    });

    a.$on("MRPT0200#closeMonthlyReportModal", function() {
        a.model.hidden.monthlyReport = !1
    });
    a.$on("doPost", function(a, b) {
        f.doPost(b.action, b.params, b.callback)
    });
    a.getMessages = function(a) {
        d.$broadcast("doPost", {
            action: "DAS0100/getMessages",
            callback: function(b) {
                (a || angular.noop)(b)
            }
        })
    };
    Messages.hasMessage() ||
        a.getMessages(function(a) {
            Messages.setMessage(a.msgList)
        });
    h.start()
}]);
dmsCommon.service("serverService", ["$http", "$window", "toaster", "idleService", function(a, d, c, e) {
    this.doPost = function(b, f, d, g) {
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
        a(b).success(function(a,
            b, f, g) {
            Fukyo.utils.LogUtils.isDebug() && (Fukyo.utils.LogUtils.trace("[ACTION   END  ] : " + g.url + " [" + (new Date - g.actionStartDate) + "ms]"), Fukyo.utils.LogUtils.trace("[ACTION   OUTPUT] : ", a));
            b = new Date;
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK START] : " + g.url);
            angular.isDefined(a) && null != a && "NG" == a.returnCd && c.pop("error", a.returnMsg, null, "trustedHtml");
            (d || angular.noop)(a);
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK END  ] : " + g.url + " [" + (new Date -
                b) + "ms]");
            e.reset()
        }).error(function(a, b, f, e) {
            Fukyo.utils.LogUtils.isDebug() && (Fukyo.utils.LogUtils.trace("[ACTION   ERROR] : " + e.url + " [" + (new Date - e.actionStartDate) + "ms]"), Fukyo.utils.LogUtils.trace(f), Fukyo.utils.LogUtils.trace(b));
            Fukyo.utils.LogUtils.error(a);
            (g || angular.noop)(a);
            c.pop("error", Messages.getMessage("F0000001"), null, "trustedHtml")
        })
    };
    this.downloadFile = function(a, f) {
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
    this.uploadFile = function(b, f, e, d, i) {
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
        }).success(function(a) {
            Fukyo.utils.LogUtils.isDebug() &&
                (Fukyo.utils.LogUtils.trace("[ACTION   END  ] : " + j + " [" + (new Date - k) + "ms]"), Fukyo.utils.LogUtils.trace("[ACTION   OUTPUT] : " + angular.toJson(a)));
            angular.isDefined(a) && null != a && "NG" == a.returnCd && c.pop("error", a.returnMsg, null, "trustedHtml");
            if (Fukyo.utils.LogUtils.isDebug()) {
                var b = new Date;
                Fukyo.utils.LogUtils.trace("[CALLBACK START] : " + j)
            }(d || angular.noop)(a);
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK END  ] : " + j + " [" + (new Date - b) + "ms]")
        }).error(function(a) {
            Fukyo.utils.LogUtils.isDebug() &&
                (Fukyo.utils.LogUtils.trace("[ACTION   END  ] : " + j + " [" + (new Date - k) + "ms]"), Fukyo.utils.LogUtils.trace("[ACTION   OUTPUT] : " + angular.toJson(a)));
            if (Fukyo.utils.LogUtils.isDebug()) {
                var b = new Date;
                Fukyo.utils.LogUtils.trace("[CALLBACK START] : " + j)
            }(i || angular.noop)(a);
            Fukyo.utils.LogUtils.isDebug() && Fukyo.utils.LogUtils.trace("[CALLBACK END  ] : " + j + " [" + (new Date - b) + "ms]");
            c.pop("error", Messages.getMessage("F0000001"), null, "trustedHtml")
        })
    }
}]);
dmsCommon.directive("chosenSelect", function() {
    return {
        restrict: "A",
        link: function(a, d, c) {
            var e = c.chosenWidth,
                b = c.chosenSelect,
                f = c.ngDisabled,
                h = c.chosenDeselect;
            a.$on("chosen#updateList", function() {
                a.$watch(c.list, function() {
                    $(d).trigger("liszt:updated");
                    $(d).trigger("chosen:updated")
                })
            });
            angular.isDefined(c.list) && null !== c.list && a.$watch(c.list, function() {
                $(d).trigger("liszt:updated");
                $(d).trigger("chosen:updated")
            });
            angular.isDefined(b) && null !== b && a.$watch(b, function() {
                $(d).trigger("liszt:updated");
                $(d).trigger("chosen:updated")
            });
            a.$watch(c.ngModel, function() {
                $(d).trigger("chosen:updated")
            });
            angular.isDefined(f) && null !== f && a.$watch(f, function(a) {
                $(d).prop("disabled", a);
                $(d).trigger("liszt:updated");
                $(d).trigger("chosen:updated")
            });
            a.$watch(c.ngModel, function() {
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
dmsCommon.directive("ngFileSelect", function() {
    return {
        link: function(a, d) {
            d.bind("change", function(c) {
                for (var i = 0; i < c.target.files.length; i++) {
                    a.file = (c.srcElement || c.target).files[i];
                    a.getFile(a.file)
                }

            })
        }
    }
});
dmsCommon.directive("currencyInput", function(a, d) {
    return {
        require: "ngModel",
        link: function(c, e, b, f) {
            var h = function() {
                var b = e.val().replace(/,/g, "");
                e.val(a("number")(b, !1))
            };
            f.$parsers.push(function(a) {
                return a.replace(/,/g, "")
            });
            f.$render = function() {
                e.val(a("number")(f.$viewValue, !1))
            };
            e.bind("change", h);
            e.bind("keydown", function(a) {
                a = a.keyCode;
                91 == a || 15 < a && 19 > a || 37 <= a && 40 >= a || d.defer(h)
            });
            e.bind("paste cut", function() {
                d.defer(h)
            })
        }
    }
});
dmsCommon.directive("datepicker", ["$document", function(a) {
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
        link: function(d, c) {
            d.datepickerTrigger = 0 !== angular.element(c).prev(".datepickerTrigger").length ? angular.element(c).prev(".datepickerTrigger") : void 0;
            "button" === d.dateType && (angular.element(c).hide(), angular.element(d.datepickerTrigger).on("click", function() {
                angular.element(this).hide();
                angular.element(c).show().find(".dmsDatepicker > input").focus()
            }), a.on("click", function(a) {
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
    function(a, d, c, e) {
        a.id = a.dateId;
        a.name = c.name;
        a.today = e("date")(new Date, "dd-MM-yyyy");
        a.initDatePicker = function() {
            $("#" + a.id).datepicker({
                dateFormat: "dd-mm-yy",
                numberOfMonths: 1,
                showCurrentAtPos: 0,
                onSelect: function(b) {
                    "button" === a.dateType && (a.$apply(function() {
                        a.dateValue = b
                    }), angular.element(this).closest("datepicker").hide(), angular.element(this).closest("datepicker").prev().show());
                    a.$apply(function() {
                        a.updateDatepicker()
                    })
                }
            })
        };
        a.formatCheck = function() {
            var b = $("#" + a.dateId),
                f = a.dateValue,
                c = e("date")(new Date(b.val()), "dd-MM-yyyy"),
                d = e("date")(new Date(f), "dd-MM-yyyy");
            if (b.val() !== f && c === d) a.dateValue = b.val()
        };
        a.updateDatepicker = function() {
            ("" === a.dateMinValue || null === a.dateMinValue || void 0 === a.dateMinValue || "" === a.dateMaxValue || null === a.dateMaxValue || void 0 === a.dateMaxVaule) && $("#" + a.id).datepicker("option", "defaultDate", null);
            a.changeMonthDisplay(a.dateMaxValue, "maxDate", 2);
            a.changeMonthDisplay(a.dateMinValue, "minDate", 0);
            null !== a.dateValue && void 0 !== a.dateValue &&
                "" !== $("#" + a.id).val() && $("#" + a.id).datepicker("option", "showCurrentAtPos", 0);
            a.dateValue = $("#" + a.dateId).val()
        };
        a.changeMonthDisplay = function(b, f, c) {
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
        a.moveDay = function(b) {
            var f = "";
            if (null ==
                a.dateValue || "" === a.dateValue) a.dateValue = a.today;
            f = new Date(a.dateValue.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            formatCheck = e("date")(f, "dd-MM-yyyy");
            if (angular.isDate(f) && "Invalid Date" !== f.toString() && angular.isNumber(b)) a.dateValue = e("date")(f.setDate(f.getDate() + b), "dd-MM-yyyy"), a.changeDayRange(a.dateValue)
        };
        a.getToday = function() {
            a.dateValue = a.today;
            a.changeDayRange(a.dateValue)
        };
        a.changeDayRange = function(b) {
            if (null != a.dateMinValue && void 0 !== a.dateMinValue && a.dateMinValue > b) a.dateMinValue =
                b;
            if (null != a.dateMaxValue && void 0 !== a.dateMaxValue && a.dateMaxValue < b) a.dateMaxValue = b
        };
        a.dateValidationFunc = function() {
            a.invalid = null === a.dateValue || void 0 === a.dateValue || "" === a.dateValue ? !0 : !1
        };
        angular.isArray(a.dateValidation) && a.dateValidation.push(a.dateValidationFunc)
    }
]);
dmsCommon.directive("fileModel", ["$parse", function(a) {
    return {
        restrict: "A",
        link: function(d, c, e) {
            var b = a(e.fileModel).assign;
            c.bind("change", function() {
                d.$apply(function() {
                    b(d, c[0].files[0])
                })
            })
        }
    }
}]);
(function(a) {
    a.factory("fileReader", ["$q", "$log", function(a) {
        var c = function(a, b, c) {
                return function() {
                    c.$apply(function() {
                        b.resolve(a.result)
                    })
                }
            },
            e = function(a, b, c) {
                return function() {
                    c.$apply(function() {
                        b.reject(a.result)
                    })
                }
            },
            b = function(a, b) {
                return function(a) {
                    b.$broadcast("fileProgress", {
                        total: a.total,
                        loaded: a.loaded
                    })
                }
            };
        return {
            readAsDataUrl: function(f, h) {
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
dmsCommon.directive("numeric", function() {
    return function(a, d) {
        $(d[0]).numericInput({
            allowFloat: !0
        })
    }
});
dmsCommon.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});
dmsCommon.service("idleService", ["$timeout", "$window", function(a, d) {
    var c = null;
    this.start = function() {
        null == c && (c = a(this._logoff, 18E5))
    };
    this.reset = function() {
        this._clear();
        this.start()
    };
    this._logoff = function() {
        d.location.href = getContextPath() + "/admin"
    };
    this._clear = function() {
        null != c && (a.cancel(c), c = null)
    }
}]);
if ("undefined" == typeof Fukyo || !Fukyo) var Fukyo = {};
Fukyo.namespace = function() {
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
Function.prototype.inheritsFrom = function(a) {
    a.constructor == Function ? (this.prototype = new a, this.prototype.constructor = this, this.prototype.parent = a.prototype) : (this.prototype = a, this.prototype.constructor = this, this.prototype.parent = a);
    return this
};
Fukyo.namespace("Fukyo.utils");
Fukyo.utils.LogUtils = {
    isDebug: function() {
        return !1
    },
    trace: function(a) {
        if (this.isDebug() && (console.log("[TRACE] " + Fukyo.utils.DateTimeUtils.getNowString() + ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    },
    debug: function(a) {
        if (this.isDebug() && (console.log("[DEBUG] " + Fukyo.utils.DateTimeUtils.getNowString() + ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    },
    info: function(a) {
        if (this.isDebug() && (console.log("[INFO] " + Fukyo.utils.DateTimeUtils.getNowString() +
                ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    },
    error: function(a) {
        if (this.isDebug() && (console.log("[ERROR] " + Fukyo.utils.DateTimeUtils.getNowString() + ": " + a), 1 < arguments.length))
            for (var d = 1; d < arguments.length; d++) console.log(arguments[d])
    }
};
Fukyo.utils.DateTimeUtils = {
    getNowString: function() {
        var a = new Date;
        return a.toLocaleDateString() + " " + a.toLocaleTimeString() + "." + a.getMilliseconds()
    },
    formatTimestamp: function(a) {
        return a.toLocaleDateString() + " " + a.toLocaleTimeString() + "." + a.getMilliseconds()
    }
};
var Messages = {},
    Messages = {
        setMessage: function(a) {
            void 0 == a || null == a || localStorage.setItem("messages", JSON.stringify(a))
        },
        getMessage: function(a, d) {
            var c = localStorage.getItem("messages");
            if (null == c || void 0 == c) return null;
            c = JSON.parse(c)[a];
            if (void 0 == d || null == d) return c;
            for (var e = d.split(","), b = 0; b < e.length; b++) var f = this.getMessage(e[b]),
                c = c.replace(/\{[0-9]+\}/, f ? f : e[b]);
             c = c.toLowerCase();
            return c.charAt(0).toUpperCase() + c.slice(1);
        },
        hasMessage: function() {
            var a = localStorage.getItem("messages");
            return void 0 == a || null == a ? !1 : !0
        },
        clearMessage: function() {
            localStorage.removeItem("messages")
        }
    },
    TextUtil = {},
    TextUtil = {
        isEmpty: function(a) {
            return null == a || "" == a
        },
        toString: function(a) {
            return void 0 == a || null == a || "null" === a ? null : a.constructor === String ? a : a.toString()
        }
    },
    ValidateUtil = {},
    ValidateUtil = {
        _isValidated: function(a, d) {
            return d.test(a)
        },
        _trimEnd: function(a) {
            return TextUtil.isEmpty(a) ? a : a.replace(/\s+$/g, "")
        },
        isValidTextRequired: function(a) {
            var d = this._trimEnd(a);
            return TextUtil.isEmpty(d) ? !1 : a ? this.isValidTextLength(d, 1, Infinity) : a
        },
        isValidTextInvalidChars: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ?
                !0 : !0 == this._isValidated(a, /[]/) ? !1 : !0
        },
        isValidTextLength: function(a, d, c) {
            a = this._trimEnd(a);
            if (TextUtil.isEmpty(a)) return !0;
            void 0 == c && (c = d);
            return d <= a.length && a.length <= c
        },
        isValidTextNumeric: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, /^[\d]*$/)
        },
        isValidTextNumber: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, /^[\d-\u002E]*$/) && isFinite(a)
        },
        isValidTextAlpha: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a,
                /^[A-Za-z]*$/)
        },
        isValidTextAlphaNumeric: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, /^[A-Za-z\d]*$/)
        },
        isValidTextHalf: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : this._isValidated(a, RegExp("^[A-Za-z\\d -/:-@\u00a5[-`{-~]*$"))
        },
        isValidTextDate: function(a) {
            var d = this._trimEnd(a);
            if (TextUtil.isEmpty(d)) return !0;
            return this._isValidated(d, /^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/) ? (a = new Date(d.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")), console.log(d),
                d = d.split("-"), a.getFullYear() === +d[2] && a.getMonth() + 1 === +d[1] && a.getDate() === +d[0]) : !1
        },
        isValidTextTelNo: function(a) {
            a = this._trimEnd(a);
            return TextUtil.isEmpty(a) ? !0 : !1 == this._isValidated(a, /^[0-9-]*$/) || !0 == this._isValidated(a, /^-.*/) || !0 == this._isValidated(a, /.*-$/) ? !1 : !0
        },
        isValidBytesLength: function(a, d) {
            var c = this._trimEnd(a);
            return TextUtil.isEmpty(c) ? !0 : (new Blob([c], {
                type: "text/plain"
            })).size > d ? !1 : !0
        },
        isValidEmail: function(a) {
            return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(a) ? !0 :
                !1
        }
    };
(function(a) {
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
    a.fn.numericInput = function(e) {
        var e = a.extend({}, c, e),
            b = e.allowFloat,
            f = e.allowNegative;
        this.keypress(function(c) {
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

angular.module("pro1100Module", ["dmsCommon", "fcsa-number"]).controller("PRO1100Ctrl", ["$scope", "serverService", "$rootScope","toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {
            hidden: {
                clientCode: null,
                showModalEditPro: !1,
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                },
                clientId: null
            }
        };
        a.model.form = {
            PRO1100SearchDataModel: null,
            PRO1100ParamSearch: {
                searchInput: {
                    productModel: "",
                    productName: ""
                },
                pagingInfo: {
                    ttlRow: null,
                    crtPage: null,
                    rowNumber: null
                }
            }
        };
        a.$on("PR01100#search", function() {
            a.model.hidden.showModalEditPro = !1;
            a.searchPRO1100Data()
        });
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.model.hidden.productTypeId = null;
        a.model.hidden.productGroupId = null;
        a.initData(a.model.hidden.clientCode, a.model.hidden.clientId);
        a.$on("CLI0300#closeImportProduct", function() {
            a.searchPRO1100DataOnly()
        })
    };
    a.searchPRO1100 = function() {
        a.searchPRO1100DataOnly()
    };
    a.prevPagePRO1100 = function() {
        a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage -= 1;
        a.searchPRO1100Data()
    };
    a.nextPagePRO1100 =
        function() {
            a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage += 1;
            a.searchPRO1100Data()
        };
    a.startPagePRO1100 = function() {
        a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage = 1;
        a.searchPRO1100Data()
    };
    a.endPagePRO1100 = function() {
        a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage = a.model.form.PRO1100SearchDataModel.pagingInfo.ttlPages;
        a.searchPRO1100Data()
    };
    a.showModalEditPro = function(e) {
        a.model.hidden.showModalEditPro = !0;
        c.$broadcast("CLI0300#openEditProductModal", {
            productInfo: e
        })
    };
    a.deleteProduct =
        function(c) {
            param = {
                productModel: c.productModel,
                productId: c.productId,
                clientId: a.model.hidden.clientId
            };
            d.doPost("/PRO1100/deleteProduct", param, function(b) {
                 "NG" == b.proFlg ? e.pop("error", b.message, null, "trustedHtml") : e.pop("success", b.message, null, "trustedHtml");
                a.searchPRO1100();
            })
        };
    a.initData = function(c, b) {
        param = {
            clientCode: c,
            clientId: b
        };
        d.doPost("/PRO1100/initData", param, function(b) {
            a.model.form.PRO1100SearchDataModel = b;
            a.model.form.InitData = b.initData
        })
    };
    a.searchPRO1100Data = function() {
        param = {
            searchInput: {
                clientCode: a.model.hidden.clientCode,
                productModel: a.model.form.PRO1100ParamSearch.searchInput.productModel,
                productName: a.model.form.PRO1100ParamSearch.searchInput.productName,
                productTypeId: a.model.hidden.productTypeId,
                productGroupId: a.model.hidden.productGroupId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.PRO1100SearchDataModel.pagingInfo ? a.model.form.PRO1100SearchDataModel.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.PRO1100SearchDataModel.pagingInfo ? a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.PRO1100SearchDataModel.pagingInfo ? a.model.form.PRO1100SearchDataModel.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/PRO1100/searchData",
            param,
            function(c) {
                a.model.form.PRO1100SearchDataModel = c
            })
    };
    a.searchPRO1100DataOnly = function() {
        param = {
            searchInput: {
                clientCode: a.model.hidden.clientCode,
                productModel: a.model.form.PRO1100ParamSearch.searchInput.productModel,
                productName: a.model.form.PRO1100ParamSearch.searchInput.productName,
                productTypeId: a.model.hidden.productTypeId,
                productGroupId: a.model.hidden.productGroupId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.PRO1100SearchDataModel.pagingInfo ? a.model.form.PRO1100SearchDataModel.pagingInfo.ttlRow : null,
                crtPage: a.model.form.PRO1100SearchDataModel.pagingInfo ? a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.PRO1100SearchDataModel.pagingInfo ?
                    a.model.form.PRO1100SearchDataModel.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/PRO1100/searchData", param, function(c) {
            a.model.form.PRO1100SearchDataModel = c
        })
    }
}]);
angular.module("pro1120Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("PRO1120Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.model = {
        hidden: {
            showCreatePro: !1,
            buttonModeAdd: !0,
            clientCode: null,
            clientId: null,
            validated: {
                isErrored: !1,
                productTypeId: {
                    isErrored: !1,
                    msg: ""
                },
                productModel: {
                    isErrored: !1,
                    msg: ""
                },
                productName: {
                    isErrored: !1,
                    msg: ""
                },
                price: {
                    isErrored: !1,
                    msg: ""
                }
            }
        }
    };
    a.model.form = {
        PRO1120InitData: null,
        PRO1120ModelAddProduct: {
            productTypeId: null,
            productGroupId: null,
            productModel: null,
            productName: null,
            price: null
        },
        PRO1120AddProductResult: null
    };
    a.init = function() {
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        a.model.hidden.clientId = angular.element("#clientId").val();
        param = {
            clientId: a.model.hidden.clientId
        };
        a.initData(param);
        a.$on("PR01120#init", function(b, c) {
            a.model.hidden.showCreatePro = c.showCreatePro;
            a.model.hidden.buttonModeAdd = !0
        });
        a.$on("PR01120#edit", function(b, c) {
            a.model.hidden.buttonModeAdd = !1;
            param = {
                clientId: a.model.hidden.clientId,
                productId: c.productInfo.productId
            };
            a.selectProductData(param)
        })
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            productTypeId: {
                isErrored: !1,
                msg: ""
            },
            productModel: {
                isErrored: !1,
                msg: ""
            },
            productName: {
                isErrored: !1,
                msg: ""
            },
            price: {
                isErrored: !1,
                msg: ""
            },
            productGroupId: {
                isErrored: !1,
                msg: ""
            }
        };
        if (null == a.model.form.PRO1120ModelAddProduct.productTypeId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productTypeId.isErrored = !0, a.model.hidden.validated.productTypeId.msg = Messages.getMessage("E0000004", "PRO1120_LABEL_PRODUCT_TYPE");
        if (null == a.model.form.PRO1120ModelAddProduct.productGroupId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productGroupId.isErrored = !0, a.model.hidden.validated.productGroupId.msg = Messages.getMessage("E0000004", "PRO1120_LABEL_PRODUCT_GROUP");

        // if (!ValidateUtil.isValidTextRequired(a.model.form.PRO1120ModelAddProduct.productModel)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productModel.isErrored = !0, a.model.hidden.validated.productModel.msg = Messages.getMessage("E0000004", "PRO1120_LABEL_PRODUCT_CODE");
        if (!ValidateUtil.isValidTextRequired(a.model.form.PRO1120ModelAddProduct.productName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productName.isErrored = !0, a.model.hidden.validated.productName.msg = Messages.getMessage("E0000004", "PRO1120_LABEL_PRODUCT_NAME");
        if (!ValidateUtil.isValidTextRequired(a.model.form.PRO1120ModelAddProduct.price)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.price.isErrored = !0, a.model.hidden.validated.price.msg = Messages.getMessage("E0000004", "PRO1120_LABEL_PRODUCT_PRICE")
    };
    a.clearProductValue = function() {
        a.model.form.PRO1120ModelAddProduct.productModel = "";
        a.model.form.PRO1120ModelAddProduct.productTypeId = null;
        a.model.form.PRO1120ModelAddProduct.productGroupId = null;
        a.model.form.PRO1120ModelAddProduct.productName = "";
        a.model.form.PRO1120ModelAddProduct.price = ""
    };
    a.addProduct = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            clientId: a.model.hidden.clientId,
            productTypeId: a.model.form.PRO1120ModelAddProduct.productTypeId,
            productGroupId: a.model.form.PRO1120ModelAddProduct.productGroupId,
            productModel: a.model.form.PRO1120ModelAddProduct.productModel,
            productName: a.model.form.PRO1120ModelAddProduct.productName,
            price: a.model.form.PRO1120ModelAddProduct.price
        }, a.addProductData(param))
    };
    a.onchangeProductType = function(id){
    	a.selectGroupByProductType(id);
    	a.model.hidden.validated.productGroupId = null;
			a.model.form.PRO1120ModelAddProduct.productGroupId = null;

    };
    a.selectGroupByProductType = function(id){
   	 d.doPost("/PRO1120/selectGroupByProductType",{productTypeId:id}, function(b) {
   		a.model.form.PRO1120InitData.proGroupList = b.proGroupList;
        })
   };
    a.closeAddProduct = function() {
        a.model.hidden.showCreatePro = !1;
        if (null != a.model.form.PRO1120AddProductResult) a.model.form.PRO1120AddProductResult.proFlg = null;
        c.$broadcast("PR01100#search", {
            param: null
        });
        c.$broadcast("CLI0300#closeModalPRO1120", {
            param: null
        })
    };
    a.updateProduct = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored &&
            (param = {
                clientId: a.model.hidden.clientId,
                productId: a.model.form.PRO1120ModelAddProduct.productId,
                productTypeId: a.model.form.PRO1120ModelAddProduct.productTypeId,
                productGroupId: a.model.form.PRO1120ModelAddProduct.productGroupId,
                productModel: a.model.form.PRO1120ModelAddProduct.productModel,
                productName: a.model.form.PRO1120ModelAddProduct.productName,
                price: a.model.form.PRO1120ModelAddProduct.price
            }, a.updateProductData(param))
    };
    a.closeUpdateProduct = function() {
        a.model.hidden.showModalEditPro = !1;
        if (null != a.model.form.PRO1120UpdateProductResult) a.model.form.PRO1120UpdateProductResult.proFlg =
            null;
        a.searchPRO1100Data()
    };
    a.initData = function(b) {
        d.doPost("/PRO1120/initData", b, function(b) {
            a.model.form.PRO1120InitData = b
        })
    };
    a.selectProductData = function(b) {
        d.doPost("/PRO1120/selectProduct", b, function(b) {
            a.model.form.PRO1120ModelAddProduct.productId = b.productInfo.productId;
            a.model.form.PRO1120ModelAddProduct.productTypeId = b.productInfo.productTypeId;
            a.model.form.PRO1120ModelAddProduct.productGroupId = b.productInfo.productGroupId;
            a.model.form.PRO1120ModelAddProduct.productModel = b.productInfo.productModel;
            a.model.form.PRO1120ModelAddProduct.productName = b.productInfo.productName;
            a.model.form.PRO1120ModelAddProduct.price = b.productInfo.price;
            a.model.form.PRO1120ModelAddProduct.versionNo = b.productInfo.versionNo

            a.selectGroupByProductType(b.productInfo.productTypeId);

        })
    };
    a.addProductData = function(b) {
        d.doPost("/PRO1120/regisPro", b, function(b) {
            a.model.form.PRO1120AddProductResult = b;
            a.clearProductValue(a.model.form.PRO1120ModelAddProduct);
            null != a.model.form.PRO1120AddProductResult && ("NG" == a.model.form.PRO1120AddProductResult.proFlg ? e.pop("error", a.model.form.PRO1120AddProductResult.message, null, "trustedHtml") : (e.pop("success", a.model.form.PRO1120AddProductResult.message,
                null, "trustedHtml"), c.$broadcast("PR01100#search", {
                param: null
            }), c.$broadcast("CLI0300#closeModalPRO1120", {
                param: null
            })))
        })
    };
    a.updateProductData = function(b) {
        d.doPost("/PRO1120/updatePro", b, function(b) {
            a.model.form.PRO1120AddProductResult = b;
            null != a.model.form.PRO1120AddProductResult && ("NG" == a.model.form.PRO1120AddProductResult.proFlg ? e.pop("error", a.model.form.PRO1120AddProductResult.message, null, "trustedHtml") : (e.pop("success", a.model.form.PRO1120AddProductResult.message, null, "trustedHtml"), c.$broadcast("PR01100#search", {
                param: null
            }), c.$broadcast("CLI0300#closeModalPRO1120", {
                param: null
            })))
        })
    }
}]);
angular.module("pro1130Module", ["dmsCommon", "toaster"]).controller("PRO1130Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function(a, d, c, e, b) {
    a.init = function() {
        a.model = {
            hidden: {
                rivalMode: !1
            }
        };
        a.model.form = {
            file: null,
            fileData: null,
            files: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("PR01130#initFromRivalProduct", function(b, c) {
            a.model.hidden.rivalMode = !0;
            a.model.hidden.rivalId = c.rivalId
        });
        a.$on("PR01130#importProduct", function() {
            a.model.hidden.rivalMode = !1
        })
    };
    a.chooseFile = function() {
        // event.stopPropagation();
        angular.element("#pro1130ChooseFile").click()
    };
    a.closeImportProduct = function() {
        c.$broadcast("CLI0300#closeImportProduct", {})
    };
    a.getFile = function(b) {
        a.model.form.file = b
    };
    a.setFiles = function(b) {
        a.$apply(function() {
            a.files = [];
            for (var c = 0; c < b.files.length; c++) a.files.push(b.files[c])
        })
    };
    a.upload = function() {
        if (!0 == a.model.hidden.rivalMode) {
            var f = {
                clientId: a.model.hidden.clientId,
                rivalId: a.model.hidden.rivalId
            };
            d.uploadFile("/CLI0370", a.model.form.file,
                f,
                function(f) {
                    a.model.form.PR01130UpdateRivalResult = f.proResult;
                    null != a.model.form.PR01130UpdateRivalResult && ("NG" == a.model.form.PR01130UpdateRivalResult.proFlg ? b.pop("error", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml") : (b.pop("success", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml"), c.$broadcast("CLI0300#closeImportProduct", {})))
                })
        } else f = {
            clientId: a.model.hidden.clientId
        }, d.uploadFile("/PRO1120", a.model.form.file, f, function(f) {
            a.model.form.PR01130UpdateRivalResult =
                f.proResult;
            null != a.model.form.PR01130UpdateRivalResult && ("NG" == a.model.form.PR01130UpdateRivalResult.proFlg ? b.pop("error", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml") : (b.pop("success", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml"), c.$broadcast("CLI0300#closeImportProduct", {})))
        })
    }
}]);
angular.module("rpt0100Module", "dmsCommon,rpt0100Module,rpt0101Module,rpt0102Module,rpt0103Module,rpt0104Module".split(",")).controller("RPT0100Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.init = function() {
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
        a.initData({}, function(c) {
            a.model.form.RPT0100InitDataModel = c;
            a.model.hidden.RPT0100SearchInputModel.searchInput.fromDate = a.model.form.RPT0100InitDataModel.initData.fromDate;
            a.model.hidden.RPT0100SearchInputModel.searchInput.toDate = a.model.form.RPT0100InitDataModel.initData.toDate
        })
    };
    a.validate = function() {
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
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage +=
            1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseArea = function(c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.initData = function(a, e) {
        d.doPost("/RPT0100/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.searchData = function() {
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
            d.doPost("/RPT0100/searchData", c, function(c) {
                a.model.form.RPT0100SearchDataOutputModel = c;
                a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0100SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.timeType = a.model.hidden.RPT0100SearchInputModel.searchInput.timeType;
                a.model.hidden.reportType = a.model.hidden.RPT0100SearchInputModel.searchInput.reportType
            })
        }
    };
    a.searchDataOnly = function() {
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
            d.doPost("/RPT0100/searchData", c, function(c) {
                a.model.form.RPT0100SearchDataOutputModel =
                    c;
                a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0100SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.timeType = a.model.hidden.RPT0100SearchInputModel.searchInput.timeType;
                a.model.hidden.reportType = a.model.hidden.RPT0100SearchInputModel.searchInput.reportType
            })
        }
    };
    a.download = function() {
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
            d.downloadFile("/RPT0100/printData", c, function() {})
        }
    }
}]);
angular.module("rpt0101Module", ["dmsCommon", "rpt0101Module"]).controller("RPT0101Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0101InitDataModel: null
    };
    a.init = function() {
        a.initData()
    };
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0101/initData", {}, function(c) {
            a.model.form.RPT0101InitDataModel = c;
            a.model.form.RPT0101InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0101InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0101InitDataModel.timeType = "0";
            a.model.form.RPT0101InitDataModel.reportType = "0"
        })
    };
    a.searchData =
        function() {
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
                function() {})
        };
    a.download = function() {
        d.downloadFile("/RPT0101/printData", {}, function() {})
    }
}]);
angular.module("rpt0102Module", ["dmsCommon", "rpt0102Module"]).controller("RPT0102Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0102InitDataModel: null
    };
    a.init = function() {
        a.initData()
    };
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0102InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0102/initData", {}, function(c) {
            a.model.form.RPT0102InitDataModel = c;
            a.model.form.RPT0102InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0102InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0102InitDataModel.timeType = "0";
            a.model.form.RPT0102InitDataModel.reportType = "0"
        })
    };
    a.searchData =
        function() {
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
                function() {})
        };
    a.download = function() {
        d.downloadFile("/RPT0102/printData", {}, function() {})
    }
}]);
angular.module("rpt0103Module", ["dmsCommon", "rpt0103Module"]).controller("RPT0103Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0103InitDataModel: null
    };
    a.init = function() {
        a.initData()
    };
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0103InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0103/initData", {}, function(c) {
            a.model.form.RPT0103InitDataModel = c;
            a.model.form.RPT0103InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0103InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0103InitDataModel.timeType = "0";
            a.model.form.RPT0103InitDataModel.reportType = "0"
        })
    };
    a.searchData =
        function() {
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
                function(a) {
                })
        };
    a.download = function() {
        d.downloadFile("/RPT0103/printData", {}, function(a) {
        })
    }
}]);
angular.module("rpt0104Module", ["dmsCommon", "rpt0104Module"]).controller("RPT0104Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0104InitDataModel: null
    };
    a.init = function() {
        a.initData()
    };
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0104InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0104/initData", {}, function(c) {
            a.model.form.RPT0104InitDataModel = c;
            a.model.form.RPT0104InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0104InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0104InitDataModel.timeType = "0";
            a.model.form.RPT0104InitDataModel.reportType = "0";
        })
    };
    a.searchData = function() {
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
            function(a) {
            })
    };
    a.download = function() {
        d.downloadFile("/RPT0104/printData", {}, function(a) {
        })
    }
}]);
angular.module("rpt0200Module", ["dmsCommon"]).controller("RPT0200Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.createPrintTime = function() {
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
    $("body").click(function() {
        a.model.hidden.showPrintTime = !1;
        a.$apply()
    });
    a.preventClose = function() {
        event.stopPropagation()
    };
    a.init = function() {
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
        function() {
            event.stopPropagation();
            a.model.hidden.showPrintTime = !0
        };
    a.prevMonth = function() {
        var c = angular.copy(parseInt(a.model.hidden.monthSaleCurrent)),
            e = angular.copy(parseInt(a.model.hidden.yearSaleCurrent)),
            c = c - 1;
        0 == c && (c = 12, e -= 1);
        a.model.hidden.lastYear > e ? a.model.hidden.disabledPrev = !0 : (a.model.hidden.disabledPrev = !1, a.model.hidden.disabledNext = !1, 10 > c && (c = "0" + c), a.model.hidden.monthSaleCurrent = c, a.model.hidden.yearSaleCurrent = e, a.searchSalesmanTimesheet())
    };
    a.nextMonth = function() {
        var c = angular.copy(parseInt(a.model.hidden.monthSaleCurrent)),
            e = angular.copy(parseInt(a.model.hidden.yearSaleCurrent)),
            c = c + 1;
        12 < c && (c = 1, e += 1);
        e > a.model.hidden.currentYear || e == a.model.hidden.currentYear && c > a.model.hidden.currentMonth ? a.model.hidden.disabledNext = !0 : (a.model.hidden.disabledNext = !1, a.model.hidden.disabledPrev = !1, 10 > c && (c = "0" + c), a.model.hidden.monthSaleCurrent = c, a.model.hidden.yearSaleCurrent = e, a.searchSalesmanTimesheet())
    };
    a.chooseSale = function(c) {
        !1 == c.choose && a.removeSaleItem(c);
        !0 == c.choose && a.addSaleItem(c)
    };
    a.removeSaleItem = function(c) {
        for (var e =
                0; e < a.model.form.listSelectSalesman.length; e++)
            if (a.model.form.listSelectSalesman[e] == c.salesmanId) {
                a.model.form.listSelectSalesman.splice(e, 1);
                break
            }
        a.checkChooseAll()
    };
    a.addSaleItem = function(c) {
        a.model.form.listSelectSalesman.push(c.salesmanId);
        a.checkChooseAll()
    };
    a.chooseAll = function() {
        if (null != a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult)
            if (!1 == a.model.form.chooseAll)
                for (var c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++) {
                    var e = a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c];
                    e.choose = !1;
                    for (var b = 0; b < a.model.form.listSelectSalesman.length; b++) a.model.form.listSelectSalesman[b] == e.salesmanId && a.model.form.listSelectSalesman.splice(b, 1)
                } else
                    for (c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++) e = a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c], e.choose = !0, a.model.form.listSelectSalesman.push(e.salesmanId)
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length) {
            a.model.form.chooseAll = !0;
            for (var c = 0; c < a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult.length; c++)
                if (!1 == a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult[c].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function() {
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
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseSalesmanItem = function(c) {
        a.model.hidden.currentSalesmanItem = c;
        c = getContextPath() + a.model.hidden.currentSalesmanItem.imagePath;
        a.model.hidden.currentSalesmanItem.urlImg = c;
        a.searchSalesmanTimesheet()
    };
    a.searchSalesmanTimesheet = function() {
        a.searchSalesmanTimesheetData({
            searchInput: {
                clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
                salesmanIdList: [a.model.hidden.currentSalesmanItem.salesmanId],
                yearMonth: a.model.hidden.yearSaleCurrent + "-" + a.model.hidden.monthSaleCurrent
            }
        }, function(c) {
            a.model.form.RPT0200SearchSalesmanTimesheetResult = c
        })
    };
    a.initData = function() {
        d.doPost("/RPT0200/initData", {}, function(c) {
            a.model.form.RPT0200InitDataModel = c
        })
    };
    a.searchData = function() {
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
        }, function(c) {
            a.model.form.RPT0200SearchDataOutputModel = c;
            a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0200SearchDataOutputModel.searchResult.pagingInfo;
            a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult = a.model.form.RPT0200SearchDataOutputModel.searchResult.salesmanSearchResult;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataOnly = function() {
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
        }, function(c) {
            a.model.form.RPT0200SearchDataOutputModel =
                c;
            a.model.form.RPT0200InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0200SearchDataOutputModel.searchResult.pagingInfo;
            a.model.form.RPT0200InitDataModel.resultSearch.salesmanSearchResult = a.model.form.RPT0200SearchDataOutputModel.searchResult.salesmanSearchResult;
            a.checkChooseAllAfterSearch();
            a.model.hidden.currentSalesmanItem = null
        })
    };
    a.print = function() {
        a.printData({
            clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
            salesmanIdList: [a.model.hidden.currentSalesmanItem.salesmanId],
            yearMonth: a.model.hidden.yearSaleCurrent + "-" + a.model.hidden.monthSaleCurrent
        }, function() {})
    };
    a.printAll = function() {
        if (null != a.model.hidden.yearChoose && null != a.model.hidden.monthChoose) {
            var c = angular.copy(a.model.hidden.monthChoose);
            10 > c && (c = "0" + c);
            a.model.hidden.yearMonth = a.model.hidden.yearChoose + "-" + c
        }
        a.printData({
            clientId: a.model.hidden.RPT0200SearchInputModel.searchInput.defaultClientId,
            salesmanIdList: a.model.form.listSelectSalesman,
            yearMonth: a.model.hidden.yearMonth
        }, function() {})
    };
    a.printData =
        function(a, e) {
            d.downloadFile("/RPT0200/printData", a, function(a) {
                (e || angular.noop)(a)
            })
        };
    a.searchSalesmanTimesheetData = function(a, e) {
        d.doPost("/RPT0200/searchSalesmanTimesheet", a, function(a) {
            (e || angular.noop)(a)
        })
    }
}]);
angular.module("rpt0300Module", ["dmsCommon"]).controller("RPT0300Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
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
    a.init = function() {
        a.initData()
    };
    a.changeReportType = function(c) {
        2 == c && a.createSaleLogMonth()
    };
    a.createSaleLogMonth = function() {
        for (var c = new Date(a.model.form.saleLogMonth[0].checkSaleLogIn.month), e = c.getFullYear(), c = c.getMonth() + 1, e = (new Date(e, c, 0)).getDate(), c = 1; c <= e; c++) a.model.form.saleLogMonth[0].checkSaleLogIn.listDate.push({
            day: c,
            value: 5
        });
        a.model.form.saleLogMonth[0].checkSaleLogIn.listDate.push({
            day: "T\u1ed5ng",
            value: 191
        })
    };
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.RPT0300InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0300/initData", {}, function(c) {
            a.model.form.RPT0300InitDataModel = c;
            a.model.form.RPT0300InitDataModel.fromDate = c.initData.fromDate;
            a.model.form.RPT0300InitDataModel.toDate = c.initData.toDate;
            a.model.form.RPT0300InitDataModel.reportType = c.initData.reportType
        })
    };
    a.searchData = function() {
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
        }, function() {})
    };
    a.download = function() {
        d.downloadFile("/RPT0300/printData", {
            fromDate: a.model.form.RPT0300InitDataModel.fromDate,
            toDate: a.model.form.RPT0300InitDataModel.toDate,
            clientId: a.model.form.RPT0300InitDataModel.clientId,
            reportType: 1
        }, function() {})
    }
}]);
angular.module("rpt0400Module", ["dmsCommon", "rpt0400Module", "rpt0401Module"]).controller("RPT0400Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d) {
    a.init = function() {
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
        }, function(c) {
            a.model.form.RPT0400InitDataModel = c;
            a.model.hidden.RPT0400SearchInputModel.searchInput.fromDate = a.model.form.RPT0400InitDataModel.initData.fromDate;
            a.model.hidden.RPT0400SearchInputModel.searchInput.toDate = a.model.form.RPT0400InitDataModel.initData.toDate;
            if (null != a.model.form.RPT0400InitDataModel.initData.clientItem) a.model.hidden.RPT0400SearchInputModel.searchInput.clientId = a.model.form.RPT0400InitDataModel.initData.clientItem[0].itemId
        })
    };
    a.validate = function() {
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
    a.chooseArea = function(c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseClient = function() {
        var c = TextUtil.toString(a.model.hidden.RPT0400SearchInputModel.searchInput.clientId);
        null != c && d.doPost("/RPT0400/clientChange", c, function(c) {
            a.model.form.RPT0400InitDataModel.initData.rivalItem = c.initData.rivalItem;
            a.model.form.RPT0400InitDataModel.initData.productTypeItem = c.initData.productTypeItem
        })
    };
    a.initData = function(a, e) {
        d.doPost("/RPT0400/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.searchData = function() {
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
            d.doPost("/RPT0400/searchData", c, function(c) {
                a.model.form.RPT0400SearchDataOutputModel = c;
                a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo = c.searchResult.pagingInfo
            })
        }
    };
    a.searchDataOnly = function() {
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
                function(c) {
                    a.model.form.RPT0400SearchDataOutputModel = c;
                    if (null != a.model.form.RPT0400SearchDataOutputModel.searchResult) a.model.form.RPT0400InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0400SearchDataOutputModel.searchResult.pagingInfo
                })
        }
    };
    a.download = function() {
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
            d.downloadFile("/RPT0400/printData", c, function() {})
        }
    }
}]);
angular.module("rpt0401Module", ["dmsCommon", "rpt0401Module"]).controller("RPT0401Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hiden: {}
    };
    a.model.form = {
        RPT0101InitDataModel: null
    };
    a.init = function() {};
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0101InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0401/initData", {}, function(c) {
            a.model.form.RPT0101InitDataModel = c;
            a.model.form.RPT0101InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0101InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0101InitDataModel.timeType = "0";
            a.model.form.RPT0101InitDataModel.reportType = "0";
        })
    };
    a.searchData = function() {
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
            function(a) {
            })
    };
    a.download = function() {
        d.downloadFile("/RPT0401/printData", {}, function(a) {
        })
    }
}]);
angular.module("rpt0500Module", ["dmsCommon"]).controller("RPT0500Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.init = function() {
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
        a.initData({}, function(c) {
            a.model.form.RPT0500InitDataModel = c;
            a.model.hidden.RPT0500SearchInputModel.searchInput.fromDate = a.model.form.RPT0500InitDataModel.initData.fromDate;
            a.model.hidden.RPT0500SearchInputModel.searchInput.toDate =
                a.model.form.RPT0500InitDataModel.initData.toDate
        })
    };
    a.validate = function() {
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
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.chooseArea = function(c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.initData = function(a, e) {
        d.doPost("/RPT0500/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.searchData = function() {
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
            d.doPost("/RPT0500/searchData", c, function(c) {
                a.model.form.RPT0500SearchDataOutputModel = c;
                a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo =
                    a.model.form.RPT0500SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.currentTimeType = angular.copy(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType);
                a.model.hidden.timeType = a.model.hidden.RPT0500SearchInputModel.searchInput.timeType;
                a.model.hidden.reportType = a.model.hidden.RPT0500SearchInputModel.searchInput.reportType
            })
        }
    };
    a.searchDataOnly = function() {
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
            d.doPost("/RPT0500/searchData", c, function(c) {
                a.model.form.RPT0500SearchDataOutputModel = c;
                a.model.hidden.currentTimeType = angular.copy(a.model.hidden.RPT0500SearchInputModel.searchInput.timeType);
                a.model.form.RPT0500InitDataModel.resultSearch.pagingInfo = a.model.form.RPT0500SearchDataOutputModel.searchResult.pagingInfo;
                a.model.hidden.timeType = a.model.hidden.RPT0500SearchInputModel.searchInput.timeType
            })
        }
    };
    a.download = function() {
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
            d.downloadFile("/RPT0500/printData", c, function() {})
        }
    }
}]);
angular.module("sal0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner","sal0110Module"]).controller("SAL0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {
            hidden: {
                showModalResetPassword: !1,
                showModalEditUser: !1,
                showImportMrs: !1,
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                }
            }
        };
        a.model.form = {
            SAL0100InitDataModel: null,
            searchParam: {
                searchInput: {
                    clientId: null,
                    storeName: "",
                    salesmanCode: "",
                    salesmanName: "",
                    salesmanSts: null,
                    storeCode: ""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            SAL0100SearchDataResult: null
        };
        a.$on("SAL0100#closeImportMrs",
            function() {
                a.model.hidden.showImportMrs = !1
            });
        a.initData()
    };
    a.search = function() {
        a.searchDataOnly()
    };
    a.importMrs = function() {
      a.model.hidden.showImportMrs = !0
    };


    a.prevPage = function() {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.deleteSale = function(b) {
        param = {
            salesmanId: b.salesmanId
        };
        d.doPost("/SAL0100/deleteSalman", param, function(b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
            a.searchDataOnly()
        })
    };
    a.activeSal = function(b) {
        param = {
            salesmanId: b.salesmanId,
            salesmanCode: b.salesmanCode
        };
        d.doPost("/SAL0100/activatSalman", param, function(b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
            a.searchDataOnly()
        })
    };
    a.showModalPasswordReset = function() {
        a.model.hidden.showModalResetPassword = !0
    };
    a.showModalEditUser = function() {
        a.model.hidden.showModalEditUser = !0
    };
    a.initData = function() {
        d.doPost("/SAL0100/initData", {}, function(b) {
            a.model.form.SAL0100InitDataModel = b;
            if (null != a.model.form.SAL0100InitDataModel.resultSearch.salInfo)
                for (b = 0; b < a.model.form.SAL0100InitDataModel.resultSearch.salInfo.length; b++) {
                    var c = a.model.form.SAL0100InitDataModel.resultSearch.salInfo[b];
                    c.imagePathUrl = getContextPath() + c.imagePath
                }
        })
    };
    a.searchData = function() {
        d.doPost("/SAL0100/searchData", {
            searchInput: {
                clientId: a.model.form.searchParam.searchInput.clientId,
                storeCode: a.model.form.searchParam.searchInput.storeCode,
                storeName: a.model.form.searchParam.searchInput.storeName,
                salesmanCode: a.model.form.searchParam.searchInput.salesmanCode,
                salesmanName: a.model.form.searchParam.searchInput.salesmanName,
                salesmanSts: a.model.form.searchParam.searchInput.salesmanSts
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo ?
                    a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
            a.model.form.SAL0100SearchDataResult = b;
            a.model.form.SAL0100InitDataModel.resultSearch.salInfo = a.model.form.SAL0100SearchDataResult.resultSearch.salInfo;
            if (null != a.model.form.SAL0100InitDataModel.resultSearch.salInfo)
                for (b = 0; b < a.model.form.SAL0100InitDataModel.resultSearch.salInfo.length; b++) {
                    var c =
                        a.model.form.SAL0100InitDataModel.resultSearch.salInfo[b];
                    c.imagePathUrl = getContextPath() + c.imagePath
                }
            a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo = a.model.form.SAL0100SearchDataResult.resultSearch.pagingInfo
        })
    };
    a.searchDataOnly = function() {
        d.doPost("/SAL0100/searchData", {
            searchInput: {
                clientId: a.model.form.searchParam.searchInput.clientId,
                storeCode: a.model.form.searchParam.searchInput.storeCode,
                storeName: a.model.form.searchParam.searchInput.storeName,
                salesmanCode: a.model.form.searchParam.searchInput.salesmanCode,
                salesmanName: a.model.form.searchParam.searchInput.salesmanName,
                salesmanSts: a.model.form.searchParam.searchInput.salesmanSts
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo ?
                    a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo ? a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
            a.model.form.SAL0100SearchDataResult = b;
            a.model.form.SAL0100InitDataModel.resultSearch.salInfo =
                a.model.form.SAL0100SearchDataResult.resultSearch.salInfo;
            a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo = a.model.form.SAL0100SearchDataResult.resultSearch.pagingInfo;
            if (null != a.model.form.SAL0100InitDataModel.resultSearch.salInfo)
                for (b = 0; b < a.model.form.SAL0100InitDataModel.resultSearch.salInfo.length; b++) {
                    var c = a.model.form.SAL0100InitDataModel.resultSearch.salInfo[b];
                    c.imagePathUrl = getContextPath() + c.imagePath
                }
        })
    }
}]);

angular.module("sal0110Module", ["dmsCommon", "toaster"]).controller("SAL0110Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function(a, d, c, e, b) {
    a.init = function() {
        a.model = {
            hidden: {
                rivalMode: !1
            }
        };
        a.model.form = {
            file: null,
            fileData: null,
            files: null
        };
    };
    a.chooseFile = function() {
        // event.stopPropagation();
        angular.element("#SAL0110ChooseFile").click()
    };
    a.closeImportMrs = function() {
        c.$broadcast("SAL0100#closeImportMrs", {})
    };
    a.getFile = function(b) {
        a.model.form.file = b
    };
    a.setFiles = function(b) {
        a.$apply(function() {
            a.files = [];
            for (var c = 0; c < b.files.length; c++) a.files.push(b.files[c])
        })
    };
    a.upload = function() {
        var  f = {
                clientId: a.model.hidden.clientId
                };
        d.uploadFile("/SAL0120", a.model.form.file, f, function(f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("SAL0100#closeImportStore", {})))

            if (null != f.proResult.proFlg && "OK" == f.proResult.proFlg) window.location.href =
                getContextPath() + "/SAL0100/"


        })
    }
}]);



angular.module("sal0300Module", "dmsCommon,fcsa-number,toaster,sal0310Module,sal0320Module,sal0330Module,sal0340Module,ngLoadingSpinner".split(",")).controller("SAL0300Ctrl", ["$scope", "$rootScope", "serverService", "toaster", function(a, d, c, e) {
    a.model = {
        hidden: {
            no_img: getContextPathImageDefault() + "/img/no_img.png",
            showSAL0310: !1,
            showSAL0320: !1,
            salesmanId: null,
            salesmanCode: null,
            imageUrl: null
        }
    };
    a.model.form = {
        viewCustomer: null,
        selectedRegion: 0
    };
    a.init = function() {
        a.model.hidden.salesmanId = angular.element("#salesmanId").val();
        a.model.hidden.salesmanCode = angular.element("#salesmanCode").val();
        a.model.hidden.imageUrl = getContextPath() + angular.element("#imageSale").val();
        a.$on("SAL0300#showSAL3010", function(b, c) {
            a.model.hidden.showSAL0310 = c.showSAL0310
        });
        a.$on("SAL0300#showSAL0320", function(b, c) {
            a.model.hidden.showSAL0320 = c.showSAL0320
        });
        a.$on("SAL0300#closeResetPasswordAfterChange", function(b, c) {
            a.model.hidden.showSAL0310 = c.showModalResetPassword;
            e.pop("success", c.message, null, "trustedHtml")
        })
    };
    a.showPopupDetail = function(b) {
        a.model.hidden.activeRow =
            b;
        a.model.hidden.showPopupDetail = !0
    };
    a.resetPasswordSale = function() {
        a.model.hidden.showSAL0310 = !0
    };
    a.showModalEditSale = function() {
        a.model.hidden.showSAL0320 = !0
    }
}]);
angular.module("sal0310Module", ["dmsCommon", "fcsa-number"]).controller("SAL0310Ctrl", ["$scope", "serverService", "$rootScope", function(a, d, c) {
    a.resetPinData = function(a, b) {
        d.doPost("/SAL0310/resetPin", a, function(a) {
            (b || angular.noop)(a)
        })
    };
    a.model = {
        hidden: {
            showSAL0310: !1,
            salesmanCode: null,
            salesmanId: null,
            validated: {
                isErrored: !1,
                password: {
                    isErrored: !1,
                    msg: ""
                },
                rePassword: {
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
        CLI0310ResetPassword: {
            pinCode: null,
            pinCodeConfirm: null
        },
        SAL0310ResetPasswordResult: null
    };
    a.model.hidden.salesmanId = angular.element("#salesmanId").val();
    a.model.hidden.salesmanCode = angular.element("#salesmanCode").val();
    a.init = function() {};
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            password: {
                isErrored: !1,
                msg: ""
            },
            rePassword: {
                isErrored: !1,
                msg: ""
            },
            checkPassword: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.CLI0310ResetPassword.pinCode)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.password.msg =
            Messages.getMessage("E0000004", "SAL0310_PASSWORD");
        if (!ValidateUtil.isValidTextRequired(a.model.form.CLI0310ResetPassword.pinCodeConfirm)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.rePassword.msg = Messages.getMessage("E0000004", "SAL0310_CONFIRM_PASSWORD");
        if (a.model.form.CLI0310ResetPassword.pinCode != a.model.form.CLI0310ResetPassword.pinCodeConfirm) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkPassword.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.checkPassword.msg = Messages.getMessage("E0000005")
    };
    a.closePassword = function() {
        a.model.hidden.showSAL0310 = !1;
        c.$broadcast("SAL0300#showSAL3010", {
            showSAL0310: a.model.hidden.showSAL0310
        })
    };
    a.resetPassword = function() {
        param = {
            salesmanCode: a.model.hidden.salesmanCode,
            salesmanId: a.model.hidden.salesmanId,
            pinCode: a.model.form.CLI0310ResetPassword.pinCode
        };
        a.validate();
        !0 != a.model.hidden.validated.isErrored &&
            a.resetPinData(param, function(e) {
                a.model.form.SAL0310ResetPasswordResult = e;
                null != a.model.form.SAL0310ResetPasswordResult.proResult && "OK" == a.model.form.SAL0310ResetPasswordResult.proResult.proFlg && c.$broadcast("SAL0300#closeResetPasswordAfterChange", {
                    showModalResetPassword: !1,
                    message: a.model.form.SAL0310ResetPasswordResult.proResult.message
                })
            })
    }
}]);
angular.module("sal0320Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("SAL0320Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.updateSalesmanData = function(a, c) {
        d.doPost("/SAL0320/updateSalesman", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {
            hidden: {
                showSAL0320: null,
                validated: {
                    isErrored: !1,
                    salesmanName: {
                        isErrored: !1,
                        msg: ""
                    },
                    email: {
                        isErrored: !1,
                        msg: ""
                    },
                    checkEmail: {
                        isErrored: !1,
                        msg: ""
                    },
                    mobile: {
                        isErrored: !1,
                        msg: ""
                    },
                    birthday: {
                        isErrored: !1,
                        msg: ""
                    },
                    activeDate: {
                        isErrored: !1,
                        msg: ""
                    }
                }
            }
        };
        a.model.form = {
            SAL0320UpdateSaleResult: null,
            SAL0320UpdateSaleInputModel: {
                salesmanId: null,
                salesmanCode: null,
                salesmanName: null,
                email: null,
                mobile: null,
                location: null,
                gender: null,
                jobTitle:null,
                gcmRegisId: null,
                imei: null
            }
        };
        a.model.form.SAL0320UpdateSaleInputModel.salesmanId = angular.element("#salesmanId").val();
        a.model.form.SAL0320UpdateSaleInputModel.salesmanCode = angular.element("#salesmanCode").val();
        a.model.form.SAL0320UpdateSaleInputModel.salesmanName = angular.element("#salesmanName").val();
        a.model.form.SAL0320UpdateSaleInputModel.email = angular.element("#email").val();
        a.model.form.SAL0320UpdateSaleInputModel.mobile = angular.element("#mobile").val();
        a.model.form.SAL0320UpdateSaleInputModel.location = angular.element("#location").val();
        a.model.form.SAL0320UpdateSaleInputModel.gender = angular.element("#gender").val();
        a.model.form.SAL0320UpdateSaleInputModel.jobTitle = angular.element("#jobTitle").val();
        a.model.form.SAL0320UpdateSaleInputModel.imei = angular.element("#imei").val()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            salesmanName: {
                isErrored: !1,
                msg: ""
            },
            email: {
                isErrored: !1,
                msg: ""
            },
            checkEmail: {
                isErrored: !1,
                msg: ""
            },
            mobile: {
                isErrored: !1,
                msg: ""
            }

        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.SAL0320UpdateSaleInputModel.salesmanName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.salesmanName.isErrored = !0, a.model.hidden.validated.salesmanName.msg = Messages.getMessage("E0000004", "SAL0320_LABEL_SALE_NAME");
        if (!ValidateUtil.isValidTextRequired(a.model.form.SAL0320UpdateSaleInputModel.email)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.email.isErrored = !0, a.model.hidden.validated.email.msg = Messages.getMessage("E0000004", "SAL0320_LABEL_SALE_EMAIL");
        if (!ValidateUtil.isValidEmail(a.model.form.SAL0320UpdateSaleInputModel.email)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkEmail.isErrored = !0, a.model.hidden.validated.checkEmail.msg = Messages.getMessage("E0000020");

    };
    a.closeEdit = function() {
        a.model.hidden.showSAL0320 = !1;
        c.$broadcast("SAL0300#showSAL0320", {
            showSAL0320: a.model.hidden.showSAL0320
        })
    };
    a.updateSale = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            salesmanId: a.model.form.SAL0320UpdateSaleInputModel.salesmanId,
            salesmanCode: a.model.form.SAL0320UpdateSaleInputModel.salesmanCode,
            salesmanName: a.model.form.SAL0320UpdateSaleInputModel.salesmanName,
            email: a.model.form.SAL0320UpdateSaleInputModel.email,
            mobile: a.model.form.SAL0320UpdateSaleInputModel.mobile,
            location: a.model.form.SAL0320UpdateSaleInputModel.location,
            gender: a.model.form.SAL0320UpdateSaleInputModel.gender,
            jobTitle: a.model.form.SAL0320UpdateSaleInputModel.jobTitle,
            imei: a.model.form.SAL0320UpdateSaleInputModel.imei
        }, a.updateSalesmanData(param, function(b) {
            a.model.form.SAL0320UpdateSaleResult = b.proResult;
            "NG" == a.model.form.SAL0320UpdateSaleResult.proFlg ? e.pop("error", a.model.form.SAL0330addStoreResult.message, null, "trustedHtml") : window.location.href = getContextPath() + "/SAL0300/" + a.model.form.SAL0320UpdateSaleInputModel.salesmanCode
        }))
    }
}]);
angular.module("sal0330Module", ["dmsCommon", "toaster"]).controller("SAL0330Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                },
                areaId: null,
                areaIdNotAssign: null,
                defaultAreaName: Messages.getMessage("SAL0330_LABEL_REGION_CHOOSE"),
                defaultAreaNameNotAssign: Messages.getMessage("SAL0330_LABEL_REGION_CHOOSE")
            }
        };
        a.model.form = {
            chooseAll: !1,
            SAL0330InitOutputModel: null,
            SAL0330ResultSearchModel: null,
            SAL0330SearchData: {
                searchInput: {
                    salesmanId: 0,
                    storeCode: "",
                    storeName: "",
                    areaId: null
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 0,
                    rowNumber: 0
                }
            },
            SAL0330ResultSearchNotAssignModel: {
                resultStoreNotAssign: {
                    searchInput: {
                        salesmanId: 0,
                        storeCode: "",
                        storeName: "",
                        areaId: null
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            },
            SAL0330SearchDataStoreNotAssign: {
                searchInput: {
                    salesmanId: 0,
                    storeCode: "",
                    storeName: "",
                    areaId: null
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            defaultUserId: null,
            SAL0330CreateResultDto: null,
            SAL0330DeleteResultDto: null,
            listSelectStore: []
        };
        a.model.hidden.salesmanId = angular.element("#salesmanId").val();
        a.initData({
            salesmanId: a.model.hidden.salesmanId
        }, function(b) {
            a.model.form.SAL0330InitOutputModel = b
        })
        a.searchStoreNotAssign();
    };
    a.chooseArea = function(b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.hidden.areaId = c
    };
    a.chooseAreaNotAssign = function(b, c) {
        a.model.hidden.defaultAreaNameNotAssign = b;
        a.model.hidden.areaIdNotAssign = c
    };
    a.searchStore = function() {
        a.searchDataStoreOnly()
    };
    a.prevPageStore = function() {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchDataStore()
    };
    a.nextPageStore = function() {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataStore()
    };
    a.startPageStore = function() {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataStore()
    };
    a.endPageStore = function() {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataStore()
    };
    a.searchStoreNotAssign = function() {
        a.searchDataStoreNotAssignOnly()
    };
    a.prevPageStoreNotAssign = function() {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage -= 1;
        a.searchDataStoreNotAssign()
    };
    a.nextPageStoreNotAssign = function() {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage += 1;
        a.searchDataStoreNotAssign()
    };
    a.startPageStoreNotAssign = function() {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage = 1;
        a.searchDataStoreNotAssign()
    };
    a.endPageStoreNotAssign = function() {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage =
            a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages;
        a.searchDataStoreNotAssign()
    };
    a.addStore = function() {
        a.addStoreData({
            salesmanId: a.model.hidden.salesmanId,
            storeIdList: a.model.form.listSelectStore
        }, function(b) {
            a.model.form.SAL0330CreateResultDto = b.proResult;
            a.model.form.listSelectStore = [];
            a.searchDataStoreNotAssign();
            a.searchStore();
            null != a.model.form.SAL0330CreateResultDto && ("NG" == a.model.form.SAL0330CreateResultDto.proFlg ? e.pop("error", a.model.form.SAL0330CreateResultDto.message,
                null, "trustedHtml") : e.pop("success", a.model.form.SAL0330CreateResultDto.message, null, "trustedHtml"))
        })
    };
    a.deleteStore = function(b) {
        a.deleteUserStoresmanData({
            salesmanId: a.model.hidden.salesmanId,
            storeId: b.storeId
        }, function(b) {
            a.model.form.SAL0330DeleteResultDto = b;
            a.searchDataStore()
        })
    };
    a.chooseStore = function(b) {
        !1 == b.choose && a.removeStoreItem(b);
        !0 == b.choose && a.addStoreItem(b)
    };
    a.removeStoreItem = function(b) {
        for (var c = 0; c < a.model.form.listSelectStore.length; c++)
            if (a.model.form.listSelectStore[c] == b.storeId) {
                a.model.form.listSelectStore.splice(c,
                    1);
                break
            }
        a.checkChooseAll()
    };
    a.addStoreItem = function(b) {
        a.model.form.listSelectStore.push(b.storeId);
        a.checkChooseAll()
    };
    a.chooseAll = function() {
        if (null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++) {
                    var c = a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b];
                    c.choose = !1;
                    for (var e = 0; e < a.model.form.listSelectStore.length; e++) a.model.form.listSelectStore[e] ==
                        c.storeId && a.model.form.listSelectStore.splice(e, 1)
                } else
                    for (b = 0; b < a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++) c = a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b], c.choose = !0, a.model.form.listSelectStore.push(c.storeId)
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++)
                if (!1 ==
                    a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function() {
        // if (null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo) {
        //     for (var b = 0; b < a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo.length; b++) {
        //         var c = a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.storeInfo[b];
        //         c.choose = !1;
        //         for (var e = 0; e < a.model.form.listSelectStore.length; e++)
        //             if (a.model.form.listSelectStore[e] ==
        //                 c.storeId) c.choose = !0
        //     }
        //     //a.checkChooseAll()
        // }else{
        //      a.model.form.listSelectStore = [];
        //      a.model.form.chooseAll = 1;
        // }
         a.model.form.listSelectStore = [];
         a.model.form.chooseAll = 1;
    };
    a.initData = function(a, c) {
        d.doPost("/SAL0330/initData", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.searchDataStore = function() {
        param = {
            searchInput: {
                salesmanId: a.model.hidden.salesmanId,
                storeCode: a.model.form.SAL0330SearchData.searchInput.storeCode,
                storeName: a.model.form.SAL0330SearchData.searchInput.storeName,
                areaId: a.model.hidden.areaId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/SAL0330/searchStoreAssigned", param, function(b) {
            a.model.form.SAL0330ResultSearchModel = b;
            a.model.form.SAL0330InitOutputModel.resultSearch.storeInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreOnly = function() {
        param = {
            searchInput: {
                salesmanId: a.model.hidden.salesmanId,
                storeCode: a.model.form.SAL0330SearchData.searchInput.storeCode,
                storeName: a.model.form.SAL0330SearchData.searchInput.storeName,
                areaId: a.model.hidden.areaId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo ? a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/SAL0330/searchStoreAssigned", param, function(b) {
            a.model.form.SAL0330ResultSearchModel = b;
            a.model.form.SAL0330InitOutputModel.resultSearch.storeInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreNotAssign = function() {
        param = {
            searchInput: {
                salesmanId: a.model.hidden.salesmanId,
                storeCode: a.model.form.SAL0330SearchDataStoreNotAssign.searchInput.storeCode,
                storeName: a.model.form.SAL0330SearchDataStoreNotAssign.searchInput.storeName,
                areaId: a.model.hidden.areaIdNotAssign
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ?
                    a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/SAL0330/searchStoreNotAssign", param, function(b) {
            a.model.form.SAL0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataStoreNotAssignOnly = function() {
        param = {
            searchInput: {
                salesmanId: a.model.hidden.salesmanId,
                storeCode: a.model.form.SAL0330SearchDataStoreNotAssign.searchInput.storeCode,
                storeName: a.model.form.SAL0330SearchDataStoreNotAssign.searchInput.storeName,
                areaId: a.model.hidden.areaIdNotAssign
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo ? a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/SAL0330/searchStoreNotAssign", param, function(b) {
            a.model.form.SAL0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.addStoreData = function(a, c) {
        d.doPost("/SAL0330/addStore", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.deleteUserStoresmanData = function(a, c) {
        d.doPost("/SAL0330/deleteStore", a, function(a) {
            (c || angular.noop)(a)
        })
    }
}]);
angular.module("sal0340Module", ["dmsCommon"]).controller("SAL0340Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.searchSaleLeaveData = function(a, e) {
        d.doPost("/SAL0340/searchData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.initDate = function() {
        var c = new Date,
            e = c.getDate(),
            b = c.getMonth() + 1,
            f = c.getFullYear();
        10 > e && (e = "0" + e);
        10 > b && (b = "0" + b);
        var d = c.getMonth() + 2,
            c = c.getFullYear();
        13 == d && (d = "01", c += 1);
        10 > d && (d = "0" + d);
        var g = (new Date(c, d, 0)).getDate();
        a.model.hidden.SAL0340SearchInputModel.searchInput.startDate =
            e + "-" + b + "-" + f;
        a.model.hidden.SAL0340SearchInputModel.searchInput.endDate = g + "-" + d + "-" + c
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                salesmanId: null,
                SAL0340SearchInputModel: {
                    searchInput: {
                        salesmanId: null,
                        startDate: null,
                        endDate: null
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                }
            }
        };
        a.model.form = {
            SAL0340initModalResult: {
                resultSearch: {
                    pagingInfo: null,
                    salLeave: null
                }
            }
        };
        a.model.hidden.salesmanId = angular.element("#salesmanId").val();
        a.initDate()
    };
    a.prevPage = function() {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchSaleLeave()
    };
    a.nextPage = function() {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage += 1;
        a.searchSaleLeave()
    };
    a.startPage = function() {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage = 1;
        a.searchSaleLeave()
    };
    a.endPage = function() {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage = a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlPages;
        a.searchSaleLeave()
    };
    a.searchSaleLeave = function() {
        param = {
            searchInput: {
                salesmanId: a.model.hidden.salesmanId,
                startDate: a.model.hidden.SAL0340SearchInputModel.searchInput.startDate,
                endDate: a.model.hidden.SAL0340SearchInputModel.searchInput.endDate
            },
            pagingInfo: {
                ttlRow: null != a.model.form.SAL0340initModalResult.resultSearch.pagingInfo ? a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.SAL0340initModalResult.resultSearch.pagingInfo ? a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.SAL0340initModalResult.resultSearch.pagingInfo ?
                    a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.rowNumber : 0
            }
        };
        a.searchSaleLeaveData(param, function(c) {
            a.model.form.SAL0340initModalResult = c
        })
    }
}]);
angular.module("sal0401Module", ["dmsCommon", "google-maps".ns()]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("SAL0401Ctrl", ["$scope", "serverService", "$rootScope", "GoogleMapApi".ns(), function(a, d, c, e) {
    a.searchDataSalmanAttendaceData = function(a, c) {
        d.doPost("/CLI0400/searchDataSalmanAttendace", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    e.then(function() {});
    a.getCurrentDay = function() {
        var a = new Date,
            c = a.getDate(),
            e = a.getMonth() +
            1,
            a = a.getFullYear();
        10 > c && (c = "0" + c);
        10 > e && (e = "0" + e);
        return c + "-" + e + "-" + a
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
                attencanceDate: a.getCurrentDay(),
                clientId: null,
                salesmanCode: a.$parent.model.form.currentSaleChoose.salesmanCode,
                salesmanName: a.$parent.model.form.currentSaleChoose.salesmanName,
                indexPositionChoose: 0
            }
        };
        a.model.form = {};
        a.map = {};
        a.randomMarkers = [];
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("SAL0401#search",
            function(b, c) {
                a.model.hidden.salesmanId = c.saleChoose.salesmanId;
                a.model.hidden.salesmanCode = c.saleChoose.salesmanCode;
                a.model.hidden.salesmanName = c.saleChoose.salesmanName;
                a.model.hidden.indexPositionChoose = 0;
                a.randomMarkers = [];
                a.searchDataSalmanAttendace()
            })
    };
    a.search = function() {
        a.searchDataSalmanAttendace()
    };
    a.searchDataSalmanAttendace = function() {
        param = {
            clientId: a.model.hidden.clientId,
            salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
            attencanceDate: a.model.hidden.attencanceDate
        };
        a.searchDataSalmanAttendaceData(param,
            function(b) {
                a.model.form.CLI0400DataSalmanLeaveResult = b;
                if (null != a.model.form.CLI0400DataSalmanLeaveResult.resultSearch.searchSalAttendanceList)
                    for (b = 0; b < a.model.form.CLI0400DataSalmanLeaveResult.resultSearch.searchSalAttendanceList.length; b++) {
                        var c = a.model.form.CLI0400DataSalmanLeaveResult.resultSearch.searchSalAttendanceList[b];
                        c.imagePathUrl = getContextPath() + c.imagePath
                    }
                null != a.model.form.CLI0400DataSalmanLeaveResult.resultSearch.searchSalAttendanceList && 0 < a.model.form.CLI0400DataSalmanLeaveResult.resultSearch.searchSalAttendanceList.length &&
                    a.checkshowMapPosition(a.model.form.CLI0400DataSalmanLeaveResult.resultSearch.searchSalAttendanceList)
            })
    };
    a.checkshowMapPosition = function(b) {
        a.randomMarkers = [];
        a.map = {
            center: {
                latitude: b[0].latVal,
                longitude: b[0].longVal
            },
            zoom: 15
        };
        for (var c = 0; c < b.length; c++) {
            var e = "",
                e = e + " (" + b[c].attendanceTypeName + ": " + b[c].time + ")";
            a.randomMarkers.push({
                latitude: b[c].latVal,
                longitude: b[c].longVal,
                showWindow: !1,
                idKey: a.model.hidden.salesmanCode + "-" + c,
                popupInfo: b[c].storeName + e
            })
        }
        a.randomMarkers.forEach(function(b) {
            b.onClicked =
                function() {
                    a.onMarkerClicked(b)
                };
            b.closeClick = function() {
                b.showWindow = !1;
                a.$apply()
            }
        })
    };
    a.$watchCollection("model.hidden.attencanceDate", function() {
        a.searchDataSalmanAttendace()
    });
    a.onMarkerClicked = function(b) {
        markerToClose = b;
        b.showWindow = !0;
        a.$apply()
    };
    a.choosePosition = function(b, c) {
        a.model.hidden.indexPositionChoose = c;
        a.map = {
            center: {
                latitude: b.latVal,
                longitude: b.longVal
            },
            zoom: 15
        }
    }
}]);
angular.module("sal0402Module", ["dmsCommon"]).controller("SAL0402Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.searchBillSalesmanData = function(a, e) {
        d.doPost("/CLI0400/searchBillSalesman", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.getCurrentDay = function() {
        var a = new Date,
            e = a.getDate(),
            b = a.getMonth() + 1,
            a = a.getFullYear();
        10 > e && (e = "0" + e);
        10 > b && (b = "0" + b);
        return e + "-" + b + "-" + a
    };
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {
                searchBillSalesman: a.getCurrentDay(),
                clientId: null,
                salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId
            }
        };
        a.model.form = {
            CLI0400searchBillSalesmanResult: null
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("SAL0402#search", function() {
            a.searchBillSalesman()
        })
    };
    a.search = function() {
        a.searchBillSalesman()
    };
    a.searchBillSalesman = function() {
        param = {
            clientId: a.model.hidden.clientId,
            salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
            selectDate: a.model.hidden.searchBillSalesman
        };
        a.searchBillSalesmanData(param, function(c) {
            a.model.form.CLI0400searchBillSalesmanResult = c;
            if (null != a.model.form.CLI0400searchBillSalesmanResult.resultSearch)
                for (c =
                    0; c < a.model.form.CLI0400searchBillSalesmanResult.resultSearch.searchBillSalesman.length; c++) {
                    var e = a.model.form.CLI0400searchBillSalesmanResult.resultSearch.searchBillSalesman[c];
                    if (null != e.pathPhoto1) e.photoBillUrl1 = getContextPath() + e.pathPhoto1;
                    if (null != e.pathPhoto2) e.photoBillUrl2 = getContextPath() + e.pathPhoto2
                }
        })
    };
    a.$watchCollection("model.hidden.searchBillSalesman", function() {
        a.searchBillSalesman()
    })
}]);
angular.module("sal0403Module", ["dmsCommon"]).controller("SAL0403Ctrl", ["$scope", "serverService", "$rootScope", function(a) {
    a.init = function() {
        a.model = {};
        a.model = {
            hidden: {}
        };
        a.model.form = {};
        a.model.hidden.clientId = angular.element("#clientId").val()
    }
}]);
angular.module("sal0404Module", ["dmsCommon", "ui.calendar"]).controller("SAL0404Ctrl", ["$scope", "serverService", "$rootScope", "uiCalendarConfig", function(a, d, c, e) {
    a.searchDataSalmanLeaveData = function(a, c) {
        d.doPost("/CLI0400/searchDataSalmanLeave", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.events = [];
        a.model = {
            hidden: {
                salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
                clientId: null,
                selectedDate: null,
                dateShow: null
            }
        };
        a.model.form = {};
        a.changeView = function(a) {
            e.calendars.myCalendar.fullCalendar("changeView",
                a)
        };
        a.renderCalender = function() {
            e.calendars.myCalendar && e.calendars.myCalendar.fullCalendar("render")
        };
        a.eventSources = [a.events];
        a.uiConfig = {
            calendar: {
                height: 450,
                editable: !1,
                lang: "vi",
                header: {
                    left: "title",
                    center: "",
                    right: "today prev,next"
                },
                buttonText: {
                    today: "H\u00f4m nay",
                    month: "Th\u00e1ng",
                    week: "Tu\u1ea7n",
                    day: "Ng\u00e0y"
                },
                viewRender: function(b) {
                    var c = b.intervalStart._d,
                        c = new Date(c),
                        b = c.getDate(),
                        e = c.getMonth() + 1,
                        c = c.getFullYear();
                    10 > b && (b = "0" + b);
                    10 > e && (e = "0" + e);
                    b = b + "-" + e + "-" + c;
                    a.model.hidden.dateShow =
                        b;
                    a.searchDataSalmanLeave(b)
                }
            }
        };
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("SAL0404#search", function() {
            a.searchDataSalmanLeave(a.model.hidden.dateShow)
        })
    };
    a.searchDataSalmanLeave = function(b) {
        param = {
            salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
            selectedDate: b
        };
        a.searchDataSalmanLeaveData(param, function(b) {
            for (; 0 < a.events.length;) a.events.splice(0, 1);
            a.model.form.CLI0400SearchDataSalmanLeaveResult = b;
            0 < a.model.form.CLI0400SearchDataSalmanLeaveResult.resultSearch.searchSalLeave.length &&
                a.addEvent(a.model.form.CLI0400SearchDataSalmanLeaveResult.resultSearch.searchSalLeave)
        })
    };
    a.addEvent = function(b) {
        for (var c = 0; c < b.length; c++) event = {
            title: b[c].contText,
            start: new Date(b[c].leaveDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")),
            end: new Date(b[c].leaveDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"))
        }, a.events.push(event);
        a.eventSources = [a.events];
        a.renderCalender()
    }
}]);
angular.module("set0100Module", ["dmsCommon", "set0110Module", "set0120Module", "set0130Module"]).controller("SET0100Ctrl", ["$scope", "serverService", "$rootScope", function(a) {
    a.init = function() {
        a.model = {
            hidden: {
                activeTab: 3
            }
        }
    }
}]);
angular.module("set0110Module", ["dmsCommon"]).controller("SET0110Ctrl", ["$scope", "serverService", "$rootScope", function(a, d, c) {
    a.init = function() {
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
    a.addRegion = function() {
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
angular.module("set0120Module", ["dmsCommon"]).controller("SET0120Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
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
    a.init = function() {
        a.initData()
    };
    a.search = function() {
        a.searchData()
    };
    a.prevPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.RPT0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function() {
        d.doPost("/RPT0100/initData", {}, function(c) {
            a.model.form.RPT0100InitDataModel = c;
            a.model.form.RPT0100InitDataModel.fromDate = "2014-12-01";
            a.model.form.RPT0100InitDataModel.toDate = "2014-12-31";
            a.model.form.RPT0100InitDataModel.timeType =
                "0";
            a.model.form.RPT0100InitDataModel.reportType = "0"
        })
    };
    a.searchData = function() {
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
        }, function() {})
    };
    a.download = function() {
        d.downloadFile("/RPT0100/printData", {}, function() {})
    }
}]);
angular.module("set0130Module", ["dmsCommon", "toaster"]).controller("SET0130Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
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
        a.initData({}, function(b) {
            a.model.form.SET0100InitDataModel = b;
            a.model.hidden.SET0100SearchInputModel.searchInput.clientId = a.model.form.SET0100InitDataModel.initData.clientId;
            a.model.hidden.SET0100SearchInputModel.searchInput.fromDate = a.model.form.SET0100InitDataModel.initData.fromDate;
            a.model.hidden.SET0100SearchInputModel.searchInput.toDate =
                a.model.form.SET0100InitDataModel.initData.toDate
        })
    };
    a.validateSend = function() {
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
    a.validate = function() {
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
    a.sendMessage = function() {
        a.validateSend();
        !0 != a.model.hidden.validatedSend.isErrored && a.sendMessageData()
    };
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage =
            1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.SET0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function(a, c) {
        d.doPost("/SET0100/initData", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.sendMessageData = function() {
        var b = {
            clientId: TextUtil.toString(a.model.hidden.SET0100CreateInputModel.clientId),
            title: TextUtil.toString(a.model.hidden.SET0100CreateInputModel.title),
            message: TextUtil.toString(a.model.hidden.SET0100CreateInputModel.message)
        };
        d.doPost("/SET0100/sendMessage", b, function(b) {
            a.model.form.SET0100CreateDataOutputModel = b;
            if (null != a.model.form.SET0100CreateDataOutputModel) "OK" == a.model.form.SET0100CreateDataOutputModel.createResult.resultFlg ? (a.model.hidden.SET0100CreateInputModel.clientId = null, a.model.hidden.SET0100CreateInputModel.title = null, a.model.hidden.SET0100CreateInputModel.message = null, e.pop("success", a.model.form.SET0100CreateDataOutputModel.createResult.message, null, "trustedHtml")) : e.pop("error", a.model.form.SET0100CreateDataOutputModel.createResult.message,
                null, "trustedHtml")
        })
    };
    a.searchData = function() {
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
            d.doPost("/SET0100/searchData", b, function(b) {
                a.model.form.SET0100SearchDataOutputModel = b;
                a.model.form.SET0100InitDataModel.resultSearch.pagingInfo = a.model.form.SET0100SearchDataOutputModel.searchResult.pagingInfo
            })
        }
    };
    a.searchDataOnly = function() {
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
            d.doPost("/SET0100/searchData", b, function(b) {
                a.model.form.SET0100SearchDataOutputModel = b;
                if (null != a.model.form.SET0100SearchDataOutputModel) "NG" == a.model.form.SET0100SearchDataOutputModel.returnCd ? e.pop("error", a.model.form.SET0100SearchDataOutputModel.returnMsg, null, "trustedHtml") : a.model.form.SET0100InitDataModel.resultSearch.pagingInfo =
                    a.model.form.SET0100SearchDataOutputModel.searchResult.pagingInfo
            })
        }
    }
}]);
angular.module("sto0100Module", ["dmsCommon", "sto0110Module","ngLoadingSpinner"]).controller("STO0100Ctrl", ["$scope", "serverService", "$rootScope","toaster", function(a, d, c,e) {
    a.model = {
        hidden: {
            storeCode: "",
            storeName: "",
            clientId: "",
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            },
            showImportStore: !1,
            defaultAreaName: Messages.getMessage("STO0100_LABEL_REGION_CHOOSE")
        }
    };
    a.model.form = {
        STO0100InitDataModel: null,
        STO0100SearchDataInputModel: null
    };
    a.importStore = function() {
        a.model.hidden.showImportStore = !0
    };
    a.init = function() {
        a.$on("STO0100#closeImportStore",
            function() {
                a.model.hidden.showImportStore = !1
            });
        a.initData()
    };
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.deleteStore = function(c) {
        param = {
            storeCode: c.storeCode
        };
        a.deleteStoreData(param)
    };
    a.chooseArea = function(c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.initData = function() {
        d.doPost("/STO0100/initData", {}, function(c) {
            a.model.form.STO0100InitDataModel = c
        })
    };
    a.searchData = function() {
        d.doPost("/STO0100/searchData", {
                searchInput: {
                    clientId: a.model.form.STO0100InitDataModel.initData.defaultClientId,
                    storeCode: a.model.hidden.storeCode,
                    storeName: a.model.hidden.storeName,
                    areaId: a.model.hidden.areaId
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            },
            function(c) {
                a.model.form.STO0100SearchDataInputModel = c;
                if (null != a.model.form.STO0100SearchDataInputModel.resultSearch) a.model.form.STO0100InitDataModel.resultSearch.storeInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.storeInfo, a.model.form.STO0100InitDataModel.resultSearch.pagingInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.pagingInfo
            })
    };
    a.searchDataOnly = function() {
        d.doPost("/STO0100/searchData", {
            searchInput: {
                clientId: a.model.form.STO0100InitDataModel.initData.defaultClientId,
                storeCode: a.model.hidden.storeCode,
                storeName: a.model.hidden.storeName,
                areaId: a.model.hidden.areaId
            },
            pagingInfo: {
                ttlRow: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.STO0100SearchDataInputModel = c;
            if (null != a.model.form.STO0100SearchDataInputModel.resultSearch) a.model.form.STO0100InitDataModel.resultSearch.storeInfo =
                a.model.form.STO0100SearchDataInputModel.resultSearch.storeInfo, a.model.form.STO0100InitDataModel.resultSearch.pagingInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.pagingInfo
        })
    };
    a.deleteStoreData = function(c) {
        d.doPost("/STO0100/deleteStore", c, function(b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
            a.search()
        })
    }
}]);
angular.module("sto0110Module", ["dmsCommon", "toaster"]).controller("STO0110Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function(a, d, c, e, b) {
    a.init = function() {
        a.model = {
            hidden: {
                rivalMode: !1
            }
        };
        a.model.form = {
            file: null,
            fileData: null,
            files: null
        };
        // a.model.hidden.clientId = angular.element("#clientId").val();
        // a.$on("PR01130#initFromRivalProduct", function(b, c) {
        //     a.model.hidden.rivalMode = !0;
        //     a.model.hidden.rivalId = c.rivalId
        // });
        // a.$on("PR01130#importProduct", function() {
        //     a.model.hidden.rivalMode = !1
        // })
    };
    a.chooseFile = function() {
        // event.stopPropagation();
        angular.element("#STO0110ChooseFile").click()
    };
    a.closeImportStore = function() {
        c.$broadcast("STO0100#closeImportStore", {})
    };
    a.getFile = function(b) {
        a.model.form.file = b
    };
    a.setFiles = function(b) {
        a.$apply(function() {
            a.files = [];
            for (var c = 0; c < b.files.length; c++) a.files.push(b.files[c])
        })
    };
    a.upload = function() {
        var  f = {
                clientId: a.model.hidden.clientId
                };
        d.uploadFile("/STO0120", a.model.form.file, f, function(f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("STO0100#closeImportStore", {})))

            if (null != f.proResult.proFlg && "OK" == f.proResult.proFlg) window.location.href =
                getContextPath() + "/STO0100/"


        })
    }
}]);

var sto0200Module = angular.module("sto0200Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("STO0200Ctrl", ["$scope", "$http", "$filter", "serverService", "GoogleMapApi".ns(), "toaster", function(a, d, c, e, b, f) {
    a.init = function() {
        a.model = {};
        a.model.form = {
            STO0200InitDataOutputModel: null,
            STO0200CreateStoreInputModel: {
                storeName: "",
                adress: "",
                classs:"",
                zone:"",
                zoneId:null,
                mr:"",
                bu:"",
                productTypeId:null,
                areaId: null,
                latVal: "",
                longVal: ""
            },
            STO0200CreateStoreResultDto: null
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                storeName: {
                    isErrored: !1,
                    msg: ""
                },
                areaId: {
                    isErrored: !1,
                    msg: ""
                },
                zoneId: {
                    isErrored: !1,
                    msg: ""
                },
                productTypeId: {
                    isErrored: !1,
                    msg: ""
                }
            },
            map: {
                latitude: null,
                longitude: null
            },
            defaultAreaName: Messages.getMessage("STO0200_LABEL_CHOOSE_REGION")
        };
        a.map = {
            center: {
                latitude: 10.771918,
                longitude: 106.698347
            },
            zoom: 15,
            events: {
                tilesloaded: function() {},
                click: function(b, c, e) {
                    var b = e[0],
                        f = b.latLng.lat(),
                        j = b.latLng.lng();
                    a.$apply(function() {
                        a.model.hidden.map.latitude = f;
                        a.model.hidden.map.longitude = j;
                        a.marker = {
                            id: 0,
                            coords: {
                                latitude: a.model.hidden.map.latitude,
                                longitude: a.model.hidden.map.longitude
                            }
                        };
                        d.get("http://maps.google.com/maps/api/geocode/json?latlng=" + f + "," + j + "&sensor=false").success(function(b) {
                            var c = "";
                            "OK" == b.status && null != b.results && void 0 != b.results && angular.forEach(b.results, function(a) {
                                if ("street_address" == a.types) c = a.formatted_address
                            });
                            a.model.form.clickAddress = c
                        })
                    })
                }
            }
        };
        a.marker = {
            id: 0,
            coords: {
                latitude: 10.771918,
                longitude: 106.698347
            }
        };
        a.initData()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            storeName: {
                isErrored: !1,
                msg: ""
            },
            areaId: {
                isErrored: !1,
                msg: ""
            },
            zoneId: {
                isErrored: !1,
                msg: ""
            },
            productTypeId: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.STO0200CreateStoreInputModel.storeName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.storeName.isErrored = !0, a.model.hidden.validated.storeName.msg = Messages.getMessage("E0000004", "STO0200_LABEL_STORE_NAME");
        if (null == a.model.form.STO0200CreateStoreInputModel.areaId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.areaId.isErrored = !0, a.model.hidden.validated.areaId.msg = Messages.getMessage("E0000004",
            "STO0200_LABEL_REGION");
        if (null == a.model.form.STO0200CreateStoreInputModel.zoneId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.zoneId.isErrored = !0, a.model.hidden.validated.zoneId.msg = Messages.getMessage("E0000004",
            "STO0200_LABEL_DOCTOR_ZONE");
        if (null == a.model.form.STO0200CreateStoreInputModel.productTypeId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productTypeId.isErrored = !0, a.model.hidden.validated.productTypeId.msg = Messages.getMessage("E0000004",
            "STO0200_LABEL_DOCTOR_BU")
    };
    a.showLocation = function() {
        a.map.center.latitude = a.model.hidden.map.latitude;
        a.map.center.longitude = a.model.hidden.map.longitude;
        a.marker = {
            id: 0,
            coords: {
                latitude: a.model.hidden.map.latitude,
                longitude: a.model.hidden.map.longitude
            }
        }
    };
    a.chooseArea = function(b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.form.STO0200CreateStoreInputModel.areaId = c
    };
    a.clearCreateParam = function() {
        a.model.form.STO0200CreateStoreInputModel = {
            storeName: "",
            adress: "",
            classs:"",
            zone:"",
            zoneId:null,
            mr:"",
            bu:"",
            productTypeId:null,
            areaId: "",
            latVal: "",
            longVal: ""
        };
        a.model.hidden.map.latitude =
            "";
        a.model.hidden.map.longitude = ""
    };
    a.createStore = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && a.createStoreDataAndChangePage({
        	storeName: a.model.form.STO0200CreateStoreInputModel.storeName,
        	classs: a.model.form.STO0200CreateStoreInputModel.classs,
        	zone: a.model.form.STO0200CreateStoreInputModel.zone,
        	zoneId: a.model.form.STO0200CreateStoreInputModel.zoneId,
        	mr: a.model.form.STO0200CreateStoreInputModel.mr,
        	bu: a.model.form.STO0200CreateStoreInputModel.bu,
        	productTypeId: a.model.form.STO0200CreateStoreInputModel.productTypeId,
            adress: a.model.form.STO0200CreateStoreInputModel.adress,
            areaId: a.model.form.STO0200CreateStoreInputModel.areaId,
            latVal: a.model.hidden.map.latitude,
            longVal: a.model.hidden.map.longitude
        })
    };
    a.createStoreContinus = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && a.createStoreData({
            storeName: a.model.form.STO0200CreateStoreInputModel.storeName,
        	classs: a.model.form.STO0200CreateStoreInputModel.classs,
        	zone: a.model.form.STO0200CreateStoreInputModel.zone,
        	zoneId: a.model.form.STO0200CreateStoreInputModel.zoneId,
        	mr: a.model.form.STO0200CreateStoreInputModel.mr,
        	bu: a.model.form.STO0200CreateStoreInputModel.bu,
        	productTypeId: a.model.form.STO0200CreateStoreInputModel.productTypeId,
            adress: a.model.form.STO0200CreateStoreInputModel.adress,
            areaId: a.model.form.STO0200CreateStoreInputModel.areaId,
            latVal: a.model.hidden.map.latitude,
            longVal: a.model.hidden.map.longitude
        })
    };
    a.findLocation = function() {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0200CreateStoreInputModel.adress) + "&sensor=false";
        d.get(b).success(function(b) {
            a.model.form.listPos = b
        })
    };
    a.findLocationEdit = function() {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0210SelectStoreResultDto.adress) + "&sensor=false";
        d.get(b).success(function(b) {
            a.model.form.listPos = b
        })
    };

    a.choosePos = function(b) {
        a.model.hidden.map.latitude = b.geometry.location.lat;
        a.model.hidden.map.longitude =
            b.geometry.location.lng;
        a.model.form.STO0200CreateStoreInputModel.adress = b.formatted_address;
        a.model.form.clickAddress = b.formatted_address;
        a.showLocation()
    };
    a.initData = function() {
        param = {};
        e.doPost("/STO0200/initData", param, function(b) {
            a.model.form.STO0200InitDataOutputModel = b
        })
    };
    a.createStoreDataAndChangePage = function(b) {
        e.doPost("/STO0200/regisStore", b, function(b) {
            a.model.form.STO0200CreateStoreResultDto = b;
            if (null != a.model.form.STO0200CreateStoreResultDto && "OK" == a.model.form.STO0200CreateStoreResultDto.proResult.proFlg) window.location.href =
                getContextPath() + "/STO0100/"
        })
    };
    a.createStoreData = function(b) {
        e.doPost("/STO0200/regisStore", b, function(b) {
            a.model.form.STO0200CreateStoreResultDto = b;
            null != a.model.form.STO0200CreateStoreResultDto && ("OK" == a.model.form.STO0200CreateStoreResultDto.proResult.proFlg ? (f.pop("success", a.model.form.STO0200CreateStoreResultDto.proResult.message, null, "trustedHtml"), a.clearCreateParam()) : f.pop("error", a.model.form.STO0200CreateStoreResultDto.proResult.message, null, "trustedHtml"))
        })
    }
}]);
var sto0210Module = angular.module("sto0210Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("STO0210Ctrl", ["$scope", "$http", "serverService", "GoogleMapApi".ns(), "toaster", function(a, d, c, e, b) {
    a.model = {};
    a.model.form = {
        STO0210InitDataOutputModel: null,
        STO0210UpdateStoreInputModel: {
            storeId: "",
            storeCode: "",
            storeName: "",
            classs:"",
            zone:"",
            zoneId:null,
            mr:"",
            bu:"",
            productTypeId:null,
            adress: "",
            areaId: null,
            latVal: "",
            longVal: "",
            versionNoStore: ""
        },
        STO0210SelectStoreResultDto: null,
        STO0210UpdateStoreResultDto: null
    };
    a.model.hidden = {
        validated: {
            isErrored: !1,
            storeName: {
                isErrored: !1,
                msg: ""
            },
            areaId: {
                isErrored: !1,
                msg: ""
            },
            zoneId: {
                isErrored: !1,
                msg: ""
            },
            productTypeId: {
                isErrored: !1,
                msg: ""
            }
        },
        map: {
            latitude: null,
            longitude: null
        },
        defaultAreaName: "",
        storeId: null,
        storeBackUp: null
    };
    a.init = function() {
        a.map = {
            center: {
                latitude: 10.771918,
                longitude: 106.698347
            },
            zoom: 18,
            events: {
                tilesloaded: function() {},
                click: function(b, c, e) {
                    var b = e[0],
                        i = b.latLng.lat(),
                        k = b.latLng.lng();
                    a.$apply(function() {
                        a.model.hidden.map.latitude = i;
                        a.model.hidden.map.longitude =
                            k;
                        a.marker = {
                            id: 0,
                            coords: {
                                latitude: a.model.hidden.map.latitude,
                                longitude: a.model.hidden.map.longitude
                            }
                        };
                        d.get("http://maps.google.com/maps/api/geocode/json?latlng=" + i + "," + k + "&sensor=false").success(function(b) {
                            var c = "";
                            "OK" == b.status && null != b.results && void 0 != b.results && angular.forEach(b.results, function(a) {
                                if ("street_address" == a.types) c = a.formatted_address
                            });
                            a.model.form.clickAddress = c
                        })
                    })
                }
            }
        };
        a.marker = {
            id: 0,
            coords: {
                latitude: 10.771918,
                longitude: 106.698347
            }
        };
        a.model.hidden.storeId = angular.element("#storeId").val();
        e.then(function() {});
        a.initData()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            storeName: {
                isErrored: !1,
                msg: ""
            },
            areaId: {
                isErrored: !1,
                msg: ""
            },
            zoneId: {
                isErrored: !1,
                msg: ""
            },
            productTypeId: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.STO0210SelectStoreResultDto.selectSore.storeName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.storeName.isErrored = !0, a.model.hidden.validated.storeName.msg = Messages.getMessage("E0000004", "STO0210_LABEL_STORE_NAME");
        if (null == a.model.form.STO0210SelectStoreResultDto.selectSore.areaId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.areaId.isErrored = !0, a.model.hidden.validated.areaId.msg = Messages.getMessage("E0000004", "STO0210_LABEL_REGION");
        if (null == a.model.form.STO0210SelectStoreResultDto.selectSore.zoneId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.zoneId.isErrored = !0, a.model.hidden.validated.zoneId.msg = Messages.getMessage("E0000004", "STO0200_LABEL_DOCTOR_ZONE");
        if (null == a.model.form.STO0210SelectStoreResultDto.selectSore.productTypeId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productTypeId.isErrored = !0, a.model.hidden.validated.productTypeId.msg = Messages.getMessage("E0000004", "STO0200_LABEL_DOCTOR_BU")
    };
    a.showLocation = function() {
        a.map.center.latitude = a.model.hidden.map.latitude;
        a.map.center.longitude = a.model.hidden.map.longitude;
        a.marker = {
            id: 0,
            coords: {
                latitude: a.model.hidden.map.latitude,
                longitude: a.model.hidden.map.longitude
            }
        }
    };
    a.findLocationEdit = function() {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0210SelectStoreResultDto.selectSore.address) + "&sensor=false";
        d.get(b).success(function(b) {
            a.model.form.listPos = b
        })
    };

    a.choosePos = function(b) {
        a.model.hidden.map.latitude = b.geometry.location.lat;
        a.model.hidden.map.longitude = b.geometry.location.lng;
        a.model.form.STO0210SelectStoreResultDto.selectSore.address = b.formatted_address;
        a.model.form.clickAddress = b.formatted_address;
        a.showLocation()
    };
    a.chooseArea = function(b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.form.STO0210SelectStoreResultDto.selectSore.areaId = c
    };
    a.updateStore =
        function() {
            a.updateStoreDataAndChangePage({
                storeId: a.model.form.STO0210SelectStoreResultDto.selectSore.storeId,
                storeCode: a.model.form.STO0210SelectStoreResultDto.selectSore.storeCode,
                storeName: a.model.form.STO0210SelectStoreResultDto.selectSore.storeName,
                classs: a.model.form.STO0210SelectStoreResultDto.selectSore.classs,
                zone: a.model.form.STO0210SelectStoreResultDto.selectSore.zone,
                zoneId: a.model.form.STO0210SelectStoreResultDto.selectSore.zoneId,
                mr: a.model.form.STO0210SelectStoreResultDto.selectSore.mr,
                bu: a.model.form.STO0210SelectStoreResultDto.selectSore.bu,
                productTypeId: a.model.form.STO0210SelectStoreResultDto.selectSore.productTypeId,
                adress: a.model.form.STO0210SelectStoreResultDto.selectSore.address,
                areaId: a.model.form.STO0210SelectStoreResultDto.selectSore.areaId,
                latVal: a.model.hidden.map.latitude,
                longVal: a.model.hidden.map.longitude,
                versionNoStore: a.model.form.STO0210SelectStoreResultDto.selectSore.versionNoStore
            })
        };
    a.updateStoreContinus = function() {
        a.updateStoreData({
            storeId: a.model.form.STO0210SelectStoreResultDto.selectSore.storeId,
            storeCode: a.model.form.STO0210SelectStoreResultDto.selectSore.storeCode,
            storeName: a.model.form.STO0210SelectStoreResultDto.selectSore.storeName,
            classs: a.model.form.STO0210SelectStoreResultDto.selectSore.classs,
            zone: a.model.form.STO0210SelectStoreResultDto.selectSore.zone,
            zoneId: a.model.form.STO0210SelectStoreResultDto.selectSore.zoneId,
            mr: a.model.form.STO0210SelectStoreResultDto.selectSore.mr,
            bu: a.model.form.STO0210SelectStoreResultDto.selectSore.bu,
            productTypeId: a.model.form.STO0210SelectStoreResultDto.selectSore.productTypeId,
            adress: a.model.form.STO0210SelectStoreResultDto.selectSore.address,
            areaId: a.model.form.STO0210SelectStoreResultDto.selectSore.areaId,
            latVal: a.model.hidden.map.latitude,
            longVal: a.model.hidden.map.longitude,
            versionNoStore: a.model.form.STO0210SelectStoreResultDto.selectSore.versionNoStore
        })
    };
    a.initData = function() {
        param = {};
        c.doPost("/STO0210/initData", param, function(b) {
            a.model.form.STO0210InitDataOutputModel = b;
            a.selectStoreData(a.model.hidden.storeId)
        })
    };
    a.selectStoreData = function(b) {
        param = {
            storeId: b
        };
        c.doPost("/STO0210/selectStore", param, function(b) {
            a.model.hidden.storeBackUp = angular.copy(b);
            a.model.form.STO0210SelectStoreResultDto = b;
            for (b = 0; b < a.model.form.STO0210InitDataOutputModel.initData.areaInfo.items.length; b++) {
                var c = a.model.form.STO0210InitDataOutputModel.initData.areaInfo.items[b];
                if (c.areaId == a.model.form.STO0210SelectStoreResultDto.selectSore.areaId) {
                    a.model.hidden.defaultAreaName = c.areaName;
                    break
                }
                if (null != c.items)
                    for (var e = 0; e < c.items.length; e++) {
                        var f = c.items[e];
                        if (f.areaId == a.model.form.STO0210SelectStoreResultDto.selectSore.areaId) {
                            a.model.hidden.defaultAreaName = f.areaName;
                            break
                        }
                    }
            }
            a.model.hidden.map.latitude = a.model.form.STO0210SelectStoreResultDto.selectSore.latVal;
            a.model.hidden.map.longitude = a.model.form.STO0210SelectStoreResultDto.selectSore.longVal;
            a.showLocation()
        })
    };
    a.updateStoreDataAndChangePage = function(b) {
        c.doPost("/STO0210/updateStore", b, function(b) {
            a.model.form.STO0210UpdateStoreResultDto = b;
            if ("OK" == a.model.form.STO0210UpdateStoreResultDto.proResult.proFlg) window.location.href = getContextPath() + "/STO0100/"
        })
    };
    a.updateStoreData = function(e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && c.doPost("/STO0210/updateStore", e, function(c) {
            a.model.form.STO0210UpdateStoreResultDto = c;
            "OK" == a.model.form.STO0210UpdateStoreResultDto.proResult.proFlg ? (b.pop("success",
                a.model.form.STO0210UpdateStoreResultDto.proResult.message, null, "trustedHtml"), window.location.href = getContextPath() + "/STO0100/") : b.pop("error", a.model.form.STO0210UpdateStoreResultDto.proResult.message, null, "trustedHtml")
        })
    }
}]);
angular.module("sto0300Module", ["dmsCommon", "fcsa-number", "sto0310Module", "sto0320Module", "sto0330Module", "google-maps".ns(), "ngLoadingSpinner"]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("STO0300Ctrl", ["$scope", "$rootScope", "serverService", "$timeout", function(a, d, c, e) {
    a.init = function() {
        a.model.hidden.storeId = angular.element("#storeId").val();
        e(function() {
            d.$broadcast("STO0320#checkRole", {
                activeTab: a.activeTab
            })
        }, 100);
        a.selectStoreData(a.model.hidden.storeId)
    };
    a.initTab1 = function() {
        d.$broadcast("STO0310#init", null)
    };
    a.initTab2 = function() {
        d.$broadcast("STO0320#init", null)
    };
    a.initTab3 = function() {
        d.$broadcast("STO0330#init", null)
    };
    a.selectStoreData = function(b) {
        a.model = {
            hidden: {
                no_img: getContextPathImageDefault() + "/img/no_img.png",
                storeId: null,
                roleAdmin: null
            }
        };
        a.model.form = {
            STO0300SelectStoreResultDto: null
        };
        a.map = {
            center: {
                latitude: 10.771918,
                longitude: 106.698347
            },
            zoom: 15
        };
        a.marker = {
            id: 0,
            coords: {
                latitude: 10.771918,
                longitude: 106.698347
            }
        };
        param = {
            storeId: b
        };
        c.doPost("/STO0300/selectStore",
            param,
            function(b) {
                a.model.form.STO0300SelectStoreResultDto = b;
                a.map = {
                    center: {
                        latitude: a.model.form.STO0300SelectStoreResultDto.selectSore.latVal,
                        longitude: a.model.form.STO0300SelectStoreResultDto.selectSore.longVal
                    },
                    zoom: 15
                };
                a.marker = {
                    id: 0,
                    coords: {
                        latitude: a.model.form.STO0300SelectStoreResultDto.selectSore.latVal,
                        longitude: a.model.form.STO0300SelectStoreResultDto.selectSore.longVal
                    }
                }
            })
    }
}]);
angular.module("sto0310Module", ["dmsCommon", "fcsa-number"]).controller("STO0310Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.model = {
        hidden: {
            storeId: null,
            selectedClient: null,
            selectedClientname: "",
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            }
        }
    };
    a.model.form = {
        STO0310DeleteDataModel: null,
        STO0310InitDataModel: null,
        STO0310RegisDataModel: null,
        STO0310Alert: {
            proResult: {
                proFlg: null,
                message: ""
            }
        }
    };
    a.init = function() {
        a.model.hidden.storeId = angular.element("#storeId").val();
        a.initData(a.model.hidden.storeId);
        a.$on("STO0310#init", function() {
            a.initData(a.model.hidden.storeId)
        })
    };
    a.regisClientStore = function() {
        if (null != a.model.hidden.selectedClient) {
            for (var b = 0; b < a.model.form.STO0310InitDataModel.initData.clientInfo.clientList.length; b++) {
                var c = a.model.form.STO0310InitDataModel.initData.clientInfo.clientList[b];
                if (a.model.hidden.selectedClient == c.clientId) a.model.hidden.selectedClientname = c.clientName
            }
            a.regisClientStoreData()
        }
    };
    a.deleteClientStore = function(b) {
        a.deleteClientStoreData(b)
    };
    a.initData = function(b) {
        param = {
            storeId: b
        };
        d.doPost("/STO0310/initData", param, function(b) {
            a.model.form.STO0310InitDataModel = b
        })
    };
    a.regisClientStoreData = function() {
        param = {
            storeId: a.model.hidden.storeId,
            clientId: a.model.hidden.selectedClient,
            clientName: a.model.hidden.selectedClientname
        };
        d.doPost("/STO0310/regisClientStore", param, function(b) {
            a.model.form.STO0310RegisDataModel = b;
            a.model.form.STO0310InitDataModel.initData.clientInfo.clientList = a.model.form.STO0310RegisDataModel.regisResult.clientInfo.clientList;
            a.model.form.STO0310InitDataModel.initData.searchClientStore = a.model.form.STO0310RegisDataModel.regisResult.searchClientStore;
            a.model.form.STO0310Alert.proResult.proFlg = a.model.form.STO0310RegisDataModel.regisResult.proFlg;
            a.model.form.STO0310Alert.proResult.message = a.model.form.STO0310RegisDataModel.regisResult.message;
            "OK" == a.model.form.STO0310Alert.proResult.proFlg && e.pop("success", a.model.form.STO0310Alert.proResult.message)
        })
    };
    a.deleteClientStoreData = function(b) {
        param = {
            storeId: a.model.hidden.storeId,
            clientId: b.clientId,
            clientName: b.clientName,
            versionNo: b.versionNo
        };
        d.doPost("/STO0310/deleteClientStore", param, function(b) {
            a.model.form.STO0310DeleteDataModel = b;
            a.model.form.STO0310InitDataModel.initData.clientInfo.clientList = a.model.form.STO0310DeleteDataModel.deleteResult.clientInfo.clientList;
            a.model.form.STO0310InitDataModel.initData.searchClientStore = a.model.form.STO0310DeleteDataModel.deleteResult.searchClientStore;
            a.model.form.STO0310Alert.proResult.proFlg = a.model.form.STO0310DeleteDataModel.deleteResult.proFlg;
            a.model.form.STO0310Alert.proResult.message = a.model.form.STO0310DeleteDataModel.deleteResult.message
        })
    }
}]);
angular.module("sto0320Module", ["dmsCommon", "fcsa-number"]).controller("STO0320Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.model = {
        hidden: {
            storeId: null,
            selectedClient: null,
            selectedClientname: "",
            roleAdmin: !1,
            initTab: !1,
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            }
        }
    };
    a.model.form = {
        STO0320InitDataModel: null,
        STO0320SelectSalesmanNotAssingnStoreInputModel: {
            storeId: null,
            clientId: null,
            salesmanCode: "",
            salesmanName: "",
            pagingInfo: {
                ttlRow: 0,
                crtPage: 1,
                rowNumber: 15
            }
        },
        STO320DeleteResult: null,
        STO0320Alert: {
            proResult: {
                proFlg: null,
                message: ""
            }
        },
        STO0320ListSaleRegis: [],
        STO0320SelectSalesmanNotAssingnStoreOutputModel: null
    };
    a.init = function() {
        !1 == a.model.hidden.initTab ? (a.model.hidden.storeId = angular.element("#storeId").val(), a.initData(a.model.hidden.storeId), a.model.hidden.initTab = !0) : a.$on("STO0320#init", function() {
            a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel = {
                storeId: null,
                clientId: null,
                salesmanCode: "",
                salesmanName: "",
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 15
                }
            };
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore();
            a.initData(a.model.hidden.storeId)
        });
        a.$on("STO0320#checkRole", function(b, c) {
            if (1 == c.activeTab) a.model.hidden.roleAdmin = !0
        })
    };
    a.selectSalesmanByStoreClient = function() {
        a.selectSalesmanByStoreClientData();
        a.selectSalesmanNotAssingnStore()
    };
    a.regisSalesmanStore = function() {
        a.regisSalesmanStoreData()
    };
    a.selectSalesmanNotAssingnStore = function() {
        a.selectSalesmanNotAssingnStoreDataOnly()
    };
    a.deleteSaleman = function(b) {
        /*event.stopPropagation();*/
        a.deleteSalemanData({
            salesmanId: b.salesmanId,
            salesmanCode: b.salesmanCode,
            storeId: a.model.hidden.storeId
        }, function(b) {
            a.model.form.STO320DeleteResult = b;
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore()
        })
    };
    a.chooseSale = function(b) {
        !1 == b.choose && a.removeSaleItem(b);
        !0 == b.choose && a.addSaleItem(b)
    };
    a.removeSaleItem = function(b) {
        for (var c = 0; c < a.model.form.STO0320ListSaleRegis.length; c++)
            if (a.model.form.STO0320ListSaleRegis[c].salesmanId = b.salesmanId) {
                a.model.form.STO0320ListSaleRegis.splice(c, 1);
                break
            }
        a.checkChooseAll()
    };
    a.addSaleItem =
        function(b) {
            a.model.form.STO0320ListSaleRegis.push({
                salesmanId: b.salesmanId,
                storeId: a.model.hidden.storeId
            });
            a.checkChooseAll()
        };
    a.chooseAll = function() {
        if (null != a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length; b++) {
                    var c = a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore[b];
                    c.choose = !1;
                    for (var e = 0; e < a.model.form.STO0320ListSaleRegis.length; e++) a.model.form.STO0320ListSaleRegis[e] ==
                        c.salesmanId && a.model.form.STO0320ListSaleRegis.splice(e, 1)
                } else {
                    a.model.form.STO0320ListSaleRegis = [];
                    for (b = 0; b < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length; b++) c = a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore[b], c.choose = !0, a.model.form.STO0320ListSaleRegis.push({
                        salesmanId: c.salesmanId,
                        storeId: a.model.hidden.storeId
                    })
                }
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length; b++)
                if (!1 == a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function() {
        // if (null != a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore) {
        //     for (var b = 0; b < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length; b++) {
        //         var c = a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore[b];
        //         c.choose = !1;
        //         for (var e = 0; e < a.model.form.STO0320ListSaleRegis.length; e++)
        //             if (a.model.form.STO0320ListSaleRegis[e] == c.salesmanId) c.choose = !0
        //     }
        //     a.checkChooseAll()
        // }
        a.model.form.STO0320ListSaleRegis = [];
        a.model.form.chooseAll = 1;
    };
    a.prevPage = function() {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage -= 1;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.nextPage = function() {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage += 1;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.startPage = function() {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage =
            1;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.endPage = function() {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage = a.model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlPages;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.deleteSalemanData = function(a, c) {
        d.doPost("/STO0320/deleteSalesmanStore", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.initData = function(b) {
        param = {
            storeId: b
        };
        d.doPost("/STO0320/initData", param, function(b) {
            a.model.form.STO0320InitDataModel = b;
            a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId =
                a.model.form.STO0320InitDataModel.defaultClientId;
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore();
        })
    };
    a.regisSalesmanStoreData = function() {
        param = {
            selectSalesman: a.model.form.STO0320ListSaleRegis
        };
        d.doPost("/STO0320/regisSalesmanStore", param, function(b) {
            a.model.form.STO0320RegisDataModel = b;
            a.model.form.STO0320Alert.proResult.proFlg = a.model.form.STO0320RegisDataModel.regisResult.proFlg;
            a.model.form.STO0320Alert.proResult.message = a.model.form.STO0320RegisDataModel.regisResult.message;
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore();
            a.model.form.STO0320ListSaleRegis = [];
            "OK" == a.model.form.STO0320Alert.proResult.proFlg && e.pop("success", a.model.form.STO0320Alert.proResult.message)
        })
    };
    a.selectSalesmanNotAssingnStoreData = function() {
        param = {
            storeId: a.model.hidden.storeId,
            clientId: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId,
            salesmanCode: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.salesmanCode,
            salesmanName: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.salesmanName,
            pagingInfo: {
                ttlRow: null != a.model.form.STO0320InitDataModel.searchResult.pagingInfo ? a.model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.STO0320InitDataModel.searchResult.pagingInfo ? a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.STO0320InitDataModel.searchResult.pagingInfo ? a.model.form.STO0320InitDataModel.searchResult.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/STO0320/selectSalesmanNotAssingnStore", param,
            function(b) {
                a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel = b;
                a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.salesmanNotAssignStore;
                a.model.form.STO0320InitDataModel.searchResult.pagingInfo = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.pagingInfo;
                a.checkChooseAllAfterSearch()
            })
    };
    a.selectSalesmanNotAssingnStoreDataOnly = function() {
        param = {
            storeId: a.model.hidden.storeId,
            clientId: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId,
            salesmanCode: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.salesmanCode,
            salesmanName: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.salesmanName,
            pagingInfo: {
                ttlRow: null != a.model.form.STO0320InitDataModel.searchResult.pagingInfo ? a.model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.STO0320InitDataModel.searchResult.pagingInfo ? a.model.form.STO0320InitDataModel.searchResult.pagingInfo.rowNumber : null
            }
        };
        d.doPost("/STO0320/selectSalesmanNotAssingnStore", param, function(b) {
            a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel = b;
            a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.salesmanNotAssignStore;
            a.model.form.STO0320InitDataModel.searchResult.pagingInfo = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.pagingInfo;
            a.checkChooseAllAfterSearch()
        })
    };
    a.selectSalesmanByStoreClientData =
        function() {
            param = {
                storeId: a.model.hidden.storeId,
                clientId: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId
            };
            d.doPost("/STO0320/selectSalesmanByStoreClient", param, function(b) {
                a.model.form.STO0320SalesmanByStoreClientOutputModel = b
            })
        }
}]);
angular.module("sto0330Module", ["dmsCommon", "fcsa-number"]).controller("STO0330Ctrl", ["$scope", "serverService", "$rootScope", function(a, d) {
    a.model = {
        hidden: {}
    };
    a.model.form = {
        STO0330InitDataModel: null
    };
    a.init = function() {
        a.model.hidden.storeId = angular.element("#storeId").val();
        a.initData(a.model.hidden.storeId)
    };
    a.getImage = function() {
        if (null != a.model.form.STO0330InitDataModel.photoResult)
            for (var c = 0; c < a.model.form.STO0330InitDataModel.photoResult.length; c++)
                for (var e = a.model.form.STO0330InitDataModel.photoResult[c],
                        b = e.photoPath.length, d = 0; d < b; d++) {
                    var h = e.photoPath[d];
                    h.photoPath = getContextPath() + h.photoPath
                }
    };
    a.initData = function(c) {
        param = {
            storeId: c
        };
        d.doPost("/STO0330/selectPhotoStore", param, function(c) {
            a.model.form.STO0330InitDataModel = c;
            a.getImage()
        })
    }
}]);
angular.module("usr0100Module", ["dmsCommon", "usr0110Module", "ngAnimate", "toaster", "ngLoadingSpinner"]).controller("USR0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", "$timeout", function(a, d, c, e, b) {
    a.init = function() {
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
            USR0100InitDataModel: null,
            searchParam: {
                searchInput: {
                    clientId: "",
                    userCode: null,
                    userName: null,
                    roleCd: null
                },
                pagingInfo: {
                    ttlRow: null,
                    crtPage: null,
                    rowNumber: null
                }
            }
        };
        a.$on("USR0100#closeResetPassword", function(b, c) {
            a.model.hidden.showModalResetPassword = c.showModalResetPassword
        });
        a.$on("USR0100#closeResetPasswordAfterChange", function(b, c) {
            a.model.hidden.showModalResetPassword = c.showModalResetPassword;
            e.pop("success", c.message, null, "trustedHtml")
        });
        a.initData()
    };
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage +=
            1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage = a.model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.showModalPasswordReset = function(e) {
        a.model.hidden.showModalResetPassword = !0;
        b(function() {
            c.$broadcast("USR0110#sendUserCode", {
                userCode: e.userCode
            })
        }, 10)
    };
    a.showModalEditUser = function() {
        a.model.hidden.showModalEditUser = !0
    };
    a.deleteUser = function(b) {
        param = {
            userCode: b.userCode
        };
        a.deleteUserData(param)
    };
    a.initData = function() {
        d.doPost("/USR0100/initData", {}, function(b) {
            a.model.form.USR0100InitDataModel = b
        })
    };
    a.deleteUserData = function() {
        d.doPost("/USR0100/deleteUser", param, function(b) {
            "OK" == b.proResult.proFlg && (e.pop("success", b.proResult.message, null, "trustedHtml"), a.search());
            "NG" == b.proResult.proFlg && e.pop("error", b.proResult.message, null, "trustedHtml")
        })
    };
    a.searchData = function() {
        d.doPost("/USR0100/searchData", {
            searchInput: {
                clientId: a.model.form.USR0100InitDataModel.initSearch.conditionSearch.defaultClientId,
                userCode: a.model.form.searchParam.searchInput.userCode,
                userName: a.model.form.searchParam.searchInput.userName,
                roleCd: a.model.form.USR0100InitDataModel.initSearch.conditionSearch.defaultRoleCd
            },
            pagingInfo: {
                ttlRow: null != a.model.form.USR0100InitDataModel.initSearch.pagingInfo ? a.model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.USR0100InitDataModel.initSearch.pagingInfo ? a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.USR0100InitDataModel.initSearch.pagingInfo ? a.model.form.USR0100InitDataModel.initSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
            a.model.form.USR0100SearchDataInputModel = b;
            a.model.form.USR0100InitDataModel.initSearch.userInfo.lstUser = a.model.form.USR0100SearchDataInputModel.resultSearch.userInfo.lstUser;
            a.model.form.USR0100InitDataModel.initSearch.pagingInfo = a.model.form.USR0100SearchDataInputModel.resultSearch.pagingInfo
        })
    };
    a.searchDataOnly = function() {
        d.doPost("/USR0100/searchData", {
            searchInput: {
                clientId: a.model.form.USR0100InitDataModel.initSearch.conditionSearch.defaultClientId,
                userCode: a.model.form.searchParam.searchInput.userCode,
                userName: a.model.form.searchParam.searchInput.userName,
                roleCd: a.model.form.USR0100InitDataModel.initSearch.conditionSearch.defaultRoleCd
            },
            pagingInfo: {
                ttlRow: null != a.model.form.USR0100InitDataModel.initSearch.pagingInfo ? a.model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.USR0100InitDataModel.initSearch.pagingInfo ? a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.USR0100InitDataModel.initSearch.pagingInfo ? a.model.form.USR0100InitDataModel.initSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
            a.model.form.USR0100SearchDataInputModel = b;
            a.model.form.USR0100InitDataModel.initSearch.userInfo.lstUser = a.model.form.USR0100SearchDataInputModel.resultSearch.userInfo.lstUser;
            a.model.form.USR0100InitDataModel.initSearch.pagingInfo = a.model.form.USR0100SearchDataInputModel.resultSearch.pagingInfo
        })
    }
}]);
angular.module("usr0110Module", ["dmsCommon", "toaster"]).controller("USR0110Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
        a.model = {
            hidden: {
                showModalResetPassword: null,
                userCode: null,
                validated: {
                    isErrored: !1,
                    password: {
                        isErrored: !1,
                        msg: ""
                    },
                    rePassword: {
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
            USR0110ResetPasswordResult: null,
            USR0110ResetPasswordInput: {
                userCode: null,
                password: null,
                rePassword: null
            }
        };
        a.$on("USR0110#sendUserCode", function(b,
            c) {
            a.model.form.USR0110ResetPasswordResult = null;
            a.model.form.USR0110ResetPasswordInput = {
                userCode: null,
                password: null,
                rePassword: null
            };
            a.model.hidden.userCode = c.userCode
        })
    };
    a.resetPassword = function() {
        param = {
            userCode: a.model.hidden.userCode,
            password: a.model.form.USR0110ResetPasswordInput.password,
            rePassword: a.model.form.USR0110ResetPasswordInput.rePassword
        };
        a.resetPasswordData(param)
    };
    a.closeResetPassword = function() {
        a.model.hidden.showModalResetPassword = !1;
        c.$broadcast("USR0100#closeResetPassword", {
            showModalResetPassword: a.model.hidden.showModalResetPassword
        })
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            password: {
                isErrored: !1,
                msg: ""
            },
            rePassword: {
                isErrored: !1,
                msg: ""
            },
            checkPassword: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0110ResetPasswordInput.password)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.password.msg = Messages.getMessage("E0000004", "USR0100_LABEL_PASSWORD");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0110ResetPasswordInput.rePassword)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.rePassword.msg = Messages.getMessage("E0000004", "USR0100_LABEL_CONFIRM_PASSWORD");
        if (a.model.form.USR0110ResetPasswordInput.rePassword != a.model.form.USR0110ResetPasswordInput.password) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkPassword.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.checkPassword.msg = Messages.getMessage("E0000005")
    };
    a.resetPasswordData = function(b) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0110/resetPassword", b, function(b) {
            a.model.form.USR0110ResetPasswordResult = b;
            if (null != a.model.form.USR0110ResetPasswordResult.proResult && "OK" == a.model.form.USR0110ResetPasswordResult.proResult.proFlg) a.model.hidden.showModalResetPassword = !1, c.$broadcast("USR0100#closeResetPasswordAfterChange", {
                showModalResetPassword: a.model.hidden.showModalResetPassword,
                message: a.model.form.USR0110ResetPasswordResult.proResult.message
            });
            null != a.model.form.USR0110ResetPasswordResult.proResult && "NG" == a.model.form.USR0110ResetPasswordResult.proResult.proFlg && e.pop("error", a.model.form.USR0110ResetPasswordResult.proResult.message, null, "trustedHtml")
        })
    }
}]);

/**
 * START DOCTOR
 * */

var doc0200Module = angular.module("doc0200Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("DOC0200Ctrl", ["$scope", "$http", "$filter", "serverService", "GoogleMapApi".ns(), "toaster", function(a, d, c, e, b, f) {
    a.init = function() {
        a.model = {};
        a.model.form = {
            STO0200InitDataOutputModel: null,
            STO0200CreateStoreInputModel: {
                docName: "",
                title:"",
                position:"",
                specialty:"",
                department:"",
                hospital:"",
                classs:"",
                zone:"",
                zoneId:null,
                mr:"",
                bu:"",
                productTypeId:null,
                adress: "",
                areaId: null,
                latVal: "",
                longVal: ""
            },
            STO0200CreateStoreResultDto: null
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                docName: {
                    isErrored: !1,
                    msg: ""
                },
                areaId: {
                    isErrored: !1,
                    msg: ""
                },
                zoneId: {
                    isErrored: !1,
                    msg: ""
                },
                productTypeId: {
                    isErrored: !1,
                    msg: ""
                }
            },
            map: {
                latitude: null,
                longitude: null
            },
            defaultAreaName: Messages.getMessage("STO0200_LABEL_CHOOSE_REGION")
        };
        a.map = {
            center: {
                latitude: 10.771918,
                longitude: 106.698347
            },
            zoom: 15,
            events: {
                tilesloaded: function() {},
                click: function(b, c, e) {
                    var b = e[0],
                        f = b.latLng.lat(),
                        j = b.latLng.lng();
                    a.$apply(function() {
                        a.model.hidden.map.latitude = f;
                        a.model.hidden.map.longitude = j;
                        a.marker = {
                            id: 0,
                            coords: {
                                latitude: a.model.hidden.map.latitude,
                                longitude: a.model.hidden.map.longitude
                            }
                        };
                        d.get("http://maps.google.com/maps/api/geocode/json?latlng=" + f + "," + j + "&sensor=false").success(function(b) {
                            var c = "";
                            "OK" == b.status && null != b.results && void 0 != b.results && angular.forEach(b.results, function(a) {
                                if ("street_address" == a.types) c = a.formatted_address
                            });
                            a.model.form.clickAddress = c
                        })
                    })
                }
            }
        };
        a.marker = {
            id: 0,
            coords: {
                latitude: 10.771918,
                longitude: 106.698347
            }
        };
        a.initData()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            docName: {
                isErrored: !1,
                msg: ""
            },
            areaId: {
                isErrored: !1,
                msg: ""
            },
            zoneId: {
                isErrored: !1,
                msg: ""
            },
            productTypeId: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.STO0200CreateStoreInputModel.docName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.docName.isErrored = !0, a.model.hidden.validated.docName.msg = Messages.getMessage("E0000004", "STO0200_LABEL_STORE_NAME");
        if (null == a.model.form.STO0200CreateStoreInputModel.areaId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.areaId.isErrored = !0, a.model.hidden.validated.areaId.msg = Messages.getMessage("E0000004",
            "STO0200_LABEL_REGION");
        if (null == a.model.form.STO0200CreateStoreInputModel.zoneId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.zoneId.isErrored = !0, a.model.hidden.validated.zoneId.msg = Messages.getMessage("E0000004",
            "STO0200_LABEL_DOCTOR_ZONE");
        if (null == a.model.form.STO0200CreateStoreInputModel.productTypeId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productTypeId.isErrored = !0, a.model.hidden.validated.productTypeId.msg = Messages.getMessage("E0000004",
            "STO0200_LABEL_DOCTOR_BU")
    };
    a.showLocation = function() {
        a.map.center.latitude = a.model.hidden.map.latitude;
        a.map.center.longitude = a.model.hidden.map.longitude;
        a.marker = {
            id: 0,
            coords: {
                latitude: a.model.hidden.map.latitude,
                longitude: a.model.hidden.map.longitude
            }
        }
    };
    a.chooseArea = function(b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.form.STO0200CreateStoreInputModel.areaId = c
    };
    a.clearCreateParam = function() {
        a.model.form.STO0200CreateStoreInputModel = {
        	 docName: "",
             title:"",
             position:"",
             specialty:"",
             department:"",
             hospital:"",
             classs:"",
             zone:"",
             zoneId:null,
             mr:"",
             bu:"",
             productTypeId:null,
             adress: "",
             areaId: "",
             latVal: "",
             longVal: ""

        };
        a.model.hidden.map.latitude =
            "";
        a.model.hidden.map.longitude = ""
    };
    a.createStore = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && a.createStoreDataAndChangePage({
            docName: a.model.form.STO0200CreateStoreInputModel.docName,
            title: a.model.form.STO0200CreateStoreInputModel.title,
            position: a.model.form.STO0200CreateStoreInputModel.position,
            specialty: a.model.form.STO0200CreateStoreInputModel.specialty,
            department: a.model.form.STO0200CreateStoreInputModel.department,
            classs: a.model.form.STO0200CreateStoreInputModel.classs,
            hospital: a.model.form.STO0200CreateStoreInputModel.hospital,
            zone: a.model.form.STO0200CreateStoreInputModel.zone,
            zoneId: a.model.form.STO0200CreateStoreInputModel.zoneId,
            mr: a.model.form.STO0200CreateStoreInputModel.mr,
            bu: a.model.form.STO0200CreateStoreInputModel.bu,
            productTypeId: a.model.form.STO0200CreateStoreInputModel.productTypeId,
            isDoctor: 1,
            adress: a.model.form.STO0200CreateStoreInputModel.adress,
            areaId: a.model.form.STO0200CreateStoreInputModel.areaId,
            latVal: a.model.hidden.map.latitude,
            longVal: a.model.hidden.map.longitude
        })
    };
    a.createStoreContinus = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && a.createStoreData({
            docName: a.model.form.STO0200CreateStoreInputModel.docName,
            title: a.model.form.STO0200CreateStoreInputModel.title,
            position: a.model.form.STO0200CreateStoreInputModel.position,
            specialty: a.model.form.STO0200CreateStoreInputModel.specialty,
            department: a.model.form.STO0200CreateStoreInputModel.department,
            classs: a.model.form.STO0200CreateStoreInputModel.classs,
            hospital: a.model.form.STO0200CreateStoreInputModel.hospital,
            zone: a.model.form.STO0200CreateStoreInputModel.zone,
            zoneId: a.model.form.STO0200CreateStoreInputModel.zoneId,
            mr: a.model.form.STO0200CreateStoreInputModel.mr,
            bu: a.model.form.STO0200CreateStoreInputModel.bu,
            productTypeId: a.model.form.STO0200CreateStoreInputModel.productTypeId,
            isDoctor: 1,
            adress: a.model.form.STO0200CreateStoreInputModel.adress,
            areaId: a.model.form.STO0200CreateStoreInputModel.areaId,
            latVal: a.model.hidden.map.latitude,
            longVal: a.model.hidden.map.longitude
        })
    };
    a.findLocation = function() {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0200CreateStoreInputModel.adress) + "&sensor=false";
        d.get(b).success(function(b) {
            a.model.form.listPos = b
        })
    };
    a.findLocationEdit = function() {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0210SelectStoreResultDto.adress) + "&sensor=false";
        d.get(b).success(function(b) {
            a.model.form.listPos = b
        })
    };

    a.choosePos = function(b) {
        a.model.hidden.map.latitude = b.geometry.location.lat;
        a.model.hidden.map.longitude =
            b.geometry.location.lng;
        a.model.form.STO0200CreateStoreInputModel.adress = b.formatted_address;
        a.model.form.clickAddress = b.formatted_address;
        a.showLocation()
    };
    a.initData = function() {
        param = {};
        e.doPost("/STO0200/initData", param, function(b) {
            a.model.form.STO0200InitDataOutputModel = b
        })
    };
    a.createStoreDataAndChangePage = function(b) {
        e.doPost("/STO0200/regisStore", b, function(b) {
            a.model.form.STO0200CreateStoreResultDto = b;
            if (null != a.model.form.STO0200CreateStoreResultDto && "OK" == a.model.form.STO0200CreateStoreResultDto.proResult.proFlg) window.location.href =
                getContextPath() + "/STO0100/"
        })
    };
    a.createStoreData = function(b) {
        e.doPost("/STO0200/regisStore", b, function(b) {
            a.model.form.STO0200CreateStoreResultDto = b;
            null != a.model.form.STO0200CreateStoreResultDto && ("OK" == a.model.form.STO0200CreateStoreResultDto.proResult.proFlg ? (f.pop("success", a.model.form.STO0200CreateStoreResultDto.proResult.message, null, "trustedHtml"), a.clearCreateParam()) : f.pop("error", a.model.form.STO0200CreateStoreResultDto.proResult.message, null, "trustedHtml"))
        })
    }
}]);

var doc0210Module = angular.module("doc0210Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("DOC0210Ctrl", ["$scope", "$http", "serverService", "GoogleMapApi".ns(), "toaster", function(a, d, c, e, b) {
    a.model = {};
    a.model.form = {
        STO0210InitDataOutputModel: null,
        STO0210UpdateStoreInputModel: {
            storeId: "",
            storeCode: "",
            docName: "",
            title:"",
            position:"",
            specialty:"",
            department:"",
            classs:"",
            hospital:"",
            zone:"",
            zoneId:null,
            mr:"",
            bu:"",
            productTypeId:null,
            adress: "",
            areaId: null,
            latVal: "",
            longVal: "",
            versionNoStore: ""
        },
        STO0210SelectStoreResultDto: null,
        STO0210UpdateStoreResultDto: null
    };
    a.model.hidden = {
        validated: {
            isErrored: !1,
            storeName: {
                isErrored: !1,
                msg: ""
            },
            areaId: {
                isErrored: !1,
                msg: ""
            },
            zoneId: {
                isErrored: !1,
                msg: ""
            },
            productTypeId: {
                isErrored: !1,
                msg: ""
            }
        },
        map: {
            latitude: null,
            longitude: null
        },
        defaultAreaName: "",
        storeId: null,
        storeBackUp: null
    };
    a.init = function() {
        a.map = {
            center: {
                latitude: 10.771918,
                longitude: 106.698347
            },
            zoom: 18,
            events: {
                tilesloaded: function() {},
                click: function(b, c, e) {
                    var b = e[0],
                        i = b.latLng.lat(),
                        k = b.latLng.lng();
                    a.$apply(function() {
                        a.model.hidden.map.latitude = i;
                        a.model.hidden.map.longitude =
                            k;
                        a.marker = {
                            id: 0,
                            coords: {
                                latitude: a.model.hidden.map.latitude,
                                longitude: a.model.hidden.map.longitude
                            }
                        };
                        d.get("http://maps.google.com/maps/api/geocode/json?latlng=" + i + "," + k + "&sensor=false").success(function(b) {
                            var c = "";
                            "OK" == b.status && null != b.results && void 0 != b.results && angular.forEach(b.results, function(a) {
                                if ("street_address" == a.types) c = a.formatted_address
                            });
                            a.model.form.clickAddress = c
                        })
                    })
                }
            }
        };
        a.marker = {
            id: 0,
            coords: {
                latitude: 10.771918,
                longitude: 106.698347
            }
        };
        a.model.hidden.storeId = angular.element("#storeId").val();
        e.then(function() {});
        a.initData()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            storeName: {
                isErrored: !1,
                msg: ""
            },
            areaId: {
                isErrored: !1,
                msg: ""
            },
            zoneId: {
                isErrored: !1,
                msg: ""
            },
            productTypeId: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.STO0210SelectStoreResultDto.selectSore.docName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.storeName.isErrored = !0, a.model.hidden.validated.docName.msg = Messages.getMessage("E0000004", "STO0210_LABEL_STORE_NAME");
        if (null == a.model.form.STO0210SelectStoreResultDto.selectSore.areaId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.areaId.isErrored = !0, a.model.hidden.validated.areaId.msg = Messages.getMessage("E0000004", "STO0210_LABEL_REGION");
        if (null == a.model.form.STO0210SelectStoreResultDto.selectSore.zoneId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.zoneId.isErrored = !0, a.model.hidden.validated.zoneId.msg = Messages.getMessage("E0000004", "STO0200_LABEL_DOCTOR_ZONE");
        if (null == a.model.form.STO0210SelectStoreResultDto.selectSore.productTypeId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.productTypeId.isErrored = !0, a.model.hidden.validated.productTypeId.msg = Messages.getMessage("E0000004", "STO0200_LABEL_DOCTOR_BU")
    };
    a.showLocation = function() {
        a.map.center.latitude = a.model.hidden.map.latitude;
        a.map.center.longitude = a.model.hidden.map.longitude;
        a.marker = {
            id: 0,
            coords: {
                latitude: a.model.hidden.map.latitude,
                longitude: a.model.hidden.map.longitude
            }
        }
    };
    a.findLocationEdit = function() {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0210SelectStoreResultDto.selectSore.address) + "&sensor=false";
        d.get(b).success(function(b) {
            a.model.form.listPos = b
        })
    };

    a.choosePos = function(b) {
        a.model.hidden.map.latitude = b.geometry.location.lat;
        a.model.hidden.map.longitude = b.geometry.location.lng;
        a.model.form.STO0210SelectStoreResultDto.selectSore.address = b.formatted_address;
        a.model.form.clickAddress = b.formatted_address;
        a.showLocation()
    };
    a.chooseArea = function(b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.form.STO0210SelectStoreResultDto.selectSore.areaId = c
    };
    a.updateStore =
        function() {
            a.updateStoreDataAndChangePage({
                storeId: a.model.form.STO0210SelectStoreResultDto.selectSore.storeId,
                storeCode: a.model.form.STO0210SelectStoreResultDto.selectSore.storeCode,
                docName: a.model.form.STO0210SelectStoreResultDto.selectSore.docName,
                title: a.model.form.STO0210SelectStoreResultDto.selectSore.title,
                position: a.model.form.STO0210SelectStoreResultDto.selectSore.position,
                specialty: a.model.form.STO0210SelectStoreResultDto.selectSore.specialty,
                department: a.model.form.STO0210SelectStoreResultDto.selectSore.department,
                classs: a.model.form.STO0210SelectStoreResultDto.selectSore.classs,
                hospital: a.model.form.STO0210SelectStoreResultDto.selectSore.hospital,
                zone: a.model.form.STO0210SelectStoreResultDto.selectSore.zone,
                zoneId: a.model.form.STO0210SelectStoreResultDto.selectSore.zoneId,
                mr: a.model.form.STO0210SelectStoreResultDto.selectSore.mr,
                bu: a.model.form.STO0210SelectStoreResultDto.selectSore.bu,
                productTypeId: a.model.form.STO0210SelectStoreResultDto.selectSore.productTypeId,
                isDoctor: 1,
                adress: a.model.form.STO0210SelectStoreResultDto.selectSore.address,
                areaId: a.model.form.STO0210SelectStoreResultDto.selectSore.areaId,
                latVal: a.model.hidden.map.latitude,
                longVal: a.model.hidden.map.longitude,
                versionNoStore: a.model.form.STO0210SelectStoreResultDto.selectSore.versionNoStore
            })
        };
    a.updateStoreContinus = function() {
        a.updateStoreData({
            storeId: a.model.form.STO0210SelectStoreResultDto.selectSore.storeId,
            storeCode: a.model.form.STO0210SelectStoreResultDto.selectSore.storeCode,
            docName: a.model.form.STO0210SelectStoreResultDto.selectSore.docName,
            title: a.model.form.STO0210SelectStoreResultDto.selectSore.title,
            position: a.model.form.STO0210SelectStoreResultDto.selectSore.position,
            specialty: a.model.form.STO0210SelectStoreResultDto.selectSore.specialty,
            department: a.model.form.STO0210SelectStoreResultDto.selectSore.department,
            classs: a.model.form.STO0210SelectStoreResultDto.selectSore.classs,
            hospital: a.model.form.STO0210SelectStoreResultDto.selectSore.hospital,
            zone: a.model.form.STO0210SelectStoreResultDto.selectSore.zone,
            zoneId: a.model.form.STO0210SelectStoreResultDto.selectSore.zoneId,
            mr: a.model.form.STO0210SelectStoreResultDto.selectSore.mr,
            bu: a.model.form.STO0210SelectStoreResultDto.selectSore.bu,
            productTypeId: a.model.form.STO0210SelectStoreResultDto.selectSore.productTypeId,
            isDoctor: 1,
            adress: a.model.form.STO0210SelectStoreResultDto.selectSore.address,
            areaId: a.model.form.STO0210SelectStoreResultDto.selectSore.areaId,
            latVal: a.model.hidden.map.latitude,
            longVal: a.model.hidden.map.longitude,
            versionNoStore: a.model.form.STO0210SelectStoreResultDto.selectSore.versionNoStore
        })
    };
    a.initData = function() {
        param = {};
        c.doPost("/STO0210/initData", param, function(b) {
            a.model.form.STO0210InitDataOutputModel = b;
            a.selectStoreData(a.model.hidden.storeId)
        })
    };
    a.selectStoreData = function(b) {
        param = {
            storeId: b
        };
        c.doPost("/STO0210/selectStore", param, function(b) {
            a.model.hidden.storeBackUp = angular.copy(b);
            a.model.form.STO0210SelectStoreResultDto = b;
            for (b = 0; b < a.model.form.STO0210InitDataOutputModel.initData.areaInfo.items.length; b++) {
                var c = a.model.form.STO0210InitDataOutputModel.initData.areaInfo.items[b];
                if (c.areaId == a.model.form.STO0210SelectStoreResultDto.selectSore.areaId) {
                    a.model.hidden.defaultAreaName = c.areaName;
                    break
                }
                if (null != c.items)
                    for (var e = 0; e < c.items.length; e++) {
                        var f = c.items[e];
                        if (f.areaId == a.model.form.STO0210SelectStoreResultDto.selectSore.areaId) {
                            a.model.hidden.defaultAreaName = f.areaName;
                            break
                        }
                    }
            }
            a.model.hidden.map.latitude = a.model.form.STO0210SelectStoreResultDto.selectSore.latVal;
            a.model.hidden.map.longitude = a.model.form.STO0210SelectStoreResultDto.selectSore.longVal;
            a.showLocation()
        })
    };
    a.updateStoreDataAndChangePage = function(b) {
        c.doPost("/STO0210/updateStore", b, function(b) {
            a.model.form.STO0210UpdateStoreResultDto = b;
            if ("OK" == a.model.form.STO0210UpdateStoreResultDto.proResult.proFlg) window.location.href = getContextPath() + "/STO0100/"
        })
    };
    a.updateStoreData = function(e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && c.doPost("/STO0210/updateStore", e, function(c) {
            a.model.form.STO0210UpdateStoreResultDto = c;
            "OK" == a.model.form.STO0210UpdateStoreResultDto.proResult.proFlg ? (b.pop("success",
                a.model.form.STO0210UpdateStoreResultDto.proResult.message, null, "trustedHtml"), window.location.href = getContextPath() + "/STO0100/") : b.pop("error", a.model.form.STO0210UpdateStoreResultDto.proResult.message, null, "trustedHtml")
        })
    }
}]);

/**
 * END DOCTOR
 */

/**
 * START KPI
 */


var kpi0100Module = angular.module("kpi0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner"]).controller("KPI0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", "$filter", function(a, d, c, e, f) {
    a.init = function() {
        a.model = {};
        a.model.hidden = {
        		productTypeId:0,
        		currentMonth:"",
        		productTypeKpiId:0
        };
        a.model.form = {
        		KPI0100ResultSearchTeamModel: null,
            KPI0100Model:{
            	productTypeKpiId:"",
            	productTypeId:"",
            	currentMonth:"",
            	trainingDays:"",
            	callRate:"",
            	promotionDays:"",
            	meetingDays:"",
            	holidays:"",
            	leaveTaken:"",
            	frequency1:"",
            	frequency2:"",
            	frequency3:""

            },
            KPI0100SearchDataSalesmanResult:{
            	resultSearch:{
            		pagingInfo:null
            	}
            }
        };
        a.initData()
    };
    a.saveKpi = function(){
    	 d.doPost("/KPI0100/saveKpi", {
    		 productTypeKpiId:a.model.form.KPI0100Model.productTypeKpiId,
    		 productTypeId:a.model.hidden.productTypeId,
    		 currentMonth:a.model.form.KPI0100Model.currentMonth,
    		 trainingDays: a.model.form.KPI0100Model.trainingDays,
         	callRate: a.model.form.KPI0100Model.callRate,
         	promotionDays: a.model.form.KPI0100Model.promotionDays,
         	meetingDays: a.model.form.KPI0100Model.meetingDays,
         	holidays: a.model.form.KPI0100Model.holidays,
         	leaveTaken: a.model.form.KPI0100Model.leaveTaken,
         	frequency1: a.model.form.KPI0100Model.frequency1,
         	frequency2: a.model.form.KPI0100Model.frequency2,
         	frequency3: a.model.form.KPI0100Model.frequency3

    	 }, function(b) {
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
    	$("#result-add-times").css("display","inline-block");
    	a.searchData();
    };
    a.loadDataWhenChangeMonth = function(b){
    	a.model.hidden.currentMonth = b
    	a.searchData();
    }
    a.search = function() {
        a.searchDataOnly();
    };
    a.prevPage = function() {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage = a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };

    a.initData = function() {
        d.doPost("/KPI0100/initData", {}, function(b) {
            a.model.form.KPI0100ResultSearchTeamModel = b;
        })
    };

    a.searchData = function() {
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
        }, function(b) {
            a.model.form.KPI0100SearchDataSalesmanResult = b;
            a.model.form.KPI0100Model = b.timeInfo
            if (a.model.form.KPI0100Model.currentMonth == undefined){
            	 a.model.form.KPI0100Model.currentMonth = a.model.hidden.currentMonth;
            }else{
            	a.model.hidden.currentMonth = a.model.form.KPI0100Model.currentMonth;
            }
        })
    };
    a.searchDataOnly = function() {
        d.doPost("/COA0100/searchData", {
            searchInput: {
                coachingCode: a.model.form.searchParam.searchInput.coachingCode,
                coachingName: a.model.form.searchParam.searchInput.coachingName
            },
            pagingInfo: {
                ttlRow: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ? a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ?
                    a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo ? a.model.form.KPI0100SearchDataSalesmanResult.resultSearch.pagingInfo.rowNumber : null
            }
        }, function(b) {
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

kpi0100Module.directive('datetimez', function() {
    return {
        restrict: 'A',
        require : 'ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
          element.datetimepicker({
           format: "MM-yyyy",
           viewMode: "months",
            minViewMode: "months",
              pickTime: false
          }).on('changeDate', function(e) {
            ngModelCtrl.$setViewValue(e.date);
            scope.$apply();
            scope.loadDataWhenChangeMonth(e.date);
          });
        }
    };
});

mrpt0200Module.directive('datetimez', function() {
    return {
        restrict: 'A',
        require : 'ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
          element.datetimepicker({
           format: "MM-yyyy",
           viewMode: "months",
            minViewMode: "months",
              pickTime: false
          }).on('changeDate', function(e) {
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
var usr0200Module = angular.module("usr0200Module", ["dmsCommon", "toaster"]).controller("USR0200Ctrl", ["$scope", "serverService", "toaster", function(a, d, c) {
    a.model = {};
    a.model.form = {
        USR0200InitDataOutputModel: null,
        managerRegionChoose: null,
        buChoose: null,
        USR0200CreateUserInputModel: {
            userRole: "",
            clientId: "",
            fullName: "",
            email: "",
            phone: "",
            firstName: "",
            lastName: "",
            userName: "",
            password: "",
            rePassword: "",
            selectedUserLeaders: null,
            selectedSalesManager: null,
            selectedSalesManagers: [],
            selectedUserSubLeaders: [],
            selectedAreaId: [],
            selectedProduct: [],
            selectedSalesman: []
        },
        USR0200SearchUserResultDto: null,
        USR0200CreateUserResultDto: null
    };
    a.model.hidden = {
        selectedUserLeadersVersion: null,
        validated: {
            isErrored: !1,
            firstName: {
                isErrored: !1,
                msg: ""
            },
            lastName: {
                isErrored: !1,
                msg: ""
            },
            defaultRoleCd: {
                isErrored: !1,
                msg: ""
            },
            defaultClientId: {
                isErrored: !1,
                msg: ""
            },
            phone: {
                isErrored: !1,
                msg: ""
            },
            email: {
                isErrored: !1,
                msg: ""
            },
            checkEmail: {
                isErrored: !1,
                msg: ""
            },
            password: {
                isErrored: !1,
                msg: ""
            },
            rePassword: {
                isErrored: !1,
                msg: ""
            },
            checkPassword: {
                isErrored: !1,
                msg: ""
            },
            selectedUserLeaders: {
                isErrored: !1,
                msg: ""
            },
            selectedSalesManager: {
                isErrored: !1,
                msg: ""
            }
        }
    };
    a.init = function() {
        a.initData()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            firstName: {
                isErrored: !1,
                msg: ""
            },
            lastName: {
                isErrored: !1,
                msg: ""
            },
            defaultRoleCd: {
                isErrored: !1,
                msg: ""
            },
            defaultClientId: {
                isErrored: !1,
                msg: ""
            },
            email: {
                isErrored: !1,
                msg: ""
            },
            checkEmail: {
                isErrored: !1,
                msg: ""
            },
            phone: {
                isErrored: !1,
                msg: ""
            },
            password: {
                isErrored: !1,
                msg: ""
            },
            rePassword: {
                isErrored: !1,
                msg: ""
            },
            checkPassword: {
                isErrored: !1,
                msg: ""
            },
            selectedUserLeaders: {
                isErrored: !1,
                msg: ""
            },
            selectedSalesManager: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0200CreateUserInputModel.firstName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.firstName.isErrored = !0, a.model.hidden.validated.firstName.msg = Messages.getMessage("E0000004", "USR0200_LABEL_FIRSTNAME");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0200CreateUserInputModel.lastName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.lastName.isErrored = !0, a.model.hidden.validated.lastName.msg = Messages.getMessage("E0000004", "USR0200_LABEL_LASTNAME");
        if (null == a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.defaultRoleCd.isErrored = !0, a.model.hidden.validated.defaultRoleCd.msg = Messages.getMessage("E0000004", "USR0200_LABEL_POSITION");
        if ((3 == a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd || 4 == a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd || 5 == a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd) && null == a.model.form.USR0200InitDataOutputModel.initData.defaultClientId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.defaultClientId.isErrored = !0, a.model.hidden.validated.defaultClientId.msg = Messages.getMessage("E0000004", "USR0200_LABEL_CLIENT");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0200CreateUserInputModel.email)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.email.isErrored = !0, a.model.hidden.validated.email.msg = Messages.getMessage("E0000004", "USR0200_LABEL_EMAIL");
        if (!ValidateUtil.isValidEmail(a.model.form.USR0200CreateUserInputModel.email)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkEmail.isErrored = !0, a.model.hidden.validated.checkEmail.msg = Messages.getMessage("E0000020");
        if (!ValidateUtil.isValidTextTelNo(a.model.form.USR0200CreateUserInputModel.phone)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.phone.isErrored = !0, a.model.hidden.validated.phone.msg = Messages.getMessage("E0000010");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0200CreateUserInputModel.password)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.password.msg =
            Messages.getMessage("E0000004", "USR0200_LABEL_PASSWORD");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0200CreateUserInputModel.rePassword)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.rePassword.msg = Messages.getMessage("E0000004", "USR0200_LABEL_REPASSWORD");
        if (a.model.form.USR0200CreateUserInputModel.rePassword != a.model.form.USR0200CreateUserInputModel.password) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkPassword.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.checkPassword.msg = Messages.getMessage("E0000005");
        if (5 == a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd && null == a.model.form.USR0200CreateUserInputModel.selectedSalesManager) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.selectedSalesManager.isErrored = !0, a.model.hidden.validated.selectedSalesManager.msg = Messages.getMessage("E0000004", "USR0200_LABEL_SALES_MANAGER");
        if (6 == a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd && null == a.model.form.USR0200CreateUserInputModel.selectedUserLeaders) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.selectedUserLeaders.isErrored = !0, a.model.hidden.validated.selectedUserLeaders.msg = Messages.getMessage("E0000004", "USR0200_LABEL_REGION_MANAGER")
    };
    a.searchUserRole = function() {
        a.model.form.USR0200CreateUserInputModel.selectedUserLeaders = null;
        a.model.form.USR0200CreateUserInputModel.selectedSalesManager = null;
        a.model.form.USR0200CreateUserInputModel.selectedSalesManagers = [];
        a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders = [];
        a.model.form.USR0200CreateUserInputModel.selectedAreaId = [];
        a.model.form.USR0200CreateUserInputModel.selectedProduct = [];
        a.model.form.USR0200CreateUserInputModel.selectedSalesman = [];
        a.clearAreaCheck();
        null != a.model.form.USR0200SearchUserResultDto && a.subLeadersCheck();
        a.searchUserRoleData()
    };
    a.chooseBU = function() {
        for (var c = 0; c < a.model.form.USR0200SearchUserResultDto.lstUserLeader.length; c++) {
            var b = a.model.form.USR0200SearchUserResultDto.lstUserLeader[c];
            if (b.userId == a.model.form.USR0200CreateUserInputModel.selectedUserLeaders) a.model.hidden.buChoose = {
                userId: a.model.form.USR0200CreateUserInputModel.selectedUserLeaders,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseRegionManager = function() {
        for (var c = 0; c < a.model.form.USR0200SearchUserResultDto.lstSalesManager.length; c++) {
            var b = a.model.form.USR0200SearchUserResultDto.lstSalesManager[c];
            if (b.userId == a.model.form.USR0200CreateUserInputModel.selectedSalesManager) a.model.hidden.managerRegionChoose = {
                userId: a.model.form.USR0200CreateUserInputModel.selectedSalesManager,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseArea = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0200CreateUserInputModel.selectedAreaId.push({
            areaId: c.areaId
        });
        else
            for (var b = a.model.form.USR0200CreateUserInputModel.selectedAreaId.length, d = 0; d < b; d++)
                if (a.model.form.USR0200CreateUserInputModel.selectedAreaId[d].userId ==
                    c.userId) {
                    a.model.form.USR0200CreateUserInputModel.selectedAreaId.splice(d, 1);
                    break
                }
    };
    a.chooseSalesManager = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0200CreateUserInputModel.selectedSalesManagers.push({
            userId: c.userId,
            versionNo: c.versionNo
        });
        else
            for (var b = a.model.form.USR0200CreateUserInputModel.selectedSalesManagers.length, d = 0; d < b; d++)
                if (a.model.form.USR0200CreateUserInputModel.selectedSalesManagers[d].userId == c.userId) {
                    a.model.form.USR0200CreateUserInputModel.selectedSalesManagers.splice(d,
                        1);
                    break
                }
    };
    a.chooseSubLeader = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders.push({
            userId: c.userId,
            versionNo: c.versionNo
        });
        else
            for (var b = a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders.length, d = 0; d < b; d++)
                if (a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders[d].userId == c.userId) {
                    a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders.splice(d,
                        1);
                    break
                }
    };
    a.chooseProduct = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0200CreateUserInputModel.selectedProduct.push({
            product_type_id: c.product_type_id
        });
        else
            for (var b = a.model.form.USR0200CreateUserInputModel.selectedProduct.length, d = 0; d < b; d++)
                if (a.model.form.USR0200CreateUserInputModel.selectedProduct[d].product_type_id == c.product_type_id) {
                    a.model.form.USR0200CreateUserInputModel.selectedProduct.splice(d,
                        1);
                    break
                }
    };
    a.chooseSalesman = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0200CreateUserInputModel.selectedSalesman.push({
            salesman_id: c.salesman_id
        });
        else
            for (var b = a.model.form.USR0200CreateUserInputModel.selectedSalesman.length, d = 0; d < b; d++)
                if (a.model.form.USR0200CreateUserInputModel.selectedSalesman[d].salesman_id == c.salesman_id) {
                    a.model.form.USR0200CreateUserInputModel.selectedSalesman.splice(d,
                        1);
                    break
                }
    };
    a.clearCreateParam = function() {
        a.model.form.USR0200CreateUserInputModel = {
            userRole: "",
            clientId: "",
            fullName: "",
            email: "",
            phone: "",
            firstName: "",
            lastName: "",
            userName: "",
            password: "",
            rePassword: "",
            selectedUserLeaders: null,
            selectedSalesManager: null,
            selectedSalesManagers: [],
            selectedUserSubLeaders: [],
            selectedAreaId: [],
            selectedProduct: [],
            selectedSalesman: []
        };
        a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd = null;
        /*a.model.form.USR0200InitDataOutputModel.initData.defaultClientId = null;*/
        a.model.hidden.managerRegionChoose = null;
        a.model.hidden.buChoose = null
    };
    a.clearAreaCheck = function() {
        if (null != a.model.form.USR0200InitDataOutputModel.initData.lstAreaGroup.items)
            for (var c =
                    a.model.form.USR0200InitDataOutputModel.initData.lstAreaGroup.items.length, b = 0; b < c; b++) a.model.form.USR0200InitDataOutputModel.initData.lstAreaGroup.items[b].itemChoose = !1
    };
    a.subLeadersCheck = function() {
        if (null != a.model.form.USR0200SearchUserResultDto.lstUserSubLeader)
            for (var c = a.model.form.USR0200SearchUserResultDto.lstUserSubLeader.length, b = 0; b < c; b++) a.model.form.USR0200SearchUserResultDto.lstUserSubLeader[b].itemChoose = !1
    };
    a.createUser = function() {
        a.createUserDataAndChangePage({
            userRole: a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd,
            clientId: a.model.form.USR0200InitDataOutputModel.initData.defaultClientId,
            email: a.model.form.USR0200CreateUserInputModel.email,
            phone: a.model.form.USR0200CreateUserInputModel.phone,
            firstName: a.model.form.USR0200CreateUserInputModel.firstName,
            lastName: a.model.form.USR0200CreateUserInputModel.lastName,
            userName: a.model.form.USR0200CreateUserInputModel.userName,
            password: a.model.form.USR0200CreateUserInputModel.password,
            rePassword: a.model.form.USR0200CreateUserInputModel.rePassword,
            selectedUserLeaders: a.model.hidden.buChoose,
            selectedSalesManager: a.model.hidden.managerRegionChoose,
            selectedSalesManagers: a.model.form.USR0200CreateUserInputModel.selectedSalesManagers,
            selectedUserSubLeaders: a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders,
            selectedAreaId: a.model.form.USR0200CreateUserInputModel.selectedAreaId,
            selectedProduct: a.model.form.USR0200CreateUserInputModel.selectedProduct,
            selectedSalesman: a.model.form.USR0200CreateUserInputModel.selectedSalesman
        })
    };
    a.createUserContinus = function() {
        a.createUserData({
            userRole: a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd,
            clientId: a.model.form.USR0200InitDataOutputModel.initData.defaultClientId,
            email: a.model.form.USR0200CreateUserInputModel.email,
            phone: a.model.form.USR0200CreateUserInputModel.phone,
            firstName: a.model.form.USR0200CreateUserInputModel.firstName,
            lastName: a.model.form.USR0200CreateUserInputModel.lastName,
            userName: a.model.form.USR0200CreateUserInputModel.userName,
            password: a.model.form.USR0200CreateUserInputModel.password,
            rePassword: a.model.form.USR0200CreateUserInputModel.rePassword,
            selectedUserLeaders: a.model.hidden.buChoose,
            selectedSalesManager: a.model.hidden.managerRegionChoose,
            selectedSalesManagers: a.model.form.USR0200CreateUserInputModel.selectedSalesManagers,
            selectedUserSubLeaders: a.model.form.USR0200CreateUserInputModel.selectedUserSubLeaders,
            selectedAreaId: a.model.form.USR0200CreateUserInputModel.selectedAreaId,
            selectedProduct: a.model.form.USR0200CreateUserInputModel.selectedProduct,
            selectedSalesman: a.model.form.USR0200CreateUserInputModel.selectedSalesman
        })
    };
    a.initData = function() {
        param = {};
        d.doPost("/USR0200/initData",
            param,
            function(c) {
                a.model.form.USR0200InitDataOutputModel = c
            })
    };
    a.searchUserRoleData = function() {
        param = {
            selectClient: {
                clientId: a.model.form.USR0200InitDataOutputModel.initData.defaultClientId
            },
            roleCd: a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd
        };
        d.doPost("/USR0200/searchUserRole", param, function(c) {
            a.model.form.USR0200SearchUserResultDto = c

            if (null != a.model.form.USR0200SearchUserResultDto.lstSalesman)
                for (c = 0; c < a.model.form.USR0200SearchUserResultDto.lstSalesman.length; c++) {
                    var b = a.model.form.USR0200SearchUserResultDto.lstSalesman[c];

                    a.model.form.USR0200SearchUserResultDto.lstSalesman[c].display_name = b.salesman_code + ' - ' + b.salesman_name;
                }
        })
    };
    a.createUserDataAndChangePage = function(e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0200/createUser", e, function(b) {
            a.model.form.USR0200CreateUserResultDto = b;
            if (null != a.model.form.USR0200CreateUserResultDto.proResult) "OK" == a.model.form.USR0200CreateUserResultDto.proResult.proFlg ? window.location.href = getContextPath() + "/USR0100/" : c.pop("error", a.model.form.USR0200CreateUserResultDto.proResult.message, null, "trustedHtml")
        })
    };
    a.createUserData = function(e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0200/createUser", e, function(b) {
            a.model.form.USR0200CreateUserResultDto = b;
            null != a.model.form.USR0200CreateUserResultDto.proResult && ("OK" ==
                a.model.form.USR0200CreateUserResultDto.proResult.proFlg ? (c.pop("success", a.model.form.USR0200CreateUserResultDto.proResult.message, null, "trustedHtml"), a.clearCreateParam()) : c.pop("error", a.model.form.USR0200CreateUserResultDto.proResult.message, null, "trustedHtml"))
        })
    }
}]);
usr0200Module.directive("fileModel", ["$parse", function(a) {
    return {
        restrict: "A",
        link: function(d, c, e) {
            var b = a(e.fileModel).assign;
            c.bind("change", function() {
                d.$apply(function() {
                    b(d, c[0].files[0])
                })
            })
        }
    }
}]);
var usr0210Module = angular.module("usr0210Module", ["dmsCommon", "toaster"]).controller("USR0210Ctrl", ["$scope", "serverService", "toaster", function(a, d, c) {
    a.model = {};
    a.model.form = {
        USR0210InitDataOutputModel: null,
        USR0210CreateUserInputModel: {
            userRole: "",
            clientId: "",
            email: "",
            phone: "",
            firstName: "",
            lastName: "",
            userName: "",
            password: "",
            rePassword: "",
            selectedUserLeaders: null,
            selectedSalesManager: null,
            selectedSalesManagers: [],
            selectedUserSubLeaders: [],
            selectedAreaId: [],
            selectedProduct: [],
            selectedSalesman: []
        },
        USR0210SearchUserResultDto: null,
        USR0210CreateUserResultDto: null
    };
    a.model.hidden = {
        validated: {
            isErrored: !1,
            firstName: {
                isErrored: !1,
                msg: ""
            },
            lastName: {
                isErrored: !1,
                msg: ""
            },
            defaultRoleCd: {
                isErrored: !1,
                msg: ""
            },
            defaultClientId: {
                isErrored: !1,
                msg: ""
            },
            phone: {
                isErrored: !1,
                msg: ""
            },
            email: {
                isErrored: !1,
                msg: ""
            },
            checkEmail: {
                isErrored: !1,
                msg: ""
            },
            selectedUserLeaders: {
                isErrored: !1,
                msg: ""
            },
            selectedSalesManager: {
                isErrored: !1,
                msg: ""
            }
        },
        managerRegionChoose: null,
        buChoose: null
    };
    a.init = function() {
        a.model.hidden.userCode = angular.element("#userCode").val();
        a.initData()
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            firstName: {
                isErrored: !1,
                msg: ""
            },
            lastName: {
                isErrored: !1,
                msg: ""
            },
            defaultRoleCd: {
                isErrored: !1,
                msg: ""
            },
            defaultClientId: {
                isErrored: !1,
                msg: ""
            },
            email: {
                isErrored: !1,
                msg: ""
            },
            phone: {
                isErrored: !1,
                msg: ""
            },
            checkEmail: {
                isErrored: !1,
                msg: ""
            },
            selectedUserLeaders: {
                isErrored: !1,
                msg: ""
            },
            selectedSalesManager: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0210CreateUserInputModel.firstName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.firstName.isErrored = !0, a.model.hidden.validated.firstName.msg = Messages.getMessage("E0000004", "USR0210_LABEL_FIRSTNAME");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0210CreateUserInputModel.lastName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.lastName.isErrored = !0, a.model.hidden.validated.lastName.msg = Messages.getMessage("E0000004", "USR0210_LABEL_LASTNAME");
        if (null == a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.defaultRoleCd.isErrored = !0, a.model.hidden.validated.defaultRoleCd.msg = Messages.getMessage("E0000004", "USR0210_LABEL_POSITION");
        if ((3 == a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd || 4 == a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd ||
                5 == a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd) && null == a.model.form.USR0210InitDataOutputModel.initData.defaultClientId) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.defaultClientId.isErrored = !0, a.model.hidden.validated.defaultClientId.msg = Messages.getMessage("E0000004", "USR0210_LABEL_CLIENT");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0210CreateUserInputModel.email)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.email.isErrored = !0, a.model.hidden.validated.email.msg =
            Messages.getMessage("E0000004", "USR0210_LABEL_EMAIL");
        if (!ValidateUtil.isValidEmail(a.model.form.USR0210CreateUserInputModel.email)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkEmail.isErrored = !0, a.model.hidden.validated.checkEmail.msg = Messages.getMessage("E0000020");
        if (!ValidateUtil.isValidTextTelNo(a.model.form.USR0210CreateUserInputModel.phone)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.phone.isErrored = !0, a.model.hidden.validated.phone.msg = Messages.getMessage("E0000010");
        if (5 == a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd && null == a.model.form.USR0210CreateUserInputModel.selectedSalesManager) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.selectedSalesManager.isErrored = !0, a.model.hidden.validated.selectedSalesManager.msg = Messages.getMessage("E0000004", "USR0200_LABEL_SALES_MANAGER");
        if (6 == a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd && null == a.model.form.USR0210CreateUserInputModel.selectedUserLeaders) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.selectedUserLeaders.isErrored = !0, a.model.hidden.validated.selectedUserLeaders.msg = Messages.getMessage("E0000004", "USR0200_LABEL_REGION_MANAGER")
    };
    a.searchUserRole = function() {
        a.model.form.USR0210CreateUserInputModel.selectedUserLeaders = null;
        a.model.form.USR0210CreateUserInputModel.selectedSalesManager = null;
        a.model.form.USR0210CreateUserInputModel.selectedSalesManagers = [];
        a.model.form.USR0210CreateUserInputModel.selectedUserSubLeaders = [];
        a.model.form.USR0210CreateUserInputModel.selectedAreaId = [];
        a.model.form.USR0210CreateUserInputModel.selectedProduct = [];
        a.model.form.USR0210CreateUserInputModel.selectedSalesman = [];
        a.clearAreaCheck();
        null != a.model.form.USR0210SearchUserResultDto && a.subLeadersCheck();
        a.searchUserRoleData()
    };
    a.searchUserCode = function() {
        a.searchUserCodeData()
    };
    a.chooseArea = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0210CreateUserInputModel.selectedAreaId.push({
            areaId: c.areaId
        });
        else
            for (var b = a.model.form.USR0210CreateUserInputModel.selectedAreaId.length, d = 0; d < b; d++)
                if (a.model.form.USR0210CreateUserInputModel.selectedAreaId[d].areaId ==
                    c.areaId) {
                    a.model.form.USR0210CreateUserInputModel.selectedAreaId.splice(d, 1);
                    break
                }
    };
    a.chooseSalesManager = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0210CreateUserInputModel.selectedSalesManagers.push({
            userId: c.userId,
            versionNo: c.versionNo
        });
        else
            for (var b = a.model.form.USR0210CreateUserInputModel.selectedSalesManagers.length, d = 0; d < b; d++)
                if (a.model.form.USR0210CreateUserInputModel.selectedSalesManagers[d].userId == c.userId) {
                    a.model.form.USR0210CreateUserInputModel.selectedSalesManagers.splice(d,
                        1);
                    break
                }
    };
    a.chooseSubLeader = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0210CreateUserInputModel.selectedUserSubLeaders.push({
            userId: c.userId,
            versionNo: c.versionNo
        });
        else
            for (var b = a.model.form.USR0210CreateUserInputModel.selectedUserSubLeaders.length, d = 0; d < b; d++)
                if (a.model.form.USR0210CreateUserInputModel.selectedUserSubLeaders[d].userId == c.userId) {
                    a.model.form.USR0210CreateUserInputModel.selectedUserSubLeaders.splice(d,
                        1);
                    break
                }
    };
    a.chooseBU = function() {
        for (var c = 0; c < a.model.form.USR0210SearchUserResultDto.lstUserLeader.length; c++) {
            var b = a.model.form.USR0210SearchUserResultDto.lstUserLeader[c];
            if (b.userId == a.model.form.USR0210CreateUserInputModel.selectedUserLeaders) a.model.hidden.buChoose = {
                userId: a.model.form.USR0210CreateUserInputModel.selectedUserLeaders,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseRegionManager = function() {
        for (var c = 0; c < a.model.form.USR0210SearchUserResultDto.lstSalesManager.length; c++) {
            var b = a.model.form.USR0210SearchUserResultDto.lstSalesManager[c];
            if (b.userId == a.model.form.USR0210CreateUserInputModel.selectedSalesManager) a.model.hidden.managerRegionChoose = {
                userId: a.model.form.USR0210CreateUserInputModel.selectedSalesManager,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseProduct = function(c) {
        c.itemChoose = !c.itemChoose;
        if (!0 == c.itemChoose) a.model.form.USR0210CreateUserInputModel.selectedProduct.push({
                product_type_id: c.product_type_id
            });
        else
            for (var b = a.model.form.USR0210CreateUserInputModel.selectedProduct.length, d = 0; d < b; d++)
                if (a.model.form.USR0210CreateUserInputModel.selectedProduct[d].product_type_id == c.product_type_id) {
                    a.model.form.USR0210CreateUserInputModel.selectedProduct.splice(d, 1);
                    break
                }
    };
    a.clearCreateParam = function() {
        a.model.form.USR0210CreateUserInputModel = {
            userRole: "",
            userCode: "",
            clientId: "",
            email: "",
            phone: "",
            firstName: "",
            lastName: "",
            userName: "",
            password: "",
            rePassword: "",
            selectedUserLeaders: null,
            selectedSalesManager: null,
            selectedSalesManagers: [],
            selectedUserSubLeaders: [],
            selectedAreaId: [],
            selectedProduct: [],
            selectedSalesman: []
        };
        a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd = null;
        /*a.model.form.USR0210InitDataOutputModel.initData.defaultClientId = null;*/
        a.model.hidden.managerRegionChoose = null
        a.model.hidden.buChoose = null
    };
    a.clearAreaCheck = function() {
        if (null != a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items)
            for (var c = a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items.length,
                    b = 0; b < c; b++) a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items[b].itemChoose = !1
    };
    a.subLeadersCheck = function() {
        if (null != a.model.form.USR0210SearchUserResultDto.lstUserSubLeader)
            for (var c = a.model.form.USR0210SearchUserResultDto.lstUserSubLeader.length, b = 0; b < c; b++) a.model.form.USR0210SearchUserResultDto.lstUserSubLeader[b].itemChoose = !1
    };
    a.createUserContinus = function() {
        a.createUserData({
            userRole: a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd,
            userCode: a.model.hidden.userCode,
            clientId: a.model.form.USR0210InitDataOutputModel.initData.defaultClientId,
            email: a.model.form.USR0210CreateUserInputModel.email,
            phone: a.model.form.USR0210CreateUserInputModel.phone,
            firstName: a.model.form.USR0210CreateUserInputModel.firstName,
            lastName: a.model.form.USR0210CreateUserInputModel.lastName,
            userName: a.model.form.USR0210CreateUserInputModel.userName,
            password: a.model.form.USR0210CreateUserInputModel.password,
            rePassword: a.model.form.USR0210CreateUserInputModel.rePassword,
            selectedSalesManager: a.model.hidden.managerRegionChoose,
            selectedUserLeaders: a.model.hidden.buChoose,
            selectedSalesManagers: a.model.form.USR0210CreateUserInputModel.selectedSalesManagers,
            selectedUserSubLeaders: a.model.form.USR0210CreateUserInputModel.selectedUserSubLeaders,
            selectedAreaId: a.model.form.USR0210CreateUserInputModel.selectedAreaId,
            selectedProduct: a.model.form.USR0210CreateUserInputModel.selectedProduct,
            selectedSalesman: a.model.form.USR0210CreateUserInputModel.selectedSalesman
        })
    };
    a.initData = function() {
        param = {};
        d.doPost("/USR0210/initData", param, function(c) {
            a.model.form.USR0210InitDataOutputModel = c;
            if (null != a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items)
                for (var c = a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items.length, b = 0; b < c; b++) a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items[b].itemChoose = !1;
            a.searchUserCode()
        })
    };
    a.searchUserRoleData = function() {
        param = {
            userCode: a.model.hidden.userCode,
            selectClient: {
                clientId: a.model.form.USR0210InitDataOutputModel.initData.defaultClientId
            },
            roleCd: a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd
        };
        d.doPost("/USR0210/searchUserRole", param, function(c) {
            a.model.form.USR0210SearchUserResultDto = c;

            if (null != a.model.form.USR0210SearchUserResultDto.lstUserSubLeader)
                for (c = 0; c < a.model.form.USR0210SearchUserResultDto.lstUserSubLeader.length; c++) {
                    var b =
                        a.model.form.USR0210SearchUserResultDto.lstUserSubLeader[c];
                    b.itemChoose = !1;
                    if (null != a.model.form.USR0210SearchUserResultDto.selectUserSubLeader)
                        for (var d = 0; d < a.model.form.USR0210SearchUserResultDto.selectUserSubLeader.length; d++) {
                            var h = a.model.form.USR0210SearchUserResultDto.selectUserSubLeader[d];
                            h == b.userId && a.chooseSubLeader(b)
                        }
                }
            a.chooseBU();
            a.chooseRegionManager();
            if (null != a.model.form.USR0210SearchUserResultDto.lstSalesManager)
                for (c = 0; c < a.model.form.USR0210SearchUserResultDto.lstSalesManager.length; c++) {
                    var b =
                        a.model.form.USR0210SearchUserResultDto.lstSalesManager[c];
                    b.itemChoose = !1;
                    if (null != a.model.form.USR0210SearchUserResultDto.selectSalesManagers)
                        for (var d = 0; d < a.model.form.USR0210SearchUserResultDto.selectSalesManagers.length; d++) {
                            var h = a.model.form.USR0210SearchUserResultDto.selectSalesManagers[d];
                            h == b.userId && a.chooseSalesManager(b)
                        }
                }
            if (null != a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items)
                for (c = 0; c < a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items.length; c++)
                    if (b =
                        a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items[c], b.itemChoose = !1, null != a.model.form.USR0210SearchUserResultDto.lstAreaGroup)
                        for (d = 0; d < a.model.form.USR0210SearchUserResultDto.lstAreaGroup.length; d++) h = a.model.form.USR0210SearchUserResultDto.lstAreaGroup[d], h.areaId == b.areaId && a.chooseArea(b)

            if (null != a.model.form.USR0210SearchUserResultDto.lstProduct)
                for (c = 0; c < a.model.form.USR0210SearchUserResultDto.lstProduct.length; c++) {
                    var b = a.model.form.USR0210SearchUserResultDto.lstProduct[c];
                    b.itemChoose = !1;
                    if (null != a.model.form.USR0210SearchUserResultDto.selectProduct)
                        for (var d = 0; d < a.model.form.USR0210SearchUserResultDto.selectProduct.length; d++) {
                            var h = a.model.form.USR0210SearchUserResultDto.selectProduct[d];
                            h == b.product_type_id && a.chooseProduct(b)
                        }
                }

            if (null != a.model.form.USR0210SearchUserResultDto.lstSalesman)
                for (c = 0; c < a.model.form.USR0210SearchUserResultDto.lstSalesman.length; c++) {
                    var b = a.model.form.USR0210SearchUserResultDto.lstSalesman[c];

                    a.model.form.USR0210SearchUserResultDto.lstSalesman[c].display_name = b.salesman_code + ' - ' + b.salesman_name;
                }

            a.model.form.USR0210CreateUserInputModel.selectedSalesman = a.model.form.USR0210SearchUserResultDto.selectSalesman;
        })
    };
    a.searchUserCodeData = function() {
        param = {
            userCode: a.model.hidden.userCode
        };
        d.doPost("/USR0210/searchUserCode", param, function(c) {
            a.model.form.USR0210SearchUserCodeResultDto = c;
            a.model.form.USR0210CreateUserInputModel.firstName =
                a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.fistName;
            a.model.form.USR0210CreateUserInputModel.lastName = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.lastName;
            a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd = parseInt(a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.userRoleCd);
            if (null != a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.clientId) a.model.form.USR0210InitDataOutputModel.initData.defaultClientId = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.clientId.toString();
            a.model.form.USR0210CreateUserInputModel.email = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.email;
            a.model.form.USR0210CreateUserInputModel.phone = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.phoneNo;
            a.model.form.USR0210CreateUserInputModel.userName = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.userName;
            a.model.form.USR0210CreateUserInputModel.selectedUserLeaders = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.parentId;
            a.model.form.USR0210CreateUserInputModel.selectedSalesManager = a.model.form.USR0210SearchUserCodeResultDto.searchUserCode.parentId;
            a.searchUserRoleData()
        })
    };
    a.createUserData =
        function(e) {
            a.validate();
            !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0210/updateUser", e, function(b) {
                a.model.form.USR0210CreateUserResultDto = b;
                "OK" == a.model.form.USR0210CreateUserResultDto.proResult.proFlg ? c.pop("success", a.model.form.USR0210CreateUserResultDto.proResult.message, null, "trustedHtml") : c.pop("error", a.model.form.USR0210CreateUserResultDto.proResult.message, null, "trustedHtml")
            })
        }
}]);


angular.module("coa0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner"]).controller("COA0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.init = function() {
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
    a.search = function() {
        a.searchDataOnly()
    };
    a.prevPage = function() {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.deleteDataCoaching = function (param){
        d.doPost("/COA0100/deleteCoaching", param, function(b) {
            null != b.proResult && ("NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message,
                    null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml"))
                 a.searchDataOnly()
        })

    };
    a.deleteCoaching = function(b){
    	a.deleteDataCoaching({
    		coachingTemplateId:b.coaching_template_id
        })
    };

    a.initData = function() {
        d.doPost("/COA0100/initData", {}, function(b) {
            a.model.form.COA0100InitDataModel = b;
        })
    };
    a.searchData = function() {
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
        }, function(b) {
            a.model.form.COA0100SearchDataResult = b;
            a.model.form.COA0100InitDataModel.resultSearch.coaInfo = a.model.form.COA0100SearchDataResult.resultSearch.coaInfo;
            a.model.form.COA0100InitDataModel.resultSearch.pagingInfo = a.model.form.COA0100SearchDataResult.resultSearch.pagingInfo
        })
    };
    a.searchDataOnly = function() {
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
        }, function(b) {
            a.model.form.COA0100SearchDataResult = b;
            a.model.form.COA0100InitDataModel.resultSearch.coaInfo =
                a.model.form.COA0100SearchDataResult.resultSearch.coaInfo;
            a.model.form.COA0100InitDataModel.resultSearch.pagingInfo = a.model.form.COA0100SearchDataResult.resultSearch.pagingInfo;
        })
    }
}]);
