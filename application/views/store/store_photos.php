<div class="manage-image">
	<div class="panel-form">
		<div class="panel panel-primary">

			<div class="panel-body">

				<div class="result-search">
					<div class="store-list-img" ng-if="model.form.STO0330InitDataModel.photoResult[0]['photoDate'] != null " ng-repeat="photoItem in model.form.STO0330InitDataModel.photoResult ">
						<div class="store-name">
							<h4>{{photoItem.photoDate}}</h4>
						</div>
						<ul class="list-img">
							<li class="image-item" ng-repeat ="photoPathItem in photoItem.photoPath  track by $index">
								<a class="image-store" href="../{{photoPathItem.photoPath}}" data-lightbox="storeImage_{{photoItem.photoDate}}"><img ng-src="../{{photoPathItem.photoPath}}"></a>
								<div style="font-style:italic;">{{photoPathItem.notes}} </div>
							</li>
							

						</ul>
					</div>
					<div class="store-list-img" style="margin-top: 5px;" ng-if="model.form.STO0330InitDataModel.photoResult[0]['photoDate'] == null ">
						 <?php echo COM0000_EMPTY_RESULT_PHOTOS; ?>
					</div>
					
				</div>

			</div>
		</div>
	</div>

</div>