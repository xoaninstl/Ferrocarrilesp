// CONFIGURACIÓN DEL BLOG - PERSONALIZA AQUÍ
const AUTHOR_CONFIG = {
    name: "Tu Nombre",
    bio: "Apasionado del ferrocarril español. Comparto la fascinante historia y actualidad de nuestro sistema ferroviario, desde las primeras locomotoras hasta los trenes de alta velocidad del futuro.",
    photo: "images/autor-foto.jpg",
    blogTitle: "Blog Ferrocarril Esp",
    blogDescription: "Blog enfocado a la historia del ferrocarril en España y las noticias del sector. Comparto contigo la fascinante evolución de nuestro sistema ferroviario, desde las primeras locomotoras de vapor hasta los trenes de alta velocidad del futuro. Descubre proyectos, curiosidades y todo lo que hace que el ferrocarril español sea único en el mundo.",
    social: {
        twitter: "https://twitter.com/tuusuario",
        instagram: "https://instagram.com/tuusuario",
        youtube: "https://youtube.com/@tucanal"
    }
};

// SISTEMA DE CATEGORÍAS JERÁRQUICO COMPLETO
const HIERARCHICAL_CATEGORIES = {
    // SECCIONES HISTÓRICAS (contenido estático/hechos)
    lineas: {
        name: "Líneas",
        color: "#3498db",
        icon: "🚆",
        description: "Información histórica sobre las líneas ferroviarias españolas",
        subcategories: {
            ancho_iberico: "Ancho Ibérico",
            ancho_metrico: "Ancho Métrico",
            ancho_internacional: "Ancho Internacional",
            metro: "Metro",
            tram: "Tram",
            lineas_cerradas: "Líneas Cerradas"
        }
    },
    
    proyectos: {
        name: "Proyectos",
        color: "#e74c3c",
        icon: "📋",
        description: "Proyectos ferroviarios históricos y actuales",
        subcategories: {
            proyectos_cancelados: "Proyectos Cancelados",
            proyectos_actuales: "Proyectos Actuales",
            proyectos_en_marcha: "Proyectos en Marcha",
            proyectos_estudio: "Proyectos Solo en Estudio"
        }
    },
    
    desarrollo_ciudades: {
        name: "Desarrollo Ciudades",
        color: "#27ae60",
        icon: "🏙️",
        description: "Impacto del ferrocarril en el desarrollo urbano",
        subcategories: {
            sevilla: "Sevilla",
            madrid: "Madrid",
            barcelona: "Barcelona"
        }
    },
    
    estaciones_tren: {
        name: "Estaciones de Tren",
        color: "#8e44ad",
        icon: "🚉",
        description: "Historia y características de las estaciones",
        subcategories: {
            mapa_provincias: "Mapa por Provincias"
        }
    },
    
    otras_secciones: {
        name: "Otras Secciones",
        color: "#f39c12",
        icon: "🔍",
        description: "Otros aspectos del ferrocarril español",
        subcategories: {
            curiosidades: "Curiosidades",
            compra_billetes: "Compra de Billetes"
        }
    },
    
    // CATEGORÍAS DE NOTICIAS (contenido dinámico - SOLO en página de noticias)
    noticias: {
        name: "Noticias",
        color: "#1abc9c",
        icon: "📰",
        description: "Noticias actuales del sector ferroviario",
        subcategories: {
            general: "General",
            historia: "Historia",
            tecnologia: "Tecnología"
        }
    },
    
    // CATEGORÍAS DE EVENTOS DEL CALENDARIO (con colores, solo visibles en calendario)
    calendario: {
        name: "Calendario",
        color: "#34495e",
        icon: "📅",
        description: "Eventos y fechas importantes del ferrocarril",
        subcategories: {
            apertura_linea: "Apertura de Línea",
            inicio_obras: "Inicio de Obras",
            fin_obras: "Fin de Obras",
            evento_especial: "Evento Especial",
            mantenimiento: "Mantenimiento",
            aniversario: "Aniversario",
            cambio_horarios: "Cambio de Horarios",
            nueva_tecnologia: "Nueva Tecnología"
        }
    }
};

// TIPOS DE EVENTOS DEL CALENDARIO (con colores sutiles y minimalistas)
const CALENDAR_EVENT_TYPES = {
    apertura_linea: {
        name: "Apertura de Línea",
        color: "#e8f5e8",
        icon: "🚆",
        description: "Inauguración de nuevas líneas ferroviarias"
    },
    inicio_obras: {
        name: "Inicio de Obras",
        color: "#fff3e0",
        icon: "🚧",
        description: "Comienzo de trabajos de construcción"
    },
    fin_obras: {
        name: "Fin de Obras",
        color: "#e3f2fd",
        icon: "✅",
        description: "Finalización de trabajos de construcción"
    },
    evento_especial: {
        name: "Evento Especial",
        color: "#fce4ec",
        icon: "🎉",
        description: "Eventos únicos y especiales"
    },
    mantenimiento: {
        name: "Mantenimiento",
        color: "#f3e5f5",
        icon: "🔧",
        description: "Trabajos de mantenimiento programados"
    },
    aniversario: {
        name: "Aniversario",
        color: "#e0f2f1",
        icon: "🎂",
        description: "Fechas conmemorativas importantes"
    },
    cambio_horarios: {
        name: "Cambio de Horarios",
        color: "#fff8e1",
        icon: "⏰",
        description: "Modificaciones en los horarios de trenes"
    },
    nueva_tecnologia: {
        name: "Nueva Tecnología",
        color: "#e8f5e8",
        icon: "⚡",
        description: "Implementación de nuevas tecnologías"
    }
};

// DATOS DE BÚSQUEDA PARA EL AUTOCMPLETADO
// Se llenará dinámicamente con títulos de entradas reales
const searchData = [];

// FUNCIÓN PARA ACTUALIZAR DATOS DE BÚSQUEDA
function updateSearchData() {
    const allContent = JSON.parse(localStorage.getItem('allContent') || '[]');
    const searchResults = [];
    
    // Añadir títulos de noticias
    allContent.filter(item => item.categories.includes('noticias')).forEach(item => {
        searchResults.push({
            title: item.title,
            url: `#noticia-${item.id}`,
            category: "Noticias"
        });
    });
    
    // Añadir títulos de contenido histórico
    allContent.filter(item => !item.categories.includes('noticias')).forEach(item => {
        searchResults.push({
            title: item.title,
            url: `#contenido-${item.id}`,
            category: "Contenido Histórico"
        });
    });
    
    // Actualizar array global
    searchData.length = 0;
    searchData.push(...searchResults);
    
    return searchResults;
}

// FUNCIÓN PARA AÑADIR CONTENIDO CON MÚLTIPLES CATEGORÍAS
function addContent(title, content, categories, date = null, author = null) {
    const contentEntry = {
        id: Date.now(),
        title: title,
        content: content,
        categories: categories,
        date: date || new Date().toISOString().split('T')[0],
        author: author || AUTHOR_CONFIG.name,
        type: 'content'
    };
    
    // Guardar en localStorage
    let allContent = JSON.parse(localStorage.getItem('allContent') || '[]');
    allContent.push(contentEntry);
    localStorage.setItem('allContent', JSON.stringify(allContent));
    
    // Mostrar notificación
    showNotification(`Contenido "${title}" añadido correctamente`, 'success');
    
    return contentEntry;
}

// FUNCIÓN PARA AÑADIR NOTICIAS CON CATEGORÍAS
function addNewsWithCategory(title, content, categories, date = null) {
    // Asegurar que siempre tenga la categoría "noticias"
    if (!categories.includes('noticias')) {
        categories.push('noticias');
    }
    
    return addContent(title, content, categories, date);
}

// FUNCIÓN PARA AÑADIR EVENTOS DEL CALENDARIO
function addCalendarEvent(date, title, eventType, url = '#') {
    const event = {
        date: date,
        title: title,
        eventType: eventType,
        url: url,
        color: CALENDAR_EVENT_TYPES[eventType]?.color || '#ff6b6b'
    };
    
    // Guardar en localStorage
    let calendarEvents = JSON.parse(localStorage.getItem('calendarEvents') || '[]');
    calendarEvents.push(event);
    localStorage.setItem('calendarEvents', JSON.stringify(calendarEvents));
    
    // Mostrar notificación
    showNotification(`Evento "${title}" añadido al calendario`, 'success');
    
    return event;
}

// FUNCIÓN PARA MOSTRAR NOTICIAS
function displayNews() {
    const newsContainer = document.getElementById('news-container');
    if (!newsContainer) return;
    
    const allContent = JSON.parse(localStorage.getItem('allContent') || '[]');
    const newsContent = allContent.filter(item => 
        item.categories.includes('noticias')
    );
    
    if (newsContent.length === 0) {
        newsContainer.innerHTML = '<p>No hay noticias disponibles.</p>';
        return;
    }
    
    newsContainer.innerHTML = newsContent.map(item => `
        <div class="post">
            <h4>${item.title}</h4>
            <p>${item.content}</p>
            <div class="post-meta">
                <span class="post-date">${item.date}</span>
                <span class="post-author">${item.author}</span>
            </div>
            <div class="post-categories">
                ${item.categories.map(cat => `<span class="post-category">${cat}</span>`).join('')}
            </div>
        </div>
    `).join('');
}

// FUNCIÓN PARA MOSTRAR NOTIFICACIONES
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// EXPORTAR FUNCIONES PARA USO EN OTROS ARCHIVOS
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        AUTHOR_CONFIG,
        HIERARCHICAL_CATEGORIES,
        CALENDAR_EVENT_TYPES,
        searchData,
        addContent,
        addNewsWithCategory,
        addCalendarEvent,
        displayNews,
        showNotification
    };
}
