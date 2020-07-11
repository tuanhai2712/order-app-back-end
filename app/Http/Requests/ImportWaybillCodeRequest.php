<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Excel;
use App\Imports\ImportWaybillCode;
use Validator;

class ImportWaybillCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function makeRules()
    {
      return [
        'waybill_code' => 'required',
        'mass' => 'required|numeric',
      ];
    }

    public function messages()
    {
      return [
          'waybill_code.required' => "Mã vận đơn không được để trống",
          'mass.required' => "Khối lượng không được để trống",
          'mass.numeric' => "Khối lượng phải là số",
      ];
    }

    public function validateFileImport()
    {
      $file = Excel::toArray(new ImportWaybillCode(), Request::file('file'));
      $data = $file[0];
      if (!$this->checkFileFormat($file[0][0])) {
        return [
            'code'      => 422,
            'success'   => false,
            'message'   => '',
            'data'      => null,
            'error'     => [
                'file_format' => 'File không đúng định dạng',
            ],
        ];
      }
      for ($i=1; $i < count($data); $i++) {
        $row = [
            'waybill_code' => $data[$i][0],
            'mass' => $data[$i][1],
        ];
        $validator = Validator::make($row, $this->makeRules(), $this->messages());
        if ($validator->fails()) {
            $keys       = $validator->errors()->keys();
            $messages   = $validator->errors()->getMessages();
            $errors     = null;
            foreach ($keys as $key) {
                $rowError = $i + 1;
                $errors = "Dòng ".$rowError.": ".$messages[$key][0];
            }
            return [
                'code'      => 422,
                'success'   => false,
                'message'   => '',
                'data'      => null,
                'error'     => $errors,
            ];
        }
      }
      return [
          'code'      => 200,
          'success'   => true,
          'message'   => '',
          'data' => $data,
          'errors' => null
      ];
    }

    private function checkFileFormat($fileFormat)
    {
      $formatTemplate = [
        'MÃ VẬN ĐƠN KHÁCH HÀNG',
        'SỐ KG',
      ];
      return $formatTemplate === $fileFormat;
    }
}
