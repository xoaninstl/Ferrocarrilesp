// SCRIPT PRINCIPAL DEL BLOG

// Variables globales para el sistema de categorías
let selectedCategories = [];
let allContent = [];

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todas las funcionalidades
    initializeMobileMenu();
    initializeComments();
    initializeSearch();
    initializeCalendar();
    
    // Mostrar noticias si la función existe
    if (typeof displayNews === 'function') {
        displayNews();
    }
    
    // Aplicar configuración del autor
    applyAuthorConfig();
    
    // Inicializar sistema de categorías
    initializeCategorySystem();
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
// SISTEMA DE COMENTARIOS
// ==================================================================================

function initializeComments() {
    // Cargar comentarios existentes
    loadComments();
}

function addComment() {
    const commentTextElement = document.getElementById('commentText');
    const commentNameElement = document.getElementById('commentName');
    const commentEmailElement = document.getElementById('commentEmail');
    
    if (!commentTextElement || !commentNameElement || !commentEmailElement) {
        showNotification('Error: Elementos del formulario no encontrados', 'error');
        return;
    }
    
    const commentText = commentTextElement.value.trim();
    const commentName = commentNameElement.value.trim();
    const commentEmail = commentEmailElement.value.trim();
    
    if (commentText === '') {
        showNotification('Por favor, escribe un comentario antes de publicar.', 'error');
        return;
    }
    
    if (commentName === '') {
        showNotification('Por favor, escribe tu nombre.', 'error');
        return;
    }
    
    if (commentEmail === '') {
        showNotification('Por favor, escribe tu correo electrónico.', 'error');
        return;
    }
    
    // Validar formato básico de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(commentEmail)) {
        showNotification('Por favor, escribe un correo electrónico válido.', 'error');
        return;
    }
    
    try {
        const comment = {
            id: Date.now(),
            text: commentText,
            author: commentName,
            email: commentEmail,
            date: new Date().toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })
        };
        
        // Guardar en localStorage con manejo de errores
        let comments = [];
        try {
            const savedComments = localStorage.getItem('blogComments');
            if (savedComments) {
                comments = JSON.parse(savedComments);
            }
        } catch (error) {
            console.error('Error al cargar comentarios existentes:', error);
        }
        
        comments.push(comment);
        
        try {
            localStorage.setItem('blogComments', JSON.stringify(comments));
            showNotification('Comentario publicado correctamente', 'success');
            
            // Limpiar formulario
            commentTextElement.value = '';
            commentNameElement.value = '';
            commentEmailElement.value = '';
            
            // Recargar comentarios
            loadComments();
        } catch (error) {
            showNotification('Error al guardar el comentario', 'error');
            console.error('Error al guardar comentario:', error);
        }
    } catch (error) {
        showNotification('Error inesperado al publicar comentario', 'error');
        console.error('Error inesperado:', error);
    }
}

function loadComments() {
    const commentsContainer = document.getElementById('commentsContainer');
    if (!commentsContainer) return;
    
    try {
        const savedComments = localStorage.getItem('blogComments');
        if (!savedComments) {
            commentsContainer.innerHTML = '<p class="no-comments">No hay comentarios aún. ¡Sé el primero en comentar!</p>';
            return;
        }
        
        const comments = JSON.parse(savedComments);
        
        if (comments.length === 0) {
            commentsContainer.innerHTML = '<p class="no-comments">No hay comentarios aún. ¡Sé el primero en comentar!</p>';
            return;
        }
        
        const commentsHTML = comments.map(comment => `
            <div class="comment">
                <div class="comment-header">
                    <strong class="comment-author">${comment.author}</strong>
                    <span class="comment-date">${comment.date}</span>
                </div>
                <div class="comment-text">${comment.text}</div>
            </div>
        `).join('');
        
        commentsContainer.innerHTML = commentsHTML;
    } catch (error) {
        console.error('Error al cargar comentarios:', error);
        commentsContainer.innerHTML = '<p class="error">Error al cargar comentarios</p>';
    }
}

// ==================================================================================
// SISTEMA DE BÚSQUEDA
// ==================================================================================

function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    if (!searchInput || !searchResults) return;
    
    // Event listener para búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        // Buscar en el contenido del blog
        const results = searchInContent(query);
        displaySearchResults(results, query);
    });
    
    // Ocultar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
}

function searchInContent(query) {
    const results = [];
    
    // Buscar en títulos de artículos
    const articleTitles = document.querySelectorAll('.blog-entry-title, h1, h2, h3');
    articleTitles.forEach(element => {
        const text = element.textContent.toLowerCase();
        if (text.includes(query)) {
            const result = {
                text: element.textContent,
                element: element,
                relevance: calculateRelevance(text, query) + 10, // Mayor relevancia para títulos
                type: 'title'
            };
            results.push(result);
        }
    });
    
    // Buscar en contenido de artículos
    const articleContent = document.querySelectorAll('.blog-entry-content p, .article-content p, .content p, p');
    articleContent.forEach(element => {
        const text = element.textContent.toLowerCase();
        if (text.includes(query) && text.length > 30) { // Solo párrafos con contenido sustancial
            const result = {
                text: element.textContent.substring(0, 150) + '...',
                element: element,
                relevance: calculateRelevance(text, query),
                type: 'content'
            };
            results.push(result);
        }
    });
    
    // Buscar en categorías
    const categories = document.querySelectorAll('.category-tag, .blog-entry-category, .category');
    categories.forEach(element => {
        const text = element.textContent.toLowerCase();
        if (text.includes(query)) {
            const result = {
                text: 'Categoría: ' + element.textContent,
                element: element,
                relevance: calculateRelevance(text, query) + 5,
                type: 'category'
            };
            results.push(result);
        }
    });
    
    // Buscar en enlaces de navegación
    const navLinks = document.querySelectorAll('.nav-menu a, .breadcrumb a, nav a');
    navLinks.forEach(element => {
        const text = element.textContent.toLowerCase();
        if (text.includes(query)) {
            const result = {
                text: 'Navegación: ' + element.textContent,
                element: element,
                relevance: calculateRelevance(text, query) + 3,
                type: 'navigation'
            };
            results.push(result);
        }
    });
    
    // Buscar en listas y elementos de contenido
    const listItems = document.querySelectorAll('li, .list-item');
    listItems.forEach(element => {
        const text = element.textContent.toLowerCase();
        if (text.includes(query) && text.length > 20) {
            const result = {
                text: element.textContent.substring(0, 100) + '...',
                element: element,
                relevance: calculateRelevance(text, query) + 2,
                type: 'content'
            };
            results.push(result);
        }
    });
    
    // Ordenar por relevancia y eliminar duplicados
    const uniqueResults = [];
    const seenTexts = new Set();
    
    results.sort((a, b) => b.relevance - a.relevance).forEach(result => {
        if (!seenTexts.has(result.text)) {
            seenTexts.add(result.text);
            uniqueResults.push(result);
        }
    });
    
    return uniqueResults.slice(0, 8);
}

function calculateRelevance(text, query) {
    let relevance = 0;
    
    // Mayor relevancia si está en el título
    if (text.length < 100) relevance += 10;
    
    // Mayor relevancia si la query está al inicio
    if (text.startsWith(query)) relevance += 5;
    
    // Contar ocurrencias
    const occurrences = (text.match(new RegExp(query, 'gi')) || []).length;
    relevance += occurrences * 2;
    
    return relevance;
}

function displaySearchResults(results, query) {
    const searchResults = document.getElementById('searchResults');
    if (!searchResults) return;
    
    if (results.length === 0) {
        searchResults.innerHTML = '<div class="no-results">No se encontraron resultados para "' + query + '"</div>';
        searchResults.style.display = 'block';
        return;
    }
    
    const resultsHTML = results.map(result => {
        const icon = getResultIcon(result.type);
        const elementId = result.element.id || generateId(result.element);
        
        return `
            <div class="search-result-item" onclick="scrollToElement('${elementId}')">
                <div class="search-result-icon">${icon}</div>
                <div class="search-result-content">
                    <div class="search-result-text">${highlightQuery(result.text, query)}</div>
                    <div class="search-result-type">${getResultTypeLabel(result.type)}</div>
                </div>
            </div>
        `;
    }).join('');
    
    searchResults.innerHTML = resultsHTML;
    searchResults.style.display = 'block';
}

function getResultIcon(type) {
    const icons = {
        'title': '📰',
        'content': '📄',
        'category': '🏷️',
        'navigation': '🧭'
    };
    return icons[type] || '📄';
}

function getResultTypeLabel(type) {
    const labels = {
        'title': 'Título',
        'content': 'Contenido',
        'category': 'Categoría',
        'navigation': 'Navegación'
    };
    return labels[type] || 'Resultado';
}

function highlightQuery(text, query) {
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
}

function generateId(element) {
    if (element.id) return element.id;
    
    const id = 'search-' + Math.random().toString(36).substr(2, 9);
    element.id = id;
    return id;
}

function scrollToElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        element.classList.add('highlight');
        setTimeout(() => element.classList.remove('highlight'), 2000);
    }
}

// ==================================================================================
// SISTEMA DE CATEGORÍAS JERÁRQUICO
// ==================================================================================

function initializeCategorySystem() {
    // Cargar contenido existente
    loadAllContent();
    
    // Añadir contenido de ejemplo si no existe
    if (allContent.length === 0) {
        addSampleContent();
    }
    
    // Inicializar el sistema de filtrado
    initializeFilterSystem();
}

function loadAllContent() {
    try {
        const savedContent = localStorage.getItem('allContent');
        allContent = savedContent ? JSON.parse(savedContent) : [];
    } catch (error) {
        allContent = [];
        console.error('Error al cargar contenido:', error);
    }
}

function initializeFilterSystem() {
    // Limpiar categorías seleccionadas al inicio
    selectedCategories = [];
    
    // Actualizar la interfaz
    updateCategoryFilter();
}

function addSampleContent() {
    // Añadir contenido de ejemplo para probar las funcionalidades
    const sampleContent = [
        {
            id: "sample_1",
            title: "Historia del Ancho Ibérico",
            content: "El ancho ibérico de 1668 mm es característico de España y Portugal. Se estableció en 1848 y es el segundo ancho más utilizado en el mundo después del ancho estándar. Esta medida única se eligió por consideraciones técnicas y geográficas específicas de la península.",
            categories: ["ancho_iberico", "historia", "sevilla"],
            date: "2025-01-15",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_2",
            title: "Proyecto AVE Madrid-Sevilla",
            content: "El primer AVE de España conectó Madrid con Sevilla en 1992, marcando el inicio de la era de alta velocidad en nuestro país. Este proyecto revolucionario estableció los estándares para futuras líneas de alta velocidad en España.",
            categories: ["ave", "apertura_linea", "madrid", "sevilla"],
            date: "2025-01-10",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_3",
            title: "Desarrollo Ferroviario en Barcelona",
            content: "Barcelona cuenta con una extensa red de metro y cercanías que conecta toda la ciudad y su área metropolitana. La red incluye múltiples líneas de metro, tranvía y cercanías que facilitan la movilidad urbana.",
            categories: ["barcelona", "metro", "cercanias"],
            date: "2025-01-05",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_4",
            title: "Estación de Atocha",
            content: "La estación de Atocha en Madrid es una de las más importantes de España, con conexiones de alta velocidad y cercanías. Su arquitectura histórica y su papel como hub de transporte la convierten en un símbolo del ferrocarril español.",
            categories: ["estaciones_principales", "madrid", "ave"],
            date: "2025-01-01",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_5",
            title: "Nueva Línea de Metro en Madrid",
            content: "Se inaugura una nueva línea de metro que conecta el centro de Madrid con los barrios del sur. Esta ampliación mejora significativamente la conectividad de la ciudad y reduce los tiempos de viaje.",
            categories: ["madrid", "metro", "apertura_linea"],
            date: "2025-01-20",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_6",
            title: "Líneas de Ancho Métrico en Asturias",
            content: "Las líneas de ancho métrico en Asturias son fundamentales para el transporte regional. Estas líneas históricas conectan las principales ciudades asturianas y son esenciales para la movilidad local.",
            categories: ["ancho_metrico", "asturias", "lineas_regionales"],
            date: "2025-01-18",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_7",
            title: "Proyecto de Metro en Valencia",
            content: "Valencia está desarrollando un ambicioso proyecto de metro que conectará toda la ciudad y su área metropolitana. Este proyecto incluye nuevas líneas y estaciones para mejorar la movilidad urbana.",
            categories: ["valencia", "metro", "proyectos_estudio"],
            date: "2025-01-12",
            author: "Blog Ferrocarril"
        },
        {
            id: "sample_8",
            title: "Estaciones Principales de Bilbao",
            content: "Bilbao cuenta con varias estaciones principales que conectan la ciudad con el resto de España. La estación de Abando es el centro neurálgico del transporte ferroviario en la capital vizcaína.",
            categories: ["bilbao", "estaciones_principales", "conectividad"],
            date: "2025-01-08",
            author: "Blog Ferrocarril"
        }
    ];
    
    try {
        localStorage.setItem('allContent', JSON.stringify(sampleContent));
        allContent = sampleContent;
        showNotification('Contenido de ejemplo cargado correctamente', 'success');
    } catch (error) {
        showNotification('Error al cargar contenido de ejemplo', 'error');
    }
}

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

function updateCategoryFilter() {
    // Obtener todas las categorías seleccionadas
    const checkboxes = document.querySelectorAll('.category-checkbox input[type="checkbox"]:checked');
    selectedCategories = Array.from(checkboxes).map(cb => cb.value);
    
    // Mostrar/ocultar botón de aplicar filtros
    const filterBtn = document.querySelector('.btn-filter');
    if (filterBtn) {
        filterBtn.disabled = selectedCategories.length === 0;
        filterBtn.textContent = selectedCategories.length === 0 ? 
            'Selecciona categorías' : 
            `Aplicar Filtros (${selectedCategories.length})`;
    }
}

function applyCategoryFilter() {
    if (selectedCategories.length === 0) {
        showNotification('Selecciona al menos una categoría', 'warning');
        return;
    }
    
    // Filtrar contenido que contenga TODAS las categorías seleccionadas
    const filteredContent = allContent.filter(item => {
        return selectedCategories.every(category => 
            item.categories.includes(category)
        );
    });
    
    if (filteredContent.length === 0) {
        showNotification(`No se encontró contenido con las categorías seleccionadas`, 'info');
        hideFilterResults();
        return;
    }
    
    // Mostrar resultados
    displayFilterResults(filteredContent);
}

function displayFilterResults(content) {
    const resultsContainer = document.getElementById('filterResults');
    const contentContainer = document.getElementById('filteredContent');
    
    if (!resultsContainer || !contentContainer) return;
    
    // Crear HTML para los resultados
    const resultsHTML = content.map(item => `
        <div class="filtered-item">
            <div class="item-header">
                <h5 class="item-title">${item.title}</h5>
                <span class="item-date">${formatDate(item.date)}</span>
            </div>
            <p class="item-excerpt">${item.content.substring(0, 150)}${item.content.length > 150 ? '...' : ''}</p>
            <div class="item-categories">
                ${item.categories.map(cat => `<span class="item-category">${getCategoryDisplayName(cat)}</span>`).join('')}
            </div>
            <div class="item-meta">
                <span class="item-author">Por: ${item.author}</span>
                <button class="btn-view-more" onclick="viewFullContent('${item.id}')">Ver más</button>
            </div>
        </div>
    `).join('');
    
    contentContainer.innerHTML = resultsHTML;
    resultsContainer.style.display = 'block';
    
    // Mostrar notificación
    showNotification(`Se encontraron ${content.length} resultados`, 'success');
}

function hideFilterResults() {
    const resultsContainer = document.getElementById('filterResults');
    if (resultsContainer) {
        resultsContainer.style.display = 'none';
    }
}

function clearCategoryFilters() {
    // Desmarcar todos los checkboxes
    const checkboxes = document.querySelectorAll('.category-checkbox input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = false);
    
    // Limpiar categorías seleccionadas
    selectedCategories = [];
    
    // Ocultar resultados
    hideFilterResults();
    
    // Actualizar interfaz
    updateCategoryFilter();
    
    showNotification('Filtros limpiados', 'info');
}

function viewFullContent(contentId) {
    // Buscar el contenido completo
    const content = allContent.find(item => item.id === contentId);
    if (!content) {
        showNotification('Contenido no encontrado', 'error');
        return;
    }
    
    // Mostrar modal con contenido completo
    showContentModal(content);
}

function showContentModal(content) {
    // Crear modal
    const modal = document.createElement('div');
    modal.className = 'content-modal';
    
    modal.innerHTML = `
        <div class="content-modal-content">
            <div class="content-modal-header">
                <h3>${content.title}</h3>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="close-btn">&times;</button>
            </div>
            <div class="content-modal-body">
                <div class="content-meta">
                    <span class="content-date">${formatDate(content.date)}</span>
                    <span class="content-author">Por: ${content.author}</span>
                </div>
                <div class="content-text">
                    ${content.content}
                </div>
                <div class="content-categories">
                    <strong>Categorías:</strong>
                    ${content.categories.map(cat => `<span class="content-category">${getCategoryDisplayName(cat)}</span>`).join('')}
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Mostrar modal
    setTimeout(() => modal.classList.add('show'), 100);
}

function formatDate(dateString) {
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    } catch (error) {
        return dateString;
    }
}

// ==================================================================================
// CALENDARIO FERROVIARIO
// ==================================================================================

function initializeCalendar() {
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    // Cargar eventos del calendario desde localStorage
    let railwayEvents = [];
    
    // TEMPORAL: Limpiar localStorage para forzar recarga
    localStorage.removeItem('calendarEvents');
    
    try {
        railwayEvents = JSON.parse(localStorage.getItem('calendarEvents') || '[]');
    } catch (error) {
        railwayEvents = [];
    }
    
    // Si no hay eventos, añadir algunos de ejemplo
    if (railwayEvents.length === 0) {
        // Eventos de ejemplo usando el sistema de categorías
        railwayEvents = [
            {
                id: Date.now() + 1,
                date: '2025-08-31',
                title: 'Inauguración Metro Sevilla Línea 3',
                category: 'apertura_linea',
                link: '#metro-sevilla',
                description: 'Gran inauguración de la nueva línea de metro que conectará el centro de Sevilla con los barrios del sur. Incluye 8 nuevas estaciones y mejorará significativamente la movilidad urbana.'
            }
        ];
        
        // Guardar en localStorage
        localStorage.setItem('calendarEvents', JSON.stringify(railwayEvents));
        console.log('Eventos de ejemplo añadidos:', railwayEvents);
    }
    
    // Limpiar localStorage temporalmente para debug
    console.log('Eventos actuales en railwayEvents:', railwayEvents);
    console.log('Eventos en localStorage:', localStorage.getItem('calendarEvents'));
    
    // Elementos del DOM
    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthSpan = document.getElementById('currentMonth');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    
    if (!calendarGrid || !currentMonthSpan || !prevMonthBtn || !nextMonthBtn) return;
    
    // Event listeners
    prevMonthBtn.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    });
    
    nextMonthBtn.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    });
    
    function renderCalendar() {
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        // Ajustar para que la semana empiece en lunes (1) en lugar de domingo (0)
        let dayOfWeek = firstDay.getDay();
        dayOfWeek = dayOfWeek === 0 ? 6 : dayOfWeek - 1; // Domingo (0) -> 6, Lunes (1) -> 0
        startDate.setDate(startDate.getDate() - dayOfWeek);
        
        currentMonthSpan.textContent = new Date(currentYear, currentMonth).toLocaleDateString('es-ES', {
            month: 'long',
            year: 'numeric'
        });
        
        calendarGrid.innerHTML = '';
        
        // Días de la semana
        const weekdays = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        weekdays.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'calendar-day weekday';
            dayHeader.textContent = day;
            dayHeader.style.fontWeight = 'bold';
            dayHeader.style.color = '#2c3e50';
            calendarGrid.appendChild(dayHeader);
        });
        
        // Días del mes
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            
            if (date.getMonth() === currentMonth) {
                dayElement.textContent = date.getDate();
                
                // Marcar día actual
                if (date.toDateString() === new Date().toDateString()) {
                    dayElement.classList.add('current-day');
                }
                
                // Buscar eventos para este día
                const dayEvents = railwayEvents.filter(event => {
                    const eventDate = new Date(event.date);
                    return eventDate.toDateString() === date.toDateString();
                });
                
                if (dayEvents.length > 0) {
                    console.log('Evento encontrado para', date.toDateString(), ':', dayEvents[0]);
                    dayElement.classList.add('has-events');
                    
                    // Aplicar color según la categoría del evento
                    const event = dayEvents[0];
                    if (event.category) {
                        // Buscar el color en la configuración
                        const eventConfig = CALENDAR_EVENT_TYPES[event.category];
                        if (eventConfig && eventConfig.color) {
                            dayElement.style.backgroundColor = eventConfig.color;
                            dayElement.style.border = `2px solid ${eventConfig.color}`;
                        }
                    }
                    
                    // Crear tooltip con título y descripción
                    const tooltipText = `${event.title}\n\n${event.description || 'Sin descripción disponible'}`;
                    dayElement.setAttribute('data-tooltip', tooltipText);
                    
                    // Crear tooltip con título en negrita usando caracteres especiales
                    const boldTitle = `**${event.title}**`;
                    const tooltipBold = `${boldTitle}\n\n${event.description || 'Sin descripción disponible'}`;
                    dayElement.setAttribute('data-tooltip-bold', tooltipBold);
                    
                    // Hacer clickeable el día
                    dayElement.style.cursor = 'pointer';
                    dayElement.addEventListener('click', () => {
                        if (event.link && event.link !== '#') {
                            window.location.href = event.link;
                        }
                    });
                    
                    // Crear tooltip clickeable real
                    dayElement.addEventListener('mouseenter', () => {
                        console.log('Mouse enter en día con evento:', event.title);
                        showClickableTooltip(event, dayElement);
                    });
                    
                    dayElement.addEventListener('mouseleave', () => {
                        console.log('Mouse leave en día con evento');
                        hideTooltip();
                    });
                }
            } else {
                dayElement.classList.add('other-month');
            }
            
            calendarGrid.appendChild(dayElement);
        }
    }
    
    // Renderizar calendario inicial
    renderCalendar();
}

// Función para mostrar tooltip clickeable
function showClickableTooltip(event, dayElement) {
    console.log('Creando tooltip para:', event.title);
    
    // Eliminar tooltip anterior si existe
    hideTooltip();
    
    // Crear contenedor del tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'clickable-tooltip';
    tooltip.innerHTML = `
        <div class="tooltip-title">${event.title}</div>
        <div class="tooltip-description">${event.description || 'Sin descripción disponible'}</div>
    `;
    
    // Posicionar tooltip
    const rect = dayElement.getBoundingClientRect();
    tooltip.style.position = 'fixed';
    tooltip.style.top = `${rect.top - 10}px`;
    tooltip.style.left = `${rect.left + rect.width/2}px`;
    tooltip.style.transform = 'translate(-50%, -100%)';
    tooltip.style.zIndex = '1000';
    
    // Hacer clickeable
    tooltip.addEventListener('click', () => {
        console.log('Click en tooltip, navegando a:', event.link);
        if (event.link && event.link !== '#') {
            window.location.href = event.link;
        }
    });
    
    // Añadir al DOM
    document.body.appendChild(tooltip);
    console.log('Tooltip añadido al DOM');
    
    // Guardar referencia para poder eliminarlo
    window.currentTooltip = tooltip;
}

// Función para ocultar tooltip
function hideTooltip() {
    if (window.currentTooltip) {
        window.currentTooltip.remove();
        window.currentTooltip = null;
    }
}

function addCalendarEvent(date, title, category, link) {
    try {
        let events = [];
        const savedEvents = localStorage.getItem('calendarEvents');
        if (savedEvents) {
            events = JSON.parse(savedEvents);
        }
        
        const newEvent = {
            id: Date.now(),
            date: date,
            title: title,
            category: category,
            link: link
        };
        
        events.push(newEvent);
        localStorage.setItem('calendarEvents', JSON.stringify(events));
        
        // Actualizar calendario si está visible
        if (typeof renderCalendar === 'function') {
            renderCalendar();
        }
        
        showNotification('Evento añadido al calendario', 'success');
    } catch (error) {
        showNotification('Error al añadir evento', 'error');
        console.error('Error:', error);
    }
}



// ==================================================================================
// FUNCIONES AUXILIARES
// ==================================================================================

function showNotification(message, type = 'info') {
    // Crear notificación
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    // Añadir al DOM
    document.body.appendChild(notification);
    
    // Mostrar con animación
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Ocultar automáticamente
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Función para el menú de categorías del sidebar
function toggleCategories() {
    const categoriesContent = document.getElementById('categoriesContent');
    const toggleButton = document.querySelector('.categories-toggle');
    
    if (categoriesContent && toggleButton) {
        const isVisible = categoriesContent.style.display !== 'none';
        
        if (isVisible) {
            categoriesContent.style.display = 'none';
            toggleButton.innerHTML = 'Ver Categorías ▼';
        } else {
            categoriesContent.style.display = 'block';
            toggleButton.innerHTML = 'Ocultar Categorías ▲';
        }
    }
}

// Función para filtrar por categoría desde el sidebar
function filterByCategory(category) {
    // Redirigir a la página correspondiente según la categoría
    switch(category) {
        case 'ancho_iberico':
            window.location.href = 'lineas/ancho-iberico.html';
            break;
        case 'proyectos_estudio':
            window.location.href = 'proyectos/proyectos-estudio.html';
            break;
        case 'sevilla':
            window.location.href = 'desarrollo-ciudades/sevilla.html';
            break;
        case 'mapa_provincias':
            window.location.href = 'estaciones-tren/mapa-provincias.html';
            break;
        default:
            // Para otras categorías, usar el filtro avanzado
            showNotification(`Filtrado por: ${getCategoryDisplayName(category)}`, 'info');
            break;
    }
}

function applyAuthorConfig() {
    // Aplicar configuración del autor desde config.js
    if (typeof authorConfig !== 'undefined') {
        const authorNameElement = document.getElementById('authorName');
        const authorBioElement = document.getElementById('authorBio');
        const authorImageElement = document.getElementById('authorImage');
        
        if (authorNameElement && authorConfig.name) {
            authorNameElement.textContent = authorConfig.name;
        }
        
        if (authorBioElement && authorConfig.bio) {
            authorBioElement.textContent = authorConfig.bio;
        }
        
        if (authorImageElement && authorConfig.image) {
            authorImageElement.src = authorConfig.image;
            authorImageElement.alt = authorConfig.name || 'Autor del blog';
        }
    }
}

function getCategoryDisplayName(category) {
    const categoryNames = {
        // Histórico
        'ancho_iberico': 'Ancho Ibérico',
        'ancho_metrico': 'Ancho Métrico',
        'ancho_internacional': 'Ancho Internacional',
        'lineas_cerradas': 'Líneas Cerradas',
        'proyectos_cancelados': 'Proyectos Cancelados',
        'proyectos_actuales': 'Proyectos Actuales',
        'proyectos_en_marcha': 'Proyectos en Marcha',
        'proyectos_estudio': 'Proyectos en Estudio',
        'mapa_provincias': 'Mapa por Provincias',
        'estaciones_principales': 'Estaciones Principales',
        
        // Noticias
        'metro': 'Metro',
        'tram': 'Tranvía',
        'ave': 'AVE',
        'cercanias': 'Cercanías',
        'apertura_linea': 'Apertura de Línea',
        'inicio_obras': 'Inicio de Obras',
        'fin_obras': 'Fin de Obras',
        'evento_especial': 'Evento Especial',
        'mantenimiento': 'Mantenimiento',
        'aniversario': 'Aniversario',
        'cambio_horarios': 'Cambio de Horarios',
        
        // Ciudades
        'sevilla': 'Sevilla',
        'madrid': 'Madrid',
        'barcelona': 'Barcelona',
        'valencia': 'Valencia',
        'bilbao': 'Bilbao',
        'a_coruna': 'A Coruña'
    };
    
    return categoryNames[category] || category;
}

// ==================================================================================
// FUNCIONES DE NOTICIAS (si existen)
// ==================================================================================

function displayNews() {
    // Función para mostrar noticias si existe
    const newsContainer = document.getElementById('newsContainer');
    if (newsContainer) {
        // Lógica para mostrar noticias
        newsContainer.innerHTML = '<p>Noticias del ferrocarril español</p>';
    }
}

// ==================================================================================
// FUNCIONES PARA PÁGINAS DE CATEGORÍAS
// ==================================================================================

function loadCategoryContent(category) {
    try {
        const savedContent = localStorage.getItem('allContent');
        if (savedContent) {
            const allContent = JSON.parse(savedContent);
            const categoryContent = allContent.filter(item => 
                item.categories.includes(category)
            );
            
            if (categoryContent.length > 0) {
                displayCategoryContent(categoryContent);
            } else {
                const container = document.getElementById('filteredContent');
                if (container) {
                    container.innerHTML = '<p class="no-content">No hay contenido disponible para esta categoría.</p>';
                }
            }
        } else {
            console.warn('No hay contenido guardado en localStorage');
        }
    } catch (error) {
        console.error('Error al cargar contenido:', error);
        const container = document.getElementById('filteredContent');
        if (container) {
            container.innerHTML = '<p class="error">Error al cargar el contenido.</p>';
        }
    }
}

function displayCategoryContent(content) {
    const container = document.getElementById('filteredContent');
    if (!container) return;
    
    const contentHTML = content.map(item => `
        <div class="category-content-item">
            <div class="item-header">
                <h4 class="item-title">${item.title}</h4>
                <span class="item-date">${formatDate(item.date)}</span>
            </div>
            <p class="item-excerpt">${item.content.substring(0, 200)}${item.content.length > 200 ? '...' : ''}</p>
            <div class="item-categories">
                ${item.categories.map(cat => `<span class="item-category">${getCategoryDisplayName(cat)}</span>`).join('')}
            </div>
            <div class="item-meta">
                <span class="item-author">Por: ${item.author}</span>
                <button class="btn-view-more" onclick="viewFullContent('${item.id}')">Ver más</button>
            </div>
        </div>
    `).join('');
    
    container.innerHTML = contentHTML;
}

function filterByAdditionalCategory() {
    const checkboxes = document.querySelectorAll('.additional-filters input[type="checkbox"]:checked');
    const selectedCategories = Array.from(checkboxes).map(cb => cb.value);
    
    if (selectedCategories.length === 0) {
        // Si no hay categorías seleccionadas, mostrar todo el contenido de la categoría principal
        const mainCategory = getMainCategoryFromURL();
        if (mainCategory) {
            loadCategoryContent(mainCategory);
        }
        return;
    }
    
    try {
        const savedContent = localStorage.getItem('allContent');
        if (savedContent) {
            const allContent = JSON.parse(savedContent);
            const mainCategory = getMainCategoryFromURL();
            
            // Filtrar por categoría principal + categorías adicionales
            const filteredContent = allContent.filter(item => {
                const hasMainCategory = mainCategory ? item.categories.includes(mainCategory) : true;
                const hasAdditionalCategories = selectedCategories.every(cat => 
                    item.categories.includes(cat)
                );
                return hasMainCategory && hasAdditionalCategories;
            });
            
            if (filteredContent.length > 0) {
                displayCategoryContent(filteredContent);
            } else {
                const container = document.getElementById('filteredContent');
                if (container) {
                    container.innerHTML = '<p class="no-content">No hay contenido con las categorías seleccionadas.</p>';
                }
            }
        }
    } catch (error) {
        console.error('Error al filtrar contenido adicional:', error);
    }
}

function getMainCategoryFromURL() {
    // Extraer la categoría principal de la URL actual
    const path = window.location.pathname;
    if (path.includes('ancho-iberico')) return 'ancho_iberico';
    if (path.includes('ancho-metrico')) return 'ancho_metrico';
    if (path.includes('ancho-internacional')) return 'ancho_internacional';
    if (path.includes('proyectos-estudio')) return 'proyectos_estudio';
    if (path.includes('sevilla')) return 'sevilla';
    if (path.includes('madrid')) return 'madrid';
    if (path.includes('barcelona')) return 'barcelona';
    return null;
}

// ==================================================================================
// FUNCIONES PARA MOSTRAR/OCULTAR MÁS CIUDADES
// ==================================================================================

function toggleMoreCities() {
    const moreCitiesList = document.querySelector('.more-cities');
    const toggleButton = document.querySelector('.btn-more-cities');

    if (moreCitiesList && toggleButton) {
        const isHidden = moreCitiesList.style.display === 'none' || moreCitiesList.style.display === '';

        if (isHidden) {
            // Mostrar ciudades adicionales
            moreCitiesList.style.display = 'block';
            moreCitiesList.innerHTML = `
                <a href="ciudades/zaragoza.html">Zaragoza</a><br>
                <a href="ciudades/malaga.html">Málaga</a><br>
                <a href="ciudades/santander.html">Santander</a><br>
                <a href="ciudades/vigo.html">Vigo</a><br>
                <a href="ciudades/gijon.html">Gijón</a><br>
                <a href="ciudades/salamanca.html">Salamanca</a><br>
                <a href="ciudades/murcia.html">Murcia</a><br>
                <a href="ciudades/oviedo.html">Oviedo</a>
            `;
            toggleButton.textContent = 'Ocultar ciudades adicionales';
        } else {
            // Ocultar ciudades adicionales
            moreCitiesList.style.display = 'none';
            moreCitiesList.innerHTML = '';
            toggleButton.textContent = 'Ver más ciudades...';
        }
    }
}

function toggleMoreCitiesFilter() {
    const moreCitiesFilter = document.querySelector('.more-cities-filter');
    const toggleButton = document.querySelector('.btn-expand-cities');

    if (moreCitiesFilter && toggleButton) {
        const isHidden = moreCitiesFilter.style.display === 'none' || moreCitiesFilter.style.display === '';

        if (isHidden) {
            // Mostrar filtros de ciudades adicionales
            moreCitiesFilter.style.display = 'block';
            moreCitiesFilter.innerHTML = `
                <div class="category-checkbox">
                    <input type="checkbox" id="zaragoza" value="zaragoza" onchange="updateCategoryFilter()">
                    <label for="zaragoza">Zaragoza</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="malaga" value="malaga" onchange="updateCategoryFilter()">
                    <label for="malaga">Málaga</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="santander" value="santander" onchange="updateCategoryFilter()">
                    <label for="santander">Santander</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="vigo" value="vigo" onchange="updateCategoryFilter()">
                    <label for="vigo">Vigo</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="gijon" value="gijon" onchange="updateCategoryFilter()">
                    <label for="gijon">Gijón</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="salamanca" value="salamanca" onchange="updateCategoryFilter()">
                    <label for="salamanca">Salamanca</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="murcia" value="murcia" onchange="updateCategoryFilter()">
                    <label for="murcia">Murcia</label>
                </div>
                <div class="category-checkbox">
                    <input type="checkbox" id="oviedo" value="oviedo" onchange="updateCategoryFilter()">
                    <label for="oviedo">Oviedo</label>
                </div>
            `;
            toggleButton.textContent = 'Ocultar ciudades adicionales';
        } else {
            // Ocultar filtros de ciudades adicionales
            moreCitiesFilter.style.display = 'none';
            moreCitiesFilter.innerHTML = '';
            toggleButton.textContent = 'Ver más ciudades...';
        }
    }
}
