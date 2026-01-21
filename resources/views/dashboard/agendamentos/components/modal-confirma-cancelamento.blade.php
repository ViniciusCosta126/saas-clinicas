<x-modal-global id="cancelaAtendimento" title="Confirmar Ação">
    <p>Tem certeza que deseja cancelar este atendimento? Esta ação não pode ser desfeita.</p>
    <x-slot:footer>
        <button class="btn-cancel" onclick="closeModal('cancelaAtendimento')">Cancelar</button>
        <form action="" method="POST" id="cancelaAtendimentoForm">
            @csrf
            @method('DELETE')
            <input type="text" hidden value="cancelado" name="status">
            <button class="btn-submit">Confirmar</button>
        </form>
    </x-slot:footer>
</x-modal-global>