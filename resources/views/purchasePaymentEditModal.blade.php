<div id="purchasePaymentEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <form id="purchasePaymentEditForm" action="#">
          @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Update Purchase Payment</b></h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Supplier Name</th>
                <th>Payment Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select required name="partyId" id="partyId" class="js-select2">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <input required type="date" name="date" id="date" class="form-control">
                </td>
              </tr>
              <tr>
                <th>Paid Amount</th>
                <th>Discount</th>
              </tr>
              <tr>
                <td>
                  <input required type="text" name="amount" id="amount" class="form-control">
                </td>
                <td>
                  <input required type="text" name="discount" id="discount" class="form-control">
                </td>
              </tr>
              <tr>
                <th>Narration</th>
                <th></th>
              </tr>
              <tr>
                <td>
                  <input type="text" name="narration" id="narration" class="form-control">
                </td>
                <td>
                </td>
              </tr>

            </tbody>
          </table>  
        </div>
        <div class="modal-footer">     
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            UPDATE
          </button>  
        </div>
      </form>
      </div>
  
    </div>
</div>



