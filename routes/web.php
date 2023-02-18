<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CRMController;
use App\Http\Controllers\UniversitiesController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\StudentInfoController;






Route::group(['middleware' => 'auth'], function () {


    Route::get('/', [Admincontroller::class, 'dashboard'])->name('/');
    Route::get('/dashboard', [Admincontroller::class, 'dashboard'])->name('dashboard');

    Route::get('/cash-in', [TransactionsController::class, 'create_cash_in'])->name('cash.in');
    Route::post('/cash-in-confirm', [TransactionsController::class, 'store_cash_in'])->name('cash.in.confirm');
    Route::get('/cash-out', [TransactionsController::class, 'create_cash_out'])->name('cash.out');
    Route::post('/cash-out-confirm', [TransactionsController::class, 'store_cash_out'])->name('cash.out.confirm');
    Route::get('/transaction-history', [TransactionsController::class, 'index'])->name('transactions.history');
    Route::get('/transaction-history-data', [TransactionsController::class, 'transactions_data'])->name('all.transactions.data');
    Route::post('/admin/update-print-cost', [SettingsController::class, 'store'])->name('update.print.cost');




    Route::group(['middleware' => 'adminAuth'], function () {
    
        //Begin::Admin  CRM
        Route::get('/admin/all-crm', [CRMController::class, 'index'])->name('admin.crm');
        Route::post('/admin/create-crm', [CRMController::class, 'store'])->name('admin.create.crm');
        Route::get('/admin/edit-crm/{id}', [CRMController::class, 'edit']);
        Route::post('/admin/update-crm/{id}', [CRMController::class, 'update']);
        Route::get('/admin/deactive-crm/{id}', [CRMController::class, 'DeactiveCRM']);
        Route::get('/admin/active-crm/{id}', [CRMController::class, 'ActiveCRM']);
        //End::Admin  CRM

        //institute Start
        Route::group(['prefix'=>'institute', 'as'=>'institute.'], function() {
            Route::get('/all-institute', [UniversitiesController::class, 'index'])->name('index');
            Route::post('/store', [UniversitiesController::class, 'store'])->name('store');
            Route::get('/edit-institute/{id}', [UniversitiesController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [UniversitiesController::class, 'update'])->name('update');
        });
        //institute End

        //subject Start
        Route::group(['prefix'=>'subject', 'as'=>'subject.'], function() {
            Route::get('/all-subject', [SubjectsController::class, 'index'])->name('index');
            Route::post('/store', [SubjectsController::class, 'store'])->name('store');
            Route::get('/edit-subject/{id}', [SubjectsController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [SubjectsController::class, 'update'])->name('update');
        });
        //subject End

    
    });


    //visitor Start
    Route::group(['prefix'=>'visitor', 'as'=>'visitor.'], function() {
        Route::get('/register-student', [StudentInfoController::class, 'create'])->name('create');
        Route::get('/all-student', [StudentInfoController::class, 'index'])->name('index');
        Route::get('/all-student_data', [StudentInfoController::class, 'index_data'])->name('index.data');
        
        Route::post('/store', [StudentInfoController::class, 'store'])->name('store');
        Route::get('/edit-student/{id}', [StudentInfoController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StudentInfoController::class, 'update'])->name('update');
    });
    //subject End


    

    
    
    

    
});
