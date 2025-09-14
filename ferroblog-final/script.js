document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidades que aún son necesarias en el frontend
    initializeMobileMenu();
    initializeSearch(); // La búsqueda en tiempo real sigue siendo útil
    initializeCalendar();
    
    // Aplicar configuración del autor (si se sigue usando config.js para ello)
    // applyAuthorConfig(); 
});

// ==================================================================================
// MENÚ MÓVIL
// ==================================================================================

function initializeMobileMenu() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
        });
    }
}

// ==================================================================================
// SISTEMA DE BÚSQUEDA (SE MANTIENE, YA QUE ES UNA BÚSQUEDA VISUAL EN LA PÁGINA)
// ==================================================================================
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    if (searchInput && searchResults) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const posts = document.querySelectorAll('.post, .noticia-article');
            
            if (query.length < 2) {
                searchResults.innerHTML = '';
                return;
            }
            
            let results = [];
            posts.forEach(post => {
                const title = post.querySelector('h4, h2, h3')?.textContent.toLowerCase() || '';
                const content = post.textContent.toLowerCase();
                
                if (title.includes(query) || content.includes(query)) {
                    results.push({
                        title: post.querySelector('h4, h2, h3')?.textContent || 'Sin título',
                        link: post.querySelector('a')?.href || '#',
                        excerpt: post.querySelector('p')?.textContent?.substring(0, 100) + '...' || ''
                    });
                }
            });
            
            if (results.length > 0) {
                searchResults.innerHTML = results.map(result => `
                    <div class="search-result">
                        <h4><a href="${result.link}">${result.title}</a></h4>
                        <p>${result.excerpt}</p>
                    </div>
                `).join('');
            } else {
                searchResults.innerHTML = '<p>No se encontraron resultados.</p>';
            }
        });
    }
}

// ==================================================================================
// CALENDARIO FERROVIARIO (SE MANTIENE, AUNQUE DEPENDE DE LOCALSTORAGE)
// ==================================================================================

function initializeCalendar() {
    const calendarContainer = document.querySelector('.railway-calendar');
    
    if (calendarContainer) {
        // Crear calendario básico
        const today = new Date();
        const month = today.getMonth();
        const year = today.getFullYear();
        
        const monthNames = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        
        calendarContainer.innerHTML = `
            <h3>📅 Calendario Ferroviario</h3>
            <div class="calendar-header">
                <h4>${monthNames[month]} ${year}</h4>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day">L</div>
                <div class="calendar-day">M</div>
                <div class="calendar-day">X</div>
                <div class="calendar-day">J</div>
                <div class="calendar-day">V</div>
                <div class="calendar-day">S</div>
                <div class="calendar-day">D</div>
                ${generateCalendarDays(month, year)}
            </div>
        `;
    }
}

function generateCalendarDays(month, year) {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay();
    
    let days = '';
    
    // Días vacíos al inicio
    for (let i = 0; i < startingDay; i++) {
        days += '<div class="calendar-day empty"></div>';
    }
    
    // Días del mes
    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = day === new Date().getDate();
        days += `<div class="calendar-day ${isToday ? 'today' : ''}">${day}</div>`;
    }
    
    return days;
}

// ==================================================================================
// FUNCIONES AUXILIARES
// ==================================================================================

// Función para hacer desplegables las secciones del filtrador
function toggleCategorySection(sectionName) {
    const section = document.getElementById(sectionName + '-section');
    const toggle = event.target.closest('.section-header');
    
    if (section && toggle) {
        const isVisible = section.classList.contains('show');
        
        if (isVisible) {
            section.classList.remove('show');
            toggle.querySelector('.toggle-icon').textContent = '▼';
        } else {
            section.classList.add('show');
            toggle.querySelector('.toggle-icon').textContent = '▲';
        }
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}