{{-- init / FormModalAddItems --}}
<div class="modal" id="ModalAddItem"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('corderline.store') }}" id="form-add-item" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name='session' value="{{ session()->getId() }}">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="btn-group">

                        <select name="typeproduct" id="typeproduct" class="form-control">
                            <option value="P">Producto</option>
                            <option value="S">Servicio</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <select name="" id="" class="form-control">
                            <option value="1">Operacion Grabada</option>
                            <option value="2">Operacion Inafecta</option>
                            <option value="3">Operacion Exonerada</option>
                        </select> 
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="productcode">
                        <div class="col-md-12">                                
                            <select name="product_id" id="" class="form-control select2-product"></select>
                        </div>
                    </div>
                    <div class="row" id="servicename">
                        <div class="col-md-12">
                            <textarea name="servicename" id="" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-6">
                            <label class="mb-0">Cantidad</label>
                            <div class="input-group">
                                <input type="text" name="qty" class="form-control text-right" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">UND</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="mb-0">PU (Sin IGV)</label>
                            <input type="text" name="priceunit" class="form-control text-right" placeholder="Precio Unitario" aria-label="Precio Unitario" aria-describedby="basic-addon2">
                             
                        </div>
                    </div>
                    <div class="row">
                            
                        <div class="col-md-4">
                            <label class="mb-0">Sub-Total</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="mb-0">IGV</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="mb-0">TOTAL</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- fin / FormModalAddItems --}}