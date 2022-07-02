<tr id="tr-{{ $item->id }}">
    <td>{{ $item->product->productcode }}</td>
    <td>{{ $item->product->productname }}</td>
    <td class="text-right border-left">{{ $item->quantity }}</td>
    <td class="">{{ $item->product->um->shortname }}</td>
    <td class="text-right">{{ $item->package }}</td>
    <td class="text-right border-left">
        <a href="#" 
            onclick="edit_item(this);"
            data-url="{{ route('ltransfer.edit', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="far fa-edit"></i> |                                
        </a>
        <a href="#" 
            onclick="delete_item(this)"
            data-url="{{ route('ltransfer.destroy', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>