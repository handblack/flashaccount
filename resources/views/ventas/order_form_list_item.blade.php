<tr id="tr-{{ $item->id }}">
    <td>{{ $item->productcode }}</td>
    <td>{{ $item->description }}</td>
    <td class="text-right border-left">{{ $item->qty }}</td>
    <td class="text-right border-left">{{ $item->priceunit }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right border-left">
        <i class="far fa-edit"></i> |                                
        <a href="#" 
            onclick="delete_item(this)"
            data-url="{{ route('corderline.destroy', $item->token) }}"
            data-id="{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>