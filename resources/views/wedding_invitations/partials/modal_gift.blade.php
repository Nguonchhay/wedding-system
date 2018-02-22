<div id="modalEditGift" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit gift of: <strong id="editGuest"></strong></h4>
            </div>
            <div class="modal-body">
                <form class="form">
                    {{ csrf_field() }}
                    <input id="edit_wedding_invitation" value="" type="hidden">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class=" col-sm-6">
                                <label for="edit_gift_dollar">Dollar (<i class="fa fa-usd" aria-hidden="true"></i>)</label>
                                <input class="form-control gif-recording" id="edit_gift_dollar" maxlength="4" value="" type="text">
                            </div>

                            <div class="col-sm-6">
                                <label for="edit_gift_khmer">Riel (<i class="fa fa-money" aria-hidden="true"></i>)</label>
                                <input class="form-control gif-recording" id="edit_gift_khmer" type="text" value="">
                            </div>

                            <div class="col-sm-12">
                                <label for="edit_gift_other">Other</label>
                                <textarea class="form-control " id="edit_gift_other" cols="50 " rows=" 2"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnEditGift" type="button" class="btn btn-primary" data-action="{!! route('wedding_invitations.record_ajax', ['id' => $wedding->id]) !!}">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Update
                </button>
                <button type="button" class="btn btn-default btnEditGiftClose">
                    <i class="fa fa-times" aria-hidden="true"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>