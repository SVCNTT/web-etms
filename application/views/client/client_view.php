<div class="main-container">
    <input id="imageClient" type="hidden" value="<?php echo $clientInfo["logoPath"]; ?>" ng-model="model.hidden.imageUrl"> 
    <input id="clientCode" type="hidden" value="<?php echo $clientInfo["clientCode"]; ?>" ng-model="model.hidden.clientCode"> 
    <input id="clientId" type="hidden" value="<?php echo $clientInfo["clientId"]; ?>" ng-model="model.hidden.clientId"> 

    <div class="wrapper-container">
      <div>
      <div class="content" style="padding-left:0px;">
                <div class="tab-content "> 
                    <div  class="tabs ">
                     <!-- <c:if test="${model.clientInfo.clientType eq 1}"> -->
                        <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
<!--                        <slidebox class="scrollbarCustom " content-width="" class="my-slidebox" content-class="my-slidebox-content">-->
                        <!-- </sec:authorize> -->
                        <!-- <sec:authorize access="hasAnyRole('MANAGER', 'LEADER', 'SUB_LEADER')"> -->
                        <!-- <slidebox class="scrollbarCustom " content-width="1010" class="my-slidebox" content-class="my-slidebox-content"> -->
                        <!-- </sec:authorize> 	 -->
                      <!-- </c:if>    -->
                      <!-- <c:if test="${model.clientInfo.clientType eq 2}"> -->
                        <!--  <slidebox class="scrollbarCustom " content-width="1400" class="my-slidebox" content-class="my-slidebox-content">	 -->
                      <!-- </c:if>    -->
                        <ul>
                        	 <!-- <li ng-class="{'active': model.hidden.activeTab ==10}"
                                ng-click="model.hidden.activeTab =10"><?php echo CLI0300_LABEL_STORE_TAB; ?></li> -->
                             <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')">  -->
                             <li ng-class="{'active': model.hidden.activeTab ==6}"
                                ng-click="model.hidden.activeTab =6"><?php echo CLI0300_LABEL_PRODUCT_TYPE; ?></li>
                             <!-- </sec:authorize> -->
                            <li ng-class="{'active': model.hidden.activeTab ==1}"
                                ng-click="model.hidden.activeTab =1"><?php echo CLI0300_LABEL_PRODUCT_TAB; ?></li>
                            <!-- <li ng-class="{'active': model.hidden.activeTab ==5}"
                                ng-click="model.hidden.activeTab =5"><?php echo CLI300_LABEL_COMPETITOR; ?></li> -->
                           
                            <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN', 'MANAGER')"> -->
                            <!-- <li ng-class="{'active': model.hidden.activeTab ==2}"
                                ng-click="model.hidden.activeTab =2"><?php echo CLI0300_LABEL_STAFF_TAB; ?></li> -->
                            <!-- </sec:authorize> -->
                           <!--  <li ng-class="{'active': model.hidden.activeTab ==7}"
                                ng-click="model.hidden.activeTab =7"><?php echo CLI0300_LABEL_SALE_MAN; ?></li> -->
                           <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')">  -->
                           <!--  <li ng-class="{'active': model.hidden.activeTab ==3}"
                                ng-click="model.hidden.activeTab =3"><?php echo CLI0300_LABEL_BILL_INFOR_TAB; ?></li> -->
                           <!-- </sec:authorize> -->
                           <!--  <c:if test="${model.clientInfo.clientType eq 2}">
                              <li ng-class="{'active': model.hidden.activeTab ==12}"
                                ng-click="model.hidden.activeTab =12"><?php echo CLI0300_LABEL_BILL_INFOR_TAB_CIGAR; ?></li>
                             </c:if> -->
                            <li ng-class="{'active': model.hidden.activeTab ==4}"
                                ng-click="model.hidden.activeTab =4"><?php echo CLI0300_LABEL_IMAGE_TAB; ?></li>
                            <!--  <c:if test="${model.clientInfo.clientType eq 1}">
                             <li ng-class="{'active': model.hidden.activeTab ==8}"
                                ng-click="model.hidden.activeTab =8"><?php echo CLI0300_LABEL_COMMON_REPORT; ?></li>
                             </c:if> -->
                            <!--  <c:if test="${model.clientInfo.clientType eq 2}">
                              <li ng-class="{'active': model.hidden.activeTab ==11}"
                                ng-click="model.hidden.activeTab =11"><?php echo CLI0300_LABEL_COMMON_REPORT_CIGAR; ?></li>
                             </c:if> -->
                         
                                <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN', 'MANAGER')"> -->
                            <!-- <li ng-class="{'active': model.hidden.activeTab ==9}"
                                ng-click="model.hidden.activeTab =9"><?php echo CLI0300_LABEL_PRICE_REPORT; ?></li> -->
                                <!-- </sec:authorize> -->
                             <!-- <li ng-class="{'active': model.hidden.activeTab ==13}"
                                ng-click="model.hidden.activeTab =13"><?php echo CLI0300_LABEL_PRODUCT_AVAI; ?></li> -->
                        </ul>
                        </slidebox>
                    </div>
                    <div class="content-tab-product scrollbarCustom" ng-if="model.hidden.activeTab ==1">
                        <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->

                        <!-- </sec:authorize> -->
                        <div ng-include="'/PRO1100'"  ng-controller="PRO1100Ctrl" ng-init="init()" >
                    </div>
                    </div>
                    <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN', 'MANAGER')"> -->
                    <div class=" content-tab-product scrollbarCustom "
                        ng-if="model.hidden.activeTab ==2">
                         <div ng-include="'/CLI0330'" ng-controller="CLI0330Ctrl" ng-init="init()" > </div>
                    </div>
                    <!-- </sec:authorize> -->
                    
                    <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')">  -->
                    <div class=" tab4 content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==3">
                          <div ng-include="'/CLI0340'" ng-controller="CLI0340Ctrl" ng-init="init()" > </div>
                  </div>
                    <!-- </sec:authorize> -->
                    
                    <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==4">
                         <div ng-include="'/CLI0350'" ng-controller="CLI0350Ctrl" ng-init="init()" > </div>
                     </div>
                     <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==5">
                         <div ng-include="'/CLI0370'" ng-controller="CLI0370Ctrl" ng-init="init()" > </div>
                    </div>
                    <!-- <sec:authorize access="hasAnyRole('ADMIN', 'SUB_ADMIN')"> -->
                     <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==6">
                         <div ng-include="'/CLI0360'" ng-controller="CLI0360Ctrl" ng-init="init()" > </div>
                      </div>
                    <!-- </sec:authorize> -->
                        <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==7">
                         <div ng-include="'/CLI0400'" ng-controller="CLI0400Ctrl" ng-init="init()" > </div>
                      </div>
                      <c:if test="${model.clientInfo.clientType eq 1}">
                       <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==8">
                         <div ng-include="'/RPT0100'" ng-controller="RPT0100Ctrl" ng-init="init()" > </div>
                      </div>
                      </c:if>
                      <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==9">
                         <div ng-include="'/RPT0400'" ng-controller="RPT0400Ctrl" ng-init="init()" > </div>
                      </div>
                      <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==10">
                         <div ng-include="'/CLI0380'" ng-controller="CLI0380Ctrl" ng-init="init()" > </div>
                      </div> 
                      <c:if test="${model.clientInfo.clientType eq 2}">
                        <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==11">
                        	<div ng-include="'/RPT0300'" ng-controller="RPT0300Ctrl" ng-init="init()" > </div>
                      </div> 
                      </c:if>
                       <c:if test="${model.clientInfo.clientType eq 2}">
                        <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==12">
                        	<div ng-include="'/CLI0390'" ng-controller="CLI0390Ctrl" ng-init="init()" > </div>
                      </div> 
                      </c:if>
                      
                        <div class=" content-tab-product scrollbarCustom"
                        ng-if="model.hidden.activeTab ==13">
                        	<div ng-include="'/RPT0500'" ng-controller="RPT0500Ctrl" ng-init="init()" > </div>
                      </div> 
                </div>
            </div>
        </div>
        </div>
</div>
<div  ng-if="model.hidden.showCLI0310"  ng-include="'/CLI0310'"  ng-controller="CLI0310Ctrl" ng-init="init()" > </div> <!-- import rival product -->

<!--  START PRO1120  -->
<div  ng-if="model.hidden.showCreatePro == true"  ng-include="'/PRO1120'"  ng-controller="PRO1120Ctrl" ng-init="init()" > </div>
<div  ng-if="model.hidden.showImportRivalProduct == true"  ng-include="'/PRO1130'"  ng-controller="PRO1130Ctrl" ng-init="init()" > </div> <!-- import rival product -->
<!-- <div   ng-include="'<c:url value="/PRO1140"/>'"  ng-controller="PRO1130Ctrl" ng-init="init()" > </div> import  product -->
<div ng-if="model.hidden.showUpdateProductType == true" ng-include="'/CLI0361'"  ng-controller="CLI0361Ctrl" ng-init="init()" > </div>
<div ng-if="model.hidden.showUpdateProductGroup == true" ng-include="'/CLI0362'"  ng-controller="CLI0362Ctrl" ng-init="init()" > </div>

<div ng-if="model.hidden.showUpdateRiVal ==true" ng-include="'/CLI0371'"  ng-controller="CLI0371Ctrl" ng-init="init()" > </div> <!-- edit rival --> 
<div ng-if="model.hidden.showAddProductRival ==true" ng-include="'/CLI0372'"  ng-controller="CLI0372Ctrl" ng-init="init()" > </div><!-- create , update rival product  --> 