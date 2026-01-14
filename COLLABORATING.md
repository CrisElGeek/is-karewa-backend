# Guía para desarrolladores

## Instalación
- __Crear directorio del API:__ Se recomienda crear un directorio fuera del directorio publico del servidor donde se agregaran los archivos del API, para  fines de ejemplo de ahora en adelante nombraremos este directorio como APP
- Dentro del directorio APP agregaremos el este repositorio como submodulo de la siguiente manera
```bash
git submodule add git@gitlab.com:criselgeek/chavo-digital-api-rest-core.git app/core
```
- __Conectar el API:__ Ejecutamos el achivo bash _setup_project.sh_ este creará los archivos y directorios necesarios para el nuevo proyecto, si nos da error, corregimos los errores y volvemos a ejecutar el archivo
```bash
sh ./setup_project.sh
```
- __Editar archivo de configuración:__ En el nuevo archivo config.yml ajustamos los parametros para que coincidan con nuestra configuracion. El archivo se puede ir modificando y agregando nuevos parámetros en el futuro
