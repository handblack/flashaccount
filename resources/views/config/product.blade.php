@extends('layouts.app')

@section('breadcrumb')
    <a href="{{ route('product.create') }}">
        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
        Nuevo
    </a>
@endsection

@section('container')
    <table>
        <tbody>
            @forelse ($result as $item)
                <tr id="tr-{{ $item->id }}">
                    <td>
                        <a href="{{ route('product.edit',[$item->token]) }}">
                        {{ $item->productcode }}
                        </a>
                    </td>
                    <td>{{ $item->productname }}</td>
                    <td>
                        <a class="delete-record" data-url="{{ route('product.destroy', $item->token) }}"
                            data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No hay resultado en la busqueda</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection