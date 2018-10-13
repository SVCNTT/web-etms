<div class="panel-form">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="icon-list"> </span><?php echo SAL0340_LABEL_VACATION; ?>
			</h3>
		</div>
		<div class="panel-body">

			<div class="group-search">
				<div class="condition-search">
						<ul>
						
						<li><span><?php echo SAL0340_LABEL_TIME; ?></span>:
                            <div class="datepicker"
								ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
								<datepicker date-id="startDate"
									date-value="model.hidden.SAL0340SearchInputModel.searchInput.startDate"></datepicker>

							</div>~
                            <div class="datepicker"
								ng-class="{'error': model.hidden.validation.stDate.isErrored == true}">
								<datepicker date-id="endDate"
									date-value="model.hidden.SAL0340SearchInputModel.searchInput.endDate"></datepicker>

							</div></li>


					</ul>

				</div>
				<div class="action-search">
					<button ng-click="searchSaleLeave()"
						class="btn btn-normal btn-sm btn-width-default">
<!--						<span class="icon-magnifier"> </span>-->
						<?php echo SAL0340_BUTTON_SEARCH; ?>
					</button>
				</div>

			</div>
			<div class="result-search" ng-if="model.form.SAL0340initModalResult.resultSearch.salLeave.length>0">
				<div class="table-region">
					<table
						class="list-table product-table table list-store table-striped table-bordered">
						<thead>
							<tr>
								<th style="width:10%"><?php echo SAL0340_LABEL_VACATION_DATE; ?></th>
								<th style="width:70%"><?php echo SAL0340_LABEL_REASON; ?></th>
								<th style="width:20%"><?php echo SAL0340_LABEL_TYPE; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="salItem in model.form.SAL0340initModalResult.resultSearch.salLeave">
								<td>{{salItem.leaveDate}}</td>
								<td>{{salItem.contText}}</td>
								<td>{{salItem.type}}</td>
							</tr>
							
						</tbody>
					</table>
					<div class="paging"
						ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != null">
						<ul class="pagination">
							<li class="disabled"><span>{{model.form.SAL0340initModalResult.resultSearch.pagingInfo.stRow}}-{{model.form.SAL0340initModalResult.resultSearch.pagingInfo.edRow}}/{{model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlRow}}</span></li>
							<li class="disabled"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == 1 || model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == null "><a
								href="#">&lt;&lt;</a></li>
							<li ng-click="startPage()"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != 1 && model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != null "><a
								href="#">&lt;&lt;</a></li>

							<li class="disabled"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == 1 || model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == null"><a
								href="#">&lt;</a></li>
							<li ng-click="prevPage()"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != 1 && model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != null "><a
								href="#">&lt;</a></li>

							<li class="disabled"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlPages || model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == null"><a
								href="#">&gt;</a></li>
							<li ng-click="nextPage()"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlPages && model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != null "><a
								href="#">&gt;</a></li>

							<li class="disabled"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlPages ||model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage == null"><a
								href="#">&gt;&gt;</a></li>
							<li ng-click="endPage()"
								ng-if="model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != model.form.SAL0340initModalResult.resultSearch.pagingInfo.ttlPages && model.form.SAL0340initModalResult.resultSearch.pagingInfo.crtPage != null"><a
								href="#">&gt;&gt;</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>