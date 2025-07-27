<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado - {{ $certificate->student->name ?? 'João Silva' }} - Portal de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .certificate-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .certificate {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            padding: 50px 70px 80px 70px; /* Aumentado padding inferior */
            position: relative;
            overflow: hidden;
            aspect-ratio: 4/3;
            min-height: 700px; /* Altura mínima para garantir espaço */
        }

        .certificate::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
        }

        .certificate::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
        }

        .certificate-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 3px solid #f8f9fa;
            border-radius: 15px;
            pointer-events: none;
        }

        .certificate-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: space-between;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .certificate-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 300;
            letter-spacing: 1px;
        }

        .certificate-body {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-bottom: 30px;
        }

        .certifies-text {
            font-size: 1.1rem;
            color: #495057;
            margin-bottom: 20px;
        }

        .student-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #212529;
            margin: 25px 0;
            position: relative;
        }

        .student-name::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .course-completion {
            font-size: 1.1rem;
            color: #495057;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .course-name {
            font-weight: 600;
            color: #212529;
            font-size: 1.3rem;
        }

        .certificate-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin: 30px 0;
        }

        .detail-section {
            text-align: center;
        }

        .detail-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #212529;
            font-weight: 600;
        }

        .certificate-footer {
            margin-top: auto;
            position: relative;
            padding-bottom: 10px; /* Espaço para elementos absolutos */
        }

        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 40px;
        }

        .signature {
            text-align: center;
        }

        .signature-line {
            width: 180px;
            height: 2px;
            background: #dee2e6;
            margin: 20px auto 10px;
        }

        .signature-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        .signature-title {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .certificate-seal {
            position: absolute;
            bottom: 60px;
            right: -10px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            z-index: 10;
        }

        .verification-info {
            position: absolute;
            bottom: 25px;
            left: 50px;
            font-size: 0.75rem;
            color: #6c757d;
            line-height: 1.4;
            z-index: 10;
        }

        .verification-code {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #495057;
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
                margin: 0;
                padding: 0;
            }

            .certificate-container {
                max-width: none;
                padding: 0;
            }

            .certificate {
                box-shadow: none;
                border-radius: 0;
                margin: 0;
                page-break-inside: avoid;
                min-height: auto;
                aspect-ratio: auto;
                height: 100vh;
            }

            .btn, .no-print {
                display: none !important;
            }

            .certificate-seal {
                bottom: 40px;
                right: 60px;
            }

            .verification-info {
                bottom: 40px;
                left: 60px;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .certificate {
                padding: 30px 25px 60px 25px;
                aspect-ratio: auto;
                min-height: 600px;
            }

            .certificate-title {
                font-size: 2.2rem;
            }

            .student-name {
                font-size: 1.8rem;
            }

            .certificate-details {
                grid-template-columns: 1fr;
                gap: 20px;
                margin: 20px 0;
            }

            .signature-section {
                grid-template-columns: 1fr;
                gap: 30px;
                margin-bottom: 80px;
            }

            .signature-line {
                width: 150px;
            }

            .certificate-seal {
                position: static;
                margin: 20px auto 0;
                width: 80px;
                height: 80px;
                font-size: 1.5rem;
            }

            .verification-info {
                position: static;
                text-align: center;
                margin-top: 20px;
                font-size: 0.7rem;
            }

            .certificate-footer {
                padding-bottom: 0;
            }
        }

        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }

        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
            padding: 10px 28px;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Action Buttons -->
        <div class="action-buttons no-print">
            <a href="{{ route('student.certificates') }}" class="btn-outline-custom">
                <i class="bi bi-arrow-left me-2"></i>Voltar aos Certificados
            </a>
            <button onclick="window.print()" class="btn-custom">
                <i class="bi bi-printer me-2"></i>Imprimir Certificado
            </button>
            <a href="{{ route('student.certificates.download', $certificate->id ?? 1) }}" class="btn-custom">
                <i class="bi bi-download me-2"></i>Baixar PDF
            </a>
        </div>

        <!-- Certificate -->
        <div class="certificate">
            <div class="certificate-border"></div>

            <div class="certificate-content">
                <!-- Header -->
                <div class="certificate-header">
                    <h1 class="certificate-title">CERTIFICADO</h1>
                    <p class="certificate-subtitle">DE CONCLUSÃO DE CURSO</p>
                </div>

                <!-- Body -->
                <div class="certificate-body">
                    <p class="certifies-text">
                        O <strong>Portal de Cursos</strong> certifica que
                    </p>

                    <h2 class="student-name">{{ $certificate->student->name ?? 'João Silva Santos' }}</h2>

                    <div class="course-completion">
                        concluiu com êxito o curso
                        <br>
                        <span class="course-name">{{ $certificate->course->title ?? 'Desenvolvimento Web Completo com PHP e Laravel' }}</span>
                    </div>

                    <p class="course-completion">
                        com carga horária de <strong>{{ $certificate->course->duration ?? '120' }} horas</strong>,
                        realizado no período de {{ $certificate->start_date ? $certificate->start_date->format('d/m/Y') : '15/01/2024' }}
                        a {{ $certificate->completion_date ? $certificate->completion_date->format('d/m/Y') : '15/07/2024' }}.
                    </p>

                    <!-- Details -->
                    <div class="certificate-details">
                        <div class="detail-section">
                            <div class="detail-label">Data de Conclusão</div>
                            <div class="detail-value">{{ $certificate->completion_date ? $certificate->completion_date->format('d/m/Y') : '15 de Julho de 2024' }}</div>
                        </div>
                        <div class="detail-section">
                            <div class="detail-label">Nota Final</div>
                            <div class="detail-value">{{ $certificate->final_grade ?? '9,5' }}/10</div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="certificate-footer">
                    <!-- Signatures -->
                    <div class="signature-section">
                        <div class="signature">
                            <div class="signature-line"></div>
                            <div class="signature-name">{{ $certificate->course->instructor->name ?? 'Prof. Maria Silva' }}</div>
                            <div class="signature-title">Instrutor(a) do Curso</div>
                        </div>
                        <div class="signature">
                            <div class="signature-line"></div>
                            <div class="signature-name">Portal de Cursos</div>
                            <div class="signature-title">Coordenação Acadêmica</div>
                        </div>
                    </div>

                    <!-- Seal -->
                    <div class="certificate-seal">
                        <i class="bi bi-award-fill"></i>
                    </div>

                    <!-- Verification Info -->
                    <div class="verification-info">
                        <div>Código de Verificação: <span class="verification-code">{{ $certificate->verification_code ?? 'PC' . strtoupper(Str::random(8)) }}</span></div>
                        <div>Validar em: portaldecursos.com/verificar</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-4 no-print">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-shield-check me-2"></i>
                        Certificado Válido
                    </h5>
                    <p class="card-text text-muted mb-3">
                        Este certificado possui validade nacional e pode ser verificado através do código acima.
                    </p>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <i class="bi bi-calendar-check display-6 text-success"></i>
                                <div class="mt-2">
                                    <strong>Data de Emissão</strong>
                                    <br>
                                    <small class="text-muted">{{ $certificate->issued_at ? $certificate->issued_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <i class="bi bi-clock display-6 text-info"></i>
                                <div class="mt-2">
                                    <strong>Carga Horária</strong>
                                    <br>
                                    <small class="text-muted">{{ $certificate->course->duration ?? '120' }} horas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <i class="bi bi-trophy display-6 text-warning"></i>
                                <div class="mt-2">
                                    <strong>Aproveitamento</strong>
                                    <br>
                                    <small class="text-muted">{{ $certificate->final_grade ?? '95' }}% de aproveitamento</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="https://portaldecursos.com/verificar/{{ $certificate->verification_code ?? 'demo' }}"
                           class="btn btn-outline-primary btn-sm"
                           target="_blank">
                            <i class="bi bi-link-45deg me-1"></i>
                            Verificar Autenticidade
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Animate certificate on load
            const certificate = document.querySelector('.certificate');
            certificate.style.opacity = '0';
            certificate.style.transform = 'scale(0.9) translateY(20px)';

            setTimeout(() => {
                certificate.style.transition = 'all 0.8s ease';
                certificate.style.opacity = '1';
                certificate.style.transform = 'scale(1) translateY(0)';
            }, 100);

            // Print optimization
            window.addEventListener('beforeprint', function() {
                document.body.style.background = 'white';
            });

            window.addEventListener('afterprint', function() {
                document.body.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            });
        });

        // Share certificate function
        function shareCertificate() {
            if (navigator.share) {
                navigator.share({
                    title: 'Meu Certificado - Portal de Cursos',
                    text: 'Acabei de concluir o curso {{ $certificate->course->title ?? "Desenvolvimento Web" }} no Portal de Cursos!',
                    url: window.location.href
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link do certificado copiado para a área de transferência!');
                });
            }
        }
    </script>
</body>
</html>
