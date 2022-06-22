
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('corderline.store') }}" id="form-add-item" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name='session' value="corder-{{ session()->getId() }}">
            <input type="hidden" name="modeline" id="modeline" value="">
            <input type="hidden" name="itemtoken" id="itemtoken" value="">
            <div class="modal-content">
                <div class="modal-header bg-light pt-3 pb-3">
                    <div class="btn-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-boxes fa-fw"></i></span>
                            </div>
                            <select name="typeproduct" id="typeproduct" class="form-control">
                                <option value="P" {{ ($item->typeproduct == 'P') ? 'selected' : '' }}>Producto</option>
                                <option value="S" {{ ($item->typeproduct == 'S') ? 'selected' : '' }}>Servicio</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="btn-group ml-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-tag fa-fw"></i></span>
                            </div>
                            <select name="" id="" class="form-control">
                            <option value="1">Operacion Grabada</option>
                            <option value="2">Operacion Inafecta</option>
                            <option value="3">Operacion Exonerada</option>
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
                                <input type="text" id="qty" name="qty" class="form-control text-right" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <select name="um_id" id="um_id" class="form-control" style="border-top-left-radius:0px;border-bottom-left-radius:0px;" disabled>
                                        @foreach (auth()->user()->ums() as $item)
                                            <option value="{{ $item->id }}">{{ $item->umname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="mb-0">PU (Sin IGV)</label>
                            <input type="text" id="priceunit" name="priceunit" class="form-control text-right" placeholder="Precio Unitario" aria-label="Precio Unitario" aria-describedby="basic-addon2">
                             
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
