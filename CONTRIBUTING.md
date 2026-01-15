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

### Crear claves de seguridad RS256

Dentro del directorio `app/.keys` ejecutamos los siguientes comandos para crear las claves privadas y publicas necesarias para firmar los tokens JWT usando RS256
```bash
ssh-keygen -t rsa -b 4096 -m PEM -f jwtRS256.key
# Don't add passphrase
openssl rsa -in jwtRS256.key -pubout -outform PEM -out jwtRS256.key.pub
```
