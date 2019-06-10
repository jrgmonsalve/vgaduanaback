<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Http\Resources\Expense as ExpenseResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{

    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO implement pagination
        return $this-> successful(Expense::with('category')->with('user')->get());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|max:160',
            'value' => 'required|numeric',
            'expense_date' => 'required|date',
        ]);

        $expense = new Expense();

        $expense->category_id = $request->category_id;
        $expense->description = $request->description;
        $expense->value = $request->value;
        $expense->user_id = Auth::user()->id;
        $expense->expense_date = $request->expense_date;

        if($expense->save()){
            return $this->successful($expense,201);
        }else{
            return $this->fail("Error al guardar el registro");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        $expense->category;
        $expense->user;
        return $this->successful($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id' => 'exists:categories,id',
            'description' => 'max:160',
            'value' => 'numeric',
            'date' => 'date',
        ]);

        $expense = Expense::findOrFail(1);

        if($expense->fill($request)){
            return $this->successful($expense,200);
        }else{
            return $this->fail("Error al actualizar el registro");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {    
        
        if($expense->delete()){
            return $this->successful($expense,200);
        }else{
            return $this->fail("Error al borrar el registro");
        }
    }
}
