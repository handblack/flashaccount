<div class="row">
    <div class="col-md-3 col-sm-6">
        <label class="mb-0">Base Imponible</label>
        <span class="form-control disabled text-right">{{ number_format($lines->sum('it_base'),2) }}</span>
    </div>
    <div class="col-md-3 col-sm-6">
        <label class="mb-0">Exonerados/Inafectos</label>
        <span class="form-control disabled text-right">0.00</span>
    </div>
    <div class="col-md-3 col-sm-6">
        <label class="mb-0">Impuestos</label>
        <span class="form-control disabled text-right">{{ number_format($lines->sum('it_tax'),2) }}</span>
    </div>
    <div class="col-md-3 col-sm-6">
        <label class="mb-0">TOTAL</label>
        <span class="form-control disabled text-right">{{ number_format($lines->sum('it_grand'),2) }}</span>
    </div>
</div>