angular.module("toaster",["ngAnimate"]).service("toaster",["$rootScope",function(e){this.pop=function(f,g,h,k,a,m){this.toast={type:f,title:g,body:h,timeout:k,bodyOutputType:a,clickHandler:m};e.$broadcast("toaster-newToast")};this.clear=function(){e.$broadcast("toaster-clearToasts")}}]).constant("toasterConfig",{limit:0,"tap-to-dismiss":!0,"close-button":!1,"newest-on-top":!0,"time-out":5E3,"icon-classes":{error:"toast-error",info:"toast-info",wait:"toast-wait",success:"toast-success",warning:"toast-warning"},
    "body-output-type":"","body-template":"toasterBodyTmpl.html","icon-class":"toast-info","position-class":"toast-top-right","title-class":"toast-title","message-class":"toast-message"}).directive("toasterContainer",["$compile","$timeout","$sce","toasterConfig","toaster",function(e,f,g,h,k){return{replace:!0,restrict:"EA",scope:!0,link:function(a,e,n){function b(l,b){l.timeout=f(function(){a.removeToast(l.id)},b)}var d=0,c;c=angular.extend({},h,a.$eval(n.toasterOptions));a.config={position:c["position-class"],
    title:c["title-class"],message:c["message-class"],tap:c["tap-to-dismiss"],closeButton:c["close-button"]};a.configureTimer=function(a){var d="number"==typeof a.timeout?a.timeout:c["time-out"];0<d&&b(a,d)};a.toasters=[];a.$on("toaster-newToast",function(){var b=k.toast;b.type=c["icon-classes"][b.type];b.type||(b.type=c["icon-class"]);d++;angular.extend(b,{id:d});b.bodyOutputType=b.bodyOutputType||c["body-output-type"];switch(b.bodyOutputType){case "trustedHtml":b.html=g.trustAsHtml(b.body);break;case "template":b.bodyTemplate=
    b.body||c["body-template"]}a.configureTimer(b);!0===c["newest-on-top"]?(a.toasters.unshift(b),0<c.limit&&a.toasters.length>c.limit&&a.toasters.pop()):(a.toasters.push(b),0<c.limit&&a.toasters.length>c.limit&&a.toasters.shift())});a.$on("toaster-clearToasts",function(){a.toasters.splice(0,a.toasters.length)})},controller:["$scope","$element","$attrs",function(a,e,g){a.stopTimer=function(a){a.timeout&&(f.cancel(a.timeout),a.timeout=null)};a.restartTimer=function(b){b.timeout||a.configureTimer(b)};a.removeToast=
    function(b){var d=0;for(d;d<a.toasters.length&&a.toasters[d].id!==b;d++);a.toasters.splice(d,1)};a.click=function(b){!0===a.config.tap&&(b.clickHandler&&angular.isFunction(a.$parent.$eval(b.clickHandler))?!0===a.$parent.$eval(b.clickHandler)(b)&&a.removeToast(b.id):(angular.isString(b.clickHandler)&&console.log("TOAST-NOTE: Your click handler is not inside a parent scope of toaster-container."),a.removeToast(b.id)))}}],template:'<div  id="toast-container" ng-class="config.position"><div ng-repeat="toaster in toasters" class="toast" ng-class="toaster.type" ng-click="click(toaster)" ng-mouseover="stopTimer(toaster)"  ng-mouseout="restartTimer(toaster)"><button class="toast-close-button" ng-show="config.closeButton">&times;</button><div ng-class="config.title">{{toaster.title}}</div><div ng-class="config.message" ng-switch on="toaster.bodyOutputType"><div ng-switch-when="trustedHtml" ng-bind-html="toaster.html"></div><div ng-switch-when="template"><div ng-include="toaster.bodyTemplate"></div></div><div ng-switch-default >{{toaster.body}}</div></div></div></div>'}}]);