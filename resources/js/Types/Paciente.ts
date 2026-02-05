import { IClinica } from "./Clinica";

export interface IPaciente {
    id: number;
    nome: string;
    email: string;
    aniversario:string;
    telefone: string;
    clinica: IClinica;
    created_at: string
}