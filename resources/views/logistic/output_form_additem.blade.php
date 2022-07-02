<div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('loutput.store') }}" id="form-add-item" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name='output_id' value="{{ session('session_logistic_output_id') }}">
        <input type="hidden" name="mode"  value="item" id="mode">
        <input type="hidden" name="line_id"  value="" id="line_id">
        <div class="modal-content">
            <div class="modal-header bg-light pt-3 pb-3">
                 Agregar Producto
            </div>
            <div class="modal-body" style="background-color:#dcdcdc4e;">
                <div class="row" id="productcode">
                    <div class="col-md-12">
                        <label>Producto</label>
                        <select name="product_id" id="product_id" class="form-control select2-product" ></select>
                    </div>
                </div>
                <div class="row mt-2" id="productcode">
                    <div class="col-md-2">
                        <label class="mb-1">Cantidad</label>
                        <input type="text" name="quantity" id="quantity"  class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="mb-1">Paquetes</label>
                        <input type="text" name="package" id="package" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"> Grabar</button>
            </div>
        </div>
    </form>
</div>