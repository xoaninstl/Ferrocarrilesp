document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todas las funcionalidades del frontend
    initializeMobileMenu();
    initializeSearch(); 
    initializeCalendar(); 
    initializeSidebarToggles();
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
// BÚSQUEDA VISUAL (RESTAURADA)
// ==================================================================================
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) return;

    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        // Esta es una búsqueda visual simple, busca en el texto visible de la página
        const allTextElements = document.querySelectorAll('h1, h2, h3, h4, p, a, li');
        let results = [];
        allTextElements.forEach(el => {
            if (el.textContent.toLowerCase().includes(query)) {
                // Evitar duplicados y elementos muy cortos
                if (!results.some(r => r.text.startsWith(el.textContent.substring(0, 30)))) {
                    results.push({
                        text: el.textContent,
                        element: el
                    });
                }
            }
        });
        displaySearchResults(results.slice(0, 8), query); // Limitar a 8 resultados
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            searchResults.style.display = 'none';
        }
    });
}

function displaySearchResults(results, query) {
    const searchResults = document.getElementById('searchResults');
    if (results.length === 0) {
        searchResults.innerHTML = '<div class="no-results">No se encontraron resultados</div>';
        searchResults.style.display = 'block';
        return;
    }
    const resultsHTML = results.map(result => {
        // Generar un ID si el elemento no lo tiene
        if (!result.element.id) {
            result.element.id = 'search-result-' + Math.random().toString(36).substr(2, 9);
        }
        return `
            <div class="search-result-item" onclick="scrollToElement('${result.element.id}')">
                <div class="search-result-text">${highlightQuery(result.text.substring(0, 70) + '...', query)}</div>
            </div>`;
    }).join('');
    searchResults.innerHTML = resultsHTML;
    searchResults.style.display = 'block';
}

function highlightQuery(text, query) {
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
}

function scrollToElement(elementId) {
    const element = document.getElementById(elementId);
    const searchResults = document.getElementById('searchResults');
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        searchResults.style.display = 'none'; // Ocultar resultados después de hacer clic
        // Resaltado temporal
        element.style.transition = 'background-color 0.5s ease';
        element.style.backgroundColor = 'rgba(255, 235, 59, 0.5)';
        setTimeout(() => {
            element.style.backgroundColor = 'transparent';
        }, 2000);
    }
}

// ==================================================================================
// CALENDARIO FERROVIARIO (CONECTADO A WORDPRESS)
// ==================================================================================
function initializeCalendar() {
    const calendarGrid = document.getElementById('calendarGrid');
    if (!calendarGrid) {
        // No estamos en una página con el calendario
        return;
    }

    // La variable `ferroblog_events` es creada por PHP en footer.php
    // Comprobamos que exista para evitar errores
    if (typeof ferroblog_events !== 'undefined') {
        renderCalendar(ferroblog_events);
    } else {
        console.error("Los datos de eventos (ferroblog_events) no fueron encontrados.");
    }
}

function renderCalendar(railwayEvents = []) {
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthSpan = document.getElementById('currentMonth');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');

    function drawCalendar() {
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        let dayOfWeek = firstDay.getDay();
        dayOfWeek = dayOfWeek === 0 ? 6 : dayOfWeek - 1; 
        startDate.setDate(startDate.getDate() - dayOfWeek);

        currentMonthSpan.textContent = new Date(currentYear, currentMonth).toLocaleDateString('es-ES', {
            month: 'long',
            year: 'numeric'
        });

        calendarGrid.innerHTML = '';
        const weekdays = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        weekdays.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'calendar-day weekday';
            dayHeader.textContent = day;
            calendarGrid.appendChild(dayHeader);
        });

        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';

            if (date.getMonth() === currentMonth) {
                dayElement.textContent = date.getDate();
                if (date.toDateString() === new Date().toDateString()) {
                    dayElement.classList.add('today');
                }

                const dayEvents = railwayEvents.filter(event => {
                    const eventDate = new Date(event.date + 'T00:00:00'); // Asegura que la fecha se interprete localmente
                    return eventDate.toDateString() === date.toDateString();
                });

                if (dayEvents.length > 0) {
                    dayElement.classList.add('has-event');
                    dayElement.setAttribute('data-event-title', dayEvents[0].title);
                    dayElement.style.backgroundColor = '#e8f5e8'; // Color base para eventos
                    dayElement.style.fontWeight = 'bold';
                }
            } else {
                dayElement.classList.add('other-month');
            }
            calendarGrid.appendChild(dayElement);
        }
    }

    prevMonthBtn.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        drawCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        drawCalendar();
    });

    drawCalendar();
}

// ==================================================================================
// DESPLEGABLES DEL SIDEBAR
// ==================================================================================
function initializeSidebarToggles() {
    const sectionHeaders = document.querySelectorAll('.sidebar .section-header');
    sectionHeaders.forEach(header => {
        header.addEventListener('click', (event) => {
            const sectionId = event.currentTarget.nextElementSibling.id;
            toggleCategorySection(sectionId.replace('-section', ''));
        });
    });
}

function toggleCategorySection(sectionName) {
    const section = document.getElementById(sectionName + '-section');
    if (!section) return;

    const toggle = section.previousElementSibling.querySelector('.toggle-icon');
    
    if (section.style.display === "block") {
        section.style.display = "none";
        toggle.textContent = '▼';
    } else {
        section.style.display = "block";
        toggle.textContent = '▲';
    }
}