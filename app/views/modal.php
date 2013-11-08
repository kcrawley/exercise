    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= $modalTitle ?></h4>
                <?php if (isset($formError)): ?>
                <h5><?= $formError; ?></h5>
                <?php endif; ?>
            </div>
            <div class="modal-body">
                <form id="client-form" class="form-horizontal" role="form">
                    <div id="<?= $modalClass ?>-group" class="form-group">
                        <label for="<?= $formName ?>" class="col-sm-2 control-label"><?= $formLabel ?></label>
                        <div class="col-sm-10">
                            <input type="text" class="data-a form-control <?= $modalClass ?>" value="<?= isset($$formName) ? $$formName : '' ?>" name="<?= $formName ?>" id="<?= $formName ?>" placeholder="<?= $formLabel ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes" class="col-sm-2 control-label">Notes</label>
                        <div class="col-sm-10">
                            <textarea name="notes" class="data-b form-control" rows="3"><?= isset($notes) ? $notes : '' ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="campaign_client_id" />
                    <input type="hidden" name="form-type" value="<?= $formType ?>" />
                    <input type="hidden" name="method" value="add" />
                    <input type="hidden" name="record_id" />
                </form>

            </div>
            <div class="dialog-footer modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="triggerSave" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->