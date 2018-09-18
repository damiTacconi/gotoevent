<!-- Modal: modalCart -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Your cart</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Product 1</td>
                            <td>100$</td>
                            <td><a><i class="fa fa-remove"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Product 2</td>
                            <td>100$</td>
                            <td><a><i class="fa fa-remove"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Product 3</td>
                            <td>100$</td>
                            <td><a><i class="fa fa-remove"></i></a></td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>Product 4</td>
                            <td>100$</td>
                            <td><a><i class="fa fa-remove"></i></a></td>
                        </tr>
                        <tr class="total">
                            <th scope="row">5</th>
                            <td>Total</td>
                            <td>400$</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <!--Footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Checkout</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal: modalCart -->