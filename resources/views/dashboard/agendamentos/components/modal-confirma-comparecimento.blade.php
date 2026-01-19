<x-modal-global id="confirmaComparecimentoAtendimento" title="Confirmar Ação">
    <p>O paciente compareceu nesta consulta?</p>
    <x-slot:footer>
        <form action="" method="POST" class="confirmaComparecimentoAtendimentoForm">
            @csrf
            @method('PUT')
            <input type="text" hidden value="nao_compareceu" name="status">
            <button class="btn-cancel">Não</button>
        </form>
        <form action="" method="POST" class="confirmaComparecimentoAtendimentoForm">
            @csrf
            @method('PUT')
            <input type="text" hidden value="concluído" name="status">
            <button class="btn-submit">Sim</button>
        </form>
    </x-slot:footer>
</x-modal-global>