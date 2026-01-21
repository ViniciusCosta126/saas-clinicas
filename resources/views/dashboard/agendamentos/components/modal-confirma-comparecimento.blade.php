<x-modal-global id="confirmaComparecimentoAtendimento" title="Confirmar Ação">
    <p>O paciente compareceu nesta consulta?</p>
    <x-slot:footer>
        <form method="POST" class="acaoAgendamentoForm" data-acao="falta">
            @csrf
            @method('PUT')
            <button class="btn-cancel">Não</button>
        </form>
        
        <form method="POST" class="acaoAgendamentoForm" data-acao="concluir">
            @csrf
            @method('PUT')
            <button class="btn-submit">Sim</button>
        </form>
    </x-slot:footer>
</x-modal-global>