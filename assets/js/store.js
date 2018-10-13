var sto0500Module = angular.module("sto0500Module", ["dmsCommon", "sto0100Module", "sto0110Module", "sto0511Module", "sto0531Module", "sto0600Module", "sto0610Module", "ngLoadingSpinner"]).controller("STO0500Ctrl", ["$scope", "serverService", "$rootScope", function (a) {
    a.init = function () {
        a.model = {
            hidden: {
                showImportStore: !1,
                showImportSurvey: !1,
                showImportStoreSurvey: !1,
                showModalViewSalesman: !1,
                showImportInventory: !1,
                storeId: 0,
                storeCode: "",
                token: ""
            },
            activeTab: 1
        }

        a.$on("STO0100#closeImportStore",
            function () {
                a.model.hidden.showImportStore = !1
            });

        a.$on("STO0100#closeImportSurvey",
            function () {
                a.model.hidden.showImportSurvey = !1
            });

        a.$on("STO0100#closeImportStoreSurvey",
            function () {
                a.model.hidden.showImportStoreSurvey = !1
            });

        a.$on("STO0100#closeModalViewSalesman",
            function () {
                a.model.hidden.showModalViewSalesman = !1
            });

        a.$on("STO0100#closeImportInventory",
            function () {
                a.model.hidden.showImportInventory = !1
            });
    }
    a.importStore = function () {
        a.model.hidden.showImportStore = !0
    };
    a.importSurvey = function () {
        a.model.hidden.showImportSurvey = !0
    };
    a.importStoreSurvey = function () {
        a.model.hidden.showImportStoreSurvey = !0
    };
    a.showModalSalesman = function (item) {
        a.model.hidden.storeId = item.storeId;
        a.model.hidden.storeCode = item.storeCode;
        a.model.hidden.token = item.token;
        a.model.hidden.showModalViewSalesman = !0
    };
    a.importInventory = function () {
        a.model.hidden.showImportInventory = !0
    };
}]);

angular.module("sto0100Module", ["dmsCommon", "sto0110Module","ngLoadingSpinner"]).controller("STO0100Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.model = {
        hidden: {
            storeCode: "",
            storeName: "",
            clientId: "",
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            },
            defaultAreaName: Messages.getMessage("STO0100_LABEL_REGION_CHOOSE")
        }
    };
    a.model.form = {
        STO0100InitDataModel: null,
        STO0100SearchDataInputModel: null
    };
    a.init = function() {
        a.initData()
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.deleteStore = function (c) {
        param = {
            storeCode: c.storeCode
        };
        a.deleteStoreData(param)
    };
    a.chooseArea = function (c, e) {
        a.model.hidden.defaultAreaName = c;
        a.model.hidden.areaId = e
    };
    a.initData = function () {
        d.doPost("/STO0100/initData", {}, function (c) {
            a.model.form.STO0100InitDataModel = c
        })
    };
    a.searchData = function () {
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
            function (c) {
                a.model.form.STO0100SearchDataInputModel = c;
                if (null != a.model.form.STO0100SearchDataInputModel.resultSearch) a.model.form.STO0100InitDataModel.resultSearch.storeInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.storeInfo, a.model.form.STO0100InitDataModel.resultSearch.pagingInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.pagingInfo
            })
    };
    a.searchDataOnly = function () {
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
        }, function (c) {
            a.model.form.STO0100SearchDataInputModel = c;
            if (null != a.model.form.STO0100SearchDataInputModel.resultSearch) a.model.form.STO0100InitDataModel.resultSearch.storeInfo =
                a.model.form.STO0100SearchDataInputModel.resultSearch.storeInfo, a.model.form.STO0100InitDataModel.resultSearch.pagingInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.pagingInfo
        })
    };
    a.deleteStoreData = function (c) {
        d.doPost("/STO0100/deleteStore", c, function (b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : e.pop("success", b.proResult.message, null, "trustedHtml");
            a.search()
        })
    }
}]);
angular.module("sto0110Module", ["dmsCommon", "toaster"]).controller("STO0110Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function (a, d, c, e, b) {
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
        angular.element("#STO0110ChooseFile").click()
    };
    a.closeImportStore = function () {
        c.$broadcast("STO0100#closeImportStore", {})
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
        d.uploadFile("/STO0120", a.model.form.file, f, function (f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("STO0100#closeImportStore", {})))

            if (null != f.proResult.proFlg && "OK" == f.proResult.proFlg) window.location.href =
                getContextPath() + "/STO0100/"


        })
    }
}]);

var sto0200Module = angular.module("sto0200Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function (a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("STO0200Ctrl", ["$scope", "$http", "$filter", "serverService", "GoogleMapApi".ns(), "toaster", function (a, d, c, e, b, f) {
    a.init = function () {
        a.model = {};
        a.model.form = {
            STO0200InitDataOutputModel: null,
            STO0200CreateStoreInputModel: {
                storeName: "",
                adress: "",
                classs: "",
                zone: "",
                zoneId: null,
                mr: "",
                bu: "",
                productTypeId: null,
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
                tilesloaded: function () {
                },
                click: function (b, c, e) {
                    var b = e[0],
                        f = b.latLng.lat(),
                        j = b.latLng.lng();
                    a.$apply(function () {
                        a.model.hidden.map.latitude = f;
                        a.model.hidden.map.longitude = j;
                        a.marker = {
                            id: 0,
                            coords: {
                                latitude: a.model.hidden.map.latitude,
                                longitude: a.model.hidden.map.longitude
                            }
                        };
                        d.get("http://maps.google.com/maps/api/geocode/json?latlng=" + f + "," + j + "&sensor=false").success(function (b) {
                            var c = "";
                            "OK" == b.status && null != b.results && void 0 != b.results && angular.forEach(b.results, function (a) {
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
    a.validate = function () {
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
    a.showLocation = function () {
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
    a.chooseArea = function (b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.form.STO0200CreateStoreInputModel.areaId = c
    };
    a.clearCreateParam = function () {
        a.model.form.STO0200CreateStoreInputModel = {
            storeName: "",
            adress: "",
            classs: "",
            zone: "",
            zoneId: null,
            mr: "",
            bu: "",
            productTypeId: null,
            areaId: "",
            latVal: "",
            longVal: ""
        };
        a.model.hidden.map.latitude =
            "";
        a.model.hidden.map.longitude = ""
    };
    a.createStore = function () {
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
    a.createStoreContinus = function () {
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
    a.findLocation = function () {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0200CreateStoreInputModel.adress) + "&sensor=false";
        d.get(b).success(function (b) {
            a.model.form.listPos = b
        })
    };
    a.findLocationEdit = function () {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0210SelectStoreResultDto.adress) + "&sensor=false";
        d.get(b).success(function (b) {
            a.model.form.listPos = b
        })
    };

    a.choosePos = function (b) {
        a.model.hidden.map.latitude = b.geometry.location.lat;
        a.model.hidden.map.longitude =
            b.geometry.location.lng;
        a.model.form.STO0200CreateStoreInputModel.adress = b.formatted_address;
        a.model.form.clickAddress = b.formatted_address;
        a.showLocation()
    };
    a.initData = function () {
        param = {};
        e.doPost("/STO0200/initData", param, function (b) {
            a.model.form.STO0200InitDataOutputModel = b
        })
    };
    a.createStoreDataAndChangePage = function (b) {
        e.doPost("/STO0200/regisStore", b, function (b) {
            a.model.form.STO0200CreateStoreResultDto = b;
            if (null != a.model.form.STO0200CreateStoreResultDto && "OK" == a.model.form.STO0200CreateStoreResultDto.proResult.proFlg) window.location.href =
                getContextPath() + "/STO0100/"
        })
    };
    a.createStoreData = function (b) {
        e.doPost("/STO0200/regisStore", b, function (b) {
            a.model.form.STO0200CreateStoreResultDto = b;
            null != a.model.form.STO0200CreateStoreResultDto && ("OK" == a.model.form.STO0200CreateStoreResultDto.proResult.proFlg ? (f.pop("success", a.model.form.STO0200CreateStoreResultDto.proResult.message, null, "trustedHtml"), a.clearCreateParam()) : f.pop("error", a.model.form.STO0200CreateStoreResultDto.proResult.message, null, "trustedHtml"))
        })
    }
}]);
var sto0210Module = angular.module("sto0210Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function (a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("STO0210Ctrl", ["$scope", "$http", "serverService", "GoogleMapApi".ns(), "toaster", function (a, d, c, e, b) {
    a.model = {};
    a.model.form = {
        STO0210InitDataOutputModel: null,
        STO0210UpdateStoreInputModel: {
            storeId: "",
            storeCode: "",
            storeName: "",
            classs: "",
            zone: "",
            zoneId: null,
            mr: "",
            bu: "",
            productTypeId: null,
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
    a.init = function () {
        a.map = {
            center: {
                latitude: 10.771918,
                longitude: 106.698347
            },
            zoom: 18,
            events: {
                tilesloaded: function () {
                },
                click: function (b, c, e) {
                    var b = e[0],
                        i = b.latLng.lat(),
                        k = b.latLng.lng();
                    a.$apply(function () {
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
                        d.get("http://maps.google.com/maps/api/geocode/json?latlng=" + i + "," + k + "&sensor=false").success(function (b) {
                            var c = "";
                            "OK" == b.status && null != b.results && void 0 != b.results && angular.forEach(b.results, function (a) {
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
        e.then(function () {
        });
        a.initData()
    };
    a.validate = function () {
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
    a.showLocation = function () {
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
    a.findLocationEdit = function () {
        var b = "http://maps.google.com/maps/api/geocode/json?address=" + encodeURIComponent(a.model.form.STO0210SelectStoreResultDto.selectSore.address) + "&sensor=false";
        d.get(b).success(function (b) {
            a.model.form.listPos = b
        })
    };

    a.choosePos = function (b) {
        a.model.hidden.map.latitude = b.geometry.location.lat;
        a.model.hidden.map.longitude = b.geometry.location.lng;
        a.model.form.STO0210SelectStoreResultDto.selectSore.address = b.formatted_address;
        a.model.form.clickAddress = b.formatted_address;
        a.showLocation()
    };
    a.chooseArea = function (b, c) {
        a.model.hidden.defaultAreaName = b;
        a.model.form.STO0210SelectStoreResultDto.selectSore.areaId = c
    };
    a.updateStore =
        function () {
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
    a.updateStoreContinus = function () {
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
    a.initData = function () {
        param = {};
        c.doPost("/STO0210/initData", param, function (b) {
            a.model.form.STO0210InitDataOutputModel = b;
            a.selectStoreData(a.model.hidden.storeId)
        })
    };
    a.selectStoreData = function (b) {
        param = {
            storeId: b
        };
        c.doPost("/STO0210/selectStore", param, function (b) {
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
    a.updateStoreDataAndChangePage = function (b) {
        c.doPost("/STO0210/updateStore", b, function (b) {
            a.model.form.STO0210UpdateStoreResultDto = b;
            if ("OK" == a.model.form.STO0210UpdateStoreResultDto.proResult.proFlg) window.location.href = getContextPath() + "/STO0100/"
        })
    };
    a.updateStoreData = function (e) {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && c.doPost("/STO0210/updateStore", e, function (c) {
            a.model.form.STO0210UpdateStoreResultDto = c;
            "OK" == a.model.form.STO0210UpdateStoreResultDto.proResult.proFlg ? (b.pop("success",
                a.model.form.STO0210UpdateStoreResultDto.proResult.message, null, "trustedHtml"), window.location.href = getContextPath() + "/STO0100/") : b.pop("error", a.model.form.STO0210UpdateStoreResultDto.proResult.message, null, "trustedHtml")
        })
    }
}]);
angular.module("sto0300Module", ["dmsCommon", "fcsa-number", "sto0310Module", "sto0320Module", "sto0330Module", "google-maps".ns(), "ngLoadingSpinner"]).config(["GoogleMapApiProvider".ns(), function (a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("STO0300Ctrl", ["$scope", "$rootScope", "serverService", "$timeout", function (a, d, c, e) {
    a.init = function () {
        a.model.hidden.storeId = angular.element("#storeId").val();
        e(function () {
            d.$broadcast("STO0320#checkRole", {
                activeTab: a.activeTab
            })
        }, 100);
        a.selectStoreData(a.model.hidden.storeId)
    };
    a.initTab1 = function () {
        d.$broadcast("STO0310#init", null)
    };
    a.initTab2 = function () {
        d.$broadcast("STO0320#init", null)
    };
    a.initTab3 = function () {
        d.$broadcast("STO0330#init", null)
    };
    a.selectStoreData = function (b) {
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
            function (b) {
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
angular.module("sto0310Module", ["dmsCommon", "fcsa-number"]).controller("STO0310Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
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
    a.init = function () {
        a.model.hidden.storeId = angular.element("#storeId").val();
        a.initData(a.model.hidden.storeId);
        a.$on("STO0310#init", function () {
            a.initData(a.model.hidden.storeId)
        })
    };
    a.regisClientStore = function () {
        if (null != a.model.hidden.selectedClient) {
            for (var b = 0; b < a.model.form.STO0310InitDataModel.initData.clientInfo.clientList.length; b++) {
                var c = a.model.form.STO0310InitDataModel.initData.clientInfo.clientList[b];
                if (a.model.hidden.selectedClient == c.clientId) a.model.hidden.selectedClientname = c.clientName
            }
            a.regisClientStoreData()
        }
    };
    a.deleteClientStore = function (b) {
        a.deleteClientStoreData(b)
    };
    a.initData = function (b) {
        param = {
            storeId: b
        };
        d.doPost("/STO0310/initData", param, function (b) {
            a.model.form.STO0310InitDataModel = b
        })
    };
    a.regisClientStoreData = function () {
        param = {
            storeId: a.model.hidden.storeId,
            clientId: a.model.hidden.selectedClient,
            clientName: a.model.hidden.selectedClientname
        };
        d.doPost("/STO0310/regisClientStore", param, function (b) {
            a.model.form.STO0310RegisDataModel = b;
            a.model.form.STO0310InitDataModel.initData.clientInfo.clientList = a.model.form.STO0310RegisDataModel.regisResult.clientInfo.clientList;
            a.model.form.STO0310InitDataModel.initData.searchClientStore = a.model.form.STO0310RegisDataModel.regisResult.searchClientStore;
            a.model.form.STO0310Alert.proResult.proFlg = a.model.form.STO0310RegisDataModel.regisResult.proFlg;
            a.model.form.STO0310Alert.proResult.message = a.model.form.STO0310RegisDataModel.regisResult.message;
            "OK" == a.model.form.STO0310Alert.proResult.proFlg && e.pop("success", a.model.form.STO0310Alert.proResult.message)
        })
    };
    a.deleteClientStoreData = function (b) {
        param = {
            storeId: a.model.hidden.storeId,
            clientId: b.clientId,
            clientName: b.clientName,
            versionNo: b.versionNo
        };
        d.doPost("/STO0310/deleteClientStore", param, function (b) {
            a.model.form.STO0310DeleteDataModel = b;
            a.model.form.STO0310InitDataModel.initData.clientInfo.clientList = a.model.form.STO0310DeleteDataModel.deleteResult.clientInfo.clientList;
            a.model.form.STO0310InitDataModel.initData.searchClientStore = a.model.form.STO0310DeleteDataModel.deleteResult.searchClientStore;
            a.model.form.STO0310Alert.proResult.proFlg = a.model.form.STO0310DeleteDataModel.deleteResult.proFlg;
            a.model.form.STO0310Alert.proResult.message = a.model.form.STO0310DeleteDataModel.deleteResult.message
        })
    }
}]);
angular.module("sto0320Module", ["dmsCommon", "fcsa-number"]).controller("STO0320Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
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
    a.init = function () {
        !1 == a.model.hidden.initTab ? (a.model.hidden.storeId = angular.element("#storeId").val(), a.initData(a.model.hidden.storeId), a.model.hidden.initTab = !0) : a.$on("STO0320#init", function () {
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
        a.$on("STO0320#checkRole", function (b, c) {
            if (1 == c.activeTab) a.model.hidden.roleAdmin = !0
        })
    };
    a.selectSalesmanByStoreClient = function () {
        a.selectSalesmanByStoreClientData();
        a.selectSalesmanNotAssingnStore()
    };
    a.regisSalesmanStore = function () {
        a.regisSalesmanStoreData()
    };
    a.selectSalesmanNotAssingnStore = function () {
        a.selectSalesmanNotAssingnStoreDataOnly()
    };
    a.deleteSaleman = function (b) {
        /*event.stopPropagation();*/
        a.deleteSalemanData({
            salesmanId: b.salesmanId,
            salesmanCode: b.salesmanCode,
            storeId: a.model.hidden.storeId
        }, function (b) {
            a.model.form.STO320DeleteResult = b;
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore()
        })
    };
    a.chooseSale = function (b) {
        !1 == b.choose && a.removeSaleItem(b);
        !0 == b.choose && a.addSaleItem(b)
    };
    a.removeSaleItem = function (b) {
        for (var c = 0; c < a.model.form.STO0320ListSaleRegis.length; c++)
            if (a.model.form.STO0320ListSaleRegis[c].salesmanId = b.salesmanId) {
                a.model.form.STO0320ListSaleRegis.splice(c, 1);
                break
            }
        a.checkChooseAll()
    };
    a.addSaleItem =
        function (b) {
            a.model.form.STO0320ListSaleRegis.push({
                salesmanId: b.salesmanId,
                storeId: a.model.hidden.storeId
            });
            a.checkChooseAll()
        };
    a.chooseAll = function () {
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
    a.checkChooseAll = function () {
        if (0 < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore.length; b++)
                if (!1 == a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.checkChooseAllAfterSearch = function () {
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
    a.prevPage = function () {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage -= 1;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.nextPage = function () {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage += 1;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.startPage = function () {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage =
            1;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.endPage = function () {
        a.model.form.STO0320InitDataModel.searchResult.pagingInfo.crtPage = a.model.form.STO0320InitDataModel.searchResult.pagingInfo.ttlPages;
        a.selectSalesmanNotAssingnStoreData()
    };
    a.deleteSalemanData = function (a, c) {
        d.doPost("/STO0320/deleteSalesmanStore", a, function (a) {
            (c || angular.noop)(a)
        })
    };
    a.initData = function (b) {
        param = {
            storeId: b
        };
        d.doPost("/STO0320/initData", param, function (b) {
            a.model.form.STO0320InitDataModel = b;
            a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId =
                a.model.form.STO0320InitDataModel.defaultClientId;
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore();
        })
    };
    a.regisSalesmanStoreData = function () {
        param = {
            selectSalesman: a.model.form.STO0320ListSaleRegis
        };
        d.doPost("/STO0320/regisSalesmanStore", param, function (b) {
            a.model.form.STO0320RegisDataModel = b;
            a.model.form.STO0320Alert.proResult.proFlg = a.model.form.STO0320RegisDataModel.regisResult.proFlg;
            a.model.form.STO0320Alert.proResult.message = a.model.form.STO0320RegisDataModel.regisResult.message;
            a.selectSalesmanByStoreClientData();
            a.selectSalesmanNotAssingnStore();
            a.model.form.STO0320ListSaleRegis = [];
            "OK" == a.model.form.STO0320Alert.proResult.proFlg && e.pop("success", a.model.form.STO0320Alert.proResult.message)
        })
    };
    a.selectSalesmanNotAssingnStoreData = function () {
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
            function (b) {
                a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel = b;
                a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.salesmanNotAssignStore;
                a.model.form.STO0320InitDataModel.searchResult.pagingInfo = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.pagingInfo;
                a.checkChooseAllAfterSearch()
            })
    };
    a.selectSalesmanNotAssingnStoreDataOnly = function () {
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
        d.doPost("/STO0320/selectSalesmanNotAssingnStore", param, function (b) {
            a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel = b;
            a.model.form.STO0320InitDataModel.searchResult.salesmanNotAssignStore = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.salesmanNotAssignStore;
            a.model.form.STO0320InitDataModel.searchResult.pagingInfo = a.model.form.STO0320SelectSalesmanNotAssingnStoreOutputModel.searchResult.pagingInfo;
            a.checkChooseAllAfterSearch()
        })
    };
    a.selectSalesmanByStoreClientData =
        function () {
            param = {
                storeId: a.model.hidden.storeId,
                clientId: a.model.form.STO0320SelectSalesmanNotAssingnStoreInputModel.clientId
            };
            d.doPost("/STO0320/selectSalesmanByStoreClient", param, function (b) {
                a.model.form.STO0320SalesmanByStoreClientOutputModel = b
            })
        }
}]);
angular.module("sto0330Module", ["dmsCommon", "fcsa-number"]).controller("STO0330Ctrl", ["$scope", "serverService", "$rootScope", function (a, d) {
    a.model = {
        hidden: {}
    };
    a.model.form = {
        STO0330InitDataModel: null
    };
    a.init = function () {
        a.model.hidden.storeId = angular.element("#storeId").val();
        a.initData(a.model.hidden.storeId)
    };
    a.getImage = function () {
        if (null != a.model.form.STO0330InitDataModel.photoResult)
            for (var c = 0; c < a.model.form.STO0330InitDataModel.photoResult.length; c++)
                for (var e = a.model.form.STO0330InitDataModel.photoResult[c],
                         b = e.photoPath.length, d = 0; d < b; d++) {
                    var h = e.photoPath[d];
                    h.photoPath = getContextPath() + h.photoPath
                }
    };
    a.initData = function (c) {
        param = {
            storeId: c
        };
        d.doPost("/STO0330/selectPhotoStore", param, function (c) {
            a.model.form.STO0330InitDataModel = c;
            a.getImage()
        })
    }
}]);

sto0500Module.controller("STO0520Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.initData = function (a, e) {
        d.doPost("/STO0521/initData", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function () {
        a.model = {};
        a.model.form = {
            STO0521initData: {
                resultInit: {
                    surveyList: null
                }
            },
            searchParam: {
                survey_id: 0,
                mr_code: null,
                store_code: null
            },
            resultSearch: {
                answerList: null,
                pagingInfo: {
                    ttlRow: null,
                    crtPage: null,
                    rowNumber: null,
                    ttlPages: 0
                }
            }
        },

            a.initData({}, function (c) {
                a.model.form.STO0521initData = c
                a.searchData();
            })
    }
    a.prevPage = function () {
        a.model.form.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.resultSearch.pagingInfo.crtPage = a.model.form.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function () {
        d.doPost("/STO0522/searchData", {
            survey_id: a.model.form.searchParam.survey_id,
            mr_code: a.model.form.searchParam.mr_code,
            store_code: a.model.form.searchParam.store_code,
            pagingInfo: {
                ttlRow: null != a.model.form.resultSearch.pagingInfo ? a.model.form.resultSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.resultSearch.pagingInfo ? a.model.form.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.resultSearch.pagingInfo ? a.model.form.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.resultSearch = b.resultSearch
        })
    };

    a.exportData = function () {
        window.location.href = '/STO0525/exportData/' + a.model.form.searchParam.survey_id;
    };
}]);
sto0500Module.controller("STO0510Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.initData = function (a, e) {
        d.doPost("/STO0511/getSurvey", a, function (a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function () {
        a.model.hidden = {
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            }
        };
        a.model.form = {
            STO0510SearchData: null,
            searchParam: {
                searchInput: {
                    surveyName: ""
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
                list: null
            }
        };
        a.initData({}, function (c) {
            a.model.form.STO0510SearchData = c
        });
        a.$on("STO0510#searchData", function () {
            a.searchData()
        });
    };
    a.prevPage = function () {
        a.model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage = a.model.form.STO0510SearchData.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function () {
        d.doPost("/STO0511/getSurvey", {
            surveyName: a.model.form.searchParam.searchInput.surveyName,
            pagingInfo: {
                ttlRow: null != a.model.form.STO0510SearchData.resultSearch.pagingInfo ? a.model.form.STO0510SearchData.resultSearch.pagingInfo.ttlRow : 0,
                crtPage: null != a.model.form.STO0510SearchData.resultSearch.pagingInfo ? a.model.form.STO0510SearchData.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.STO0510SearchData.resultSearch.pagingInfo ? a.model.form.STO0510SearchData.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.STO0510SearchData = b;
        })
    };
    a.getQuestion = function (item) {
        a.model.form.dataQuestion.survey_id = -1;
        d.doPost("/STO0514/getQuestion", {
            survey_id: item.id,
            token: item.token
        }, function (b) {
            a.model.form.dataQuestion.survey_name = item.name;
            a.model.form.dataQuestion.survey_id = item.id;
            a.model.form.dataQuestion.list = b.resultSearch.questions;
        });
    };
    a.activeSurvey = function (item, status) {
        //item.status = status;
        d.doPost("/STO0515/activeSurvey", {
            survey_id: item.id,
            token: item.token,
            status: status
        }, function (f) {
            if (null != f.proResult.proFlg) {
                if ("NG" == f.proResult.proFlg) {
                    e.pop("error", f.proResult.message, null, "trustedHtml");
                } else {
                    e.pop("success", f.proResult.message, null, "trustedHtml");
                    a.searchData();
                }
            }
        });
    };
    a.deleteSurvey = function (item) {
        d.doPost("/STO0516/deleteSurvey", {
            id: item.id,
            token: item.token
        }, function (b) {
            "OK" == b.proResult.proFlg && (e.pop("success", b.proResult.message, null, "trustedHtml"), a.searchData());
            "NG" == b.proResult.proFlg && e.pop("error", b.proResult.message, null, "trustedHtml")
        })
    };
}]);

angular.module("sto0511Module", ["dmsCommon", "toaster"]).controller("STO0511Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function (a, d, c, e, b) {
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
        angular.element("#STO0511ChooseFile").click()
    };
    a.closeImportSurvey = function () {
        c.$broadcast("STO0100#closeImportSurvey", {})
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
        d.uploadFile("/STO0513/import", a.model.form.file, f, function (f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("STO0510#searchData"), c.$broadcast("STO0100#closeImportSurvey", {})))
        })
    }
}]);

sto0500Module.controller("STO0523Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
        a.model = {};
        a.model.form = {
            data: null
        };
        a.model.hidden = {
            survey_id: angular.element("#survey-id").val(),
            id: angular.element("#survey-answer-id").val(),
            token: angular.element("#survey-answer-tk").val()
        };
        a.initData(
            {
                survey_id: a.model.hidden.survey_id,
                id: a.model.hidden.id,
                token: a.model.hidden.token
            }, function (c) {
                a.model.form.data = c;
            })
    }
    a.initData = function (a, e) {
        d.doPost("/STO0524/getDetail", a, function (a) {
            (e || angular.noop)(a)
        })
    };
}]);

sto0500Module.controller("STO0530Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.model = {
        hidden: {
            storeCode: "",
            deleteConfirm: {
                message: Messages.getMessage("C0000001")
            },
            defaultAreaName: Messages.getMessage("STO0100_LABEL_REGION_CHOOSE")
        }
    };
    a.model.form = {
        STO0100InitDataModel: null,
        STO0100SearchDataInputModel: null
    };
    a.init = function () {
        a.initData();
        a.$on("STO0530#search", function () {
            a.search()
        });
    };
    a.search = function () {
        a.searchDataOnly()
    };
    a.prevPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage =
            a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.initData = function () {
        d.doPost("/STO0531/initData", {}, function (c) {
            a.model.form.STO0100InitDataModel = c
        })
    };
    a.searchData = function () {
        d.doPost("/STO0532/searchData", {
                searchInput: {
                    storeCode: a.model.hidden.storeCode
                },
                pagingInfo: {
                    ttlRow: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                    crtPage: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                    rowNumber: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
                }
            },
            function (c) {
                a.model.form.STO0100SearchDataInputModel = c;
                if (null != a.model.form.STO0100SearchDataInputModel.resultSearch) a.model.form.STO0100InitDataModel.resultSearch.storeInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.storeInfo, a.model.form.STO0100InitDataModel.resultSearch.pagingInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.pagingInfo
            })
    };
    a.searchDataOnly = function () {
        d.doPost("/STO0532/searchData", {
            searchInput: {
                storeCode: a.model.hidden.storeCode
            },
            pagingInfo: {
                ttlRow: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.STO0100InitDataModel.resultSearch.pagingInfo ? a.model.form.STO0100InitDataModel.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (c) {
            a.model.form.STO0100SearchDataInputModel = c;
            if (null != a.model.form.STO0100SearchDataInputModel.resultSearch) a.model.form.STO0100InitDataModel.resultSearch.storeInfo =
                a.model.form.STO0100SearchDataInputModel.resultSearch.storeInfo, a.model.form.STO0100InitDataModel.resultSearch.pagingInfo = a.model.form.STO0100SearchDataInputModel.resultSearch.pagingInfo
        })
    };
    a.deleteStore = function (item) {
        d.doPost("/STO0533/deleteStore", {
            storeCode: item.storeCode,
            token: item.token
        }, function (b) {
            "NG" == b.proResult.proFlg ? e.pop("error", b.proResult.message, null, "trustedHtml") : (e.pop("success", b.proResult.message, null, "trustedHtml"), a.search());
        })
    }
}]);

sto0500Module.controller("STO0523Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
        a.model = {};
        a.model.form = {
            data: null
        };
        a.model.hidden = {
            survey_id: angular.element("#survey-id").val(),
            id: angular.element("#survey-answer-id").val(),
            token: angular.element("#survey-answer-tk").val()
        };
        a.initData(
            {
                survey_id: a.model.hidden.survey_id,
                id: a.model.hidden.id,
                token: a.model.hidden.token
            }, function (c) {
                a.model.form.data = c;
            })
    }
    a.initData = function (a, e) {
        d.doPost("/STO0524/getDetail", a, function (a) {
            (e || angular.noop)(a)
        })
    };
}]);

angular.module("sto0531Module", ["dmsCommon", "toaster"]).controller("STO0531Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function (a, d, c, e, b) {
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
        angular.element("#STO0531ChooseFile").click()
    };
    a.closeImportStoreSurvey = function () {
        c.$broadcast("STO0100#closeImportStoreSurvey", {})
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
        d.uploadFile("/STO0535/import", a.model.form.file, f, function (f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("STO0530#search"), c.$broadcast("STO0100#closeImportStoreSurvey", {})))
        })
    }
}]);

sto0500Module.controller("STO0536Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function (store_id, store_code, token) {
        a.model = {};
        a.model.form = {
            data: {
                store_code: store_code,
                salesmans: null
            }
        };
        a.initData(
            {
                store_id: store_id,
                token: token
            },
            function (c) {
                a.model.form.data.salesmans = c.data;
            })
    };
    a.closeModalViewSalesman = function () {
        c.$broadcast("STO0100#closeModalViewSalesman", {})
    };
    a.initData = function (a, e) {
        d.doPost("/STO0537/getSalesman", a, function (a) {
            (e || angular.noop)(a)
        })
    };
}]);

sto0500Module.controller("STO0540Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    a.init = function () {
        a.model.form = {
            searchParam: {
                searchInput: {
                    salesmanCode: "",
                    salesmanName: ""
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            STO0540SearchDataResult: {
                resultSearch:{
                    salInfo: null,
                    pagingInfo: null
                }
            }
        };
        a.searchData()
    };
    a.search = function () {
        a.searchData()
    };
    a.prevPage = function () {
        a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function () {
        a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function () {
        a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function () {
        a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage = a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function () {
        d.doPost("/STO0541/search", {
            searchInput: {
                salesmanCode: a.model.form.searchParam.searchInput.salesmanCode,
                salesmanName: a.model.form.searchParam.searchInput.salesmanName
            },
            pagingInfo: {
                ttlRow: null != a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo ? a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo ?
                    a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo ? a.model.form.STO0540SearchDataResult.resultSearch.pagingInfo.rowNumber : null
            }
        }, function (b) {
            a.model.form.STO0540SearchDataResult = b;
        })
    };
}]);