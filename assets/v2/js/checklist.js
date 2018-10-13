angular.module("che0100Module", ["dmsCommon", "toaster", "ngLoadingSpinner"])
    .controller("CHE0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
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
                CHE0100InitDataModel: null,
                searchParam: {
                    searchInput: {
                        checklistName: "",
                        checklistCode: ""
                    },
                    pagingInfo: {
                        ttlRow: 0,
                        crtPage: 1,
                        rowNumber: 0
                    }
                },
                CHE0100SearchDataResult: null
            };
            a.initData()
        };
        a.search = function() {
            a.searchDataOnly()
        };
        a.prevPage = function() {
            a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
            a.searchData()
        };
        a.nextPage = function() {
            a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
            a.searchData()
        };
        a.startPage = function() {
            a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
            a.searchData()
        };
        a.endPage = function() {
            a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage = a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlPages;
            a.searchData()
        };
        a.deleteDataChecklist = function (param){
            d.doPost("/CHE0100/deleteChecklist", param, function(b) {
                null != b.proResult && ("NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message,
                    null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml"))
                a.searchDataOnly()
            })

        };
        a.deleteChecklist = function(b){
            a.deleteDataChecklist({
                checklistId:b.checklist_id
            })
        };

        a.initData = function() {
            d.doPost("/CHE0100/initData", {}, function(b) {
                a.model.form.CHE0100InitDataModel = b;
            })
        };
        a.searchData = function() {
            d.doPost("/CHE0100/searchData", {
                searchInput: {
                    coachingCode: a.model.form.searchParam.searchInput.checklistCode,
                    coachingName: a.model.form.searchParam.searchInput.checklistName
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ?
                        a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage : null,
                    rowNumber: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            }, function(b) {
                a.model.form.CHE0100SearchDataResult = b;
                a.model.form.CHE0100InitDataModel.resultSearch.cheInfo = a.model.form.CHE0100SearchDataResult.resultSearch.cheInfo;
                a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo = a.model.form.CHE0100SearchDataResult.resultSearch.pagingInfo
            })
        };
        a.searchDataOnly = function() {
            d.doPost("/CHE0100/searchData", {
                searchInput: {
                    checklistCode: a.model.form.searchParam.searchInput.checklistCode,
                    checklistName: a.model.form.searchParam.searchInput.checklistName
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ?
                        a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage : null,
                    rowNumber: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            }, function(b) {
                a.model.form.CHE0100SearchDataResult = b;
                a.model.form.CHE0100InitDataModel.resultSearch.cheInfo = a.model.form.CHE0100SearchDataResult.resultSearch.cheInfo;
                a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo = a.model.form.CHE0100SearchDataResult.resultSearch.pagingInfo;
            })
        }
    }]);

var che0200Module = angular.module("che0200Module", ["dmsCommon","che0220Module", "toaster", "ngLoadingSpinner"])
    .controller("CHE0200Ctrl", ["$scope", "$http", "$filter", "serverService", "toaster", function(a, d, c, e, f) {
        a.init = function() {
            a.model.activeTab = 1;
            a.model.form = {
                chooseAll: !1,
                chooseAllRM: !1,
                CHE0200InitDataOutputModel: null,
                CHE0200InitDataModel:null,
                CHE0200CreateChecklistInputModel: {
                    checklistName: "",
                    checklistStartday: "",
                    checklistEndday: "",
                    checklistCode:"",
                    checklistId:0
                },
                CHE0200CreateChecklistResultDto: null,
                CHE0330ResultSearchNotAssignModel: {
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
                CHE0340SearchDataUserNotAssign: {
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
                CHE0340ResultSearchNotAssignModel: {
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

                CHE0340SearchDataUserAssign: {
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
                CHE0340ResultSearchAssignModel: {
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

                CHE0330ResultSearchUserAssignModel: {
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
                CHE0330SearchDataUserNotAssign: {
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
                CHE0330SearchDataUserAssign: {
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
                listSelectUser: [],
                listSelectChecklist:[],
                listSelectRMUser: [],
                listSelectRMChecklist:[]
            };
            a.model.hidden = {
                showCHE0220: !1,
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                },
                validated: {
                    isErrored: !1,
                    checklistName: {
                        isErrored: !1,
                        msg: ""
                    },
                    checklistStartday: {
                        isErrored: !1,
                        msg: ""
                    },
                    checklistEndday: {
                        isErrored: !1,
                        msg: ""
                    }
                },
                deleteConfirm: {
                    message: Messages.getMessage("C0000001")
                }
            };
            a.$on("CHE0200#showCHE0220", function(b, c) {
                a.model.hidden.showCHE0220 = c.showCHE0220
            });

        };
        a.searchType = function(){
            a.searchUserNotAssign();
        }
        a.countStep = 1;
        a.chooseAll = function() {
            if (null != a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo)
                if (!1 == a.model.form.chooseAll)
                    for (var b = 0; b < a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) {
                        var c = a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b];
                        c.choose = !1;
                        for (var e = 0; e < a.model.form.listSelectUser.length; e++) a.model.form.listSelectUser[e] ==
                        c.userId && a.model.form.listSelectUser.splice(e, 1)
                    } else
                    for (b = 0; b < a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) c = a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b], c.choose = !0, a.model.form.listSelectUser.push(c.userId)
        };
        a.checkChooseAll = function() {
            if (0 < a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length) {
                a.model.form.chooseAll = !0;
                for (var b = 0; b < a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++)
                    if (!1 ==
                        a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b].choose) {
                        a.model.form.chooseAll = !1;
                        break
                    }
            }
        };

        a.chooseAllRM = function() {
            if (null != a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo)
                if (!1 == a.model.form.chooseAllRM)
                    for (var b = 0; b < a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) {
                        var c = a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b];
                        c.choose = !1;
                        for (var e = 0; e < a.model.form.listSelectRMUser.length; e++) a.model.form.listSelectRMUser[e] ==
                        c.userId && a.model.form.listSelectRMUser.splice(e, 1)
                    } else
                    for (b = 0; b < a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) c = a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b], c.choose = !0,
                        a.model.form.listSelectRMUser.push(c.userId)
        };
        a.checkChooseAllRM = function() {

            if (0 < a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length) {
                a.model.form.chooseAllRM = !0;
                for (var b = 0; b < a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++)
                    if (!1 ==
                        a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b].choose) {
                        a.model.form.chooseAllRM = !1;
                        break
                    }
            }
        };

        a.finish = function(){
            window.location.href = getContextPath() + "/CHE0100";
        };
        a.addUser = function() {
            a.addUserData({
                checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                userIdList: a.model.form.listSelectUser
            }, function(b) {

                null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
                a.searchDataUserNotAssignOnly();
                a.searchDataUserAssignOnly();
            })
        };
        a.addRMUser = function() {
            a.addRMUserData({
                checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                userIdList: a.model.form.listSelectRMUser
            }, function(b) {

                null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
                a.searchRMUserNotAssign();
                a.searchRMUserAssign();
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

        a.chooseRMUser = function(b) {
            !1 == b.choose && a.removeRMUserItem(b);
            !0 == b.choose && a.addRMUserItem(b)
        };
        a.removeRMUserItem = function(b) {
            for (var f = 0; f < a.model.form.listSelectRMUser.length; f++)
                if (a.model.form.listSelectRMUser[f] == b.userId) {
                    a.model.form.listSelectRMUser.splice(f,
                        1);
                    break
                }
            a.checkChooseAllRM()
        };
        a.addRMUserItem = function(b) {
            a.model.form.listSelectRMUser.push(b.userId);
            a.checkChooseAllRM()
        };

        a.addUserData = function(a, c) {
            e.doPost("/CHE0330/assignUserChecklist", a, function(a) {
                (c || angular.noop)(a)
            })
        };

        a.addRMUserData = function(a, c) {
            e.doPost("/CHE0340/assignRMUserChecklist", a, function(a) {
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
                    checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                    userName: a.model.form.CHE0330SearchDataUserNotAssign.searchInput.userName,
                    userCode: a.model.form.CHE0330SearchDataUserNotAssign.searchInput.userCode

                },
                pagingInfo: {
                    ttlRow: null != a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.rowNumber : null
                }
            };
            e.doPost("/CHE0330/searchUserNotAssign", param, function(b) {
                a.model.form.CHE0330ResultSearchNotAssignModel = b;
                a.checkChooseAllAfterSearch();
            })
        };

        a.checkChooseAllAfterSearch = function() {
            a.model.form.listSelectUser = [];
            a.model.form.chooseAll = 1;
        };
        /**
         * Start not assign
         */

        a.prevPageUserNotAssign = function() {
            a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage -= 1;
            a.searchDataUserNotAssignOnly()
        };
        a.nextPageUserNotAssign = function() {
            a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage += 1;
            a.searchDataUserNotAssignOnly()
        };
        a.startPageUserNotAssign = function() {
            a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage = 1;
            a.searchDataUserNotAssignOnly()
        };
        a.endPageUserNotAssign = function() {
            a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage =
                a.model.form.CHE0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages;
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
                    checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                    userName: a.model.form.CHE0330SearchDataUserAssign.searchInput.userName,
                    userCode: a.model.form.CHE0330SearchDataUserAssign.searchInput.userCode

                },
                pagingInfo: {
                    ttlRow: null != a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.rowNumber : null
                }
            };
            e.doPost("/CHE0430/searchUserAssign", param, function(b) {
                a.model.form.CHE0330ResultSearchUserAssignModel = b;

            })
        };
        a.removeUser = function(b){
            e.doPost("/CHE0430/removeUserFromChecklist", {
                checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                userId:b.userId
            }, function(b) {
                null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
                a.searchDataUserNotAssignOnly();
                a.searchDataUserAssignOnly();
            })
        };

        a.removeRMUser = function(b){
            e.doPost("/CHE0340/removeUserFromChecklist", {
                checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                userId:b.userId
            }, function(b) {
                null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
                a.searchRMUserAssign();
                a.searchRMUserNotAssign();
            })
        };

        a.prevPageUserAssign = function() {
            a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage -= 1;
            a.searchDataUserAssignOnly()
        };
        a.nextPageUserAssign = function() {
            a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage += 1;
            a.searchDataUserAssignOnly()
        };
        a.startPageUserAssign = function() {
            a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage = 1;
            a.searchDataUserAssignOnly()
        };
        a.endPageUserAssign = function() {
            a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage =
                a.model.form.CHE0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages;
            a.searchDataUserAssignOnly()
        };

        a.validate = function() {
            a.model.hidden.validated = {
                isErrored: !1,
                checklistName: {
                    isErrored: !1,
                    msg: ""
                },
                checklistStartday: {
                    isErrored: !1,
                    msg: ""
                },
                checklistEndday: {
                    isErrored: !1,
                    msg: ""
                },
                checklistMoreEndDay: {
                    isErrored: !1,
                    msg: ""
                }
            };
            if (!ValidateUtil.isValidTextRequired(a.model.form.CHE0200CreateChecklistInputModel.checklistName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checklistName.isErrored = !0, a.model.hidden.validated.checklistName.msg = Messages.getMessage("E0000004", "CHE0200_LABEL_CHECKLIST_NAME");
            if (!ValidateUtil.isValidTextRequired(a.model.form.CHE0200CreateChecklistInputModel.checklistStartday)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checklistStartday.isErrored = !0, a.model.hidden.validated.checklistStartday.msg = Messages.getMessage("E0000004", "CHE0200_LABEL_CHECKLIST_STARTDAY");
            if (!ValidateUtil.isValidTextRequired(a.model.form.CHE0200CreateChecklistInputModel.checklistEndday)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.checklistEndday.isErrored = !0, a.model.hidden.validated.checklistEndday.msg = Messages.getMessage("E0000004", "CHE0200_LABEL_CHECKLIST_ENDDAY");

            if ( ValidateUtil.isValidTextRequired(a.model.form.CHE0200CreateChecklistInputModel.checklistStartday)
                && ValidateUtil.isValidTextRequired(a.model.form.CHE0200CreateChecklistInputModel.checklistEndday)){


                var firstValue = a.model.form.CHE0200CreateChecklistInputModel.checklistStartday.split('-');
                var secondValue = a.model.form.CHE0200CreateChecklistInputModel.checklistEndday.split('-');

                var startDay = new Date(firstValue[2] + "-" + firstValue[1] + "-" + firstValue[0]).getTime();
                var endDay = new Date(secondValue[2] + "-" + secondValue[1] + "-" + secondValue[0]).getTime();

                if (startDay >  endDay)
                    a.model.hidden.validated.isErrored = !0,
                        a.model.hidden.validated.checklistMoreEndDay.isErrored = !0,
                        a.model.hidden.validated.checklistMoreEndDay.msg = Messages.getMessage("E0000031");

            }
        };

        a.nextChecklist = function() {
            if (a.countStep == 1){
                a.validate();
                !0 != a.model.hidden.validated.isErrored && a.createChecklistData({
                    checklistName: a.model.form.CHE0200CreateChecklistInputModel.checklistName,
                    checklistStartday: a.model.form.CHE0200CreateChecklistInputModel.checklistStartday,
                    checklistEndday: a.model.form.CHE0200CreateChecklistInputModel.checklistEndday,
                    checklistId:a.model.form.CHE0200CreateChecklistInputModel.checklistId
                })

            }
        };

        a.searchRMUserNotAssign = function() {
            param = {
                searchInput: {
                    checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                    userName: a.model.form.CHE0340SearchDataUserNotAssign.searchInput.userName,
                    userCode: a.model.form.CHE0340SearchDataUserNotAssign.searchInput.userCode

                },
                pagingInfo: {
                    ttlRow: null != a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.CHE0340ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.rowNumber : null
                }
            };
            e.doPost("/CHE0340/searchRMUserNotAssign", param, function(b) {
                a.model.form.CHE0340ResultSearchNotAssignModel = b;
                a.checkChooseAllAfterSearch();
            })
        };

        a.searchRMUserAssign = function () {
            param = {
                searchInput: {
                    checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
                    userName: a.model.form.CHE0340SearchDataUserAssign.searchInput.userName,
                    userCode: a.model.form.CHE0340SearchDataUserAssign.searchInput.userCode

                },
                pagingInfo: {
                    ttlRow: null != a.model.form.CHE0340ResultSearchAssignModel.resultUserAssign.pagingInfo ? a.model.form.CHE0340ResultSearchAssignModel.resultUserAssign.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.CHE0340ResultSearchAssignModel.resultUserAssign.pagingInfo ? a.model.form.CHE0340ResultSearchAssignModel.resultUserAssign.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.CHE0340ResultSearchAssignModel.resultUserAssign.pagingInfo ? a.model.form.CHE0340ResultSearchAssignModel.resultUserAssign.pagingInfo.rowNumber : null
                }
            };
            e.doPost("/CHE0340/searchRMUserAssign", param, function(b) {
                a.model.form.CHE0340ResultSearchUserAssignModel = b;
                a.checkChooseAllAfterSearch();
            })
        };

        a.createChecklistData = function(b) {
            e.doPost("/CHE0200/regisChecklist", b, function(b) {
                a.model.form.CHE0200CreateChecklistInputModel.checklistId = b.checklistId;
                $("#checklist").hide();
                $("#assign-checklist").show();
                $("#next-assign").hide();
                $("#back_checklist").show();
                $("#finish_checklist").show();

                a.searchDataUserNotAssignOnly();
                a.searchDataUserAssignOnly();
                a.searchRMUserNotAssign();
                a.searchRMUserAssign();

                a.countStep++;
            })
        };
        a.backStore = function(){
            if (a.countStep == 2){
                $("#checklist").show();
                $("#assign-checklist").hide();
                $("#back_checklist").hide();
                $("#finish_checklist").hide();
                $("#next-checklist").show();
                $("#next-assign").show();

                a.countStep--;
            }
        };

    }]);

var che0220Module = angular.module("che0220Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("CHE0220Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.count = 0;
    a.init = function() {
        a.model.hidden.checklistId = angular.element("#checklistId").val();
        a.initData();

    };
}]);

//Directive for adding buttons on click that show an alert on click

che0200Module.directive('myOnChange', function () {
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

var che0400Module = angular.module("che0400Module", ["dmsCommon","toaster", "ngLoadingSpinner"]).controller("CHE0400Ctrl", ["$scope", "$http", "$filter", "serverService", "toaster", function(a, d, c, e, f) {
    a.init = function() {
        a.model = {
            hidden: {
                showCHE0220: !1
            }
        };
        a.model.form = {
            chooseAll: !1,
            chooseAllChecklist: !1,
            CHE0200InitDataOutputModel: null,
            CHE0200InitDataModel:null,
            CHE0100InputDataModel:{
                searchInput:{
                    doctorName:"",
                    hospital:""
                }
            },
            CHE0200CreateChecklistInputModel: {
                checklistName: "",
                checklistStartday: "",
                checklistEndday: "",
                checklistCode:"",
                checklistId:0
            },
            CHE0200CreateChecklistResultDto: null,
            CHE0200CreateChecklistSectionResult:null,
            CHE0200CreateChecklistSectionResultDto:null,
            CHE0330ResultSearchUserAssignModel: {
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
            listSelectChecklist:[]
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                checklistName: {
                    isErrored: !1,
                    msg: ""
                },
                checklistStartday: {
                    isErrored: !1,
                    msg: ""
                },
                checklistEndday: {
                    isErrored: !1,
                    msg: ""
                }
            }
        };

        a.initData();
    };


    a.initData = function() {
        a.model.form.CHE0200CreateChecklistInputModel.checklistId
            = angular.element("#checklistId").val();
        e.doPost("/CHE0400/initData", {
            checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId
        }, function(b) {
            a.model.form.CHE0100InitDataModel = b;
            a.model.form.listSelectChecklist = b.listSelectChecklist;
            a.checkFirstLoad();
        })
    };

    a.countStep = 1;

    a.checkChooseAllAfterSearch = function() {
        a.model.form.listSelectUser = [];
        a.model.form.chooseAll = 1;
    };
    a.checkFirstLoad = function(){
        if (null != a.model.form.CHE0100InitDataModel.resultSearch.cheInfo) {
            for (var c = 0; c < a.model.form.CHE0100InitDataModel.resultSearch.cheInfo.length; c++) {
                var e = a.model.form.CHE0100InitDataModel.resultSearch.cheInfo[c];
                e.choose = !1;
                for (var b = 0; b < a.model.form.listSelectChecklist.length; b++)
                    if (a.model.form.listSelectChecklist[b] == e.customerEventId) e.choose = !0
            }
            a.checkChooseAllChecklist()
        }
    }
    a.searchUserMark = function() {
        a.searchDataUserMarkOnly()
    };
    a.searchDataUserMarkOnly = function() {
        var param = {
            checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
            searchInput: {
                doctorName: a.model.form.CHE0100InputDataModel.searchInput.doctorName,
                hospital: a.model.form.CHE0100InputDataModel.searchInput.hospital
            },
            pagingInfo: {
                ttlRow: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo ? a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/CHE0400/initData", param, function(b) {
            a.model.form.CHE0100InitDataModel = b;
            a.checkFirstLoad();
        })
    };

    a.prevPageUserMark = function() {
        a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchDataUserMarkOnly()
    };
    a.nextPageUserMark = function() {
        a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataUserMarkOnly()
    };
    a.startPageUserMark = function() {
        a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataUserMarkOnly()
    };
    a.endPageUserMark = function() {
        a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.CHE0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataUserMarkOnly()
    };


    a.chooseChecklist = function(b) {
        !1 == b.choose && a.removeChecklistItem(b);
        !0 == b.choose && a.addChecklistItem(b)
    };
    a.removeChecklistItem = function(b) {
        for (var f = 0; f < a.model.form.listSelectChecklist.length; f++)
            if (a.model.form.listSelectChecklist[f] == b.customerEventId) {
                a.model.form.listSelectChecklist.splice(f,
                    1);
                break
            }
        a.checkChooseAllChecklist()
    };
    a.addChecklistItem = function(b) {
        a.model.form.listSelectChecklist.push(b.customerEventId);
        a.checkChooseAllChecklist()
    };
    a.chooseAllChecklist = function() {
        if (null != a.model.form.CHE0100InitDataModel.resultSearch.cheInfo)
            if (!1 == a.model.form.chooseAllChecklist)
                for (var b = 0; b < a.model.form.CHE0100InitDataModel.resultSearch.cheInfo.length; b++) {
                    var c = a.model.form.CHE0100InitDataModel.resultSearch.cheInfo[b];
                    c.choose = !1;
                    for (var e = 0; e < a.model.form.listSelectChecklist.length; e++) a.model.form.listSelectChecklist[e] ==
                    c.customerEventId && a.model.form.listSelectChecklist.splice(e, 1)
                } else
                for (b = 0; b < a.model.form.CHE0100InitDataModel.resultSearch.cheInfo.length; b++) c = a.model.form.CHE0100InitDataModel.resultSearch.cheInfo[b], c.choose = !0, a.model.form.listSelectChecklist.push(c.customerEventId)
    };
    a.checkChooseAllChecklist = function() {
        if (0 < a.model.form.CHE0100InitDataModel.resultSearch.cheInfo.length) {
            a.model.form.chooseAllChecklist = !0;
            for (var b = 0; b < a.model.form.CHE0100InitDataModel.resultSearch.cheInfo.length; b++)
                if (!1 ==
                    a.model.form.CHE0100InitDataModel.resultSearch.cheInfo[b].choose) {
                    a.model.form.chooseAllChecklist = !1;
                    break
                }
        }
    };
    a.addAttendance = function(){
        e.doPost("/CHE0400/regisAttendance", {
            listSelectChecklist:a.model.form.listSelectChecklist,
            checklistId: a.model.form.CHE0200CreateChecklistInputModel.checklistId,
        }, function(b) {
//            a.model.form.CHE0100InitDataModel = b;
        })
    };
    a.viewListChecklist = function(){
        a.addAttendance();
        window.location.href = getContextPath() + "/CHE0100";
    };

}]);

