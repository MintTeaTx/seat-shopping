@section('left')
    <div class="modal fade" tabindex="-1" role="dialog" id="createOrderModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                    <h4 class="modal-title">Are you sure?</h4>                </div>
                <form role="form">
                    <div>
                    <input type="hidden" id="charactername">
                        {{csrf_field()}}
                        <label>Order Details</label><br>
                        <textarea name="order_info" id="order_info" rows="30" style="width: 100%" onclick="this.focus();this.select();"></textarea>
                    </div>
                </form>
            </div>
        </div>


    </div>