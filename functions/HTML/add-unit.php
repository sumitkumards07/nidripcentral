<div class="row">
    <div class="col-md-4">
        
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-grid"></i> Add Unit</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="unit_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text unit_name"><i class="fas fa-award award"></i></div>
                            </div>
                            <input type="text" name="unit_name" id="unit_name" class="form-control unit_name" placeholder="Enter Unit Name..">
                        </div>
                        <span class="unit_name_error text-danger text-small"></span>
                    </div>
                    <input type="hidden" name="created_on" id="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                    <div class="form-group">
                        <input type="submit" id="btn_unit" class="btn btn-primary w-100" value="Add Unit" />
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4>View Units</h4></div>
            <div class="card-body">
                <div id="umsg"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Unit Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="unit_view"></tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>








