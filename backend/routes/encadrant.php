use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Encadrant\DocumentController as EncadrantDocumentController;
use App\Http\Controllers\Encadrant\TacheController as EncadrantTacheController;
use App\Http\Controllers\Encadrant\EvaluationController as EncadrantEvaluationController;
use App\Http\Controllers\Encadrant\StageController as EncadrantStageController;


Route::middleware(['auth', 'role:Encadrant'])->prefix('encadrant')->name('encadrant.')->group(function () {
    
    Route::get('/documents', [EncadrantDocumentController::class, 'index'])->name('documents.index');
    Route::patch('/documents/{id}/status', [EncadrantDocumentController::class, 'updateStatus'])->name('documents.updateStatus');
    Route::delete('/documents/{id}', [EncadrantDocumentController::class, 'destroy'])->name('documents.destroy');

    Route::get('/taches', [EncadrantTacheController::class, 'index'])->name('taches.index');
    Route::post('/taches', [EncadrantTacheController::class, 'store'])->name('taches.store');
    Route::put('/taches/{id}', [EncadrantTacheController::class, 'update'])->name('taches.update');
    Route::delete('/taches/{id}', [EncadrantTacheController::class, 'destroy'])->name('taches.destroy');

    Route::get('/evaluations', [EncadrantEvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('/evaluations', [EncadrantEvaluationController::class, 'store'])->name('evaluations.store');
    Route::put('/evaluations/{id}', [EncadrantEvaluationController::class, 'update'])->name('evaluations.update');

    
    Route::get('/stages', [EncadrantStageController::class, 'index'])->name('stages.index');
    Route::get('/stages/{id}', [EncadrantStageController::class, 'show'])->name('stages.show');
    Route::put('/stages/{id}', [EncadrantStageController::class, 'update'])->name('stages.update');
    Route::patch('/stages/{id}/status', [EncadrantStageController::class, 'updateStatus'])->name('stages.updateStatus');

});
