<tr id="tr-{{ $item->id }}">
    <td>{{ $item->productcode }}</td>
    <td>{{ $item->description }}</td>
    <td class="text-right border-left">{{ $item->qty }}</td>
    <td>{{ $item->umshortname }}</td>
    <td class="text-right border-left">{{ $item->priceunit }}</td>
    <td class="text-right border-left">{{ number_format($item->it_base,2) }}</td>
    <td></td>
    <td></td>
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