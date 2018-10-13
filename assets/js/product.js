/**
 * Created by ledaicanh on 11/16/17.
 */
angular.module("pro1100Module", ["dmsCommon", "fcsa-number"]).controller("PRO1100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
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
        a.$on("PR01100#search", function () {
            a.model.hidden.showModalEditPro = !1;
            a.searchPRO1100Data()
        });
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.model.hidden.productTypeId = null;
        a.model.hidden.productGroupId = null;
        a.initData(a.model.hidden.clientCode, a.model.hidden.clientId);
        a.$on("CLI0300#closeImportProduct", function () {
            a.searchPRO1100DataOnly()
        })
    };
    a.searchPRO1100 = function () {
        a.searchPRO1100DataOnly()
    };
    a.prevPagePRO1100 = function () {
        a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage -= 1;
        a.searchPRO1100Data()
    };
    a.nextPagePRO1100 =
        function () {
            a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage += 1;
            a.searchPRO1100Data()
        };
    a.startPagePRO1100 = function () {
        a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage = 1;
        a.searchPRO1100Data()
    };
    a.endPagePRO1100 = function () {
        a.model.form.PRO1100SearchDataModel.pagingInfo.crtPage = a.model.form.PRO1100SearchDataModel.pagingInfo.ttlPages;
        a.searchPRO1100Data()
    };
    a.showModalEditPro = function (e) {
        a.model.hidden.showModalEditPro = !0;
        c.$broadcast("CLI0300#openEditProductModal", {
            productInfo: e
        })
    };
    a.deleteProduct =
        function (c) {
            param = {
                productModel: c.productModel,
                productId: c.productId,
                clientId: a.model.hidden.clientId
            };
            d.doPost("/PRO1100/deleteProduct", param, function (b) {
                "NG" == b.proFlg ? e.pop("error", b.message, null, "trustedHtml") : e.pop("success", b.message, null, "trustedHtml");
                a.searchPRO1100();
            })
        };
    a.initData = function (c, b) {
        param = {
            clientCode: c,
            clientId: b
        };
        d.doPost("/PRO1100/initData", param, function (b) {
            a.model.form.PRO1100SearchDataModel = b;
            a.model.form.InitData = b.initData
        })
    };
    a.searchPRO1100Data = function () {
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
            function (c) {
                a.model.form.PRO1100SearchDataModel = c
            })
    };
    a.searchPRO1100DataOnly = function () {
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
        d.doPost("/PRO1100/searchData", param, function (c) {
            a.model.form.PRO1100SearchDataModel = c
        })
    }
}]);
angular.module("pro1120Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("PRO1120Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
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
    a.init = function () {
        a.model.hidden.clientCode = angular.element("#clientCode").val();
        a.model.hidden.clientId = angular.element("#clientId").val();
        param = {
            clientId: a.model.hidden.clientId
        };
        a.initData(param);
        a.$on("PR01120#init", function (b, c) {
            a.model.hidden.showCreatePro = c.showCreatePro;
            a.model.hidden.buttonModeAdd = !0
        });
        a.$on("PR01120#edit", function (b, c) {
            a.model.hidden.buttonModeAdd = !1;
            param = {
                clientId: a.model.hidden.clientId,
                productId: c.productInfo.productId
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
    a.clearProductValue = function () {
        a.model.form.PRO1120ModelAddProduct.productModel = "";
        a.model.form.PRO1120ModelAddProduct.productTypeId = null;
        a.model.form.PRO1120ModelAddProduct.productGroupId = null;
        a.model.form.PRO1120ModelAddProduct.productName = "";
        a.model.form.PRO1120ModelAddProduct.price = ""
    };
    a.addProduct = function () {
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
    a.onchangeProductType = function (id) {
        a.selectGroupByProductType(id);
        a.model.hidden.validated.productGroupId = null;
        a.model.form.PRO1120ModelAddProduct.productGroupId = null;

    };
    a.selectGroupByProductType = function (id) {
        d.doPost("/PRO1120/selectGroupByProductType", {productTypeId: id}, function (b) {
            a.model.form.PRO1120InitData.proGroupList = b.proGroupList;
        })
    };
    a.closeAddProduct = function () {
        a.model.hidden.showCreatePro = !1;
        if (null != a.model.form.PRO1120AddProductResult) a.model.form.PRO1120AddProductResult.proFlg = null;
        c.$broadcast("PR01100#search", {
            param: null
        });
        c.$broadcast("CLI0300#closeModalPRO1120", {
            param: null
        })
    };
    a.updateProduct = function () {
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
    a.closeUpdateProduct = function () {
        a.model.hidden.showModalEditPro = !1;
        if (null != a.model.form.PRO1120UpdateProductResult) a.model.form.PRO1120UpdateProductResult.proFlg =
            null;
        a.searchPRO1100Data()
    };
    a.initData = function (b) {
        d.doPost("/PRO1120/initData", b, function (b) {
            a.model.form.PRO1120InitData = b
        })
    };
    a.selectProductData = function (b) {
        d.doPost("/PRO1120/selectProduct", b, function (b) {
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
    a.addProductData = function (b) {
        d.doPost("/PRO1120/regisPro", b, function (b) {
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
    a.updateProductData = function (b) {
        d.doPost("/PRO1120/updatePro", b, function (b) {
            a.model.form.PRO1120AddProductResult = b;
            null != a.model.form.PRO1120AddProductResult && ("NG" == a.model.form.PRO1120AddProductResult.proFlg ? e.pop("error", a.model.form.PRO1120AddProductResult.message, null, "trustedHtml") : (e.pop("success", a.model.form.PRO1120AddProductResult.message, null, "trustedHtml"), c.$broadcast("PR01100#search", {
                param: null
            }), c.$broadcast("CLI0300#closeModalPRO1120", {
                param: null
            })))
        })
    }
}]);
angular.module("pro1130Module", ["dmsCommon", "toaster"]).controller("PRO1130Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function (a, d, c, e, b) {
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
        a.model.hidden.clientId = angular.element("#clientId").val();
        a.$on("PR01130#initFromRivalProduct", function (b, c) {
            a.model.hidden.rivalMode = !0;
            a.model.hidden.rivalId = c.rivalId
        });
        a.$on("PR01130#importProduct", function () {
            a.model.hidden.rivalMode = !1
        })
    };
    a.chooseFile = function () {
        // event.stopPropagation();
        angular.element("#pro1130ChooseFile").click()
    };
    a.closeImportProduct = function () {
        c.$broadcast("CLI0300#closeImportProduct", {})
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
        if (!0 == a.model.hidden.rivalMode) {
            var f = {
                clientId: a.model.hidden.clientId,
                rivalId: a.model.hidden.rivalId
            };
            d.uploadFile("/CLI0370", a.model.form.file,
                f,
                function (f) {
                    a.model.form.PR01130UpdateRivalResult = f.proResult;
                    null != a.model.form.PR01130UpdateRivalResult && ("NG" == a.model.form.PR01130UpdateRivalResult.proFlg ? b.pop("error", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml") : (b.pop("success", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml"), c.$broadcast("CLI0300#closeImportProduct", {})))
                })
        } else f = {
            clientId: a.model.hidden.clientId
        }, d.uploadFile("/PRO1120", a.model.form.file, f, function (f) {
            a.model.form.PR01130UpdateRivalResult =
                f.proResult;
            null != a.model.form.PR01130UpdateRivalResult && ("NG" == a.model.form.PR01130UpdateRivalResult.proFlg ? b.pop("error", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml") : (b.pop("success", a.model.form.PR01130UpdateRivalResult.message, null, "trustedHtml"), c.$broadcast("CLI0300#closeImportProduct", {})))
        })
    }
}]);
