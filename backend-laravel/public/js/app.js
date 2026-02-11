// Global App JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    initializeTooltips();

    // Inicializar tooltips
    initializeTooltips();

    // Handle responsive sidebar
    handleSidebar();

    // Manipular barra lateral responsiva
    handleSidebar();
});

function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Você pode adicionar uma tooltip customizada aqui se desejar
        });
    });
}

function handleSidebar() {
    // Adicionar lógica de sidebar se necessário
}

// Helper function para formatar datas
// Função auxiliar para formatar datas
function formatDate(date) {
    return new Date(date).toLocaleDateString('pt-BR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

// Helper function para formatar horas
// Função auxiliar para formatar horas
function formatTime(date) {
    return new Date(date).toLocaleTimeString('pt-BR', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

// CSRF Token para requisições AJAX
// Token CSRF para requisições AJAX
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content;
}

// Fazer requisições AJAX com CSRF
// Fazer requisições AJAX com token CSRF
function makeRequest(url, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
        }
    };

    if (data) {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(data);
    }

    return fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            throw error;
        });
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
