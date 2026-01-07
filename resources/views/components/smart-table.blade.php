@props(['headers', 'items', 'id' => 'smartTable'])
@vite(['resources/css/components/smart-table.scss'])
<div class="table-container">
    <div class="table-header-actions" style="padding: 20px; display: flex; justify-content: flex-end;">
        <div class="search-input-wrapper" style="position: relative; width: 300px;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 12px; color: #94a3b8;"></i>
            <input type="text" 
                   id="{{ $id }}Search" 
                   placeholder="Filtrar nesta página..." 
                   onkeyup="filterTable('{{ $id }}')"
                   style="width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="custom-table" id="{{ $id }}">
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th class="{{ $header == 'Ações' ? 'text-center' : '' }}">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
                
                <tr id="{{ $id }}Empty" style="display: none;">
                    <td colspan="{{ count($headers) }}" class="text-center" style="padding: 40px; color: #94a3b8;">
                        Nenhum resultado encontrado para o filtro.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterTable(tableId) {
        const input = document.getElementById(tableId + 'Search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById(tableId);
        const rows = table.querySelector('tbody').querySelectorAll('tr:not(#text-center)'); 
        const emptyMsg = document.getElementById(tableId + 'Empty');
        let totalVisible = 0;

        rows.forEach(row => {
            if (row === emptyMsg) return;
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(filter);
            row.style.display = isVisible ? "" : "none";
            if (isVisible) totalVisible++;
        });

        emptyMsg.style.display = (totalVisible === 0 && filter !== "") ? "" : "none";
    }
</script>