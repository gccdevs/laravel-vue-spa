<?php

namespace App\Http\Resources;

use App\Models\FormField;
use App\Models\FormPayment;
use App\Models\User;
use App\Models\SystemFile;
use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $formPayment = FormPayment::where('form_id', $this->id)->first();
        return [
            'id'               => $this->id,
            'is_draft'         => $this->is_draft,
            'author'           => User::find($this->author_id)->toArray(),
            'form_name'        => $this->form_name,
            'form_description' => $this->form_description,
            'has_payment'      => $this->has_payment,
            'contact_person'   => $this->contact_person,
            'contact_number'    => $this->contact_number,
            'start_date'       => date('Y-m-d', strtotime( $this->start_date)),
            'start_time'       => date('H:m:s', strtotime($this->start_time)),
            'expired_date'     => date('Y-m-d', strtotime( $this->expired_date)),
            'expired_time'     => date('H:m:s', strtotime($this->expired_time)),
            'is_upload_file'   => $this->is_upload_file,
            'form_banner'      => $this->getBannerPath($this->banner_file_id),
            'banner_link'      => $this->banner_link,
            'form_fields'      => FormFieldResource::collection(FormField::where('form_id', $this->id)->orderBy('index', 'ASC')->get()),
            'payment'          => [
                'amount'       => $formPayment ? $formPayment->amount : '',
                'description'  => $formPayment ? $formPayment->description : null,
            ]
        ];
    }

    public function getBannerPath($id)
    {
        $image = SystemFile::find($id);
        if ($image) {
            return env('APP_URL') . '/storage/app/media/uploads/form-builder/' . $image->disk_name;
        }
        return null;
    }
}
