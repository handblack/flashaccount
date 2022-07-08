<tr id="tr-{{ $item->id }}">
    <td>{{ $item->description }}</td>
    <td class="console d-none d-sm-table-cell">{{ ($item->typeproduct == 'P') ? $item->product->productcode : '' }}</td>
    <td class="text-right border-left console">{{ $item->quantity }}</td>
    <td>{{ $item->um->shortname }}</td>
    <td class="text-right border-left console">{{ $item->priceunit }}</td>
    <td class="text-right border-left console d-none d-sm-table-cell">{{ number_format($item->amountbase,2) }}</td>
    <td class="text-right border-left console d-none d-sm-table-cell">{{ number_format($item->amounttax,2) }}</td>
    <td class="text-right border-left console">{{ number_format($item->amountgrand,2) }}</td>
    <td class="text-right border-left console pl-3">
        <a href="#" 
            onclick="edit_item(this);"
            data-url="{{ route('cinvoice.edit', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="far fa-edit"></i>                             
        </a>|<a href="#" 
            onclick="delete_item(this)"
            data-url="{{ route('cinvoice.destroy', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>