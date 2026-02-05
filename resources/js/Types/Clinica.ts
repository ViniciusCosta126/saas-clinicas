export interface IClinica {
    id: number;
    nome_clinica: string;
    nome_responsavel: string;
    telefone: string | null;
    email: string;
    preco_min_consulta: number;
    preco_max_consulta: number;
    created_at:string
}