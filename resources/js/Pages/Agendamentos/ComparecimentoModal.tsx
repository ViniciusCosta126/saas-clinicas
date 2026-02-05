import Modal from '@/components/common/ui/Modal/Modal';

interface ComparecimentoModalProps {
    isOpen: boolean;
    title: string;
    message: string;
    onClose: () => void;
    onAction: (type: 'concluir' | 'falta') => void;
    loading?: boolean;
}

export default function ComparecimentoModal({ 
    isOpen, 
    title, 
    message, 
    onClose, 
    onAction,
    loading = false 
}: ComparecimentoModalProps) {
    return (
        <Modal isOpen={isOpen} title={title} onClose={onClose}>
            <div style={{ padding: '16px 0' }}>
                <p style={{ fontSize: '1.05rem', color: '#475569' }}>{message}</p>
            </div>
            
            <div className="form-actions">
                <button 
                    className="btn-cancel" 
                    onClick={onClose} 
                    disabled={loading}
                >
                    Cancelar
                </button>
                <div style={{ display: 'flex', gap: '10px' }}>
                    <button 
                        className="btn-submit btn-danger" 
                        onClick={() => onAction('falta')}
                        disabled={loading}
                    >
                        Não (Falta)
                    </button>
                    <button 
                        className="btn-submit btn-success" 
                        onClick={() => onAction('concluir')}
                        disabled={loading}
                    >
                        Sim (Compareceu)
                    </button>
                </div>
            </div>
        </Modal>
    );
}