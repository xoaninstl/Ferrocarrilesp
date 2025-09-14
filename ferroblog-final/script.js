document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidades del frontend
    initializeMobileMenu();
    initializeCalendar(); // Esta función ahora usará los datos de WordPress
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
        header.addEventListener('click', () => {
            const sectionId = header.parentElement.querySelector('.section-content').id;
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