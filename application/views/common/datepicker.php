<div class="input-group dmsDatepicker">
  <input type="text" class="form-control-dms input-sm" ng-model="dateValue" id="{{ dateId }}" ng-class="{ error:invalid }" autocomplete="off">
  <div class="input-group-btn">
    <a type="button" class="btn btn-default" ng-click="moveDay( -1 )"> <span class="fa fa-angle-left"></span>
    </a> <a type="button" class="btn btn-default" ng-click="getToday()"> <span class="fa fa-dot-circle-o"></span>
    </a> <a type="button" class="btn btn-default" ng-click="moveDay( 1 )"> <span class="fa fa-angle-right"></span>
    </a>
  </div>
  {{ initDatePicker() }}
</div>