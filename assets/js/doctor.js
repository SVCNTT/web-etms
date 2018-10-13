/**
 * START DOCTOR
 * */

var doc0200Module = angular.module("doc0200Module", ["dmsCommon", "cli0360Module", "cli0363Module", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function (a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("DOC0200Ctrl", ["$scope", "$http", "$filter", "serverService", "GoogleMapApi".ns(), "toaster", function (a, d, c, e, b, f) {
    a.init = function () {
        a.model = {};
        a.model.form = {
            STO0200InitDataOutputModel: null,
            STO0200CreateStoreInputModel: {
                docName: "",
                title: "",
                position: "",
                specialty: "",
                department: "",
                hospital: "",
                classs: "",
                zone: "",
                zoneId: null,
                mr: "",
                bu: "",
                productTypeId: null,
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
            docName: "",
            title: "",
            position: "",
            specialty: "",
            department: "",
            hospital: "",
            classs: "",
            zone: "",
            zoneId: null,
            mr: "",
            bu: "",
            productTypeId: null,
            adress: "",
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
    a.createStoreContinus = function () {
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

var doc0210Module = angular.module("doc0210Module", ["dmsCommon", "google-maps".ns(), "toaster"]).config(["GoogleMapApiProvider".ns(), function (a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("DOC0210Ctrl", ["$scope", "$http", "serverService", "GoogleMapApi".ns(), "toaster", function (a, d, c, e, b) {
    a.model = {};
    a.model.form = {
        STO0210InitDataOutputModel: null,
        STO0210UpdateStoreInputModel: {
            storeId: "",
            storeCode: "",
            docName: "",
            title: "",
            position: "",
            specialty: "",
            department: "",
            classs: "",
            hospital: "",
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
        if (!ValidateUtil.isValidTextRequired(a.model.form.STO0210SelectStoreResultDto.selectSore.docName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.storeName.isErrored = !0, a.model.hidden.validated.docName.msg = Messages.getMessage("E0000004", "STO0210_LABEL_STORE_NAME");
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
    a.updateStoreContinus = function () {
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

/**
 * END DOCTOR
 *//**
 * Created by ledaicanh on 11/15/17.
 */
