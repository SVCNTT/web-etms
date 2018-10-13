<div class="list-sale-position check-in-dasboard">

    <div class="search-list-sale-result">

        <div class="panel-form" style="width: 50%">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="icon-list"> </span>
                        <?php echo DAS0140_LABEL_CLIENT_SALE_LIST;?>
                    </h3>
                </div>
                <div class="panel-body">

                    <div class="group-search">
                        <div class="condition-search">

                            <?php if (check_ACL($profile, 'dashboard', 'location_bu')) {?>
                            <ul>
                                <li><span><?php echo DAS0140_LABEL_BU;?> </span>:
                                    <select chosen-select="model.form.DAS0140InitOutputModel.initData.productTypeList"
                                            data-placeholder="<?php echo DAS0140_LABEL_BU_CHOOSE_ALL;?>"
                                            ng-change="search()"
                                            chosen-width="200px"
                                            ng-model="model.hidden.DAS0140SearchInputModel.productTypeId	"
                                            ng-options="item.productTypeId as item.productTypeName for item in model.form.DAS0140InitOutputModel.initData.productTypeList">
                                        <option value=""><?php echo DAS0140_LABEL_BU_CHOOSE_ALL;?></option>
                                    </select>
                                </li>
                            </ul>
                            <?php }?>

                            <ul>
                                <li><span><?php echo DAS0140_LABEL_SALECODE;?> </span>:
                                    <input type="text" class="form-control-dms width-200" ng-enter="search()"
                                           ng-model="model.form.DAS0140ParamSearch.searchInput.salesmanCode"
                                           value='{{model.form.DAS0140ParamSearch.searchInput.salesmanCode}}'></li>

                            </ul>
                            <ul>
                                <li><span><?php echo DAS0140_LABEL_SALENAME;?> </span>:
                                    <input type="text" class="form-control-dms width-200" ng-enter="search()"
                                           ng-model="model.form.DAS0140ParamSearch.searchInput.salesmanName"
                                           value='{{model.form.DAS0140ParamSearch.searchInput.salesmanName}}'></li>
                            </ul>
                        </div>
                        <div class="action-search">
                            <button class="btn btn-normal btn-sm btn-width-default"
                                    ng-click="search()">
                                <?php echo DAS0140_BUTTON_SEARCH;?>
                            </button>

<!--                            <div class="pull-right">-->
<!--                                <input ng-change="showAll()"-->
<!--                                       ng-model="model.form.showAll" type="checkbox"-->
<!--                                       id="checkboxShowAll"-->
<!--                                       class="regular-checkbox" /><label-->
<!--                                    for="checkboxShowAll"> </label><span style="position: relative;top: -2px;margin-left: 8px;">--><?php //echo DAS0140_LABEL_ALL_SALE;?><!--</span>-->
<!--                            </div>-->

                        </div>

                    </div>
                    <div class="result-search">
                        <div class="table-region">

                            <table
                                class="list-table product-table table table-striped table-bordered statistic-loc"
                                ng-click="preventClose()">
                                <thead>
                                    <tr>
                                        <th><?php echo DAS0140_LABEL_SALE;?></th>
                                        <th><?php echo DAS0140_LABEL_STORENAME;?></th>
                                        <th class="text-center"><?php echo DAS0140_LABEL_IMAGE;?></th>
                                        <th class="text-center"><?php echo DAS0140_LABEL_CHECKIN;?></th>
                                        <th class="text-center"><?php echo DAS0140_LABEL_CHECKOUT;?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-class="{'active': $index == model.hidden.activeRow}"
                                        ng-repeat="salemanItem in model.form.DAS0140SearchResult.salesmanCheckin " ng-click="setSelected(salemanItem);">
                                        <td class="">{{salemanItem.salesmanCode}}<br/>{{salemanItem.salesmanName}} </td>
                                        <td class="" ng-if="salemanItem.isDoctor == 0">{{salemanItem.storeCode}}<br/>{{salemanItem.storeName}}</td>
                                        <td class="" ng-if="salemanItem.isDoctor == 1">{{salemanItem.storeCode}}<br/>{{salemanItem.doctorTitle}}.{{salemanItem.doctorName}}</td>
                                        <td class="text-center">
                                            <a href="{{salemanItem.imagePath}}" data-lightbox="billImage"> <img ng-src="{{salemanItem.imagePath}}" style="width: 70px;"></a>
                                        </td>
                                        <td class="text-center">
                                            {{salemanItem.checkinTime}}
                                        </td>
                                        <td class="text-center">
                                            {{salemanItem.checkoutTime}}
                                        </td>
                                    </tr>

                                    <!--Empty - Begin-->
                                    <tr ng-if="model.form.DAS0140SearchResult.pagingInfo.ttlRow == null || model.form.DAS0140SearchResult.pagingInfo.ttlRow == 0">
                                        <td colspan="6"><?php echo COM0000_EMPTY_RESULT;?></td>
                                    </tr>
                                    <!--Empty - End-->

                                </tbody>
                            </table>


                            <div class="paging" ng-if="model.form.DAS0140SearchResult.pagingInfo.ttlRow > 0">
                                <ul class="pagination">
                                    <li class="disabled"><span>{{model.form.DAS0140SearchResult.pagingInfo.stRow}}-{{model.form.DAS0140SearchResult.pagingInfo.edRow}}/{{model.form.DAS0140SearchResult.pagingInfo.ttlRow}}</span></li>
                                    <li class="disabled"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage == 1 || model.form.DAS0140SearchResult.pagingInfo.crtPage == null"><a
                                            href="#">&lt;&lt;</a></li>
                                    <li ng-click="startPageDAS0140()"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage != 1 && model.form.DAS0140SearchResult.pagingInfo.crtPage != null"><a
                                            href="#">&lt;&lt;</a></li>

                                    <li class="disabled"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage == 1 || model.form.DAS0140SearchResult.pagingInfo.crtPage == null"><a
                                            href="#">&lt;</a></li>
                                    <li ng-click="prevPageDAS0140()"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage != 1 && model.form.DAS0140SearchResult.pagingInfo.crtPage != null"><a
                                            href="#">&lt;</a></li>

                                    <li class="disabled"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage == model.form.DAS0140SearchResult.pagingInfo.ttlPages || model.form.DAS0140SearchResult.pagingInfo.crtPage == null"><a
                                            href="#">&gt;</a></li>
                                    <li ng-click="nextPageDAS0140()"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage != model.form.DAS0140SearchResult.pagingInfo.ttlPages && model.form.DAS0140SearchResult.pagingInfo.crtPage != null"><a
                                            href="#">&gt;</a></li>

                                    <li class="disabled"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage == model.form.DAS0140SearchResult.pagingInfo.ttlPages || model.form.DAS0140SearchResult.pagingInfo.crtPage == null"><a
                                            href="#">&gt;&gt;</a></li>
                                    <li ng-click="endPageDAS0140()"
                                        ng-if="model.form.DAS0140SearchResult.pagingInfo.crtPage != model.form.DAS0140SearchResult.pagingInfo.ttlPages && model.form.DAS0140SearchResult.pagingInfo.crtPage != null"><a
                                            href="#">&gt;&gt;</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-sale-graph" style="width: 49% !important;">

            <ui-gmap-google-map events="map.events" center="map.center"
                                zoom="map.zoom" style="height:100px"> <ui-gmap-markers
                    models="randomMarkers" coords="'self'" idKey="'idKey'"  click="'onClicked'" events="markersEvents">
                    <ui-gmap-windows show="'showWindow'" closeClick="'closeClick'" ng-cloak>

                        <p style="white-space:nowrap" ng-non-bindable> <span style="font-style: italic;font-weight: 600">{{storeName}} </span><br/>{{popupInfo}} </p>
                    </ui-gmap-windows>
                </ui-gmap-markers>
            </ui-gmap-google-map>

        </div>
    </div>
</div>