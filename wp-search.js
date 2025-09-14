// BÚSQUEDA PERSONALIZADA PARA WORDPRESS
// Este archivo adapta la funcionalidad de búsqueda original para trabajar con WordPress

// Variables globales
let searchTimeout;
let isSearching = false;
let searchCache = new Map();

// Inicializar búsqueda mejorada
function initializeWordPressSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) {
        console.warn('Elementos de búsqueda no encontrados');
        return;
    }

    // Evento de entrada de texto
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();

        if (query.length < 2) {
            hideSearchResults();
            return;
        }

        // Debounce para evitar muchas peticiones
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performWordPressSearch(query);
        }, 300);
    });

    // Ocultar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            hideSearchResults();
        }
    });

    // Mostrar resultados al enfocar si hay consulta
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            showSearchResults();
        }
    });
}

// Realizar búsqueda combinada (WordPress + estático)
async function performWordPressSearch(query) {
    if (isSearching) return;

    const lowerQuery = query.toLowerCase();

    // Verificar caché
    if (searchCache.has(lowerQuery)) {
        displaySearchResults(searchCache.get(lowerQuery), query);
        return;
    }

    isSearching = true;
    showLoadingState();

    try {
        // Buscar en WordPress via AJAX
        const wpResults = await searchInWordPress(query);

        // Buscar en contenido estático
        const staticResults = searchInStaticContent(query);

        // Combinar y ordenar resultados
        const allResults = [...wpResults, ...staticResults];
        const sortedResults = sortResultsByRelevance(allResults, query);

        // Guardar en caché
        searchCache.set(lowerQuery, sortedResults);

        displaySearchResults(sortedResults, query);

    } catch (error) {
        console.error('Error en la búsqueda:', error);
        displaySearchError();
    } finally {
        isSearching = false;
    }
}

// Buscar en WordPress via AJAX
async function searchInWordPress(query) {
    if (!ferrocarril_ajax) {
        console.warn('Variables de AJAX no disponibles');
        return [];
    }

    const formData = new FormData();
    formData.append('action', 'ferrocarril_search');
    formData.append('search_term', query);
    formData.append('nonce', ferrocarril_ajax.nonce);

    try {
        const response = await fetch(ferrocarril_ajax.ajax_url, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success && data.data) {
            return data.data.map(post => ({
                title: post.title,
                excerpt: post.excerpt,
                url: post.url,
                date: post.date,
                categories: post.categories,
                type: post.type,
                relevance: calculateWordPressRelevance(post, query),
                source: 'wordpress'
            }));
        }
    } catch (error) {
        console.error('Error en búsqueda de WordPress:', error);
    }

    return [];
}

// Buscar en contenido estático
function searchInStaticContent(query) {
    const results = [];
    const lowerQuery = query.toLowerCase();

    // Buscar en secciones estáticas
    const staticSections = [
        {
            title: 'Líneas - Ancho Ibérico',
            excerpt: 'Información sobre las líneas de ancho ibérico en España',
            url: ferrocarril_ajax.home_url + '/lineas/ancho-iberico.html',
            type: 'section',
            keywords: ['ancho', 'iberico', 'lineas', 'vias', 'ferrocarril']
        },
        {
            title: 'Líneas - Ancho Métrico',
            excerpt: 'Información sobre las líneas de ancho métrico',
            url: ferrocarril_ajax.home_url + '/lineas/ancho-metrico.html',
            type: 'section',
            keywords: ['ancho', 'metrico', 'lineas', 'vias']
        },
        {
            title: 'Líneas - Ancho Internacional',
            excerpt: 'Información sobre las líneas de ancho internacional',
            url: ferrocarril_ajax.home_url + '/lineas/ancho-internacional.html',
            type: 'section',
            keywords: ['ancho', 'internacional', 'lineas', 'europa']
        },
        {
            title: 'Proyectos Cancelados',
            excerpt: 'Proyectos ferroviarios que fueron cancelados',
            url: ferrocarril_ajax.home_url + '/proyectos/proyectos-cancelados.html',
            type: 'section',
            keywords: ['proyectos', 'cancelados', 'historia']
        },
        {
            title: 'Proyectos Actuales',
            excerpt: 'Proyectos ferroviarios actualmente en desarrollo',
            url: ferrocarril_ajax.home_url + '/proyectos/proyectos-actuales.html',
            type: 'section',
            keywords: ['proyectos', 'actuales', 'desarrollo', 'obras']
        },
        {
            title: 'Desarrollo de Sevilla',
            excerpt: 'Desarrollo ferroviario en la ciudad de Sevilla',
            url: ferrocarril_ajax.home_url + '/ciudades/sevilla.html',
            type: 'section',
            keywords: ['sevilla', 'ciudad', 'desarrollo', 'metro', 'tranvia']
        },
        {
            title: 'Desarrollo de Madrid',
            excerpt: 'Desarrollo ferroviario en la ciudad de Madrid',
            url: ferrocarril_ajax.home_url + '/ciudades/madrid.html',
            type: 'section',
            keywords: ['madrid', 'ciudad', 'desarrollo', 'metro', 'cercanias']
        },
        {
            title: 'Desarrollo de Barcelona',
            excerpt: 'Desarrollo ferroviario en la ciudad de Barcelona',
            url: ferrocarril_ajax.home_url + '/ciudades/barcelona.html',
            type: 'section',
            keywords: ['barcelona', 'ciudad', 'desarrollo', 'metro', 'tram']
        }
    ];

    // Filtrar secciones que coincidan
    staticSections.forEach(section => {
        const titleMatch = section.title.toLowerCase().includes(lowerQuery);
        const excerptMatch = section.excerpt.toLowerCase().includes(lowerQuery);
        const keywordMatch = section.keywords.some(keyword =>
            keyword.includes(lowerQuery) || lowerQuery.includes(keyword)
        );

        if (titleMatch || excerptMatch || keywordMatch) {
            let relevance = 0;
            if (titleMatch) relevance += 10;
            if (excerptMatch) relevance += 5;
            if (keywordMatch) relevance += 3;

            results.push({
                ...section,
                relevance: relevance,
                source: 'static'
            });
        }
    });

    // Buscar en contenido actual de la página
    const pageResults = searchInCurrentPage(query);
    results.push(...pageResults);

    return results;
}

// Buscar en la página actual
function searchInCurrentPage(query) {
    const results = [];
    const lowerQuery = query.toLowerCase();

    // Buscar en títulos
    const headings = document.querySelectorAll('h1, h2, h3, h4, .post h4, .seccion-card h4');
    headings.forEach(heading => {
        if (heading.textContent.toLowerCase().includes(lowerQuery)) {
            results.push({
                title: 'En esta página: ' + heading.textContent,
                excerpt: 'Encontrado en el contenido actual',
                url: '#',
                type: 'current-page',
                relevance: 8,
                source: 'current-page',
                element: heading
            });
        }
    });

    // Buscar en párrafos
    const paragraphs = document.querySelectorAll('p, .post p');
    paragraphs.forEach(p => {
        const text = p.textContent.toLowerCase();
        if (text.includes(lowerQuery) && text.length > 30) {
            results.push({
                title: 'Contenido encontrado',
                excerpt: p.textContent.substring(0, 120) + '...',
                url: '#',
                type: 'current-page',
                relevance: 5,
                source: 'current-page',
                element: p
            });
        }
    });

    return results.slice(0, 3); // Limitar resultados de página actual
}

// Calcular relevancia para resultados de WordPress
function calculateWordPressRelevance(post, query) {
    let relevance = 0;
    const lowerQuery = query.toLowerCase();
    const title = post.title.toLowerCase();
    const excerpt = post.excerpt.toLowerCase();

    // Relevancia por título
    if (title.includes(lowerQuery)) {
        relevance += 15;
        if (title.startsWith(lowerQuery)) relevance += 5;
    }

    // Relevancia por contenido
    if (excerpt.includes(lowerQuery)) {
        relevance += 10;
    }

    // Relevancia por categorías
    if (post.categories && post.categories.toLowerCase().includes(lowerQuery)) {
        relevance += 8;
    }

    // Penalizar por antigüedad (opcional)
    if (post.date) {
        const postDate = new Date(post.date);
        const now = new Date();
        const daysDiff = (now - postDate) / (1000 * 60 * 60 * 24);
        if (daysDiff < 30) relevance += 2;
    }

    return relevance;
}

// Ordenar resultados por relevancia
function sortResultsByRelevance(results, query) {
    return results
        .sort((a, b) => b.relevance - a.relevance)
        .slice(0, 10); // Limitar a 10 resultados
}

// Mostrar resultados de búsqueda
function displaySearchResults(results, query) {
    const searchResults = document.getElementById('searchResults');

    if (!results || results.length === 0) {
        searchResults.innerHTML = '<div class="no-results">No se encontraron resultados para "' + escapeHtml(query) + '"</div>';
        showSearchResults();
        return;
    }

    let html = '';

    results.forEach(result => {
        const icon = getResultIcon(result.type, result.source);
        const typeLabel = getTypeLabel(result.type, result.source);

        html += `
            <div class="search-result-item" onclick="handleResultClick('${result.url}', ${result.element ? 'result.element' : 'null'})">
                <div class="search-result-icon">${icon}</div>
                <div class="search-result-content">
                    <div class="search-result-text">${highlightQuery(result.title, query)}</div>
                    <div class="search-result-type">${typeLabel}</div>
                    ${result.excerpt ? `<div class="search-result-excerpt">${highlightQuery(result.excerpt, query)}</div>` : ''}
                    ${result.date ? `<div class="search-result-date">${result.date}</div>` : ''}
                </div>
            </div>
        `;
    });

    searchResults.innerHTML = html;
    showSearchResults();
}

// Manejar clic en resultado
function handleResultClick(url, element) {
    if (element && element !== 'null') {
        // Scroll al elemento en la página actual
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        element.classList.add('highlight');
        setTimeout(() => element.classList.remove('highlight'), 3000);
    } else if (url && url !== '#') {
        // Navegar a la URL
        window.location.href = url;
    }

    hideSearchResults();
}

// Obtener icono según tipo de resultado
function getResultIcon(type, source) {
    const icons = {
        'post': '📄',
        'page': '📋',
        'section': '🔗',
        'current-page': '📍',
        'navigation': '🧭'
    };

    return icons[type] || '📄';
}

// Obtener etiqueta de tipo
function getTypeLabel(type, source) {
    const labels = {
        'post': 'Artículo',
        'page': 'Página',
        'section': 'Sección',
        'current-page': 'En esta página',
        'navigation': 'Navegación'
    };

    let label = labels[type] || 'Contenido';

    if (source === 'wordpress') {
        label += ' (WP)';
    }

    return label;
}

// Resaltar consulta en texto
function highlightQuery(text, query) {
    if (!text || !query) return text;

    const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
}

// Estados de la búsqueda
function showLoadingState() {
    const searchResults = document.getElementById('searchResults');
    searchResults.innerHTML = '<div class="search-loading">🔍 Buscando...</div>';
    showSearchResults();
}

function displaySearchError() {
    const searchResults = document.getElementById('searchResults');
    searchResults.innerHTML = '<div class="search-error">❌ Error en la búsqueda. Intenta de nuevo.</div>';
    showSearchResults();
}

function showSearchResults() {
    const searchResults = document.getElementById('searchResults');
    searchResults.style.display = 'block';
}

function hideSearchResults() {
    const searchResults = document.getElementById('searchResults');
    searchResults.style.display = 'none';
}

// Utilidades
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Limpiar caché periódicamente
setInterval(() => {
    if (searchCache.size > 50) {
        searchCache.clear();
    }
}, 300000); // 5 minutos

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeWordPressSearch);