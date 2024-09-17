<?php
// Configuración de la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'clinicasedi';
$backup_dir = 'C:\\Users\\Admin\\Desktop\\Backup\\'; // Escapar las barras invertidas en la ruta

// Verifica si el directorio de backup existe, si no, crea el directorio
if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// Nombre del archivo de backup
$backup_file = $backup_dir . $dbname . '_' . date('Y-m-d_H-i-s') . '.sql';

// Comando para exportar la base de datos
$command = "C:\\xampp\\mysql\\bin\\mysqldump --host=$host --user=$username --password=$password $dbname > \"$backup_file\"";

// Ejecuta el comando
system($command, $output);

// Verifica si el backup se ha creado con éxito
if ($output === 0) {
    echo "Backup creado exitosamente: $backup_file";
} else {
    echo "Error al crear el backup.";
}
?>

