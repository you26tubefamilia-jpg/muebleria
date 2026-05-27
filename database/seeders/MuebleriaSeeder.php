<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\ImagenProducto;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\File;

class MuebleriaSeeder extends Seeder
{
    public function run(): void
    {
        // ── Usuario Admin ──
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@muebleria.com',
            'password' => bcrypt('password'),
            'rol' => 'admin',
        ]);

        // ── Categorías (coinciden con las carpetas de imágenes) ──
        $categorias = [
            ['nombre' => 'Camas', 'descripcion' => 'Camas individuales, matrimoniales, king size y literas con diseños modernos y tradicionales.'],
            ['nombre' => 'Cocina', 'descripcion' => 'Muebles de cocina: alacenas, gabinetes, barras, islas y organizadores.'],
            ['nombre' => 'Comedores', 'descripcion' => 'Juegos de comedor, mesas, sillas, vitrinas y buffets para tu hogar.'],
            ['nombre' => 'Gaveteros', 'descripcion' => 'Gaveteros, cómodas, cajoneras y muebles de almacenamiento.'],
            ['nombre' => 'Puertas', 'descripcion' => 'Puertas de madera, puertas corredizas, principales y de interiores.'],
        ];
        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }

        // ── Proveedores ──
        Proveedor::create(['nombre' => 'Muebles del Norte S.A.', 'contacto' => 'Carlos Mendoza', 'telefono' => '8181234567', 'email' => 'ventas@mueblednorte.com', 'ciudad' => 'Monterrey', 'estado' => 'Nuevo León']);
        Proveedor::create(['nombre' => 'Maderas Finas de Oaxaca', 'contacto' => 'María López', 'telefono' => '9511234567', 'email' => 'contacto@maderasfinas.mx', 'ciudad' => 'Oaxaca', 'estado' => 'Oaxaca']);
        Proveedor::create(['nombre' => 'Tapicería Guadalajara', 'contacto' => 'Roberto Sánchez', 'telefono' => '3331234567', 'email' => 'info@tapiceriagdl.com', 'ciudad' => 'Guadalajara', 'estado' => 'Jalisco']);

        // ── Mapeo: carpeta => categoria_id ──
        $carpetas = [
            'camas' => 1,
            'cocina' => 2,
            'comedores' => 3,
            'gaveteros' => 4,
            'puertas' => 5,
        ];

        // ── Productos por categoría con nombres reales ──
        $productosDef = [
            'camas' => [
                ['nombre' => 'Cama King Size Elegance', 'descripcion_corta' => 'Cama king con cabecera tapizada', 'precio' => 16900, 'stock' => 6, 'sku' => 'CAM-001', 'material' => 'Madera / Terciopelo', 'color' => 'Gris', 'dimensiones' => '200x210x120 cm', 'destacado' => true],
                ['nombre' => 'Cama Matrimonial Moderna', 'descripcion_corta' => 'Diseño minimalista con respaldo acolchado', 'precio' => 12500, 'stock' => 8, 'sku' => 'CAM-002', 'material' => 'MDF / Tela', 'color' => 'Beige', 'dimensiones' => '160x200x110 cm'],
                ['nombre' => 'Cama Individual Juvenil', 'descripcion_corta' => 'Ideal para recámaras pequeñas', 'precio' => 5800, 'precio_oferta' => 4900, 'stock' => 15, 'sku' => 'CAM-003', 'material' => 'Madera de pino', 'color' => 'Natural'],
                ['nombre' => 'Litera Doble con Cajones', 'descripcion_corta' => 'Litera resistente con almacenamiento inferior', 'precio' => 14200, 'stock' => 4, 'sku' => 'CAM-004', 'material' => 'Madera maciza', 'color' => 'Chocolate'],
                ['nombre' => 'Cama Queen con Plataforma', 'descripcion_corta' => 'Base con sistema de almacenaje hidráulico', 'precio' => 13800, 'precio_oferta' => 11500, 'stock' => 7, 'sku' => 'CAM-005', 'material' => 'MDF laminado', 'color' => 'Blanco', 'destacado' => true],
                ['nombre' => 'Cama Capitoneada Premium', 'descripcion_corta' => 'Cabecera capitoneada en piel sintética', 'precio' => 19500, 'stock' => 3, 'sku' => 'CAM-006', 'material' => 'Piel sintética', 'color' => 'Negro'],
            ],
            'cocina' => [
                ['nombre' => 'Alacena Moderna 3 Puertas', 'descripcion_corta' => 'Alacena con entrepaños ajustables', 'precio' => 7800, 'stock' => 6, 'sku' => 'COC-001', 'material' => 'Melamina', 'color' => 'Blanco', 'destacado' => true],
                ['nombre' => 'Gabinete Inferior de Cocina', 'descripcion_corta' => 'Gabinete con 2 cajones y puerta', 'precio' => 5200, 'stock' => 10, 'sku' => 'COC-002', 'material' => 'MDF', 'color' => 'Gris Claro'],
                ['nombre' => 'Isla de Cocina con Barra', 'descripcion_corta' => 'Isla multifuncional con cubierta de granito', 'precio' => 18500, 'precio_oferta' => 15900, 'stock' => 3, 'sku' => 'COC-003', 'material' => 'Madera / Granito', 'color' => 'Natural / Negro', 'destacado' => true],
                ['nombre' => 'Banco Alto para Barra', 'descripcion_corta' => 'Banco industrial con respaldo', 'precio' => 2200, 'stock' => 20, 'sku' => 'COC-004', 'material' => 'Metal / Madera', 'color' => 'Negro / Natural'],
                ['nombre' => 'Mueble Organizador de Cocina', 'descripcion_corta' => 'Estantería con canastas y ganchos', 'precio' => 3800, 'stock' => 12, 'sku' => 'COC-005', 'material' => 'Metal / MDF', 'color' => 'Blanco'],
            ],
            'comedores' => [
                ['nombre' => 'Comedor Rústico 6 Sillas', 'descripcion_corta' => 'Mesa de parota con sillas tapizadas', 'precio' => 24500, 'precio_oferta' => 19900, 'stock' => 5, 'sku' => 'COM-001', 'material' => 'Madera de parota', 'color' => 'Natural', 'destacado' => true],
                ['nombre' => 'Comedor Moderno 4 Sillas', 'descripcion_corta' => 'Diseño contemporáneo con vidrio templado', 'precio' => 15800, 'stock' => 8, 'sku' => 'COM-002', 'material' => 'Metal / Vidrio', 'color' => 'Negro / Transparente'],
                ['nombre' => 'Silla de Comedor Elegance', 'descripcion_corta' => 'Silla tapizada con patas doradas', 'precio' => 2800, 'stock' => 24, 'sku' => 'COM-003', 'material' => 'Metal / Tela', 'color' => 'Beige'],
                ['nombre' => 'Mesa Extensible para 8', 'descripcion_corta' => 'Mesa que se extiende de 6 a 8 personas', 'precio' => 18900, 'stock' => 4, 'sku' => 'COM-004', 'material' => 'Madera de encino', 'color' => 'Nogal', 'destacado' => true],
                ['nombre' => 'Vitrina Colonial de Madera', 'descripcion_corta' => 'Vitrina con puertas de vidrio biselado', 'precio' => 12800, 'precio_oferta' => 10500, 'stock' => 3, 'sku' => 'COM-005', 'material' => 'Madera de cedro', 'color' => 'Nogal'],
                ['nombre' => 'Buffet Aparador Clásico', 'descripcion_corta' => 'Aparador con cajones y puertas talladas', 'precio' => 11200, 'stock' => 5, 'sku' => 'COM-006', 'material' => 'Madera maciza', 'color' => 'Caoba'],
            ],
            'gaveteros' => [
                ['nombre' => 'Gavetero 6 Cajones Venecia', 'descripcion_corta' => 'Amplio gavetero con tiradores dorados', 'precio' => 9800, 'precio_oferta' => 8200, 'stock' => 7, 'sku' => 'GAV-001', 'material' => 'Madera de pino', 'color' => 'Blanco / Dorado', 'destacado' => true],
                ['nombre' => 'Cómoda 4 Cajones Moderna', 'descripcion_corta' => 'Diseño nórdico con patas altas', 'precio' => 6500, 'stock' => 10, 'sku' => 'GAV-002', 'material' => 'MDF laminado', 'color' => 'Natural'],
                ['nombre' => 'Cajonera Vertical Slim', 'descripcion_corta' => 'Ideal para espacios reducidos', 'precio' => 4200, 'stock' => 14, 'sku' => 'GAV-003', 'material' => 'MDF', 'color' => 'Gris'],
                ['nombre' => 'Gavetero Rústico de Madera', 'descripcion_corta' => 'Acabado envejecido artesanal', 'precio' => 8900, 'stock' => 5, 'sku' => 'GAV-004', 'material' => 'Madera reciclada', 'color' => 'Multi-tono'],
                ['nombre' => 'Tocador con Espejo y Cajones', 'descripcion_corta' => 'Tocador completo con banco incluido', 'precio' => 11500, 'precio_oferta' => 9800, 'stock' => 4, 'sku' => 'GAV-005', 'material' => 'MDF / Espejo', 'color' => 'Blanco', 'destacado' => true],
            ],
            'puertas' => [
                ['nombre' => 'Puerta Principal de Madera', 'descripcion_corta' => 'Puerta tallada a mano con herraje', 'precio' => 15800, 'stock' => 6, 'sku' => 'PUE-001', 'material' => 'Madera de caoba', 'color' => 'Caoba', 'destacado' => true],
                ['nombre' => 'Puerta Corrediza Barn Door', 'descripcion_corta' => 'Estilo granero con riel de acero', 'precio' => 8900, 'stock' => 8, 'sku' => 'PUE-002', 'material' => 'Madera / Acero', 'color' => 'Natural / Negro'],
                ['nombre' => 'Puerta Interior Lisa', 'descripcion_corta' => 'Puerta de paso con acabado liso', 'precio' => 3200, 'stock' => 20, 'sku' => 'PUE-003', 'material' => 'MDF', 'color' => 'Blanco'],
                ['nombre' => 'Puerta con Vitral Decorativo', 'descripcion_corta' => 'Puerta con cristal emplomado artesanal', 'precio' => 22000, 'precio_oferta' => 18500, 'stock' => 2, 'sku' => 'PUE-004', 'material' => 'Madera / Vitral', 'color' => 'Nogal', 'destacado' => true],
                ['nombre' => 'Puerta Doble de Entrada', 'descripcion_corta' => 'Juego de puertas con arco superior', 'precio' => 28500, 'stock' => 3, 'sku' => 'PUE-005', 'material' => 'Madera maciza', 'color' => 'Chocolate'],
            ],
        ];

        // Obtener archivos de imagen de cada carpeta
        foreach ($productosDef as $carpeta => $productos) {
            $catId = $carpetas[$carpeta];
            $rutaBase = storage_path("app/public/productos/{$carpeta}");
            $imagenes = collect(File::files($rutaBase))
                ->map(fn($f) => $f->getFilename())
                ->values()
                ->toArray();

            $imgIndex = 0;
            $imgCount = count($imagenes);

            foreach ($productos as $i => $prodData) {
                $prodData['categoria_id'] = $catId;
                $prodData['proveedor_id'] = rand(1, 3);

                // Asignar imagen principal
                if ($imgCount > 0) {
                    $prodData['imagen_principal'] = "productos/{$carpeta}/" . $imagenes[$imgIndex % $imgCount];
                    $imgIndex++;
                }

                $producto = Producto::create($prodData);

                // Asignar imágenes adicionales a la galería (3-4 por producto)
                $galCount = min(4, $imgCount - 1);
                for ($g = 0; $g < $galCount; $g++) {
                    if ($imgIndex < $imgCount) {
                        ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'ruta' => "productos/{$carpeta}/" . $imagenes[$imgIndex % $imgCount],
                            'orden' => $g,
                        ]);
                        $imgIndex++;
                    }
                }
            }
        }

        // ── Clientes ──
        $clientes = [
            ['nombre' => 'Juan', 'apellidos' => 'García Hernández', 'telefono' => '5551234567', 'email' => 'juan.garcia@email.com', 'ciudad' => 'CDMX', 'estado' => 'CDMX', 'codigo_postal' => '06000'],
            ['nombre' => 'Ana', 'apellidos' => 'Martínez López', 'telefono' => '5559876543', 'email' => 'ana.martinez@email.com', 'ciudad' => 'CDMX', 'estado' => 'CDMX', 'codigo_postal' => '06700'],
            ['nombre' => 'Roberto', 'apellidos' => 'Sánchez Pérez', 'telefono' => '8187654321', 'email' => 'roberto.sanchez@email.com', 'ciudad' => 'Monterrey', 'estado' => 'Nuevo León', 'codigo_postal' => '64000'],
            ['nombre' => 'Laura', 'apellidos' => 'Torres Rivera', 'telefono' => '3341234567', 'email' => 'laura.torres@email.com', 'ciudad' => 'Guadalajara', 'estado' => 'Jalisco', 'codigo_postal' => '44100'],
            ['nombre' => 'Pedro', 'apellidos' => 'Ramírez Díaz', 'telefono' => '2221234567', 'email' => 'pedro.ramirez@email.com', 'ciudad' => 'Puebla', 'estado' => 'Puebla', 'codigo_postal' => '72000'],
        ];
        foreach ($clientes as $cli) {
            Cliente::create($cli);
        }
    }
}
