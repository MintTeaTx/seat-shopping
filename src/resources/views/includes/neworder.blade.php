
<div class="modal fade" tabindex="-1" role="dialog" id="newOrderModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title">Are you sure?</h4>
            </div>

            <form role="form" action="{{ route('shopping.neworder') }}" method="post">
                <div class="form-group">
                    <label>Order Details</label><br>
                    {{ csrf_field() }}
                    <textarea class="form-control" name="details" rows="30" style="width: 100%" onclick="this.focus();this.select();"></textarea>
                </div>
                <div class="btn-group pull-right" role="group"><br>
                        <input type="submit" class="btn-primary" id="saveOrder" value="Submit Order"/>
                </div>

            </form>
        </div>
    </div>
</div>
