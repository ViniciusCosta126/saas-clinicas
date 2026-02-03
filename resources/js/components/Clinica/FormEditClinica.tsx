import { Link, useForm } from "@inertiajs/react";
import { IClinica } from "../../Types/Clinica";
import FormTemplate from "../common/FormTemplate";
import { route } from 'ziggy-js';

type Props = {
    clinica: IClinica
}

export default function FormEditClinica({ clinica }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        nome_clinica: clinica.nome_clinica,
        nome_responsavel: clinica.nome_responsavel,
        telefone: clinica.telefone,
        preco_min_consulta: clinica.preco_min_consulta,
        preco_max_consulta: clinica.preco_max_consulta,
        email: clinica.email
    })

    function submit(e: React.FormEvent) {
        e.preventDefault();
        put(route("clinica.update", clinica.id));
    }

    return (
        <FormTemplate onSubmit={submit}>
            <div className="form-grid">
                <div className="form-group full-width">
                    <label>Nome da Clínica</label>
                    <div className={`input-wrapper ${errors.nome_clinica ? "input-error" : ""}`}>
                        <i className="fa-solid fa-hospital"></i>
                        <input
                            value={data.nome_clinica}
                            onChange={e => setData("nome_clinica", e.target.value)}
                        />
                    </div>
                    {errors.nome_clinica && (
                        <span className="error-message">{errors.nome_clinica}</span>
                    )}
                </div>

                <div className="form-group">
                    <label>Responsável Técnico</label>
                    <div className={`input-wrapper ${errors.nome_responsavel ? "input-error" : ""}`}>
                        <i className="fa-solid fa-user-tie"></i>
                        <input
                            value={data.nome_responsavel}
                            onChange={e => setData("nome_responsavel", e.target.value)}
                        />
                    </div>
                    {errors.nome_responsavel && (
                        <span className="error-message">{errors.nome_responsavel}</span>
                    )}
                </div>

                <div className="form-group">
                    <label>Telefone</label>
                    <div className={`input-wrapper ${errors.telefone ? "input-error" : ""}`}>
                        <i className="fa-solid fa-phone"></i>
                        <input
                            maxLength={11}
                            value={data.telefone ?? ''}
                            onChange={e => setData("telefone", e.target.value)}
                        />
                    </div>
                    {errors.telefone && (
                        <span className="error-message">{errors.telefone}</span>
                    )}
                </div>

                <div className="form-group">
                    <label>Preço mínimo</label>
                    <div className={`input-wrapper ${errors.preco_min_consulta ? "input-error" : ""}`}>
                        <i className="fa-solid fa-dollar"></i>
                        <input
                            type="number"
                            step="0.01"
                            value={data.preco_min_consulta}
                            onChange={e => setData("preco_min_consulta", parseFloat(e.target.value))}
                        />
                    </div>
                    {errors.preco_min_consulta && (
                        <span className="error-message">{errors.preco_min_consulta}</span>
                    )}
                </div>

                <div className="form-group">
                    <label>Preço máximo</label>
                    <div className={`input-wrapper ${errors.preco_max_consulta ? "input-error" : ""}`}>
                        <i className="fa-solid fa-dollar"></i>
                        <input
                            type="number"
                            step="0.01"
                            value={data.preco_max_consulta}
                            onChange={e => setData("preco_max_consulta", parseFloat(e.target.value))}
                        />
                    </div>
                    {errors.preco_max_consulta && (
                        <span className="error-message">{errors.preco_max_consulta}</span>
                    )}
                </div>

                <div className="form-group full-width">
                    <label>Email</label>
                    <div className={`input-wrapper ${errors.email ? "input-error" : ""}`}>
                        <i className="fa-solid fa-envelope"></i>
                        <input
                            type="email"
                            value={data.email}
                            onChange={e => setData("email", e.target.value)}
                        />
                    </div>
                    {errors.email && (
                        <span className="error-message">{errors.email}</span>
                    )}
                </div>
            </div>

            <div className="form-actions">
                <button disabled={processing} className="btn-submit">
                    <i className="fa-solid fa-check"></i>
                    {processing ? "Salvando..." : "Salvar Alterações"}
                </button>
            </div>
        </FormTemplate>
    )
}