<tr id="tr-{{ $item->id }}">
    
    <td class="text-right border-left">
        <a href="#" 
            onclick="edit_item(this);"
            data-url="{{ route('linput.edit', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="far fa-edit"></i> |                                
        </a>
        <a href="#" 
            onclick="delete_item(this)"
            data-url="{{ route('linput.destroy', $item->id) }}"
            data-id="{{ $item->id }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>