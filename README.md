# ProviEmplea API — Plataforma de Intermediación Laboral y Búsqueda Inversa

> **Iniciativa de Modernización Tecnológica y Vinculación Municipal**  
> Desarrollado para el Departamento de Empleo — **Municipalidad de Providencia, Santiago de Chile**.  
> Arquitectura orientada a la no discriminación laboral mediante el estándar de **Curriculum Ciego**.

API REST robusta construida en **Laravel 11 (PHP 8.4)** y dockerizada bajo Nginx y MySQL 8.0, diseñada para el Departamento de Empleo de la Municipalidad de Providencia. Implementa el modelo de **búsqueda inversa de talento local** garantizando la no discriminación mediante el estándar de **Curriculum Ciego** (los perfiles públicos se exponen de forma anónima sin datos sensibles).

---

## Stack Tecnológico

| Componente     | Versión               |
|----------------|-----------------------|
| Framework      | Laravel 11.x          |
| Intérprete PHP | PHP 8.4 (FPM)         |
| Base de Datos  | MySQL 8.0             |
| Servidor Web   | Nginx 1.27-Alpine     |
| Contenedores   | Docker Desktop + WSL2 |

---

## Requisitos e Instalación Local

### Requisitos previos

- **Docker Desktop** instalado y activo
- Cliente de base de datos como **TablePlus** o **DBeaver** *(opcional, para visualización)*

### Instalación paso a paso

**1. Clonar el repositorio:**

```bash
git clone https://github.com/Benj11ii/proviemplea_eva3.git
cd proviemplea_eva3/backend
```

**2. Levantar los contenedores de Docker:**

> Compila la imagen personalizada de PHP 8.4 e inicializa Nginx y MySQL en el puerto 8080.

```bash
docker compose up -d --build
```

**3. Ejecutar las migraciones y sembrar datos de prueba:**

> Crea la estructura relacional e inserta los datos de prueba oficiales de la guía de endpoints.

```bash
docker compose exec app php artisan migrate:fresh --seed
```

---

## Documentación Interactiva (Swagger UI)

Con el entorno corriendo, accede a la especificación interactiva en:

**http://localhost:8080/api/documentation**

### Endpoints disponibles

| Método   | Endpoint                          | Descripción                                                  |
|----------|-----------------------------------|--------------------------------------------------------------|
| `GET`    | `/api/health`                     | Estado de salud del sistema                                  |
| `GET`    | `/api/personas`                   | Lista de talentos en formato CV Ciego (anónimos)             |
| `POST`   | `/api/personas`                   | Registro de nuevo talento (genera UUID y código único)       |
| `GET`    | `/api/personas/{id}`              | Perfil privado con datos de contacto (solo administración)   |
| `PUT`    | `/api/personas/{id}`              | Actualizar datos del talento                                 |
| `DELETE` | `/api/personas/{id}`              | Desactivar perfil del talento (soft-delete)                  |
| `PATCH`  | `/api/personas/{id}/validar`      | Validar talento para su publicación en la vitrina            |
| `GET`    | `/api/empresas`                   | Listar todas las empresas activas                            |
| `POST`   | `/api/empresas`                   | Registro de empresas empleadoras                             |
| `GET`    | `/api/empresas/{id}`              | Obtener empresa por ID                                       |
| `PUT`    | `/api/empresas/{id}`              | Actualizar datos de la empresa                               |
| `DELETE` | `/api/empresas/{id}`              | Desactivar perfil de la empresa                              |
| `PATCH`  | `/api/empresas/{id}/validar`      | Validar empresa en el directorio oficial                     |
| `GET`    | `/api/admin/contactos`            | Listar todas las solicitudes de intermediación               |
| `POST`   | `/api/admin/contactos`            | Intermediación laboral (empresa solicita contactar talento)  |
| `PATCH`  | `/api/admin/contactos/{id}/estado`| Actualizar estado de intermediación (entrevista, etc.)       |
| `GET`    | `/api/admin/estadisticas`         | Métricas de control y seguimiento                            |

---

## Detalles de Rendimiento, Optimización y Pruebas

### 1. Adaptación de Esquemas según Contexto

La API adapta el flujo de datos según el actor que realiza la consulta para garantizar el **Curriculum Ciego** y la protección de datos sensibles:

| Esquema          | Descripción                                                                                     |
|------------------|-------------------------------------------------------------------------------------------------|
| `PersonaInput`   | Esquema de escritura para registro del talento                                                  |
| `Persona`        | Esquema de lectura administrativa completa (incluye email, teléfono y comprobante)              |
| `PersonaCVCiego` | Esquema de lectura pública — omite datos sociodemográficos e identificables para evitar sesgos  |

---

### 2. Control de Calidad y Pruebas Automatizadas

Se implementó una suite de pruebas funcionales con **PHPUnit** para garantizar la ausencia de errores de regresión.

**Ejecutar pruebas:**

```bash
docker compose exec app php artisan test
```

**Pruebas integradas:**

| Test | Descripción |
|------|-------------|
| `puede_registrar_un_talento_exitosamente` | Verifica la creación del recurso y el código auto-generado |
| `no_permite_registrar_un_talento_con_email_duplicado` | Valida restricciones de unicidad |
| `la_lista_publica_expone_los_datos_en_formato_cv_ciego` | Garantiza que los campos sensibles estén excluidos de la vista pública |

---

### 3. Caché Dinámica e Invalidación

El endpoint `GET /api/personas` almacena en caché el listado de talentos en formato CV Ciego por **10 minutos (600 segundos)** para reducir el impacto de lectura en MySQL.

**Estrategia de consistencia:** las operaciones de escritura (`POST`, `PUT`, `DELETE`, `PATCH /validar`) invalidan la caché inmediatamente via `Cache::forget`, asegurando consistencia en los datos expuestos.

---

### 4. Limitación de Tasa (Rate Limiting)

Todas las rutas de la API (excepto `/health`) están protegidas bajo el middleware `throttle:60,1`:

- Máximo **60 peticiones por minuto** por dirección IP
- Mitiga ataques de denegación de servicio (DoS)
- Garantiza la disponibilidad del servidor bajo carga

---

## Contrato de Datos

El archivo de especificación OpenAPI oficial en formato YAML se encuentra en:
Directorio storage/api-docs/ como **`swagger.yaml`**.
