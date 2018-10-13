<div class="main-container">
    <div class="wrapper-container">
        <div class="content-list scrollbarCustom">
            <div class="group-action"></div>

            <div class="panel-form">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span data-icon="&#xe067;"> </span>
                            <?php echo COA0100_LABEL_FORM; ?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-create">
                            <table class="table list-user-search create-table">
                                <tr> 
                                     <td class="title"><?php echo COA0100_LABEL_NAME; ?></td>
                                    <td>
                                        <div>:
                                            <input type="text" class="form-control-dms" ng-enter="search()"
                                                ng-model="model.form.searchParam.searchInput.coachingName"
                                                value='{{model.form.searchParam.searchInput.coachingName'>
                                        </div>
                                    </td>                               
                                	<td class="title"><?php echo COA0100_LABEL_CODE; ?></td>
                                    <td>
                                        <div>:
                                            <input type="text" class="form-control-dms" ng-enter="search()"
                                                ng-model="model.form.searchParam.searchInput.coachingCode"
                                                value='{{model.form.searchParam.searchInput.coachingCode}}'>
                                        </div>
                                    </td>

                                </tr>
                            </table>
                            <div class="btn-action-search">
                                <button class="btn btn-normal btn-sm btn-width-default"
                                    ng-click="search()">
                                    <?php echo COA0100_BUTTON_SEARCH; ?>
                                </button>
                                <a class="btn btn-default btn-sm  btn-width-default btn-success" href="/COA0200">
                                    <?php echo  COA0100_BUTTON_CREAT; ?>
                                </a>
                            </div>


                        </div>
                        <div class="result-search">
                            <div class="table-region">
                                <table
                                    class="list-table product-table table table-striped table-bordered"
                                    ng-click="preventClose()">
                                    <thead>
                                        <tr>
                                            <th ng-click="sortName()" style="width: 12%;"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo COA0100_LABEL_CODE; ?></th>
                                                
                                           <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo COA0100_LABEL_NAME; ?></th> 
                                                
                                              <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo COA0100_LABEL_STARTDAY; ?></th>
                                                
                                            <th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo COA0100_LABEL_ENDDAY; ?></th>

											<th ng-click="sortName()"><i
                                                ng-if="model.hidden.sortName==false"
                                                class="fa fa-chevron-up"></i> <i
                                                ng-if="model.hidden.sortName==true"
                                                class="fa fa-chevron-down"></i><?php echo COA0230_LABEL_LIST_NAME; ?></th>
                                             <th ng-click="sortName()"> <?php echo COA0230_LABEL_ASSIGN_VIEW_ANSWER;?> </th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-if="model.form.COA0100InitDataModel.resultSearch.coaInfo.length>0"
                                            ng-repeat="coaItem in model.form.COA0100InitDataModel.resultSearch.coaInfo">
                                            <td><a
                                                href="/COA0400/{{coaItem.coaching_code}}">{{coaItem.coaching_code}}</a></td>
                                            <td>{{coaItem.coaching_name}}
                                            </td>
                                            <td>{{coaItem.start_date}}</td>
                                            <td>{{coaItem.end_date}} </td>
                                            <td>{{coaItem.firstlast}}
                                            </td>
                                            <td>
				                               	<span  class="delete-store pull-right icon-close dropdown-toggle"  data-toggle="dropdown"></span>
												<a class="edit-store pull-right" href="/COA0240/{{coaItem.coaching_code}}"><span class="icon-note"></span> </a>
												<div class="popover-confirm dropdown-menu">
													<div class="arrow"> </div>
													<div class="content-confirm">
														{{model.hidden.deleteConfirm.message}} 
													</div>
													<div class="button-group-action text-center">

                                                        <button class="btn  btn-default btn-info btn-xs" ng-click="deleteCoaching(coaItem)">
                                                            <span><?php echo COMMON_BUTTON_OK; ?> </span>
                                                        </button>
														<button class="btn btn-default btn-danger btn-xs">
															<span><?php echo COMMON_BUTTON_CANCEL; ?></span>
														</button>
												    	
													</div>
												</div>
                                            </td>
                                        </tr>
                                        <!--Empty - Begin-->
                                        <tr  ng-if="model.form.COA0100InitDataModel.resultSearch.coaInfo.length == null">
                                            <td colspan="6"><?php echo COM0000_EMPTY_RESULT;?></td>
                                        </tr>
                                        <!--Empty - End-->

                                    </tbody>
                                </table>
                                <div class="paging"
                                    ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != null">
                                    <ul class="pagination">
                                        <li class="disabled"><span>{{model.form.COA0100InitDataModel.resultSearch.pagingInfo.stRow}}-{{model.form.COA0100InitDataModel.resultSearch.pagingInfo.edRow}}/{{model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlRow}}</span></li>
                                        <li class="disabled"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == null "><a
                                            href="#">&lt;&lt;</a></li>
                                        <li ng-click="startPage()"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != null "><a
                                            href="#">&lt;&lt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == 1 || model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == null"><a
                                            href="#">&lt;</a></li>
                                        <li ng-click="prevPage()"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != 1 && model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != null "><a
                                            href="#">&lt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == null"><a
                                            href="#">&gt;</a></li>
                                        <li ng-click="nextPage()"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != null "><a
                                            href="#">&gt;</a></li>

                                        <li class="disabled"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlPages || model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage == null"><a
                                            href="#">&gt;&gt;</a></li>
                                        <li ng-click="endPage()"
                                            ng-if="model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != model.form.COA0100InitDataModel.resultSearch.pagingInfo.ttlPages && model.form.COA0100InitDataModel.resultSearch.pagingInfo.crtPage != null"><a
                                            href="#">&gt;&gt;</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>