# 🏭 Web Almacén

Sistema de gestión de inventario construido con **Laravel 11**, **Docker**, **DropZone** y **Tailwind CSS**.

---

## 📁 Estructura del Proyecto

```
web-almacen/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php        ← Dashboard
│   │   ├── ProductController.php     ← CRUD Productos
│   │   ├── ExitController.php        ← Registro Salidas
│   │   └── UserController.php        ← Registro Usuarios
│   └── Models/
│       ├── Product.php
│       ├── ExitRecord.php
│       └── Usuario.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_products_table.php
│   │   ├── ..._create_usuarios_table.php
│   │   └── ..._create_exit_records_table.php
│   └── seeders/
│       └── DatabaseSeeder.php        ← Datos de prueba
├── resources/
│   ├── css/app.css                   ← Tailwind + componentes
│   ├── js/app.js                     ← DropZone + JS
│   └── views/
│       ├── layouts/app.blade.php     ← Layout principal
│       ├── home.blade.php            ← Dashboard
│       ├── products/create.blade.php ← Form Producto + DropZone
│       ├── exits/create.blade.php    ← Form Salida + DropZone
│       └── users/create.blade.php    ← Form Usuario
├── routes/web.php                    ← Rutas
├── docker/
│   ├── Dockerfile
│   └── nginx.conf
├── docker-compose.yml
├── tailwind.config.js
├── vite.config.js
└── setup.sh                         ← Script de instalación
```

---

## 🚀 Instalación (desde cero)

### Requisitos previos
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado y corriendo
- Git

### Pasos

```bash
# 1. Clona / copia el proyecto en tu carpeta de trabajo
cd ~/proyectos        # o donde prefieras
# (si ya tienes la carpeta web-almacen aquí, omite esto)

# 2. Entra a la carpeta
cd web-almacen

# 3. Ejecuta el script de instalación (todo en uno)
bash setup.sh
```

El script hace automáticamente:
- Copia `.env.example` → `.env`
- Levanta los contenedores (PHP, Nginx, MySQL, phpMyAdmin)
- Instala dependencias PHP (Composer)
- Genera `APP_KEY`
- Instala dependencias JS y compila con Vite
- Ejecuta migraciones y seeders
- Crea el symlink de storage

### Acceso
| Servicio    | URL                       |
|-------------|---------------------------|
| App Web     | http://localhost:8080     |
| phpMyAdmin  | http://localhost:8081     |

---

## 🔧 Comandos útiles

```bash
# Levantar contenedores
docker-compose up -d

# Detener contenedores
docker-compose down

# Ver logs
docker-compose logs -f app

# Ejecutar artisan
docker-compose exec app php artisan <comando>

# Compilar assets en modo desarrollo (hot reload)
docker-compose exec app npm run dev

# Compilar assets para producción
docker-compose exec app npm run build

# Correr migraciones desde cero
docker-compose exec app php artisan migrate:fresh --seed
```

---

## 🗺️ Menú y Rutas

| Menú               | URL               | Descripción                          |
|--------------------|-------------------|--------------------------------------|
| Home               | `/`               | Dashboard con estadísticas           |
| Registro Producto  | `/productos/nuevo`| Formulario con DropZone para imagen  |
| Registro Salida    | `/salidas/nuevo`  | Formulario con DropZone comprobante  |
| Registro Usuarios  | `/usuarios/nuevo` | Formulario de alta de usuarios       |

---

## 📋 Formularios

### Registro Producto (con DropZone)
| Campo        | Tipo     | Requerido |
|--------------|----------|-----------|
| Nombre       | text     | ✅        |
| Categoría    | select   | ✅        |
| Precio       | number   | ✅        |
| Stock        | number   | ✅        |
| Código/SKU   | text     |           |
| Unidad       | select   |           |
| Descripción  | textarea |           |
| **Imagen**   | DropZone |           |

### Registro Salida (con DropZone)
| Campo          | Tipo     | Requerido |
|----------------|----------|-----------|
| Producto       | select   | ✅        |
| Cantidad       | number   | ✅        |
| Destino        | text     | ✅        |
| Motivo         | select   | ✅        |
| Responsable    | select   | ✅        |
| Fecha          | date     | ✅        |
| Observaciones  | textarea |           |
| **Comprobante**| DropZone |           |

### Registro Usuario
| Campo        | Tipo     | Requerido |
|--------------|----------|-----------|
| Nombre       | text     | ✅        |
| Apellido     | text     | ✅        |
| Email        | email    | ✅        |
| Teléfono     | tel      |           |
| Rol          | select   | ✅        |
| Departamento | text     |           |
| Contraseña   | password | ✅        |
| Confirmar    | password | ✅        |

---

## 🗄️ Base de Datos

### Tablas

**`products`**
```
id, nombre, categoria, precio, stock, codigo, unidad, descripcion, imagen, timestamps
```

**`usuarios`**
```
id, nombre, apellido, email, telefono, rol, departamento, password, activo, timestamps
```

**`exit_records`**
```
id, producto_id (FK), cantidad, destino, motivo, responsable_id (FK),
fecha_salida, observaciones, comprobante, timestamps
```

### Datos de prueba (seeder)
- 2 usuarios de demostración (`admin@webalmacen.com` / `password`)
- 8 productos de ejemplo con distintas categorías

---

## 🎨 Stack Tecnológico

| Tecnología   | Versión | Uso                               |
|--------------|---------|-----------------------------------|
| Laravel      | 11.x    | Framework PHP                     |
| PHP          | 8.2     | Lenguaje backend                  |
| MySQL        | 8.0     | Base de datos                     |
| Tailwind CSS | 3.4     | Estilos UI                        |
| DropZone.js  | 6.x     | Carga de imágenes drag-and-drop   |
| Vite         | 5.x     | Bundler de assets                 |
| Docker       | —       | Contenerización                   |
| Nginx        | Alpine  | Servidor web                      |
| phpMyAdmin   | —       | Administración de BD              |
