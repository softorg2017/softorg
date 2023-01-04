{{--修改-基本-信息--}}
<div class="modal fade modal-main-body" id="modal-body-for-item-text-set">
    <div class="col-md-6 col-md-offset-3 margin-top-64px margin-bottom-64px bg-white">

        <div class="box- box-info- form-container">

            <div class="box-header with-border margin-top-16px margin-bottom-16px">
                <h3 class="box-title">修改【<span class="item-text-set-title"></span>】</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered " id="modal-item-text-set-form">
                <div class="box-body">

                    {{ csrf_field() }}
                    <input type="hidden" name="item-text-set-operate" value="item-text-set" readonly>
                    <input type="hidden" name="item-text-set-order-id" value="0" readonly>
                    <input type="hidden" name="item-text-set-operate-type" value="add" readonly>
                    <input type="hidden" name="item-text-set-column-key" value="" readonly>


                    <div class="form-group">
                        <label class="control-label col-md-2 item-text-set-column-name"></label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="item-text-set-column-value" autocomplete="off" placeholder="" value="">
                            <textarea class="form-control" name="item-textarea-set-column-value" rows="6" cols="100%"></textarea>
                        </div>
                    </div>

                </div>
            </form>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="item-submit-for-item-text-set"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default" id="item-cancel-for-item-text-set">取消</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>