<div class="modal-confirm ">
    <div class="modal-info">
        <div class="header">
            <span class="title" class="pull-left"> <?php echo STO0110_LABEL_TITLE; ?>
            </span> <span class="pull-right close icon-close"
                ng-click="closeImportStore()"></span>
        </div>
           
            <div class="body">
                <span><?php echo STO0110_LABEL_CHOOSE_FILE; ?>:</span>

                <div class="choose-file">
                     <input  onchange="angular.element(this).scope().setFiles(this)"
                       ng-file-select="onFileSelect($files)" class="ng-hide" type="file" name="file"
                       id="STO0110ChooseFile">
                <a ng-click="chooseFile()" name="file"
                   class="btn btn-default btn-sm btn-normal btn-width-default pull-left choose-file-custom">
                       <span class="icon-folder"></span> <?php echo CLI0200_BUTTON_UPFILE; ?> </a>

                <div ng-repeat="file in files.slice(0)" class="fileNameChoose">
                    <span>{{file.webkitRelativePath || file.name}}</span>
                        	 <span ng-switch="file.size > 1024*1024">(
				                <span ng-switch-when="true">{{file.size / 1024 / 1024 | number:2}} MB</span>
				                <span ng-switch-default>{{file.size / 1024 | number:2}} kB</span>)
				            </span>
                </div>
                 </div>

            </div>
            <div class="footer">
                <button type="button" ng-click="upload()" ng-disabled="files.length==0 || files ==null"
                    class="btn btn-default btn-sm  btn-success btn-width-default pull-right">
                    <span class="icon-cloud-upload"> </span>
                    <?php echo STO0110_BUTTON_UPLOAD_PRICE; ?>
                </button>
            </div>
    </div>
</div>