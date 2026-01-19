<x-modal-global id="confirmaPresencaAtendimento" title="Confirmar Ação">
    <p>Confirmar presença do paciente nesta consulta?</p>
    <x-slot:footer>
        <button class="btn-cancel" onclick="closeModal('confirmaPresencaAtendimento')">Cancelar</button>
        <form action="" method="POST" id="confirmaPresencaAtendimentoForm">
            @csrf
            @method('PUT')
            <input type="text" hidden value="confirmado" name="status">
            <button class="btn-submit">Confirmar</button>
        </form>
    </x-slot:footer>
</x-modal-global>