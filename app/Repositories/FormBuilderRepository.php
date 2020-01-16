<?php

namespace App\Repositories;

use App\Models\FormPayment;
use App\Models\FormField;
use App\Models\Form;
use App\Models\SystemFile;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class FormBuilderRepository extends BaseRepository
{

    public function getFormModel()
    {
        return new Form;
    }

    public function getFormFieldModel()
    {
        return new FormField();
    }

    public function getFormPaymentModel()
    {
        return new FormPayment();
    }

    public function getSystemFileModel()
    {
        return new SystemFile();
    }

    /**
     * Create and save new form data
     * @param $formData
     * @return Form
     * @throws \Exception
     */
    public function createNewForm($formData)
    {
        try{
            DB::beginTransaction();

            $banner = array_get($formData, 'form_banner', '');

            unset($formData['form_banner']);
            $newForm = $this->saveFormDetail($formData);

//            $newForm->is_upload_file = array_get($formData, 'is_upload_file', false);
//
//            if ($newForm->is_upload_file) {
//                if (array_get($formData, 'form_banner_name', '') && $banner) {
//                    $image = $this->saveFormBanner($newForm, $banner, array_get($formData, 'form_banner_name', ''));
//                    $newForm->banner_file_id = $image->id;
//                }
//            } else {
//                $newForm->banner_link = array_get($formData, 'banner_link', '');
//            }

            if ($newForm->hasPayment()) {
                $this->saveFormPaymentDetail($newForm, array_get($formData, 'payment', []));
            }

            $this->saveFormFieldDetail($newForm, array_get($formData, 'form_fields', []));

            $newForm->save();

            DB::commit();

            return $newForm;

        }catch(\Exception $e){
            DB::rollback();

            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('FormRepo', 'Failed to create form', $e->getMessage());
            }

            throw new \Exception('Error.' . $e->getMessage());
        }
    }

    /**
     * @param $form
     * @param $banner
     * @param $filename
     * @return SystemFile
     * @throws \Exception
     */
    public function saveFormBanner($form, $banner, $filename)
    {
        $diskname = Uuid::uuid1();
        $fileExt = explode('.', $filename)[1];
        $storageName = $diskname . '.' . $fileExt;
        $output = $this->base64ToImage($banner, storage_path() . '/app/media/uploads/form-builder/' . $storageName);

        if ($output) {
            $newSystemFile = $this->getSystemFileModel();
            $newSystemFile->disk_name = $storageName;
            $newSystemFile->file_name = $filename;
            $newSystemFile->file_type = $fileExt;
//            $newSystemFile->file_size = Storage::size(storage_path() . '/app/public/uploads/form-builder/' . $storageName);
            $newSystemFile->attachment_type = get_class($form);
            $newSystemFile->attachment_id = $form->id;
            $newSystemFile->save();
            return $newSystemFile;
        }
    }

    /**
     * Convert base64 to image
     * @param $base64String
     * @param $outputFile
     * @return mixed
     * @throws \Exception
     */
    function base64ToImage($base64String, $outputFile) {
        try {
            $ifp = fopen($outputFile, 'wb');

            $data = explode(',', $base64String);

            fwrite($ifp, base64_decode(end($data)));

            fclose($ifp);

            return $outputFile;
        } catch (\Exception $e) {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('FormRepo', 'Image failed to save to: ', $outputFile);
            }
            throw new \Exception('Failed to save image to: ' . $outputFile);
        }
    }

    /**
     * @param $formData
     * @return Form
     */
    public function saveFormDetail($formData)
    {
        $form = $this->getFormModel();
        $pickedData = array_only($formData, [
            'contact_person',
            'contact_number',
            'start_date',
            'expired_date',
            'expired_time',
            'start_time',
            'has_payment',
            'form_name',
            'form_description',
            'is_draft',
            'banner_link',
        ]);
        $form->fill($pickedData);
        $form->author_id = auth()->user()->id;
        $form->save();
        return $form;
    }

    public function saveFormPaymentDetail($form, $formData)
    {
        $newFormPayment = $this->getFormPaymentModel();

        $newFormPayment->form_id = $form->id;
        $newFormPayment->amount = array_get($formData, 'amount', 0);
        $newFormPayment->description = array_get($formData, 'description', null);
        $newFormPayment->coupon = serialize(array_get($formData, 'coupon', null));
        $newFormPayment->save();
        return $newFormPayment;
    }

    /**
     * @param $form
     * @param $formFields
     */
    public function saveFormFieldDetail($form, $formFields)
    {
        $index = 0;
        foreach ($formFields as $formField) {

            $newFormField = $this->createFormField($form, $formField, $index);

            $index += 1;
        }

    }

    /**
     * @param $form
     * @param $formField
     * @param $index
     * @return FormField
     */
    protected function createFormField($form, $formField, $index)
    {
        $newFormField = $this->getFormFieldModel();

        $newFormField->uuid = array_get($formField, 'id', Uuid::uuid4());

        $pickedData = array_only($formField, [
            'type',
            'required',
            'label',
            'instruction',
            'placeholder',
            'multiple',
            'link',
            'allow_markdown',
            'upload_type',
        ]);
        $newFormField->fill($pickedData);

        if (array_get($formField, 'options', []) && count(array_get($formField, 'options', [])) > 0 ) {
            $newFormField->options = serialize(array_get($formField, 'options', []));
        }
        if (array_get($formField, 'logic', []) &&  count(array_get($formField, 'logic', [])) > 0 ) {
            $newFormField->logic = serialize(array_get($formField, 'logic', []));
        }
        if (array_get($formField, 'constraint', []) && count(array_get($formField, 'constraint', [])) > 0 ) {
            $newFormField->constraint = serialize(array_get($formField, 'constraint', []));
        }

        $newFormField->form_id = $form->id;
        $newFormField->index = $index;

        $newFormField->save();

        return $newFormField;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function updateForm($id, $data)
    {
        try {
            DB::beginTransaction();

            $form = Form::find($id);
            $this->updateFormDetail($form, $data);
            $this->updateFormPayment($form, array_get($data, 'payment', []));
            $this->updateFormFields($form, array_get($data, 'form_fields', []));
            $form->save();

            DB::commit();

            return $form;

        } catch (\Exception $e) {

            DB::rollBack();

            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('FormRepo', 'Cannot update the form: ' . $id . '\n' . $e->getMessage());
            }
            throw new \Exception('Cannot update the form: ' . $id . '\n' . $e->getMessage());
        }
    }

    protected function updateFormDetail($form, $data)
    {
        $pickedData = array_only($data, [
            'contact_person',
            'contact_number',
            'start_date',
            'expired_date',
            'expired_time',
            'start_time',
            'has_payment',
            'form_name',
            'form_description',
            'is_draft',
            'banner_link'
        ]);
        $form->update($pickedData);
        $form->last_modify_user_id = auth()->user()->id;
        $form->save();

        return $form;
    }

    /**
     * @param $form
     * @param $data
     */
    protected function updateFormPayment($form, $data)
    {
        if ($form->has_payment) {
            // update existing form payment
            if ($payment = FormPayment::where('form_id', $form->id)->first()) {
                $payment->update([
                    'amount'      => array_get($data, 'amount', 0),
                    'description' => array_get($data, 'description', null),
                    'coupon'      => serialize(array_get($data, 'coupon', [])),
                ]);
                $payment->save();
            } else { // or create a new form payment
                $this->saveFormPaymentDetail($form, $data);
            }
        } else {
            if ($payment = FormPayment::where('form_id', $form->id)->first()) {
                $payment->delete();
            }
        }
    }

    protected function updateFormFields($form, $data)
    {
        $formFields = $form->formFields;

        $index = 0;
        foreach ($data as $field) {

            foreach ($formFields as $key => $formField) { // check if the field already exist
                if (array_get($field, 'id') == $formField->uuid) {
                    $this->updateExistingFormField($formField, $field, $index);
                    unset($data[$index]);
                    break;
                }
            }
            $newField = $this->createFormField($form, $field, $index); // create a new field
            $index += 1;
        }

        // delete not exists form fields
        foreach ($formFields as $formField) {
            $formField->delete();
        }
    }

    /**
     * @param $formField
     * @param $field
     * @param $index
     * @return mixed
     */
    protected function updateExistingFormField($formField, $field, $index)
    {
        $formField->index = $index;

        $pickedData = array_only($field, [
            'required',
            'label',
            'instruction',
            'placeholder',
            'multiple',
            'link',
            'allow_markdown',
            'upload_type',
        ]);
        $formField->update($pickedData);

        if (array_get($field, 'options', []) && count(array_get($field, 'options', [])) > 0 ) {
            $formField->options = serialize(array_get($field, 'options', []));
        }
        if (array_get($field, 'logic', []) && count(array_get($field, 'logic', [])) > 0 ) {
            $formField->logic = serialize(array_get($field, 'logic', []));
        }
        if (array_get($field, 'constraint', []) &&  count(array_get($field, 'constraint', [])) > 0 ) {
            $formField->constraint = serialize(array_get($field, 'constraint', []));
        }

        $formField->save();
        return $formField;
    }
}
