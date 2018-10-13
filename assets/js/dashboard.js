angular.module("das0100Module", ["dmsCommon", "das0110Module", "das0130Module", "das0140Module", "das0150Module", "ngLoadingSpinner"]).controller("DAS0100Ctrl", ["$scope", "serverService", "$rootScope", function(a) {
    a.init = function() {
        a.model = {};
        a.model.activeTab = 1
    }
}]);

angular.module("das0110Module", ["dmsCommon", "highcharts-ng"]).controller("DAS0110Ctrl", function($scope, serverService) {

    $scope.model = {};
    $scope.model.form = {
        DAS0110SearchInputModel: {
            startDate: null,
            endDate: null
        }
    };
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    $scope.chart = {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            zoomType: 'x'
        },
        options: {
            tooltip: {
                shared: true,
                crosshairs: true,
                xDateFormat: '%a, %b %e'
            }
        },
        title: {
            text: 'List Call Records'
        },

        xAxis: {
            tickInterval: 24 * 3600 * 1000, // one date
            minTickInterval: 24 * 3600 * 1000, // one date
            type: "datetime",
            dateTimeLabelFormats: { // don't display the dummy year
                day: '%e. %b'
            },
            tickWidth: 0,
            gridLineWidth: 1,
            labels: {
                align: 'left',
                x: 3,
                y: -3
            }
        },

        yAxis: [{ // left y axis
            title: {
                text: null
            },
            labels: {
                align: 'left',
                x: 3,
                y: 16,
                format: '{value:.,0f}'
            },
            showFirstLabel: false
        }, { // right y axis
            linkedTo: 0,
            gridLineWidth: 0,
            opposite: true,
            title: {
                text: null
            },
            labels: {
                align: 'right',
                x: -3,
                y: 16,
                format: '{value:.,0f}'
            },
            showFirstLabel: false
        }],

        legend: {
            align: 'left',
            verticalAlign: 'top',
            floating: true,
            borderWidth: 0
        },

        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function (e) {
                            hs.htmlExpand(null, {
                                pageOrigin: {
                                    x: e.pageX || e.clientX,
                                    y: e.pageY || e.clientY
                                },
                                headingText: this.series.name,
                                maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
                                this.y + ' visits',
                                width: 200
                            });
                        }
                    }
                },
                marker: {
                    lineWidth: 1
                }
            }
        }
    };
    $scope.init = function() {
        $scope.initData([], function(a) {
            //$scope.chart.series = a.callRecords;
            //$scope.callRecords = a.callRecords;
        });
    };

    $scope.selectScheduleData = function(a, e) {
        serverService.doPost("/DAS0110/initData", a, function(a) {
            (e || angular.noop)(a)
            $scope.chart.series = a.callRecords;
        })
    };

    $scope.initData = function(a, f) {
        serverService.doPost("/DAS0110/initData", a, function(a) {
            (f || angular.noop)(a)
            $scope.chart.series = a.callRecords;

        })
    };

    $scope.init();
    $scope.searchData = function() {
        $scope.selectScheduleData({
            startDate: $scope.model.form.DAS0110SearchInputModel.startDate,
            endDate: $scope.model.form.DAS0110SearchInputModel.endDate
        }, function(c) {
            $scope.callRecords = c.callRecords;
        })
    };

}).directive('hcPie', function() {
    return {
        restrict: 'C',
        replace: true,
        scope: {
            items: '='
        },
        //controller: function ($scope, $element, $attrs) {
        //    console.log(2);
        //
        //},
        template: '<div id="container" style="margin: 0 auto">not working</div>',
        link: function (scope, element, attrs) {
            var chart = new Highcharts.Chart({
                });
        }
    }
});

angular.module("das0130Module", ["dmsCommon"]).controller("DAS0130Ctrl", ["$scope", "serverService", function(a, d) {
    a.initData = function(a, e) {
        d.doPost("/DAS0130/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.searchBillData = function(a, e) {
        d.doPost("/DAS0130/searchBill", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.searchBillDetailData = function(a, e) {
        d.doPost("/DAS0130/searchBillDetail", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {
            hidden: {
                no_img: getContextPathImageDefault() + "/img/no_img.png",
                all: 0,
                today: 1,
                month: 2,
                checkYes: !1,
                checkNo: !1,
                currentBill: null,
                DAS0130SearchInputModel: {
                    searchInput: {
                        storeName: null,
                        storeCode: null,
                        storeId: null,
                        clientId: null,
                        salesmanCode: "",
                        salesmanName: "",
                        billDateCd: 0,
                        billNoFlag: 2
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
            DAS0130InitOutputModel: null,
            DAS0130ResultSearchModel: null,
            DAS0130BillDetailOutputModel: null
        };
        param = {
            clientId: null
        };
        a.initData(param, function(c) {
            a.model.form.DAS0130InitOutputModel = c
        })
    };
    a.search = function() {
        param = {
            searchInput: {
                storeName: a.model.hidden.DAS0130SearchInputModel.searchInput.storeName,
                storeCode: a.model.hidden.DAS0130SearchInputModel.searchInput.storeCode,
                clientId: a.model.hidden.DAS0130SearchInputModel.searchInput.clientId,
                salesmanCode: a.model.hidden.DAS0130SearchInputModel.searchInput.salesmanCode,
                salesmanName: a.model.hidden.DAS0130SearchInputModel.searchInput.salesmanName,
                billDateCd: a.model.hidden.DAS0130SearchInputModel.searchInput.billDateCd,
                billNoFlag: a.model.hidden.DAS0130SearchInputModel.searchInput.billNoFlag
            },
            pagingInfo: {
                ttlRow: null != a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo ?
                    a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: 1,
                rowNumber: null != a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo ? a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        a.searchBillData(param, function(c) {
            a.model.hidden.currentBill = null;
            a.model.form.DAS0130BillDetailOutputModel = null;
            a.model.form.DAS0130ResultSearchModel = c;
            a.model.form.DAS0130ResultSearchModel = c;
            a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo = a.model.form.DAS0130ResultSearchModel.resultSearch.pagingInfo;
            a.model.form.DAS0130InitOutputModel.resultSearch.billInfo = a.model.form.DAS0130ResultSearchModel.resultSearch.billInfo
        })
    };
    a.searchBillDataPage = function() {
        param = {
            searchInput: {
                storeName: a.model.hidden.DAS0130SearchInputModel.searchInput.storeName,
                storeCode: a.model.hidden.DAS0130SearchInputModel.searchInput.storeCode,
                clientId: a.model.hidden.DAS0130SearchInputModel.searchInput.clientId,
                salesmanCode: a.model.hidden.DAS0130SearchInputModel.searchInput.salesmanCode,
                salesmanName: a.model.hidden.DAS0130SearchInputModel.searchInput.salesmanName,
                billDateCd: a.model.hidden.DAS0130SearchInputModel.searchInput.billDateCd,
                billNoFlag: a.model.hidden.DAS0130SearchInputModel.searchInput.billNoFlag
            },
            pagingInfo: {
                ttlRow: null != a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo ? a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo ? a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo ?
                    a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.rowNumber : null
            }
        };
        a.searchBillData(param, function(c) {
            a.model.hidden.currentBill = null;
            a.model.form.DAS0130BillDetailOutputModel = null;
            a.model.form.DAS0130ResultSearchModel = c;
            a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo = a.model.form.DAS0130ResultSearchModel.resultSearch.pagingInfo;
            a.model.form.DAS0130InitOutputModel.resultSearch.billInfo = a.model.form.DAS0130ResultSearchModel.resultSearch.billInfo
        })
    };
    a.prevPage = function() {
        a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.crtPage -=
            1;
        a.searchBillDataPage()
    };
    a.nextPage = function() {
        a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.crtPage += 1;
        a.searchBillDataPage()
    };
    a.startPage = function() {
        a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.crtPage = 1;
        a.searchBillDataPage()
    };
    a.endPage = function() {
        a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.crtPage = a.model.form.DAS0130InitOutputModel.resultSearch.pagingInfo.ttlPages;
        a.searchBillDataPage()
    };
    a.searchBillDetail = function(c) {
        a.model.hidden.currentBill = c;
        param = {
            billId: c.billId,
            clientId: c.clientId
        };
        a.searchBillDetailData(param, function(c) {
            a.model.form.DAS0130BillDetailOutputModel = c;
            for (c = 0; c < a.model.form.DAS0130BillDetailOutputModel.resultSearch.metaData.cusMetaInfo.length; c++) {
                var b = a.model.form.DAS0130BillDetailOutputModel.resultSearch.metaData.cusMetaInfo[c];
                if (null != b.inputVal) b.inputVal = b.inputVal.replace("|", ",")
            }
            if (null != a.model.form.DAS0130BillDetailOutputModel.resultSearch.billInfo.pathPhoto1) a.model.form.DAS0130BillDetailOutputModel.resultSearch.billInfo.pathPhoto1Url =
                getContextPath() + a.model.form.DAS0130BillDetailOutputModel.resultSearch.billInfo.pathPhoto1;
            if (null != a.model.form.DAS0130BillDetailOutputModel.resultSearch.billInfo.pathPhoto2) a.model.form.DAS0130BillDetailOutputModel.resultSearch.billInfo.pathPhoto2Url = getContextPath() + a.model.form.DAS0130BillDetailOutputModel.resultSearch.billInfo.pathPhoto2
        })
    };
    a.$watchCollection("model.hidden.checkYes", function() {
        a.setBillNo()
    });
    a.$watchCollection("model.hidden.checkNo", function() {
        a.setBillNo()
    });
    a.setBillNo = function() {
        a.model.hidden.DAS0130SearchInputModel.searchInput.billNoFlag = !0 == a.model.hidden.checkYes && !0 == a.model.hidden.checkNo ? 2 : !0 == a.model.hidden.checkYes && !1 == a.model.hidden.checkNo ? 1 : !1 == a.model.hidden.checkYes && !0 == a.model.hidden.checkNo ? 0 : 2
    };
    a.getWidthImageList = function() {
        for (var c = 0, e = 0; e < a.model.form.DAS0130BillDetailOutputModel.resultSearch.billDetailLst.length; e++) {
            var b = a.model.form.DAS0130BillDetailOutputModel.resultSearch.billDetailLst[e];
            null != b.pathPhoto1 && (c += 103);
            null != b.pathPhoto2 && (c += 103);
            if (null != b.pathPhoto1 || null != b.pathPhoto2) c += 10
        }
        return c
    }
}]);
angular.module("das0140Module", ["dmsCommon", "google-maps".ns()]).config(["GoogleMapApiProvider".ns(), function(a) {
    a.configure({
        v: "3.16",
        libraries: "weather,geometry,visualization"
    })
}]).controller("DAS0140Ctrl", ["$scope", "serverService", "$rootScope", "GoogleMapApi".ns(), function(a, d, c, e) {
    a.initData = function(a, f) {
        d.doPost("/DAS0140/initData", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    a.searchData = function(a, f) {
        d.doPost("/DAS0140/searchData", a, function(a) {
            (f || angular.noop)(a)
        })
    };
    e.then(function() {});
    a.init =
        function() {
            a.model = {};
            a.model = {
                hidden: {
                    DAS0140SearchInputModel: {
                        productTypeId: null
                    },
                    no_img: getContextPath() + "/resources/img/no_img.png",
                    defaultAreaName: Messages.getMessage("DAS0140_LABEL_REGION_CHOOSE"),
                    indexSelect: null
                }
            };
            a.model.form = {
                DAS0140ParamSearch: {
                    searchInput: {
                        salesmanCode: "",
                        salesmanName: ""
                    },
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: null,
                        rowNumber: null
                    }
                },
                DAS0140InitOutputModel: null,
                DAS0140SearchResult: {
                    salesmanCheckin: null,
                    pagingInfo: {
                        ttlRow: null,
                        crtPage: null,
                        rowNumber: null
                    }
                },
                showAll: !0,
                salemanSelect: null
            };

            a.map = {
                center: {
                    latitude: 10.771918,
                    longitude: 106.698347
                },
                zoom: 15
            };
            a.randomMarkers = [];
            a.model.hidden.clientId = angular.element("#clientId").val();
            param = {
                clientId: null
            };
            a.initData(param, function(b) {
                a.model.form.DAS0140InitOutputModel = b;
                a.model.hidden.DAS0140SearchInputModel.clientId = a.model.form.DAS0140InitOutputModel.initData.defaultClientId;
                a.search();
            })
        };
    a.setSelected = function(item) {
        a.showLocation(item);
    };
    a.changeData = function() {
        param = {
            clientId: a.model.hidden.DAS0140SearchInputModel.clientId
        };
        a.initData(param, function(b) {
            a.model.form.DAS0140InitOutputModel = b;
            a.model.hidden.DAS0140SearchInputModel.clientId = a.model.form.DAS0140InitOutputModel.initData.defaultClientId
        })
    };
    a.chooseArea = function(b, f) {
        a.model.hidden.defaultAreaName =
            b;
        a.model.hidden.DAS0140SearchInputModel.areaId = f
    };
    a.search = function() {
        var param = {
            searchInput: {
                productTypeId: a.model.hidden.DAS0140SearchInputModel.productTypeId,
                salesmanCode: a.model.form.DAS0140ParamSearch.searchInput.salesmanCode,
                salesmanName: a.model.form.DAS0140ParamSearch.searchInput.salesmanName
            }
        };
        a.searchData(param, function(b) {
            a.randomMarkers = [];
            a.model.hidden.indexSelect = null;
            a.model.form.DAS0140SearchResult = b;
            if (null != a.model.form.DAS0140SearchResult) {
                if (null != a.model.form.DAS0140SearchResult.salesmanCheckin)
                    for (b = 0; b < a.model.form.DAS0140SearchResult.salesmanCheckin.length; b++) {
                        var f =
                            a.model.form.DAS0140SearchResult.salesmanCheckin[b];
                        f.imagePathCheckInUrl = getContextPath() + f.imagePathCheckIn;
                        f.imagePathCheckOutUrl = getContextPath() + f.imagePathCheckOut
                    }
                a.model.hidden.indexSelect = 0;
                a.model.form.salemanSelect = a.model.form.DAS0140SearchResult.salesmanCheckin[0];
                a.showAll()
            }
        })
    };

    a.redirectPage = function() {
        var param = {
            searchInput: {
                productTypeId: a.model.hidden.DAS0140SearchInputModel.productTypeId,
                salesmanCode: a.model.form.DAS0140ParamSearch.searchInput.salesmanCode,
                salesmanName: a.model.form.DAS0140ParamSearch.searchInput.salesmanName
            },
            pagingInfo: {
                ttlRow: null != a.model.form.DAS0140SearchResult.pagingInfo ? a.model.form.DAS0140SearchResult.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.DAS0140SearchResult.pagingInfo ? a.model.form.DAS0140SearchResult.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.DAS0140SearchResult.pagingInfo ? a.model.form.DAS0140SearchResult.pagingInfo.rowNumber : null
            }
        };
        a.searchData(param, function(b) {
            a.randomMarkers = [];
            a.model.hidden.indexSelect = null;
            a.model.form.DAS0140SearchResult = b;
            if (null != a.model.form.DAS0140SearchResult) {
                if (null != a.model.form.DAS0140SearchResult.salesmanCheckin)
                    for (b = 0; b < a.model.form.DAS0140SearchResult.salesmanCheckin.length; b++) {
                        var f =
                            a.model.form.DAS0140SearchResult.salesmanCheckin[b];
                        f.imagePathCheckInUrl = getContextPath() + f.imagePathCheckIn;
                        f.imagePathCheckOutUrl = getContextPath() + f.imagePathCheckOut
                    }
                a.model.hidden.indexSelect = 0;
                a.model.form.salemanSelect = a.model.form.DAS0140SearchResult.salesmanCheckin[0];
                a.showAll()
            }
        })
    };

    a.prevPageDAS0140 = function() {
        a.model.form.DAS0140SearchResult.pagingInfo.crtPage -= 1;
        a.redirectPage()
    };
    a.nextPageDAS0140 =
        function() {
            a.model.form.DAS0140SearchResult.pagingInfo.crtPage += 1;
            a.redirectPage()
        };
    a.startPageDAS0140 = function() {
        a.model.form.DAS0140SearchResult.pagingInfo.crtPage = 1;
        a.redirectPage()
    };
    a.endPageDAS0140 = function() {
        a.model.form.DAS0140SearchResult.pagingInfo.crtPage = a.model.form.DAS0140SearchResult.pagingInfo.ttlPages;
        a.redirectPage()
    };

    a.checkshowMapPosition = function(b) {
        if (null != b && 0 < b.length) {
            a.randomMarkers = [];
            a.map = {
                center: {
                    latitude: b[0].latVal,
                    longitude: b[0].longVal
                },
                zoom: 15
            };
            for (var f = 0; f < b.length; f++) {
                var c =
                    "";
                null != b[f].imagePathCheckIn ? c = "(check-in: " + b[f].checkInDate + ")" : null != b[f].imagePathCheckout && (c = "(check-out: " + b[f].checkOutDate + ")");
                a.randomMarkers.push({
                    latitude: b[f].latVal,
                    longitude: b[f].longVal,
                    storeName: b[f].storeName,
                    popupInfo: b[f].salesmanName + c,
                    idKey: b[f].salesmanCode + "-" + f
                })
            }
            a.randomMarkers.forEach(function(b) {
                b.onClicked = function() {
                    a.onMarkerClicked(b)
                };
                b.closeClick = function() {
                    b.showWindow = !1;
                    a.$apply()
                }
            })
        }
    };
    a.onMarkerClicked = function(b) {
        markerToClose = b;
        b.showWindow = !0;
        a.$apply()
    };
    a.chooseSaleman = function(b, f) {
        a.model.form.salemanSelect = b;
        a.model.hidden.indexSelect = f;
        !1 == a.model.form.showAll ? a.showPositionSelectSale() : a.map = {
            center: {
                latitude: a.model.form.salemanSelect.latVal,
                longitude: a.model.form.salemanSelect.longVal
            },
            zoom: 15
        }
    };
    a.showAll = function() {
        !0 == a.model.form.showAll && a.showPositionAllSale();
        !1 == a.model.form.showAll && a.showPositionSelectSale()
    };
    a.showPositionAllSale = function() {
        null != a.model.form.DAS0140SearchResult && a.checkshowMapPosition(a.model.form.DAS0140SearchResult.salesmanCheckin)
    };
    a.showPositionSelectSale = function() {
        var b = [];
        null != a.model.form.salemanSelect && b.push(a.model.form.salemanSelect);
        0 < b.length && a.checkshowMapPosition(b)
    }

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

    a.showLocation = function(item) {
        a.map = {
            center: {
                latitude: item.latVal,
                longitude: item.longVal
            },
            zoom: 15
        };
    };
}]);
angular.module("das0150Module", ["dmsCommon", "ui.calendar"]).controller("DAS0150Ctrl", ["$scope", "serverService", "$rootScope", "uiCalendarConfig", function(a, d, c, e) {
    a.initData = function(a, e) {
        d.doPost("/DAS0150/initData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.selectScheduleData = function(a, e) {
        d.doPost("/DAS0150/searchData", a, function(a) {
            (e || angular.noop)(a)
        })
    };
    a.init = function() {
        a.model = {};
        a.model.form = {
            DAS0150InitOutputModel: null,
            DAS0150SearchInputModel: {
                productTypeId: null,
                startDate: null,
                endDate: null,
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: null,
                    rowNumber: 0
                }
            }
        };
        a.initData({}, function(c) {
            a.model.form.DAS0150InitOutputModel = c;
        })
    };
    a.prevPage = function() {
        a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage -= 1;
        a.searchData()
    };
    a.nextPage = function() {
        a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage += 1;
        a.searchData()
    };
    a.startPage = function() {
        a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage = 1;
        a.searchData()
    };
    a.endPage = function() {
        a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage =
            a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlPages;
        a.searchData()
    };
    a.searchData = function() {
        a.selectScheduleData({
            productTypeId: a.model.form.DAS0150SearchInputModel.productTypeId,
            startDate: a.model.form.DAS0150SearchInputModel.startDate,
            endDate: a.model.form.DAS0150SearchInputModel.endDate,
            pagingInfo: {
                ttlRow: null != a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo ? a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo ?
                    a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.crtPage : null,
                rowNumber: null != a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo ? a.model.form.DAS0150InitOutputModel.scheduleInfo.pagingInfo.rowNumber : null
            }
        }, function(c) {
            a.model.form.DAS0150InitOutputModel.scheduleInfo = c.scheduleInfo
        })
    };
}]);