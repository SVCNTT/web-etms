

<div class="manage-image">
	<div class="panel-form">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="icon-list"> </span><?php echo CLI0350_LABEL_IMAGE_LIST; ?>
				</h3>
			</div>
			<div class="panel-body">

				<div class="group-search">
					<div class="condition-search">
						<div></div>
						<ul>
							<li><span> <?php echo CLI0350_LABEL_STORE; ?>:</span> <select
								chosen-select="model.form.CLI0350InitOutputModel.storeInfo" chosen-width="150px"
								ng-model="model.form.CLI0350SearchInputModel.storeId"
								ng-options="item.storeId as item.storeName for item in model.form.CLI0350InitOutputModel.storeInfo">
							</select></li>
							<li><span> <?php echo CLI0350_LABEL_DATE; ?> :</span>
								<div class="datepicker"
									ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
									<datepicker date-id="startDate" date-value="model.form.CLI0350SearchInputModel.startDate"></datepicker>

								</div>
								<span> ~ </span>
							<div class="datepicker"
									ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
									<datepicker date-id="endDate" date-value="model.form.CLI0350SearchInputModel.endDate"></datepicker>

								</div>
							</li>

							
						</ul>

					</div>
					<div class="action-search" >
						<button ng-click="search()" class="btn btn-normal btn-sm btn-width-default">
							<span class="icon-magnifier"> </span> <?php echo CLI0350_BUTTON_SEARCH; ?>
						</button>
					</div>

				</div>
				<div class="result-search">
					<div class="store-list-img" ng-repeat="photoCalItem in model.form.CLI0350InitOutputModel.photoInfo.photoCal">
						<div class="photo-date">
							<h3>{{photoCalItem.photoDate}}</h3>
						</div>
						<div class="store-name" ng-repeat="storeItem in photoCalItem.photoStoreInfo">
							<h4>{{storeItem.storeName}}</h4>
							<ul class="list-img">
								
								<li class="image-item" ng-repeat="photoItem in storeItem.photoPath">
								
								<a class="image-store" href="{{photoItem.photoUrl}}" data-lightbox="store-set-{{storeItem.storeId}}"><img ng-src="{{photoItem.photoUrl}}"></a>
								<div style="font-style: italic;">{{photoItem.notes}} </div>
								</li>
							 
							</ul>
						</div>
						
					</div>

					<div class="paging" ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null">
                        <ul class="pagination">
                            <li class="disabled"><span>{{model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.stRow}}-{{model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.edRow}}/{{model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlRow}}</span></li>
                            <li class="disabled"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == 1 || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null"><a
                                href="#">&lt;&lt;</a></li>
                            <li ng-click="startPage()"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != 1 && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null"><a
                                href="#">&lt;&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == 1 || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null"><a
                                href="#">&lt;</a></li>
                            <li ng-click="prevPage()"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != 1 && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null"><a
                                href="#">&lt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null"><a
                                href="#">&gt;</a></li>
                            <li ng-click="nextPage()"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null"><a
                                href="#">&gt;</a></li>

                            <li class="disabled"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages || model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage == null"><a
                                href="#">&gt;&gt;</a></li>
                            <li ng-click="endPage()"
                                ng-if="model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.ttlPages && model.form.CLI0350InitOutputModel.photoInfo.pagingInfo.crtPage != null"><a
                                href="#">&gt;&gt;</a></li>
                        </ul>
                    </div>

				</div>

			</div>
		</div>
	</div>

</div>