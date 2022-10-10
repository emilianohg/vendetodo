# Sistema Vende Todo

## ⚙ Configuración de servidor laravel

Dentro de la carpeta `laravel-vendetodo` debemos crear el archivo `.env` a partir de `.env.example`.

```
cp .env.example .env
```

Posteriormente generamos la `APP_KEY` dentro del archivo `.env` con el comando:
```
php artisan key:generate
```

## ⚡ Encender el sistema

Ejecutar el comando:
```
docker compose up
```
ó en versiones anteriores:
```
docker-compose up
```

# Pendientes
[] Agregar el sail
