// Aguarda o DOM estar pronto
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== NOTIFICATIONS.JS CARREGADO ===');
    
    // Função para tentar conectar com retry
    function tryConnect(attempt = 1) {
        console.log(`🔄 Tentativa ${attempt} de conexão...`);
        console.log('Echo disponível?', !!window.Echo);
        console.log('UserId disponível?', !!window.userId);
        console.log('UserId valor:', window.userId);
        
        if (window.Echo && window.userId) {
            console.log(`🎯 Conectando ao canal: App.Models.User.${window.userId}`);
            
            try {
                const channel = window.Echo.private(`App.Models.User.${window.userId}`);
                
                // Debug dos eventos do canal
                channel.subscribed(() => {
                    console.log('✅ Canal privado subscrito com sucesso');
                });
                
                channel.error((error) => {
                    console.error('❌ Erro no canal privado:', error);
                });
                
                // Escutar notificações
                channel.notification((notification) => {
                    console.log("📥 NOTIFICAÇÃO RECEBIDA:", notification);
                    console.log("📥 Tipo da notificação:", typeof notification);
                    console.log("📥 Propriedades:", Object.keys(notification));
                    
                    addNotificationToList(notification);
                    incrementNotificationCount();
                    showNotificationToast(notification.message || 'Nova notificação');
                });
                
                // Escutar evento específico também (caso o .notification não funcione)
                channel.listen('.notification', (data) => {
                    console.log("📥 EVENTO .notification RECEBIDO:", data);
                    addNotificationToList(data);
                    incrementNotificationCount();
                    showNotificationToast(data.message || 'Nova notificação');
                });
                
                console.log('✅ Configuração do canal concluída');
                
            } catch (error) {
                console.error('❌ Erro ao configurar canal:', error);
            }
        } else {
            console.error('❌ Echo ou userId não disponível');
            
            if (attempt < 10) {
                setTimeout(() => tryConnect(attempt + 1), 1000);
            }
        }
    }

    setTimeout(() => tryConnect(), 1000);
});

// Suas funções aqui (fora do DOMContentLoaded)
function incrementNotificationCount() {
    let badge = document.getElementById('notification-count');
    
    if (!badge) {
        // Se o badge não existe, cria um novo
        const bellIcon = document.querySelector('#notificationDropdown i.bi-bell');
        if (bellIcon && bellIcon.parentElement) {
            badge = document.createElement('span');
            badge.id = 'notification-count';
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
            badge.textContent = '1';
            badge.style.display = 'inline-block';
            bellIcon.parentElement.appendChild(badge);
            console.log('✅ Badge criado com contador: 1');
            return;
        }
    }

    // Se o badge já existe, incrementa
    let count = parseInt(badge.textContent) || 0;
    count += 1;
    badge.textContent = count;
    badge.style.display = 'inline-block';
    console.log('✅ Badge incrementado para:', count);
}

function addNotificationToList(notification) {
    try {
        const list = document.getElementById('notification-list');
        if (!list) {
            console.error('Elemento notification-list não encontrado');
            return;
        }

        //console.log('📝 Adicionando notificação:', notification);
        //console.log('📝 Estrutura atual do list:', list.innerHTML);

        // Remove mensagem de "nenhuma notificação" se existir
        const emptyItem = list.querySelector('.text-muted');
        if (emptyItem && emptyItem.textContent.includes('Nenhuma notificação')) {
            emptyItem.parentElement.remove();
        }

        // Cria o novo item
        const newItem = document.createElement('li');
        newItem.innerHTML = `
            <a class="dropdown-item" href="${notification.url ?? '#'}">
                <i class="bi bi-bell-fill text-info me-2"></i>
                ${notification.message ?? 'Nova notificação'}
            </a>
        `;

        // Procura pelo li que contém o divisor
        const dividerLi = Array.from(list.children).find(li => 
            li.querySelector('hr.dropdown-divider')
        );
        
        if (dividerLi) {
            // Insere antes do li que contém o divisor
            list.insertBefore(newItem, dividerLi);
            console.log('✅ Notificação inserida antes do divisor');
        } else {
            // Procura pelo li que contém o link "Ver todas"
            const viewAllLi = Array.from(list.children).find(li => 
                li.querySelector('a[href*="notifications"]')
            );
            
            if (viewAllLi) {
                list.insertBefore(newItem, viewAllLi);
                console.log('✅ Notificação inserida antes do "Ver todas"');
            } else {
                // Como último recurso, adiciona no final
                list.appendChild(newItem);
                console.log('✅ Notificação adicionada no final');
            }
        }
        
        console.log('✅ Notificação adicionada à lista com sucesso');
    } catch (error) {
        console.error('❌ Erro ao adicionar notificação:', error);
        console.error('❌ Stack trace:', error.stack);
    }
}

function showNotificationToast(message) {
    try {
        console.log("🔔 Tentando mostrar toast com mensagem:", message);

        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        
        toastContainer.innerHTML = `
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-bell-fill text-info me-2"></i>
                    <strong class="me-auto">Nova Notificação</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;

        document.body.appendChild(toastContainer);

        const toastEl = toastContainer.querySelector('.toast');
        const bsToast = new bootstrap.Toast(toastEl);
        bsToast.show();

        console.log("✅ Toast criado e mostrado");

        setTimeout(() => {
            toastContainer.remove();
        }, 5000);

    } catch (error) {
        console.error("❌ Erro ao mostrar toast:", error);
    }
}
