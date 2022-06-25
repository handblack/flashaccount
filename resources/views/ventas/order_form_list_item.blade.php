<tr id="tr-{{ $item->id }}">
    <td>{{ ($item->typeproduct == 'P') ? $item->product->productcode : '' }}</td>
    <td>{{ $item->description }}</td>
    <td class="text-right border-left">{{ $item->quantity }}</td>
    <td>{{ $item->um->shortname }}</td>
    <td class="text-right border-left">{{ $item->priceunit }}</td>
    <td class="text-right border-left">{{ number_format($item->amountbase,2) }}</td>
    <td class="text-right border-left">{{ number_format($item->amounttax,2) }}</td>
    <td class="text-right border-left">{{ number_format($item->amountgrand,2) }}</td>
    <td class="text-right border-left">
        <a href="#" 
            onclick="edit_item(this);"
            data-url="{{ route('corderline.edit', $item->token) }}"
            data-id="{{ $item->id }}">
            <i class="far fa-edit"></i> |                                
        </a>
        <a href="#" 
            onclick="delete_item(this)"
            data-url="{{ route('corderline.destroy', $item->token) }}"
            data-id="{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>