<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Jobs\sendFormCreationJob;
use App\Models\Form;
use App\Models\FormField;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::with('fields')->latest()->paginate(3);

        return view('form.index', compact('forms'));
    }

    public function createForm()
    {
        return view('form.create');
    }

    public function storeForm(StoreFormRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $tableName = strtolower(str_replace(' ', '_', $validatedData['name']));

            if (! Schema::hasTable($tableName)) {
                Schema::create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->timestamps();
                });
            }

            $form = Form::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            // Insert form field data into the dynamically created table
            foreach ($validatedData['fields'] as $fieldData) {
                if (isset($fieldData['options']) && is_array($fieldData['options'])) {
                    $fieldData['options'] = json_encode(explode(',', $fieldData['options'][0]));
                }
                $columnName = strtolower(str_replace(' ', '_', $fieldData['name']));
                $fieldData['name'] = $columnName;
                // Create the form field
                $formField = $form->fields()->create($fieldData);

                // Add a varchar column for each form field
                Schema::table($tableName, function (Blueprint $table) use ($columnName) {
                    $table->string($columnName)->nullable();
                });
            }

            // Update the form's table_name attribute
            $form->table_name = $tableName;
            $form->save();

            // Dispatch the job
            dispatch(new sendFormCreationJob($form))->onConnection('database');

            return redirect()->route('forms.index')->with('success', 'Form created successfully.');
        } catch (QueryException $e) {
            Log::error('Error creating form: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the form. Please try again later.');
        }
    }

    public function editForm(Form $form)
    {
        return view('form.edit', compact('form'));
    }

    public function updateForm(UpdateFormRequest $request, $id)
    {

        $validatedData = $request->validated();

        try {
            $form = Form::findOrFail($id);

            // Define the table name using the form's updated name
            $tableName = strtolower(str_replace(' ', '_', $validatedData['name']));

            // If the table name has changed, rename the table
            if ($form->table_name !== $tableName) {
                Schema::rename($form->table_name, $tableName);
                $form->table_name = $tableName;
                $form->save();
            }
            $form->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);
            // Collect the IDs of fields to be deleted
            $fieldIdsToDelete = collect($form->fields()->pluck('id'))->diff(collect($validatedData['fields'])->pluck('id'));

            // Delete fields marked for deletion
            FormField::whereIn('id', $fieldIdsToDelete)->delete();

            foreach ($validatedData['fields'] as $fieldData) {
                if (isset($fieldData['id'])) {
                    // If the field has an ID, it already exists in the database, so update it
                    $field = FormField::findOrFail($fieldData['id']);
                } else {
                    // If the field does not have an ID, it's a new field, so create it
                    $field = new FormField();
                    $field->form_id = $id; // Assuming you have a foreign key to relate fields to forms
                }
                if (isset($fieldData['options']) && is_array($fieldData['options'])) {
                    $options = json_encode(explode(',', $fieldData['options'][0]));
                }

                //$options = $fieldData['options'] ?? [];

                // If the field type is not 'select', set options to an array with a single empty string
                if ($fieldData['type'] !== 'select') {
                    $options = json_encode(['']); // Array with a single empty string
                }

                // Check if the field name has changed, if so, rename the column
                $columnName = strtolower(str_replace(' ', '_', $fieldData['name']));

                $field->fill([
                    'label' => $fieldData['label'],
                    'name' => $columnName,
                    'type' => $fieldData['type'],
                    'options' => $options,
                ])->save();

                // Check if the field is new, if so, add the column to the table
                if (! isset($fieldData['id'])) {
                    Schema::table($tableName, function (Blueprint $table) use ($columnName) {
                        $table->string($columnName)->nullable();
                    });
                }
            }

            return redirect()->route('forms.index')->with('success', 'Form updated successfully.');
        } catch (QueryException $e) {
            Log::error('Error updating form: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while update the form. Please check with input.');
        }
    }

    public function destroyForm(Request $request, Form $form)
    {
        try {
            $form->fields()->delete();
            $tableName = $form->table_name;
            Schema::dropIfExists($tableName);
            $form->delete();

            return redirect()->route('forms.index')->with('success', 'Form deleted successfully.');
        } catch (QueryException $e) {
            Log::error('Error deleting form: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting the form.');
        }
    }

    public function listSubmissions(Form $form)
    {
        $submissions = DB::table($form->table_name)->latest()->get();
        //dd($submissions);
        $form->loadMissing('fields');

        return view('submission.list', compact('submissions', 'form'));

    }
}
