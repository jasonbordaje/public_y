<div data-backdrop="static" class="modal fade" id="completeRequest" role="dialog">
    <div class="cr-wrapper">
        <div class="cr-subwrapper">
            <div class="modal-dialog">
                <div class="modal-content" id="completeRequestContent">
                    <div class="modal-header" id="completeRequestHeader">
                        <button type="button" data-dismiss="modal" class="close">&times;</button>
                        <div class="modal-title">
                            <h4>Complete Request</h4>
                        </div>
                    </div>
                    <div class="modal-body" id="completeRequestBody">
                        <input type="hidden" id="requestHeaderId" name="">
                        <div class="form-group">
                            <label>Select Driver</label>
                            <select id="selectDriver" class="form-control input-lg"></select>
                        </div>
                        <div class="form-group">
                            <label>Received By:</label>
                            <input type="type" id="receivedby" class="form-control input-lg" placeholder="Receivers Name" name="">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="button" id="btncompleterequest" class="btn btn-primary btn-block">Complete</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" id="btncancelcompleterequest" class="btn btn-danger btn-block" data-dismiss="modal" class="close">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>