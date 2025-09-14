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
// BÚSQUEDA VISUAL
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
        const allTextElements = document.querySelectorAll('h1, h2, h3, h4, p, a, li');
        let results = [];
        allTextElements.forEach(el => {
            if (el.textContent.toLowerCase().includes(query)) {
                if (!results.some(r => r.text.startsWith(el.textContent.substring(0, 30)))) {
                    results.push({
                        text: el.textContent,
                        element: el
                    });
                }
            }
        });
        displaySearchResults(results.slice(0, 8), query);
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
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        searchResults.style.display = 'none';
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
        return;
    }
    
    // La variable `ferroblog_events` es creada por PHP en footer.php
    if (typeof ferroblog_events !== 'undefined') {
        renderCalendar(ferroblog_events);
    } else {
        console.error("Los datos de eventos (ferroblog_events) no fueron encontrados.");
        renderCalendar([]); // Dibuja un calendario vacío para evitar errores
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
        calendarGrid.innerHTML = ''; // Limpiar calendario
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
        const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
        
        currentMonthSpan.textContent = firstDayOfMonth.toLocaleDateString('es-ES', {
            month: 'long',
            year: 'numeric'
        });
        
        // Añadir cabeceras de días de la semana
        const weekdays = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
        weekdays.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'calendar-day weekday';
            dayHeader.textContent = day;
            calendarGrid.appendChild(dayHeader);
        });
        
        // Calcular huecos al principio del mes
        let startingDay = firstDayOfMonth.getDay(); // Domingo = 0, Lunes = 1...
        startingDay = (startingDay === 0) ? 6 : startingDay - 1; // Lunes = 0...

        for (let i = 0; i < startingDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day other-month';
            calendarGrid.appendChild(emptyCell);
        }

        // Rellenar días del mes
        for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;

            const today = new Date();
            if (day === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear()) {
                dayElement.classList.add('today');
            }

            const dayString = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayEvents = railwayEvents.filter(event => event.date === dayString);
                
                if (dayEvents.length > 0) {
                dayElement.classList.add('has-event');
                dayElement.setAttribute('title', dayEvents.map(e => e.title).join(', '));
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
            const content = event.currentTarget.nextElementSibling;
            const icon = event.currentTarget.querySelector('.toggle-icon');
            if (content.style.display === "block") {
                content.style.display = "none";
                icon.textContent = '▼';
            } else {
                content.style.display = "block";
                icon.textContent = '▲';
            }
        });
    });
}