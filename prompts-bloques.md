# Prompts para Crear Bloques Gutenberg

Guía para escribir prompts efectivos que generen bloques de alta calidad con ACF Pro V3, Tailwind CSS y mejores prácticas SEO.

## Estructura del Prompt Ideal

```
Necesito crear un bloque [NOMBRE] que [FUNCIÓN].

CONTEXTO:
- [Dónde se usará y por qué]
- [Tipo de contenido que mostrará]

CAMPOS ACF:
- [Campo 1]: [tipo] - [propósito]
- [Campo 2]: [tipo] - [propósito]

DISEÑO:
- Mobile: [comportamiento específico]
- Desktop: [comportamiento específico]
- Colores: [paleta a usar: primary/accent/secondary]

HTML:
- Elemento semántico: <[elemento]>
- [Estructura específica si es compleja]

INTERACTIVIDAD:
- [Comportamiento con vanilla JS si aplica]
- [Eventos específicos: click, hover, scroll, etc.]

SEO:
- Schema.org: [tipo de schema si aplica, o "no aplica"]
- [Razón por la que aplica o no]
```

## Ejemplos de Prompts Efectivos

### ❌ Prompt Pobre

```
crea un bloque de testimonios
```

**Problemas:**
- No especifica campos
- No define diseño
- No menciona comportamiento
- No considera SEO

### ✅ Prompt Óptimo

```
Necesito crear un bloque "Testimonios Carousel" que muestre opiniones de clientes.

CONTEXTO:
- Se usará en homepage y páginas de servicios
- Muestra 3-6 testimonios con rotación automática

CAMPOS ACF:
- testimonials: repeater
  - author_name: text - Nombre del cliente
  - author_role: text - Cargo/empresa
  - author_image: image - Foto 100x100px
  - testimonial_text: textarea - Máximo 280 caracteres
  - rating: range (1-5) - Estrellas
- autoplay: true_false - Rotación automática
- autoplay_speed: number - Segundos entre slides (default: 5)

DISEÑO:
- Mobile: 1 testimonio por vista, swipe horizontal
- Desktop: 3 testimonios visibles, navegación con flechas
- Colores: fondo acfb-bg-secondary-50, texto acfb-text-main-black
- Estrellas: acfb-text-accent-main llenas, acfb-text-secondary-200 vacías

HTML:
- Elemento semántico: <section> con role="region" aria-label="Testimonios"
- Cada testimonio: <figure> con <blockquote> y <figcaption>
- Lista de testimonios: <ul> no <div>

INTERACTIVIDAD:
- Vanilla JS: carousel con touch swipe
- Pausar autoplay al hover
- Navegación teclado: flechas izquierda/derecha
- Indicadores de posición (dots) clickeables

SEO:
- Schema.org: Review (solo si rating >= 4)
- itemProp en author, reviewBody, ratingValue
- No usar schema si es decorativo sin ratings
```

## Elementos Clave por Tipo de Bloque

### Bloques de Contenido (Hero, Banner, CTA)

```
CAMPOS: Título (h1/h2/h3), subtítulo, imagen, botón(es)
HTML: <header>, <section>, <article> según contexto
SCHEMA: Ninguno (decorativo)
JS: Animaciones entrada con IntersectionObserver
```

### Bloques de Lista (Servicios, Features, Team)

```
CAMPOS: Repeater con ícono/imagen, título, descripción
HTML: <ul> obligatorio, cada item <li> con heading apropiado
SCHEMA: ItemList si es contenido indexable
JS: Filtros, búsqueda, lazy loading de imágenes
```

### Bloques de Media (Galería, Video, Slider)

```
CAMPOS: Repeater de imágenes/videos, configuración UI
HTML: <figure>, <figcaption>, atributos aria
SCHEMA: ImageGallery o VideoObject
JS: Lightbox, carousel, lazy loading obligatorio
```

### Bloques de Datos (Testimonios, FAQs, Pricing)

```
CAMPOS: Repeater estructurado, toggles de schema
HTML: Semántico según tipo (<dl> para FAQs)
SCHEMA: Review, FAQPage, Offer (crucial para SEO)
JS: Expand/collapse, filtros, comparadores
```

### Bloques de Formulario (Contact, Newsletter, Search)

```
CAMPOS: Configuración, no crear inputs (usar Contact Form 7)
HTML: Wrapper <section>, integrar shortcode
SCHEMA: Ninguno (formularios no se indexan)
JS: Validación, AJAX, feedback visual
```

## Checklist de Prompt Completo

Antes de enviar tu prompt, verifica:

- [ ] **Nombre descriptivo** del bloque (kebab-case)
- [ ] **Contexto de uso** específico
- [ ] **Todos los campos ACF** con tipo y propósito
- [ ] **Diseño mobile Y desktop** detallado
- [ ] **Elemento HTML semántico** correcto
- [ ] **Clases Tailwind con prefijo** acfb-
- [ ] **Paleta de colores** definida (primary/accent/secondary)
- [ ] **JavaScript vanilla** si hay interactividad
- [ ] **Schema.org justificado** (por qué sí o no)
- [ ] **Accesibilidad** (aria-labels, roles, alt)

## Vocabulario Preciso

### Tipos de Campo ACF
```
text, textarea, wysiwyg, image, gallery, file
true_false, select, checkbox, radio, button_group
number, range, email, url, password
date_picker, color_picker, link
repeater, group, flexible_content, clone
post_object, relationship, taxonomy, user
```

### Elementos HTML5 Semánticos
```
<header>     - Encabezado de sección
<nav>        - Navegación principal
<main>       - Contenido principal
<article>    - Contenido independiente
<section>    - Sección temática
<aside>      - Contenido relacionado
<footer>     - Pie de sección
<figure>     - Contenido visual con caption
<time>       - Fechas y horas
<address>    - Información de contacto
```

### Tipos de Schema.org Comunes
```
Article, BlogPosting, NewsArticle
ImageGallery, ImageObject, VideoObject
Review, AggregateRating
FAQPage, Question, Answer
Product, Offer, PriceSpecification
Organization, Person, LocalBusiness
Event, Recipe, HowTo
```

### Clases Tailwind Frecuentes (con prefijo acfb-)
```
Layout: flex, grid, container, mx-auto
Spacing: p-{n}, m-{n}, space-{x|y}-{n}
Sizing: w-full, h-screen, max-w-{size}
Typography: text-{size}, font-{weight}, leading-{size}
Colors: bg-primary-{50-500}, text-accent-main
Responsive: sm:, md:, lg:, xl:, 2xl:
Effects: hover:, focus:, transition, duration-{n}
```

## Errores Comunes a Evitar

### ❌ Vago
```
"un slider bonito"
```
### ✅ Específico
```
"carousel de 4 slides con transición fade, autoplay 6 segundos, navegación dots abajo"
```

---

### ❌ Sin Contexto
```
"bloque de precios"
```
### ✅ Con Contexto
```
"tabla de precios comparativa para 3 planes, destacar plan recomendado, incluir toggle mensual/anual"
```

---

### ❌ Ignorar Accesibilidad
```
"ícono clickeable para abrir modal"
```
### ✅ Accesible
```
"botón con aria-label que abre modal, cerrar con Escape, focus trap dentro del modal"
```

---

### ❌ Asumir Conocimiento
```
"como el típico bloque de features"
```
### ✅ Describir Completamente
```
"grid 3 columnas desktop, 1 columna mobile, cada feature: ícono SVG 48x48, título h3, descripción 2 líneas"
```

## Plantilla Rápida

Copia y completa:

```
Crear bloque "[NOMBRE]" que [ACCIÓN].

CAMPOS:
- [nombre]: [tipo] - [descripción]

MOBILE: [comportamiento]
DESKTOP: [comportamiento]

HTML: <[elemento]>
SCHEMA: [tipo o "no aplica"]
JS: [interactividad o "ninguna"]

COLORES:
- Fondo: acfb-bg-[color]
- Texto: acfb-text-[color]
- Acento: acfb-[color]
```

---

**Recuerda:** Un prompt detallado = código de calidad. Invierte 5 minutos en escribir bien el prompt, ahorra 30 minutos de correcciones.
