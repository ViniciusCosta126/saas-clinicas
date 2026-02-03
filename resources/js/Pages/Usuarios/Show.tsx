import { useForm, usePage } from '@inertiajs/react'
import DashboardLayout from '../../Layouts/DashboardLayout'
import PageHeader from '@/components/common/PageHeader'
import { IPageProps } from '@/Types/PageProps'
import '../../../css/dashboard/meu-perfil/index.scss'
import { FormEvent } from 'react'
import { route } from 'ziggy-js'
import FormTemplate from '@/components/common/FormTemplate'
import { getFirstLetter } from '@/utils/format'
export default function Show() {
    const { auth } = usePage<IPageProps>().props
    const user = auth.user

    const { data: profile, setData: setProfile, put: updateProfile, processing: processingProfile, errors: profileErrors } = useForm({
        name: user.name ?? '',
        email: user.email ?? '',
        telefone: user.telefone ?? '',
        cpf: user.cpf ?? ''
    })

    const { data: passwordData, setData: setPassword, put: updatePassword, processing: processingPassword, errors: passwordErrors } = useForm({
        password: '',
        password_confirmation: ''
    })

    function handleSubmitProfile(e: FormEvent) {
        e.preventDefault();
        updateProfile(route('update-meu-perfil'));
    }

    function handleSubmitPassword(e:FormEvent){
        e.preventDefault();
        updatePassword(route('update-senha'))
    }
    return (
        <DashboardLayout>
            <PageHeader titulo='Meu Perfil' subtitulo='Gerencie suas informações pessoais e de segurança.' />
            <div className="profile-grid">
                <div className="profile-card profile-sidebar">
                    <div className="profile-avatar-wrapper">
                        <img src={`https://placehold.co/80x80?text=${getFirstLetter(user.name)}`} alt="Foto de Perfil" className="user-avatar" />
                        <button className="btn-change-photo"><i className="fa-solid fa-camera"></i></button>
                    </div>
                    <div className="profile-bio">
                        <h3>{user.name}</h3>
                        <span>{user.role}</span>
                        <p className="clinic-tag"><i className="fa-solid fa-hospital"></i>
                            {auth.clinica?.nome_clinica ?? 'Sem Nome'}</p>
                    </div>
                </div>

                <div className="profile-content">
                    <div className="profile-card">
                        <div className="card-header">
                            <h4><i className="fa-solid fa-user-gear"></i> Dados Pessoais</h4>
                        </div>

                        <FormTemplate onSubmit={handleSubmitProfile}>
                            <div className="form-grid">
                                <div className="form-group">
                                    <label>Nome Completo</label>
                                    <div className={`input-wrapper ${profileErrors.name ? "input-error" : ""}`}>
                                        <i className="fa-solid fa-user-tie"></i>
                                        <input type="text" name="name" value={profile.name} onChange={(e) => setProfile("name", e.target.value)} />
                                    </div>
                                    {profileErrors.name && (
                                        <span className="error-message">{profileErrors.name}</span>
                                    )}
                                </div>

                                <div className="form-group">
                                    <label>E-mail</label>
                                    <div className={`input-wrapper ${profileErrors.email ? 'input-error' : ''}`}>
                                        <i className="fa-solid fa-envelope"></i>
                                        <input type="email" name="email" value={profile.email} onChange={(e) => setProfile('email', e.target.value)} />
                                    </div>
                                    {profileErrors.email && (
                                        <span className="error-message">{profileErrors.email}</span>
                                    )}
                                </div>

                                <div className="form-group">
                                    <label>Telefone</label>
                                    <div className={`input-wrapper ${profileErrors.telefone ? 'input-error' : ''}`}>
                                        <i className="fa-solid fa-phone"></i>
                                        <input type="text" name="telefone" placeholder="(11) 99999-9999"
                                            value={profile.telefone} onChange={(e) => setProfile('telefone', e.target.value)} />
                                    </div>
                                    {profileErrors.telefone && (
                                        <span className="error-message">{profileErrors.telefone}</span>
                                    )}
                                </div>

                                <div className="form-group">
                                    <label>CPF</label>
                                    <div className={`input-wrapper ${profileErrors.cpf ? 'input-error' : ''}`}>
                                        <i className="fa-solid fa-address-card"></i>
                                        <input type="text" name="cpf" placeholder="000.000.000-00"
                                            value={profile.cpf} onChange={(e) => setProfile('cpf', e.target.value)} />
                                    </div>
                                    {profileErrors.cpf && (
                                        <span className="error-message">{profileErrors.cpf}</span>
                                    )}
                                </div>
                            </div>

                            <div className="form-actions">
                                <button disabled={processingProfile} className="btn-submit">
                                    <i className="fa-solid fa-check"></i>
                                    {processingProfile ? "Salvando..." : "Salvar Alterações"}
                                </button>
                            </div>
                        </FormTemplate>
                    </div>

                    <div className="profile-card mt-4">
                        <div className="card-header">
                            <h4><i className="fa-solid fa-lock"></i> Segurança</h4>
                        </div>

                        <FormTemplate onSubmit={handleSubmitPassword}>
                            <div className="form-grid">
                                <div className="form-group">
                                    <label>Nova senha</label>
                                    <div className={`input-wrapper ${passwordErrors.password ? "input-error" : ""}`}>
                                        <i className="fa-solid fa-lock"></i>
                                        <input placeholder='Digite sua nova senha' type="password" name="name" value={passwordData.password} onChange={(e) => setPassword("password", e.target.value)} />
                                    </div>
                                    {passwordErrors.password && (
                                        <span className="error-message">{passwordErrors.password}</span>
                                    )}
                                </div>
                                <div className="form-group">
                                    <label>Confirmar nova senha</label>
                                    <div className={`input-wrapper ${passwordErrors.password_confirmation ? "input-error" : ""}`}>
                                        <i className="fa-solid fa-lock"></i>
                                        <input placeholder='Confirme sua nova senha' type="password" name="name" value={passwordData.password_confirmation} onChange={(e) => setPassword("password_confirmation", e.target.value)} />
                                    </div>
                                    {passwordErrors.password_confirmation && (
                                        <span className="error-message">{passwordErrors.password_confirmation}</span>
                                    )}
                                </div>
                            </div>
                            <div className="form-actions">
                                <button disabled={processingPassword} className="btn-submit">
                                    <i className="fa-solid fa-check"></i>
                                    {processingPassword ? "Salvando..." : "Salvar Alterações"}
                                </button>
                            </div>
                        </FormTemplate>
                    </div>
                </div>
            </div>
        </DashboardLayout>
    )
}