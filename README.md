# Prueba Stradata | Michael Garcia

Prueba tecnica para Stradata, hecho con Laravel y VueJs, se genero la ruta necesaria para la ejecucion del filtro con el nombre y el porcentaje de coincidencia,
se reciben por parametro y se compara con la base de datos. Se usaron funciones de PHP y tambien propias de Laravel. Se uso fetch para las peticiones del front.

<br>

## Instalación Laravel

```
composer install
```

Copiar el archivo `.env.example` como `.env`
<br />
Luego generar la llave.

```
php artisan key:generate
```

Ejecutar migraciones

```
php artisan migrate
```

Despues importar la base de datos ubicado en `/database/prueba-stradata.sql`

## Instalación Front

```
yarn install
```

```
yarn dev
```

## Credenciales de Login

Usuario: me@maikoldev.com
<br/>
Password: 123456789

<br/>
Abrir en servidor local [http://localhost:3000](http://localhost:3000)

<br/>
<br/>

### El proyecto esta corriendo en [http://prueba-stradata.maikoldev.com/public](http://prueba-stradata.maikoldev.com/public)
