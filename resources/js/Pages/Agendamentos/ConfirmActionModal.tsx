import Modal from '@/components/common/ui/Modal/Modal';

interface ConfirmActionModalProps {
    isOpen: boolean;
    title: string;
    message: string;
    onClose: () => void;
    onConfirm: () => void;
    loading?: boolean;
    confirmText?: string;
    variant?: 'danger' | 'success' | 'primary';
}

export default function ConfirmActionModal({
    isOpen,
    title,
    message,
    onClose,
    onConfirm,
    loading = false,
    confirmText = "Confirmar",
    variant = 'primary'
}: ConfirmActionModalProps) {
    
    const variantClass = {
        danger: 'btn-danger',
        success: 'btn-submit',
        primary: 'btn-primary'
    }[variant];
    
    return (
        <Modal isOpen={isOpen} title={title} onClose={onClose}>
            <div style={{ padding: '15px 0' }}>
                <p style={{ fontSize: '1.05rem', color: '#475569' }}>{message}</p>
            </div>
            
            <div className="form-actions" style={{ display: 'flex', justifyContent: 'flex-end', gap: '10px', marginTop: '20px' }}>
                <button className="btn-cancel" onClick={onClose} disabled={loading}>
                    Cancelar
                </button>
                <button className={`btn-submit ${variantClass}`} onClick={onConfirm} disabled={loading}>
                    {loading ? (
                        <><i className="fa-solid fa-spinner fa-spin"></i> Processando...</>
                    ) : (
                        confirmText
                    )}
                </button>
            </div>
        </Modal>
    );
}