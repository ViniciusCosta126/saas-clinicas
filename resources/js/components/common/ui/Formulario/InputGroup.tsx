
interface InputGroupProps {
    label: string;
    icon: string;
    error?: string;
    fullWidth?: boolean;
    children: React.ReactElement
}
export default function InputGroup({ label, icon, error, fullWidth, children }: InputGroupProps) {
    return (
        <div className={`form-group ${fullWidth ? 'full-width' : ''}`}>
            <label>{label}</label>
            <div className={`input-wrapper ${error ? 'input-error' : ''}`}>
                <i className={`fa-solid ${icon}`}></i>
                {children}
            </div>
            {error && <span className="error-message">{error}</span>}
        </div>
    );
}