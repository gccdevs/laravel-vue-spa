<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->uuid,
            'field_id'       => $this->id,
            'index'          => $this->index,
            'type'           => $this->type,
            'label'          => $this->label,
            'instruction'    => $this->instruction,
            'required'       => $this->required,
            'placeholder'    => $this->placeholder,
            'allow_markdown' => $this->allow_markdown,
            'options'        => unserialize($this->options),
            'constraint'     => unserialize($this->constraint),
            'logic'          => unserialize($this->logic),
            'upload_type'    => $this->upload_type,
            'link'           => $this->link,
        ];
    }
}
