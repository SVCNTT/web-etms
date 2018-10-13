angular.module("sal0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner", "sal0110Module"]).controller("SAL0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
            function () {
                a.model.hidden.showImportMrs = !1
            });
        a.initData()
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.importMrs = function () {
        a.model.hidden.showImportMrs = !0
    };


    a.prevPage = function () {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.SAL0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.deleteSale = function (b) {
        param = {
            salesmanId: b.salesmanId
        };
        d.doPost("/SAL0100/deleteSalman", param, function (b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
            a.searchDataOnly()
        })
    };
    a.activeSal = function (b) {
        param = {
            salesmanId: b.salesmanId,
            salesmanCode: b.salesmanCode
        };
        d.doPost("/SAL0100/activatSalman", param, function (b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
            a.searchDataOnly()
        })
    };
    a.showModalPasswordReset = function () {
        a.model.hidden.showModalResetPassword = !0
    };
    a.showModalEditUser = function () {
        a.model.hidden.showModalEditUser = !0
    };
    a.initData = function () {
        d.doPost("/SAL0100/initData", {}, function (b) {
            a.model.form.SAL0100InitDataModel = b;
            if (null != a.model.form.SAL0100InitDataModel.resultSearch.salInfo)
                for (b = 0; b < a.model.form.SAL0100InitDataModel.resultSearch.salInfo.length; b++) {
                    var c = a.model.form.SAL0100InitDataModel.resultSearch.salInfo[b];
                    c.imagePathUrl = getContextPath() + c.imagePath
                }
        })
    };
    a.searchData = function () {
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
        }, function (b) {
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
    a.searchDataOnly = function () {
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
        }, function (b) {
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

angular.module("sal0110Module", ["dmsCommon", "toaster"]).controller("SAL0110Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function (a, d, c, e, b) {
    a.init = function () {
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
    a.chooseFile = function () {
        // event.stopPropagation();
        angular.element("#SAL0110ChooseFile").click()
    };
    a.closeImportMrs = function () {
        c.$broadcast("SAL0100#closeImportMrs", {})
    };
    a.getFile = function (b) {
        a.model.form.file = b
    };
    a.setFiles = function (b) {
        a.$apply(function () {
            a.files = [];
            for (var c = 0; c < b.files.length; c++) a.files.push(b.files[c])
        })
    };
    a.upload = function () {
        var f = {
            clientId: a.model.hidden.clientId
        };
        d.uploadFile("/SAL0120", a.model.form.file, f, function (f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("SAL0100#closeImportStore", {})))

            if (null != f.proResult.proFlg && "OK" == f.proResult.proFlg) window.location.href =
                getContextPath() + "/SAL0100/"


        })
    }
}]);


angular.module("sal0300Module", "dmsCommon,fcsa-number,toaster,sal0310Module,sal0320Module,sal0330Module,sal0340Module,ngLoadingSpinner".split(",")).controller("SAL0300Ctrl", ["$scope", "$rootScope", "serverService", "toaster", function (a, d, c, e) {
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
    a.init = function () {
        a.model.hidden.salesmanId = angular.element("#salesmanId").val();
        a.model.hidden.salesmanCode = angular.element("#salesmanCode").val();
        a.model.hidden.imageUrl = getContextPath() + angular.element("#imageSale").val();
        a.$on("SAL0300#showSAL3010", function (b, c) {
            a.model.hidden.showSAL0310 = c.showSAL0310
        });
        a.$on("SAL0300#showSAL0320", function (b, c) {
            a.model.hidden.showSAL0320 = c.showSAL0320
        });
        a.$on("SAL0300#closeResetPasswordAfterChange", function (b, c) {
            a.model.hidden.showSAL0310 = c.showModalResetPassword;
            e.pop("success", c.message, null, "trustedHtml")
        })
    };
    a.showPopupDetail = function (b) {
        a.model.hidden.activeRow =
            b;
        a.model.hidden.showPopupDetail = !0
    };
    a.resetPasswordSale = function () {
        a.model.hidden.showSAL0310 = !0
    };
    a.showModalEditSale = function () {
        a.model.hidden.showSAL0320 = !0
    }
}]);
angular.module("sal0310Module", ["dmsCommon", "fcsa-number"]).controller("SAL0310Ctrl", ["$scope", "serverService", "$rootScope", function (a, d, c) {
    a.resetPinData = function (a, b) {
        d.doPost("/SAL0310/resetPin", a, function (a) {
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
    a.init = function () {
    };
    a.validate = function () {
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
    a.closePassword = function () {
        a.model.hidden.showSAL0310 = !1;
        c.$broadcast("SAL0300#showSAL3010", {
            showSAL0310: a.model.hidden.showSAL0310
        })
    };
    a.resetPassword = function () {
        param = {
            salesmanCode: a.model.hidden.salesmanCode,
            salesmanId: a.model.hidden.salesmanId,
            pinCode: a.model.form.CLI0310ResetPassword.pinCode
        };
        a.validate();
        !0 != a.model.hidden.validated.isErrored &&
        a.resetPinData(param, function (e) {
            a.model.form.SAL0310ResetPasswordResult = e;
            null != a.model.form.SAL0310ResetPasswordResult.proResult && "OK" == a.model.form.SAL0310ResetPasswordResult.proResult.proFlg && c.$broadcast("SAL0300#closeResetPasswordAfterChange", {
                showModalResetPassword: !1,
                message: a.model.form.SAL0310ResetPasswordResult.proResult.message
            })
        })
    }
}]);
angular.module("sal0320Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("SAL0320Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.updateSalesmanData = function (a, c) {
        d.doPost("/SAL0320/updateSalesman", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    a.init = function () {
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
                jobTitle: null,
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
    a.validate = function () {
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
    a.closeEdit = function () {
        a.model.hidden.showSAL0320 = !1;
        c.$broadcast("SAL0300#showSAL0320", {
            showSAL0320: a.model.hidden.showSAL0320
        })
    };
    a.updateSale = function () {
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
        }, a.updateSalesmanData(param, function (b) {
            a.model.form.SAL0320UpdateSaleResult = b.proResult;
            "NG" == a.model.form.SAL0320UpdateSaleResult.proFlg ? e.pop("error", a.model.form.SAL0330addStoreResult.message, null, "trustedHtml") : window.location.href = getContextPath() + "/SAL0300/" + a.model.form.SAL0320UpdateSaleInputModel.salesmanCode
        }))
    }
}]);
angular.module("sal0330Module", ["dmsCommon", "toaster"]).controller("SAL0330Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
        }, function (b) {
            a.model.form.SAL0330InitOutputModel = b
        })
        a.searchStoreNotAssign();
    };
    a.chooseArea = function (b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.hidden.areaId = c
    };
    a.chooseAreaNotAssign = function (b, c) {
        a.model.hidden.defaultAreaNameNotAssign = b;
        a.model.hidden.areaIdNotAssign = c
    };
    a.searchStore = function () {
        a.searchDataStoreOnly()
    };
    a.prevPageStore = function () {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchDataStore()
    };
    a.nextPageStore = function () {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataStore()
    };
    a.startPageStore = function () {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataStore()
    };
    a.endPageStore = function () {
        a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataStore()
    };
    a.searchStoreNotAssign = function () {
        a.searchDataStoreNotAssignOnly()
    };
    a.prevPageStoreNotAssign = function () {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage -= 1;
        a.searchDataStoreNotAssign()
    };
    a.nextPageStoreNotAssign = function () {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage += 1;
        a.searchDataStoreNotAssign()
    };
    a.startPageStoreNotAssign = function () {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage = 1;
        a.searchDataStoreNotAssign()
    };
    a.endPageStoreNotAssign = function () {
        a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage =
            a.model.form.SAL0330ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages;
        a.searchDataStoreNotAssign()
    };
    a.addStore = function () {
        a.addStoreData({
            salesmanId: a.model.hidden.salesmanId,
            storeIdList: a.model.form.listSelectStore
        }, function (b) {
            a.model.form.SAL0330CreateResultDto = b.proResult;
            a.model.form.listSelectStore = [];
            a.searchDataStoreNotAssign();
            a.searchStore();
            null != a.model.form.SAL0330CreateResultDto && ("NG" == a.model.form.SAL0330CreateResultDto.proFlg ? e.pop("error", a.model.form.SAL0330CreateResultDto.message,
                null, "trustedHtml") : e.pop("success", a.model.form.SAL0330CreateResultDto.message, null, "trustedHtml"))
        })
    };
    a.deleteStore = function (b) {
        a.deleteUserStoresmanData({
            salesmanId: a.model.hidden.salesmanId,
            storeId: b.storeId
        }, function (b) {
            a.model.form.SAL0330DeleteResultDto = b;
            a.searchDataStore()
        })
    };
    a.chooseStore = function (b) {
        !1 == b.choose && a.removeStoreItem(b);
        !0 == b.choose && a.addStoreItem(b)
    };
    a.removeStoreItem = function (b) {
        for (var c = 0; c < a.model.form.listSelectStore.length; c++)
            if (a.model.form.listSelectStore[c] == b.storeId) {
                a.model.form.listSelectStore.splice(c,
                    1);
                break
            }
        a.checkChooseAll()
    };
    a.addStoreItem = function (b) {
        a.model.form.listSelectStore.push(b.storeId);
        a.checkChooseAll()
    };
    a.chooseAll = function () {
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
    a.checkChooseAll = function () {
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
    a.checkChooseAllAfterSearch = function () {
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
    a.initData = function (a, c) {
        d.doPost("/SAL0330/initData", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    a.searchDataStore = function () {
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
        d.doPost("/SAL0330/searchStoreAssigned", param, function (b) {
            a.model.form.SAL0330ResultSearchModel = b;
            a.model.form.SAL0330InitOutputModel.resultSearch.storeInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreOnly = function () {
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
        d.doPost("/SAL0330/searchStoreAssigned", param, function (b) {
            a.model.form.SAL0330ResultSearchModel = b;
            a.model.form.SAL0330InitOutputModel.resultSearch.storeInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.SAL0330InitOutputModel.resultSearch.pagingInfo = a.model.form.SAL0330ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreNotAssign = function () {
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
        d.doPost("/SAL0330/searchStoreNotAssign", param, function (b) {
            a.model.form.SAL0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataStoreNotAssignOnly = function () {
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
        d.doPost("/SAL0330/searchStoreNotAssign", param, function (b) {
            a.model.form.SAL0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.addStoreData = function (a, c) {
        d.doPost("/SAL0330/addStore", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    a.deleteUserStoresmanData = function (a, c) {
        d.doPost("/SAL0330/deleteStore", a, function (a) {
            (c || angular.noop)(a)
        })
    }
}]);
angular.module("sal0340Module", ["dmsCommon"]).controller("SAL0340Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.searchSaleLeaveData = function (a, e) {
        d.doPost("/SAL0340/searchData", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.initDate = function () {
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
    a.init = function () {
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
    a.prevPage = function () {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchSaleLeave()
    };
    a.nextPage = function () {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage += 1;
        a.searchSaleLeave()
    };
    a.startPage = function () {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage = 1;
        a.searchSaleLeave()
    };
    a.endPage = function () {
        a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage = a.model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlPages;
        a.searchSaleLeave()
    };
    a.searchSaleLeave = function () {
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
        a.searchSaleLeaveData(param, function (c) {
            a.model.form.SAL0340initModalResult = c
        })
    }
}]);
angular.module("sal0401Module", ["dmsCommon", "google-maps".ns()]).config(["GoogleMapApiProvider".ns(), function (a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("SAL0401Ctrl", ["$scope", "serverService", "$rootScope", "GoogleMapApi".ns(), function (a, d, c, e) {
    a.searchDataSalmanAttendaceData = function (a, c) {
        d.doPost("/CLI0400/searchDataSalmanAttendace", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    e.then(function () {
    });
    a.getCurrentDay = function () {
        var a = new Date,
            c = a.getDate(),
            e = a.getMonth() +
                1,
            a = a.getFullYear();
        10 > c && (c = "0" + c);
        10 > e && (e = "0" + e);
        return c + "-" + e + "-" + a
    };
    a.init = function () {
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
            function (b, c) {
                a.model.hidden.salesmanId = c.saleChoose.salesmanId;
                a.model.hidden.salesmanCode = c.saleChoose.salesmanCode;
                a.model.hidden.salesmanName = c.saleChoose.salesmanName;
                a.model.hidden.indexPositionChoose = 0;
                a.randomMarkers = [];
                a.searchDataSalmanAttendace()
            })
    };
    a.search = function () {
        a.searchDataSalmanAttendace()
    };
    a.searchDataSalmanAttendace = function () {
        param = {
            clientId: a.model.hidden.clientId,
            salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
            attencanceDate: a.model.hidden.attencanceDate
        };
        a.searchDataSalmanAttendaceData(param,
            function (b) {
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
    a.checkshowMapPosition = function (b) {
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
        a.randomMarkers.forEach(function (b) {
            b.onClicked =
                function () {
                    a.onMarkerClicked(b)
                };
            b.closeClick = function () {
                b.showWindow = !1;
                a.$apply()
            }
        })
    };
    a.$watchCollection("model.hidden.attencanceDate", function () {
        a.searchDataSalmanAttendace()
    });
    a.onMarkerClicked = function (b) {
        markerToClose = b;
        b.showWindow = !0;
        a.$apply()
    };
    a.choosePosition = function (b, c) {
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
angular.module("sal0402Module", ["dmsCommon"]).controller("SAL0402Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.searchBillSalesmanData = function (a, e) {
        d.doPost("/CLI0400/searchBillSalesman", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.getCurrentDay = function () {
        var a = new Date,
            e = a.getDate(),
            b = a.getMonth() + 1,
            a = a.getFullYear();
        10 > e && (e = "0" + e);
        10 > b && (b = "0" + b);
        return e + "-" + b + "-" + a
    };
    a.init = function () {
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
        a.$on("SAL0402#search", function () {
            a.searchBillSalesman()
        })
    };
    a.search = function () {
        a.searchBillSalesman()
    };
    a.searchBillSalesman = function () {
        param = {
            clientId: a.model.hidden.clientId,
            salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
            selectDate: a.model.hidden.searchBillSalesman
        };
        a.searchBillSalesmanData(param, function (c) {
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
    a.$watchCollection("model.hidden.searchBillSalesman", function () {
        a.searchBillSalesman()
    })
}]);
angular.module("sal0403Module", ["dmsCommon"]).controller("SAL0403Ctrl", ["$scope", "serverService", "$rootScope", function (a) {
    a.init = function () {
        a.model = {};
        a.model = {
            hidden: {}
        };
        a.model.form = {};
        a.model.hidden.clientId = angular.element("#clientId").val()
    }
}]);
angular.module("sal0404Module", ["dmsCommon", "ui.calendar"]).controller("SAL0404Ctrl", ["$scope", "serverService", "$rootScope", "uiCalendarConfig", function (a, d, c, e) {
    a.searchDataSalmanLeaveData = function (a, c) {
        d.doPost("/CLI0400/searchDataSalmanLeave", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    a.init = function () {
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
        a.changeView = function (a) {
            e.calendars.myCalendar.fullCalendar("changeView",
                a)
        };
        a.renderCalender = function () {
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
                viewRender: function (b) {
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
        a.$on("SAL0404#search", function () {
            a.searchDataSalmanLeave(a.model.hidden.dateShow)
        })
    };
    a.searchDataSalmanLeave = function (b) {
        param = {
            salesmanId: a.$parent.model.form.currentSaleChoose.salesmanId,
            selectedDate: b
        };
        a.searchDataSalmanLeaveData(param, function (b) {
            for (; 0 < a.events.length;) a.events.splice(0, 1);
            a.model.form.CLI0400SearchDataSalmanLeaveResult = b;
            0 < a.model.form.CLI0400SearchDataSalmanLeaveResult.resultSearch.searchSalLeave.length &&
            a.addEvent(a.model.form.CLI0400SearchDataSalmanLeaveResult.resultSearch.searchSalLeave)
        })
    };
    a.addEvent = function (b) {
        for (var c = 0; c < b.length; c++) event = {
            title: b[c].contText,
            start: new Date(b[c].leaveDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")),
            end: new Date(b[c].leaveDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"))
        }, a.events.push(event);
        a.eventSources = [a.events];
        a.renderCalender()
    }
}]);