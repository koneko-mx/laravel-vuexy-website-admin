# 🎨 Laravel Vuexy Website Admin - Vuexy Admin

<p align="center">
    <a href="https://koneko.mx" target="_blank"> <img src="https://git.koneko.mx/Koneko-ST/koneko-st/raw/branch/main/logo-images/horizontal-05.png" width="400" alt="Koneko Soluciones Tecnológicas Logo"> </a> 
</p>
<p align="center">
    <a href="https://koneko.mx"><img src="https://img.shields.io/badge/Website-koneko.mx-blue" alt="Sitio Web"></a> 
    <a href="https://packagist.org/packages/koneko/laravel-vuexy-website-admin"><img src="https://img.shields.io/packagist/v/koneko/laravel-vuexy-website-admin" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/koneko/laravel-vuexy-website-admin"><img src="https://img.shields.io/packagist/l/koneko/laravel-vuexy-website-admin" alt="License"></a>
    <a href="https://git.koneko.mx/koneko"><img src="https://img.shields.io/badge/Git%20Server-Koneko%20Git-orange" alt="Servidor Git"></a> 
    <a href="https://github.com/koneko-mx/laravel-vuexy-website-admin/actions/workflows/tests.yml"><img src="https://github.com/koneko-mx/laravel-vuexy-website-admin/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a> 
    <a href="https://github.com/koneko-mx/laravel-vuexy-website-admin/issues"><img src="https://img.shields.io/github/issues/koneko/laravel-vuexy-website-admin" alt="Issues"></a> 
</p>

---

## 📌 Descripción

**Laravel Vuexy Website Admin** es un módulo diseñado para **Laravel Vuexy Admin**, proporcionando [breve descripción de la funcionalidad].

### ✨ Características:
- 🔹 Integración completa con Vuexy Admin.
- 🔹 Funcionalidad clave 1.
- 🔹 Funcionalidad clave 2.

---

## 📦 Instalación

Instalar vía **Composer**:

```bash
composer require koneko/laravel-vuexy-website-admin
```

Publicar archivos de configuración y migraciones (si aplica):

```bash
php artisan vendor:publish --tag=laravel-vuexy-website-admin-config
php artisan migrate
```

---

## 🚀 Uso básico

```php
use Koneko\NombreLibreria\Models\Model;

$model = Model::create([
    'campo1' => 'Valor',
    'campo2' => 'Otro valor',
]);
```

---

## 📚 Configuración adicional

Si necesitas personalizar la configuración del módulo, publica el archivo de configuración:

```bash
php artisan vendor:publish --tag=laravel-vuexy-website-admin-config
```

Esto generará `config/nombre_libreria.php`, donde puedes modificar valores predeterminados.

---

## 🛠 Dependencias

Este paquete requiere las siguientes dependencias:
- Laravel 11
- `koneko/laravel-vuexy-website-admin`
- Dependencias específicas de la librería

---

## 📦 Publicación de Assets y Configuraciones

Para publicar configuraciones y seeders:

```bash
php artisan vendor:publish --tag=laravel-vuexy-website-admin-config
php artisan vendor:publish --tag=laravel-vuexy-website-admin-seeders
php artisan migrate --seed
```

Para publicar imágenes del tema:

```bash
php artisan vendor:publish --tag=laravel-vuexy-website-admin-images
```

---

## 🛠 Pruebas

Ejecuta los tests con:

```bash
php artisan test
```

---

## 🌍 Repositorio Principal y Sincronización

Este repositorio es una **copia sincronizada** del repositorio principal alojado en **[Tea - Koneko Git](https://git.koneko.mx/koneko/laravel-vuexy-website-admin)**.

### 🔄 Sincronización con GitHub
- **Repositorio Principal:** [git.koneko.mx](https://git.koneko.mx/koneko/laravel-vuexy-website-admin)
- **Repositorio en GitHub:** [github.com/koneko/laravel-vuexy-website-admin](https://github.com/koneko/laravel-vuexy-website-admin)
- **Los cambios pueden reflejarse primero en Tea antes de GitHub.**

### 🤝 Contribuciones
Si deseas contribuir:
1. Puedes abrir un **Issue** en [GitHub Issues](https://github.com/koneko/laravel-vuexy-website-admin/issues).
2. Para Pull Requests, **preferimos contribuciones en Tea**. Contacta a `admin@koneko.mx` para solicitar acceso.

⚠️ **Nota:** Algunos cambios pueden tardar en reflejarse en GitHub, ya que este repositorio se actualiza automáticamente desde Tea.

---

## 🏅 Licencia

Este paquete es de código abierto bajo la licencia [MIT](LICENSE).

---

<p align="center">
    Hecho con ❤️ por <a href="https://koneko.mx">Koneko Soluciones Tecnológicas</a>
</p>
