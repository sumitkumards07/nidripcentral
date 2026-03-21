
<div class="modal fade" id="update_content" class="update_content" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="colorgraph"></div><br />
                <div class="row">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading" style='background: #3C8DBC; color: #fff; font-wieght: bold;'><i class='fa fa-edit'></i> Update Contents</div>
                            <div class="panel-body">
                                <div id="umsg"></div>
                                    <form method="post" id="update_content_form" enctype="multipart/form-data" onsubmit="return false" autocomplete="off">
                                        <input type="hidden" id="update_company_id" name="update_company_id" />
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_name" name="update_company_name">
                                            <span class="fa fa-bank form-control-feedback"></span>
                                            <small id="update_coname_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="file" class="form-control" id="update_company_logo" name="update_company_logo">
                                            <span class="fa fa-image form-control-feedback"></span>
                                            <small id="update_cologo_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_salogan" name="update_company_salogan">
                                            <span class="fa fa-heart form-control-feedback"></span>
                                            <small id="update_cosalogan_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_phone" name="update_company_phone">
                                            <span class="fa fa-phone form-control-feedback"></span>
                                            <small id="update_cophone_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_mobile" name="update_company_mobile">
                                            <span class="fa fa-mobile form-control-feedback"></span>
                                            <small id="update_comobile_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_email" name="update_company_email">
                                            <span class="fa fa-envelope form-control-feedback"></span>
                                            <small id="update_coemail_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_web" name="update_company_web">
                                            <span class="fa fa-globe form-control-feedback"></span>
                                            <small id="update_coweb_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_address" name="update_company_address">
                                            <span class="fa fa-map-marker form-control-feedback"></span>
                                            <small id="update_coaddress_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_city" name="update_company_city">
                                            <span class="fa fa-road form-control-feedback"></span>
                                            <small id="update_cocity_error" class="form-text text-muted"></small>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="update_company_pob" name="update_company_pob">
                                            <span class="fa fa-paper-plane form-control-feedback"></span>
                                            <small id="update_copob_error" class="form-text text-muted"></small>
                                        </div>
                                        <input type="hidden" value="<?php echo date("Y-d-m h:m:s"); ?>" id="updated_on" name="updated_on" />
                                        <input type="hidden" value="Admin" id="updated_by" name="updated_by" />
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_update_content" name="btn_update_content"><i class="fa fa-plus"></i> Update Contents</button>
                                            </div>
                                            <div class="col-xs-6">
                                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="colorgraph"></div>
                </div>
            </div>
        </div>
    </div>
</div>