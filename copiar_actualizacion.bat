@echo off
echo ============================================
echo   SCRIPT DE ACTUALIZACION - Pharmalivet
echo   Archivos modificados desde commit 6eb93a8
echo   (Nuevo inicio + correciones de tipo)
echo ============================================
echo.

REM Configura aqui la ruta destino (USB o carpeta)
set DESTINO=D:\Puntos_Actualizacion3

echo Destino: %DESTINO%
echo.
echo Creando estructura de carpetas...

REM Crear carpetas
mkdir "%DESTINO%\app\Config" 2>nul
mkdir "%DESTINO%\app\Controllers" 2>nul
mkdir "%DESTINO%\app\Views\campanias" 2>nul
mkdir "%DESTINO%\app\Views\canjes" 2>nul
mkdir "%DESTINO%\app\Views\category" 2>nul
mkdir "%DESTINO%\app\Views\clientes" 2>nul
mkdir "%DESTINO%\app\Views\compras" 2>nul
mkdir "%DESTINO%\app\Views\dashboard" 2>nul
mkdir "%DESTINO%\app\Views\inicio" 2>nul
mkdir "%DESTINO%\app\Views\layouts" 2>nul
mkdir "%DESTINO%\app\Views\partials" 2>nul
mkdir "%DESTINO%\app\Views\product" 2>nul
mkdir "%DESTINO%\app\Views\profile" 2>nul
mkdir "%DESTINO%\app\Views\user" 2>nul
mkdir "%DESTINO%\public\assets\img" 2>nul
mkdir "%DESTINO%\public\js\dashboard" 2>nul

echo.
echo Copiando Config...
copy "app\Config\Routes.php" "%DESTINO%\app\Config\"

echo Copiando Controllers...
copy "app\Controllers\Canjes.php" "%DESTINO%\app\Controllers\"
copy "app\Controllers\ClientesController.php" "%DESTINO%\app\Controllers\"
copy "app\Controllers\ComprasController.php" "%DESTINO%\app\Controllers\"
copy "app\Controllers\DashboardController.php" "%DESTINO%\app\Controllers\"

echo Copiando Views\campanias...
copy "app\Views\campanias\create.php" "%DESTINO%\app\Views\campanias\"
copy "app\Views\campanias\edit.php" "%DESTINO%\app\Views\campanias\"
copy "app\Views\campanias\gestionar_puntos.php" "%DESTINO%\app\Views\campanias\"
copy "app\Views\campanias\index.php" "%DESTINO%\app\Views\campanias\"

echo Copiando Views\canjes...
copy "app\Views\canjes\index.php" "%DESTINO%\app\Views\canjes\"
copy "app\Views\canjes\ticket.php" "%DESTINO%\app\Views\canjes\"

echo Copiando Views\category...
copy "app\Views\category\create.php" "%DESTINO%\app\Views\category\"
copy "app\Views\category\edit.php" "%DESTINO%\app\Views\category\"
copy "app\Views\category\index.php" "%DESTINO%\app\Views\category\"

echo Copiando Views\clientes...
copy "app\Views\clientes\edit.php" "%DESTINO%\app\Views\clientes\"
copy "app\Views\clientes\index.php" "%DESTINO%\app\Views\clientes\"
copy "app\Views\clientes\puntos.php" "%DESTINO%\app\Views\clientes\"
copy "app\Views\clientes\show.php" "%DESTINO%\app\Views\clientes\"

echo Copiando Views\compras...
copy "app\Views\compras\index.php" "%DESTINO%\app\Views\compras\"
copy "app\Views\compras\ticket.php" "%DESTINO%\app\Views\compras\"
copy "app\Views\compras\ticket_cliente.php" "%DESTINO%\app\Views\compras\"

echo Copiando Views\dashboard...
copy "app\Views\dashboard\index.php" "%DESTINO%\app\Views\dashboard\"

echo Copiando Views\inicio...
copy "app\Views\inicio\index.php" "%DESTINO%\app\Views\inicio\"

echo Copiando Views\layouts...
copy "app\Views\layouts\main.php" "%DESTINO%\app\Views\layouts\"

echo Copiando Views\partials...
copy "app\Views\partials\sidebar.php" "%DESTINO%\app\Views\partials\"

echo Copiando Views\product...
copy "app\Views\product\create.php" "%DESTINO%\app\Views\product\"
copy "app\Views\product\edit.php" "%DESTINO%\app\Views\product\"
copy "app\Views\product\index.php" "%DESTINO%\app\Views\product\"

echo Copiando Views\profile...
copy "app\Views\profile\index.php" "%DESTINO%\app\Views\profile\"

echo Copiando Views\user...
copy "app\Views\user\create.php" "%DESTINO%\app\Views\user\"
copy "app\Views\user\edit.php" "%DESTINO%\app\Views\user\"
copy "app\Views\user\index.php" "%DESTINO%\app\Views\user\"

echo Copiando imagenes...
copy "public\assets\img\Frontis-framacia1.PNG" "%DESTINO%\public\assets\img\"
copy "public\assets\img\farmaceutica1.PNG" "%DESTINO%\public\assets\img\"
copy "public\assets\img\farmaceutica2.PNG" "%DESTINO%\public\assets\img\"
copy "public\assets\img\farmaceutica3.PNG" "%DESTINO%\public\assets\img\"
copy "public\assets\img\farmaceutica4.PNG" "%DESTINO%\public\assets\img\"
copy "public\assets\img\img-1-usuarios.jpg" "%DESTINO%\public\assets\img\"
copy "public\assets\img\xFrontis-framacia1.PNG" "%DESTINO%\public\assets\img\"

echo Copiando JavaScript...
copy "public\js\dashboard\index.js" "%DESTINO%\public\js\dashboard\"

echo.
echo ============================================
echo   COPIA COMPLETADA!
echo   Total: 40 archivos
echo   Destino: %DESTINO%
echo ============================================
echo.
echo INSTRUCCIONES PARA LA PC LOCAL:
echo 1. Copia la carpeta %DESTINO% a la PC local
echo 2. Desde esa carpeta, copia todo a C:\xampp\htdocs\Puntos
echo 3. Reemplaza los archivos cuando pregunte
echo 4. NO toques el archivo .env ni la carpeta writable
echo.
pause
