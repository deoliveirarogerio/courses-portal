@extends('web._theme')

@section('title', 'Contato - Portal de Cursos')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Entre em Contato</h1>
                <p class="lead text-muted">Estamos aqui para ajudar você. Entre em contato conosco através dos canais abaixo.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Envie sua Mensagem</h3>
                    </div>
                    <div class="card-body">
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">Nome *</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Sobrenome *</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telefone</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Assunto *</label>
                                <select class="form-select" id="subject" required>
                                    <option value="">Selecione um assunto</option>
                                    <option value="informacoes">Informações sobre cursos</option>
                                    <option value="inscricao">Dúvidas sobre inscrição</option>
                                    <option value="pagamento">Problemas com pagamento</option>
                                    <option value="tecnico">Suporte técnico</option>
                                    <option value="parceria">Parcerias</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensagem *</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Descreva sua dúvida ou solicitação..." required></textarea>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Desejo receber novidades e promoções por e-mail
                                </label>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Enviar Mensagem
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4">
                <!-- Contact Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informações de Contato</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-envelope text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">E-mail</h6>
                                    <small class="text-muted">contato@portaldecursos.com</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-telephone text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Telefone</h6>
                                    <small class="text-muted">(11) 9999-9999</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-whatsapp text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">WhatsApp</h6>
                                    <small class="text-muted">(11) 99999-9999</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-geo-alt text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Endereço</h6>
                                    <small class="text-muted">São Paulo, SP - Brasil</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Business Hours -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Horário de Atendimento</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Segunda - Sexta</span>
                            <span class="text-muted">8h às 18h</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sábado</span>
                            <span class="text-muted">9h às 14h</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Domingo</span>
                            <span class="text-muted">Fechado</span>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Redes Sociais</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-5">Perguntas Frequentes</h2>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Como posso me inscrever em um curso?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Para se inscrever em um curso, basta acessar a página do curso desejado e clicar no botão "Inscrever-se". Você será direcionado para o formulário de inscrição onde deverá preencher seus dados pessoais e escolher a forma de pagamento.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Quais são as formas de pagamento aceitas?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aceitamos pagamento via cartão de crédito (Visa, Mastercard, Elo), cartão de débito, PIX e boleto bancário. Para pagamentos parcelados, consulte as condições específicas de cada curso.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Os cursos oferecem certificado?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim! Todos os nossos cursos oferecem certificado de conclusão. O certificado é emitido automaticamente após a conclusão de todas as atividades e avaliações do curso.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Posso acessar o curso quantas vezes quiser?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim! Uma vez inscrito, você terá acesso vitalício ao conteúdo do curso. Poderá assistir às aulas quantas vezes desejar e no seu próprio ritmo.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Como funciona o suporte aos estudantes?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oferecemos suporte completo através de chat online, e-mail e WhatsApp. Nossa equipe está disponível de segunda a sexta das 8h às 18h, e aos sábados das 9h às 14h para esclarecer suas dúvidas.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="text-success mb-3">
                    <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Mensagem Enviada!</h4>
                <p class="text-muted mb-4">Obrigado pelo seu contato. Responderemos em breve!</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulate form submission
        setTimeout(() => {
            contactForm.reset();
            successModal.show();
        }, 1000);
    });
});
</script>
@endsection