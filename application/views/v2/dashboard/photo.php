<div class="panel-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="icon-list"> </span>
                <?php echo CLI0350_LABEL_IMAGE_LIST; ?>
            </h3>
        </div>
        <div class="panel-body">

            <div class="form-create">
                <table class="table list-user-search create-table">
                    <tbody>
                    <tr>
                        <td class="title">
                            <?php echo CLI0350_LABEL_STORE; ?>
                        </td>
                        <td>
                            <div>:
                                <select
                                    chosen-select="model.form.CLI0350InitOutputModel.storeInfo" chosen-width="400px"
                                    ng-model="model.form.CLI0350SearchInputModel.storeId"
                                    ng-options="item.store_id as item.store_name for item in model.form.CLI0350InitOutputModel.storeInfo">
                                </select>
                            </div>
                        </td>

                        <td class="title">
                            <?php echo CLI0350_LABEL_DATE; ?>
                        </td>
                        <td style="display: flex;vertical-align: middle;line-height: 30px;">
                            <span>:</span>
                            <div class="datepicker"
                                 ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
                                <datepicker date-id="startDate"
                                            date-value="model.form.CLI0350SearchInputModel.startDate"></datepicker>

                            </div>
                            <span>&nbsp;~&nbsp;</span>

                            <div class="datepicker"
                                 ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
                                <datepicker date-id="endDate"
                                            date-value="model.form.CLI0350SearchInputModel.endDate"></datepicker>

                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-action-search">
                    <button ng-click="searchData()" class="btn btn-normal btn-sm btn-width-default">
                        <?php echo CLI0350_BUTTON_SEARCH; ?>
                    </button>
                </div>
            </div>

            <div class="result-search">
                <div class="store-list-img"
                     ng-repeat="photoCalItem in model.form.CLI0350InitOutputModel.photoInfo.photoCal">
                    <div class="das-list-date">
                        <h3>{{photoCalItem.photoDate}}</h3>
                    </div>
                    <div class="store-name">
                        <ul class="das-list-img row">
                            <li class="image-item col-md-3" ng-repeat="photoItem in photoCalItem.photoPaths">
                                <h5 title="{{photoItem.storeName}}">{{photoItem.storeName}}</h5>
                                <a class="image-store" href="/{{photoItem.photoPath}}" data-lightbox="billImage">
                                    <img style="width: 100%" ng-src="/{{photoItem.photoPath}}">
                                </a>
                                <div>{{photoItem.notes}}</div>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="paging" ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null">
                    <ul class="pagination">
                        <li class="disabled"><span>{{model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.stRow}}-{{model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.edRow}}/{{model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlRow}}</span>
                        </li>
                        <li class="disabled"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == 1 || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&lt;&lt;</a></li>
                        <li ng-click="startPage()"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != 1 && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&lt;&lt;</a></li>

                        <li class="disabled"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == 1 || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&lt;</a></li>
                        <li ng-click="prevPage()"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != 1 && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&lt;</a></li>

                        <li class="disabled"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&gt;</a></li>
                        <li ng-click="nextPage()"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&gt;</a></li>

                        <li class="disabled"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null">
                            <a
                                href="#">&gt;&gt;</a></li>
                        <li ng-click="endPage()"
                            ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null">
                            <a
                                href="#">&gt;&gt;</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>