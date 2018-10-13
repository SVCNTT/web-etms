<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"> </span><?php echo STO0100_LABEL_FORM; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-store-search">
                    <tr>

                        <td class="title"> <?php echo STO0100_LABEL_REGION; ?>    </td>
                        <td>:
                            <div class="my-areas btn-group my-button">
                                <button type="button"
                                        class="dropdown-toggle chooseRegion"
                                        data-toggle="dropdown" aria-expanded="false">
                                    {{model.hidden.defaultAreaName}}
                                </button>
                                <div class="my-areas-icon"><b></b></div>
                                <ul class="dropdown-menu areaList scrollbarCustom" role="menu">
                                    <li ng-repeat="areaGroupItem in model.form.STO0100InitDataModel.initData.areaInfo.items">

                                        <div class="groupAreaName"
                                             ng-click="chooseArea(areaGroupItem.areaName,areaGroupItem.areaId)">
                                            {{areaGroupItem.areaName}}
                                        </div>
                                        <ul class="area">
                                            <li ng-repeat="areaItem in areaGroupItem.items">
                                                <div class="areaName"
                                                     ng-click="chooseArea(areaItem.areaName,areaItem.areaId)">
                                                    {{areaItem.areaName}}
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </td>

                        <td class="title"> <?php echo STO0100_LABEL_CODE; ?>    </td>
                        <td>
                            <div>:
                                <input type="text" class="form-control-dms width200" ng-enter="search()"
                                       ng-model="model.hidden.storeCode" value='{{model.hidden.storeCode}}'>
                            </div>
                        </td>

                        <td class="title"> <?php echo STO0100_LABEL_NAME; ?>    </td>
                        <td>
                            <div>:
                                <input type="text" class="form-control-dms width200" ng-enter="search()"
                                       ng-model="model.hidden.storeName" value='{{model.hidden.storeName}}'>
                            </div>
                        </td>

                    </tr>

                </table>
                <div class="btn-action-search">
                    <button class="btn btn-normal btn-sm btn-width-default" ng-click="search()">
                        <?php echo STO0100_BUTTON_SEARCH; ?>
                    </button>

                    <?php if (check_ACL($profile, 'store', 'create_pharmacy')) { ?>
                        <a style="width: 140px;"
                           class="btn btn-default btn-sm  btn-width-default btn-success" href="/STO0200">
                            <?php echo STO0100_BUTTON_CREAT; ?>
                        </a>
                    <?php } ?>

                    <?php if (check_ACL($profile, 'store', 'create_doctor')) { ?>
                        <a style="width:130px;"
                           class="btn btn-default btn-sm  btn-width-default btn-success" href="/DOC0200">
                            <?php echo STO0100_BUTTON_CREAT_DOCTOR; ?>
                        </a>
                    <?php } ?>

                    <?php if (check_ACL($profile, 'store', 'import')) { ?>
                        <button ng-click="importStore()" class="btn btn-sm  btn-info btn-width-default">
                            <span> </span>
                            <?php echo CLI0300_BUTTON_CHOOSE_FILE; ?>
                        </button>
                    <?php } ?>

                    <?php if (check_ACL($profile, 'store', 'export_pharmacy') || check_ACL($profile, 'store', 'export_doctor')) { ?>
                        <div class="btn-group" style="box-shadow: none;top: 5px">
                            <a href="bootstrap-elements.html" data-target="#"
                               class="btn btn-default btn-sm btn-width-default dropdown-toggle"
                               data-toggle="dropdown">
                                <?php echo STO0100_BUTTON_EXPORT; ?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (check_ACL($profile, 'store', 'export_pharmacy')) { ?>
                                    <li>
                                        <a href="/STO0410/0"><?php echo STO0100_BUTTON_EXPORT_PHARMACY ?></a>
                                    </li>
                                <?php } ?>

                                <?php if (check_ACL($profile, 'store', 'export_doctor')) { ?>
                                    <li><a href="/STO0410/1"><?php echo STO0100_BUTTON_EXPORT_DOCTOR; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>


            </div>
            <div class="result-search">
                <div class="table-region">
                    <table
                        class="list-table product-table table list-store table-striped table-bordered"
                        >
                        <thead>
                        <tr>
                            <th ng-click="sortName()"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>  <?php echo STO0100_LABEL_CODE; ?>
                            </th>
                            <th ng-click="sortCode()"><i
                                    ng-if="model.hidden.sortCode==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortCode==true"
                                    class="fa fa-chevron-down"></i>  <?php echo STO0100_LABEL_NAME; ?>
                            </th>

                            <th ng-click="sortName()"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i>  <?php echo STO0100_LABEL_ADDRESS; ?>
                            </th>
                            <th ng-click="sortName()"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i><?php echo STO0100_LABEL_REGION; ?>
                            </th>
                            <th ng-click="sortName()"><i
                                    ng-if="model.hidden.sortName==false"
                                    class="fa fa-chevron-up"></i> <i
                                    ng-if="model.hidden.sortName==true"
                                    class="fa fa-chevron-down"></i><?php echo STO0100_LABEL_DOCTORS; ?>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="storeItem in model.form.STO0100InitDataModel.resultSearch.storeInfo">
                            <td>{{storeItem.storeCode}}</td>
                            <td><a href="/STO0300/{{storeItem.storeCode}}">{{storeItem.storeName}}</a></td>
                            <td>{{storeItem.adddress}}</td>
                            <td>
                                {{storeItem.areaName}}
                            </td>
                            <td>
                                {{storeItem.isDoctor}}
                                <?php if (check_ACL($profile, 'store', 'delete')) { ?>
                                    <span class="delete-store pull-right icon-close dropdown-toggle"
                                          data-toggle="dropdown"></span>
                                <?php } ?>

                                <?php if (check_ACL($profile, 'store', 'edit')) { ?>
                                    <a ng-if="storeItem.isDoctor == 'No'" class="edit-store pull-right"
                                       href="/STO0210/{{storeItem.storeCode}}"><span
                                            class="icon-note"></span> </a>
                                    <a ng-if="storeItem.isDoctor == 'Yes'" class="edit-store pull-right"
                                       href="/DOC0210/{{storeItem.storeCode}}"><span
                                            class="icon-note"></span> </a>
                                <?php } ?>

                                <?php if (check_ACL($profile, 'store', 'delete')) { ?>
                                    <div class="popover-confirm dropdown-menu">
                                        <div class="arrow"></div>
                                        <div class="content-confirm">
                                            {{model.hidden.deleteConfirm.message}}
                                        </div>
                                        <div class="button-group-action text-center">

                                            <button class="btn  btn-default btn-info btn-xs"
                                                    ng-click="deleteStore(storeItem)">
                                                <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                            </button>
                                            <button class="btn btn-default btn-danger btn-xs">
                                                <span><?php echo COMMON_BUTTON_CANCEL; ?></span>
                                            </button>

                                        </div>
                                    </div>
                                <?php } ?>

                            </td>


                        </tr>
                        <!--Empty - Begin-->
                        <tr ng-if="model.form.STO0100InitDataModel.resultSearch.storeInfo.length == null">
                            <td colspan="5"><?php echo COM0000_EMPTY_RESULT; ?></td>
                        </tr>
                        <!--Empty - End-->

                        </tbody>
                    </table>
                    <div class="paging"
                         ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                        <ul class="pagination">
                            <li class="disabled"><span>{{model.form.STO0100InitDataModel.resultSearch.pagingInfo.stRow}}-{{model.form.STO0100InitDataModel.resultSearch.pagingInfo.edRow}}/{{model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlRow}}</span>
                            </li>
                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null ">
                                <a href="#">&lt;&lt;</a></li>
                            <li ng-click="startPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                <a href="#">&lt;&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                <a href="#">&lt;</a></li>
                            <li ng-click="prevPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                <a href="#">&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                <a href="#">&gt;</a></li>
                            <li ng-click="nextPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null ">
                                <a href="#">&gt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages ||model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage == null">
                                <a href="#">&gt;&gt;</a></li>
                            <li ng-click="endPage()"
                                ng-if="model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.STO0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.STO0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                                <a href="#">&gt;&gt;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
