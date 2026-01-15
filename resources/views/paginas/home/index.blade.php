@extends('layout')
@section('main')
    @vite(['resources/css/paginas/home/index.scss'])
    <nav class="home-nav">
        <div class="container nav-content">
            <div class="logo">
                <i class="fa-solid fa-house-medical"></i>
                <span>SaaS Clínicas</span>
            </div>
            
            <button class="mobile-menu-toggle" id="menuToggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="nav-links" id="navLinks">
                <a href="#funcionalidades">Funcionalidades</a>
                <a href="/login" class="btn-login">Entrar</a>
                <a href="/criar-conta" class="btn-start">Começar Agora</a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container hero-grid">
            <div class="hero-text animate-up">
                <span class="badge-new">✨ Gestão inteligente para sua clínica</span>
                <h1>O controle total da sua clínica <span>em um só lugar.</span></h1>
                <p>Agendamentos, prontuários, financeiro e gestão de equipe. Tudo pensado para você focar no que mais importa: seus pacientes.</p>
                <div class="hero-actions">
                    <a href="/criar-conta" class="btn-primary-large">Experimentar Grátis</a>
                    <a href="#demo" class="btn-secondary-large"><i class="fa-solid fa-play"></i> Ver Demonstração</a>
                </div>
            </div>

            <div class="hero-image animate-fade">
                <div class="image-mockup">
                    <div class="mockup-screen">
                        <div class="mockup-header"></div>
                        <div class="mockup-body">
                            <div class="mockup-line"></div>
                            <div class="mockup-line short"></div>
                            <div class="mockup-grid">
                                <div></div><div></div><div></div>
                            </div>
                        </div>
                    </div>
                    <div class="floating-card finance">
                        <i class="fa-solid fa-chart-line"></i>
                        <div class="card-info">
                            <strong>+24%</strong>
                            <span>Faturamento</span>
                        </div>
                    </div>
                    <div class="floating-card appointment">
                        <i class="fa-solid fa-calendar-check"></i>
                        <div class="card-info">
                            <strong>Agenda</strong>
                            <span>Sincronizada</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="funcionalidades" class="features">
        <div class="container">
            <div class="section-title">
                <h2>Tudo o que você precisa</h2>
                <p>Desenvolvido com tecnologia de ponta para facilitar o dia a dia da sua clínica.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-calendar-day"></i></div>
                    <h3>Agenda Inteligente</h3>
                    <p>Gerencie múltiplos profissionais com lembretes automáticos via WhatsApp.</p>
                </div>
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-user-shield"></i></div>
                    <h3>Segurança de Dados</h3>
                    <p>Dados criptografados e isolamento completo por clínica (Multi-tenancy).</p>
                </div>
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <h3>Financeiro Prático</h3>
                    <p>Controle de caixa, repasses e faturamento TISS sem complicações.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="home-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="logo">
                        <i class="fa-solid fa-house-medical"></i>
                        <span>SaaS Clínicas</span>
                    </div>
                    <p>A plataforma definitiva para clínicas modernas que buscam eficiência e segurança.</p>
                    <div class="social-links">
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h4>Produto</h4>
                    <a href="#funcionalidades">Funcionalidades</a>
                    <a href="#">Planos e Preços</a>
                    <a href="#">Segurança</a>
                </div>

                <div class="footer-links">
                    <h4>Suporte</h4>
                    <a href="#">Central de Ajuda</a>
                    <a href="#">Contato</a>
                    <a href="#">Documentação</a>
                </div>

                <div class="footer-contact">
                    <h4>Fale Conosco</h4>
                    <p><i class="fa-solid fa-envelope"></i> contato@saasclinicas.com.br</p>
                    <p><i class="fa-solid fa-phone"></i> (11) 99999-9999</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 SaaS Clínicas. Todos os direitos reservados.</p>
                <div class="legal">
                    <a href="#">Privacidade</a>
                    <a href="#">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('menuToggle').onclick = function() {
            document.getElementById('navLinks').classList.toggle('active');
        };
    </script>
@endsection