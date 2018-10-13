angular.module("cli0100Module", ["dmsCommon", "ngLoadingSpinner"]).controller("CLI0100Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hidden: {}
    };
    a.model.form = {
        CLI0100InitDataModel: null,
        CLI0100SearchDataInputModel: null,
        nameSearch: null
    };
    a.init = function () {
        a.initData()
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.CLI0100InitDataModel.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.CLI0100InitDataModel.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage =
        function () {
            a.model.form.CLI0100InitDataModel.pagingInfo.crtPage = 1;
            a.searchData()
        };
    a.endPage = function () {
        a.model.form.CLI0100InitDataModel.pagingInfo.crtPage = a.model.form.CLI0100InitDataModel.pagingInfo.ttlPages;
        a.searchData()
    };
    a.getImage = function () {
        if (null != a.model.form.CLI0100InitDataModel.cliInfo.clientList)
            for (var c = a.model.form.CLI0100InitDataModel.cliInfo.clientList.length, e = 0; e < c; e++) {
                var b = a.model.form.CLI0100InitDataModel.cliInfo.clientList[e],
                    f = getContextPath() + b.logoPath;
                b.imageUrl = f
            }
    };
    a.initData =
        function () {
            d.doPost("/CLI0100/initData/", {}, function (c) {
                a.model.form.CLI0100InitDataModel = c;
                a.getImage()
            })
        };
    a.searchData = function () {
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
        }, function (c) {
            a.model.form.CLI0100SearchDataInputModel = c;
            a.model.form.CLI0100InitDataModel.cliInfo.clientList = a.model.form.CLI0100SearchDataInputModel.clientInfo.clientList;
            a.model.form.CLI0100InitDataModel.pagingInfo = a.model.form.CLI0100SearchDataInputModel.pagingInfo;
            a.getImage()
        })
    };
    a.searchDataOnly = function () {
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
        }, function (c) {
            a.model.form.CLI0100SearchDataInputModel = c;
            a.model.form.CLI0100InitDataModel.cliInfo.clientList = a.model.form.CLI0100SearchDataInputModel.clientInfo.clientList;
            a.model.form.CLI0100InitDataModel.pagingInfo = a.model.form.CLI0100SearchDataInputModel.pagingInfo;
            a.getImage()
        })
    }
}]);
angular.module("cli0200Module", ["dmsCommon", "fcsa-number"]).controller("CLI0200Ctrl", ["$scope", "serverService", "fileReader", function (a, d, c) {
    a.chooseFile = function () {
        /*event.stopPropagation();*/
        angular.element("#ChooseFile").click()
    };
    a.getFile = function () {
        c.readAsDataUrl(a.file, a).then(function (c) {
            a.model.form.urlImage = c
        })
    };
    a.init = function () {
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
        a.initData(param, function (c) {
            a.model.form.CLI0200InitOutputModel = c;
            if (angular.isDefined(c.clientType) && 0 < c.clientType.length) a.model.form.clientType = c.clientType[0].codeCd
        })
    };
    a.initData = function (a, b) {
        d.doPost("/CLI0200/initData", a, function (a) {
            (b || angular.noop)(a)
        })
    }
}]);
angular.module("cli0300Module", "dmsCommon,fcsa-number,Slidebox,pro1100Module,pro1120Module,pro1130Module,cli0310Module,cli0330Module,cli0340Module,cli0350Module,cli0360Module,cli0361Module,cli0362Module,cli0370Module,cli0371Module,cli0372Module,cli0380Module,cli0390Module,cli0400Module,rpt0100Module,rpt0300Module,rpt0400Module,rpt0500Module".split(",")).controller("CLI0300Ctrl", ["$scope", "$rootScope", "serverService", "$timeout", function (a, d, c, e) {
    a.showPopupDetail = function (b) {
        a.model.hidden.activeRow = b;
        a.model.hidden.showPopupDetail = !0
    };
    a.importProduct = function () {
        a.model.hidden.showImportRivalProduct = !0;
        e(function () {
            d.$broadcast("PR01130#importProduct")
        })
    };
    a.showCreatePro = function () {
        a.model.hidden.showCreatePro = !0;
        d.$broadcast("PR01120#init", {
            showCreatePro: a.model.hidden.showCreatePro
        })
    };
    a.showModalEditCus = function () {
        a.model.hidden.showEditCus = !0
    };
    a.init = function () {
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
        a.$on("CLI0310#closeEditClientModal", function () {
            a.model.hidden.showCLI0310 = !1
        });
        a.$on("CLI0300#closeModalPRO1120", function () {
            a.model.hidden.showCreatePro = !1
        });
        a.$on("CLI0300#openImportRivalProduct", function (b, f) {
            a.model.hidden.showImportRivalProduct = !0;
            e(function () {
                d.$broadcast("PR01130#initFromRivalProduct", {
                    rivalId: f.rivalId
                })
            })
        });
        a.$on("CLI0300#closeImportProduct", function () {
            a.model.hidden.showImportRivalProduct = !1
        });
        a.$on("CLI0300#openEditProductModal", function (b, f) {
            a.model.hidden.showCreatePro = !0;
            e(function () {
                d.$broadcast("PR01120#edit", {
                    productInfo: f.productInfo
                })
            })
        });
        a.$on("CLI0300#openUpdateProductTypeModal", function (b, f) {
            a.model.hidden.showUpdateProductType = !0;
            e(function () {
                d.$broadcast("CLI0361#edit", {
                    itemProductType: f.itemProductType,
                    showUpdateProductType: !0
                })
            })
        });
        a.$on("CLI0300#closeUpdateProductTypeModal",
            function () {
                a.model.hidden.showUpdateProductType = !1
            });
        a.$on("CLI0300#openUpdateProductGroupModal", function (b, f) {
            a.model.hidden.showUpdateProductGroup = !0;
            e(function () {
                d.$broadcast("CLI0362#edit", {
                    itemProductGroup: f.itemProductGroup,
                    showUpdateProductGroup: !0
                })
            })
        });
        a.$on("CLI0300#closeUpdateProductGroupModal",
            function () {
                a.model.hidden.showUpdateProductGroup = !1
            });
        a.$on("CLI0300#openRivalModal", function (b, f) {
            a.model.hidden.showUpdateRiVal = !0;
            e(function () {
                d.$broadcast("CLI0371#edit", {
                    itemRival: angular.copy(f.itemRival),
                    showModalEditRival: !0
                })
            })
        });
        a.$on("CLI0300#closeRivalModal", function () {
            a.model.hidden.showUpdateRiVal = !1
        });
        a.$on("CLI0300#openRivalProductModal", function (b, f) {
            a.model.hidden.showAddProductRival = !0;
            e(function () {
                d.$broadcast("CLI0372#createRivalProduct", {
                    rivalId: f.rivalId
                })
            })
        });
        a.$on("CLI0300#closeRivalProductModal",
            function () {
                a.model.hidden.showAddProductRival = !1
            });
        a.$on("CLI0300#updateRivalProductModal", function (b, f) {
            a.model.hidden.showAddProductRival = !0;
            e(function () {
                d.$broadcast("CLI0372#showModalEditPro", {
                    productItem: f.productItem
                })
            })
        })
    };
    a.openEditClientModal = function () {
        a.model.hidden.showCLI0310 = !0;
        d.$broadcast("CLI0310#showEditClientModal")
    };
    a.sortCode = function () {
        a.model.hidden.sortCode = !1 == a.model.hidden.sortCode ? !0 : !1
    };
    a.sortName = function () {
        a.model.hidden.sortName = !1 == a.model.hidden.sortName ? !0 : !1
    }
}]);
var cli0310Module = angular.module("cli0310Module", ["dmsCommon"]).controller("CLI0310Ctrl", ["$scope", "serverService", "$rootScope", "toaster", "fileReader", function (a, d, c, e, b) {
    a.init = function () {
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
        a.initData(param, function (b) {
            a.model.form.CLI0310InitOutputModel =
                b;
            a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath = getContextPath() + a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath
        })
    };
    a.chooseFile = function () {
        // event.stopPropagation();
        angular.element("#cli0310ChooseFile").click()
    };
    a.getFile = function (f) {
        a.model.form.file = f;
        b.readAsDataUrl(f, a).then(function (b) {
            a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.logoPath = b
        })
    };
    a.closeEditClientModal = function () {
        window.location.href = getContextPath() + "/CLI0300/" + a.model.hidden.clientCode;
        c.$broadcast("CLI0310#closeEditClientModal")
    };
    a.updateClient = function () {
        param = {
            clientCode: a.model.hidden.clientCode,
            clientName: a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.clientName,
            clientType: a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.clientType,
            ratePoint: a.model.form.CLI0310InitOutputModel.clientInfo.clientInfo.ratePoint
        };
        a.updateClientData(param)
    };
    a.initData = function (a, b) {
        d.doPost("/CLI0310/initData", a, function (a) {
            (b || angular.noop)(a)
        })
    };
    a.updateClientData = function (b) {
        d.uploadFile("/CLI0310",
            a.model.form.file, b,
            function (b) {
                if (angular.isDefined(b.proResult) && null != b.proResult && "OK" == b.proResult.proFlg) window.location.href = getContextPath() + "/CLI0300/" + a.model.hidden.clientCode, e.pop("success", b.proResult.message, null, "trustedHtml");
                a.model.form.CLI0310UpdateClientResult = b.proResult
            })
    }
}]);
var cli0330Module = angular.module("cli0330Module", ["dmsCommon", "toaster"]).controller("CLI0330Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
            function (b) {
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
    a.searchSale = function () {
        a.searchDataSaleOnly()
    };
    a.prevPageSale = function () {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchDataSale()
    };
    a.nextPageSale = function () {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataSale()
    };
    a.startPageSale = function () {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataSale()
    };
    a.endPageSale = function () {
        a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataSale()
    };
    a.searchSaleNotAssign = function () {
        a.searchDataSaleNotAssignOnly()
    };
    a.prevPageSaleNotAssign =
        function () {
            a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage -= 1;
            a.searchDataSaleNotAssign()
        };
    a.nextPageSaleNotAssign = function () {
        a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataSaleNotAssign()
    };
    a.startPageSaleNotAssign = function () {
        a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataSaleNotAssign()
    };
    a.endPageSaleNotAssign = function () {
        a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.crtPage =
            a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataSaleNotAssign()
    };
    a.regisUserSalesman = function () {
        a.regisUserSalesmanData({
            clientId: a.model.hidden.clientId,
            userManagerId: a.model.form.CLI0330CreateInputModel.userId,
            selectSalesmanId: a.model.form.listSelectSalesman
        }, function (b) {
            a.model.form.CLI0330CreateResultDto = b.proResult;
            a.model.form.listSelectSalesman = [];
            a.searchDataSaleNotAssign();
            a.searchSale();
            null != a.model.form.CLI0330CreateResultDto && ("NG" == a.model.form.CLI0330CreateResultDto.proFlg ?
                e.pop("error", a.model.form.CLI0330CreateResultDto.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0330CreateResultDto.message, null, "trustedHtml"))
        })
    };
    a.deleteUserSalesman = function (b) {
        a.deleteUserSalesmanData({
            clientId: a.model.hidden.clientId,
            salesmanId: b.salesmanId
        }, function (b) {
            a.model.form.CLI0330DeleteResultDto = b;
            a.searchDataSale()
        })
    };
    a.chooseSale = function (b) {
        !1 == b.choose && a.removeSaleItem(b);
        !0 == b.choose && a.addSaleItem(b)
    };
    a.removeSaleItem = function (b) {
        for (var f = 0; f < a.model.form.listSelectSalesman.length; f++)
            if (a.model.form.listSelectSalesman[f] ==
                b.salesmanId) {
                a.model.form.listSelectSalesman.splice(f, 1);
                break
            }
        a.checkChooseAll()
    };
    a.addSaleItem = function (b) {
        a.model.form.listSelectSalesman.push(b.salesmanId);
        a.checkChooseAll()
    };
    a.chooseAll = function () {
        if (null != a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++) {
                    var f = a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b];
                    f.choose = !1;
                    for (var c = 0; c < a.model.form.listSelectSalesman.length; c++) a.model.form.listSelectSalesman[c] == f.salesmanId && a.model.form.listSelectSalesman.splice(c, 1)
                } else
                for (b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++) f = a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b], f.choose = !0, a.model.form.listSelectSalesman.push(f.salesmanId)
    };
    a.checkChooseAll = function () {
        if (0 < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList.length; b++)
                if (!1 == a.model.form.CLI0330ResultSearchNotAssignModel.resultSearch.searchSalList[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function () {
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
    a.initData = function (a, f) {
        d.doPost("/CLI0330/initData", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.searchDataSale = function () {
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
        d.doPost("/CLI0330/searchDataSalman", param, function (b) {
            a.model.form.CLI0330ResultSearchModel = b;
            a.model.form.CLI0330InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0330ResultSearchModel.resultSearch.searchSalList;
            a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0330ResultSearchModel.resultSearch.pagingInfo
        })
    };
    a.searchDataSaleOnly = function () {
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
        d.doPost("/CLI0330/searchDataSalman", param, function (b) {
            a.model.form.CLI0330ResultSearchModel = b;
            a.model.form.CLI0330InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0330ResultSearchModel.resultSearch.searchSalList;
            a.model.form.CLI0330InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0330ResultSearchModel.resultSearch.pagingInfo
        })
    };
    a.searchDataSaleNotAssign = function () {
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
        d.doPost("/CLI0330/searchDataSalmanNotAssign", param, function (b) {
            a.model.form.CLI0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataSaleNotAssignOnly = function () {
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
        d.doPost("/CLI0330/searchDataSalmanNotAssign", param, function (b) {
            a.model.form.CLI0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.regisUserSalesmanData = function (a, f) {
        d.doPost("/CLI0330/regisUserSalesman", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteUserSalesmanData = function (a, f) {
        d.doPost("/CLI0330/deleteUserSalesman", a, function (a) {
            (f || angular.noop)(a)
        })
    }
}]);
var cli0340Module = angular.module("cli0340Module", ["dmsCommon", "toaster"]).controller("CLI0340Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.initData = function (a, f) {
        d.doPost("/CLI0340/initData", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.regisCusmetaData = function (a, f) {
        d.doPost("/CLI0340/regisCusMeta", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.selectCusMetaData = function (a, f) {
        d.doPost("/CLI0340/selectCusMeta", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteCusMetaData = function (a, f) {
        d.doPost("/CLI0340/deleteCusMeta",
            a,
            function (a) {
                (f || angular.noop)(a)
            })
    };
    a.init = function () {
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
            function (b) {
                a.model.form.CLI0340InitOutputModel = b;
                a.selectCusMeta()
            })
    };
    a.addItemVal = function () {
        a.model.form.listVal.push({
            name: ""
        })
    };
    a.removeItemVal = function (b) {
        a.model.form.listVal.splice(b, 1)
    };
    a.deleteItemView = function (b) {
        param = {
            cusMetaId: b.cusMetaId
        };
        a.deleteCusMetaData(param, function (b) {
            a.model.form.CLI0340DeleteResult = b.proResult;
            a.selectCusMeta();
            null != a.model.form.CLI0340DeleteResult && ("NG" == a.model.form.CLI0340DeleteResult.proFlg ?
                e.pop("error", a.model.form.CLI0340DeleteResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0340DeleteResult.message, null, "trustedHtml"))
        })
    };
    a.validate = function () {
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
    a.createListVal = function (b) {
        for (var f = "", c = 0; c < b.length; c++) var e = b[c],
            f = c == b.length - 1 ? f + e.name : f + (e.name + "|");
        a.model.form.CLI0340RegisCusMeta.listVal = f
    };
    a.regisCusmeta = function () {
        a.createListVal(a.model.form.listVal);
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            cusmetaName: a.model.form.CLI0340RegisCusMeta.cusmetaName,
            clientId: a.model.hidden.clientId,
            cusMetaType: a.model.form.CLI0340RegisCusMeta.cusMetaType,
            listVal: a.model.form.CLI0340RegisCusMeta.listVal
        }, a.regisCusmetaData(param, function (b) {
            a.model.form.CLI0340RegisResult = b.proResult;
            a.clear();
            a.model.hidden.showViewList = !1;
            a.selectCusMeta();
            null != a.model.form.CLI0340RegisResult && ("NG" == a.model.form.CLI0340RegisResult.proFlg ? e.pop("error", a.model.form.CLI0340RegisResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0340RegisResult.message, null, "trustedHtml"))
        }))
    };
    a.clear = function () {
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
    a.selectCusMeta = function () {
        a.model.form.CLI0340ViewList = [];
        a.selectCusMetaData({
            clientId: a.model.hidden.clientId
        }, function (b) {
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
var cli0350Module = angular.module("cli0350Module", ["dmsCommon"]).controller("CLI0350Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.initData = function (a, e) {
        d.doPost("/CLI0350/initData", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.selectPhotoData = function (a, e) {
        d.doPost("/CLI0350/selectPhoto", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function () {
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
        }, function (c) {
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
    a.prevPage = function () {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage =
            a.model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function () {
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
        }, function (c) {
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

var cli0363Module = angular.module("cli0363Module", ["dmsCommon", "toaster"]).
controller("CLI0363Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.selectProTypeData = function (a, f) {
        d.doPost("/CLI0360/selectProType", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init =
        function () {
            a.model = {};
            a.model = {
                hidden: {
                    deleteConfirm: {
                        message: Messages.getMessage("C0000001")
                    }
                }
            };
            a.model.form = {
                CLI0363SelProTypeOutputModel: null,
                CLI0363DocSelProTypeClassModel : {}
            };
            a.$on("CLI0363#selectProductType", function () {
                a.selectProTypeNoCache()
            });
            a.selectProTypeData({
                clientId: a.model.hidden.clientId
            }, function (b) {
                a.model.form.CLI0363SelProTypeOutputModel = b;
                a.model.form.CLI0363DocSelProTypeClassModel = [{
                                    classId : 'A',
                                    className : 'A'
                                },{
                                    classId : 'B',
                                    className : 'B'
                                },{
                                    classId : 'C',
                                    className : 'C'
                                },{
                                    classId : 'D',
                                    className : 'D'
                                }]; 
                if (b.proTypeList.productTypeList[0] != undefined) {
                    a.model.hidden.productTypeId = b.proTypeList.productTypeList[0].productTypeId;
                } else {
                    a.model.hidden.productTypeId = '';
                }
            })
        };   
}]);

var cli0360Module = angular.module("cli0360Module", ["dmsCommon", "toaster"]).controller("CLI0360Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.selectProTypeData = function (a, f) {
        d.doPost("/CLI0360/selectProType", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.selectProGroupData = function (a, f) {
        d.doPost("/CLI0360/selectProGroup", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.regisProductTypeData = function (a, f) {
        d.doPost("/CLI0360/regisProductTye", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteProductTypeData = function (a, f) {
        d.doPost("/CLI0360/deleteProductTye", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.regisProductGroupData = function (a, f) {
        d.doPost("/CLI0360/regisProductGroup", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteProductGroupData = function (a, f) {
        d.doPost("/CLI0360/deleteProductGroup", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init =
        function () {
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
                    productTypeId: null,
                    productGroupName: ""
                }
            };
            a.$on("CLI0360#selectProductType", function () {
                a.selectProTypeNoCache()
            });
            a.$on("CLI0360#selectProductGroup", function () {
                a.selectProGroup()
            });
            a.model.hidden.clientId = angular.element("#clientId").val();
            a.selectProTypeData({
                clientId: a.model.hidden.clientId
            }, function (b) {
                a.model.form.CLI0360SelProTypeOutputModel = b;
                if (b.proTypeList.productTypeList[0] != undefined) {
                    a.model.hidden.productTypeId = b.proTypeList.productTypeList[0].productTypeId;
                } else {
                    a.model.hidden.productTypeId = '';
                }
                a.selectProGroupData({
                    clientId: a.model.hidden.clientId,
                    productTypeId: a.model.hidden.productTypeId
                }, function (b) {
                    a.model.form.CLI0360SelProGroupOutputModel = b;
                })
            })

        };
    a.getProductGroupList = function (b) {
        a.model.hidden.productTypeId = b.productTypeId;
        a.selectProGroupData({
            clientId: a.model.hidden.clientId,
            productTypeId: b.productTypeId
        }, function (b) {
            a.model.form.CLI0360SelProGroupOutputModel = b;
        })
    };
    a.selectProType = function () {
        a.selectProTypeData({
            clientId: a.model.hidden.clientId
        }, function (b) {
            a.model.form.CLI0360SelProTypeOutputModel = b;
        })
    };
    a.selectProTypeNoCache = function () {
        a.selectProTypeData({
            no_cache: false,
            clientId: a.model.hidden.clientId
        }, function (b) {
            a.model.form.CLI0360SelProTypeOutputModel = b;
            a.model.form.CLI0363SelProTypeOutputModel = b;
        })
    };
    a.regisProductType = function () {
        a.regisProductTypeData({
            clientId: a.model.hidden.clientId,
            productTypeName: a.model.form.CLI0360RegisInputModel.productTypeName
        }, function (b) {
            a.model.form.CLI0360RegisResult = b.proResult;
            a.model.form.CLI0360RegisInputModel.productTypeName = "";
            a.selectProTypeNoCache();
            "NG" == a.model.form.CLI0360RegisResult.proFlg ?
                e.pop("error", a.model.form.CLI0360RegisResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0360RegisResult.message, null, "trustedHtml")
        })
    };
    a.deleteProductGroup = function (b) {
        a.deleteProductGroupData({
            clientId: a.model.hidden.clientId,
            productGroupId: b.productGroupId
        }, function (b) {
            a.model.form.CLI0360RegisResult = b.proResult;
            "NG" == a.model.form.CLI0360RegisResult.proFlg && e.pop("error", a.model.form.CLI0360RegisResult.message, null, "trustedHtml");
            a.selectProGroup()
        })
    };
    a.editProductType = function (a) {
        c.$broadcast("CLI0300#openUpdateProductTypeModal", {
            itemProductType: angular.copy(a)
        })
    }

    a.selectProGroup = function () {
        a.selectProGroupData({
            clientId: a.model.hidden.clientId,
            productTypeId: a.model.hidden.productTypeId
        }, function (b) {
            a.model.form.CLI0360SelProGroupOutputModel = b;
        })
    }
    a.regisProductGroup = function () {
        a.regisProductGroupData({
            clientId: a.model.hidden.clientId,
            productTypeId: a.model.hidden.productTypeId,
            productGroupName: a.model.form.CLI0360RegisGroupInputModel.productGroupName
        }, function (b) {
            a.model.form.CLI0360RegisGroupResult = b.proResult;
            a.model.form.CLI0360RegisGroupInputModel.productGroupName = "";
            a.selectProGroup();
            "NG" == a.model.form.CLI0360RegisGroupResult.proFlg ?
                e.pop("error", a.model.form.CLI0360RegisGroupResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0360RegisGroupResult.message, null, "trustedHtml")
        })
    };
    a.deleteProductType = function (b) {
        a.deleteProductTypeData({
            clientId: a.model.hidden.clientId,
            productTypeId: b.productTypeId
        }, function (b) {
            a.model.form.CLI0360RegisResult = b.proResult;
            "NG" == a.model.form.CLI0360RegisResult.proFlg && e.pop("error", a.model.form.CLI0360RegisResult.message, null, "trustedHtml");
            a.selectProTypeNoCache()
        })
    };
    a.editProductGroup = function (a) {
        c.$broadcast("CLI0300#openUpdateProductGroupModal", {
            itemProductGroup: angular.copy(a)
        })
    }


}]);
angular.module("cli0361Module", ["dmsCommon", "toaster"]).controller("CLI0361Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.updateProductTypeData = function (a, f) {
        d.doPost("/CLI0360/updateProductTye", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function () {
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
        a.$on("CLI0361#edit", function (b, f) {
            a.model.form = {
                CLI0361UpdateProductType: null,
                CLI0361UpdateRivalResult: null
            };
            a.model.hidden.showUpdateProductType = f.showUpdateProductType;
            a.model.form.CLI0361UpdateProductType = f.itemProductType
        })
    };
    a.closeUpdateProductTypeModal = function () {
        c.$broadcast("CLI0300#closeUpdateProductTypeModal", {})
    };
    a.updateProductType = function () {
        a.updateProductTypeData({
                productTypeId: a.model.form.CLI0361UpdateProductType.productTypeId,
                productGroupId: a.model.form.CLI0361UpdateProductType.productGroupId,
                clientId: a.model.hidden.clientId,
                productTypeName: a.model.form.CLI0361UpdateProductType.productTypeName
            },
            function (b) {
                a.model.form.CLI0361UpdateRivalResult = b.proResult;
                a.model.hidden.showUpdateProductType = !1;
                c.$broadcast("CLI0360#selectProductType", null);
                "NG" == a.model.form.CLI0361UpdateRivalResult.proFlg ? e.pop("error", a.model.form.CLI0361UpdateRivalResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0361UpdateRivalResult.message, null, "trustedHtml");
                c.$broadcast("CLI0300#closeUpdateProductTypeModal", {})
            })
    }
}]);
angular.module("cli0362Module", ["dmsCommon", "toaster"]).controller("CLI0362Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.updateProductGroupData = function (a, f) {
        d.doPost("/CLI0360/updateProductGroup", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function () {
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
        a.$on("CLI0362#edit", function (b, f) {
            a.model.form = {
                CLI0361UpdateProductGroup: null
            };
            a.model.hidden.showUpdateProductGroup = f.showUpdateProductGroup;
            a.model.form.CLI0362UpdateProductGroup = f.itemProductGroup
        })
    };
    a.closeUpdateProductGroupModal = function () {
        c.$broadcast("CLI0300#closeUpdateProductGroupModal", {})
    };
    a.updateProductGroup = function () {
        a.updateProductGroupData({
                productTypeId: a.model.form.CLI0362UpdateProductGroup.productTypeId,
                productGroupId: a.model.form.CLI0362UpdateProductGroup.productGroupId,
                clientId: a.model.hidden.clientId,
                productGroupName: a.model.form.CLI0362UpdateProductGroup.productGroupName
            },
            function (b) {
                a.model.hidden.showUpdateProductGroup = !1;
                c.$broadcast("CLI0360#selectProductGroup", null);
                "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
                c.$broadcast("CLI0300#closeUpdateProductGroupModal", {});
                //c.$broadcast("CLI0300#reloadProductGroup", {productTypeId: a.model.form.CLI0362UpdateProductGroup.productTypeId})
            })
    }
}]);
var cli0370Module = angular.module("cli0370Module", ["dmsCommon", "toaster"]).controller("CLI0370Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.selectRivalData = function (a, f) {
        d.doPost("/CLI0370/selectRival", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.regisRivalData = function (a, f) {
        d.doPost("/CLI0370/regisRival", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteRivalData = function (a, f) {
        d.doPost("/CLI0370/deleteRival", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.selectRivalProductData = function (a,
                                         f) {
        d.doPost("/CLI0370/selectRivalProduct", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteRivalProductData = function (a, f) {
        d.doPost("/CLI0370/deleteRivalProduct", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function () {
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
        a.$on("CLI0370#selectRival", function () {
            a.selectRival()
        });
        a.$on("CLI0370#selectRivalProduct", function () {
            a.selectRivalProduct()
        });
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.selectRivalData({
            clientId: a.model.hidden.clientId
        }, function (b) {
            a.model.form.CLI0370SelProTypeOutputModel = b;
        });
        a.$on("CLI0300#closeImportProduct", function () {
            a.selectRivalProduct()
        })
    };
    a.selectRival = function () {
        a.selectRivalData({
                clientId: a.model.hidden.clientId
            },
            function (b) {
                a.model.form.CLI0370SelProTypeOutputModel = b;
            })
    };
    a.regisRival = function () {
        a.regisRivalData({
            clientId: a.model.hidden.clientId,
            rivalName: a.model.form.CLI0370RegisInputModel.rivalName
        }, function (b) {
            a.model.form.CLI0370RegisResult = b.proResult;
            a.model.form.CLI0370RegisInputModel.rivalName = "";
            a.selectRival();
            "NG" == a.model.form.CLI0370RegisResult.proFlg ? e.pop("error", a.model.form.CLI0370RegisResult.message, null, "trustedHtml") : e.pop("success",
                a.model.form.CLI0370RegisResult.message, null, "trustedHtml")
        })
    };
    a.deleteRival = function (b) {
        event.stopPropagation();
        a.deleteRivalData({
            clientId: a.model.hidden.clientId,
            rivalId: b.rivalId
        }, function (f) {
            a.model.form.CLI0370RegisResult = f;
            if (a.model.hidden.rivalSelect.rivalId == b.rivalId) a.model.hidden.rivalSelect = null, a.model.hidden.showRivalProduct = !1;
            a.selectRival()
        })
    };
    a.updateRival = function (a) {
        event.stopPropagation();
        c.$broadcast("CLI0300#openRivalModal", {
            itemRival: angular.copy(a)
        })
    };
    a.selectRivalItem =
        function (b) {
            a.model.hidden.rivalSelect = b;
            a.model.hidden.showRivalProduct = !0;
            a.selectRivalProduct()
        };
    a.selectRivalProduct = function () {
        param = {
            clientId: a.model.hidden.clientId,
            rivalId: a.model.hidden.rivalSelect.rivalId
        };
        a.selectRivalProductData(param, function (b) {
            a.model.form.CLI0370SelRivalProOutputModel = b
        })
    };
    a.deleteRivalProduct = function (b) {
        a.deleteRivalProductData({
            rivalProductId: b.rivalProductId,
            productName: b.productName,
            clientId: a.model.hidden.clientId
        }, function () {
            a.selectRivalProduct()
        })
    };
    a.importFile =
        function () {
            c.$broadcast("CLI0300#openImportRivalProduct", {
                rivalId: a.model.hidden.rivalSelect.rivalId
            })
        };
    a.regisRivalProduct = function () {
        c.$broadcast("CLI0300#openRivalProductModal", {
            rivalId: a.model.hidden.rivalSelect.rivalId
        })
    };
    a.showModalEditPro = function (a) {
        c.$broadcast("CLI0300#updateRivalProductModal", {
            productItem: a
        })
    }
}]);
angular.module("cli0371Module", ["dmsCommon", "toaster"]).controller("CLI0371Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.updateRivalData = function (a, f) {
        d.doPost("/CLI0370/updateRival", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init = function () {
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
        a.$on("CLI0371#edit", function (b, f) {
            a.model.hidden.showModalEditRival = f.showModalEditRival;
            a.model.form.CLI0371UpdateRival = f.itemRival
        })
    };
    a.closeUpdateRivalModal = function () {
        c.$broadcast("CLI0300#closeRivalModal", {})
    };
    a.updateRival = function () {
        a.updateRivalData({
            clientId: a.model.hidden.clientId,
            rivalId: a.model.form.CLI0371UpdateRival.rivalId,
            rivalName: a.model.form.CLI0371UpdateRival.rivalName
        }, function (b) {
            a.model.form.CLI0371RegisResult = b.proResult;
            a.model.hidden.showModalEditRival = !1;
            c.$broadcast("CLI0370#selectRival", null);
            "NG" == a.model.form.CLI0371RegisResult.proFlg ? e.pop("error", a.model.form.CLI0371RegisResult.message,
                null, "trustedHtml") : e.pop("success", a.model.form.CLI0371RegisResult.message, null, "trustedHtml");
            c.$broadcast("CLI0300#closeRivalModal", {})
        })
    }
}]);
angular.module("cli0372Module", ["dmsCommon", "toaster"]).controller("CLI0372Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
        a.initData(param, function (b) {
            a.model.form.CLI0372InitOutPutModal = b
        });
        a.$on("CLI0372#createRivalProduct", function (b, f) {
            a.model.hidden.showRivalProductModal = !0;
            a.model.hidden.buttonModeAdd = !0;
            a.model.form.CLI0372ModelAddProduct.rivalId = f.rivalId
        });
        a.$on("CLI0372#showModalEditPro", function (b,
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
        a.$on("CLI0372#edit", function (b, f) {
            a.model.hidden.showCreatePro = f.showCreatePro;
            a.model.hidden.buttonModeAdd = !1;
            param = {
                clientId: a.model.hidden.clientId,
                productId: f.productInfo.productId
            };
            a.selectProductData(param)
        })
    };
    a.validate = function () {
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
    a.clearProductValue = function () {
        a.model.form.CLI0372ModelAddProduct.unitName = "";
        a.model.form.CLI0372ModelAddProduct.productTypeId = null;
        a.model.form.CLI0372ModelAddProduct.productName = ""
    };
    a.regisRivalProduct = function () {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            clientId: a.model.hidden.clientId,
            rivalId: a.model.form.CLI0372ModelAddProduct.rivalId,
            unitName: a.model.form.CLI0372ModelAddProduct.unitName,
            productName: a.model.form.CLI0372ModelAddProduct.productName,
            productTypeId: a.model.form.CLI0372ModelAddProduct.productTypeId
        }, a.regisRivalProductData(param, function (b) {
            a.model.form.CLI0372AddProductResult = b.proResult;
            a.clearProductValue();
            c.$broadcast("CLI0370#selectRivalProduct", null);
            null != a.model.form.CLI0372AddProductResult && ("NG" == a.model.form.CLI0372AddProductResult.proFlg ? e.pop("error", a.model.form.CLI0372AddProductResult.message, null, "trustedHtml") :
                (e.pop("success", a.model.form.CLI0372AddProductResult.message, null, "trustedHtml"), c.$broadcast("CLI0300#closeRivalProductModal", {})))
        }))
    };
    a.closeAddRivalProductModal = function () {
        a.model.form.CLI0372AddProductResult = null;
        c.$broadcast("CLI0300#closeRivalProductModal", {})
    };
    a.updateRivalProduct = function () {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
            clientId: a.model.hidden.clientId,
            unitName: a.model.form.CLI0372ModelAddProduct.unitName,
            productName: a.model.form.CLI0372ModelAddProduct.productName,
            productTypeId: a.model.form.CLI0372ModelAddProduct.productTypeId,
            rivalProductId: a.model.form.rivalProductId
        }, a.updateRivalProductData(param, function (b) {
            a.model.form.CLI0372AddProductResult = b.proResult;
            a.model.hidden.showRivalProductModal = !1;
            c.$broadcast("CLI0370#selectRivalProduct", null);
            null != a.model.form.CLI0372AddProductResult && ("NG" == a.model.form.CLI0372AddProductResult.proFlg ? e.pop("error", a.model.form.CLI0372AddProductResult.message, null, "trustedHtml") : (e.pop("success", a.model.form.CLI0372AddProductResult.message,
                null, "trustedHtml"), c.$broadcast("CLI0300#closeRivalProductModal", {})))
        }))
    };
    a.initData = function (a, f) {
        d.doPost("/CLI0370/initData", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.regisRivalProductData = function (a, f) {
        d.doPost("/CLI0370/regisRivalProduct", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.updateRivalProductData = function (a, f) {
        d.doPost("/CLI0370/updateRivalProduct", a, function (a) {
            (f || angular.noop)(a)
        })
    }
}]);
angular.module("cli0380Module", ["dmsCommon", "toaster", "ngLoadingSpinner"]).controller("CLI0380Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
        }, function (b) {
            a.model.form.CLI0380InitOutputModel = b
        })
        a.searchDataStoreNotAssignOnly();
    };
    a.chooseArea = function (b, f) {
        a.model.hidden.defaultAreaName = b;
        a.model.hidden.areaId = f
    };
    a.chooseAreaNotAssign = function (b, f) {
        a.model.hidden.defaultAreaNameNotAssign = b;
        a.model.hidden.areaIdNotAssign = f
    };
    a.searchStore = function () {
        a.searchDataStoreOnly()
    };
    a.prevPageStore = function () {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchDataStore()
    };
    a.nextPageStore = function () {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataStore()
    };
    a.startPageStore = function () {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataStore()
    };
    a.endPageStore = function () {
        a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataStore()
    };
    a.searchStoreNotAssign = function () {
        a.searchDataStoreNotAssignOnly()
    };
    a.prevPageStoreNotAssign = function () {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage -= 1;
        a.searchDataStoreNotAssign()
    };
    a.nextPageStoreNotAssign = function () {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage += 1;
        a.searchDataStoreNotAssign()
    };
    a.startPageStoreNotAssign = function () {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage = 1;
        a.searchDataStoreNotAssign()
    };
    a.endPageStoreNotAssign = function () {
        a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.crtPage =
            a.model.form.CLI0380ResultSearchNotAssignModel.resultStoreNotAssign.pagingInfo.ttlPages;
        a.searchDataStoreNotAssign()
    };
    a.addStore = function () {
        a.addStoreData({
            clientId: a.model.hidden.clientId,
            storeIdList: a.model.form.listSelectStore
        }, function (b) {
            a.model.form.CLI0380CreateResultDto = b.proResult;
            a.model.form.listSelectStore = [];
            a.searchDataStoreNotAssign();
            a.searchStore();
            null != a.model.form.CLI0380CreateResultDto && ("NG" == a.model.form.CLI0380CreateResultDto.proFlg ? e.pop("error", a.model.form.CLI0380CreateResultDto.message,
                null, "trustedHtml") : e.pop("success", a.model.form.CLI0380CreateResultDto.message, null, "trustedHtml"))
        })
    };
    a.deleteStore = function (b) {
        a.deleteUserStoresmanData({
            clientId: a.model.hidden.clientId,
            storeId: b.storeId
        }, function (b) {
            a.model.form.CLI0380DeleteResultDto = b;
            a.searchDataStore()
        })
    };
    a.chooseStore = function (b) {
        !1 == b.choose && a.removeStoreItem(b);
        !0 == b.choose && a.addStoreItem(b)
    };
    a.removeStoreItem = function (b) {
        for (var f = 0; f < a.model.form.listSelectStore.length; f++)
            if (a.model.form.listSelectStore[f] == b.storeId) {
                a.model.form.listSelectStore.splice(f,
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
    a.checkChooseAll = function () {
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
    a.checkChooseAllAfterSearch = function () {
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
    a.initData = function (a, f) {
        d.doPost("/CLI0380/initData", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.searchDataStore = function () {
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
        d.doPost("/CLI0380/searchStoreAssigned", param, function (b) {
            a.model.form.CLI0380ResultSearchModel = b;
            a.model.form.CLI0380InitOutputModel.resultSearch.storeInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreOnly = function () {
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
        d.doPost("/CLI0380/searchStoreAssigned", param, function (b) {
            a.model.form.CLI0380ResultSearchModel = b;
            a.model.form.CLI0380InitOutputModel.resultSearch.storeInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.storeInfo;
            a.model.form.CLI0380InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0380ResultSearchModel.resultStoreAssigned.pagingInfo
        })
    };
    a.searchDataStoreNotAssign = function () {
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
        d.doPost("/CLI0380/searchStoreNotAssign", param, function (b) {
            a.model.form.CLI0380ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    a.searchDataStoreNotAssignOnly = function () {
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
        d.doPost("/CLI0380/searchStoreNotAssign", param, function (b) {
            a.model.form.CLI0380ResultSearchNotAssignModel = b;
            a.model.form.listSelectStore = [];
            a.checkChooseAllAfterSearch()
        })
    };
    a.addStoreData = function (a, f) {
        d.doPost("/CLI0380/addStore", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteUserStoresmanData = function (a, f) {
        d.doPost("/CLI0380/deleteStore", a, function (a) {
            (f || angular.noop)(a)
        })
    }
}]);
var cli0390Module = angular.module("cli0390Module", ["dmsCommon", "toaster"]).controller("CLI0390Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.selectProTypeData = function (a, f) {
        d.doPost("/CLI0390/selectProType", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.selectProGroupData = function (a, f) {
        d.doPost("/CLI0390/selectProGroup", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.regisProductTypeData = function (a, f) {
        d.doPost("/CLI0390/regisProductTye", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.deleteProductTypeData = function (a, f) {
        d.doPost("/CLI0390/deleteProductTye", a, function (a) {
            (f || angular.noop)(a)
        })
    };
    a.init =
        function () {
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
                CLI0390SelProGroupOutputModel: null,
                CLI0390RegisResult: null,
                CLI0390RegisInputModel: {
                    clientId: null,
                    productTypeName: ""
                }
            };
            a.model.hidden.clientId = angular.element("#clientId").val()
        };
    a.selectProType = function () {
        a.selectProTypeData({
            clientId: a.model.hidden.clientId
        }, function (b) {
            a.model.form.CLI0390SelProTypeOutputModel = b;
        })
    };
    a.selectProGroup = function () {
        a.selectProGroupData({
            clientId: a.model.hidden.clientId
        }, function (b) {
            a.model.form.CLI0390SelProGroupOutputModel = b;
        })
    };
    a.regisProductType =
        function () {
            a.regisProductTypeData({
                clientId: a.model.hidden.clientId,
                productTypeName: a.model.form.CLI0390RegisInputModel.productTypeName
            }, function (b) {
                a.model.form.CLI0390RegisResult = b.proResult;
                a.model.form.CLI0390RegisInputModel.productTypeName = "";
                a.selectProType();
                "NG" == a.model.form.CLI0390RegisResult.proFlg ? e.pop("error", a.model.form.CLI0390RegisResult.message, null, "trustedHtml") : e.pop("success", a.model.form.CLI0390RegisResult.message, null, "trustedHtml")
            })
        };
    a.deleteProductType = function (b) {
        a.deleteProductTypeData({
            clientId: a.model.hidden.clientId,
            productTypeId: b.productTypeId
        }, function (b) {
            a.model.form.CLI0390RegisResult = b;
            a.selectProType()
        })
    };
    a.editProductType = function (a) {
        c.$broadcast("CLI0300#openUpdateProductTypeModal", {
            itemProductType: angular.copy(a)
        })
    }
}]);
angular.module("cli0400Module", ["dmsCommon", "sal0401Module", "sal0402Module", "sal0403Module", "sal0404Module"]).controller("CLI0400Ctrl", ["$scope", "serverService", "$rootScope", function (a, d, c) {
    a.initData = function (a, b) {
        d.doPost("/CLI0400/initData", a, function (a) {
            (b || angular.noop)(a)
        })
    };
    a.searchData = function (a, b) {
        d.doPost("/CLI0400/searchDataSalman", a, function (a) {
            (b || angular.noop)(a)
        })
    };
    a.init = function () {
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
        a.initData(param, function (c) {
            a.model.form.CLI0400InitOutputModel = c
        })
    };
    a.chooseArea = function (c, b) {
        a.model.hidden.defaultAreaName =
            c;
        a.model.hidden.areaId = b
    };
    a.chooseSale = function (e) {
        a.model.form.currentSaleChoose = e;
        a.model.hidden.showDetailSale = !0;
        a.model.form.currentSaleChoose.urlImg = getContextPath() + a.model.form.currentSaleChoose.imagePath;
        c.$broadcast("SAL0401#search", {
            saleChoose: e
        });
        c.$broadcast("SAL0402#search", {});
        c.$broadcast("SAL0404#search", {})
    };
    a.search = function () {
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
        }, function (c) {
            a.model.form.CLI0400SearchDataSalmanResult = c;
            a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo =
                a.model.form.CLI0400SearchDataSalmanResult.resultSearch.pagingInfo;
            a.model.form.CLI0400InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0400SearchDataSalmanResult.resultSearch.searchSalList
        })
    };
    a.searchDataPaging = function () {
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
        }, function (c) {
            a.model.form.CLI0400SearchDataSalmanResult = c;
            a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo = a.model.form.CLI0400SearchDataSalmanResult.resultSearch.pagingInfo;
            a.model.form.CLI0400InitOutputModel.resultSearch.searchSalList = a.model.form.CLI0400SearchDataSalmanResult.resultSearch.searchSalList
        })
    };
    a.prevPage = function () {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchDataPaging()
    };
    a.nextPage = function () {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchDataPaging()
    };
    a.startPage = function () {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchDataPaging()
    };
    a.endPage = function () {
        a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.crtPage =
            a.model.form.CLI0400InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchDataPaging()
    }
}]);