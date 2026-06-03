<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Producto;
use App\Models\Categoria;

class SyncBaserowImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'baserow:sync-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza las URLs de imágenes de Baserow con la base de datos local (reemplazando rutas locales)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiUrl = env('BASEROW_API_URL', 'https://api.baserow.io/api');
        $token = env('BASEROW_TOKEN');
        $tableId = 1007645; // El ID de la tabla donde upload_all.js subió las imágenes

        if (!$token) {
            $this->error('Falta el token de Baserow en el archivo .env');
            return;
        }

        $this->info("Obteniendo registros de la tabla de Baserow ($tableId)...");

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ])->get("{$apiUrl}/database/rows/table/{$tableId}/?user_field_names=true&size=200");

        if (!$response->successful()) {
            $this->error("Error al obtener registros de Baserow: " . $response->body());
            return;
        }

        $rows = $response->json('results');
        $this->info("Se encontraron " . count($rows) . " registros en Baserow.");

        $updatedCount = 0;

        foreach ($rows as $row) {
            $nombre = $row['Nombre'] ?? ''; // ej: camas/imagen.jpg
            $url = $row['Notas'] ?? ''; // URL en baserow

            if (!empty($nombre) && !empty($url)) {
                // En MySQL, los productos tienen la ruta 'productos/camas/imagen.jpg'
                $localPath = 'productos/' . $nombre;
                
                // Buscamos si existe un producto con esta imagen local
                $producto = Producto::where('imagen_principal', $localPath)->first();
                if ($producto) {
                    $producto->imagen_principal = $url;
                    $producto->save();
                    $this->info("Actualizado Producto #{$producto->id} con nueva URL.");
                    $updatedCount++;
                }

                // También podríamos revisar si es una categoría, aunque upload_all.js no las procesó
                $catLocalPath = 'categorias/' . basename($nombre);
                $categoria = Categoria::where('imagen', $catLocalPath)->first();
                if ($categoria) {
                    $categoria->imagen = $url;
                    $categoria->save();
                    $this->info("Actualizada Categoría #{$categoria->id} con nueva URL.");
                    $updatedCount++;
                }
            }
        }

        $this->info("¡Sincronización completada! $updatedCount registros actualizados.");
    }
}
