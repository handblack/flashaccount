<tr id="tr-{{ $item->id }}">
    <td class="console">{{ ($item->typeproduct == 'P') ? $item->product->productcode : '' }}</td>
    <td>{{ $item->description }}</td>
    <td class="text-right border-left console">{{ $item->quantity }}</td>
    <td>{{ $item->um->shortname }}</td>
    <td class="text-right border-left console">{{ $item->priceunit }}</td>
    <td class="text-right border-left console">{{ number_format($item->amountbase,2) }}</td>
    <td class="text-right border-left console">{{ number_format($item->amounttax,2) }}</td>
    <td class="text-right border-left console">{{ number_format($item->amountgrand,2) }}</td>
    <td class="text-right border-left console">
        <a href="#" 
            onclick="edit_item(this);"
            data-url="{{ route('ccredit.edit', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="far fa-edit"></i> |                                
        </a>
        <a href="#" 
            onclick="delete_item(this)"
            data-url="{{ route('ccredit.destroy', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>