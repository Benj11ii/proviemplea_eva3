# 📡 ProviEmplea API — Plataforma de Búsqueda Inversa

**Proyecto de Vinculación con el Medio (VcM)**  
**Asignatura:** Desarrollo Backend (IF201IINF) — Unidad 3  
**Instituto Profesional:** San Sebastián

API REST robusta construida en **Laravel 11 (PHP 8.4)** y dockerizada bajo Nginx y MySQL 8.0, diseñada para el Departamento de Empleo de la Municipalidad de Providencia. Implementa el modelo de **búsqueda inversa de talento local** garantizando la no discriminación mediante el estándar de **Curriculum Ciego** (los perfiles públicos se exponen de forma anónima sin datos sensibles).

---

## 🛠️ Stack Tecnológico

| Componente       | Versión                    |
|------------------|----------------------------|
| Framework        | Laravel 11.x               |
| Intérprete PHP   | PHP 8.4 (FPM)              |
| Base de Datos    | MySQL 8.0                  |
| Servidor Web     | Nginx 1.27-Alpine          |
| Contenedores     | Docker Desktop + WSL2      |

---

## 🚀 Requisitos e Instalación Local

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

**3. Ejecutar las migraciones en MySQL:**

> Crea la estructura relacional de personas, empresas e intermediación.

```bash
docker compose exec app php artisan migrate:fresh
```

---

## 📖 Documentación Interactiva (Swagger UI)

Con el entorno corriendo, accede a la especificación interactiva en:

👉 **http://localhost:8080/api/documentation**

### Endpoints disponibles

| Método | Endpoint                    | Descripción                                                    |
|--------|-----------------------------|----------------------------------------------------------------|
| `GET`  | `/api/health`               | Estado de salud del sistema                                    |
| `GET`  | `/api/personas`             | Lista de talentos en formato CV Ciego (anónimos)               |
| `POST` | `/api/personas`             | Registro de nuevo talento (genera UUID y código único)         |
| `GET`  | `/api/personas/{id}`        | Perfil privado con datos de contacto (solo administración)     |
| `POST` | `/api/empresas`             | Registro de empresas empleadoras                               |
| `POST` | `/api/admin/contactos`      | Intermediación laboral (empresa solicita contactar talento)    |
| `GET`  | `/api/admin/estadisticas`   | Métricas de control y seguimiento                              |

---

## 📝 Contrato de Datos

El archivo de especificación OpenAPI oficial en formato YAML se encuentra en la raíz del proyecto como **`swagger.yaml`**.
