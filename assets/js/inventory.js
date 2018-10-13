angular.module("sto0600Module", ["dmsCommon", "sto0610Module","ngLoadingSpinner", "highcharts-ng"]).controller("STO0600Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function (a, d, c, e) {
    var dateObj = new Date();

    a.model = {
        hidden: {
            currentMonth: (dateObj.getUTCMonth() + 1) + '-' + dateObj.getUTCFullYear(),
            salesManagerId: 0,
            regionalManagerId: 0,
            zoneId: 0
        }
    };
    a.model.form = {
        STO0600InitDataModel: {
            resultSearch: {
                zoneList: [],
                productList: [],
                inventoryInfo: []
            },
            salesManager: [],
            regionalManager: [],
        },
    };
    a.init = function() {
        a.initData();
    };
    a.search = function () {
        a.searchData()
    };
    a.loadDataWhenChangeMonth = function(b){
        a.model.hidden.currentMonth = (b.getUTCMonth() + 1) + '-' + b.getUTCFullYear();
    }
    a.initData = function () {
        d.doPost("/STO0600/initData", {
            searchInput: {
                currentMonth: a.model.hidden.currentMonth,
                salesManagerId: a.model.hidden.salesManagerId,
                regionalManagerId: a.model.hidden.regionalManagerId
            }
        }, function (c) {
            a.model.form.STO0600InitDataModel.resultSearch = c.resultSearch;
            a.model.form.STO0600InitDataModel.salesManager = c.salesManager;
            a.model.form.STO0600InitDataModel.regionalManager = c.regionalManager;
            a.model.hidden.zoneId = c.resultSearch.zoneDefault;

            a.changeSaleManage();
            a.buildDataForChart();
            a.updateChart();
        })
    };
    a.searchData = function () {
        d.doPost("/STO0600/searchData", {
                searchInput: {
                    currentMonth: a.model.hidden.currentMonth,
                    salesManagerId: a.model.hidden.salesManagerId,
                    regionalManagerId: a.model.hidden.regionalManagerId
                }
            },
            function (c) {
                a.model.form.STO0600InitDataModel.resultSearch = c.resultSearch;
                a.model.hidden.zoneId = c.resultSearch.zoneDefault;

                a.buildDataForChart();
                a.updateChart();
            })
    };
    a.changeSaleManage = function () {
        d.doPost("/STO0600/loadRegionalManager", {
                searchInput: {
                    salesManagerId: a.model.hidden.salesManagerId,
                }
            },
            function (c) {
                a.model.form.STO0600InitDataModel.regionalManager = c.regionalManager;
                a.model.hidden.regionalManagerId = 0
            })
    };
    a.chartByProduct = {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Quantity'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        series: []
    };
    a.chartTotal = {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total'
        },
        xAxis: {
            categories: [
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Quantity'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        series: []
    };
    a.buildDataForChart = function() {
        //Reset chart
        a.chartTotal.series = [];
        a.chartTotal.xAxis.categories = [];

        //Set title
        a.chartTotal.title.text = "Total " + a.model.hidden.currentMonth;

        var data_sales_in = [];
        var data_sales_out = [];
        for (var key in a.model.form.STO0600InitDataModel.resultSearch.inventoryTotal) {
            data_sales_in.push(a.model.form.STO0600InitDataModel.resultSearch.inventoryTotal[key].total_in);
            data_sales_out.push(a.model.form.STO0600InitDataModel.resultSearch.inventoryTotal[key].total_out);

            a.chartTotal.xAxis.categories.push(a.model.form.STO0600InitDataModel.resultSearch.productList[key]);
        }

        a.chartTotal.series.push({
            "name": "Sales In",
            "data": data_sales_in,
            "type": "column",
            "color": "#0099cc"
        });

        a.chartTotal.series.push({
            "name": "Sales Out",
            "data": data_sales_out,
            "type": "column",
            "color": "#cc3300"
        });
    };
    a.updateChart = function () {
        // console.log(a.model.hidden.zoneId);
        var zoneSelected = a.model.hidden.zoneId;

        //Reset chart
        a.chartByProduct.series = [];
        a.chartByProduct.xAxis.categories = [];
        a.chartByProduct.title.text = a.model.hidden.currentMont;

        if (zoneSelected != 0) {
            //Set title
            a.chartByProduct.title.text = a.model.form.STO0600InitDataModel.resultSearch.zoneList[a.model.hidden.zoneId] + " " + a.model.hidden.currentMonth;

            var data_sales_in = [];
            var data_sales_out = [];
            for (var key in a.model.form.STO0600InitDataModel.resultSearch.inventoryInfo) {

                s_i = typeof a.model.form.STO0600InitDataModel.resultSearch.inventoryInfo[key][zoneSelected] === "undefined" ? 0 : a.model.form.STO0600InitDataModel.resultSearch.inventoryInfo[key][zoneSelected].sales_in;
                s_o = typeof a.model.form.STO0600InitDataModel.resultSearch.inventoryInfo[key][zoneSelected] === "undefined" ? 0 : a.model.form.STO0600InitDataModel.resultSearch.inventoryInfo[key][zoneSelected].sales_out;
                data_sales_in.push(parseInt(s_i));
                data_sales_out.push(parseInt(s_o));

                a.chartByProduct.xAxis.categories.push(a.model.form.STO0600InitDataModel.resultSearch.productList[key]);
            }

            a.chartByProduct.series.push({
                "name": "Sales In",
                "data": data_sales_in,
                "type": "column",
                "color": "#0099cc"
            });

            a.chartByProduct.series.push({
                "name": "Sales Out",
                "data": data_sales_out,
                "type": "column",
                "color": "#cc3300"
            });
        }
    };
    a.exportInventory = function() {
        window.location.href = '/STO0630/exportData/' + a.model.hidden.currentMonth;
    }
}]);
angular.module("sto0610Module", ["dmsCommon", "toaster"]).controller("STO0610Ctrl", ["$scope", "serverService", "$rootScope", "fileReader", "toaster", function (a, d, c, e, b) {
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
        angular.element("#STO0610ChooseFile").click()
    };
    a.closeImportInventory = function () {
        c.$broadcast("STO0100#closeImportInventory", {})
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
        d.uploadFile("/STO0620", a.model.form.file, f, function (f) {

            null != f.proResult.proFlg && ("NG" == f.proResult.proFlg ? b.pop("error", f.proResult.message, null, "trustedHtml") : (b.pop("success", f.proResult.message, null, "trustedHtml"), c.$broadcast("STO0100#closeImportInventory", {})))
        })
    }
}]);