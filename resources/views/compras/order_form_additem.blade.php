
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('porder.store') }}" id="form-add-item" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name='order_id' value="{{ session('session_compras_order_id') }}">
            <input type="hidden" name="mode"  value="item" id="mode">
            <input type="hidden" name="line_id"  value="" id="line_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Producto/Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light pt-1">
                    <div class="row">
                        <div class="col-md-12 col-12 mt-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-boxes fa-fw"></i>
                                        <span class="d-none d-sm-inline-block">&nbsp;Tipo</span>
                                    </span>
                                </div>
                                <select name="typeproduct" id="typeproduct" class="form-control">
                                    <option value="P">Producto</option>
                                    <option value="S">Servicio</option>
                                </select>
                            </div>
                        </div>
                    </div>  
                    <div class="row" id="productcode">
                        <div class="col-md-12 mt-2">                                
                            <select name="product_id" id="product_id" class="form-control select2-product" ></select>
                        </div>
                    </div>
                    <div class="row" id="servicename" style="display: none;">
                        <div class="col-md-12 mt-2">
                            <textarea name="servicename" id="servicename2" cols="30" rows="2" class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-4 mt-2">
                            <label class="mb-0">Cantidad</label>
                            <div class="input-group">
                                <input type="number" id="quantity" name="quantity" class="form-control text-right" step="0.00001" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <select name="um_id" id="um_id" class="form-control" style="border-top-left-radius:0px;border-bottom-left-radius:0px;" disabled>
                                        @foreach (auth()->user()->um() as $item)
                                            <option value="{{ $item->id }}">{{ $item->umname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-9 col-md-4 mt-2">
                            <label class="mb-0">Precio Unitario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select name="afecto" id="afecto" class="form-control" >
                                        <option value="C">CON IGV</option>
                                        <option value="S">SIN IGV</option>
                                    </select>
                                </div>
                                <input type="number" id="priceunit" name="priceunit" class="form-control text-right ml-1" step="0.01" placeholder="Precio" aria-label="Cantidad" aria-describedby="basic-addon2" required>
                            </div>
                        </div>

                        <div class="col-3 col-md-4 mt-2">
                            <label class="mb-0">Pack</label>
                            <input type="number" id="package" name="package" class="form-control text-right " placeholder="" aria-label="Cantidad" aria-describedby="basic-addon2" step="1">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-4 col-md-4 mt-2">
                            <label class="mb-0">Sub-Total</label>
                            <input type="text" class="form-control text-right it-subtotal" disabled>
                        </div>
                        <div class="col-4 col-md-4 mt-2">
                            <label class="mb-0">IGV</label>
                            <input type="text" class="form-control text-right it-igv" disabled>
                        </div>
                        <div class="col-4 col-md-4 mt-2">
                            <label class="mb-0">TOTAL</label>
                            <input type="text" class="form-control text-right it-total" value="0.00" disabled>
                        </div>
                    </div>
                                
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Grabar</button>
                </div>
                <div class="modal-header pt-3 pb-3 bg-light">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-tag fa-fw"></i></span>
                                </div>
                                <select name="typeoperation_id" id="" class="form-control">
                                    @foreach ($typeoperation as $item)
                                        <option value="{{ $item->id }}">{{ $item->identity }}</option>
                                    @endforeach
                                </select> 
                            </div> 
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">IGV</span>
                                </div>
                                <select name="tax_id" id="tax_id" class="form-control">
                                    @foreach ($taxes as $item)
                                        <option value="{{ $item->id }}">{{ $item->taxname }}</option>
                                    @endforeach
                                </select> 
                            </div> 
                        </div>
                    </div>           
                    
                </div>
            </div>
        </form>
    </div>
