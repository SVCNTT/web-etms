//fgnass.github.com/spin.js#v2.1.0
! function(a, b) {
    "object" == typeof exports ? module.exports = b() : "function" == typeof define && define.amd ? define(b) : a.Spinner = b()
}(this, function() {
    "use strict";

    function a(a, b) {
        var c, d = document.createElement(a || "div");
        for (c in b) d[c] = b[c];
        return d
    }

    function b(a) {
        for (var b = 1, c = arguments.length; c > b; b++) a.appendChild(arguments[b]);
        return a
    }

    function c(a, b, c, d) {
        var e = ["opacity", b, ~~(100 * a), c, d].join("-"),
            f = .01 + c / d * 100,
            g = Math.max(1 - (1 - a) / b * (100 - f), a),
            h = j.substring(0, j.indexOf("Animation")).toLowerCase(),
            i = h && "-" + h + "-" || "";
        return m[e] || (k.insertRule("@" + i + "keyframes " + e + "{0%{opacity:" + g + "}" + f + "%{opacity:" + a + "}" + (f + .01) + "%{opacity:1}" + (f + b) % 100 + "%{opacity:" + a + "}100%{opacity:" + g + "}}", k.cssRules.length), m[e] = 1), e
    }

    function d(a, b) {
        var c, d, e = a.style;
        for (b = b.charAt(0).toUpperCase() + b.slice(1), d = 0; d < l.length; d++)
            if (c = l[d] + b, void 0 !== e[c]) return c;
        return void 0 !== e[b] ? b : void 0
    }

    function e(a, b) {
        for (var c in b) a.style[d(a, c) || c] = b[c];
        return a
    }

    function f(a) {
        for (var b = 1; b < arguments.length; b++) {
            var c = arguments[b];
            for (var d in c) void 0 === a[d] && (a[d] = c[d])
        }
        return a
    }

    function g(a, b) {
        return "string" == typeof a ? a : a[b % a.length]
    }

    function h(a) {
        this.opts = f(a || {}, h.defaults, n)
    }

    function i() {
        function c(b, c) {
            return a("<" + b + ' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">', c)
        }
        k.addRule(".spin-vml", "behavior:url(#default#VML)"), h.prototype.lines = function(a, d) {
            function f() {
                return e(c("group", {
                    coordsize: k + " " + k,
                    coordorigin: -j + " " + -j
                }), {
                    width: k,
                    height: k
                })
            }

            function h(a, h, i) {
                b(m, b(e(f(), {
                    rotation: 360 / d.lines * a + "deg",
                    left: ~~h
                }), b(e(c("roundrect", {
                    arcsize: d.corners
                }), {
                    width: j,
                    height: d.scale * d.width,
                    left: d.scale * d.radius,
                    top: -d.scale * d.width >> 1,
                    filter: i
                }), c("fill", {
                    color: g(d.color, a),
                    opacity: d.opacity
                }), c("stroke", {
                    opacity: 0
                }))))
            }
            var i, j = d.scale * (d.length + d.width),
                k = 2 * d.scale * j,
                l = -(d.width + d.length) * d.scale * 2 + "px",
                m = e(f(), {
                    position: "absolute",
                    top: l,
                    left: l
                });
            if (d.shadow)
                for (i = 1; i <= d.lines; i++) h(i, -2, "progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");
            for (i = 1; i <= d.lines; i++) h(i);
            return b(a, m)
        }, h.prototype.opacity = function(a, b, c, d) {
            var e = a.firstChild;
            d = d.shadow && d.lines || 0, e && b + d < e.childNodes.length && (e = e.childNodes[b + d], e = e && e.firstChild, e = e && e.firstChild, e && (e.opacity = c))
        }
    }
    var j, k, l = ["webkit", "Moz", "ms", "O"],
        m = {},
        n = {
            lines: 12,
            length: 7,
            width: 5,
            radius: 10,
            scale: 1,
            rotate: 0,
            corners: 1,
            color: "#000",
            direction: 1,
            speed: 1,
            trail: 100,
            opacity: .25,
            fps: 20,
            zIndex: 2e9,
            className: "spinner",
            top: "50%",
            left: "50%",
            position: "absolute"
        };
    if (h.defaults = {}, f(h.prototype, {
            spin: function(b) {
                this.stop();
                var c = this,
                    d = c.opts,
                    f = c.el = e(a(0, {
                        className: d.className
                    }), {
                        position: d.position,
                        width: 0,
                        zIndex: d.zIndex
                    });
                if (e(f, {
                        left: d.left,
                        top: d.top
                    }), b && b.insertBefore(f, b.firstChild || null), f.setAttribute("role", "progressbar"), c.lines(f, c.opts), !j) {
                    var g, h = 0,
                        i = (d.lines - 1) * (1 - d.direction) / 2,
                        k = d.fps,
                        l = k / d.speed,
                        m = (1 - d.opacity) / (l * d.trail / 100),
                        n = l / d.lines;
                    ! function o() {
                        h++;
                        for (var a = 0; a < d.lines; a++) g = Math.max(1 - (h + (d.lines - a) * n) % l * m, d.opacity), c.opacity(f, a * d.direction + i, g, d);
                        c.timeout = c.el && setTimeout(o, ~~(1e3 / k))
                    }()
                }
                return c
            },
            stop: function() {
                var a = this.el;
                return a && (clearTimeout(this.timeout), a.parentNode && a.parentNode.removeChild(a), this.el = void 0), this
            },
            lines: function(d, f) {
                function h(b, c) {
                    return e(a(), {
                        position: "absolute",
                        width: f.scale * (f.length + f.width) + "px",
                        height: f.scale * f.width + "px",
                        background: b,
                        boxShadow: c,
                        transformOrigin: "left",
                        transform: "rotate(" + ~~(360 / f.lines * k + f.rotate) + "deg) translate(" + f.scale * f.radius + "px,0)",
                        borderRadius: (f.corners * f.scale * f.width >> 1) + "px"
                    })
                }
                for (var i, k = 0, l = (f.lines - 1) * (1 - f.direction) / 2; k < f.lines; k++) i = e(a(), {
                    position: "absolute",
                    top: 1 + ~(f.scale * f.width / 2) + "px",
                    transform: f.hwaccel ? "translate3d(0,0,0)" : "",
                    opacity: f.opacity,
                    animation: j && c(f.opacity, f.trail, l + k * f.direction, f.lines) + " " + 1 / f.speed + "s linear infinite"
                }), f.shadow && b(i, e(h("#000", "0 0 4px #000"), {
                    top: "2px"
                })), b(d, b(i, h(g(f.color, k), "0 0 1px rgba(0,0,0,.1)")));
                return d
            },
            opacity: function(a, b, c) {
                b < a.childNodes.length && (a.childNodes[b].style.opacity = c)
            }
        }), "undefined" != typeof document) {
        k = function() {
            var c = a("style", {
                type: "text/css"
            });
            return b(document.getElementsByTagName("head")[0], c), c.sheet || c.styleSheet
        }();
        var o = e(a("group"), {
            behavior: "url(#default#VML)"
        });
        !d(o, "transform") && o.adj ? i() : j = d(o, "animation")
    }
    return h
});

! function(a) {
    "use strict";

    function b(a, b) {
        a.module("angularSpinner", []).factory("usSpinnerService", ["$rootScope", function(a) {
            var b = {};
            return b.spin = function(b) {
                a.$broadcast("us-spinner:spin", b)
            }, b.stop = function(b) {
                a.$broadcast("us-spinner:stop", b)
            }, b
        }]).directive("usSpinner", ["$window", function(c) {
            return {
                scope: !0,
                link: function(d, e, f) {
                    function g() {
                        d.spinner && d.spinner.stop()
                    }
                    var h = b || c.Spinner;
                    d.spinner = null, d.key = a.isDefined(f.spinnerKey) ? f.spinnerKey : !1, d.startActive = a.isDefined(f.spinnerStartActive) ? f.spinnerStartActive : d.key ? !1 : !0, d.spin = function() {
                        d.spinner && d.spinner.spin(e[0])
                    }, d.stop = function() {
                        d.startActive = !1, g()
                    }, d.$watch(f.usSpinner, function(a) {
                        g(), d.spinner = new h(a), (!d.key || d.startActive) && d.spinner.spin(e[0])
                    }, !0), d.$on("us-spinner:spin", function(a, b) {
                        b === d.key && d.spin()
                    }), d.$on("us-spinner:stop", function(a, b) {
                        b === d.key && d.stop()
                    }), d.$on("$destroy", function() {
                        d.stop(), d.spinner = null
                    })
                }
            }
        }])
    }
    "function" == typeof define && define.amd ? define(["angular", "spin"], b) : b(a.angular)
}(window);

(function(){
    angular.module('ngLoadingSpinner', ['angularSpinner'])
    .directive('usSpinner',   ['$http', '$rootScope' ,function ($http, $rootScope){
        return {
            link: function (scope, elm, attrs)
            {
                $rootScope.spinnerActive = false;
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (loading)
                {
                    $rootScope.spinnerActive = loading;
                    if(loading){
                        elm.removeClass('ng-hide');
                    }else{
                        elm.addClass('ng-hide');
                    }
                });
            }
        };

    }]);
}).call(this);

var coa0200Module = angular.module("coa0200Module", ["dmsCommon","coa0220Module", "toaster", "ngLoadingSpinner"]).controller("COA0200Ctrl", ["$scope", "$http", "$filter", "serverService", "toaster", function(a, d, c, e, f) {
    a.init = function() {
        a.model = {
    		hidden: {
                showCOA0220: !1
            }
        };
        a.model.form = {
        	chooseAll: !1,
            COA0200InitDataOutputModel: null,
            CAO0200InitDataModel:null,
            COA0200CreateCoachingInputModel: {
            	coachingName: "",
            	coachingStartday: "",
            	coachingEndday: "",
            	coachingCode:"",
            	coachingTemplateId:0
            },
            COA0200CreateCoachingResultDto: null,
            COA0200CreateCoachingSectionResultDto:null,
            COA0330ResultSearchNotAssignModel: {
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
            COA0330ResultSearchUserAssignModel: {
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
            COA0330SearchDataUserNotAssign: {
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
            COA0330SearchDataUserAssign: {
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
            listSelectUser: []
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                coachingName: {
                    isErrored: !1,
                    msg: ""
                },
                coachingStartday: {
                    isErrored: !1,
                    msg: ""
                },
                coachingEndday: {
                    isErrored: !1,
                    msg: ""
                }
            }
        };
        a.$on("COA0200#showCOA0220", function(b, c) {
            a.model.hidden.showCOA0220 = c.showCOA0220
        });
        a.$on("COA0200#reloadSection", function() {
        	a.getQuestion();
        })
        
    };
    a.searchType = function(){
    	a.searchUserNotAssign();
    }
    a.countStep = 1;
    a.chooseAll = function() {
        if (null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo)
            if (!1 == a.model.form.chooseAll)
                for (var b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) {
                    var c = a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b];
                    c.choose = !1;
                    for (var e = 0; e < a.model.form.listSelectUser.length; e++) a.model.form.listSelectUser[e] ==
                        c.userId && a.model.form.listSelectUser.splice(e, 1)
                } else
                    for (b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) c = a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b], c.choose = !0, a.model.form.listSelectUser.push(c.userId)
    };
    a.checkChooseAll = function() {
        if (0 < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length) {
            a.model.form.chooseAll = !0;
            for (var b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++)
                if (!1 ==
                    a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b].choose) {
                    a.model.form.chooseAll = !1;
                    break
                }
        }
    };
    a.finish = function(){
    	window.location.href = getContextPath() + "/COA0100";
    };
    a.addUser = function() {
        a.addUserData({
        	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
            userIdList: a.model.form.listSelectUser
        }, function(b) {
//        
        	null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
        	 a.searchDataUserNotAssignOnly();
        	 a.searchDataUserAssignOnly();
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
    a.addUserData = function(a, c) {
        e.doPost("/COA0330/assignUserCoaching", a, function(a) {
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
            	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserNotAssign.searchInput.userName,
                userCode: a.model.form.COA0330SearchDataUserNotAssign.searchInput.userCode

            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo ? a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0330/searchUserNotAssign", param, function(b) {
            a.model.form.COA0330ResultSearchNotAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
    
    a.checkChooseAllAfterSearch = function() {
//         if (null != a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo) {
//             for (var b = 0; b < a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo.length; b++) {
//                 var f = a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.userInfo[b];
//                 f.choose = !1;
//                 for (var c = 0; c < a.model.form.listSelectUser.length; c++)
//                     if (a.model.form.listSelectUser[c] ==
//                         f.userId) f.choose = !0
//             }
//             a.checkChooseAll()
//         }
    	a.model.form.listSelectUser = [];
        a.model.form.chooseAll = 1;
    };
/**
 * Start not assign
 */

    a.prevPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage -= 1;
        a.searchDataUserNotAssignOnly()
    };
    a.nextPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage += 1;
        a.searchDataUserNotAssignOnly()
    };
    a.startPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage = 1;
        a.searchDataUserNotAssignOnly()
    };
    a.endPageUserNotAssign = function() {
        a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchNotAssignModel.resultUserNotAssign.pagingInfo.ttlPages;
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
            	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserAssign.searchInput.userName,
                userCode: a.model.form.COA0330SearchDataUserAssign.searchInput.userCode

            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0430/searchUserAssign", param, function(b) {
            a.model.form.COA0330ResultSearchUserAssignModel = b;
        })
    };
    a.removeUser = function(b){
    	e.doPost("/COA0430/removeUserFromCoaching", {
        	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
        	userId:b.userId
    	}, function(b) {
    		null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
    		 a.searchDataUserNotAssignOnly();
        	 a.searchDataUserAssignOnly();        
    	})
    };
    a.prevPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage -= 1;
        a.searchDataUserAssignOnly()
    };
    a.nextPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage += 1;
        a.searchDataUserAssignOnly()
    };
    a.startPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage = 1;
        a.searchDataUserAssignOnly()
    };
    a.endPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages;
        a.searchDataUserAssignOnly()
    };
    
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            coachingName: {
                isErrored: !1,
                msg: ""
            },
            coachingStartday: {
                isErrored: !1,
                msg: ""
            },
            coachingEndday: {
            	isErrored: !1,
            	msg: ""
            },
            coachingMoreStartDay: {
            	isErrored: !1,
            	msg: ""
            },
            coachingMoreEndDay: {
                isErrored: !1,
                msg: ""
            }
        };
        
        	
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingName)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.coachingName.isErrored = !0, a.model.hidden.validated.coachingName.msg = Messages.getMessage("E0000004", "COA0200_LABEL_COACHING_NAME");
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingStartday)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.coachingStartday.isErrored = !0, a.model.hidden.validated.coachingStartday.msg = Messages.getMessage("E0000004", "COA0200_LABEL_COACHING_STARTDAY");
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingEndday)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.coachingEndday.isErrored = !0, a.model.hidden.validated.coachingEndday.msg = Messages.getMessage("E0000004", "COA0200_LABEL_COACHING_ENDDAY");
      
        
        if ( ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingStartday)
        		&& ValidateUtil.isValidTextRequired(a.model.form.COA0200CreateCoachingInputModel.coachingEndday)){
        	
        	  console.log(a.model.form.COA0200CreateCoachingInputModel.coachingStartday)
              console.log(a.model.form.COA0200CreateCoachingInputModel.coachingEndday)
              
             var firstValue = a.model.form.COA0200CreateCoachingInputModel.coachingStartday.split('-');
    	  	 var secondValue = a.model.form.COA0200CreateCoachingInputModel.coachingEndday.split('-');

    	  	 var startDay = new Date(firstValue[2] + "-" + firstValue[1] + "-" + firstValue[0]).getTime();
    	  	 var endDay = new Date(secondValue[2] + "-" + secondValue[1] + "-" + secondValue[0]).getTime();
    	  	 var current = c("date")(new Date, "dd-MM-yyyy").split('-');
    	  	 var now = new Date(current[2] + "-" + current[1] + "-" + current[0]).getTime();
	        	if ((startDay < now) && $("#isEdit").val() == '0')
	            	a.model.hidden.validated.isErrored = !0, 
	            	a.model.hidden.validated.coachingMoreStartDay.isErrored = !0, 
	            	a.model.hidden.validated.coachingMoreStartDay.msg = Messages.getMessage("E0000030");
	        	
	        	if (startDay >=  endDay)
	        		a.model.hidden.validated.isErrored = !0, 
	            	a.model.hidden.validated.coachingMoreEndDay.isErrored = !0, 
	            	a.model.hidden.validated.coachingMoreEndDay.msg = Messages.getMessage("E0000031");
	        	
        }
    };
    
    a.nextCoaching = function() {
    	if (a.countStep == 1){
            a.validate();
            !0 != a.model.hidden.validated.isErrored && a.createCoachingData({
            	coachingName: a.model.form.COA0200CreateCoachingInputModel.coachingName,
            	coachingStartday: a.model.form.COA0200CreateCoachingInputModel.coachingStartday,
            	coachingEndday: a.model.form.COA0200CreateCoachingInputModel.coachingEndday,
            	coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
            })
            
    	}else{
    		$("#assign-regional-manager").show();
    		$("#coaching_template_question").hide();
    		
    		$("#next-coaching").hide();
        	$("#next-assign").hide();

    		$("#finish_coaching").show();
    		a.countStep++;
    		a.searchDataUserNotAssignOnly();
    		a.searchDataUserAssignOnly();
    	}
    };
    a.createCoachingData = function(b) {
        e.doPost("/COA0200/regisCoaching", b, function(b) {
        	a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId = b.coachingTemplateId;
        	 a.getQuestion();
     		$("#coaching_template").hide();
        	$("#coaching_template_question").show();
        	$("#back_coaching").show();
        	
        	$("#next-coaching").hide();
        	$("#next-assign").show();
        	a.countStep++;

        })
    };
    a.deleteSectionData = function(param) {
        e.doPost("/COA0200/deleteSection", param, function(b) {
            null != b.proResult && ("NG" == b.proResult.proFlg ? f.pop("error", b.proResult.message,
                    null, "trustedHtml") : f.pop("success", b.proResult.message, null, "trustedHtml"))
                a.getQuestion();
                    
        })
    };
	a.backStore = function(){
    	if (a.countStep == 2){
    		$("#coaching_template").show();
        	$("#coaching_template_question").hide();
        	$("#back_coaching").hide();
    		$("#next-coaching").show();
        	$("#next-assign").hide();

        	a.countStep--;
    	}
    	if (a.countStep == 3){
    		$("#coaching_template").hide();
        	$("#assign-regional-manager").hide();
        	$("#finish_coaching").hide();
        	
        	$("#coaching_template_question").show();
        	$("#back_coaching").show();
    		$("#next-coaching").hide();
        	$("#next-assign").show();


        	a.countStep--;
    	}
    	
	};
    a.addQuestions = function() {
        a.model.hidden.showCOA0220 = !0;
    }
    
    a.editQuestions = function(b){
    	angular.element("#coachingTemplateSectionId").val(b.coaching_template_section_id); 
    	a.model.hidden.showCOA0220 = !0;
    };
     
    a.getQuestion = function(){
    	a.getQuestionData({
    		coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
        });
    };
    a.deleteSection = function(b){
    	a.deleteSectionData({
    		coachingTemplateSectionId:b.coaching_template_section_id
        })
    };
    
    a.getQuestionData = function(param) {
        e.doPost("/COA0200/coachingSection", param, function(b) {
        	a.model.form.COA0200CreateCoachingSectionResultDto = b
       	 	a.model.form.listSelectUser = a.model.form.COA0200CreateCoachingSectionResultDto.listSelectUser;

        })
    };
    
    
}]);
var coa0220Module = angular.module("coa0220Module", ["dmsCommon", "fcsa-number", "toaster"]).controller("COA0220Ctrl", ["$scope", "serverService", "$rootScope", "toaster", function(a, d, c, e) {
    a.createQuestionData = function(a, c) {
        d.doPost("/COA0220/saveQuestion", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.initData = function() {
        d.doPost("/COA0220/initData", {coachingTemplateSectionId: angular.element("#coachingTemplateSectionId").val()}, function(b) {
            a.model.form.CAO0200InitDataModel = b;
            a.model.form.COA0220CreateQuestionInputModel = b.initData.inforSection

        })
    };
    
    a.count = 0;
    a.init = function() {
        a.model = {
            hidden: {
            	showCOA0220:  !1,
            	coachingTemplateId:"",
                validated: {
                    isErrored: !1,
                    questionType: {
                        isErrored: !1,
                        msg: ""
                    },
                    questionTitle: {
                        isErrored: !1,
                        msg: ""
                    }
                },
                needToCalculate:1
            }
        };
        a.model.form = {
            CAO0200InitDataModel: null,
            COA0220CreateQuestionInputModel: {
                questionType: null,
                questionTitle:"",
                optionValues:[],
                needToCalculate:1
            },
        	COA0220CreateQuestionResult:null,
        	coachingTemplateSectionId:""
        };
        a.model.hidden.coachingTemplateId = angular.element("#coachingTemplateId").val();
        a.initData();
        
    };
    a.validate = function() {
        a.model.hidden.validated = {
            isErrored: !1,
            questionType: {
                isErrored: !1,
                msg: ""
            },
            questionTitle: {
                isErrored: !1,
                msg: ""
            },
            optionValues: {
                isErrored: !1,
                msg: ""
            }
        };
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0220CreateQuestionInputModel.questionTitle)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.questionTitle.isErrored = !0, a.model.hidden.validated.questionTitle.msg = Messages.getMessage("E0000004", "COA0200_LABEL_QUESTION_TITLE");
        if (a.model.form.COA0220CreateQuestionInputModel.optionValues.length <= 0 || a.model.form.COA0220CreateQuestionInputModel.optionValues[0]["sectionItemTitle"] == "") 
        	a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.optionValues.isErrored = !0, 
        	a.model.hidden.validated.optionValues.msg = Messages.getMessage("E0000004", "COA0200_LABEL_QUESTION_NOTE");
        if (!ValidateUtil.isValidTextRequired(a.model.form.COA0220CreateQuestionInputModel.questionType)) a.model.hidden.validated.isErrored = !0, a.model.hidden.validated.questionType.isErrored = !0, a.model.hidden.validated.questionType.msg = Messages.getMessage("E0000004", "COA0200_LABEL_QUESTION_TYPE");
    };
    a.closeEdit = function() {
        a.model.hidden.showCOA0220 = !1;
        c.$broadcast("COA0200#showCOA0220", {
            showCOA0220: a.model.hidden.showCOA0220
        })
        angular.element("#coachingTemplateSectionId").val("")
    };
    a.addItem = function(){
    	a.model.form.COA0220CreateQuestionInputModel.optionValues.push({"sectionItemTitle":""})
    	setTimeout(function(){ 
    		$("#space-for-buttons :input[type='text']").each(function(){
        		if ($(this).val() == ""){
        			$(this).focus();
        		}
        	});
    	}, 100);

    	
    	
    };
    a.removeItem = function($event) {
    	var parent = $($event.target).parent();
    	if (parent.attr("id") != "") {
	    	for (var c = 0; c < a.model.form.COA0220CreateQuestionInputModel.optionValues.length; c++)
		        if (a.model.form.COA0220CreateQuestionInputModel.optionValues[c] != undefined && 
		        		a.model.form.COA0220CreateQuestionInputModel.optionValues[c].coachingTemplateSectionItemId == parent.attr("id")) {
		        	a.model.form.COA0220CreateQuestionInputModel.optionValues.splice(c, 1);
		            break
		        }
    	}else{
    		$(parent).find('input[type=text]').each(function() {
		    	for (var c = 0; c < a.model.form.COA0220CreateQuestionInputModel.optionValues.length; c++)
			        if (a.model.form.COA0220CreateQuestionInputModel.optionValues[c] != undefined && 
			        		a.model.form.COA0220CreateQuestionInputModel.optionValues[c].sectionItemTitle == $(this).val() ) {
			        	a.model.form.COA0220CreateQuestionInputModel.optionValues.splice(c, 1);
			            break
			        }
    		})
    	}
    };
    a.createQuestion = function() {
        a.validate();
        !0 != a.model.hidden.validated.isErrored && (param = {
    		coachingTemplateId: a.model.hidden.coachingTemplateId,
    		coachingTemplateSectionId: angular.element("#coachingTemplateSectionId").val(),
        	questionTitle: a.model.form.COA0220CreateQuestionInputModel.questionTitle,
            questionType: a.model.form.COA0220CreateQuestionInputModel.questionType,
            optionValues: a.model.form.COA0220CreateQuestionInputModel.optionValues,
            needToCalculate: a.model.form.COA0220CreateQuestionInputModel.needToCalculate == true ? 1 : 0
        }, a.createQuestionData(param, function(b) {
            a.model.form.COA0220CreateQuestionResult = b;
            null != a.model.form.COA0220CreateQuestionResult.proResult && ("NG" == a.model.form.COA0220CreateQuestionResult.proResult.proFlg ? e.pop("error", a.model.form.COA0220CreateQuestionResult.proResult.message,
                    null, "trustedHtml") : e.pop("success", a.model.form.COA0220CreateQuestionResult.proResult.message, null, "trustedHtml"))
            a.closeEdit();
            c.$broadcast("COA0200#reloadSection");
        }))
    };
}]);
coa0220Module.directive("addbuttonsbutton", function(){
	return {
		restrict: "E",
		template: '<a href="" addbuttons>Add "Other"</a>'
	}
});

//Directive for adding buttons on click that show an alert on click
coa0220Module.directive("addbuttons", function($compile){
	return function(scope, element, attrs){
		element.bind("click", function(){
			scope.count++; 
			var template = '<div class="answer-main" >' +
            '<span></span>' +
            '<input type="checkbox" class="checkbox-answer"  disabled="disabled"/>' +
            '<input type="text" ng-model="model.form.COA0220CreateQuestionInputModel.optionValues['+scope.count+'].sectionItemTitle"' +
                'class="form-control-dms width200"> <span style="min-width: 15px ! important;"  ng-click="removeItem($event)"  class="delete-store pull-right icon-close  delete-input" ></span>' +
            '</div>';
			angular.element(document.getElementById('space-for-buttons')).append($compile(template)(scope));
		});
	};
});

coa0200Module.directive('myOnChange', function () { 
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

var coa0400Module = angular.module("coa0400Module", ["dmsCommon","toaster", "ngLoadingSpinner"]).controller("COA0400Ctrl", ["$scope", "$http", "$filter", "serverService", "toaster", function(a, d, c, e, f) {
    a.init = function() {
        a.model = {
    		hidden: {
                showCOA0220: !1
            }
        };
        a.model.form = {
        	chooseAll: !1,
            COA0200InitDataOutputModel: null,
            CAO0200InitDataModel:null,
            COA0200CreateCoachingInputModel: {
            	coachingName: "",
            	coachingStartday: "",
            	coachingEndday: "",
            	coachingCode:"",
            	coachingTemplateId:0
            },
            COA0200CreateCoachingResultDto: null,
            COA0200CreateCoachingSectionResult:null,
            COA0200CreateCoachingSectionResultDto:null,
            COA0330ResultSearchUserAssignModel: {
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
            COA0330ResultSearchUserMarkModel: {
            	resultUserMark: {
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
            COA0330SearchDataUserAssign: {
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
            COA0330SearchDataUserMark: {
                searchInput: {
                	userName:"",
                	userCode:"",
                	userId:0
                },
                pagingInfo: {
                    ttlRow: 0,
                    crtPage: 1,
                    rowNumber: 0
                }
            },
            listSelectUser: []
        };
        a.model.hidden = {
            validated: {
                isErrored: !1,
                coachingName: {
                    isErrored: !1,
                    msg: ""
                },
                coachingStartday: {
                    isErrored: !1,
                    msg: ""
                },
                coachingEndday: {
                    isErrored: !1,
                    msg: ""
                }
            }
        };
    	a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId = $('#coachingTemplateIdFirsLoad').val()
        a.searchType(); 
    };
    a.searchType = function(){
    	a.searchUserAssign();
    }
    a.searchUserMark = function(){
    	a.searchUserAssign();
    }
    a.countStep = 1;
   
    a.viewListCoaching = function() {
    	window.location.href = getContextPath() + "/COA0100";
    };
    
    a.viewAnswer = function(b){
    	 a.viewAnswerData({
         	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
             userId: b.userId,
             coachingSalesmanId : b.coachingSalesmanId
         }, function(b) {
         	a.model.form.COA0200CreateCoachingSectionResult = b
         })
    };
    
    a.viewAnswerData = function(a, c) {
    	$("#coaching_template_answer").show();
    	$("#assign-regional-manager").hide();
    	$("#assign-regional-mark-user").hide();
		
        e.doPost("/COA0440/viewAnswerData", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.backListManger = function() {
		$("#assign-regional-mark-user").hide();
		$("#assign-regional-manager").show();
    };
    a.backListUser = function() {
		$("#assign-regional-mark-user").show();
		$("#assign-regional-manager").hide();
    	$("#coaching_template_answer").hide();

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
    a.addUserData = function(a, c) {
        e.doPost("/COA0330/assignUserCoaching", a, function(a) {
            (c || angular.noop)(a)
        })
    };
    a.checkChooseAllAfterSearch = function() {
         a.model.form.listSelectUser = [];
         a.model.form.chooseAll = 1;
    };
    
    a.searchUserAssign = function() {
        a.searchDataUserAssignOnly()
    };
    a.searchDataUserAssignOnly = function() {
        param = {
            searchInput: {
            	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserAssign.searchInput.userName,
                userCode: a.model.form.COA0330SearchDataUserAssign.searchInput.userCode
            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo ? a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0430/searchUserAssign", param, function(b) {
            a.model.form.COA0330ResultSearchUserAssignModel = b;
            a.checkChooseAllAfterSearch()
        })
    };
 
    a.prevPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage -= 1;
        a.searchDataUserAssignOnly()
    };
    a.nextPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage += 1;
        a.searchDataUserAssignOnly()
    };
    a.startPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage = 1;
        a.searchDataUserAssignOnly()
    };
    a.endPageUserAssign = function() {
        a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchUserAssignModel.resultUserAssign.pagingInfo.ttlPages;
        a.searchDataUserAssignOnly()
    };
    
    a.searchUserMark = function() {
        a.searchDataUserMarkOnly()
    };
    a.searchDataUserMarkOnly = function() {
        param = {
            searchInput: {
            	coachingTemplateId: a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId,
                userName: a.model.form.COA0330SearchDataUserMark.searchInput.userName,
                userId: a.model.form.COA0330SearchDataUserMark.searchInput.userId

            },
            pagingInfo: {
                ttlRow: null != a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo ? a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlRow : null,
                crtPage: null != a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo ? a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage : 1,
                rowNumber: null != a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo ? a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.rowNumber : null
            }
        };
        e.doPost("/COA0430/searchUserMark", param, function(b) {
            a.model.form.COA0330ResultSearchUserMarkModel = b;
        })
    };
    
    a.viewUserMark = function(b){
    	a.model.form.COA0330SearchDataUserMark.searchInput.userId = b.userId
    	$("#assign-regional-mark-user").show();
		$("#assign-regional-manager").hide();
		
    	a.searchDataUserMarkOnly();
    }
    
    a.prevPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage -= 1;
        a.searchDataUserMarkOnly()
    };
    a.nextPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage += 1;
        a.searchDataUserMarkOnly()
    };
    a.startPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage = 1;
        a.searchDataUserMarkOnly()
    };
    a.endPageUserMark = function() {
        a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.crtPage =
            a.model.form.COA0330ResultSearchUserMarkModel.resultUserMark.pagingInfo.ttlPages;
        a.searchDataUserMarkOnly()
    };
    
    a.nextCoaching = function() {
    	if (a.countStep == 1){
    		$("#coaching_template").hide();
        	$("#coaching_template_question").show();
        	$("#back_coaching").show();
        	$("#next-coaching").hide();
        	$("#next-assign").show();
        	a.createCoachingData({
            	coachingName: a.model.form.COA0200CreateCoachingInputModel.coachingName,
            	coachingStartday: a.model.form.COA0200CreateCoachingInputModel.coachingStartday,
            	coachingEndday: a.model.form.COA0200CreateCoachingInputModel.coachingEndday,
            	coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
            })
            a.countStep++;
    	}else{
    		$("#coaching_template_question").hide();
    		$("#next-coaching").hide();
        	$("#next-assign").hide();
    		a.countStep++;
    		a.searchDataUserAssignOnly();
    	}
    	
		$("#finish_coaching").show();
    	$("#coaching_template_answer").hide();
    	$("#assign-regional-mark-user").hide();
    	$("#assign-regional-manager").hide();

    };
    a.createCoachingData = function(b) {
        e.doPost("/COA0200/regisCoaching", b, function(b) {
        	a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId = b.coachingTemplateId;
        	 a.getQuestion();
        })
    };
	a.backStore = function(){
		$("#coaching_template_answer").hide();
		$("#assign-regional-mark-user").hide();
		$("#assign-regional-manager").show();
		$("#coaching_template_question").show();
		$("#finish_coaching").hide();

    	if (a.countStep == 2){
    		$("#coaching_template").show();
        	$("#coaching_template_question").hide();
        	$("#back_coaching").hide();
    		$("#next-coaching").show();
        	$("#next-assign").hide();
        	a.countStep--;
    	}
    	if (a.countStep == 3){
    		$("#coaching_template").hide();
        	$("#assign-regional-manager").hide();
        	$("#finish_coaching").hide();
        	
        	$("#coaching_template_question").show();
        	$("#back_coaching").show();
    		$("#next-coaching").hide();
        	$("#next-assign").show();
        	a.countStep--;
    	}
    	
	};
    a.addQuestions = function() {
        a.model.hidden.showCOA0220 = !0;
    }
    
    a.editQuestions = function(b){
    	angular.element("#coachingTemplateSectionId").val(b.coaching_template_section_id); 
    	a.model.hidden.showCOA0220 = !0;
    };
     
    a.getQuestion = function(){
    	a.getQuestionData({
    		coachingTemplateId:a.model.form.COA0200CreateCoachingInputModel.coachingTemplateId
        });
    };
    
    a.getQuestionData = function(param) {
        e.doPost("/COA0200/coachingSection", param, function(b) {
        	a.model.form.COA0200CreateCoachingSectionResultDto = b
       	 	a.model.form.listSelectUser = a.model.form.COA0200CreateCoachingSectionResultDto.listSelectUser;

        })
    };
    
    
}]);
