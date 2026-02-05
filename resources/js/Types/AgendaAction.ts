export interface AgendaActionConfig {
    title: string;
    message: string;
    routeName: string;
    method: 'put' | 'post' | 'delete';
    variant: 'danger' | 'success' | 'primary';
    confirmText?: string;
}