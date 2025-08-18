<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="{{ $icon }} me-2"></i>
            {{ $title }}
            <span class="badge bg-primary ms-2">{{ $total }}</span>
        </h6>
    </div>
    <div class="card-body">
        @if($items->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center col-id">
                                <i class="fas fa-hashtag"></i> ID
                            </th>
                            @foreach($columns as $column)
                                <th class="{{ $column['class'] ?? '' }}" style="{{ $column['style'] ?? '' }}">
                                    @if(isset($column['icon']))
                                        <i class="{{ $column['icon'] }}"></i>
                                    @endif
                                    {{ $column['label'] }}
                                </th>
                            @endforeach
                            <th class="text-center" style="width: 180px;">
                                <i class="fas fa-cogs"></i> Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="text-center table-index">#{{ $item->id }}</td>
                                @foreach($columns as $key => $column)
                                    <td class="{{ $column['cell_class'] ?? '' }}">
                                        @if(isset($column['component']))
                                            @include($column['component'], ['item' => $item, 'value' => data_get($item, $key)])
                                        @else
                                            {{ data_get($item, $key) }}
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-center">
                                    <div class="btn-group-modern" role="group">
                                        <a href="{{ route($routePrefix . '.show', $item->id) }}" 
                                           class="btn-action btn-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route($routePrefix . '.edit', $item->id) }}" 
                                           class="btn-action btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route($routePrefix . '.destroy', $item->id) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('{{ $deleteMessage }}')"> 
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-danger" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if(method_exists($items, 'links'))
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $items->firstItem() }} a {{ $items->lastItem() }} 
                        de {{ $items->total() }} resultados
                    </div>
                    <div>
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="{{ $emptyIcon }} fa-3x text-muted"></i>
                </div>
                <h5 class="text-muted">{{ $emptyTitle }}</h5>
                <p class="text-muted mb-4">{{ $emptyMessage }}</p>
                <a href="{{ route($routePrefix . '.create') }}" class="btn-modern btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ $createButton }}
                </a>
            </div>
        @endif
    </div>
</div>