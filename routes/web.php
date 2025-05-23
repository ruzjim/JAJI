<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\ClientesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PuntoController;
use App\Http\Controllers\ProductoPuntosController;
use App\Http\Controllers\PuntosUsersController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\NotificacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/register', [authController::class, 'register'])->name('register');
Route::post('/login', [authController::class, 'login'])->name('login');
Route::get('/logout', [authController::class, 'logout'])->name('logout');
Route::get('/signin', [authController::class, 'signin'])->name('signin');
// Route::get('/register', [authController::class, 'registerr'])->name('register');

Route::get('/customers', [ClientesController::class, 'index'])->middleware('auth')->name('customers');
Route::post('/agregarCliente', [ClientesController::class, 'agregarCliente'])->name('agregarCliente');
Route::get('/pos', [POSController::class, 'index'])->middleware('auth')->name('pos');


// Route::get('/pos', function () {
    
// })->name('pos');










Route::get('/admin/promociones', function () {
    if (!file_exists(public_path('promociones'))) {
        mkdir(public_path('promociones'), 0755, true);
    }
    $archivos = File::files(public_path('promociones'));
    $imagenesPromociones = collect($archivos)->map(function ($archivo) {
        return asset('promociones/' . basename($archivo));
    });

    return view('admin.promociones.index', compact('imagenesPromociones'));
})->middleware('auth')->name('promociones.index');

Route::post('/admin/promociones/subir', function (Request $request) {
    $request->validate([
        'imagen' => 'required|file|image|mimes:jpeg,jpg,png|max:2048',
    ]);

    if (!$request->hasFile('imagen')) {
        return back()->with('error', 'No se recibió ningún archivo.');
    }

    $imagen = $request->file('imagen');

    if (!$imagen->isValid()) {
        return back()->with('error', 'El archivo no se subió correctamente.');
    }

    $nombreArchivo = uniqid('promo_') . '.' . $imagen->getClientOriginalExtension();

    $imagen->move(public_path('promociones'), $nombreArchivo);

    return redirect()->route('promociones.index')->with('success', 'Imagen subida correctamente.');
})->name('promociones.subir');



Route::post('/admin/promociones/borrar', function (Request $request) {
    $ruta = $request->input('imagen');

    if ($ruta) {
        $nombre = basename($ruta);
        Storage::delete('public/promociones/' . $nombre);
        return redirect()->route('promociones.index')->with('success', 'Imagen eliminada correctamente.');
    }

    return redirect()->route('promociones.index')->with('error', 'No se pudo eliminar la imagen.');
})->name('promociones.borrar');


// Route::get('index', [CustomAuthController::class, 'dashboard']);
// Route::get('signin', [CustomAuthController::class, 'index'])->name('signin');
// Route::post('custom-login', [CustomAuthController::class, 'customSignin'])->name('signin.custom');
// Route::get('register', [CustomAuthController::class, 'registration'])->name('register');
// Route::post('custom-register', [CustomAuthController::class, 'customRegister'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

// Route::get('/', function () {
//     return view('index');
// })->name('index')->middleware('auth');

// Route::get('/index', function () {
//     return view('index');
// })->name('index');
// CRUD Comentarios (HU12)

Route::get('/comentarios', [ComentarioController::class, 'index'])->name('comentarios.index');
Route::get('/comentarios/crear', [ComentarioController::class, 'create'])->middleware('auth')->name('comentarios.create');
Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::get('/comentarios/{id}/editar', [ComentarioController::class, 'edit'])->middleware('auth')->name('comentarios.edit');
Route::put('/comentarios/{id}', [ComentarioController::class, 'update'])->name('comentarios.update');
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
Route::get('/comentarios/cambiar-estado/{id}', [ComentarioController::class, 'cambiarEstado'])->name('comentarios.cambiarEstado');


// CRUD Notificaciones (HU16)

Route::get('/notificaciones', [NotificacionController::class, 'index'])->middleware('auth')->name('notificaciones.index');
Route::get('/notificaciones/crear', [NotificacionController::class, 'create'])->middleware('auth')->name('notificaciones.create');
Route::post('/notificaciones', [NotificacionController::class, 'store'])->middleware('auth')->name('notificaciones.store');
Route::get('/notificaciones/{id}/editar', [NotificacionController::class, 'edit'])->middleware('auth')->name('notificaciones.edit');
Route::put('/notificaciones/{id}', [NotificacionController::class, 'update'])->middleware('auth')->name('notificaciones.update');
Route::delete('/notificaciones/{id}', [NotificacionController::class, 'destroy'])->middleware('auth')->name('notificaciones.destroy');
Route::get('/notificaciones/cambiar-estado/{id}', [NotificacionController::class, 'cambiarEstado'])->middleware('auth')->name('notificaciones.cambiarEstado');


//Rutas producto
Route::get('/product-list', [ProductController::class, 'producto'])->middleware('auth')->name('product-list');
Route::get('/add-product', function () {
    return view('add-product');
})->middleware('auth')->name('add-product');
Route::post('/add-product', [ProductController::class, 'guardarProducto'])->middleware('auth')->name('guardar-producto');
Route::get('/edit-product/{Id_Producto}', [ProductController::class, 'editarProductoGet'])->middleware('auth')->name('edit-product');
Route::post('/edit-product/{Id_Producto}', [ProductController::class, 'actualizarProducto'])->middleware('auth')->name('update-product');
Route::get('/cambiar-estado/{Id_Producto}', [ProductController::class, 'cambiarEstado'])->middleware('auth')->name('cambiar-estado');
Route::get('/productos-expirados', [ProductController::class, 'productosExpirados'])->middleware('auth')->name('productos-expirados');
Route::get('/actualizar-expirados', [EstadisticasController::class, 'actualizarProductosExpirados'])->middleware('auth');


//Rutas Puntos
Route::get('/puntos', [PuntoController::class, 'puntos'])->middleware('auth')->name('puntos');
Route::get('/edit-punto/{Id_Puntos}', [PuntoController::class, 'editarPuntoGet'])->middleware('auth')->name('editar-punto');
Route::put('/edit-punto/{Id_Puntos}', [PuntoController::class, 'actualizarPunto'])->middleware('auth')->name('update-punto');
Route::get('/crear-punto', function () {
    return view('crear-punto');
})->middleware('auth')->name('crear-punto');
Route::post('/crear-punto', [PuntoController::class, 'guardarPunto'])->middleware('auth')->name('guardar-punto');
Route::get('/cambiar-estado-punto/{Id_Puntos}', [PuntoController::class, 'cambiarEstadoPuntos'])->middleware('auth')->name('cambiar-estado-punto');

//Rutas Producto Puntos
Route::get('/producto_puntos', [ProductoPuntosController::class, 'producto_puntosList'])->middleware('auth')->name('producto_puntos');
Route::get('/crear-producto_puntos', [ProductoPuntosController::class, 'crearproductopunto'])->middleware('auth')->name('crear-producto_puntos');
Route::post('/producto_puntos', [ProductoPuntosController::class, 'store'])->middleware('auth')->name('producto_puntos.store');
Route::get('/editar-producto_puntos/{id}', [ProductoPuntosController::class, 'editar'])->middleware('auth')->name('editar-producto_puntos');
Route::put('/editar-producto_puntos/{id}', [ProductoPuntosController::class, 'update'])->middleware('auth')->name('editar-producto_puntos.update');
Route::get('/cambiar-estado-producto-punto/{id}', [ProductoPuntosController::class, 'cambiarEstadoProductosPuntos'])->middleware('auth')->name('cambiar-estado-producto-punto');
Route::get('/producto/{producto_id}/puntos', [ProductoPuntosController::class, 'obtenerPuntosPorProducto'])->middleware('auth');

//Rutas para buscar la cantidad de puntos por numero de cedula de usuario
Route::get('/puntos_users', [PuntosUsersController::class, 'puntosUsersList'])->middleware('auth')->name('puntos_users');
Route::get('/puntos_totales_users', [PuntosUsersController::class, 'buscarPorCedula'])->middleware('auth')->name('puntos_users_buscar');
Route::get('/lista-puntos-users', [PuntosUsersController::class, 'listarUsuariosConPuntos'])->middleware('auth')->name('lista.puntos.users');
Route::get('/expirar-puntos-anual', [PuntosUsersController::class, 'expirarPuntosAnual'])->middleware('auth')->name('expirar.puntos.anual');


//Estadisticas
Route::get('/top-usuarios', [EstadisticasController::class, 'topUsuarios'])->middleware('auth');
Route::get('/total-usuarios', [EstadisticasController::class, 'totalUsuarios'])->middleware('auth');
Route::get('/productos-stock-bajo', [EstadisticasController::class, 'ProductosStockBajo'])->middleware('auth');
Route::get('/index', [EstadisticasController::class, 'productosPorVencer'])->middleware('auth');
Route::get('/', [EstadisticasController::class, 'productosPorVencer'])->middleware('auth');
Route::get('/stockbajo', [EstadisticasController::class, 'productosStockBajo2'])->middleware('auth');
Route::get('/productos_a_vencer', [EstadisticasController::class, 'productosPorVencer2'])->middleware('auth');
Route::get('/total-productos-expirados', [EstadisticasController::class, 'totalProductosExpirados'])->middleware('auth');
Route::get('/total-productos-stock-bajo', [EstadisticasController::class, 'totalProductosStockBajo'])->middleware('auth');
Route::get('/total-productos-por-vencer', [EstadisticasController::class, 'totalProductosPorVencer'])->middleware('auth');

//Ventas
Route::post('/completar-venta', [VentaController::class, 'store'])->middleware('auth');
Route::get('/cierrecaja', [VentaController::class, 'cierrecaja'])->name('cierrecaja')->middleware('auth');
Route::post('/CerrarCaja', [VentaController::class, 'CerrarCaja'])->name('CerrarCaja')->middleware('auth');


//Puntos ganados por usuario
Route::post('/check-user', [ClientesController::class, 'checkUser'])->middleware('auth');

//Reportes
Route::get('/productos_mas_vendidos', [ReportesController::class, 'productosMasVendidos'])->middleware('auth');
Route::get('/producto_users_mas_puntos', [ReportesController::class, 'puntosUsersList'])->middleware('auth');
Route::get('/reporte_diario_ventas', [ReportesController::class, 'reporteDiarioVentas'])->middleware('auth')->name('reportes.ventas-diarias');
Route::get('/reporte_venta_fechas', [ReportesController::class, 'reportePorFechas'])->middleware('auth')->name('reporte.ventas.fechas');

Route::get('/expired-products', function () {
    return view('expired-products');
})->name('expired-products');

Route::get('/low-stocks', function () {
    return view('low-stocks');
})->name('low-stocks');

Route::get('/category-list', function () {
    return view('category-list');
})->name('category-list');

Route::get('/sub-categories', function () {
    return view('sub-categories');
})->name('sub-categories');

Route::get('/brand-list', function () {
    return view('brand-list');
})->name('brand-list');

Route::get('/units', function () {
    return view('units');
})->name('units');

Route::get('/varriant-attributes', function () {
    return view('varriant-attributes');
})->name('varriant-attributes');

Route::get('/warranty', function () {
    return view('warranty');
})->name('warranty');

Route::get('/barcode', function () {
    return view('barcode');
})->name('barcode');

Route::get('/qrcode', function () {
    return view('qrcode');
})->name('qrcode');

Route::get('/product-details', function () {
    return view('product-details');
})->name('product-details');

Route::get('/sales-dashboard', function () {
    return view('sales-dashboard');
})->name('sales-dashboard');

Route::get('/video-call', function () {
    return view('video-call');
})->name('video-call');

Route::get('/audio-call', function () {
    return view('audio-call');
})->name('audio-call');

Route::get('/call-history', function () {
    return view('call-history');
})->name('call-history');

Route::get('/calendar', function () {
    return view('calendar');
})->name('calendar');

Route::get('/email', function () {
    return view('email');
})->name('email');

Route::get('/todo', function () {
    return view('todo');
})->name('todo');

Route::get('/notes', function () {
    return view('notes');
})->name('notes');

Route::get('/file-manager', function () {
    return view('file-manager');
})->name('file-manager');

Route::get('/file-shared', function () {
    return view('file-shared');
})->name('file-shared');

Route::get('/file-document', function () {
    return view('file-document');
})->name('file-document');

Route::get('/file-recent', function () {
    return view('file-recent');
})->name('file-recent');

Route::get('/file-favourites', function () {
    return view('file-favourites');
})->name('file-favourites');

Route::get('/file-archived', function () {
    return view('file-archived');
})->name('file-archived');

Route::get('/file-manager-deleted', function () {
    return view('file-manager-deleted');
})->name('file-manager-deleted');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/manage-stocks', function () {
    return view('manage-stocks');
})->name('manage-stocks');

Route::get('/stock-adjustment', function () {
    return view('stock-adjustment');
})->name('stock-adjustment');

Route::get('/stock-transfer', function () {
    return view('stock-transfer');
})->name('stock-transfer');

Route::get('/purchase-list', function () {
    return view('purchase-list');
})->name('purchase-list');

Route::get('/purchase-order-report', function () {
    return view('purchase-order-report');
})->name('purchase-order-report');

Route::get('/purchase-returns', function () {
    return view('purchase-returns');
})->name('purchase-returns');

Route::get('/expense-list', function () {
    return view('expense-list');
})->name('expense-list');

Route::get('/expense-category', function () {
    return view('expense-category');
})->name('expense-category');

Route::get('/purchase-report', function () {
    return view('purchase-report');
})->name('purchase-report');

Route::get('/employees-grid', function () {
    return view('employees-grid');
})->name('employees-grid');

Route::get('/edit-employee', function () {
    return view('edit-employee');
})->name('edit-employee');

Route::get('/department-grid', function () {
    return view('department-grid');
})->name('department-grid');

Route::get('/designation', function () {
    return view('designation');
})->name('designation');

Route::get('/shift', function () {
    return view('shift');
})->name('shift');

Route::get('/attendance-employee', function () {
    return view('attendance-employee');
})->name('attendance-employee');

Route::get('/attendance-admin', function () {
    return view('attendance-admin');
})->name('attendance-admin');

Route::get('/leaves-admin', function () {
    return view('leaves-admin');
})->name('leaves-admin');

Route::get('/leaves-employee', function () {
    return view('leaves-employee');
})->name('leaves-employee');

Route::get('/leave-types', function () {
    return view('leave-types');
})->name('leave-types');

Route::get('/holidays', function () {
    return view('holidays');
})->name('holidays');

Route::get('/payroll-list', function () {
    return view('payroll-list');
})->name('payroll-list');

Route::get('/payslip', function () {
    return view('payslip');
})->name('payslip');


Route::get('/sales-list', function () {
    return view('sales-list');
})->name('sales-list');

Route::get('/invoice-report', function () {
    return view('invoice-report');
})->name('invoice-report');

Route::get('/sales-returns', function () {
    return view('sales-returns');
})->name('sales-returns');

Route::get('/quotation-list', function () {
    return view('quotation-list');
})->name('quotation-list');



Route::get('/coupons', function () {
    return view('coupons');
})->name('coupons');



Route::get('/suppliers', function () {
    return view('suppliers');
})->name('suppliers');

Route::get('/store-list', function () {
    return view('store-list');
})->name('store-list');

Route::get('/warehouse', function () {
    return view('warehouse');
})->name('warehouse');

Route::get('/ui-accordion', function () {
    return view('ui-accordion');
})->name('ui-accordion');

Route::get('/ui-alerts', function () {
    return view('ui-alerts');
})->name('ui-alerts');

Route::get('/ui-avatar', function () {
    return view('ui-avatar');
})->name('ui-avatar');

Route::get('/ui-badges', function () {
    return view('ui-badges');
})->name('ui-badges');

Route::get('/ui-borders', function () {
    return view('ui-borders');
})->name('ui-borders');

Route::get('/ui-breadcrumb', function () {
    return view('ui-breadcrumb');
})->name('ui-breadcrumb');

Route::get('/ui-buttons-group', function () {
    return view('ui-buttons-group');
})->name('ui-buttons-group');

Route::get('/ui-buttons', function () {
    return view('ui-buttons');
})->name('ui-buttons');

Route::get('/ui-cards', function () {
    return view('ui-cards');
})->name('ui-cards');

Route::get('/ui-carousel', function () {
    return view('ui-carousel');
})->name('ui-carousel');

Route::get('/ui-clipboard', function () {
    return view('ui-clipboard');
})->name('ui-clipboard');

Route::get('/ui-colors', function () {
    return view('ui-colors');
})->name('ui-colors');

Route::get('/ui-counter', function () {
    return view('ui-counter');
})->name('ui-counter');

Route::get('/ui-drag-drop', function () {
    return view('ui-drag-drop');
})->name('ui-drag-drop');

Route::get('/ui-dropdowns', function () {
    return view('ui-dropdowns');
})->name('ui-dropdowns');

Route::get('/ui-grid', function () {
    return view('ui-grid');
})->name('ui-grid');

Route::get('/ui-images', function () {
    return view('ui-images');
})->name('ui-images');

Route::get('/ui-lightbox', function () {
    return view('ui-lightbox');
})->name('ui-lightbox');

Route::get('/ui-media', function () {
    return view('ui-media');
})->name('ui-media');

Route::get('/ui-modals', function () {
    return view('ui-modals');
})->name('ui-modals');

Route::get('/ui-nav-tabs', function () {
    return view('ui-nav-tabs');
})->name('ui-nav-tabs');

Route::get('/ui-offcanvas', function () {
    return view('ui-offcanvas');
})->name('ui-offcanvas');

Route::get('/ui-pagination', function () {
    return view('ui-pagination');
})->name('ui-pagination');

Route::get('/ui-placeholders', function () {
    return view('ui-placeholders');
})->name('ui-placeholders');

Route::get('/ui-popovers', function () {
    return view('ui-popovers');
})->name('ui-popovers');

Route::get('/ui-progress', function () {
    return view('ui-progress');
})->name('ui-progress');

Route::get('/ui-rangeslider', function () {
    return view('ui-rangeslider');
})->name('ui-rangeslider');

Route::get('/ui-rating', function () {
    return view('ui-rating');
})->name('ui-rating');

Route::get('/ui-ribbon', function () {
    return view('ui-ribbon');
})->name('ui-ribbon');

Route::get('/ui-scrollbar', function () {
    return view('ui-scrollbar');
})->name('ui-scrollbar');

Route::get('/ui-spinner', function () {
    return view('ui-spinner');
})->name('ui-spinner');

Route::get('/ui-stickynote', function () {
    return view('ui-stickynote');
})->name('ui-stickynote');

Route::get('/ui-sweetalerts', function () {
    return view('ui-sweetalerts');
})->name('ui-sweetalerts');

Route::get('/ui-text-editor', function () {
    return view('ui-text-editor');
})->name('ui-text-editor');

Route::get('/ui-timeline', function () {
    return view('ui-timeline');
})->name('ui-timeline');

Route::get('/ui-toasts', function () {
    return view('ui-toasts');
})->name('ui-toasts');

Route::get('/ui-tooltips', function () {
    return view('ui-tooltips');
})->name('ui-tooltips');

Route::get('/ui-typography', function () {
    return view('ui-typography');
})->name('ui-typography');

Route::get('/ui-video', function () {
    return view('ui-video');
})->name('ui-video');

Route::get('/chart-apex', function () {
    return view('chart-apex');
})->name('chart-apex');

Route::get('/chart-js', function () {
    return view('chart-js');
})->name('chart-js');

Route::get('/chart-morris', function () {
    return view('chart-morris');
})->name('chart-morris');

Route::get('/chart-flot', function () {
    return view('chart-flot');
})->name('chart-flot');

Route::get('/chart-peity', function () {
    return view('chart-peity');
})->name('chart-peity');

Route::get('/chart-c3', function () {
    return view('chart-c3');
})->name('chart-c3');

Route::get('/icon-fontawesome', function () {
    return view('icon-fontawesome');
})->name('icon-fontawesome');

Route::get('/icon-feather', function () {
    return view('icon-feather');
})->name('icon-feather');

Route::get('/icon-ionic', function () {
    return view('icon-ionic');
})->name('icon-ionic');

Route::get('/icon-material', function () {
    return view('icon-material');
})->name('icon-material');

Route::get('/icon-pe7', function () {
    return view('icon-pe7');
})->name('icon-pe7');

Route::get('/icon-simpleline', function () {
    return view('icon-simpleline');
})->name('icon-simpleline');

Route::get('/icon-themify', function () {
    return view('icon-themify');
})->name('icon-themify');

Route::get('/icon-weather', function () {
    return view('icon-weather');
})->name('icon-weather');

Route::get('/icon-typicon', function () {
    return view('icon-typicon');
})->name('icon-typicon');

Route::get('/icon-flag', function () {
    return view('icon-flag');
})->name('icon-flag');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::get('/roles-permissions', function () {
    return view('roles-permissions');
})->name('roles-permissions');

Route::get('/delete-account', function () {
    return view('delete-account');
})->name('delete-account');

Route::get('/permissions', function () {
    return view('permissions');
})->name('permissions');
Route::get('/form-basic-inputs', function () {
    return view('form-basic-inputs');
})->name('form-basic-inputs');

Route::get('/form-checkbox-radios', function () {
    return view('form-checkbox-radios');
})->name('form-checkbox-radios');

Route::get('/form-input-groups', function () {
    return view('form-input-groups');
})->name('form-input-groups');

Route::get('/form-grid-gutters', function () {
    return view('form-grid-gutters');
})->name('form-grid-gutters');

Route::get('/form-select', function () {
    return view('form-select');
})->name('form-select');

Route::get('/form-mask', function () {
    return view('form-mask');
})->name('form-mask');

Route::get('/form-fileupload', function () {
    return view('form-fileupload');
})->name('form-fileupload');

Route::get('/form-horizontal', function () {
    return view('form-horizontal');
})->name('form-horizontal');

Route::get('/form-vertical', function () {
    return view('form-vertical');
})->name('form-vertical');

Route::get('/form-floating-labels', function () {
    return view('form-floating-labels');
})->name('form-floating-labels');

Route::get('/form-validation', function () {
    return view('form-validation');
})->name('form-validation');

Route::get('/form-select2', function () {
    return view('form-select2');
})->name('form-select2');

Route::get('/form-wizard', function () {
    return view('form-wizard');
})->name('form-wizard');

Route::get('/tables-basic', function () {
    return view('tables-basic');
})->name('tables-basic');

Route::get('/data-tables', function () {
    return view('data-tables');
})->name('data-tables');

Route::get('/sales-report', function () {
    return view('sales-report');
})->name('sales-report');

Route::get('/purchase-report', function () {
    return view('purchase-report');
})->name('purchase-report');

Route::get('/inventory-report', function () {
    return view('inventory-report');
})->name('inventory-report');

Route::get('/invoice-report', function () {
    return view('invoice-report');
})->name('invoice-report');

Route::get('/supplier-report', function () {
    return view('supplier-report');
})->name('supplier-report');

Route::get('/customer-report', function () {
    return view('customer-report');
})->name('customer-report');

Route::get('/expense-report', function () {
    return view('expense-report');
})->name('expense-report');

Route::get('/income-report', function () {
    return view('income-report');
})->name('income-report');

Route::get('/tax-reports', function () {
    return view('tax-reports');
})->name('tax-reports');

Route::get('/profit-and-loss', function () {
    return view('profit-and-loss');
})->name('profit-and-loss');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/under-maintenance', function () {
    return view('under-maintenance');
})->name('under-maintenance');

Route::get('/blank-page', function () {
    return view('blank-page');
})->name('blank-page');

Route::get('/coming-soon', function () {
    return view('coming-soon');
})->name('coming-soon');

Route::get('/countries', function () {
    return view('countries');
})->name('countries');

Route::get('/states', function () {
    return view('states');
})->name('states');

Route::get('/error-404', function () {
    return view('error-404');
})->name('error-404');

Route::get('/error-500', function () {
    return view('error-500');
})->name('error-500');

Route::get('/lock-screen', function () {
    return view('lock-screen');
})->name('lock-screen');

Route::get('/two-step-verification-3', function () {
    return view('two-step-verification-3');
})->name('two-step-verification-3');

Route::get('/two-step-verification-2', function () {
    return view('two-step-verification-2');
})->name('two-step-verification-2');

Route::get('/two-step-verification', function () {
    return view('two-step-verification');
})->name('two-step-verification');

Route::get('/email-verification-3', function () {
    return view('email-verification-3');
})->name('email-verification-3');

Route::get('/email-verification-2', function () {
    return view('email-verification-2');
})->name('email-verification-2');

Route::get('/email-verification', function () {
    return view('email-verification');
})->name('email-verification');

Route::get('/reset-password-3', function () {
    return view('reset-password-3');
})->name('reset-password-3');

Route::get('/reset-password-2', function () {
    return view('reset-password-2');
})->name('reset-password-2');

Route::get('/reset-password', function () {
    return view('reset-password');
})->name('reset-password');

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('forgot-password');

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('forgot-password');

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('forgot-password');







Route::get('/success-3', function () {
    return view('success-3');
})->name('success-3');

Route::get('/success-2', function () {
    return view('success-2');
})->name('success-2');

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/general-settings', function () {
    return view('general-settings');
})->name('general-settings');

Route::get('/security-settings', function () {
    return view('security-settings');
})->name('security-settings');

Route::get('/notification', function () {
    return view('notification');
})->name('notification');

Route::get('/connected-apps', function () {
    return view('connected-apps');
})->name('connected-apps');

Route::get('/system-settings', function () {
    return view('system-settings');
})->name('system-settings');

Route::get('/company-settings', function () {
    return view('company-settings');
})->name('company-settings');

Route::get('/localization-settings', function () {
    return view('localization-settings');
})->name('localization-settings');

Route::get('/prefixes', function () {
    return view('prefixes');
})->name('prefixes');

Route::get('/preference', function () {
    return view('preference');
})->name('preference');

Route::get('/appearance', function () {
    return view('appearance');
})->name('appearance');

Route::get('/social-authentication', function () {
    return view('social-authentication');
})->name('social-authentication');

Route::get('/language-settings', function () {
    return view('language-settings');
})->name('language-settings');

Route::get('/invoice-settings', function () {
    return view('invoice-settings');
})->name('invoice-settings');

Route::get('/printer-settings', function () {
    return view('printer-settings');
})->name('printer-settings');

Route::get('/pos-settings', function () {
    return view('pos-settings');
})->name('pos-settings');

Route::get('/custom-fields', function () {
    return view('custom-fields');
})->name('custom-fields');

Route::get('/email-settings', function () {
    return view('email-settings');
})->name('email-settings');

Route::get('/sms-gateway', function () {
    return view('sms-gateway');
})->name('sms-gateway');

Route::get('/otp-settings', function () {
    return view('otp-settings');
})->name('otp-settings');

Route::get('/gdpr-settings', function () {
    return view('gdpr-settings');
})->name('gdpr-settings');

Route::get('/payment-gateway-settings', function () {
    return view('payment-gateway-settings');
})->name('payment-gateway-settings');

Route::get('/bank-settings-grid', function () {
    return view('bank-settings-grid');
})->name('bank-settings-grid');

Route::get('/tax-rates', function () {
    return view('tax-rates');
})->name('tax-rates');

Route::get('/currency-settings', function () {
    return view('currency-settings');
})->name('currency-settings');

Route::get('/storage-settings', function () {
    return view('storage-settings');
})->name('storage-settings');

Route::get('/ban-ip-address', function () {
    return view('ban-ip-address');
})->name('ban-ip-address');

Route::get('/activities', function () {
    return view('activities');
})->name('activities');

Route::get('/add-employee', function () {
    return view('add-employee');
})->name('add-employee');

Route::get('/bank-settings-list', function () {
    return view('bank-settings-list');
})->name('bank-settings-list');

Route::get('/department-list', function () {
    return view('department-list');
})->name('department-list');

Route::get('/employees-list', function () {
    return view('employees-list');
})->name('employees-list');

Route::get('/language-settings-web', function () {
    return view('language-settings-web');
})->name('language-settings-web');
