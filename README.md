# ACF Blocks Starter

Plugin base para crear bloques Gutenberg personalizados con **ACF Pro V3**, **Tailwind CSS** y **mejores prácticas SEO**.

## 🚀 Características

- ✅ **ACF Pro 6.6+ Blocks V3** - Panel expandido de edición
- ✅ **Tailwind CSS** con prefijo `acfb-` para evitar conflictos
- ✅ **WordPress Playground** - Entorno Node.js sin XAMPP/MAMP
- ✅ **HTML5 Semántico** - SEO-friendly por diseño
- ✅ **Schema.org** contextual y opcional
- ✅ **JavaScript Vanilla** - Sin dependencias externas
- ✅ **Paleta personalizable** - Colores primary/accent/secondary
- ✅ **Auto-registro** de bloques
- ✅ **ACF JSON Sync** - Sincronización de campos

## 📦 Inicio Rápido

### Opción A: WordPress Local (⭐ Recomendado para Windows)

```bash
# 1. Instalar dependencias
npm install

# 2. Copiar plugin a tu instalación WordPress
# Reemplazar ruta con tu instalación local
cp -r . /path/to/wordpress/wp-content/plugins/acf-blocks-starter

# 3. Activar plugin en WordPress Admin
# 4. Compilar Tailwind en modo watch
npm run dev
```

### Opción B: WordPress Playground (Linux/Mac)

```bash
# 1. Instalar dependencias
npm install

# 2. Configurar licencia ACF en server.js (línea 17)
# Reemplazar: YOUR_ACF_LICENSE_KEY

# 3. Iniciar WordPress Playground + Tailwind
npm run dev:playground
```

**Acceder a**: http://localhost:8888/wp-admin  
**Usuario**: admin | **Contraseña**: password

> ⚠️ **Nota**: WordPress Playground tiene problemas de compatibilidad con Windows. Si `npm run dev:playground` falla, usa la **Opción A** con WordPress local.

## 📁 Estructura del Proyecto

```
acf-blocks-starter/
├── .github/instructions/     # Guías para agentes LLM
│   ├── setup.md
│   ├── acf-blocks-v3.md
│   ├── tailwind-prefix.md
│   ├── javascript-vanilla.md
│   ├── html-semantico.md
│   ├── schema-org-contextual.md
│   └── build-plugin.md
├── acf-json/                 # ACF field groups (auto-sync)
├── blocks/                   # Bloques Gutenberg
│   ├── example-hero/
│   │   ├── block.json       # Config bloque (blockVersion: 3)
│   │   ├── fields.php       # ACF fields
│   │   └── render.php       # Template PHP
│   └── example-gallery/
│       ├── block.json
│       ├── fields.php
│       └── render.php
│   └── popup-modal/
│       ├── block.json
│       ├── fields.php
│       ├── render.php
│       └── popup-modal.js
├── includes/
│   ├── acf-setup.php        # ACF JSON sync
│   ├── register-blocks.php  # Auto-registro
│   └── schema-helper.php    # Helpers Schema.org
├── src/styles/
│   └── blocks.css           # Tailwind source
├── dist/
│   └── blocks.css           # CSS compilado
├── plugin.php               # Archivo principal
├── tailwind.config.js       # Config Tailwind + paleta
└── package.json
```

## 🎨 Bloques Incluidos

### Hero Section
Sección hero con imagen de fondo, título H1 y subtítulo. HTML semántico (`<header>`).

### Gallery
Galería responsive:
- **Mobile**: Carrusel vanilla JS con touch swipe
- **Desktop**: Grid 2/3/4 columnas
- **Schema.org**: ImageGallery opcional

### Popup Modal
Ventana emergente configurable:
- **Timer**: Retraso de aparición ajustable.
- **Cierre**: Botón "X", clic en overlay o tecla ESC.
- **Persistencia**: Uso de `localStorage` con expiración en horas.

## 🛠️ Scripts NPM

```bash
npm run dev                # Compilar Tailwind en modo watch
npm run dev:playground     # WordPress Playground + Tailwind (Linux/Mac)
npm run tailwind:build     # Compilar CSS producción
npm run build:plugin       # Generar ZIP instalable
```

> **Nota**: En Windows, usa `npm run dev` + WordPress local. En Linux/Mac puedes usar `npm run dev:playground`.

## 📚 Documentación

Consulta `.github/instructions/` para:
- **Setup inicial** y troubleshooting
- **ACF Blocks V3** configuración correcta
- **Tailwind** con prefijo obligatorio
- **JavaScript vanilla** sin librerías
- **HTML semántico** por tipo de contenido
- **Schema.org** contextual
- **Build** y distribución

## 🎓 Para Estudiantes

Este repositorio está diseñado para aprender:

1. **HTML5 semántico** - Elementos correctos por contexto
2. **Tailwind CSS** - Utility-first con prefijo custom
3. **ACF Pro** - Bloques V3 con panel expandido
4. **JavaScript vanilla** - Sin dependencias externas
5. **SEO** - Schema.org y mejores prácticas
6. **WordPress Blocks API** - Estándar moderno

### Crear Tu Propio Bloque

```bash
# 1. Crear carpeta
mkdir blocks/mi-bloque

# 2. Copiar estructura desde example-hero o example-gallery
# 3. Modificar block.json (name, title)
# 4. Crear fields en ACF UI o fields.php
# 5. Diseñar template en render.php

# El bloque aparecerá automáticamente en el editor
```

## 🎯 Mejores Prácticas

### ✅ Hacer
- Usar prefijo `acfb-` en TODAS las clases Tailwind
- HTML semántico (`<header>`, `<nav>`, `<ul>`, etc.)
- JavaScript vanilla para interactividad
- Schema.org solo donde tenga sentido
- Probar en mobile y desktop

### ❌ Evitar
- CSS custom fuera de Tailwind
- Librerías JS externas sin aprobación
- Clases Tailwind sin prefijo
- `<div>` para listas repetitivas
- Schema.org en bloques decorativos

## 📋 Requisitos

- **WordPress** 6.2+
- **PHP** 7.4+
- **Node.js** 18+
- **ACF Pro** 6.6+ con licencia dev/agency

## 📄 Licencia

GPL v2 or later

## 👤 Autor

**Pablo Silva Pastén Sil7en**  
GitHub: [@sil7en](https://github.com/sil7en)

---

**¿Listo para crear bloques increíbles?** 🚀

### Windows:
1. `npm install`
2. Copiar plugin a `wp-content/plugins/` de tu WordPress local
3. Activar plugin en WordPress Admin
4. `npm run dev` (compila Tailwind)
5. ¡Crear tu primer bloque!

### Linux/Mac:
1. `npm install`
2. Configurar licencia ACF en `server.js`
3. `npm run dev:playground`
4. Abrir http://localhost:8888/wp-admin
5. ¡Crear tu primer bloque!