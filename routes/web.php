<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SemillaController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


// Rutas de la aplicación protegidas por autenticación
Route::middleware(['auth'])->group(function () {



    // Feed principal
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
    Route::get('/feed/search', [FeedController::class, 'search'])->name('feed.search');

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/{user}', [ProfileController::class, 'showUser'])->name('profile.show_user');

    // Inventario de semillas
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::delete('inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');


    Route::post('/inventory/{inventoryId}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/inventory/{inventoryId}/comment/{commentId}/reply', [CommentController::class, 'reply'])->name('comments.reply');

    // Mensajería
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/create', [MessageController::class, 'create'])->name('create');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/conversation/{contact}', [MessageController::class, 'showConversation'])->name('conversation');
        Route::get('/messages/conversation/{receiver_id}', [MessageController::class, 'getConversation'])->name('messages.conversation');
        Route::get('/messages/conversation/{contactId}', [MessageController::class, 'getConversation']);
        Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');
        Route::post('/messages/mark-as-read/{msgId}', [MessageController::class, 'markAsRead']);
        Route::get('/search-users', [MessageController::class, 'searchUsers']);
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/reportes', [AdminController::class, 'reportes'])->name('admin.reportes');
        // Otras rutas para diferentes reportes
    });

    // Configuración
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::put('/settings/notifications', [SettingsController::class, 'updatenotifications'])->name('settings.notifications.update');
    Route::get('/settings/security', [SettingsController::class, 'security'])->name('settings.security');
    Route::put('/settings/security', [SettingsController::class, 'updatesecurity'])->name('settings.security.update');
    Route::get('/settings/language', [SettingsController::class, 'Language'])->name('settings.language');
    Route::post('/settings/language', [SettingsController::class, 'updateLanguage'])->name('settings.language.update');
    Route::get('/settings/account', [SettingsController::class, 'account'])->name('settings.account');
    Route::post('/settings/account', [SettingsController::class, 'updateAccount'])->name('settings.account.update');
    Route::get('/settings/deactivate', [SettingsController::class, 'deactivate'])->name('settings.deactivate');
    Route::post('/settings/deactivate', [SettingsController::class, 'deactivateAccount'])->name('settings.deactivate');



    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/reportes', [ReportController::class, 'showReport'])->name('admin.report');
    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios');
    Route::get('/admin/usuarios/ver/{id}', [UserController::class, 'show'])->name('admin.usuarios.ver');
    Route::delete('/admin/usuarios/eliminar/{id}', [UserController::class, 'destroy'])->name('admin.usuarios.eliminar');
    Route::get('/admin/semillas', [SemillaController::class, 'index'])->name('admin.semillas');
    Route::get('/admin/semillas/filter', [SemillasController::class, 'filterByMunicipio'])->name('admin.semillas.filter');
    Route::get('/admin/semillas/municipios', [SemillasController::class, 'getMunicipios'])->name('admin.semillas.municipios');
    Route::delete('admin/semillas', [SemillaController::class, 'destroy'])->name('admin.semillas.destroy');

});


