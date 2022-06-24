<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="input-group ">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">BASE</span>
            </div>
            <span class="form-control disabled text-right text-monospace">{{ number_format($lines->sum('it_base'),2) }}</span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="input-group ">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">EXO</span>
            </div>
            <span class="form-control disabled text-right text-monospace">0.00</span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="input-group ">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">IGV</span>
            </div>
            <span class="form-control disabled text-right text-monospace">{{ number_format($lines->sum('it_tax'),2) }}</span>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="input-group ">
            <div class="input-group-prepend">
              <span class="input-group-text bg-secondary" id="basic-addon1"><strong>TOTAL</strong></span>
            </div>
            <span class="form-control disabled text-right text-monospace">{{ number_format($lines->sum('it_grand'),2) }}</span>
        </div>
    </div>
</div>