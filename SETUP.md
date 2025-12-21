# Configuración del Sistema de Tienda CI4

## Requisitos Previos

- PHP 8.0 o superior
- MySQL 5.7 o superior
- Composer
- Servidor web (Apache/Nginx)

## Instalación

### 1. Configurar Base de Datos

1. Crear una base de datos MySQL llamada `tienda_ci4`
2. Copiar el archivo `env` a `.env` en la raíz del proyecto
3. Configurar las credenciales de base de datos en `.env`:

```env
database.default.hostname = localhost
database.default.database = tienda_ci4
database.default.username = tu_usuario
database.default.password = tu_password
```

### 2. Instalar Dependencias

```bash
composer install
```

### 3. Ejecutar Migraciones

```bash
php spark migrate
```

### 4. Crear Usuario Administrador

Ejecutar el siguiente comando para crear un usuario administrador:

```bash
php spark db:seed InitialData
```

O crear manualmente en la base de datos:

```sql
INSERT INTO users (name, email, password, role, created_at, updated_at) 
VALUES ('Administrador', 'admin@tienda.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador', NOW(), NOW());
```

**Contraseña por defecto:** `password`

### 5. Configurar Permisos

Asegurar que los directorios sean escribibles:

```bash
chmod -R 755 writable/
```

### 6. Configurar Servidor Web

#### Apache (.htaccess ya incluido)
El archivo `.htaccess` ya está configurado en la carpeta `public/`.

#### Nginx
```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /ruta/a/tienda-ci4/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Estructura del Sistema

### Roles de Usuario
- **Administrador**: Acceso completo al sistema
- **Vendedor**: Acceso limitado a productos y categorías

### Funcionalidades
- Gestión de usuarios (solo administradores)
- Gestión de categorías
- Gestión de productos con imágenes
- Exportación a Excel y PDF
- Sistema de autenticación
- Panel de administración con AdminLTE

## Seguridad

### Cambios Implementados
1. ✅ Validación CSRF en formularios
2. ✅ Filtros de autenticación en rutas críticas
3. ✅ Validación de tipos MIME para imágenes
4. ✅ Sanitización de datos de entrada
5. ✅ Protección contra XSS con `esc()`
6. ✅ Validación de roles de usuario

### Recomendaciones de Producción
1. Cambiar `encryption.key` en `.env`
2. Configurar HTTPS
3. Usar contraseñas fuertes
4. Configurar backup automático de base de datos
5. Monitorear logs de errores

## Solución de Problemas

### Error de Conexión a Base de Datos
- Verificar credenciales en `.env`
- Asegurar que MySQL esté ejecutándose
- Verificar que la base de datos existe

### Error de Permisos
- Verificar permisos en carpeta `writable/`
- Asegurar que el servidor web tenga permisos de escritura

### Error de Migraciones
- Verificar que todas las tablas se crearon correctamente
- Ejecutar `php spark migrate:rollback` y luego `php spark migrate`

## Contacto

Para soporte técnico, contactar al administrador del sistema. 