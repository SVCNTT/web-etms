/**
 * Created by ledaicanh on 11/16/17.
 */
angular.module("usr0100Module", ["dmsCommon", "usr0110Module", "ngAnimate", "toaster", "ngLoadingSpinner"]).controller("USR0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", "$timeout", function (a, d, c, e, b) {
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
        a.$on("USR0100#closeResetPassword", function (b, c) {
            a.model.hidden.showModalResetPassword = c.showModalResetPassword
        });
        a.$on("USR0100#closeResetPasswordAfterChange", function (b, c) {
            a.model.hidden.showModalResetPassword = c.showModalResetPassword;
            e.pop("success", c.message, null, "trustedHtml")
        });
        a.initData()
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage +=
            1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.USR0100InitDataModel.initSearch.pagingInfo.crtPage = a.model.form.USR0100InitDataModel.initSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.showModalPasswordReset = function (e) {
        a.model.hidden.showModalResetPassword = !0;
        b(function () {
            c.$broadcast("USR0110#sendUserCode", {
                userCode: e.userCode
            })
        }, 10)
    };
    a.showModalEditUser = function () {
        a.model.hidden.showModalEditUser = !0
    };
    a.deleteUser = function (b) {
        param = {
            userCode: b.userCode
        };
        a.deleteUserData(param)
    };
    a.initData = function () {
        d.doPost("/USR0100/initData", {}, function (b) {
            a.model.form.USR0100InitDataModel = b
        })
    };
    a.deleteUserData = function () {
        d.doPost("/USR0100/deleteUser", param, function (b) {
            "OK" == b.proResult.proFlg && (e.pop("success", b.proResult.message, null, "trustedHtml"), a.search());
            "NG" == b.proResult.proFlg && e.pop("error", b.proResult.message, null, "trustedHtml")
        })
    };
    a.searchData = function () {
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
        }, function (b) {
            a.model.form.USR0100SearchDataInputModel = b;
            a.model.form.USR0100InitDataModel.initSearch.userInfo.lstUser = a.model.form.USR0100SearchDataInputModel.resultSearch.userInfo.lstUser;
            a.model.form.USR0100InitDataModel.initSearch.pagingInfo = a.model.form.USR0100SearchDataInputModel.resultSearch.pagingInfo
        })
    };
    a.searchDataOnly = function () {
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
        }, function (b) {
            a.model.form.USR0100SearchDataInputModel = b;
            a.model.form.USR0100InitDataModel.initSearch.userInfo.lstUser = a.model.form.USR0100SearchDataInputModel.resultSearch.userInfo.lstUser;
            a.model.form.USR0100InitDataModel.initSearch.pagingInfo = a.model.form.USR0100SearchDataInputModel.resultSearch.pagingInfo
        })
    }
}]);

angular.module("usr0110Module", ["dmsCommon", "toaster"]).controller("USR0110Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
        a.$on("USR0110#sendUserCode", function (b,
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
    a.resetPassword = function () {
        param = {
            userCode: a.model.hidden.userCode,
            password: a.model.form.USR0110ResetPasswordInput.password,
            rePassword: a.model.form.USR0110ResetPasswordInput.rePassword
        };
        a.resetPasswordData(param)
    };
    a.closeResetPassword = function () {
        a.model.hidden.showModalResetPassword = !1;
        c.$broadcast("USR0100#closeResetPassword", {
            showModalResetPassword: a.model.hidden.showModalResetPassword
        })
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
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0110ResetPasswordInput.password)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.password.msg = Messages.getMessage("E0000004", "USR0100_LABEL_PASSWORD");
        if (!ValidateUtil.isValidTextRequired(a.model.form.USR0110ResetPasswordInput.rePassword)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.rePassword.msg = Messages.getMessage("E0000004", "USR0100_LABEL_CONFIRM_PASSWORD");
        if (a.model.form.USR0110ResetPasswordInput.rePassword != a.model.form.USR0110ResetPasswordInput.password) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checkPassword.isErrored = !0, a.model.hidden.validated.password.isErrored = !0, a.model.hidden.validated.rePassword.isErrored = !0, a.model.hidden.validated.checkPassword.msg = Messages.getMessage("E0000005")
    };
    a.resetPasswordData = function (b) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0110/resetPassword", b, function (b) {
            a.model.form.USR0110ResetPasswordResult = b;
            if (null != a.model.form.USR0110ResetPasswordResult.proResult && "OK" == a.model.form.USR0110ResetPasswordResult.proResult.proFlg) a.model.hidden.showModalResetPassword = !1, c.$broadcast("USR0100#closeResetPasswordAfterChange", {
                showModalResetPassword: a.model.hidden.showModalResetPassword,
                message: a.model.form.USR0110ResetPasswordResult.proResult.message
            });
            null != a.model.form.USR0110ResetPasswordResult.proResult && "NG" == a.model.form.USR0110ResetPasswordResult.proResult.proFlg && e.pop("error", a.model.form.USR0110ResetPasswordResult.proResult.message, null, "trustedHtml")
        })
    }
}]);

var usr0200Module = angular.module("usr0200Module", ["dmsCommon", "toaster"]).controller("USR0200Ctrl", ["$scope", "serverService", "toaster", function (a, d, c) {
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
    a.init = function () {
        a.initData()
    };
    a.validate = function () {
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
    a.searchUserRole = function () {
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
    a.chooseBU = function () {
        for (var c = 0; c < a.model.form.USR0200SearchUserResultDto.lstUserLeader.length; c++) {
            var b = a.model.form.USR0200SearchUserResultDto.lstUserLeader[c];
            if (b.userId == a.model.form.USR0200CreateUserInputModel.selectedUserLeaders) a.model.hidden.buChoose = {
                userId: a.model.form.USR0200CreateUserInputModel.selectedUserLeaders,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseRegionManager = function () {
        for (var c = 0; c < a.model.form.USR0200SearchUserResultDto.lstSalesManager.length; c++) {
            var b = a.model.form.USR0200SearchUserResultDto.lstSalesManager[c];
            if (b.userId == a.model.form.USR0200CreateUserInputModel.selectedSalesManager) a.model.hidden.managerRegionChoose = {
                userId: a.model.form.USR0200CreateUserInputModel.selectedSalesManager,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseArea = function (c) {
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
    a.chooseSalesManager = function (c) {
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
    a.chooseSubLeader = function (c) {
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
    a.chooseProduct = function (c) {
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
    a.chooseSalesman = function (c) {
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
    a.clearCreateParam = function () {
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
    a.clearAreaCheck = function () {
        if (null != a.model.form.USR0200InitDataOutputModel.initData.lstAreaGroup.items)
            for (var c =
                a.model.form.USR0200InitDataOutputModel.initData.lstAreaGroup.items.length, b = 0; b < c; b++) a.model.form.USR0200InitDataOutputModel.initData.lstAreaGroup.items[b].itemChoose = !1
    };
    a.subLeadersCheck = function () {
        if (null != a.model.form.USR0200SearchUserResultDto.lstUserSubLeader)
            for (var c = a.model.form.USR0200SearchUserResultDto.lstUserSubLeader.length, b = 0; b < c; b++) a.model.form.USR0200SearchUserResultDto.lstUserSubLeader[b].itemChoose = !1
    };
    a.createUser = function () {
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
    a.createUserContinus = function () {
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
    a.initData = function () {
        param = {};
        d.doPost("/USR0200/initData",
            param,
            function (c) {
                a.model.form.USR0200InitDataOutputModel = c
            })
    };
    a.searchUserRoleData = function () {
        param = {
            selectClient: {
                clientId: a.model.form.USR0200InitDataOutputModel.initData.defaultClientId
            },
            roleCd: a.model.form.USR0200InitDataOutputModel.initData.defaultRoleCd
        };
        d.doPost("/USR0200/searchUserRole", param, function (c) {
            a.model.form.USR0200SearchUserResultDto = c

            if (null != a.model.form.USR0200SearchUserResultDto.lstSalesman)
                for (c = 0; c < a.model.form.USR0200SearchUserResultDto.lstSalesman.length; c++) {
                    var b = a.model.form.USR0200SearchUserResultDto.lstSalesman[c];

                    a.model.form.USR0200SearchUserResultDto.lstSalesman[c].display_name = b.salesman_code + ' - ' + b.salesman_name;
                }
        })
    };
    a.createUserDataAndChangePage = function (e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0200/createUser", e, function (b) {
            a.model.form.USR0200CreateUserResultDto = b;
            if (null != a.model.form.USR0200CreateUserResultDto.proResult) "OK" == a.model.form.USR0200CreateUserResultDto.proResult.proFlg ? window.location.href = getContextPath() + "/USR0100/" : c.pop("error", a.model.form.USR0200CreateUserResultDto.proResult.message, null, "trustedHtml")
        })
    };
    a.createUserData = function (e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0200/createUser", e, function (b) {
            a.model.form.USR0200CreateUserResultDto = b;
            null != a.model.form.USR0200CreateUserResultDto.proResult && ("OK" ==
            a.model.form.USR0200CreateUserResultDto.proResult.proFlg ? (c.pop("success", a.model.form.USR0200CreateUserResultDto.proResult.message, null, "trustedHtml"), a.clearCreateParam()) : c.pop("error", a.model.form.USR0200CreateUserResultDto.proResult.message, null, "trustedHtml"))
        })
    }
}]);
usr0200Module.directive("fileModel", ["$parse", function (a) {
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
var usr0210Module = angular.module("usr0210Module", ["dmsCommon", "toaster"]).controller("USR0210Ctrl", ["$scope", "serverService", "toaster", function (a, d, c) {
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
    a.init = function () {
        a.model.hidden.userCode = angular.element("#userCode").val();
        a.initData()
    };
    a.validate = function () {
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
    a.searchUserRole = function () {
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
    a.searchUserCode = function () {
        a.searchUserCodeData()
    };
    a.chooseArea = function (c) {
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
    a.chooseSalesManager = function (c) {
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
    a.chooseSubLeader = function (c) {
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
    a.chooseBU = function () {
        for (var c = 0; c < a.model.form.USR0210SearchUserResultDto.lstUserLeader.length; c++) {
            var b = a.model.form.USR0210SearchUserResultDto.lstUserLeader[c];
            if (b.userId == a.model.form.USR0210CreateUserInputModel.selectedUserLeaders) a.model.hidden.buChoose = {
                userId: a.model.form.USR0210CreateUserInputModel.selectedUserLeaders,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseRegionManager = function () {
        for (var c = 0; c < a.model.form.USR0210SearchUserResultDto.lstSalesManager.length; c++) {
            var b = a.model.form.USR0210SearchUserResultDto.lstSalesManager[c];
            if (b.userId == a.model.form.USR0210CreateUserInputModel.selectedSalesManager) a.model.hidden.managerRegionChoose = {
                userId: a.model.form.USR0210CreateUserInputModel.selectedSalesManager,
                versionNo: b.versionNo
            }
        }
    };
    a.chooseProduct = function (c) {
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
    a.clearCreateParam = function () {
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
    a.clearAreaCheck = function () {
        if (null != a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items)
            for (var c = a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items.length,
                     b = 0; b < c; b++) a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items[b].itemChoose = !1
    };
    a.subLeadersCheck = function () {
        if (null != a.model.form.USR0210SearchUserResultDto.lstUserSubLeader)
            for (var c = a.model.form.USR0210SearchUserResultDto.lstUserSubLeader.length, b = 0; b < c; b++) a.model.form.USR0210SearchUserResultDto.lstUserSubLeader[b].itemChoose = !1
    };
    a.createUserContinus = function () {
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
    a.initData = function () {
        param = {};
        d.doPost("/USR0210/initData", param, function (c) {
            a.model.form.USR0210InitDataOutputModel = c;
            if (null != a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items)
                for (var c = a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items.length, b = 0; b < c; b++) a.model.form.USR0210InitDataOutputModel.initData.lstAreaGroup.items[b].itemChoose = !1;
            a.searchUserCode()
        })
    };
    a.searchUserRoleData = function () {
        param = {
            userCode: a.model.hidden.userCode,
            selectClient: {
                clientId: a.model.form.USR0210InitDataOutputModel.initData.defaultClientId
            },
            roleCd: a.model.form.USR0210InitDataOutputModel.initData.defaultRoleCd
        };
        d.doPost("/USR0210/searchUserRole", param, function (c) {
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
    a.searchUserCodeData = function () {
        param = {
            userCode: a.model.hidden.userCode
        };
        d.doPost("/USR0210/searchUserCode", param, function (c) {
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
        function (e) {
            a.validate();
            !0 != a.model.hidden.validated.isErrored && d.doPost("/USR0210/updateUser", e, function (b) {
                a.model.form.USR0210CreateUserResultDto = b;
                "OK" == a.model.form.USR0210CreateUserResultDto.proResult.proFlg ? c.pop("success", a.model.form.USR0210CreateUserResultDto.proResult.message, null, "trustedHtml") : c.pop("error", a.model.form.USR0210CreateUserResultDto.proResult.message, null, "trustedHtml")
            })
        }
}]);
