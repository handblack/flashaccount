
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('ccredit.store') }}" id="form-add-item" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name='credit_id' value="{{ session('session_ventas_credit_id') }}">
            <input type="hidden" name="mode"  value="item" id="mode">
            <input type="hidden" name="line_id"  value="" id="line_id">
            <div class="modal-content">
                <div class="modal-header bg-light pt-3 pb-3">
                    <div class="btn-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-boxes fa-fw"></i></span>
                            </div>
                            <select name="typeproduct" id="typeproduct" class="form-control">
                                <option value="P">Producto</option>
                                <option value="S">Servicio</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="btn-group ml-2">
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
                    <div class="btn-group ml-2">
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

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="productcode">
                        <div class="col-md-12">                                
                            <select name="product_id" id="product_id" class="form-control select2-product" ></select>
                        </div>
                    </div>
                    <div class="row" id="servicename" style="display: none;">
                        <div class="col-md-12">
                            <textarea name="servicename" id="servicename2" cols="30" rows="2" class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-6">
                            <label class="mb-0">Cantidad</label>
                            <div class="input-group">
                                <input type="text" id="qty" name="quantity" class="form-control text-right" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <select name="um_id" id="um_id" class="form-control" style="border-top-left-radius:0px;border-bottom-left-radius:0px;" disabled>
                                        @foreach (auth()->user()->um() as $item)
                                            <option value="{{ $item->id }}">{{ $item->umname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="mb-0">PU (Sin IGV)</label>
                            <input type="text" id="priceunit" name="priceunit" class="form-control text-right" placeholder="Precio SIN IGV" aria-label="Precio Unitario" aria-describedby="basic-addon2">
                             
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="mb-0">PU (Con IGV)</label>
                            <input type="text" id="priceunittax" name="priceunittax" class="form-control text-right" placeholder="Precio CON IGV" aria-label="Precio Unitario" aria-describedby="basic-addon2">
                             
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Grabar</button>
                </div>
            </div>
        </form>
    </div>
